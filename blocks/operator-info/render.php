<?php
/**
 * Operator Data block render
 */
$options = get_option( 'lae_compliance_options', array() );
$admin_name = ! empty( $options['admin_name'] ) ? esc_html( $options['admin_name'] ) : 'Administración de Loterías';
$nif = ! empty( $options['admin_nif'] ) ? esc_html( $options['admin_nif'] ) : 'No especificado';
?>

<div class="lae-block-operator-info" style="border: 1px solid #ccc; padding: 20px; border-radius: 8px; background: #f9f9f9;">
    <h3 style="margin-top: 0;">Identificación del Operador</h3>
    <p><strong>Titular/Administración:</strong> <?php echo $admin_name; ?></p>
    <p><strong>NIF/CIF:</strong> <?php echo $nif; ?></p>
    <p style="font-size: 0.85em; color: #666;">Punto de venta oficial de Loterías y Apuestas del Estado.</p>
</div>