<?php

/**
 * Column block config
 *
 * @package Kenta Blocks
 */
$attributes = array_merge(
    array(
    'blockID'           => array(
    'type' => 'string',
),
    'verticalAlignment' => array(
    'type' => 'string',
),
    'width'             => array(
    'type' => 'object',
),
),
    kenta_blocks_container_global_style(),
    kenta_blocks_box_attrs(),
    kenta_blocks_overlay_attrs(),
    kenta_blocks_shape_attrs(),
    kenta_blocks_advanced_attrs()
);
$metadata = array(
    'title'      => __( 'Column (KB)', 'kenta-blocks' ),
    'keywords'   => array( 'column' ),
    'parent'     => array( 'kenta-blocks/section' ),
    'supports'   => array(
    'anchor'   => true,
    'reusable' => false,
    'html'     => false,
),
    'attributes' => $attributes,
);
return array(
    'metadata' => $metadata,
    'css'      => function ( $id, $attrs, $css ) use( $metadata ) {
    $width = kenta_blocks_block_attr( 'width', $attrs, $metadata );
    $wrapperCss = array(
        '--kb-column-flex-grow' => ( $width ? 0 : 1 ),
        '--kb-column-width'     => $width,
        'z-index'               => kenta_blocks_block_attr( 'zIndex', $attrs, $metadata ),
    );
    $columnCss = array_merge(
        kenta_blocks_css()->border( kenta_blocks_block_attr( 'border', $attrs, $metadata ) ),
        kenta_blocks_css()->shadow( kenta_blocks_block_attr( 'shadow', $attrs, $metadata ) ),
        kenta_blocks_css()->background( kenta_blocks_block_attr( 'background', $attrs, $metadata ) ),
        kenta_blocks_css()->dimensions( kenta_blocks_block_attr( 'radius', $attrs, $metadata ), '--kb-border-radius' ),
        kenta_blocks_advanced_css( $attrs, $metadata, array( 'z-index', 'margin' ) )
    );
    $css[".kb-column-wrapper-{$id}"] = array_merge( $wrapperCss, kenta_blocks_container_global_css( $attrs, $metadata ) );
    $css[".kb-column-{$id}"] = $columnCss;
    $css[".kb-column-has-overlay.kb-column-{$id}::after"] = kenta_blocks_overlay_css( $attrs, $metadata );
    $shape_css = kenta_blocks_shape_css( ".kb-column-{$id} .kb-shape-divider", $attrs, $metadata );
    return array_merge( $css, $shape_css );
},
);