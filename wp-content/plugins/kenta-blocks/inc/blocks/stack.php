<?php

/**
 * Stack block config
 *
 * @package Kenta Blocks
 */
$attributes = array_merge(
    array(
    'blockID' => array(
    'type' => 'string',
),
    'justify' => array(
    'type'    => 'object',
    'default' => 'flex-start',
),
    'gap'     => array(
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
    'title'       => __( 'Stack (KB)', 'kenta-blocks' ),
    'description' => __( 'Arrange blocks vertically.', 'kenta-blocks' ),
    'keywords'    => array(
    'stack',
    'group',
    'stack',
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
    $css[".kb-stack.kb-stack-{$id}"] = array_merge(
        kenta_blocks_css()->border( kenta_blocks_block_attr( 'border', $attrs, $metadata ) ),
        kenta_blocks_css()->shadow( kenta_blocks_block_attr( 'shadow', $attrs, $metadata ) ),
        kenta_blocks_css()->background( kenta_blocks_block_attr( 'background', $attrs, $metadata ) ),
        kenta_blocks_css()->dimensions( kenta_blocks_block_attr( 'radius', $attrs, $metadata ), 'border-radius' ),
        kenta_blocks_container_global_css( $attrs, $metadata ),
        kenta_blocks_advanced_css( $attrs, $metadata )
    );
    $css[".kb-stack.kb-stack-{$id} > .kb-stack-inner-container"] = array(
        'align-items' => kenta_blocks_block_attr( 'justify', $attrs, $metadata ),
        'gap'         => kenta_blocks_block_attr( 'gap', $attrs, $metadata ),
    );
    $css[".kb-stack-has-overlay.kb-stack-{$id}::after"] = kenta_blocks_overlay_css( $attrs, $metadata );
    return $css;
},
);