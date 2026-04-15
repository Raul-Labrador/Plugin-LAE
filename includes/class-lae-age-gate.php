<?php
/**
 * Clase encargada de gestionar el control de acceso para mayores de 18 años.
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
     * Carga el JavaScript y las variables CSS de color.
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
            true // true = cargar en el footer para no ralentizar la web
        );

        $color = ! empty( $options['age_gate_color'] ) ? esc_attr( $options['age_gate_color'] ) : '#000000';
        
        $custom_css = "
            :root {
                --lae-primary-color: {$color};
            }
        ";

        wp_register_style( 'lae-age-gate-dynamic-style', false );
        wp_enqueue_style( 'lae-age-gate-dynamic-style' );
        wp_add_inline_style( 'lae-age-gate-dynamic-style', $custom_css );
    }

    /**
     * Imprime el HTML del modal llamando a su plantilla.
     */
    public function render_modal() {
        if ( is_admin() ) {
            return;
        }

        $options = get_option( 'lae_compliance_options', array() );
        
        // Comprobamos si el administrador ha marcado el check de "Activar Age Gate"
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

// Instanciamos la clase para que los hooks empiecen a escuchar
new LAE_Compliance_Age_Gate();