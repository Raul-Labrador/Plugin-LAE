<?php
/**
 * Class to register the plugin's Gutenberg blocks.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LAE_Compliance_Blocks {

    public function __construct() {
        add_action( 'init', array( $this, 'register_gutenberg_blocks' ) );
    }

    /**
     * Register all custom blocks in the plugin.
     */
    public function register_gutenberg_blocks() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

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

// Instantiate the class so that the hook is activated
new LAE_Compliance_Blocks();