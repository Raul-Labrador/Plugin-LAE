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
        // COMPATIBILITY SHIELDS for Woocommerce compatibility (Phase 3)
        
        if ( is_admin() ) { return; }
        if ( wp_doing_ajax() ) { return; }
        if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) { return; }
        if ( wp_doing_cron() ) { return; }
        if ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url() ) { return; }
        if ( function_exists( 'is_checkout' ) && is_checkout() ) { return; } // Oculta el footer en el pago

        echo do_shortcode( '[lae_responsible_footer]' );
    }
}

// Instantiate
new LAE_Compliance_Hooks();