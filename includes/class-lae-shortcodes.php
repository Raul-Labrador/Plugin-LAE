<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class LAE_Compliance_Shortcodes {

    public function __construct() {
        // M3 & M4 Legal Pages Shortcodes
        add_shortcode( 'lae_operator_info', array( $this, 'render_operator_info' ) );
        add_shortcode( 'lae_responsible_footer', array( $this, 'render_responsible_footer' ) );
        add_shortcode( 'lae_responsible_gaming_page', array( $this, 'render_responsible_gaming_page' ) );
        add_shortcode( 'lae_autoexclusion_page', array( $this, 'render_autoexclusion_page' ) );
        add_shortcode( 'lae_returns_policy_page', array( $this, 'render_returns_policy_page' ) );

        // M5 & M6 Compliance Blocks Shortcodes
        add_shortcode( 'lae_responsible_gaming', array( $this, 'render_responsible_gaming' ) );
        add_shortcode( 'lae_age_warning', array( $this, 'render_age_warning' ) );
        add_shortcode( 'lae_phone_helpline', array( $this, 'render_phone_helpline' ) );
        add_shortcode( 'lae_exclusion_links', array( $this, 'render_exclusion_links' ) );
    }

    /* M3 & M4 */

    public function render_operator_info() {
        $options = LAE_Compliance_Integration::get_operator_data();

        $admin_name   = $options['admin_name'] ?? '';
        $admin_number = $options['admin_number'] ?? '';
        $holder_name  = $options['holder_name'] ?? '';
        $holder_nif   = $options['holder_nif'] ?? '';
        $address      = $options['address'] ?? '';

        ob_start();
        ?>
        <div class="lae-operator-info-card">
            <ul>
                <li><strong>Administración:</strong> <?php echo esc_html( $admin_name ); ?></li>
                <li><strong>Número LAE:</strong> <?php echo esc_html( $admin_number ); ?></li>
                <li><strong>Titular:</strong> <?php echo esc_html( $holder_name ); ?></li>
                <li><strong>NIF:</strong> <?php echo esc_html( $holder_nif ); ?></li>
                <li><strong>Dirección:</strong> <?php echo esc_html( $address ); ?></li>
            </ul>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_responsible_footer() {
        ob_start();
        $template_path = LAE_COMPLIANCE_PATH . 'templates/footer-bar.php';
        if ( file_exists( $template_path ) ) {
            include $template_path;
        }
        return ob_get_clean();
    }

    public function render_responsible_gaming_page() {

        /**
         * Legal / official sources used for this page:
         * - DGOJ: obligation to include a direct and easily visible link to responsible gaming information.
         * - DGOJ: RGIAJ as the official self-exclusion / gambling access restriction registry.
         * - SELAE: official responsible gaming / minors protection resource.
         * - Ministry of Health: official 024 helpline resource.
         *
         * Sources:
         * https://www.ordenacionjuego.es/participantes-juego/juego-seguro/medidas-juego-seguro/medidas-informacion-proteccion-personas
         * https://www.ordenacionjuego.es/participantes-juego/juego-seguro/rgiaj
         * https://www.selae.es/es/web-corporativa/responsabilidad-social/gestion-responsable-del-juego/proteccion-a-menores
         * https://www.sanidad.gob.es/linea024/home.htm
         *
         * Note:
         * - The old "www.jugarbien.es" link appears unavailable and should not be used.
         */

        $options = get_option( 'lae_compliance_options', array() );
        $admin_name = ! empty( $options['admin_name'] ) ? $options['admin_name'] : 'nuestra administración';

        ob_start();
        ?>
        <div class="lae-legal-page lae-responsible-gaming-page">
            <h2>Juego responsable</h2>

            <p>En <strong><?php echo esc_html( $admin_name ); ?></strong> promovemos un uso responsable de los juegos de lotería. La participación debe entenderse como una forma de ocio y nunca como una manera de obtener ingresos ni de resolver problemas económicos o personales.</p>

            <p><strong>Prohibida la participación a menores de 18 años.</strong></p>

            <p>Los juegos de lotería son juegos de azar. Participar no garantiza la obtención de premio y conviene hacerlo con moderación, autocontrol y dentro de unos límites personales.</p>

            <p>Te recomendamos:</p>
            <ul>
                <li>jugar solo si eres mayor de edad</li>
                <li>no gastar más de lo que puedas permitirte perder</li>
                <li>no intentar recuperar pérdidas con nuevas compras</li>
                <li>no jugar bajo estrés, ansiedad o presión económica</li>
                <li>hacer pausas y revisar con frecuencia tus hábitos de juego</li>
            </ul>

            <p>Si crees que el juego deja de ser una actividad de ocio o te genera malestar, es importante parar y buscar ayuda o limitar tu acceso al juego.</p>

            <h3>Recursos oficiales</h3>
            <div class="lae-legal-page-links">
                <a href="https://www.ordenacionjuego.es/participantes-juego/juego-seguro/medidas-juego-seguro/medidas-informacion-proteccion-personas" class="lae-badge-link" target="_blank" rel="noopener noreferrer">Juego Seguro</a>
                <a href="https://www.ordenacionjuego.es/participantes-juego/juego-seguro/rgiaj" class="lae-badge-link" target="_blank" rel="noopener noreferrer">RGIAJ / Autoprohibición</a>
                <a href="https://www.selae.es/es/web-corporativa/responsabilidad-social/gestion-responsable-del-juego/proteccion-a-menores" class="lae-badge-link" target="_blank" rel="noopener noreferrer">Protección a menores</a>
                <a href="https://www.sanidad.gob.es/linea024/home.htm" class="lae-badge-link" target="_blank" rel="noopener noreferrer">Ayuda 024</a>
            </div>

            <p>En esta web puedes informarte sobre los juegos disponibles sin que exista obligación de participar. La decisión de compra o participación debe ser siempre libre, consciente y responsable.</p>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_autoexclusion_page() {

        /**
         * Official sources used for this page:
         * - DGOJ: RGIAJ official information page (what it is, who it applies to, duration and cancellation after 6 months).
         * - DGOJ: RGIAJ application/registration information (electronic application and immediate effects through the e-office).
         *
         * Sources:
         * https://www.ordenacionjuego.es/participantes-juego/juego-seguro/rgiaj
         * https://www.ordenacionjuego.es/datos-estudios/actividad-historica/act-rgiaj
         */
        ob_start();
        ?>
        <div class="lae-legal-page lae-autoexclusion-page">
            <h2>Autoexclusión (RGIAJ)</h2>

            <p>Si deseas limitar tu acceso a actividades de juego, puedes solicitar la inscripción en el <strong>Registro General de Interdicciones de Acceso al Juego (RGIAJ)</strong>, gestionado por la Dirección General de Ordenación del Juego.</p>

            <p>La inscripción en el RGIAJ impide participar en aquellos juegos en los que la legislación exige la identificación previa del participante y constituye una medida oficial de protección para personas que desean restringir su acceso al juego.</p>

            <p>Puedes solicitar la inscripción de forma electrónica a través de la sede oficial o mediante la presentación del formulario correspondiente en un registro público. Cuando la solicitud se realiza por sede electrónica, sus efectos son inmediatos.</p>

            <p>La inscripción tiene carácter <strong>indefinido</strong>. No obstante, la persona interesada podrá solicitar su cancelación una vez transcurridos <strong>seis meses</strong> desde la fecha de inscripción.</p>

            <p>Si necesitas comprobar tu situación en el registro o consultar información adicional sobre el procedimiento, puedes hacerlo a través de los canales oficiales de la Dirección General de Ordenación del Juego.</p>

            <p>Para ampliar información sobre el procedimiento, consultar tu situación o acceder a la solicitud, puedes utilizar los recursos oficiales de la Dirección General de Ordenación del Juego.</p>
            
            <div class="lae-legal-page-links">
                <a href="https://www.ordenacionjuego.es/participantes-juego/juego-seguro/rgiaj" class="lae-badge-link" target="_blank" rel="noopener noreferrer">Información oficial sobre RGIAJ</a>
                <a href="https://www.ordenacionjuego.es/datos-estudios/actividad-historica/act-rgiaj" class="lae-badge-link" target="_blank" rel="noopener noreferrer">Solicitud e inscripción</a>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_returns_policy_page() {

        /**
         * Legal basis used for this page:
         * - Article 103.l of Royal Legislative Decree 1/2007 (TRLGDCU):
         *   the right of withdrawal does not apply to services related to leisure
         *   activities when the contract provides for a specific date or period of performance.
         *
         * Official source:
         * https://www.boe.es/buscar/act.php?id=BOE-A-2007-20555
         */

        $options = get_option( 'lae_compliance_options', array() );
        $admin_name = ! empty( $options['admin_name'] ) ? $options['admin_name'] : 'esta administración';

        ob_start();
        ?>
        <div class="lae-legal-page lae-returns-policy-page">
            <h2>Política de devoluciones</h2>

            <p>La gestión de compra de décimos, resguardos o participaciones realizada a través de <strong><?php echo esc_html( $admin_name ); ?></strong> está sujeta a la normativa aplicable en materia de juego y consumo.</p>

            <p>Antes de finalizar tu compra, te recomendamos revisar cuidadosamente el sorteo seleccionado, la fecha del sorteo, el número elegido, el importe, la cantidad y cualquier otro dato relevante del pedido.</p>

            <p>Una vez confirmada y formalizada la compra, y siempre que el pedido quede vinculado a un sorteo o fecha concreta, <strong>no procederá el derecho de desistimiento ni la devolución del importe</strong>, al tratarse de un servicio relacionado con actividades de esparcimiento cuando el contrato prevea una fecha o un periodo de ejecución específicos.</p>

            <p>Por ese motivo, no será posible anular o devolver pedidos ya emitidos, gestionados o validados, salvo en aquellos supuestos en los que resulte aplicable una obligación legal distinta o exista una incidencia técnica o operativa imputable al servicio prestado.</p>

            <p>En caso de incidencia, error técnico en el proceso de compra o duda sobre la gestión del pedido, podrás ponerte en contacto con <strong><?php echo esc_html( $admin_name ); ?></strong> a través de los canales habituales de atención para revisar el caso concreto.</p>

            <p>Esta política afecta exclusivamente a la devolución o cancelación de compras ya realizadas y no limita otros derechos que puedan corresponder al usuario conforme a la normativa aplicable.</p>
        </div>
        <?php
        return ob_get_clean();
    }

    /* M5 & M6 */

    public function render_responsible_gaming( $atts ) {
        $atts = shortcode_atts( array(
            'size' => 'banner', // options: banner, compact
        ), $atts, 'lae_responsible_gaming' );

        $size_class = ( $atts['size'] === 'compact' ) ? 'lae-sc-compact' : 'lae-sc-banner';

        ob_start();
        ?>
        <div class="lae-shortcode-wrapper lae-sc-responsible-gaming <?php echo esc_attr( $size_class ); ?>">
            <p>
                <span class="lae-logo-18-inline"><strong>+18</strong></span>
                Si juegas, juega con responsabilidad. El juego puede crear adicción.
            </p>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_age_warning() {
        ob_start();
        ?>
        <div class="lae-shortcode-wrapper lae-sc-age-warning">
            <div class="lae-sc-icon">
                <span class="lae-logo-18"><strong>+18</strong></span>
            </div>
            <div class="lae-sc-content">
                <h4>Prohibida la venta a menores</h4>
                <p>El acceso y la participación en los juegos comercializados por Loterías y Apuestas del Estado está estrictamente prohibido a los menores de 18 años.</p>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_phone_helpline() {
        ob_start();
        ?>
        <div class="lae-shortcode-wrapper lae-sc-phone">
            <a href="tel:024" class="lae-sc-phone-link">
                <span class="lae-icon">☎</span> 
                <span class="lae-text">Teléfono de ayuda:</span> 
                <span class="lae-number">024</span>
            </a>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_exclusion_links() {
        ob_start();
        ?>
        <div class="lae-shortcode-wrapper lae-sc-exclusion-links">
            <a href="https://www.ordenacionjuego.es/participantes-juego/juego-seguro/rgiaj" class="lae-sc-card-link" target="_blank" rel="noopener noreferrer">
                <strong>RGIAJ / Autoprohibición</strong>
                <span>Información oficial y acceso al registro</span>
            </a>
            <a href="https://www.selae.es/es/web-corporativa/responsabilidad-social/gestion-responsable-del-juego/proteccion-a-menores" class="lae-sc-card-link" target="_blank" rel="noopener noreferrer">
                <strong>Protección a menores</strong>
                <span>Información oficial de SELAE</span>
            </a>
        </div>
        <?php
        return ob_get_clean();
    }
}

new LAE_Compliance_Shortcodes();