<?php
/**
 * Clase para gestionar las integraciones con el sistema existente (Fase 3)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LAE_Compliance_Integration {

    public static function get_operator_data() {
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

        $json_path = ABSPATH . 'client-config.json';

        if ( file_exists( $json_path ) ) {
            $json_content = file_get_contents( $json_path );
            $json_data    = json_decode( $json_content, true );

            if ( json_last_error() === JSON_ERROR_NONE && ! empty( $json_data ) ) {
                return array(
                    'admin_name'   => isset( $json_data['nombre_administracion'] ) ? sanitize_text_field( $json_data['nombre_administracion'] ) : __( 'Administración no definida', 'lotto-lae-compliance' ),                    'admin_number' => isset( $json_data['numero_administracion'] ) ? sanitize_text_field( $json_data['numero_administracion'] ) : '',
                    'holder_name'  => isset( $json_data['titular'] ) ? sanitize_text_field( $json_data['titular'] ) : '',
                    'holder_nif'   => isset( $json_data['nif'] ) ? sanitize_text_field( $json_data['nif'] ) : '',
                    'address'      => isset( $json_data['direccion'] ) ? sanitize_text_field( $json_data['direccion'] ) : '',
                );
            }
        }

        return array(
            'admin_name'   => __( 'Administración de Loterías', 'lotto-lae-compliance' ),
            'admin_number' => '',
            'holder_name'  => '',
            'holder_nif'   => '',
            'address'      => '',
        );
    }
}