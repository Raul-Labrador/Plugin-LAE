<?php
/**
 * Clase para registrar los bloques de Gutenberg del plugin.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LAE_Compliance_Blocks {

    public function __construct() {
        add_action( 'init', array( $this, 'register_gutenberg_blocks' ) );
    }

    /**
     * Registra todos los bloques personalizados del plugin.
     */
    public function register_gutenberg_blocks() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        // Array con los nombres de las carpetas de nuestros bloques
        $blocks = array(
            'age-warning',
            'exclusion-links',
            'operator-info',
            'responsible-gaming',
        );

        foreach ( $blocks as $block_folder ) {
            $block_path = LAE_COMPLIANCE_PATH . 'blocks/' . $block_folder;
            if ( file_exists( $block_path ) ) {
                register_block_type( $block_path );
            }
        }
    }
}

// Instanciar la clase para que el hook se active
new LAE_Compliance_Blocks();