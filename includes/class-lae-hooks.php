<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LAE_Compliance_Hooks {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
        add_action( 'wp_footer', array( $this, 'render_footer_bar' ) );
        add_filter( 'wp_nav_menu_items', array( $this, 'add_operator_link_to_footer_menu' ), 10, 2 );
    }

    public function enqueue_assets() {
        wp_enqueue_style(
            'lae-compliance-style',
            LAE_COMPLIANCE_URL . 'assets/css/lae-compliance.css',
            array(),
            LAE_COMPLIANCE_VERSION
        );

        $options = get_option( 'lae_compliance_options', array() );

        $is_sticky = isset( $options['footer_is_sticky'] ) ? $options['footer_is_sticky'] : 1;

        $custom_css = "
            .lae-compliance-footer-bar {
                position: " . ( $is_sticky ? 'fixed' : 'static' ) . " !important;
                bottom: 0;
                width: 100%;
                z-index: 9999;
            }
        ";

        wp_add_inline_style( 'lae-compliance-style', $custom_css );
    }

    public function render_footer_bar() {
        // Escudos de compatibilidad
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

        echo do_shortcode( '[lae_responsible_footer]' );
    }

    public function add_operator_link_to_footer_menu( $items, $args ) {
        if ( empty( $args->theme_location ) || 'footer' !== $args->theme_location ) {
            return $items;
        }

        $operator_page_url = site_url( '/identificacion-operador/' );

        $items .= '<li class="menu-item menu-item-type-custom menu-item-object-custom nav-item lae-operator-menu-item">';
        $items .= '<a class="nav-link" href="' . esc_url( $operator_page_url ) . '">';
        $items .= '<span class="span-help"><i class="far fa-circle"></i> &nbsp;</span>';
        $items .= 'Identificación del operador';
        $items .= '</a>';
        $items .= '</li>';

        return $items;
    }
}

new LAE_Compliance_Hooks();