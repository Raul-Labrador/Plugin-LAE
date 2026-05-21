(function(wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var el = wp.element.createElement;
    var ServerSideRender = wp.serverSideRender;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var components = wp.components;
    var PanelBody = components.PanelBody;
    var SelectControl = components.SelectControl;
    var __ = wp.i18n.__;

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

    registerLAEBlock('age-warning', __('Aviso +18 LAE', 'lotto-lae-compliance'), 'warning');
    registerLAEBlock('exclusion-links', __('Enlaces Autoexclusión', 'lotto-lae-compliance'), 'external');
    

    registerBlockType('lae/responsible-gaming', {
        title: __('Banner Juego Responsable', 'lotto-lae-compliance'),
        icon: 'shield',
        category: 'widgets',
        attributes: {
            size: { type: 'string', default: 'medium' }
        },
        edit: function(props) {
            return el(wp.element.Fragment, {},
                el(InspectorControls, {},
                    el(PanelBody, { title: __('Configuración del Banner', 'lotto-lae-compliance') },
                        el(SelectControl, {
                            label: __('Tamaño del Banner', 'lotto-lae-compliance'),
                            value: props.attributes.size,
                            options: [
                                { label: __('Pequeño', 'lotto-lae-compliance'), value: 'small' },
                                { label: __('Mediano', 'lotto-lae-compliance'), value: 'medium' },
                                { label: __('Grande', 'lotto-lae-compliance'), value: 'large' }
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
        title: __('Aviso de Probabilidades', 'lotto-lae-compliance'),
        icon: 'info',
        category: 'widgets',
        attributes: {
            sorteo: { type: 'string', default: 'loteria-nacional' }
        },
        edit: function(props) {
            return el(wp.element.Fragment, {},
                el(InspectorControls, {},
                    el(PanelBody, { title: __('Configuración del Aviso', 'lotto-lae-compliance') },
                        el(SelectControl, {
                            label: __('Sorteo a mostrar', 'lotto-lae-compliance'),
                            value: props.attributes.sorteo,
                            options: [
                                { label: __('Lotería Nacional', 'lotto-lae-compliance'), value: 'loteria-nacional' },
                                { label: __('Euromillones', 'lotto-lae-compliance'), value: 'euromillones' },
                                { label: __('La Primitiva', 'lotto-lae-compliance'), value: 'primitiva' },
                                { label: __('Bonoloto', 'lotto-lae-compliance'), value: 'bonoloto' },
                                { label: __('La Quiniela', 'lotto-lae-compliance'), value: 'quiniela' }
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