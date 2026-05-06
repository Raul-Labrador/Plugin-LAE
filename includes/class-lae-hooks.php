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

        $options = get_option( 'lae_compliance_options', array() );

        // We retrieve the values ​​from the settings panel (or use the default ones)
        $footer_bg_option    = ! empty( $options['footer_bg_color'] ) ? esc_attr( $options['footer_bg_color'] ) : '#111111';
        $footer_text_option  = ! empty( $options['footer_text_color'] ) ? esc_attr( $options['footer_text_color'] ) : '#ffffff';
        $footer_hover_option = ! empty( $options['footer_hover_color'] ) ? esc_attr( $options['footer_hover_color'] ) : '#1e73be';
        $footer_pos          = ! empty( $options['footer_position'] ) ? esc_attr( $options['footer_position'] ) : 'fixed';

        // We pass those values ​​through filters. 
        // If the child theme doesn't say anything, the panel's settings are used. If the child theme does intervene, the child theme takes precedence.
        $footer_bg    = apply_filters( 'lae_footer_bg_color', $footer_bg_option );
        $footer_text  = apply_filters( 'lae_footer_text_color', $footer_text_option );
        $footer_hover = apply_filters( 'lae_footer_hover_color', $footer_hover_option );

        /*
        On the child theme its necesary to write

        add_filter( 'lae_footer_bg_color', function() { return '#color'; } );
        add_filter( 'lae_footer_hover_color', function() { return '#color'; } );

        on functions.php this will put the color of child theme on the footer bar.

        */

        $custom_css = "
            :root {
                --lae-footer-bg: {$footer_bg};
                --lae-footer-text: {$footer_text};
                --lae-footer-hover: {$footer_hover};
            }

            .lae-compliance-footer-bar {
                position: " . ( $footer_pos === 'static' ? 'static' : 'fixed' ) . ";
            }
        ";

        wp_add_inline_style( 'lae-compliance-style', $custom_css );
    }

    public function render_footer_bar() {
        if ( is_admin() ) { return; }
        if ( wp_doing_ajax() ) { return; }
        if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) { return; }
        if ( wp_doing_cron() ) { return; }
        if ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url() ) { return; }
        if ( function_exists( 'is_checkout' ) && is_checkout() ) { return; }

        $options = get_option( 'lae_compliance_options', array() );

        if ( empty( $options['enable_footer'] ) ) {
            return;
        }

        $show_on = ! empty( $options['footer_show_on'] ) ? $options['footer_show_on'] : 'all';

        if ( 'home' === $show_on && ! is_front_page() ) {
            return;
        }

        if ( 'shop' === $show_on ) {
            if ( ! function_exists( 'is_shop' ) || ( ! is_shop() && ! is_product() && ! is_cart() ) ) {
                return;
            }
        }

        echo do_shortcode( '[lae_responsible_footer]' );
    }
}

new LAE_Compliance_Hooks();