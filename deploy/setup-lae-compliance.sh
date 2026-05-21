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
NIF=$(jq -r '.holder_nif' cliente-config.json)
DIRECCION=$(jq -r '.address' cliente-config.json)

# Install and activate the plugin
echo "Instalando plugin LAE Compliance..."
# Adjust this path to where you have the zip file in your test environment.

# Uncomment the following line to perform the installation
# wp plugin install ./lotto-lae-compliance.zip --activate

# Populate settings in our array of options
echo "Configurando opciones del plugin"
# We create the base option if it doesn't exist.
wp option add lae_compliance_options '{"enable_age_gate":1, "footer_is_sticky":1}' --format=json

# We inject the JSON data
wp option patch insert lae_compliance_options admin_name "$NOMBRE_COMERCIAL"
wp option patch insert lae_compliance_options admin_number "$NUMERO_ADMIN"
wp option patch insert lae_compliance_options holder_name "$TITULAR"
wp option patch insert lae_compliance_options holder_nif "$NIF"
wp option patch insert lae_compliance_options address "$DIRECCION"

# Create legal pages
echo "Creando páginas legales si no existen"
wp eval "LAE_Compliance_Pages::create_all_if_not_exist();"

# Assign pages to a Footer menu
echo "Configurando el menú"
# We create the menu
wp menu create "Legal Footer" || true

# List of slugs that you have in your PHP
PAGES=("juego-responsable" "autoexclusion" "politica-devoluciones-loteria" "identificacion-operador")

for SLUG in "${PAGES[@]}"; do
    # We obtain the ID of the newly created page
    PAGE_ID=$(wp post list --post_type=page --name="$SLUG" --field=ID --format=ids)
    
    if [ ! -z "$PAGE_ID" ]; then
        # We added it to the menu
        wp menu item add-post "Legal Footer" "$PAGE_ID"
        echo "   -> Página '$SLUG' añadida al menú."
    fi
done

echo "Despliegue terminado con exito"