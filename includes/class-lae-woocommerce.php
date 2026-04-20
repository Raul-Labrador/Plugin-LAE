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
        
        // Thank You Page: Final Message
        add_action( 'woocommerce_thankyou', array( $this, 'thankyou_responsible_notice' ) );
        
        // WooCommerce Emails: Legal Footer
        add_action( 'woocommerce_email_footer', array( $this, 'email_legal_footer' ) );
    }

    public function product_probability_notice() {
        // We attached it below the price/short extract
        echo '<div class="lae-wc-notice lae-product-notice" style="border: 1px solid #ffcc00; padding: 10px; margin-bottom: 20px; border-radius: 4px; background: #fffdf0;">';
        echo '<p style="margin:0; font-size: 0.9em;">ℹ️ <strong>Aviso:</strong> La lotería es un juego de azar. Conoce las probabilidades de ganar antes de jugar. Juega con responsabilidad.</p>';
        echo '</div>';
    }

    public function cart_responsible_notice() {
        // We use the native WooCommerce class so that it inherits the style of the theme's notices.
        echo '<div class="woocommerce-info lae-cart-notice">';
        echo '<strong>Política de Loterías:</strong> Los décimos y resguardos adquiridos no admiten devolución una vez validados. Juega con responsabilidad y solo si eres mayor de 18 años.';
        echo '</div>';
    }

    //We created a checkbox using the WooCommerce Forms API
    public function checkout_age_checkbox() {
        woocommerce_form_field( 'lae_checkout_age_verify', array(
            'type'          => 'checkbox',
            'class'         => array('form-row lae-age-checkbox'),
            'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
            'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
            'required'      => true,
            'label'         => '<strong>Confirmo que soy mayor de 18 años</strong> y acepto las condiciones de compra de lotería.',
        ), WC()->checkout->get_value( 'lae_checkout_age_verify' ) );
    }

    public function checkout_age_validation() {
        // If the user tries to pay without checking the box, we block the purchase and throw an error.
        if ( ! isset( $_POST['lae_checkout_age_verify'] ) ) {
            wc_add_notice( '<strong>Acceso denegado:</strong> Debes confirmar que eres mayor de 18 años para poder finalizar la compra.', 'error' );
        }
    }

    public function thankyou_responsible_notice( $order_id ) {
        echo '<div class="lae-wc-notice lae-thankyou-notice" style="margin-top: 20px; padding: 15px; background: #f9f9f9; border-left: 4px solid #4CAF50;">';
        echo '<p style="margin:0;">Gracias por confiar en nosotros. Recuerda: <strong>Juega con cabeza, juega con responsabilidad.</strong> Si tienes problemas con el juego, llama al 024.</p>';
        echo '</div>';
    }

    public function email_legal_footer( $email ) {
        echo '<div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #e5e5e5; font-size: 11px; color: #777;">';
        echo '<p><strong>Aviso legal:</strong> Prohibida la participación a menores de 18 años. El juego puede generar adicción. Juega con responsabilidad. Más info en <a href="https://www.jugarbien.es" target="_blank">jugarbien.es</a>.</p>';
        echo '</div>';
    }
}

// Instantiate the class
new LAE_Compliance_WooCommerce();