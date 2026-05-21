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

        // Inject ads into Lottoei's custom pages
        add_filter( 'the_content', array( $this, 'inject_lottoei_notices' ) );
    }

    public function product_probability_notice() {
        ?>
        <div class="woocommerce-message lae-product-notice">
            <strong><?php echo esc_html__( 'Aviso:', 'lotto-lae-compliance' ); ?></strong>
            <?php echo esc_html__( 'Los juegos de lotería son juegos de azar. Participar en ellos no garantiza la obtención de premio. Juega con responsabilidad.', 'lotto-lae-compliance' ); ?>
        </div>
        <?php
    }

    public function cart_responsible_notice() {
        ?>
        <div class="woocommerce-error lae-cart-notice">
            <strong><?php echo esc_html__( 'Política de devoluciones:', 'lotto-lae-compliance' ); ?></strong>
            <?php echo esc_html__( 'Los décimos y resguardos adquiridos no admiten devolución una vez validados. Prohibida la venta a menores de 18 años.', 'lotto-lae-compliance' ); ?>
        </div>
        <?php
    }

    public function checkout_age_checkbox() {
        woocommerce_form_field( 'lae_checkout_age_verify', array(
            'type'        => 'checkbox',
            'class'       => array( 'form-row lae-age-checkbox' ),
            'label_class' => array( 'woocommerce-form__label woocommerce-form__label-for-checkbox checkbox' ),
            'input_class' => array( 'woocommerce-form__input woocommerce-form__input-checkbox input-checkbox' ),
            'required'    => true,
            'label'       => '<span style="font-weight: bold; margin-right: 5px;">+18</span><strong>' . esc_html__( 'Confirmo que soy mayor de 18 años', 'lotto-lae-compliance' ) . '</strong> ' . esc_html__( 'y acepto las condiciones de compra.', 'lotto-lae-compliance' ),
        ), WC()->checkout->get_value( 'lae_checkout_age_verify' ) );
    }

    public function checkout_age_validation() {
        if ( ! isset( $_POST['lae_checkout_age_verify'] ) ) {
            wc_add_notice(
                '<i class="fas fa-times-circle" style="margin-right: 5px;"></i> <strong>' . esc_html__( 'Acceso denegado:', 'lotto-lae-compliance' ) . '</strong> ' . esc_html__( 'Debes confirmar que eres mayor de 18 años para poder finalizar la compra.', 'lotto-lae-compliance' ),
                'error'
            );
        }
    }

    public function thankyou_responsible_notice( $order_id ) {
        ?>
        <div class="lae-wc-notice lae-thankyou-notice" style="background-color: #fdfae6; border-left: 4px solid #d4af37; padding: 15px; margin-bottom: 25px; border-radius: 4px;">
            <p style="margin: 0; color: #444;">
                <span class="lae-logo-18" style="font-weight: bold; margin-right: 10px;">+18</span>
                <i class="fas fa-shield-alt" style="color: #d4af37; margin-right: 5px;"></i>
                <strong><?php echo esc_html__( 'Juego Responsable:', 'lotto-lae-compliance' ); ?></strong>
                <?php echo esc_html__( 'Si juegas, juega con responsabilidad. El juego puede crear adicción. Teléfono gratuito de ayuda:', 'lotto-lae-compliance' ); ?>
                <strong>024</strong>.
            </p>
        </div>
        <?php
    }

    public function email_legal_footer( $email ) {
        ?>
        <div style="background-color: #f6f6f6; padding: 20px; text-align: center; font-size: 12px; color: #666666; border-top: 1px solid #eeeeee; margin-top: 30px;">
            <p style="margin: 0 0 10px 0;"><strong><?php echo esc_html__( '+18 | Prohibida la participación a menores de edad.', 'lotto-lae-compliance' ); ?></strong></p>
            <p style="margin: 0;">
                <?php echo esc_html__( 'Si juegas, juega con responsabilidad. El juego puede crear adicción.', 'lotto-lae-compliance' ); ?><br>
                <?php echo esc_html__( 'Teléfono gratuito de ayuda:', 'lotto-lae-compliance' ); ?> <strong>024</strong> |
                <?php echo esc_html__( 'Más información en', 'lotto-lae-compliance' ); ?>
                <a href="https://www.loteriasyapuestas.es/es" style="color: #1e73be; text-decoration: underline;" target="_blank"><?php echo esc_html__( 'Loterías y Apuestas', 'lotto-lae-compliance' ); ?></a>
            </p>
        </div>
        <?php
    }

    public function inject_lottoei_notices( $content ) {
        // We only act on the public part and the main content
        if ( is_admin() || ! is_main_query() ) {
            return $content;
        }

        $lottoei_shortcodes = array( 'lotto_numbers', 'lotto_company', 'lotto_terminal' );
        $is_lottoei_page = false;

        foreach ( $lottoei_shortcodes as $shortcode ) {
            if ( has_shortcode( $content, $shortcode ) ) {
                $is_lottoei_page = true;
                break;
            }
        }

        // If it's a Lottoei page, we inject our notice right BEFORE its content.
        if ( $is_lottoei_page ) {
            ob_start();
            ?>
            <div class="woocommerce-message lae-product-notice" style="margin-bottom: 2em;">
                <strong><?php echo esc_html__( 'Aviso:', 'lotto-lae-compliance' ); ?></strong>
                <?php echo esc_html__( 'Los juegos de lotería son juegos de azar. Participar en ellos no garantiza la obtención de premio. Juega con responsabilidad.', 'lotto-lae-compliance' ); ?>
            </div>
            <?php
            $aviso_legal = ob_get_clean();

            $content = $aviso_legal . $content;
        }

        return $content;
    }
}

new LAE_Compliance_WooCommerce();