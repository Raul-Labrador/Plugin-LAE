<?php
/**
 * Visual template for the footer compliance bar.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$options = get_option( 'lae_compliance_options', array() );

if ( empty( $options['enable_footer'] ) ) {
    return; 
}

// Rescatamos los colores del panel (con valores por defecto)
$bg_color    = ! empty( $options['footer_bg_color'] ) ? $options['footer_bg_color'] : '#111111';
$text_color  = ! empty( $options['footer_text_color'] ) ? $options['footer_text_color'] : '#ffffff';
$hover_color = ! empty( $options['footer_hover_color'] ) ? $options['footer_hover_color'] : '#1e73be'; // Azul por defecto
$position    = ! empty( $options['footer_position'] ) ? $options['footer_position'] : 'fixed';
?>

<div class="lae-compliance-footer-bar" id="lae-footer-bar" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>; position: <?php echo esc_attr($position); ?>; --lae-footer-text: <?php echo esc_attr($text_color); ?>; --lae-footer-hover: <?php echo esc_attr($hover_color); ?>;">
    
    <div class="lae-compliance-logos">
        <span class="lae-logo-18" aria-label="Mayor de 18 años">
            <strong style="border-color: <?php echo esc_attr($text_color); ?>;">+18</strong>
        </span>

        <a href="https://www.juegoseguro.es" target="_blank" rel="noopener noreferrer" class="lae-badge">Juego Seguro</a>
        <a href="https://www.loteriasyapuestas.es/es" target="_blank" rel="noopener noreferrer" class="lae-badge">Juego Responsable</a>
    </div>

    <div class="lae-compliance-text">
        <p><?php esc_html_e( 'Si juegas, juega con responsabilidad. El juego puede crear adicción.', 'lotto-lae-compliance' ); ?></p>
    </div>

    <div class="lae-compliance-links">
        <a href="<?php echo esc_url( site_url('/juego-responsable/') ); ?>" class="lae-footer-link">Política de Juego</a> 
        <span class="lae-separator">|</span>
        <a href="<?php echo esc_url( site_url('/politica-devoluciones-loteria/') ); ?>" class="lae-footer-link">Política de Devoluciones</a>
        <span class="lae-separator">|</span>
        <a href="<?php echo esc_url( home_url('/autoexclusion/') ); ?>" class="lae-footer-link lae-fw-bold">RGIAJ</a>
        <span class="lae-separator">|</span>
        <a href="tel:024" class="lae-footer-link lae-fw-bold">☎ 024</a>
    </div>

</div>

<?php if ( $position === 'fixed' ) : ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var footerBar = document.getElementById('lae-footer-bar');
        if (footerBar) {
            document.body.style.paddingBottom = footerBar.offsetHeight + 'px';
        }
    });
</script>
<?php endif; ?>