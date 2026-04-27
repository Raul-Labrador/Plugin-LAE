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
        add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_assets' ) );
    }

    public function register_gutenberg_blocks() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        $blocks = array(
            'age-warning',
            'exclusion-links',
            'operator-info',
            'responsible-gaming',
            'probability-disclaimer',
        );

        foreach ( $blocks as $block_folder ) {
            $block_path = LAE_COMPLIANCE_PATH . 'blocks/' . $block_folder;
            if ( file_exists( $block_path . '/block.json' ) ) {
                register_block_type( $block_path );
            }
        }
    }

    public function enqueue_editor_assets() {
        // We load the bridge script that tells the editor to paint the buttons
        wp_enqueue_script(
            'lae-blocks-editor',
            LAE_COMPLIANCE_URL . 'assets/js/lae-blocks-editor.js',
            array( 'wp-blocks', 'wp-element', 'wp-server-side-render' ),
            LAE_COMPLIANCE_VERSION,
            true
        );
    }
}

new LAE_Compliance_Blocks();