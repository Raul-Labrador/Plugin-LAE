document.addEventListener("DOMContentLoaded", function () {
    var overlay = document.getElementById("lae-age-gate-overlay");
    var btnYes = document.getElementById("lae-btn-yes");
    var btnNo = document.getElementById("lae-btn-no");
    var content = document.querySelector(".lae-age-gate-content");

    if (!overlay || !content) return;

    var originalContent = content.innerHTML;

    var i18n = window.laeComplianceI18n || {
        deniedTitle: "Acceso no permitido",
        deniedLine1: "Lo sentimos, este sitio está restringido a mayores de 18 años.",
        deniedLine2: "No puedes acceder al contenido."
    };

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
                <h1 id="lae-age-title" class="lae-age-title">${i18n.deniedTitle}</h1>
                <div class="lae-age-text">
                    <p>${i18n.deniedLine1}</p>
                    <p>${i18n.deniedLine2}</p>
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

    function initAgeGate() {
        if (getCookie("lae_age_verified")) {
            hideAgeGate();
            return;
        }

        sessionStorage.removeItem("lae_age_denied");
        restoreOriginalAgeGate();

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
});S