<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LAE_Compliance_Shortcodes {

    public function __construct() {
        add_shortcode( 'lae_operator_info', array( $this, 'render_operator_info' ) );
        add_shortcode( 'lae_responsible_footer', array( $this, 'render_responsible_footer' ) );
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
}

// Instantiate the class so it works
new LAE_Compliance_Shortcodes();