<?php
/**
 * Render of the Probability Notice block
 */

// We retrieve the chosen draw or set the default value
$sorteo = isset( $attributes['sorteo'] ) && ! empty( $attributes['sorteo'] ) ? $attributes['sorteo'] : 'Lotería Nacional';
?>

<div class="lae-block-probability" style="background-color: #fff9c4; border-left: 4px solid #fbc02d; padding: 15px; margin: 20px 0; font-size: 0.9em; color: #555; border-radius: 4px;">
    <p style="margin: 0;">
        <strong>Aviso sobre probabilidades:</strong> La participación en <em><?php echo esc_html( $sorteo ); ?></em> es un juego de azar. 
        Las probabilidades matemáticas de obtener el premio mayor dependen del número total de billetes o combinaciones emitidas en cada sorteo. 
        Infórmate sobre las probabilidades reales antes de jugar y hazlo siempre con responsabilidad.
    </p>
</div>