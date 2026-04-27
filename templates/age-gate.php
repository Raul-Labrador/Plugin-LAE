<?php
/**
 * HTML template for the age verification modal (Age Gate).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$options = get_option( 'lae_compliance_options', array() );

$admin_name = ! empty( $options['admin_name'] ) ? esc_html( $options['admin_name'] ) : 'esta Administración de Loterías';
?>

<div id="lae-age-gate-modal" class="lae-age-gate-overlay" style="display: none;">
    
    <div class="lae-age-gate-content">
        <h2>Atención</h2>
        <p>
            Bienvenido a <strong><?php echo $admin_name; ?></strong>.<br><br>
            De acuerdo con la legislación vigente, el acceso a esta plataforma está estrictamente prohibido a menores de edad.<br><br>
            ¿Eres mayor de 18 años?
        </p>

        <div class="lae-age-gate-buttons">
            <button id="lae-btn-age-yes" class="lae-btn-yes">Sí, soy mayor de 18 años</button>
            
            <button id="lae-btn-age-no" class="lae-btn-no">No, soy menor de 18 años</button>
        </div>
        
        <p style="font-size: 0.8rem; margin-top: 20px; color: #666;">
            Al pulsar en "Sí", confirmas tu mayoría de edad y aceptas el uso de una cookie técnica para recordar tu elección.
        </p>
    </div>

</div>