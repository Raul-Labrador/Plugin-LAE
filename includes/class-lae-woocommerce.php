<?php
/**
 * Class to inject legal messages and validations into WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LAE_Compliance_WooCommerce {

    public function __construct() {
        // Product page: Probability notice
        add_action( 'woocommerce_single_product_summary', array( $this, 'product_probability_notice' ), 25 );
        
        // Shopping cart: Returns policy and responsible gaming
        add_action( 'woocommerce_before_cart', array( $this, 'cart_responsible_notice' ) );
        
        // Checkout: +18 checkbox required
        add_action( 'woocommerce_review_order_before_submit', array( $this, 'checkout_age_checkbox' ) );
        add_action( 'woocommerce_checkout_process', array( $this, 'checkout_age_validation' ) );
        
        // Thank You Page: Final Message (Movido arriba según M3)
        add_action( 'woocommerce_before_thankyou', array( $this, 'thankyou_responsible_notice' ), 5 );
        
        // WooCommerce Emails: Legal Footer
        add_action( 'woocommerce_email_footer', array( $this, 'email_legal_footer' ) );
    }

    public function product_probability_notice() {
        ?>
        <div class="lae-wc-notice lae-product-notice" style="border: 1px solid #ffcc00; padding: 10px; margin-bottom: 20px; border-radius: 4px; background: #fffdf0;">
            <p style="margin:0; font-size: 0.9em; color: #444;">
                <i class="fas fa-info-circle" style="color: #d4af37; margin-right: 5px;"></i> 
                <strong>Aviso legal:</strong> Los juegos de lotería son juegos de azar. Participar en ellos no garantiza la obtención de premio. Juega con responsabilidad.
            </p>
        </div>
        <?php
    }

    public function cart_responsible_notice() {
        ?>
        <div class="woocommerce-info lae-cart-notice">
            <i class="fas fa-exclamation-triangle" style="margin-right: 5px;"></i> 
            <strong>Política de devoluciones:</strong> Los décimos y resguardos adquiridos no admiten devolución una vez validados. Prohibida la venta a menores de 18 años.
        </div>
        <?php
    }

    // Mantenemos esto en PHP porque es una llamada a una función que genera el input
    public function checkout_age_checkbox() {
        woocommerce_form_field( 'lae_checkout_age_verify', array(
            'type'          => 'checkbox',
            'class'         => array('form-row lae-age-checkbox'),
            'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
            'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
            'required'      => true,
            'label'         => '<span style="font-weight: bold; margin-right: 5px;">+18</span><strong>Confirmo que soy mayor de 18 años</strong> y acepto las condiciones de compra.',
        ), WC()->checkout->get_value( 'lae_checkout_age_verify' ) );
    }

    // Mantenemos en PHP porque maneja lógica (if) y añade un error al sistema
    public function checkout_age_validation() {
        if ( ! isset( $_POST['lae_checkout_age_verify'] ) ) {
            wc_add_notice( '<i class="fas fa-times-circle" style="margin-right: 5px;"></i> <strong>Acceso denegado:</strong> Debes confirmar que eres mayor de 18 años para poder finalizar la compra.', 'error' );
        }
    }

    public function thankyou_responsible_notice( $order_id ) {
        ?>
        <div class="lae-wc-notice lae-thankyou-notice" style="background-color: #fdfae6; border-left: 4px solid #d4af37; padding: 15px; margin-bottom: 25px; border-radius: 4px;">
            <p style="margin: 0; color: #444;">
                <span class="lae-logo-18" style="font-weight: bold; margin-right: 10px;">+18</span>
                <i class="fas fa-shield-alt" style="color: #d4af37; margin-right: 5px;"></i> 
                <strong>Juego Responsable:</strong> Si juegas, juega con responsabilidad. El juego puede crear adicción. Teléfono gratuito de ayuda: <strong>024</strong>.
            </p>
        </div>
        <?php
    }

    public function email_legal_footer( $email ) {
        ?>
        <div style="background-color: #f6f6f6; padding: 20px; text-align: center; font-size: 12px; color: #666666; border-top: 1px solid #eeeeee; margin-top: 30px;">
            <p style="margin: 0 0 10px 0;"><strong>+18 | Prohibida la participación a menores de edad.</strong></p>
            <p style="margin: 0;">
                Si juegas, juega con responsabilidad. El juego puede crear adicción. <br>
                Teléfono gratuito de ayuda: <strong>024</strong> | Más información en <a href="https://www.loteriasyapuestas.es/es" style="color: #1e73be; text-decoration: underline;" target="_blank">Loterías y Apuestas</a>
            </p>
        </div>
        <?php
    }
}

// Instantiate the class
new LAE_Compliance_WooCommerce();