<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LAE_Compliance_Shortcodes {

    public function __construct() {
        // M3 & M4 Legal Pages Shortcodes
        add_shortcode( 'lae_operator_info', array( $this, 'render_operator_info' ) );
        add_shortcode( 'lae_responsible_footer', array( $this, 'render_responsible_footer' ) );
        add_shortcode( 'lae_responsible_gaming_page', array( $this, 'render_responsible_gaming_page' ) );
        add_shortcode( 'lae_autoexclusion_page', array( $this, 'render_autoexclusion_page' ) );
        add_shortcode( 'lae_returns_policy_page', array( $this, 'render_returns_policy_page' ) );

        // M5 & M6 Compliance Blocks Shortcodes
        add_shortcode( 'lae_responsible_gaming', array( $this, 'render_responsible_gaming' ) );
        add_shortcode( 'lae_age_warning', array( $this, 'render_age_warning' ) );
        add_shortcode( 'lae_phone_helpline', array( $this, 'render_phone_helpline' ) );
        add_shortcode( 'lae_exclusion_links', array( $this, 'render_exclusion_links' ) );
        add_shortcode( 'lae_probability_disclaimer', array( $this, 'render_probability_disclaimer' ) );
    }


    public function render_operator_info() {
        $options = get_option( 'lae_compliance_options', array() );

        $data = array(
            'admin_name'   => ! empty( $options['admin_name'] ) ? $options['admin_name'] : 'No especificado',
            'admin_number' => ! empty( $options['admin_number'] ) ? $options['admin_number'] : 'No especificado',
            'holder_name'  => ! empty( $options['holder_name'] ) ? $options['holder_name'] : 'No especificado',
            'holder_nif'   => ! empty( $options['holder_nif'] ) ? $options['holder_nif'] : 'No especificado',
            'address'      => ! empty( $options['address'] ) ? $options['address'] : 'No especificado',
        );

        return $this->render_template( 'operator-info', $data );
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
            'admin_name' => ! empty( $options['admin_name'] ) ? $options['admin_name'] : 'nuestra administración',
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

    public function render_returns_policy_page() {

        /**
         * Legal basis used for this page:
         * - Article 103.l of Royal Legislative Decree 1/2007 (TRLGDCU):
         *   the right of withdrawal does not apply to services related to leisure
         *   activities when the contract provides for a specific date or period of performance.
         *
         * Official source:
         * https://www.boe.es/buscar/act.php?id=BOE-A-2007-20555
         */

        $options = get_option( 'lae_compliance_options', array() );

        $data = array(
            'admin_name' => ! empty( $options['admin_name'] ) ? $options['admin_name'] : 'esta administración',
        );

        return $this->render_template( 'returns-policy-page', $data );
    }

    /* M5 & M6 */

    public function render_responsible_gaming( $atts ) {
        $atts = shortcode_atts( array(
            'size' => 'banner', // options: banner, compact
        ), $atts, 'lae_responsible_gaming' );

        $size_class = ( $atts['size'] === 'compact' ) ? 'lae-sc-compact' : 'lae-sc-banner';

        ob_start();
        ?>
        <div class="lae-shortcode-wrapper lae-sc-responsible-gaming">
            <p>
                <span class="lae-logo-18"><strong>+18</strong></span>
                Si juegas, juega con responsabilidad. El juego puede crear adicción.
            </p>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_age_warning() {
        ob_start();
        ?>
        <div class="lae-shortcode-wrapper lae-sc-age-warning">
            <div class="lae-sc-content">
                <h4>Prohibida la venta a menores</h4>
                <p>El acceso y la participación en los juegos comercializados por Loterías y Apuestas del Estado está estrictamente prohibido a los menores de 18 años.</p>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_phone_helpline() {
        ob_start();
        ?>
        <div class="lae-shortcode-wrapper lae-sc-phone">
            <a href="tel:024" class="lae-sc-phone-link">
                <span class="lae-icon">☎</span> 
                <span class="lae-text">Teléfono de ayuda:</span> 
                <span class="lae-number">024</span>
            </a>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_exclusion_links() {
        ob_start();
        ?>
        <div class="lae-shortcode-wrapper lae-block-exclusion-links">
            <p class="h3" style="text-align: center; margin-bottom: 20px; color: #111;">Recursos de Ayuda y Autoexclusión</p>
            
            <div class="lae-sc-exclusion-links">
                
                <a href="https://sede.ordenacionjuego.gob.es/es/registro-interdicciones" target="_blank" rel="noopener noreferrer" class="lae-sc-card-link">
                    <strong style="display: block; font-size: 1.1em; margin-bottom: 5px;">Registro RGIAJ</strong>
                    <span style="font-size: 0.85em; color: #666;">Solicitar autoexclusión estatal</span>
                </a>

                <a href="https://www.jugarbien.es" target="_blank" rel="noopener noreferrer" class="lae-sc-card-link">
                    <strong style="display: block; font-size: 1.1em; margin-bottom: 5px;">Jugar Bien</strong>
                    <span style="font-size: 0.85em; color: #666;">Información y prevención</span>
                </a>

                <a href="tel:024" class="lae-sc-card-link">
                    <strong style="display: block; font-size: 1.1em; margin-bottom: 5px;">☎ Teléfono 024</strong>
                    <span style="font-size: 0.85em; color: #666;">Línea de atención gratuita</span>
                </a>
                
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_probability_disclaimer() {
        // We retrieve the chosen draw or set the default value
        $sorteo = isset( $attributes['sorteo'] ) && ! empty( $attributes['sorteo'] ) ? $attributes['sorteo'] : 'Lotería Nacional';

        ob_start();
        ?>

        <div class="lae-block-probability" style="background-color: #fff9c4; border-left: 4px solid #fbc02d; padding: 15px; margin: 20px 0; font-size: 0.9em; color: #555; border-radius: 4px;">
            <p style="margin: 0;">
                <strong>Aviso sobre probabilidades:</strong> La participación en los juegos de lotería se basa en el azar. Las probabilidades de obtener premio en cada uno de los juegos comercializados por SELAE son públicas y pueden ser consultadas en los puntos de venta oficiales y en la web de Loterías y Apuestas del Estado.
            </p>
        </div>
        <?php
        return ob_get_clean();
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