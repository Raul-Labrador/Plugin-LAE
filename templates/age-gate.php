<?php
/**
 * Visual template for the Age Gate modal.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Recuperamos las opciones para sacar el nombre de la empresa
$options = get_option( 'lae_compliance_options', array() );
$admin_name = ! empty( $options['admin_name'] ) ? $options['admin_name'] : 'nuestra web';
?>

<div id="lae-age-gate-overlay" class="lae-age-gate-overlay" style="display: none;" role="dialog" aria-modal="true" aria-labelledby="lae-age-title">
    
    <div class="lae-age-gate-content">
        
        <div class="lae-age-welcome">
            Bienvenido a <strong><?php echo esc_html( $admin_name ); ?></strong>
        </div>

        <h2 id="lae-age-title" class="lae-age-title">¿Eres mayor de 18 años?</h2>

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