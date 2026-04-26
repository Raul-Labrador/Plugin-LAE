<?php
/**
 * Operator Data block render
 */
$operator_data = LAE_Compliance_Integration::get_operator_data();

$admin_name = esc_html( $operator_data['admin_name'] );
$nif        = esc_html( $operator_data['admin_nif'] );
?>

<div class="lae-block-operator-info" style="border: 1px solid #ccc; padding: 20px; border-radius: 8px; background: #f9f9f9;">
    <h3 style="margin-top: 0;">Identificación del Operador</h3>
    <p><strong>Titular/Administración:</strong> <?php echo $admin_name; ?></p>
    <p><strong>NIF/CIF:</strong> <?php echo $nif; ?></p>
    <p style="font-size: 0.85em; color: #666;">Punto de venta oficial de Loterías y Apuestas del Estado.</p>
</div>