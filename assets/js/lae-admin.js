document.addEventListener("DOMContentLoaded", function() {
    var form = document.querySelector('form[action="options.php"]');

    var i18n = window.laeAdminI18n || {
        restoring: "Restaurando...",
        restoreDefault: "↺ Restaurar por defecto"
    };

    function autoSubmit() {
        if (form) {
            var submitBtn = form.querySelector('input[type="submit"]');
            if (submitBtn) {
                submitBtn.value = i18n.restoring;
                submitBtn.click();
            }
        }
    }

    var resetFields = [
        'lae_compliance_options[reset_age_gate_defaults]',
        'lae_compliance_options[reset_footer_defaults]'
    ];

    resetFields.forEach(function(fieldName) {
        var checkbox = document.querySelector('input[name="' + fieldName + '"]');

        if (checkbox) {
            var label = checkbox.closest('.lae-switch-label') || checkbox.parentNode;

            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'button button-secondary';
            btn.style.color = '#d63638';
            btn.style.borderColor = '#d63638';
            btn.innerHTML = i18n.restoreDefault;

            btn.addEventListener('click', function(e) {
                e.preventDefault();
                checkbox.checked = true;
                autoSubmit();
            });

            label.style.display = 'none';
            label.parentNode.insertBefore(btn, label);
        }
    });
});