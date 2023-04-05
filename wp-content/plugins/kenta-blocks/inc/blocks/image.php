<?php

/**
 * Image block config
 *
 * @package Kenta Blocks
 */
$attributes = array_merge( array(
    'blockID'    => array(
    'type' => 'string',
),
    'id'         => array(
    'type' => 'number',
),
    'url'        => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'selector'  => 'img',
    'attribute' => 'src',
),
    'alt'        => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'selector'  => 'img',
    'attribute' => 'alt',
),
    'caption'    => array(
    'type'     => 'string',
    'source'   => 'html',
    'selector' => 'figcaption',
),
    'title'      => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'selector'  => 'img',
    'attribute' => 'title',
),
    'alignment'  => array(
    'type' => 'object',
),
    'sizeSlug'   => array(
    'type'    => 'string',
    'default' => '',
),
    'width'      => array(
    'type' => 'object',
),
    'maxWidth'   => array(
    'type' => 'object',
),
    'height'     => array(
    'type' => 'object',
),
    'objectFit'  => array(
    'type' => 'object',
),
    'opacity'    => array(
    'type' => 'object',
),
    'href'       => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'selector'  => 'figure > a',
    'attribute' => 'href',
),
    'linkTarget' => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'selector'  => 'figure > a',
    'attribute' => 'target',
),
    'rel'        => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'selector'  => 'figure > a',
    'attribute' => 'rel',
),
    'cssFilter'  => array(
    'type' => 'object',
),
), kenta_blocks_box_attrs(), kenta_blocks_advanced_attrs() );
$metadata = array(
    'title'      => __( 'Image (KB)', 'kenta-blocks' ),
    'keywords'   => array( 'image', 'media' ),
    'supports'   => array(
    'anchor' => true,
    'align'  => array( 'wide', 'full' ),
),
    'attributes' => $attributes,
);
return array(
    'metadata' => $metadata,
    'css'      => function ( $id, $attrs, $css ) use( $metadata ) {
    $css[".kb-image.kb-image-{$id}"] = array_merge( array(
        'text-align' => kenta_blocks_block_attr( 'alignment', $attrs, $metadata ),
    ), kenta_blocks_css()->background( kenta_blocks_block_attr( 'background', $attrs, $metadata ) ), kenta_blocks_advanced_css( $attrs, $metadata ) );
    $css[".kb-image.kb-image-{$id} img"] = array_merge(
        array(
        'width'      => kenta_blocks_block_attr( 'width', $attrs, $metadata ),
        'max-width'  => kenta_blocks_block_attr( 'maxWidth', $attrs, $metadata ),
        'height'     => kenta_blocks_block_attr( 'height', $attrs, $metadata ),
        'opacity'    => kenta_blocks_block_attr( 'opacity', $attrs, $metadata ),
        'object-fit' => kenta_blocks_block_attr( 'objectFit', $attrs, $metadata ),
    ),
        kenta_blocks_css()->filter( kenta_blocks_block_attr( 'cssFilter', $attrs, $metadata ) ),
        kenta_blocks_css()->border( kenta_blocks_block_attr( 'border', $attrs, $metadata ) ),
        kenta_blocks_css()->shadow( kenta_blocks_block_attr( 'shadow', $attrs, $metadata ) ),
        kenta_blocks_css()->dimensions( kenta_blocks_block_attr( 'radius', $attrs, $metadata ), 'border-radius' )
    );
    return $css;
},
);