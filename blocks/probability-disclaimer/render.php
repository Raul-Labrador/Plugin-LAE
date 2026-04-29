<?php
/**
 * Render of the Probability Notice block
 */

// We retrieve the chosen draw or set the default value
$sorteo = isset( $attributes['sorteo'] ) && ! empty( $attributes['sorteo'] ) ? $attributes['sorteo'] : 'Lotería Nacional';
?>

<div class="lae-block-probability" style="background-color: #fff9c4; border-left: 4px solid #fbc02d; padding: 15px; margin: 20px 0; font-size: 0.9em; color: #555; border-radius: 4px;">
    <p style="margin: 0;">
        <strong>Aviso sobre probabilidades:</strong> La participación en los juegos de lotería se basa en el azar. Las probabilidades de obtener premio en cada uno de los juegos comercializados por SELAE son públicas y pueden ser consultadas en los puntos de venta oficiales y en la web de Loterías y Apuestas del Estado.
    </p>
</div>