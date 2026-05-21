<?php
/**
 * Plugin Name: Lotto LAE Compliance
 * Description: Adaptación legal para administraciones de lotería (DGOJ, SELAE, Juego Responsable).
 * Version:     0.1.1
 * Author:      Raúl Labrador Pérez & Juan Manuel Mesa
 * Text Domain: lotto-lae-compliance
 * Domain Path: /languages
 */

// If anyone tries to access the file directly, block it.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define constants
define( 'LAE_COMPLIANCE_VERSION', '0.1.0' );
define( 'LAE_COMPLIANCE_PATH', plugin_dir_path( __FILE__ ) );
define( 'LAE_COMPLIANCE_URL', plugin_dir_url( __FILE__ ) );

/**
 * Load plugin translations.
 */
function lae_compliance_load_textdomain() {
    load_plugin_textdomain(
        'lotto-lae-compliance',
        false,
        dirname( plugin_basename( __FILE__ ) ) . '/languages'
    );
}

/**
 * Function to load all plugin components
 */
function lae_compliance_init() {
    require_once LAE_COMPLIANCE_PATH . 'includes/class-lae-age-gate.php';
    require_once LAE_COMPLIANCE_PATH . 'includes/class-lae-blocks.php';
    require_once LAE_COMPLIANCE_PATH . 'includes/class-lae-hooks.php';
    require_once LAE_COMPLIANCE_PATH . 'includes/class-lae-settings.php';
    require_once LAE_COMPLIANCE_PATH . 'includes/class-lae-shortcodes.php';
    require_once LAE_COMPLIANCE_PATH . 'includes/class-lae-woocommerce.php';
    require_once LAE_COMPLIANCE_PATH . 'includes/class-lae-integration.php';
}

add_action( 'plugins_loaded', 'lae_compliance_load_textdomain' );
add_action( 'plugins_loaded', 'lae_compliance_init' );

/**
 * ACTIVATION LOGIC
 * Runs only ONCE when the plugin is activated
 */
function lae_compliance_activate() {
    require_once LAE_COMPLIANCE_PATH . 'includes/class-lae-pages.php';

    LAE_Compliance_Pages::create_all_if_not_exist();

    flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'lae_compliance_activate' );