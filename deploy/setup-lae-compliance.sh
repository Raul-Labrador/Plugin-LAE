#!/bin/bash

# Comprobar si existe el archivo JSON
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

# Instalar y activar el plugin
echo "Instalando plugin LAE Compliance..."
# Ajusta esta ruta a donde tengáis el zip en vuestro entorno de pruebas
# wp plugin install ./lotto-lae-compliance.zip --activate

# Poblar ajustes en nuestro array de opciones
echo "Configurando opciones del plugin"
# Creamos la opción base si no existe
wp option add lae_compliance_options '{"enable_age_gate":1, "footer_is_sticky":1}' --format=json

# Inyectamos los datos del JSON
wp option patch insert lae_compliance_options admin_name "$NOMBRE_COMERCIAL"
wp option patch insert lae_compliance_options admin_number "$NUMERO_ADMIN"
wp option patch insert lae_compliance_options holder_name "$TITULAR"
wp option patch insert lae_compliance_options holder_nif "$NIF"
wp option patch insert lae_compliance_options address "$DIRECCION"

# Crear páginas legales (Llamando a vuestra clase exacta)
echo "Creando páginas legales si no existen"
wp eval "LAE_Compliance_Pages::create_all_if_not_exist();"

# Asignar páginas a un menú de Footer
echo "Configurando el menú"
# Creamos el menú (si ya existe, el comando fallará pero el script seguirá gracias al || true)
wp menu create "Legal Footer" || true

# Lista de slugs que tenéis en vuestro PHP
PAGES=("juego-responsable" "autoexclusion" "politica-devoluciones-loteria" "identificacion-operador")

for SLUG in "${PAGES[@]}"; do
    # Obtenemos el ID de la página recién creada
    PAGE_ID=$(wp post list --post_type=page --name="$SLUG" --field=ID --format=ids)
    
    if [ ! -z "$PAGE_ID" ]; then
        # La añadimos al menú
        wp menu item add-post "Legal Footer" "$PAGE_ID"
        echo "   -> Página '$SLUG' añadida al menú."
    fi
done

echo "Despliegue terminado con exito"