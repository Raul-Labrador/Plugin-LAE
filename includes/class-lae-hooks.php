<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LAE_Compliance_Hooks {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
        add_action( 'wp_footer', array( $this, 'render_footer_bar' ) );
    }

    public function enqueue_assets() {
        wp_enqueue_style(
            'lae-compliance-style',
            LAE_COMPLIANCE_URL . 'assets/css/lae-compliance.css',
            array(),
            LAE_COMPLIANCE_VERSION
        );
    }

    public function render_footer_bar() {
        if ( is_admin() ) {
            return;
        }

        echo do_shortcode( '[lae_responsible_footer]' );
    }
}