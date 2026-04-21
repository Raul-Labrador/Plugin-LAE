<?php
/**
 * Render of the Responsible Gaming Banner block
 * The $attributes variable is automatically available.
 */

// We check the chosen size (banner or compact)
$size = isset( $attributes['size'] ) ? $attributes['size'] : 'banner';

// We assign styles according to size
$padding = ( $size === 'compact' ) ? '10px' : '30px';
$font_size = ( $size === 'compact' ) ? '14px' : '18px';
?>

<div class="lae-block-responsible-gaming" style="background: #000; color: #fff; text-align: center; border-radius: 4px; padding: <?php echo esc_attr( $padding ); ?>;">
    <p style="margin: 0; font-size: <?php echo esc_attr( $font_size ); ?>; font-weight: bold;">
        <span style="border: 2px solid #fff; border-radius: 50%; padding: 2px 6px; margin-right: 10px;">+18</span>
        Si juegas, juega con responsabilidad. El juego puede crear adicción.
    </p>
</div>