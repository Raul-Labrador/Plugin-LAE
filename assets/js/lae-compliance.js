document.addEventListener("DOMContentLoaded", function () {
    var overlay = document.getElementById("lae-age-gate-overlay");
    var btnYes = document.getElementById("lae-btn-yes");
    var btnNo = document.getElementById("lae-btn-no");

    if (!overlay) return;

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
            return;
        }

        if (!isCookiesYesVisible()) {
            showAgeGate();
            return;
        }

        var tries = 0;
        var maxTries = 100; // ~20 segundos
        var interval = setInterval(function () {
            tries++;

            if (!isCookiesYesVisible()) {
                clearInterval(interval);
                showAgeGate();
                return;
            }

            if (tries >= maxTries) {
                clearInterval(interval);
                showAgeGate();
            }
        }, 200);
    }

    initAgeGate();

    if (btnYes) {
        btnYes.addEventListener("click", function () {
            setAgeCookie();
            hideAgeGate();
        });
    }

    if (btnNo) {
        btnNo.addEventListener("click", function () {
            window.location.href = "https://www.google.com";
        });
    }
});