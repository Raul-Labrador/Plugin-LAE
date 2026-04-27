<?php
/**
 * Visual template for the footer compliance bar.
 * Can be called from a widget or a shortcode.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$options = get_option( 'lae_compliance_options', array() );
?>

<div class="lae-compliance-footer-bar" id="lae-footer-bar">
    
    <div class="lae-compliance-logos">
        <span class="lae-logo-18" aria-label="Mayor de 18 años">
            <strong>+18</strong>
        </span>

        <a href="https://www.ordenacionjuego.es/participantes-juego/juego-seguro" target="_blank" rel="noopener noreferrer" class="lae-badge">Juego Seguro</a>
        <a href="https://sede.ordenacionjuego.gob.es/es/jugar-bien" target="_blank" rel="noopener noreferrer" class="lae-badge">Jugar Bien</a>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var footerBar = document.getElementById('lae-footer-bar');
        if (footerBar) {
            document.body.style.paddingBottom = footerBar.offsetHeight + 'px';
        }
    });
</script>