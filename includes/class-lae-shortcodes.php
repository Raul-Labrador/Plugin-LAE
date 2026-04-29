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
    }

    /* M3 & M4 */

    public function render_operator_info() {
        $options = get_option( 'lae_compliance_options', array() );

        $admin_name   = $options['admin_name'] ?? '';
        $admin_number = $options['admin_number'] ?? '';
        $holder_name  = $options['holder_name'] ?? '';
        $holder_nif   = $options['holder_nif'] ?? '';
        $address      = $options['address'] ?? '';

        ob_start();
        ?>
        <div class="lae-operator-info-card">
            <ul>
                <li><strong>Administración:</strong> <?php echo esc_html( $admin_name ); ?></li>
                <li><strong>Número LAE:</strong> <?php echo esc_html( $admin_number ); ?></li>
                <li><strong>Titular:</strong> <?php echo esc_html( $holder_name ); ?></li>
                <li><strong>NIF:</strong> <?php echo esc_html( $holder_nif ); ?></li>
                <li><strong>Dirección:</strong> <?php echo esc_html( $address ); ?></li>
            </ul>
        </div>
        <?php
        return ob_get_clean();
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
        $options = get_option( 'lae_compliance_options', array() );
        $admin_name = !empty($options['admin_name']) ? $options['admin_name'] : 'nuestra administración';

        ob_start();
        ?>
        <div class="lae-legal-page lae-responsible-gaming-page">
            <h2>Juego Responsable</h2>
            <p>En <strong><?php echo esc_html( $admin_name ); ?></strong> fomentamos una participación responsable en los juegos de lotería.</p>
            <p>Los juegos de lotería son una forma de ocio y deben disfrutarse con moderación, autocontrol y solo por mayores de 18 años.</p>
            <p>Si crees que el juego está suponiendo un problema, puedes limitar tu participación o buscar ayuda especializada en los siguientes enlaces oficiales:</p>
            <div class="lae-legal-page-links">
                <a href="https://www.ordenacionjuego.es/es/juego-seguro" class="lae-badge-link" target="_blank" rel="noopener noreferrer">Juego Seguro</a>
                <a href="https://www.jugarbien.es" class="lae-badge-link" target="_blank" rel="noopener noreferrer">Jugar Bien</a>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_autoexclusion_page() {
        ob_start();
        ?>
        <div class="lae-legal-page lae-autoexclusion-page">
            <h2>Autoexclusión (RGIAJ)</h2>
            <p>Si deseas limitar tu acceso a actividades de juego, puedes solicitar la inscripción en el Registro General de Interdicciones de Acceso al Juego (RGIAJ).</p>
            <p>Este registro permite restringir tu participación en determinados servicios relacionados con el juego en todo el territorio nacional.</p>
            <div class="lae-legal-action-box">
                <a href="https://sede.ordenacionjuego.gob.es/es/registro-interdicciones" class="lae-btn-primary" target="_blank" rel="noopener noreferrer">
                    Acceder al Registro RGIAJ
                </a>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_returns_policy_page() {
        $options = get_option( 'lae_compliance_options', array() );
        $admin_name = !empty($options['admin_name']) ? $options['admin_name'] : 'esta administración';

        ob_start();
        ?>
        <div class="lae-legal-page lae-returns-policy-page">
            <h2>Política de Devoluciones</h2>
            <p>La compra de décimos y participaciones gestionada por <strong><?php echo esc_html( $admin_name ); ?></strong> está sujeta a la normativa aplicable en materia de juego del Estado Español.</p>
            <p>Una vez formalizada la compra y emitido el resguardo o décimo, <strong>no será posible ejercer el derecho de desistimiento</strong> ni proceder a la devolución del importe, al tratarse de un contrato de servicios de juego excluido del derecho de desistimiento regulado en la Ley General para la Defensa de los Consumidores y Usuarios.</p>
            <p>Se recomienda revisar cuidadosamente los datos del pedido antes de completar el proceso de compra.</p>
            <p>Para cualquier incidencia técnica relacionada con la plataforma de compra, el usuario podrá contactar con la administración a través de los canales de soporte habituales.</p>
        </div>
        <?php
        return ob_get_clean();
    }

    /* M5 & M6 */

    public function render_responsible_gaming( $atts ) {
        $atts = shortcode_atts( array(
            'size' => 'banner', // options: banner, compact
        ), $atts, 'lae_responsible_gaming' );

        $size_class = ( $atts['size'] === 'compact' ) ? 'lae-sc-compact' : 'lae-sc-banner';

        ob_start();
        ?>
        <div class="lae-shortcode-wrapper lae-sc-responsible-gaming <?php echo esc_attr( $size_class ); ?>">
            <p>
                <span class="lae-logo-18-inline"><strong>+18</strong></span>
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
            <div class="lae-sc-icon">
                <span class="lae-logo-18"><strong>+18</strong></span>
            </div>
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
        <div class="lae-shortcode-wrapper lae-sc-exclusion-links">
            <a href="https://sede.ordenacionjuego.gob.es/es/registro-interdicciones" class="lae-sc-card-link" target="_blank" rel="noopener noreferrer">
                <strong>Registro RGIAJ</strong>
                <span>Solicitar autoexclusión</span>
            </a>
            <a href="https://www.jugarbien.es" class="lae-sc-card-link" target="_blank" rel="noopener noreferrer">
                <strong>Jugar Bien</strong>
                <span>Información y prevención</span>
            </a>
        </div>
        <?php
        return ob_get_clean();
    }
}

new LAE_Compliance_Shortcodes();