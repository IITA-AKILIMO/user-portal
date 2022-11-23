<?php

/**
 * Section block config
 *
 * @package Kenta Blocks
 */
$attributes = array_merge(
    array(
    'blockID'        => array(
    'type' => 'string',
),
    'boxedContainer' => array(
    'type'    => 'string',
    'default' => 'no',
),
    'contentWidth'   => array(
    'type'    => 'object',
    'default' => array(
    'desktop' => '1140px',
    'tablet'  => '768px',
    'mobile'  => '576px',
),
),
    'direction'      => array(
    'type'    => 'object',
    'default' => 'row',
),
    'alignItems'     => array(
    'type'    => 'object',
    'default' => 'flex-start',
),
    'wrap'           => array(
    'type'    => 'string',
    'default' => 'yes',
),
    'gap'            => array(
    'type'    => 'object',
    'default' => '12px',
),
),
    kenta_blocks_container_global_style(),
    kenta_blocks_box_attrs(),
    kenta_blocks_overlay_attrs(),
    kenta_blocks_shape_attrs(),
    kenta_blocks_advanced_attrs( array(
    'padding' => array(
    'linked' => true,
    'top'    => '12px',
    'right'  => '12px',
    'bottom' => '12px',
    'left'   => '12px',
),
) )
);
$metadata = array(
    'title'      => __( 'Section (KB)', 'kenta-blocks' ),
    'keywords'   => array(
    'section',
    'column',
    'columns',
    'row'
),
    'supports'   => array(
    'anchor' => true,
    'align'  => array( 'wide', 'full' ),
    'html'   => false,
),
    'attributes' => $attributes,
);
return array(
    'metadata' => $metadata,
    'css'      => function ( $id, $attrs, $css ) use( $metadata ) {
    $isBoxed = kenta_blocks_block_attr( 'boxedContainer', $attrs, $metadata ) === 'yes';
    $containerStyle = array_merge( array(
        'align-items' => $attrs['alignItems'] ?? null,
        'flex-wrap'   => ( ($attrs['wrap'] ?? 'yes') == 'yes' ? 'wrap' : 'no-wrap' ),
    ), kenta_blocks_css()->dimensions( kenta_blocks_block_attr( 'padding', $attrs, $metadata ), 'padding' ) );
    if ( $isBoxed ) {
        $css[".kb-section-{$id} .kb-section-container"] = array_merge( $containerStyle, array(
            'max-width' => kenta_blocks_block_attr( 'contentWidth', $attrs, $metadata ),
        ) );
    }
    $css[".kb-section-{$id}"] = array_merge(
        ( $isBoxed ? array() : $containerStyle ),
        array(
        '--kb-columns-gap' => $attrs['gap'] ?? null,
    ),
        kenta_blocks_css()->border( kenta_blocks_block_attr( 'border', $attrs, $metadata ) ),
        kenta_blocks_css()->shadow( kenta_blocks_block_attr( 'shadow', $attrs, $metadata ) ),
        kenta_blocks_css()->background( kenta_blocks_block_attr( 'background', $attrs, $metadata ) ),
        kenta_blocks_css()->dimensions( kenta_blocks_block_attr( 'radius', $attrs, $metadata ), '--kb-border-radius' ),
        kenta_blocks_container_global_css( $attrs, $metadata ),
        kenta_blocks_advanced_css( $attrs, $metadata, array( 'padding' ) )
    );
    $css[".kb-section-has-overlay.kb-section-{$id}::after"] = kenta_blocks_overlay_css( $attrs, $metadata );
    $shape_css = kenta_blocks_shape_css( ".kb-section-{$id} .kb-shape-divider", $attrs, $metadata );
    return array_merge( $css, $shape_css );
},
);