<?php
/**
 * Class responsible for managing access control for people over 18 years old.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LAE_Compliance_Age_Gate {

    public function __construct() {
        add_action( 'wp_footer', array( $this, 'render_modal' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
    }

    /**
     * Load the JavaScript and CSS color variables.
     */
    public function enqueue_assets() {
        $options = get_option( 'lae_compliance_options', array() );
        
        if ( empty( $options['enable_age_gate'] ) ) {
            return;
        }

        wp_enqueue_script(
            'lae-compliance-js',
            LAE_COMPLIANCE_URL . 'assets/js/lae-compliance.js',
            array(),
            LAE_COMPLIANCE_VERSION,
            true // true = Load in the footer to avoid slowing down the website
        );
        
        // Ensure the main plugin stylesheet is loaded before adding inline CSS.
        wp_enqueue_style(
            'lae-compliance-style',
            LAE_COMPLIANCE_URL . 'assets/css/lae-compliance.css',
            array(),
            LAE_COMPLIANCE_VERSION
        );

        $popup_bg = ! empty( $options['age_gate_bg_color'] ) ? esc_attr( $options['age_gate_bg_color'] ) : '#ffffff';

        // Filter so that the child theme can overwrite the background color
        $popup_bg = apply_filters( 'lae_age_gate_bg_color', $popup_bg );

        /*
        On the child theme its necesary to write
        
        add_filter( 'lae_age_gate_bg_color', function() { return '#color'; } );
        
        on functions.php this will put the color of child theme on the age-gate
        */

        $custom_css = "
            :root {
                --lae-age-gate-bg: {$popup_bg};
            }
        ";

        wp_register_style( 'lae-age-gate-dynamic-style', false );
        wp_enqueue_style( 'lae-age-gate-dynamic-style' );
        wp_add_inline_style( 'lae-age-gate-dynamic-style', $custom_css );
    }

    /**
     * Print the modal's HTML by calling its template.
     */
    public function render_modal() {
        // COMPATIBILITY SHIELDS for Woocommerce compatibility (Phase 3)
        
        // Avoid administration panel
        if ( is_admin() ) { return; }
        
        // Avoid breaking AJAX requests from WooCommerce and Lotto plugins
        if ( wp_doing_ajax() ) { return; }
        
        // Avoid breaking the REST API
        if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) { return; }
        
        // Avoid blocking scheduled tasks (CRON)
        if ( wp_doing_cron() ) { return; }
        
        // Avoid injecting into pure WooCommerce endpoints or the checkout page
        if ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url() ) { return; }
        if ( function_exists( 'is_checkout' ) && is_checkout() ) { return; }

        $options = get_option( 'lae_compliance_options', array() );
        
        // Check if the administrator has checked the "Activate Age Gate" box.
        if ( empty( $options['enable_age_gate'] ) ) {
            return;
        }

        $template_path = LAE_COMPLIANCE_PATH . 'templates/age-gate.php';
        
        if ( file_exists( $template_path ) ) {
            include $template_path;
        } else {
            echo '';
        }
    }
}

// We instantiate the class so that the hooks start listening
new LAE_Compliance_Age_Gate();