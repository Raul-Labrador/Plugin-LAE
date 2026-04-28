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
        register_setting( 'lae_compliance_group', 'lae_compliance_options' );

        // Administration Data
        add_settings_section( 'lae_section_admin', 'Datos de la Administración', null, 'lae-compliance' );

        $admin_fields = array(
            'admin_name'   => 'Nombre de la administración',
            'admin_number' => 'Número de administración LAE',
            'holder_name'  => 'Nombre del titular / responsable',
            'holder_nif'   => 'NIF del titular',
            'address'      => 'Dirección física',
        );

        foreach ( $admin_fields as $id => $label ) {
            add_settings_field( $id, $label, array( $this, 'render_input_field' ), 'lae-compliance', 'lae_section_admin', array( 'id' => $id ) );
        }

        // Age Gate Settings
        add_settings_section( 'lae_section_age_gate', 'Configuración Age Gate (Popup +18)', null, 'lae-compliance' );
        add_settings_field( 'enable_age_gate', 'Activar Age Gate', array( $this, 'render_toggle_field' ), 'lae-compliance', 'lae_section_age_gate', array( 'id' => 'enable_age_gate' ) );
        add_settings_field( 'age_gate_bg_color', 'Color de fondo Popup', array( $this, 'render_color_field' ), 'lae-compliance', 'lae_section_age_gate', array( 'id' => 'age_gate_bg_color', 'default' => '#ffffff' ) );

        // Footer Bar Settings
        add_settings_section( 'lae_section_footer', 'Configuración del Footer Compliance', null, 'lae-compliance' );
        
        add_settings_field( 'enable_footer', 'Activar Footer Bar', array( $this, 'render_toggle_field' ), 'lae-compliance', 'lae_section_footer', array( 'id' => 'enable_footer' ) );
        
        add_settings_field( 'footer_position', 'Posición', array( $this, 'render_select_field' ), 'lae-compliance', 'lae_section_footer', array( 
            'id' => 'footer_position', 
            'options' => array(
                'fixed'  => 'Fijo en la parte inferior (Sticky)',
                'static' => 'Estático al final del contenido'
            )
        ) );

        add_settings_field( 'footer_bg_color', 'Color de fondo', array( $this, 'render_color_field' ), 'lae-compliance', 'lae_section_footer', array( 'id' => 'footer_bg_color', 'default' => '#111111' ) );
        add_settings_field( 'footer_text_color', 'Color de texto', array( $this, 'render_color_field' ), 'lae-compliance', 'lae_section_footer', array( 'id' => 'footer_text_color', 'default' => '#ffffff' ) );

        add_settings_field( 'footer_show_on', 'Mostrar en', array( $this, 'render_select_field' ), 'lae-compliance', 'lae_section_footer', array( 
            'id' => 'footer_show_on', 
            'options' => array(
                'all'  => 'Toda la web',
                'shop' => 'Solo páginas de tienda (WooCommerce)',
                'home' => 'Solo en la página de inicio'
            )
        ) );
    }

    /* CALLBACKS */

    public function render_input_field( $args ) {
        $options = get_option( 'lae_compliance_options' );
        $value   = isset( $options[ $args['id'] ] ) ? esc_attr( $options[ $args['id'] ] ) : '';
        echo "<input type='text' name='lae_compliance_options[{$args['id']}]' value='{$value}' class='regular-text'>";
    }

    public function render_toggle_field( $args ) {
        $options = get_option( 'lae_compliance_options' );
        $checked = isset( $options[ $args['id'] ] ) && $options[ $args['id'] ] == 1 ? 'checked' : '';
        echo "<input type='checkbox' name='lae_compliance_options[{$args['id']}]' value='1' {$checked}>";
    }

    public function render_color_field( $args ) {
        $options = get_option( 'lae_compliance_options' );
        $default = isset( $args['default'] ) ? $args['default'] : '#000000';
        $value   = isset( $options[ $args['id'] ] ) ? esc_attr( $options[ $args['id'] ] ) : $default;
        echo "<input type='color' name='lae_compliance_options[{$args['id']}]' value='{$value}'>";
    }

    public function render_select_field( $args ) {
        $options = get_option( 'lae_compliance_options' );
        $current = isset( $options[ $args['id'] ] ) ? $options[ $args['id'] ] : '';
        echo "<select name='lae_compliance_options[{$args['id']}]'>";
        foreach ( $args['options'] as $value => $label ) {
            echo "<option value='{$value}' " . selected( $current, $value, false ) . ">{$label}</option>";
        }
        echo "</select>";
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Configuración de Cumplimiento LAE</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'lae_compliance_group' );
                do_settings_sections( 'lae-compliance' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}

new LAE_Compliance_Settings();