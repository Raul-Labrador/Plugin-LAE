document.addEventListener("DOMContentLoaded", function () {
    var overlay = document.getElementById("lae-age-gate-overlay");
    var btnYes = document.getElementById("lae-btn-yes");
    var btnNo = document.getElementById("lae-btn-no");
    var content = document.querySelector(".lae-age-gate-content");

    if (!overlay || !content) return;

    var originalContent = content.innerHTML;

    function getCookie(name) {
        var match = document.cookie.match(new RegExp("(^| )" + name + "=([^;]+)"));
        return match ? match[2] : null;
    }

    function setAgeCookie() {
        var d = new Date();
        d.setTime(d.getTime() + (30 * 24 * 60 * 60 * 1000));
        document.cookie = "lae_age_verified=1; expires=" + d.toUTCString() + "; path=/; SameSite=Lax";
    }

    function showAgeGate() {
        overlay.style.display = "flex";
        document.body.classList.add("lae-no-scroll");

        if (document.activeElement instanceof HTMLElement) {
            document.activeElement.blur();
        }
    }

    function hideAgeGate() {
        overlay.style.display = "none";
        document.body.classList.remove("lae-no-scroll");
    }

    function showDeniedMessage() {
        sessionStorage.setItem("lae_age_denied", "1");

        content.innerHTML = `
            <div class="lae-age-denied-message">
                <h1 id="lae-age-title" class="lae-age-title">Acceso no permitido</h2>
                <div class="lae-age-text">
                    <p>Lo sentimos, este sitio está restringido a mayores de 18 años.</p>
                    <p>No puedes acceder al contenido.</p>
                </div>
            </div>
        `;

        showAgeGate();
    }

    function restoreOriginalAgeGate() {
        content.innerHTML = originalContent;

        btnYes = document.getElementById("lae-btn-yes");
        btnNo = document.getElementById("lae-btn-no");

        bindButtons();
    }

    function isCookiesYesVisible() {
        var selectors = [
            "#cookie-law-info-bar",
            ".cky-consent-container",
            ".cky-banner-container",
            ".cky-modal",
            ".cli-bar-container",
            ".cky-notice"
        ];

        for (var i = 0; i < selectors.length; i++) {
            var el = document.querySelector(selectors[i]);

            if (el) {
                var style = window.getComputedStyle(el);
                var visible =
                    style.display !== "none" &&
                    style.visibility !== "hidden" &&
                    style.opacity !== "0" &&
                    el.offsetHeight > 0 &&
                    el.offsetWidth > 0;

                if (visible) {
                    return true;
                }
            }
        }

        return false;
    }

    function initAgeGate() {
        if (getCookie("lae_age_verified")) {
            hideAgeGate();
            return;
        }

        // Si se ha recargado o cambiado de página, volvemos al popup normal
        sessionStorage.removeItem("lae_age_denied");
        restoreOriginalAgeGate();

        // Mostramos el popup inmediatamente, sin esperar a ningún plugin de cookies
        showAgeGate();
    }

    function bindButtons() {
        if (btnYes) {
            btnYes.addEventListener("click", function () {
                setAgeCookie();
                hideAgeGate();
            });
        }

        if (btnNo) {
            btnNo.addEventListener("click", function () {
                showDeniedMessage();
            });
        }
    }

    bindButtons();
    initAgeGate();
});