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
            Bienvenido a <strong><?php echo esc_html( $admin_name ); ?></strong>
        </div>

        <p id="lae-age-title" class="h2 lae-age-title">¿Eres mayor de 18 años?</p>

        <div class="lae-age-text">
            <p>El acceso y uso de este sitio web está estrictamente prohibido a menores de 18 años.</p>
        </div>

        <div class="lae-age-gate-buttons">
            <button id="lae-btn-yes" class="lae-btn-yes">SÍ, SOY MAYOR</button>
            <button id="lae-btn-no" class="lae-btn-no">NO, SALIR</button>
        </div>

        <p class="lae-cookie-warning">Al confirmar, aceptas el uso de una cookie necesaria para guardar tu preferencia de acceso.</p>

    </div>

</div>