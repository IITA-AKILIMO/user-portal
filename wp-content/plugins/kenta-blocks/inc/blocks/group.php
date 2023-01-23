<?php

/**
 * Group block config
 *
 * @package Kenta Blocks
 */
$attributes = array_merge(
    array(
    'blockID' => array(
    'type' => 'string',
),
),
    kenta_blocks_container_global_style(),
    kenta_blocks_box_attrs(),
    kenta_blocks_overlay_attrs(),
    kenta_blocks_advanced_attrs()
);
$metadata = array(
    'title'       => __( 'Group (KB)', 'kenta-blocks' ),
    'description' => __( 'Gather blocks in a container.', 'kenta-blocks' ),
    'keywords'    => array(
    'group',
    'stack',
    'row',
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
    $css[".kb-group.kb-group-{$id}"] = array_merge(
        kenta_blocks_css()->border( kenta_blocks_block_attr( 'border', $attrs, $metadata ) ),
        kenta_blocks_css()->shadow( kenta_blocks_block_attr( 'shadow', $attrs, $metadata ) ),
        kenta_blocks_css()->background( kenta_blocks_block_attr( 'background', $attrs, $metadata ) ),
        kenta_blocks_css()->dimensions( kenta_blocks_block_attr( 'radius', $attrs, $metadata ), 'border-radius' ),
        kenta_blocks_container_global_css( $attrs, $metadata ),
        kenta_blocks_advanced_css( $attrs, $metadata )
    );
    $css[".kb-group-has-overlay.kb-group-{$id}::after"] = kenta_blocks_overlay_css( $attrs, $metadata );
    return $css;
},
);