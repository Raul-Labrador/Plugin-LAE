# lotto-lae-compliance

Informe de Fase 0: Investigación y Definición

Este documento recoge los resultados de la Fase 0, cumpliendo con los objetivos de recopilación normativa, auditoría de activos actuales y definición de requisitos funcionales para el cumplimiento legal de LAE. Su objetivo es servir como base de trabajo para las siguientes fases del proyecto.

## 1. Documento de Requisitos y Fuentes Legales

He creado esta lista detallada para tener una respuesta inmediata si alguien nos pregunta por qué implementamos cada función. Es la "traducción" de la ley al código y explica el motivo real detrás de cada pieza del plugin:

- Requisito: Bloqueo de menores (Age Gate) | Fuente: Art. 29 RD 958/2020.

    - Por qué lo ponemos: La ley es muy estricta: hay que evitar "proactivamente" que los menores entren en páginas de juego. No basta con un texto pequeño; necesitamos un sistema que bloquee la entrada hasta que el usuario confirme que es mayor de edad.

- Requisito: Identificación clara del operador (NIF/Titular) | Fuente: Art. 13 Ley 13/2011.

    - Por qué lo ponemos: Al vender juego online, el usuario tiene que saber en todo momento quién es el responsable legal de la administración. - Por qué lo ponemos: Al vender juego online, el usuario debe poder identificar claramente quién es el responsable de la administración. La visibilidad del titular y sus datos fiscales refuerza la transparencia y la identificación del operador.

- Requisito: Mensajes de Juego Responsable y Logos | Fuente: Art. 29.2 RD 958/2020.

    - Por qué lo ponemos: Los avisos de "Jugar con responsabilidad" no son opcionales. Tienen que estar en un lugar destacado (normalmente el footer) y acompañados de los sellos oficiales de la DGOJ ("Juego Seguro" y "Jugar Bien") para que el sitio se reconozca como seguro.

- Requisito: Acceso directo a la Autoexclusión (RGIAJ) | Fuente: Directrices Técnicas de la DGOJ.

    - Por qué lo ponemos: Si un usuario decide que quiere dejar de jugar por salud, tenemos la obligación de ponerle el enlace al Registro General de Interdicciones de Acceso al Juego a mano. Tiene que ser un acceso rápido para facilitar su derecho a la autoexclusión.

- Requisito: Ayuda emocional y teléfono 024 | Fuente: Mandato del Ministerio de Sanidad.

    - Por qué lo ponemos: Se ha integrado la línea 024 (ayuda contra la conducta suicida y apoyo emocional) como parte del compromiso de juego responsable. Es un requisito de protección social que debe estar visible junto a los recursos de ayuda al jugador.

- Requisito: Política de "No Devolución" de apuestas | Fuente: Art. 103.l Ley General de Consumidores.

    - Por qué lo ponemos: Mucha gente cree que puede devolver un décimo como si fuera una camiseta. Sin embargo, la ley excluye específicamente los servicios de juego del derecho de desistimiento. Hay que avisar de esto para proteger a la administración de reclamaciones.

- Requisito: Doble verificación de edad en la compra | Fuente: Protocolos de Verificación de SELAE.

    - Por qué lo ponemos: Aparte del aviso al entrar (Age Gate), SELAE exige que justo antes de pagar (en el checkout), el cliente vuelva a marcar una casilla confirmando su mayoría de edad. Es una capa extra de seguridad legal.

- Requisito: Aviso sobre la naturaleza del azar y probabilidades | Fuente: Ley 13/2011 y normativa DGOJ.

    - Por qué lo ponemos: Hay que informar de que los resultados son aleatorios y que no existen trucos para ganar. Esto suele ir en las páginas de producto o en el carrito para evitar que se cree una falsa expectativa de ganancia segura.

- Requisito: Protección de datos en contexto de juego (RGPD) | Fuente: Reglamento (UE) 2016/679.

    - Por qué lo ponemos: Al tratar datos sensibles (como el DNI para cobrar premios), el plugin debe asegurar que la política de privacidad mencione específicamente el tratamiento de datos para actividades de juego y la verificación de identidad.

## 2. Auditoría de Web Demo (demoloteria.testcomerline.me)

He realizado una auditoría a fondo de la web actual identificando los siguientes Gaps de Cumplimiento (puntos de mejora obligatorios):


### Leyenda de criticidad
| Gravedad | Indicador |
|---|---|
| **Crítico** | 🔴 |
| **Medio** | 🟠 |

***Verificación de Edad (Age Gate)***

> Estado: No existe.

> Gravedad: 🔴 Crítico.

**Observación:** El acceso al sitio es directo, permitiendo que menores de edad visualicen sorteos y productos de azar sin filtrado previo.

***Identificación del Operador (NIF/Titular)***

> Estado: Incompleto.

> Gravedad: 🟠 Medio.

**Observación:** Se menciona el número de administración, pero faltan los datos fiscales obligatorios del titular (Nombre y NIF) para garantizar la transparencia según la Ley 13/2011.

***Sellos Oficiales DGOJ (+18, Juego Seguro, Jugar Bien)***

> Estado: Ausente.

> Gravedad: 🔴 Crítico.
 

**Observación:** El pie de página carece de la iconografía oficial requerida. Estos sellos son mandatorios para la validez legal del sitio de venta online.

***Enlaces de Autoexclusión y acceso al RGIAJ***

> Estado: Ausente.

> Gravedad: 🔴 Crítico.

