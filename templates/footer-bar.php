<?php
/**
 * Plantilla visual para la barra de cumplimiento del pie de página.
 * Puede ser llamada desde un Widget o un Shortcode.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


$options = get_option( 'lae_compliance_options', array() );
?>

<div class="lae-compliance-footer-bar">
    
    <div class="lae-compliance-logos">
        <span class="lae-logo-18" aria-label="Mayor de 18 años">
            <strong>+18</strong>
        </span>

        <span class="lae-badge">Juego Seguro</span>
        <span class="lae-badge">Jugar Bien</span>
    </div>

    <div class="lae-compliance-text">
        <p>
            <?php esc_html_e( 'Si juegas, juega con responsabilidad. El juego puede crear adicción.', 'lotto-lae-compliance' ); ?>
        </p>
    </div>

    <div class="lae-compliance-links">
        <a href="https://sede.ordenacionjuego.gob.es/es/registro-interdicciones" target="_blank" rel="noopener noreferrer" class="lae-btn-rgiaj">
            <?php esc_html_e( 'Autoexclusión RGIAJ', 'lotto-lae-compliance' ); ?>
        </a>
        
        <a href="tel:024" class="lae-btn-024">
            ☎ <?php esc_html_e( 'Ayuda: 024', 'lotto-lae-compliance' ); ?>
        </a>
    </div>

</div>