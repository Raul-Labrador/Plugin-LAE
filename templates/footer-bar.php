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

// We rescued the panel's colors
$bg_color    = ! empty( $options['footer_bg_color'] ) ? $options['footer_bg_color'] : '#111111';
$text_color  = ! empty( $options['footer_text_color'] ) ? $options['footer_text_color'] : '#ffffff';
$hover_color = ! empty( $options['footer_hover_color'] ) ? $options['footer_hover_color'] : '#1e73be';
$position    = ! empty( $options['footer_position'] ) ? $options['footer_position'] : 'fixed';
?>

<style>
    #lae-footer-bar a.lae-footer-link:hover,
    #lae-footer-bar a.lae-badge:hover {
        color: <?php echo esc_attr( $hover_color ); ?> !important;
        border-color: <?php echo esc_attr( $hover_color ); ?> !important;
    }
</style>

<div class="lae-compliance-footer-bar" id="lae-footer-bar" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>; position: <?php echo esc_attr($position); ?>;">
    
    <div class="lae-compliance-logos">
        <span class="lae-logo-18" aria-label="<?php echo esc_attr__( 'Mayor de 18 años', 'lotto-lae-compliance' ); ?>">
            <strong style="border-color: <?php echo esc_attr( $text_color ); ?>;">+18</strong>
        </span>

        <a href="https://www.juegoseguro.es" target="_blank" rel="noopener noreferrer" class="lae-badge" style="color: <?php echo esc_attr($text_color); ?>; border-color: <?php echo esc_attr($text_color); ?>;">
            <?php echo esc_html__( 'Juego Seguro', 'lotto-lae-compliance' ); ?>
        </a>
        <a href="https://www.loteriasyapuestas.es/es" target="_blank" rel="noopener noreferrer" class="lae-badge" style="color: <?php echo esc_attr($text_color); ?>; border-color: <?php echo esc_attr($text_color); ?>;">
            <?php echo esc_html__( 'Juego Responsable', 'lotto-lae-compliance' ); ?>
        </a>
    </div>

    <div class="lae-compliance-text">
        <p><?php echo esc_html__( 'Si juegas, juega con responsabilidad. El juego puede crear adicción.', 'lotto-lae-compliance' ); ?></p>
    </div>

    <div class="lae-compliance-links">
        <a href="<?php echo esc_url( site_url('/juego-responsable/') ); ?>" class="lae-footer-link" style="color: <?php echo esc_attr($text_color); ?>;">
            <?php echo esc_html__( 'Política de Juego', 'lotto-lae-compliance' ); ?>
        </a> 
        <span class="lae-separator">|</span>
        <a href="<?php echo esc_url( site_url('/politica-devoluciones-loteria/') ); ?>" class="lae-footer-link" style="color: <?php echo esc_attr($text_color); ?>;">
            <?php echo esc_html__( 'Política de Devoluciones', 'lotto-lae-compliance' ); ?>
        </a>
        <span class="lae-separator">|</span>
        <a href="<?php echo esc_url( home_url('/autoexclusion/') ); ?>" class="lae-footer-link lae-fw-bold" style="color: <?php echo esc_attr($text_color); ?>;">
            <?php echo esc_html__( 'RGIAJ', 'lotto-lae-compliance' ); ?>
        </a>
        <span class="lae-separator">|</span>
        <a href="tel:024" class="lae-footer-link lae-fw-bold" style="color: <?php echo esc_attr($text_color); ?>;">☎ 024</a>
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