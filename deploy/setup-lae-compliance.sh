#!/bin/bash

# Check if the JSON file exists
if [ ! -f "cliente-config.json" ]; then
    echo "Error: No se encuentra el archivo cliente-config.json"
    exit 1
fi

echo "Leyendo datos del cliente desde JSON"
NOMBRE_COMERCIAL=$(jq -r '.admin_name' cliente-config.json)
NUMERO_ADMIN=$(jq -r '.admin_number' cliente-config.json)
TITULAR=$(jq -r '.holder_name' cliente-config.json)

# Install and activate the plugin
echo "Instalando plugin LAE Compliance..."
# Adjust this path to where you have the zip file in your test environment.

# Uncomment the following line to perform the installation
# wp plugin install ./lotto-lae-compliance.zip --activate

# Populate settings in our array of options
echo "Configurando opciones del plugin"
# We create the base option if it doesn't exist.
wp option add lae_compliance_options '{"enable_age_gate":1, "footer_is_sticky":1}' --format=json || true

# We inject only the 3 required values
wp option patch insert lae_compliance_options admin_name "$NOMBRE_COMERCIAL"
wp option patch insert lae_compliance_options admin_number "$NUMERO_ADMIN"
wp option patch insert lae_compliance_options holder_name "$TITULAR"

# Create legal pages
echo "Creando páginas legales si no existen"
wp eval "LAE_Compliance_Pages::create_all_if_not_exist();"

# Insert extra lines into Aviso legal
# We add only the 3 extra administration fields and keep the original legal text untouched.
echo "Añadiendo datos extra en Aviso legal"
export LAE_ADMIN_NAME="$NOMBRE_COMERCIAL"
export LAE_ADMIN_NUMBER="$NUMERO_ADMIN"
export LAE_HOLDER_NAME="$TITULAR"

wp eval '
$slug = "aviso-legal";
$page = get_page_by_path( $slug );

if ( ! $page ) {
    echo "No se ha encontrado la página Aviso legal\n";
    return;
}

$content = $page->post_content;

/*
 * If the extra lines already exist, do not insert them again.
 * This prevents duplicated content on repeated deployments.
 */
if (
    strpos( $content, "Nombre de la administración:" ) !== false ||
    strpos( $content, "Número de administración LAE:" ) !== false ||
    strpos( $content, "Titular / responsable:" ) !== false
) {
    echo "Aviso legal ya contiene los datos extra\n";
    return;
}

$admin_name   = trim( getenv( "LAE_ADMIN_NAME" ) );
$admin_number = trim( getenv( "LAE_ADMIN_NUMBER" ) );
$holder_name  = trim( getenv( "LAE_HOLDER_NAME" ) );

$extra = "";

/*
 * Build the extra legal lines only when values exist.
 * We do not inject empty or null values.
 */
if ( $admin_name !== "" && $admin_name !== "null" ) {
    $extra .= "Nombre de la administración: " . $admin_name . "\n\n";
}

if ( $admin_number !== "" && $admin_number !== "null" ) {
    $extra .= "Número de administración LAE: " . $admin_number . "\n\n";
}

if ( $holder_name !== "" && $holder_name !== "null" ) {
    $extra .= "Titular / responsable: " . $holder_name . "\n\n";
}

if ( $extra === "" ) {
    echo "No hay datos extra que insertar\n";
    return;
}

/*
 * Insert the new lines right before the NIF line.
 * If NIF is not found, append the extra block at the end.
 */
$pos = strpos( $content, "NIF:" );

if ( $pos !== false ) {
    $content = substr( $content, 0, $pos ) . $extra . substr( $content, $pos );
} else {
    $content .= "\n\n" . $extra;
}

wp_update_post(
    array(
        "ID"           => $page->ID,
        "post_content" => $content,
    )
);

echo "Datos extra añadidos en Aviso legal\n";
'

# Update Cancelaciones y devoluciones block in Envíos y pagos
# We replace only the returns/cancellations section and keep the rest of the page as it is.
echo "Actualizando bloque de Cancelaciones y devoluciones en Envíos y pagos"

wp eval '
$slug = "envios-y-pagos";
$page = get_page_by_path( $slug );

if ( ! $page ) {
    echo "No se ha encontrado la página Envíos y pagos\n";
    return;
}

$content = $page->post_content;

