<?php
/**
 * Clase para gestionar las integraciones con el sistema existente (Fase 3)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LAE_Compliance_Integration {

    /**
     * Obtiene los datos del operador priorizando la Base de Datos (ajustes).
     * Si no existen, busca un archivo JSON de configuración.
     */
    public static function get_operator_data() {
        // 1. Intentamos leer de los ajustes del plugin (Base de datos / WP-CLI)
        $options = get_option( 'lae_compliance_options', array() );
        
        if ( ! empty( $options['admin_name'] ) && ! empty( $options['admin_nif'] ) ) {
            return $options;
        }

        // 2. Fallback: Si la BD está vacía, buscamos el archivo JSON físico
        // Por defecto buscamos en la raíz de WordPress (donde está wp-config.php)
        $json_path = ABSPATH . 'client-config.json'; 

        if ( file_exists( $json_path ) ) {
            $json_content = file_get_contents( $json_path );
            $json_data    = json_decode( $json_content, true );

            if ( json_last_error() === JSON_ERROR_NONE && ! empty( $json_data ) ) {
                // Mapeamos los datos del JSON a nuestras variables
                return array(
                    'admin_name' => isset( $json_data['nombre_administracion'] ) ? sanitize_text_field( $json_data['nombre_administracion'] ) : 'Administración no definida',
                    'admin_nif'  => isset( $json_data['nif'] ) ? sanitize_text_field( $json_data['nif'] ) : 'NIF no definido',
                );
            }
        }

        // 3. Si no hay ni BD ni JSON, devolvemos valores por defecto genéricos
        return array(
            'admin_name' => 'Administración de Loterías',
            'admin_nif'  => 'No especificado',
        );
    }
}