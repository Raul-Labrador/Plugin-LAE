(function(wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var el = wp.element.createElement;
    var ServerSideRender = wp.serverSideRender;

    // Función auxiliar para registrar nuestros bloques rápido
    function registerLAEBlock(name, title, icon) {
        registerBlockType('lae/' + name, {
            title: title,
            icon: icon,
            category: 'widgets',
            edit: function(props) {
                // Esto hace la magia: pide el HTML directamente a tu archivo render.php
                return el(ServerSideRender, {
                    block: 'lae/' + name,
                    attributes: props.attributes
                });
            },
            save: function() {
                // Al ser bloques dinámicos (PHP), el guardado en base de datos es null
                return null; 
            }
        });
    }

    // Registramos los 5 bloques en la interfaz
    registerLAEBlock('age-warning', 'Aviso +18 LAE', 'warning');
    registerLAEBlock('exclusion-links', 'Enlaces Autoexclusión', 'external');
    registerLAEBlock('operator-info', 'Datos del Operador LAE', 'id');
    registerLAEBlock('responsible-gaming', 'Banner Juego Responsable', 'shield');
    registerLAEBlock('probability-disclaimer', 'Aviso de Probabilidades', 'info');

})(window.wp);