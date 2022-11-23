<?php

/**
 * Button block config
 *
 * @package Kenta Blocks
 */
$attributes = array(
    'blockID'      => array(
    'type' => 'string',
),
    'anchor'       => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'attribute' => 'id',
    'selector'  => 'a',
),
    'url'          => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'selector'  => 'a',
    'attribute' => 'href',
    'default'   => '',
),
    'text'         => array(
    'type'     => 'string',
    'source'   => 'html',
    'selector' => '.kb-button span',
),
    'linkTarget'   => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'selector'  => 'a',
    'attribute' => 'target',
),
    'rel'          => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'selector'  => 'a',
    'attribute' => 'rel',
),
    'hasIcon'      => array(
    'type'    => 'string',
    'default' => 'no',
),
    'icon'         => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'selector'  => 'i',
    'attribute' => 'class',
    'default'   => 'fas fa-star',
),
    'iconPosition' => array(
    'enum'    => array( 'left', 'right' ),
    'default' => 'left',
),
    'justify'      => array(
    'type'    => 'object',
    'default' => 'center',
),
    'preset'       => array(
    'type'    => 'string',
    'default' => 'primary',
),
    'width'        => array(
    'type' => 'object',
),
    'radius'       => array(
    'type'    => 'object',
    'default' => array(
    'top'    => '2px',
    'right'  => '2px',
    'bottom' => '2px',
    'left'   => '2px',
    'linked' => true,
),
),
    'padding'      => array(
    'type'    => 'object',
    'default' => array(
    'top'    => '12px',
    'right'  => '16px',
    'bottom' => '12px',
    'left'   => '16px',
),
),
);
$metadata = array(
    'title'      => __( 'Button (KB)', 'kenta-blocks' ),
    'keywords'   => array( 'link', 'button', 'buttons' ),
    'parent'     => array( 'kenta-blocks/buttons' ),
    'supports'   => array(
    'anchor' => true,
),
    'attributes' => $attributes,
);
if ( !function_exists( 'kenta_blocks_button_preset' ) ) {
    /**
     * Get button preset style
     *
     * @param $style
     *
     * @return array
     */
    function kenta_blocks_button_preset( $style )
    {
        $presets = array(
            'ghost'   => array(
            'textColor'   => array(
            'initial' => 'currentColor',
            'hover'   => 'currentColor',
        ),
            'buttonColor' => array(
            'initial' => 'var(--kb-transparent)',
            'hover'   => 'var(--kb-transparent)',
        ),
            'border'      => array(
            'style' => 'none',
            'width' => 2,
            'color' => 'var(--kb-primary-color)',
            'hover' => 'var(--kb-primary-active)',
        ),
        ),
            'solid'   => array(
            'textColor'   => array(
            'initial' => 'var(--kb-base-color)',
            'hover'   => 'var(--kb-base-color)',
        ),
            'buttonColor' => array(
            'initial' => 'var(--kb-primary-color)',
            'hover'   => 'var(--kb-accent-color)',
        ),
            'border'      => array(
            'style' => 'solid',
            'width' => 2,
            'color' => 'var(--kb-primary-color)',
            'hover' => 'var(--kb-accent-color)',
        ),
        ),
            'outline' => array(
            'textColor'   => array(
            'initial' => 'var(--kb-primary-color)',
            'hover'   => 'var(--kb-base-color)',
        ),
            'buttonColor' => array(
            'initial' => 'var(--kb-transparent)',
            'hover'   => 'var(--kb-primary-color)',
        ),
            'border'      => array(
            'style' => 'solid',
            'width' => 2,
            'color' => 'var(--kb-primary-color)',
            'hover' => 'var(--kb-primary-color)',
        ),
        ),
            'invert'  => array(
            'textColor'   => array(
            'initial' => 'var(--kb-base-color)',
            'hover'   => 'var(--kb-base-color)',
        ),
            'buttonColor' => array(
            'initial' => 'var(--kb-accent-color)',
            'hover'   => 'var(--kb-primary-color)',
        ),
            'border'      => array(
            'style' => 'solid',
            'width' => 2,
            'color' => 'var(--kb-accent-color)',
            'hover' => 'var(--kb-primary-color)',
        ),
        ),
            'primary' => array(
            'textColor'   => array(
            'initial' => 'var(--kb-base-color)',
            'hover'   => 'var(--kb-base-color)',
        ),
            'buttonColor' => array(
            'initial' => 'var(--kb-primary-color)',
            'hover'   => 'var(--kb-primary-active)',
        ),
            'border'      => array(
            'style' => 'solid',
            'width' => 2,
            'color' => 'var(--kb-primary-color)',
            'hover' => 'var(--kb-primary-active)',
        ),
        ),
            'accent'  => array(
            'textColor'   => array(
            'initial' => 'var(--kb-base-color)',
            'hover'   => 'var(--kb-base-color)',
        ),
            'buttonColor' => array(
            'initial' => 'var(--kb-accent-color)',
            'hover'   => 'var(--kb-accent-active)',
        ),
            'border'      => array(
            'style' => 'solid',
            'width' => 2,
            'color' => 'var(--kb-accent-color)',
            'hover' => 'var(--kb-accent-active)',
        ),
        ),
        );
        return $presets[$style] ?? array();
    }

}
if ( !function_exists( 'kenta_blocks_button_css' ) ) {
    /**
     * Generate button style
     *
     * @param array $attrs
     * @param array $metadata
     * @param array $button_css
     *
     * @return array|mixed
     */
    function kenta_blocks_button_css( $attrs, $metadata, $button_css = array() )
    {
        $preset = kenta_blocks_button_preset( kenta_blocks_block_attr( 'preset', $attrs, $metadata ) );
        if ( isset( $preset['textColor'] ) ) {
            $button_css = kenta_blocks_css()->colors( $preset['textColor'], array(
                'initial' => '--kb-button-text-initial-color',
                'hover'   => '--kb-button-text-hover-color',
            ), $button_css );
        }
        if ( isset( $preset['buttonColor'] ) ) {
            $button_css = kenta_blocks_css()->colors( $preset['buttonColor'], array(
                'initial' => '--kb-button-initial-color',
                'hover'   => '--kb-button-hover-color',
            ), $button_css );
        }
        if ( isset( $preset['border'] ) ) {
            $button_css = array_merge( $button_css, kenta_blocks_css()->border( $preset['border'], '--kb-button-border' ) );
        }
        // padding
        return array_merge( $button_css, kenta_blocks_css()->dimensions( kenta_blocks_block_attr( 'radius', $attrs, $metadata ), '--kb-button-radius' ), kenta_blocks_css()->dimensions( kenta_blocks_block_attr( 'padding', $attrs, $metadata ), '--kb-button-padding' ) );
    }

}
return array(
    'metadata' => $metadata,
    'css'      => function ( $id, $attrs, $css ) use( $metadata ) {
    $wrapper_css = array(
        'width' => $attrs['width'] ?? null,
    );
    $button_css = kenta_blocks_button_css( $attrs, $metadata, array(
        'justify-content' => kenta_blocks_block_attr( 'justify', $attrs, $metadata ),
    ) );
    $css[".kb-button-wrapper-{$id}"] = $wrapper_css;
    $css[".kb-button-{$id}"] = $button_css;
    return $css;
},
);