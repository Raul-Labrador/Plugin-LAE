<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LAE_Compliance_Shortcodes {

    public function __construct() {
        add_shortcode( 'lae_responsible_footer', array( $this, 'render_responsible_footer' ) );
        add_shortcode( 'lae_responsible_gaming_page', array( $this, 'render_responsible_gaming_page' ) );
        add_shortcode( 'lae_autoexclusion_page', array( $this, 'render_autoexclusion_page' ) );
        

        add_shortcode( 'lae_responsible_gaming', array( $this, 'render_responsible_gaming' ) );
        add_shortcode( 'lae_age_warning', array( $this, 'render_age_warning' ) );
        add_shortcode( 'lae_phone_helpline', array( $this, 'render_phone_helpline' ) );
        add_shortcode( 'lae_exclusion_links', array( $this, 'render_exclusion_links' ) );
        add_shortcode( 'lae_probability_disclaimer', array( $this, 'render_probability_disclaimer' ) );
    }

    public function render_responsible_footer() {
        ob_start();
        $template_path = LAE_COMPLIANCE_PATH . 'templates/footer-bar.php';
        if ( file_exists( $template_path ) ) {
            include $template_path;
        }
        return ob_get_clean();
    }

    public function render_responsible_gaming_page() {

        /**
         * Legal / official sources used for this page:
         * - DGOJ: obligation to include a direct and easily visible link to responsible gaming information.
         * - DGOJ: RGIAJ as the official self-exclusion / gambling access restriction registry.
         * - SELAE: official responsible gaming / minors protection resource.
         * - Ministry of Health: official 024 helpline resource.
         *
         * Sources:
         * https://www.ordenacionjuego.es/participantes-juego/juego-seguro/medidas-juego-seguro/medidas-informacion-proteccion-personas
         * https://www.ordenacionjuego.es/participantes-juego/juego-seguro/rgiaj
         * https://www.selae.es/es/web-corporativa/responsabilidad-social/gestion-responsable-del-juego/proteccion-a-menores
         * https://www.sanidad.gob.es/linea024/home.htm
         *
         * Note:
         * - The old "www.jugarbien.es" link appears unavailable and should not be used.
         */

        $options = get_option( 'lae_compliance_options', array() );

        $data = array(
            'admin_name' => ! empty( $options['admin_name'] ) ? $options['admin_name'] : __( 'nuestra administración', 'lotto-lae-compliance' ),
        );

        return $this->render_template( 'responsible-gaming-page', $data );
    }

    public function render_autoexclusion_page() {

        /**
         * Official sources used for this page:
         * - DGOJ: RGIAJ official information page (what it is, who it applies to, duration and cancellation after 6 months).
         * - DGOJ: RGIAJ application/registration information (electronic application and immediate effects through the e-office).
         *
         * Sources:
         * https://www.ordenacionjuego.es/participantes-juego/juego-seguro/rgiaj
         * https://www.ordenacionjuego.es/datos-estudios/actividad-historica/act-rgiaj
         */
        return $this->render_template( 'autoexclusion-page' );
    }

    public function render_responsible_gaming( $atts ) {
        $atts = shortcode_atts(
            array(
                'size' => 'medium',
            ),
            $atts,
            'lae_responsible_gaming'
        );

        $allowed_sizes = array( 'small', 'medium', 'large' );
        $size = in_array( $atts['size'], $allowed_sizes, true ) ? $atts['size'] : 'medium';

        $data = array(
            'size'       => $size,
            'size_class' => 'lae-size-' . $size,
        );

        return $this->render_template( 'responsible-gaming-block', $data );
    }

    public function render_age_warning() {
        return $this->render_template( 'age-warning-block' );
    }

    public function render_phone_helpline() {
        return $this->render_template( 'phone-helpline-block' );
    }

    public function render_exclusion_links() {
        return $this->render_template( 'exclusion-links-block' );
    }

    public function render_probability_disclaimer( $atts ) {
        $atts = shortcode_atts(
            array(
                'sorteo' => 'loteria-nacional',
            ),
            $atts,
            'lae_probability_disclaimer'
        );

        $sorteo = sanitize_title( $atts['sorteo'] );

        $messages = array(
            'loteria-nacional' => __( 'La participación en Lotería Nacional se basa en el azar. Las probabilidades de obtener premio pueden consultarse en los canales oficiales de Loterías y Apuestas del Estado.', 'lotto-lae-compliance' ),
            'euromillones'     => __( 'La participación en Euromillones se basa en el azar. Las probabilidades de obtener premio pueden consultarse en los canales oficiales de Loterías y Apuestas del Estado.', 'lotto-lae-compliance' ),
            'primitiva'        => __( 'La participación en La Primitiva se basa en el azar. Las probabilidades de obtener premio pueden consultarse en los canales oficiales de Loterías y Apuestas del Estado.', 'lotto-lae-compliance' ),
            'bonoloto'         => __( 'La participación en Bonoloto se basa en el azar. Las probabilidades de obtener premio pueden consultarse en los canales oficiales de Loterías y Apuestas del Estado.', 'lotto-lae-compliance' ),
            'quiniela'         => __( 'La participación en La Quiniela se basa en el azar. Las probabilidades de obtener premio pueden consultarse en los canales oficiales de Loterías y Apuestas del Estado.', 'lotto-lae-compliance' ),
        );

        $message = isset( $messages[ $sorteo ] )
            ? $messages[ $sorteo ]
            : __( 'La participación en los juegos de lotería se basa en el azar. Las probabilidades de obtener premio pueden consultarse en los canales oficiales de Loterías y Apuestas del Estado.', 'lotto-lae-compliance' );
                
        $data = array(
            'sorteo'  => $sorteo,
            'message' => $message,
        );

        return $this->render_template( 'probability-disclaimer-block', $data );
    }

    private function render_template( $template_name, $data = array() ) {
        $template_path = LAE_COMPLIANCE_PATH . 'templates/' . $template_name . '.php';

        if ( ! file_exists( $template_path ) ) {
            return '';
        }

        if ( ! empty( $data ) && is_array( $data ) ) {
            extract( $data, EXTR_SKIP );
        }

        ob_start();
        include $template_path;
        return ob_get_clean();
    }
}

new LAE_Compliance_Shortcodes();