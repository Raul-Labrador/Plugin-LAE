document.addEventListener("DOMContentLoaded", function() {
    var overlay = document.getElementById('lae-age-gate-overlay');
    var btnYes = document.getElementById('lae-btn-yes');
    var btnNo = document.getElementById('lae-btn-no');

    if (!overlay) return;

    // Función para leer cookies
    function getCookie(name) {
        var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        if (match) return match[2];
        return null;
    }

    // Comprobamos si ya ha aceptado (no mostramos si ya hay cookie)
    if (!getCookie('lae_age_verified')) {
        overlay.style.display = 'flex';
        document.body.classList.add('lae-no-scroll');
        
        // Evitamos que el botón SÍ se marque por defecto
        if (document.activeElement instanceof HTMLElement) {
            document.activeElement.blur();
        }
    }

    // Acción para SÍ
    if (btnYes) {
        btnYes.addEventListener('click', function() {
            var d = new Date();
            d.setTime(d.getTime() + (30 * 24 * 60 * 60 * 1000)); // 30 días
            document.cookie = "lae_age_verified=1; expires=" + d.toUTCString() + "; path=/; SameSite=Lax";
            
            overlay.style.display = 'none';
            document.body.classList.remove('lae-no-scroll');
        });
    }

    // Acción para NO
    if (btnNo) {
        btnNo.addEventListener('click', function() {
            window.location.href = "https://www.google.com";
        });
    }
});