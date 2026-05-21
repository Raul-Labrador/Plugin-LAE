<?php
/**
 * Render for Responsible Gaming Block
 */

$size = isset( $attributes['size'] ) ? $attributes['size'] : 'medium';

echo do_shortcode( '[lae_responsible_gaming size="' . esc_attr( $size ) . '"]' );