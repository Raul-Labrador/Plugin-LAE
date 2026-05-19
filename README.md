# 🎰 Lotto LAE Compliance — WordPress Plugin

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=flat-square&logo=php&logoColor=white)
![WordPress](https://img.shields.io/badge/WordPress-Plugin-21759B?style=flat-square&logo=wordpress&logoColor=white)
![WooCommerce](https://img.shields.io/badge/WooCommerce-Compatible-96588A?style=flat-square&logo=woocommerce&logoColor=white)
![License](https://img.shields.io/badge/License-Proprietary-red?style=flat-square)
![Status](https://img.shields.io/badge/Status-Production-brightgreen?style=flat-square)

> Plugin de WordPress desarrollado en prácticas profesionales para garantizar el **cumplimiento normativo y legal** de las administraciones de Loterías y Apuestas del Estado (LAE) en España.

---

## 📋 Descripción

Lotto LAE Compliance centraliza toda la gestión de **obligaciones legales** que deben cumplir las administraciones de lotería con presencia online en España: verificación de edad, avisos de juego responsable, páginas legales y avisos en el flujo de compra. Se integra de forma nativa con **WooCommerce** y el editor de bloques **Gutenberg**, sin modificar plantillas del tema.

---

## ⚙️ Tecnologías

| Capa | Tecnologías |
|------|------------|
| Backend | PHP · WordPress Hooks · Shortcodes · WP-CLI |
| Frontend | JavaScript · CSS3 |
| Infraestructura | Bash · JSON · `jq` |

---

## ✨ Funcionalidades

### 🔞 Verificación de Edad (Age Gate)
Muro de verificación para mayores de 18 con máxima prioridad visual (`z-index`) para evitar conflictos con banners de cookies (CookieYes, etc.) y garantizar el bloqueo real de la web hasta su aceptación explícita.

### 🛒 Integración con WooCommerce
Inyección de avisos legales en el flujo de compra completo **mediante hooks**, sin alterar plantillas:
- Avisos de probabilidades en fichas de producto
- Políticas de devolución en el carrito
- Checkbox obligatorio de verificación de edad en el checkout

### 🧩 Bloques Gutenberg & Shortcodes
Componentes reutilizables que permiten a los editores insertar desde el panel nativo de WordPress:
- Bloques de **Juego Responsable** con tamaños dinámicos
- **Avisos de Probabilidad** adaptados a sorteos específicos (Euromillones, Primitiva, Bonoloto, etc.)

### 🛠️ Panel de Administración
Interfaz nativa y amigable para el administrador del sitio. Todos los ajustes (datos del operador, colores corporativos heredados del tema, comportamiento sticky del footer) se persisten en un **único array serializado** en base de datos para maximizar el rendimiento.

### 🚀 Despliegue Masivo Automatizado
Scripts de infraestructura en **Bash** que leen configuraciones desde un archivo `.json` usando `jq` e inyectan datos vía **WP-CLI**, permitiendo el despliegue automático del plugin y sus páginas legales en **cientos de sitios simultáneamente**.

---

## 🚀 Instalación

### Opción A — Panel de WordPress (Recomendado)

1. Descarga este repositorio como `.zip` (`Code → Download ZIP`).
2. En tu WordPress, ve a **Plugins → Añadir nuevo → Subir plugin**.
3. Sube el `.zip` y actívalo.
4. Navega al nuevo menú **Cumplimiento LAE** en la barra lateral.
5. Introduce los datos de la administración y personaliza el diseño.

### Opción B — Despliegue Masivo con WP-CLI

```bash
# 1. Configura tus sitios en el archivo de configuración
cp config.example.json config.json

# 2. Edita config.json con los datos de cada administración
# 3. Ejecuta el script de despliegue
bash deploy.sh config.json
```

---

## 📁 Estructura del proyecto

```
plugin-lae/
├── plugin-lae.php          # Archivo principal del plugin
├── includes/
│   ├── age-gate.php        # Lógica de verificación de edad
│   ├── woocommerce.php     # Hooks e integración con WooCommerce
│   └── admin-panel.php     # Panel de opciones
├── blocks/                 # Bloques de Gutenberg
├── assets/
│   ├── css/
│   └── js/
└── deploy/
    ├── deploy.sh           # Script de despliegue masivo
    └── config.example.json # Plantilla de configuración
```

---

## 👨‍💻 Contexto

Desarrollado durante las **prácticas profesionales en [Comerline](https://comerline.es)** (Feb 2026 – May 2026), empresa especializada en soluciones eCommerce para el sector de loterías en España.

---

## 📄 Licencia

Este proyecto es de uso propietario. El código se comparte con fines de portfolio. No está permitida su distribución o uso comercial sin autorización expresa del autor.
