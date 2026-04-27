<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LAE_Compliance_Shortcodes {

    public function __construct() {
        add_shortcode( 'lae_operator_info', array( $this, 'render_operator_info' ) );
        add_shortcode( 'lae_responsible_footer', array( $this, 'render_responsible_footer' ) );
        add_shortcode( 'lae_responsible_gaming_page', array( $this, 'render_responsible_gaming_page' ) );
        add_shortcode( 'lae_autoexclusion_page', array( $this, 'render_autoexclusion_page' ) );
        add_shortcode( 'lae_returns_policy_page', array( $this, 'render_returns_policy_page' ) );

        add_shortcode( 'lae_responsible_gaming', array( $this, 'render_responsible_gaming' ) );
        add_shortcode( 'lae_age_warning', array( $this, 'render_age_warning' ) );
        add_shortcode( 'lae_phone_helpline', array( $this, 'render_phone_helpline' ) );
        add_shortcode( 'lae_exclusion_links', array( $this, 'render_exclusion_links' ) );
    }

    public function render_operator_info() {
        $options = get_option( 'lae_compliance_options', array() );

        $admin_name   = $options['admin_name'] ?? '';
        $admin_number = $options['admin_number'] ?? '';
        $holder_name  = $options['holder_name'] ?? '';
        $holder_nif   = $options['holder_nif'] ?? '';
        $address      = $options['address'] ?? '';

        ob_start();
        ?>
        <div class="lae-operator-info">
            <p><strong>Administración:</strong> <?php echo esc_html( $admin_name ); ?></p>
            <p><strong>Número LAE:</strong> <?php echo esc_html( $admin_number ); ?></p>
            <p><strong>Titular:</strong> <?php echo esc_html( $holder_name ); ?></p>
            <p><strong>NIF:</strong> <?php echo esc_html( $holder_nif ); ?></p>
            <p><strong>Dirección:</strong> <?php echo esc_html( $address ); ?></p>
        </div>
        <?php
        return ob_get_clean();
    }

    // Replace the HTML with the footer template located in /templates
    public function render_responsible_footer() {
        ob_start();

        $template_path = LAE_COMPLIANCE_PATH . 'templates/footer-bar.php';
        if ( file_exists( $template_path ) ) {
            include $template_path;
        }

        return ob_get_clean();
    }

    public function render_responsible_gaming_page() {
        $options = get_option( 'lae_compliance_options', array() );
        $admin_name = $options['admin_name'] ?? 'esta administración';

        ob_start();
        ?>
        <div class="lae-legal-page lae-responsible-gaming-page">
            <h2>Juego responsable</h2>
            <p>En <?php echo esc_html( $admin_name ); ?> fomentamos una participación responsable en los juegos de lotería.</p>
            <p>Los juegos de lotería son una forma de ocio y deben disfrutarse con moderación, autocontrol y solo por mayores de 18 años.</p>
            <p>Si crees que el juego está suponiendo un problema, puedes limitar tu participación o buscar ayuda especializada.</p>
            <p>
                <a href="https://www.ordenacionjuego.es/es/juego-seguro" target="_blank" rel="noopener noreferrer">Juego Seguro</a>
                |
                <a href="https://www.jugarbien.es" target="_blank" rel="noopener noreferrer">Jugar Bien</a>
            </p>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_autoexclusion_page() {
        ob_start();
        ?>
        <div class="lae-legal-page lae-autoexclusion-page">
            <h2>Autoexclusión</h2>
            <p>Si deseas limitar tu acceso a actividades de juego, puedes solicitar la inscripción en el Registro General de Interdicciones de Acceso al Juego (RGIAJ).</p>
            <p>Este registro permite restringir tu participación en determinados servicios relacionados con el juego.</p>
            <p>
                <a href="https://sede.ordenacionjuego.gob.es/es/registro-interdicciones" target="_blank" rel="noopener noreferrer">
                    Acceder al RGIAJ
                </a>
            </p>
            <p>También puedes consultar recursos de ayuda y orientación en organismos oficiales especializados en juego responsable.</p>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_returns_policy_page() {
        $options = get_option( 'lae_compliance_options', array() );
        $admin_name = $options['admin_name'] ?? 'esta administración';

        ob_start();
        ?>
        <div class="lae-legal-page lae-returns-policy-page">
            <h2>Política de devoluciones</h2>
            <p>La compra de décimos y participaciones gestionada por <?php echo esc_html( $admin_name ); ?> está sujeta a la normativa aplicable en materia de juego.</p>
            <p>Una vez formalizada la compra, no será posible ejercer el derecho de desistimiento en los supuestos legalmente excluidos para este tipo de productos o servicios.</p>
            <p>Se recomienda revisar cuidadosamente los datos del pedido antes de completar el proceso de compra.</p>
            <p>Para cualquier incidencia relacionada con la gestión, custodia o entrega de décimos, el usuario podrá contactar con la administración a través de los canales habilitados.</p>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_responsible_gaming( $atts ) {
        // Leemos el atributo 'size', por defecto será 'banner'
        $atts = shortcode_atts( array(
            'size' => 'banner',
        ), $atts, 'lae_responsible_gaming' );

        $padding = ( $atts['size'] === 'compact' ) ? '10px' : '30px';
        $font_size = ( $atts['size'] === 'compact' ) ? '14px' : '18px';

        ob_start();
        ?>
        <div class="lae-shortcode-responsible-gaming" style="background: #000; color: #fff; text-align: center; border-radius: 4px; padding: <?php echo esc_attr( $padding ); ?>; margin: 20px 0;">
            <p style="margin: 0; font-size: <?php echo esc_attr( $font_size ); ?>; font-weight: bold;">
                <span style="border: 2px solid #fff; border-radius: 50%; padding: 2px 6px; margin-right: 10px;">+18</span>
                Si juegas, juega con responsabilidad. El juego puede crear adicción.
            </p>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * M6: Notice of prohibition of sale to minors
     */
    public function render_age_warning() {
        ob_start();
        ?>
        <div class="lae-shortcode-age-warning" style="border: 2px solid #d32f2f; background-color: #ffebee; color: #c62828; padding: 15px; border-radius: 6px; display: flex; align-items: center; gap: 15px; margin: 20px 0;">
            <div style="font-size: 24px; font-weight: bold; border: 2px solid #c62828; border-radius: 50%; width: 40px; height: 40px; display: flex; justify-content: center; align-items: center; flex-shrink: 0;">
                +18
            </div>
            <div>
                <h4 style="margin: 0 0 5px 0; color: #b71c1c;">Prohibida la venta a menores</h4>
                <p style="margin: 0; font-size: 0.9em;">El acceso y la participación en los juegos comercializados por Loterías y Apuestas del Estado está estrictamente prohibido a los menores de 18 años.</p>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * M6: Help phone
     */
    public function render_phone_helpline() {
        ob_start();
        ?>
        <div class="lae-shortcode-phone" style="display: inline-block; background: #eceff1; border: 1px solid #cfd8dc; padding: 10px 20px; border-radius: 6px; text-align: center; margin: 10px 0;">
            <strong style="display: block; font-size: 1.1em; color: #37474f;">☎ Teléfono de ayuda: <a href="tel:024" style="color: #1976d2; text-decoration: none;">024</a></strong>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * M6: Self-exclusion links
     */
    public function render_exclusion_links() {
        ob_start();
        ?>
        <div class="lae-shortcode-exclusion-links" style="margin: 20px 0;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                <a href="https://sede.ordenacionjuego.gob.es/es/registro-interdicciones" target="_blank" rel="noopener noreferrer" style="background: #eceff1; border: 1px solid #cfd8dc; padding: 15px; text-align: center; border-radius: 6px; text-decoration: none; color: #37474f;">
                    <strong style="display: block; font-size: 1.1em; margin-bottom: 5px;">Registro RGIAJ</strong>
                    <span style="font-size: 0.85em;">Solicitar autoexclusión</span>
                </a>
                <a href="https://www.jugarbien.es" target="_blank" rel="noopener noreferrer" style="background: #eceff1; border: 1px solid #cfd8dc; padding: 15px; text-align: center; border-radius: 6px; text-decoration: none; color: #37474f;">
                    <strong style="display: block; font-size: 1.1em; margin-bottom: 5px;">Jugar Bien</strong>
                    <span style="font-size: 0.85em;">Información y prevención</span>
                </a>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Instantiate the class so it works
new LAE_Compliance_Shortcodes();