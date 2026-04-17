<?php
/**
 * Class to manage the plugin settings in the WordPress admin.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LAE_Compliance_Settings {

    public function __construct() {
        // Add the menu item to the admin panel
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        // Register the settings
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    /**
     * Creates the entry in the Settings menu
     */
    public function add_settings_page() {
        add_options_page(
            'Cumplimiento LAE',
            'Cumplimiento LAE',
            'manage_options',
            'lae-compliance',
            array( $this, 'render_settings_page' )
        );
    }

    /**
     * Registers the fields in the database
     */
    public function register_settings() {
        register_setting( 'lae_compliance_group', 'lae_compliance_options' );

        // Section 1: Administration data
        add_settings_section( 'lae_section_admin', 'Datos de la Administración', null, 'lae-compliance' );

        $fields = array(
            'admin_name'   => 'Nombre de la administración',
            'admin_number' => 'Número de administración LAE',
            'holder_name'  => 'Nombre del titular / responsable',
            'holder_nif'   => 'NIF del titular',
            'address'      => 'Dirección física',
            'license'      => 'CNAE / Licencia (si aplica)',
        );

        foreach ( $fields as $id => $label ) {
            add_settings_field(
                $id,
                $label,
                array( $this, 'render_input_field' ),
                'lae-compliance',
                'lae_section_admin',
                array( 'id' => $id )
            );
        }

        // Section 2: Modules and Appearance (toggles and colors)
        add_settings_section( 'lae_section_appearance', 'Personalización y Módulos', null, 'lae-compliance' );

        add_settings_field( 'enable_age_gate', 'Activar Age Gate', array( $this, 'render_toggle_field' ), 'lae-compliance', 'lae_section_appearance', array( 'id' => 'enable_age_gate' ) );
        add_settings_field( 'age_gate_color', 'Color Age Gate', array( $this, 'render_color_field' ), 'lae-compliance', 'lae_section_appearance', array( 'id' => 'age_gate_color' ) );
    }

    /**
     * Callbacks to render the fields
     */
    public function render_input_field( $args ) {
        $options = get_option( 'lae_compliance_options' );
        $value   = isset( $options[ $args['id'] ] ) ? esc_attr( $options[ $args['id'] ] ) : '';
        echo "<input type='text' name='lae_compliance_options[{$args['id']}]' value='{$value}' class='regular-text'>";
    }

    public function render_toggle_field( $args ) {
        $options = get_option( 'lae_compliance_options' );
        $checked = isset( $options[ $args['id'] ] ) ? checked( 1, $options[ $args['id'] ], false ) : '';
        echo "<input type='checkbox' name='lae_compliance_options[{$args['id']}]' value='1' {$checked}>";
    }

    public function render_color_field( $args ) {
        $options = get_option( 'lae_compliance_options' );
        $value   = isset( $options[ $args['id'] ] ) ? esc_attr( $options[ $args['id'] ] ) : '#000000';
        echo "<input type='color' name='lae_compliance_options[{$args['id']}]' value='{$value}'>";
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

// Instantiate the class so it works
new LAE_Compliance_Settings();