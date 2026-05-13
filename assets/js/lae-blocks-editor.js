(function(wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var el = wp.element.createElement;
    var ServerSideRender = wp.serverSideRender;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var components = wp.components;
    var PanelBody = components.PanelBody;
    var SelectControl = components.SelectControl;

    // Function to register blocks that have NO configuration
    function registerLAEBlock(name, title, icon) {
        registerBlockType('lae/' + name, {
            title: title,
            icon: icon,
            category: 'widgets',
            edit: function(props) {
                return el(ServerSideRender, { block: 'lae/' + name, attributes: props.attributes });
            },
            save: function() { return null; }
        });
    }

    registerLAEBlock('age-warning', 'Aviso +18 LAE', 'warning');
    registerLAEBlock('exclusion-links', 'Enlaces Autoexclusión', 'external');
    registerLAEBlock('operator-info', 'Datos del Operador LAE', 'id');

    // Responsible Gaming Banner (SIZE Settings)
    registerBlockType('lae/responsible-gaming', {
        title: 'Banner Juego Responsable',
        icon: 'shield',
        category: 'widgets',
        attributes: {
            size: { type: 'string', default: 'medium' }
        },
        edit: function(props) {
            return el(wp.element.Fragment, {},
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Configuración del Banner' },
                        el(SelectControl, {
                            label: 'Tamaño del Banner',
                            value: props.attributes.size,
                            options: [
                                { label: 'Pequeño', value: 'small' },
                                { label: 'Mediano', value: 'medium' },
                                { label: 'Grande', value: 'large' }
                            ],
                            onChange: function(newSize) { props.setAttributes({ size: newSize }); }
                        })
                    )
                ),
                el(ServerSideRender, { block: 'lae/responsible-gaming', attributes: props.attributes })
            );
        },
        save: function() { return null; }
    });

    // Probabilities Notice (DRAWING Settings)
    registerBlockType('lae/probability-disclaimer', {
        title: 'Aviso de Probabilidades',
        icon: 'info',
        category: 'widgets',
        attributes: {
            sorteo: { type: 'string', default: 'loteria-nacional' }
        },
        edit: function(props) {
            return el(wp.element.Fragment, {},
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Configuración del Aviso' },
                        el(SelectControl, {
                            label: 'Sorteo a mostrar',
                            value: props.attributes.sorteo,
                            options: [
                                { label: 'Lotería Nacional', value: 'loteria-nacional' },
                                { label: 'Euromillones', value: 'euromillones' },
                                { label: 'La Primitiva', value: 'primitiva' },
                                { label: 'Bonoloto', value: 'bonoloto' },
                                { label: 'La Quiniela', value: 'quiniela' }
                            ],
                            onChange: function(newSorteo) { props.setAttributes({ sorteo: newSorteo }); }
                        })
                    )
                ),
                el(ServerSideRender, { block: 'lae/probability-disclaimer', attributes: props.attributes })
            );
        },
        save: function() { return null; }
    });

})(window.wp);