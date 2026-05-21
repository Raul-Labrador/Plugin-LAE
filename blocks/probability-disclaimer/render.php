<?php
/**
 * Render of the Probability Notice block
 */

$sorteo = isset( $attributes['sorteo'] ) ? $attributes['sorteo'] : 'loteria-nacional';

echo do_shortcode( '[lae_probability_disclaimer sorteo="' . esc_attr( $sorteo ) . '"]' );