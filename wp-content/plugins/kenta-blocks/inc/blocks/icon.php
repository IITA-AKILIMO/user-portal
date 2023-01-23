<?php

/**
 * Icon block config
 *
 * @package Kenta Blocks
 */
$attributes = array_merge( array(
    'blockID'    => array(
    'type' => 'string',
),
    'anchor'     => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'attribute' => 'id',
    'selector'  => 'a',
),
    'icon'       => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'selector'  => 'i',
    'attribute' => 'class',
    'default'   => 'fas fa-star',
),
    'iconSize'   => array(
    'type'    => 'object',
    'default' => '60px',
),
    'url'        => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'selector'  => 'a',
    'attribute' => 'href',
    'default'   => '',
),
    'text'       => array(
    'type'     => 'string',
    'source'   => 'html',
    'selector' => 'a span',
),
    'linkTarget' => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'selector'  => 'a',
    'attribute' => 'target',
),
    'rel'        => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'selector'  => 'a',
    'attribute' => 'rel',
),
    'textAlign'  => array(
    'type' => 'object',
),
    'iconColor'  => array(
    'type'    => 'object',
    'default' => array(
    'initial' => \KentaBlocks\Css::INITIAL_VALUE,
    'hover'   => \KentaBlocks\Css::INITIAL_VALUE,
),
),
), kenta_blocks_advanced_attrs() );
$metadata = array(
    'title'      => __( 'Icon (KB)', 'kenta-blocks' ),
    'keywords'   => array(
    'icon',
    'ico',
    'link',
    'button'
),
    'supports'   => array(
    'anchor' => true,
),
    'attributes' => $attributes,
);
return array(
    'metadata' => $metadata,
    'css'      => function ( $id, $attrs, $css ) use( $metadata ) {
    $css[".kb-icon-{$id}"] = array_merge( array(
        'text-align'     => kenta_blocks_block_attr( 'textAlign', $attrs, $metadata ),
        '--kb-icon-size' => kenta_blocks_block_attr( 'iconSize', $attrs, $metadata ),
    ), kenta_blocks_css()->colors( kenta_blocks_block_attr( 'iconColor', $attrs, $metadata ), array(
        'initial' => '--kb-icon-initial-color',
        'hover'   => '--kb-icon-hover-color',
    ) ), kenta_blocks_advanced_css( $attrs, $metadata ) );
    return $css;
},
);