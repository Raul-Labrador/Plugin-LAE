/**
 * Lógica del Age Gate para Lotto LAE Compliance
 */
document.addEventListener('DOMContentLoaded', function() {
    
    const modal = document.getElementById('lae-age-gate-modal');
    const btnYes = document.getElementById('lae-btn-age-yes');
    const btnNo = document.getElementById('lae-btn-age-no');
    const cookieName = 'lae_age_verified';

    function getCookie(name) {
        let nameEQ = name + "=";
        let ca = document.cookie.split(';');
        for(let i=0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }

    if (!getCookie(cookieName)) {
        if (modal) {
            modal.style.display = 'flex';
            document.body.classList.add('lae-no-scroll'); 
        }
    }

    if (btnYes) {
        btnYes.addEventListener('click', function() {
            setCookie(cookieName, 'true', 30); 
            if (modal) {
                modal.style.display = 'none';
            }
            document.body.classList.remove('lae-no-scroll'); 
        });
    }

    if (btnNo) {
        btnNo.addEventListener('click', function() {
            window.location.href = "https://www.jugarbien.es/";
        });
    }

});