<?php
/**
 * Class to manage the plugin settings in the WordPress admin.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LAE_Compliance_Settings {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
    }

    public function add_settings_page() {
        add_options_page(
            'Cumplimiento LAE',
            'Cumplimiento LAE',
            'manage_options',
            'lae-compliance',
            array( $this, 'render_settings_page' )
        );
    }

    public function register_settings() {
        register_setting(
            'lae_compliance_group',
            'lae_compliance_options',
            array( $this, 'sanitize_options' )
        );

        // Administration Data
        add_settings_section(
            'lae_section_admin',
            'Datos de la Administración',
            array( $this, 'render_admin_section' ),
            'lae-compliance'
        );

        $admin_fields = array(
            'admin_name'   => 'Nombre de la administración',
            'admin_number' => 'Número de administración LAE',
            'holder_name'  => 'Nombre del titular / responsable',
            'holder_nif'   => 'NIF del titular',
            'address'      => 'Dirección física',
        );

        foreach ( $admin_fields as $id => $label ) {
            add_settings_field(
                $id,
                $label,
                array( $this, 'render_input_field' ),
                'lae-compliance',
                'lae_section_admin',
                array( 'id' => $id )
            );
        }

        // Age Gate Settings
        add_settings_section(
            'lae_section_age_gate',
            'Configuración Age Gate (Popup +18)',
            array( $this, 'render_age_gate_section' ),
            'lae-compliance'
        );

        add_settings_field(
            'enable_age_gate',
            'Activar Age Gate',
            array( $this, 'render_toggle_field' ),
            'lae-compliance',
            'lae_section_age_gate',
            array( 'id' => 'enable_age_gate' )
        );

        add_settings_field(
            'age_gate_title_color',
            'Color del título',
            array( $this, 'render_color_field' ),
            'lae-compliance',
            'lae_section_age_gate',
            array(
                'id'      => 'age_gate_title_color',
                'default' => '#1e73be',
            )
        );

        add_settings_field(
            'age_gate_button_bg_color',
            'Color de fondo botón principal',
            array( $this, 'render_color_field' ),
            'lae-compliance',
            'lae_section_age_gate',
            array(
                'id'      => 'age_gate_button_bg_color',
                'default' => '#000000',
            )
        );

        add_settings_field(
            'age_gate_button_text_color',
            'Color de texto botón principal',
            array( $this, 'render_color_field' ),
            'lae-compliance',
            'lae_section_age_gate',
            array(
                'id'      => 'age_gate_button_text_color',
                'default' => '#ffffff',
            )
        );

        add_settings_field(
            'reset_age_gate_defaults',
            'Restaurar Age Gate por defecto',
            array( $this, 'render_toggle_field' ),
            'lae-compliance',
            'lae_section_age_gate',
            array(
                'id' => 'reset_age_gate_defaults',
            )
        );

        // Footer Bar Settings
        add_settings_section(
            'lae_section_footer',
            'Configuración del Footer Compliance',
            array( $this, 'render_footer_section' ),
            'lae-compliance'
        );

        add_settings_field(
            'enable_footer',
            'Activar Footer Bar',
            array( $this, 'render_toggle_field' ),
            'lae-compliance',
            'lae_section_footer',
            array( 'id' => 'enable_footer' )
        );

        add_settings_field(
            'footer_bg_color',
            'Color de fondo',
            array( $this, 'render_color_field' ),
            'lae-compliance',
            'lae_section_footer',
            array(
                'id'      => 'footer_bg_color',
                'default' => '#000000',
            )
        );

        add_settings_field(
            'footer_text_color',
            'Color de texto',
            array( $this, 'render_color_field' ),
            'lae-compliance',
            'lae_section_footer',
            array(
                'id'      => 'footer_text_color',
                'default' => '#ffffff',
            )
        );

        add_settings_field(
            'footer_hover_color',
            'Color de enlaces (Hover)',
            array( $this, 'render_color_field' ),
            'lae-compliance',
            'lae_section_footer',
            array(
                'id'      => 'footer_hover_color',
                'default' => '#1e73be',
            )
        );

        add_settings_field(
            'footer_show_on',
            'Mostrar en',
            array( $this, 'render_select_field' ),
            'lae-compliance',
            'lae_section_footer',
            array(
                'id' => 'footer_show_on',
                'options' => array(
                    'all'  => 'Toda la web',
                    'shop' => 'Solo páginas de tienda (WooCommerce)',
                    'home' => 'Solo en la página de inicio',
                ),
            )
        );

        add_settings_field(
            'reset_footer_defaults',
            'Restaurar Footer por defecto',
            array( $this, 'render_toggle_field' ),
            'lae-compliance',
            'lae_section_footer',
            array(
                'id' => 'reset_footer_defaults',
            )
        );
    }

    public function sanitize_options( $input ) {
        $output = is_array( $input ) ? $input : array();

        // Normalizar checkboxes para evitar avisos
        $output['enable_age_gate']          = ! empty( $output['enable_age_gate'] ) ? 1 : 0;
        $output['enable_footer']            = ! empty( $output['enable_footer'] ) ? 1 : 0;
        $output['reset_age_gate_defaults']  = ! empty( $output['reset_age_gate_defaults'] ) ? 1 : 0;
        $output['reset_footer_defaults']    = ! empty( $output['reset_footer_defaults'] ) ? 1 : 0;

        // Sanitizar textos
        $output['admin_name']   = isset( $output['admin_name'] ) ? sanitize_text_field( $output['admin_name'] ) : '';
        $output['admin_number'] = isset( $output['admin_number'] ) ? sanitize_text_field( $output['admin_number'] ) : '';
        $output['holder_name']  = isset( $output['holder_name'] ) ? sanitize_text_field( $output['holder_name'] ) : '';
        $output['holder_nif']   = isset( $output['holder_nif'] ) ? sanitize_text_field( $output['holder_nif'] ) : '';
        $output['address']      = isset( $output['address'] ) ? sanitize_text_field( $output['address'] ) : '';

        // Sanitizar selects
        $allowed_show_on   = array( 'all', 'shop', 'home' );

        $output['footer_show_on'] = ( isset( $output['footer_show_on'] ) && in_array( $output['footer_show_on'], $allowed_show_on, true ) )
            ? $output['footer_show_on']
            : 'all';

        // Sanitizar colores
        $output['age_gate_title_color']       = $this->sanitize_hex_color_or_default( $output['age_gate_title_color'] ?? '', '#1e73be' );
        $output['age_gate_button_bg_color']   = $this->sanitize_hex_color_or_default( $output['age_gate_button_bg_color'] ?? '', '#000000' );
        $output['age_gate_button_text_color'] = $this->sanitize_hex_color_or_default( $output['age_gate_button_text_color'] ?? '', '#ffffff' );

        $output['footer_bg_color']    = $this->sanitize_hex_color_or_default( $output['footer_bg_color'] ?? '', '#000000' );
        $output['footer_text_color']  = $this->sanitize_hex_color_or_default( $output['footer_text_color'] ?? '', '#ffffff' );
        $output['footer_hover_color'] = $this->sanitize_hex_color_or_default( $output['footer_hover_color'] ?? '', '#1e73be' );

        // Restaurar defaults Age Gate
        if ( ! empty( $output['reset_age_gate_defaults'] ) ) {
            $output['age_gate_title_color']       = '#1e73be';
            $output['age_gate_button_bg_color']   = '#000000';
            $output['age_gate_button_text_color'] = '#ffffff';
            $output['reset_age_gate_defaults']    = 0;
        }

        // Restaurar defaults Footer
        if ( ! empty( $output['reset_footer_defaults'] ) ) {
            $output['footer_bg_color']       = '#000000';
            $output['footer_text_color']     = '#ffffff';
            $output['footer_hover_color']    = '#1e73be';
            $output['footer_show_on']        = 'all';
            $output['reset_footer_defaults'] = 0;
        }

        return $output;
    }

    private function sanitize_hex_color_or_default( $color, $default ) {
        $sanitized = sanitize_hex_color( $color );
        return $sanitized ? $sanitized : $default;
    }

    /* CALLBACKS */

    public function render_input_field( $args ) {
        $options = get_option( 'lae_compliance_options' );
        $value   = isset( $options[ $args['id'] ] ) ? esc_attr( $options[ $args['id'] ] ) : '';
        echo "<input type='text' name='lae_compliance_options[{$args['id']}]' value='{$value}' class='regular-text lae-input'>";
    }

    public function render_toggle_field( $args ) {
        $options = get_option( 'lae_compliance_options' );
        $checked = isset( $options[ $args['id'] ] ) && $options[ $args['id'] ] == 1 ? 'checked' : '';
        echo "<label class='lae-switch-label'>";
        echo "<input type='checkbox' name='lae_compliance_options[{$args['id']}]' value='1' {$checked}>";
        echo "<span>Activado</span>";
        echo "</label>";
    }

    public function render_color_field( $args ) {
        $options = get_option( 'lae_compliance_options' );
        $default = isset( $args['default'] ) ? $args['default'] : '#000000';
        $value   = isset( $options[ $args['id'] ] ) ? esc_attr( $options[ $args['id'] ] ) : $default;
        echo "<input type='color' name='lae_compliance_options[{$args['id']}]' value='{$value}' class='lae-color-field'>";
    }

    public function render_select_field( $args ) {
        $options = get_option( 'lae_compliance_options' );
        $current = isset( $options[ $args['id'] ] ) ? $options[ $args['id'] ] : '';

        echo "<select name='lae_compliance_options[{$args['id']}]' class='lae-select-field'>";
        foreach ( $args['options'] as $value => $label ) {
            echo "<option value='{$value}' " . selected( $current, $value, false ) . ">{$label}</option>";
        }
        echo "</select>";
    }

    public function render_admin_section() {
        echo '<p class="lae-section-description">Completa aquí los datos identificativos de la administración que se mostrarán en las páginas legales y bloques de cumplimiento.</p>';
    }

    public function render_age_gate_section() {
        echo '<p class="lae-section-description">Configura el popup de verificación de mayoría de edad y su apariencia visual.</p>';
    }

    public function render_footer_section() {
        echo '<p class="lae-section-description">Define cómo se mostrará la barra inferior de cumplimiento en la web.</p>';
    }

    public function render_settings_page() {
        ?>
        <div class="wrap lae-admin-page">
            <h1>Configuración de Cumplimiento LAE</h1>
            <form method="post" action="options.php" class="lae-admin-form">
                <?php
                settings_fields( 'lae_compliance_group' );
                do_settings_sections( 'lae-compliance' );
                submit_button( 'Guardar cambios' );
                ?>
            </form>
        </div>
        <?php
    }

    public function enqueue_admin_assets( $hook ) {
        if ( 'settings_page_lae-compliance' !== $hook ) {
            return;
        }

        wp_enqueue_style(
            'lae-compliance-admin-style',
            LAE_COMPLIANCE_URL . 'assets/css/lae-admin.css',
            array(),
            LAE_COMPLIANCE_VERSION
        );
    }
}

new LAE_Compliance_Settings();