**Observación:** No existe una vía rápida y directa para que el usuario pueda solicitar su inscripción en el Registro General de Interdicciones de Acceso al Juego.

***Teléfono de Ayuda al Jugador (024)***

> Estado: Ausente.

> Gravedad: 🟠 Medio.

**Observación:** No se visualiza el número 024, obligatorio según las últimas directrices de juego responsable.

***Consentimiento de Edad en Proceso de Pago (Checkout)***

> Estado: Ausente.

> Gravedad: 🔴 Crítico.

**Observación:** El flujo de WooCommerce permite finalizar la compra sin que el cliente declare ser mayor de edad mediante un checkbox independiente.

***Aviso de azar y probabilidades***

> Estado: Ausente.

> Gravedad: 🟠 Medio.

**Observación:** No hay textos que expliquen que los sorteos son aleatorios y no hay garantía de premios (exigido para evitar publicidad engañosa).

***Página de "Juego Responsable" dedicada***

> Estado: No existe.

> Gravedad: 🔴 Crítico.

**Observación:** El RD 958/2020 obliga a tener una sección propia con consejos y recursos, no basta con una frase en el footer.

## 3. Definición de Contenidos: Fijos vs. Configurables

He dividido el contenido según su naturaleza para que el plugin sea reutilizable en todo el "fleet" de webs:

### 3.1. Textos Normativos Fijos (Hardcoded e i18n)

Estos textos no se permitirán editar desde el panel de WordPress para evitar alteraciones legales accidentales. Se implementarán mediante funciones de traducción __():

Aviso Menores (Minor Warning): "Prohibida la venta a menores de 18 años."

Eslogan Responsable (Responsible Slogan): "Si juegas, juega con responsabilidad. El juego puede crear adicción."

Info Ayuda (Helpline Info): "Atención al juego problemático: Teléfono 024."

Aviso de Azar (Probability Disclaimer): "Los juegos de lotería son juegos de azar. Juega con moderación y autocontrol."

Pie de Ticket Legal: "Esta apuesta es gestionada por la Administración de Loterías oficial indicada en el pie de página. El depósito y custodia del décimo se realiza bajo normativa estatal."

### 3.2. Datos Configurables y Reglas de Validación (Variables)

Datos inyectados mediante configure-wp.sh. Definiremos reglas estrictas para evitar datos "corruptos":

- lae_admin_name: Nombre comercial.

- lae_admin_number: Numérico, exactamente 5 dígitos.

- lae_holder_name: Nombre y apellidos del titular.

- lae_holder_nif: Formato NIF/CIF (Validación mediante Regex).

- lae_address: Dirección física completa (Calle, Número, CP, Localidad).

- lae_sale_type: Selector [Digital / Físico / Híbrido].

### 3.3. Configuración de Apariencia (Módulo de Estilos)

Color Primario: Para el fondo del Age Gate y la barra inferior.

Posición de la barra: Selector para Header o Footer.

Z-Index: Ajustable para asegurar que el Age Gate bloquee menús sticky.

## 4. Inventario de Bloques y Componentes Necesarios

### 4.1. Módulo Age Gate (Control de Acceso)

Funcionalidad: Interstitial modal session-based.

Comportamiento: Bloquea scroll del <body> mediante CSS (overflow: hidden).

Interacción: "Sí" (Cookie técnica) / "No" (Redirección a jugarbien.es).

Técnica: Vanilla JS para carga ultra-rápida.

### 4.2. Módulo Footer Bar (Barra de Cumplimiento)

Funcionalidad: Barra fija (sticky) en la base de la ventana.

Elementos: Logos SVG oficiales, Enlace RGIAJ, Teléfono 024 (formato tel:024).

### 4.3. Bloques Gutenberg y Shortcodes

Bloque: Identificación Operador: Tarjeta visual con datos del Art. 13.

Bloque: Juego Responsable: Banner visual con eslogan y logos.

Shortcodes: Soporte para [lae_operator_info] y [lae_responsible_footer].

### 4.4. Hooks de Integración con WooCommerce

Checkout Checkbox: Filtro woocommerce_checkout_fields.

Avisos de Producto: Hook woocommerce_single_product_summary.

Emails Transaccionales: Hook woocommerce_email_footer.

## 5. Notas sobre Contratos de Afiliación y Políticas de Devolución

He identificado matices críticos según la modalidad de venta:

### 5.1. Venta en Depósito (Digital Puro)

Naturaleza: El décimo queda custodiado. Se emite Certificado de Depósito.

Desistimiento: No aplicable (Art. 103.l Ley Consumidores).

Requisito: Página autogenerada de "Condiciones de Compra".

### 5.2. Envío Físico (Mensajería)

Naturaleza: Documento al portador enviado al cliente.

Responsabilidad: El riesgo se transfiere según el seguro contratado.

Requisito: Aviso legal en checkout sobre custodia post-entrega.

### 5.3. Venta Mixta / Recogida en Local

Seguridad: Obligatoriedad de presentar DNI original y comprobante.

## 6. Referencias y Recursos Oficiales

DGOJ - Juego Seguro: Web Oficial

Portal Jugar Bien: Web de Ayuda

RGIAJ (Autoexclusión): Acceso al Registro

SELAE (Loterías y Apuestas - Corporativo): Portal Corporativo

Centro de Ayuda - Teléfono 024: Línea 024 Sanidad

Este documento deja una base inicial de la Fase 0 y recoge los principales puntos identificados para preparar la Fase 1 (Arquitectura).