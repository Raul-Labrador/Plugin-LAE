<?php
/**
 * Visual template for the Age Gate modal.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// We retrieved the options from the database
$options = get_option( 'lae_compliance_options', array() );
$admin_name = ! empty( $options['admin_name'] ) ? $options['admin_name'] : 'nuestra web';

// We brought back the colors of Age Gate
$title_color   = ! empty( $options['age_gate_title_color'] ) ? $options['age_gate_title_color'] : '#1e73be';
$btn_bg_color  = ! empty( $options['age_gate_button_bg_color'] ) ? $options['age_gate_button_bg_color'] : '#2ecc71';
$btn_txt_color = ! empty( $options['age_gate_button_text_color'] ) ? $options['age_gate_button_text_color'] : '#ffffff';
?>

<style>
    #lae-age-gate-overlay .lae-age-title {
        color: <?php echo esc_attr( $title_color ); ?> !important;
    }
    #lae-age-gate-overlay .lae-btn-yes {
        background-color: <?php echo esc_attr( $btn_bg_color ); ?> !important;
        border-color: <?php echo esc_attr( $btn_bg_color ); ?> !important;
        color: <?php echo esc_attr( $btn_txt_color ); ?> !important;
    }
    #lae-age-gate-overlay .lae-age-welcome strong {
        color: <?php echo esc_attr( $title_color ); ?> !important;
    }
</style>

<div id="lae-age-gate-overlay" class="lae-age-gate-overlay" style="display: none;" role="dialog" aria-modal="true" aria-labelledby="lae-age-title">

    <div class="lae-age-gate-content">

        <div class="lae-age-welcome">
            <?php
            printf(
                esc_html__( 'Bienvenido a %s', 'lotto-lae-compliance' ),
                '<strong>' . esc_html( $admin_name ) . '</strong>'
            );
            ?>
        </div>

        <p id="lae-age-title" class="h2 lae-age-title">
            <?php echo esc_html__( '¿Eres mayor de 18 años?', 'lotto-lae-compliance' ); ?>
        </p>

        <div class="lae-age-text">
            <p><?php echo esc_html__( 'El acceso y uso de este sitio web está estrictamente prohibido a menores de 18 años.', 'lotto-lae-compliance' ); ?></p>
        </div>

        <div class="lae-age-gate-buttons">
            <button id="lae-btn-yes" class="lae-btn-yes"><?php echo esc_html__( 'SÍ, SOY MAYOR', 'lotto-lae-compliance' ); ?></button>
            <button id="lae-btn-no" class="lae-btn-no"><?php echo esc_html__( 'NO, SALIR', 'lotto-lae-compliance' ); ?></button>
        </div>

        <p class="lae-cookie-warning">
            <?php echo esc_html__( 'Al confirmar, aceptas el uso de una cookie necesaria para guardar tu preferencia de acceso.', 'lotto-lae-compliance' ); ?>
        </p>

    </div>

</div>