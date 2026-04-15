<?php
/**
 * Plugin Name: Lotto LAE Compliance
 * Description: Adaptación legal para administraciones de lotería (DGOJ, SELAE, Juego Responsable).
 * Version:     0.1.0
 * Author:      Comerline
 * Text Domain: lotto-lae-compliance
 * Domain Path: /languages
 */

// Si alguien intenta entrar directamente al archivo, lo echamos.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Definimos constantes
define( 'LAE_COMPLIANCE_VERSION', '0.1.0' );
define( 'LAE_COMPLIANCE_PATH', plugin_dir_path( __FILE__ ) );
define( 'LAE_COMPLIANCE_URL', plugin_dir_url( __FILE__ ) );

/**
 * Función para cargar todas las piezas del motor
 */
function lae_compliance_init() {
    // Aquí iremos haciendo los "require" de tus clases según las vayamos programando
    require_once LAE_COMPLIANCE_PATH . 'includes/class-lae-age-gate.php';
    require_once LAE_COMPLIANCE_PATH . 'includes/class-lae-blocks.php';
    require_once LAE_COMPLIANCE_PATH . 'includes/class-lae-hooks.php';
    require_once LAE_COMPLIANCE_PATH . 'includes/class-lae-settings.php';
    require_once LAE_COMPLIANCE_PATH . 'includes/class-lae-shortcodes.php';
    
}

// Arrancamos el plugin
add_action( 'plugins_loaded', 'lae_compliance_init' );

/**
 * LÓGICA DE ACTIVACIÓN
 * Se ejecuta solo UNA VEZ cuando se activa el plugin
 */
function lae_compliance_activate() {
    require_once LAE_COMPLIANCE_PATH . 'includes/class-lae-pages.php';
    
    LAE_Compliance_Pages::create_all_if_not_exist();
    
    flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'lae_compliance_activate' );