/*
 * New legal text for the returns and cancellations section.
 * This text replaces the old block only if the section is found.
 */
$new_block = <<<TEXT
Cancelaciones y devoluciones.

Antes de finalizar la compra, le recomendamos revisar cuidadosamente el sorteo seleccionado, la fecha del sorteo, el número elegido, el importe, la cantidad y cualquier otro dato relevante del pedido.

La compra de décimos, resguardos o participaciones realizada a través de esta web queda vinculada al sorteo o fecha concreta seleccionados por el usuario. Por este motivo, una vez confirmada y formalizada la compra, y siempre que el pedido haya quedado emitido, gestionado o validado para un sorteo determinado, no procederá la cancelación ni la devolución del importe, salvo en aquellos supuestos en los que resulte aplicable una obligación legal distinta o exista una incidencia técnica u operativa imputable al servicio prestado.

Si la compra queda en depósito o en recogida en la administración, la solicitud de cancelación podrá valorarse como máximo dentro de las 48 horas siguientes a la realización de la compra y siempre que el pedido no haya sido emitido, gestionado o validado definitivamente y que no se haya celebrado el sorteo al que pertenezcan los décimos adquiridos.

En caso de incidencia, error técnico en el proceso de compra o duda sobre la gestión del pedido, el usuario podrá ponerse en contacto con la administración a través de los canales habituales de atención para revisar el caso concreto.

Si procede un reembolso, este se realizará mediante el mismo método de pago utilizado en la compra, en un plazo estimado de 24 a 48 horas, sin perjuicio del tiempo adicional que pueda depender de la entidad bancaria o del proveedor de pago correspondiente.

Esta política afecta exclusivamente a la devolución o cancelación de compras ya realizadas y no limita otros derechos que puedan corresponder al usuario conforme a la normativa aplicable.
TEXT;

/*
 * If the new legal text is already present, do nothing.
 * This prevents duplicate updates on repeated runs.
 */
if ( strpos( $content, "Antes de finalizar la compra, le recomendamos revisar cuidadosamente el sorteo seleccionado" ) !== false ) {
    echo "El texto legal de devoluciones ya está actualizado\n";
    return;
}

/*
 * Locate the original returns section by its heading.
 * If it does not exist, append the new block at the end of the page.
 */
$start = strpos( $content, "Cancelaciones y devoluciones." );

if ( $start === false ) {
    $content .= "\n\n" . $new_block;

    wp_update_post(
        array(
            "ID"           => $page->ID,
            "post_content" => $content,
        )
    );

    echo "No se encontró el bloque original; se ha añadido el nuevo al final\n";
    return;
}

/*
 * Try to find the next section heading so we only replace the target block.
 * If no next heading is found, replace everything from the target block to the end.
 */
$rest = substr( $content, $start );
$next_heading_pos = false;

$possible_headings = array(
    "\n\n3.",
    "\n\nOtros",
    "\n\nCondiciones",
    "\n\nAviso",
    "\n\nInformación"
);

foreach ( $possible_headings as $heading ) {
    $pos = strpos( $rest, $heading );
    if ( $pos !== false ) {
        $next_heading_pos = $start + $pos;
        break;
    }
}

if ( $next_heading_pos !== false ) {
    $content = substr( $content, 0, $start ) . $new_block . substr( $content, $next_heading_pos );
} else {
    $content = substr( $content, 0, $start ) . $new_block;
}

wp_update_post(
    array(
        "ID"           => $page->ID,
        "post_content" => $content,
    )
);

echo "Bloque de Cancelaciones y devoluciones actualizado en Envíos y pagos\n";
'

# Assign pages to a Footer menu
echo "Configurando el menú"
# We create the menu
wp menu create "Legal Footer" || true

# List of slugs that you have in your PHP
PAGES=("juego-responsable" "autoexclusion")

for SLUG in "${PAGES[@]}"; do
    # We obtain the ID of the newly created page
    PAGE_ID=$(wp post list --post_type=page --name="$SLUG" --field=ID --format=ids)
    
    if [ ! -z "$PAGE_ID" ]; then
        # We added it to the menu
        wp menu item add-post "Legal Footer" "$PAGE_ID" || true
        echo "   -> Página '$SLUG' añadida al menú."
    fi
done

echo "Despliegue terminado con exito"