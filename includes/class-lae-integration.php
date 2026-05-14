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
        // 1. Intentamos leer de los ajustes del plugin
        $options = get_option( 'lae_compliance_options', array() );

        if ( ! empty( $options ) ) {
            return array(
                'admin_name'   => isset( $options['admin_name'] ) ? sanitize_text_field( $options['admin_name'] ) : '',
                'admin_number' => isset( $options['admin_number'] ) ? sanitize_text_field( $options['admin_number'] ) : '',
                'holder_name'  => isset( $options['holder_name'] ) ? sanitize_text_field( $options['holder_name'] ) : '',
                'holder_nif'   => isset( $options['holder_nif'] ) ? sanitize_text_field( $options['holder_nif'] ) : '',
                'address'      => isset( $options['address'] ) ? sanitize_text_field( $options['address'] ) : '',
            );
        }

        // 2. Fallback: si la BD está vacía, buscamos el archivo JSON físico
        $json_path = ABSPATH . 'client-config.json';

        if ( file_exists( $json_path ) ) {
            $json_content = file_get_contents( $json_path );
            $json_data    = json_decode( $json_content, true );

            if ( json_last_error() === JSON_ERROR_NONE && ! empty( $json_data ) ) {
                return array(
                    'admin_name'   => isset( $json_data['nombre_administracion'] ) ? sanitize_text_field( $json_data['nombre_administracion'] ) : 'Administración no definida',
                    'admin_number' => isset( $json_data['numero_administracion'] ) ? sanitize_text_field( $json_data['numero_administracion'] ) : '',
                    'holder_name'  => isset( $json_data['titular'] ) ? sanitize_text_field( $json_data['titular'] ) : '',
                    'holder_nif'   => isset( $json_data['nif'] ) ? sanitize_text_field( $json_data['nif'] ) : '',
                    'address'      => isset( $json_data['direccion'] ) ? sanitize_text_field( $json_data['direccion'] ) : '',
                );
            }
        }

        // 3. Valores por defecto
        return array(
            'admin_name'   => 'Administración de Loterías',
            'admin_number' => '',
            'holder_name'  => '',
            'holder_nif'   => '',
            'address'      => '',
        );
    }
}