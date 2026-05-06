<?php
/**
 * Render for Operator/Seller Info Block
 */

$options = get_option( 'lae_compliance_options', array() );

$admin_name  = !empty($options['admin_name']) ? $options['admin_name'] : 'No especificado';
$holder_nif  = !empty($options['holder_nif']) ? $options['holder_nif'] : 'No especificado';
?>

<div class="lae-shortcode-wrapper lae-operator-info-card">
    <h4 class="lae-operator-title">IDENTIFICACIÓN DEL VENDEDOR</h4>
    
    <div style="margin-bottom: 15px;">
        <p style="margin: 0 0 8px 0; color: #333;">
            <strong>Titular/Administración:</strong> <?php echo esc_html( $admin_name ); ?>
        </p>
        <p style="margin: 0; color: #333;">
            <strong>NIF/CIF:</strong> <?php echo esc_html( $holder_nif ); ?>
        </p>
    </div>

    <p style="margin: 0; font-size: 0.85em; color: #666; border-top: 1px solid #eee; padding-top: 10px;">
        Punto de venta oficial de Loterías y Apuestas del Estado.
    </p>
</div>