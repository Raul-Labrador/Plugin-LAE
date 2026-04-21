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
}

// Instantiate the class so it works
new LAE_Compliance_Shortcodes();