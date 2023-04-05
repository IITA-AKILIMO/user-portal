<?php

/**
 * Cover block config
 *
 * @package Kenta Blocks
 */
$attributes = array_merge(
    array(
    'blockID'      => array(
    'type' => 'string',
),
    'minHeight'    => array(
    'type'    => 'object',
    'default' => '300px',
),
    'contentWidth' => array(
    'type'    => 'object',
    'default' => array(
    'desktop' => '1140px',
    'tablet'  => '768px',
    'mobile'  => '576px',
),
),
    'alignItems'   => array(
    'type'    => 'object',
    'default' => 'center',
),
),
    kenta_blocks_container_global_style(),
    kenta_blocks_box_attrs(),
    kenta_blocks_overlay_attrs( array(
    'overlay' => 'yes',
) ),
    kenta_blocks_shape_attrs(),
    kenta_blocks_advanced_attrs( array(
    'padding' => array(
    'linked' => true,
    'top'    => '24px',
    'right'  => '24px',
    'bottom' => '24px',
    'left'   => '24px',
),
) )
);
$metadata = array(
    'title'      => __( 'Cover (KB)', 'kenta-blocks' ),
    'keywords'   => array( 'cover', 'hero' ),
    'supports'   => array(
    'anchor' => true,
    'align'  => array( 'wide', 'full' ),
),
    'attributes' => $attributes,
);
return array(
    'metadata' => $metadata,
    'css'      => function ( $id, $attrs, $css ) use( $metadata ) {
    $css[".kb-cover.kb-cover-{$id}"] = array_merge(
        kenta_blocks_css()->border( kenta_blocks_block_attr( 'border', $attrs, $metadata ) ),
        kenta_blocks_css()->shadow( kenta_blocks_block_attr( 'shadow', $attrs, $metadata ) ),
        kenta_blocks_css()->background( kenta_blocks_block_attr( 'background', $attrs, $metadata ) ),
        kenta_blocks_css()->dimensions( kenta_blocks_block_attr( 'radius', $attrs, $metadata ), 'border-radius' ),
        kenta_blocks_container_global_css( $attrs, $metadata ),
        kenta_blocks_advanced_css( $attrs, $metadata, array( 'padding' ) ),
        array(
        'align-items'                => kenta_blocks_block_attr( 'alignItems', $attrs, $metadata ),
        '--kb-cover-inner-max-width' => kenta_blocks_block_attr( 'contentWidth', $attrs, $metadata ),
        '--kb-cover-min-height'      => kenta_blocks_block_attr( 'minHeight', $attrs, $metadata ),
    )
    );
    $css[".kb-cover-{$id} .kb-cover-inner-container"] = kenta_blocks_css()->dimensions( kenta_blocks_block_attr( 'padding', $attrs, $metadata ), 'padding' );
    $css[".kb-cover-has-overlay.kb-cover-{$id}::after"] = kenta_blocks_overlay_css( $attrs, $metadata );
    $shape_css = kenta_blocks_shape_css( ".kb-cover-{$id} .kb-shape-divider", $attrs, $metadata );
    return array_merge( $css, $shape_css );
},
);