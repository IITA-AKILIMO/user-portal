<?php

/**
 * Row block config
 *
 * @package Kenta Blocks
 */
$attributes = array_merge(
    array(
    'blockID'    => array(
    'type' => 'string',
),
    'justify'    => array(
    'type'    => 'object',
    'default' => 'flex-start',
),
    'alignItems' => array(
    'type'    => 'object',
    'default' => 'center',
),
    'wrap'       => array(
    'type'    => 'string',
    'default' => 'no',
),
    'gap'        => array(
    'type'    => 'object',
    'default' => '12px',
),
),
    kenta_blocks_container_global_style(),
    kenta_blocks_box_attrs(),
    kenta_blocks_overlay_attrs(),
    kenta_blocks_advanced_attrs()
);
$metadata = array(
    'title'       => __( 'Row (KB)', 'kenta-blocks' ),
    'description' => __( 'Arrange blocks horizontally.', 'kenta-blocks' ),
    'keywords'    => array(
    'row',
    'stack',
    'group',
    'container'
),
    'supports'    => array(
    'anchor' => true,
    'align'  => array( 'wide', 'full' ),
    'html'   => false,
),
    'attributes'  => $attributes,
);
return array(
    'metadata' => $metadata,
    'css'      => function ( $id, $attrs, $css ) use( $metadata ) {
    $css[".kb-row.kb-row-{$id}"] = array_merge(
        kenta_blocks_css()->border( kenta_blocks_block_attr( 'border', $attrs, $metadata ) ),
        kenta_blocks_css()->shadow( kenta_blocks_block_attr( 'shadow', $attrs, $metadata ) ),
        kenta_blocks_css()->background( kenta_blocks_block_attr( 'background', $attrs, $metadata ) ),
        kenta_blocks_css()->dimensions( kenta_blocks_block_attr( 'radius', $attrs, $metadata ), 'border-radius' ),
        kenta_blocks_container_global_css( $attrs, $metadata ),
        kenta_blocks_advanced_css( $attrs, $metadata )
    );
    $css[".kb-row.kb-row-{$id} > .kb-row-inner-container"] = array(
        'justify-content' => kenta_blocks_block_attr( 'justify', $attrs, $metadata ),
        'align-items'     => kenta_blocks_block_attr( 'alignItems', $attrs, $metadata ),
        'flex-wrap'       => ( kenta_blocks_block_attr( 'wrap', $attrs, $metadata ) === 'yes' ? 'wrap' : 'nowrap' ),
        'gap'             => kenta_blocks_block_attr( 'gap', $attrs, $metadata ),
    );
    $css[".kb-row-has-overlay.kb-row-{$id}::after"] = kenta_blocks_overlay_css( $attrs, $metadata );
    return $css;
},
);