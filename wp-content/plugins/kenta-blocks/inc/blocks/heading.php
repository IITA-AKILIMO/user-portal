<?php

/**
 * Heading block config
 *
 * @package Kenta Blocks
 */
$attributes = array_merge( array(
    'blockID'        => array(
    'type' => 'string',
),
    'content'        => array(
    'type'     => 'string',
    'source'   => 'html',
    'selector' => 'h1,h2,h3,h4,h5,h6',
    'default'  => '',
),
    'markup'         => array(
    'type'    => 'string',
    'default' => 'h2',
),
    'maxWidth'       => array(
    'type' => 'object',
),
    'textAlign'      => array(
    'type' => 'object',
),
    'alignSelf'      => array(
    'type' => 'object',
),
    'color'          => array(
    'type'    => 'object',
    'default' => array(
    'initial'      => \KentaBlocks\Css::INITIAL_VALUE,
    'link-initial' => \KentaBlocks\Css::INITIAL_VALUE,
    'link-hover'   => \KentaBlocks\Css::INITIAL_VALUE,
),
),
    'typography'     => array(
    'type'    => 'object',
    'default' => array(
    'family'     => \KentaBlocks\Css::INITIAL_VALUE,
    'fontSize'   => \KentaBlocks\Css::INITIAL_VALUE,
    'variant'    => \KentaBlocks\Css::INITIAL_VALUE,
    'lineHeight' => \KentaBlocks\Css::INITIAL_VALUE,
),
),
    'displayAsBlock' => array(
    'type'    => 'string',
    'default' => 'no',
),
), kenta_blocks_box_attrs(), kenta_blocks_advanced_attrs() );
$metadata = array(
    'title'      => __( 'Heading (KB)', 'kenta-blocks' ),
    'keywords'   => array( 'heading', 'title' ),
    'supports'   => array(
    'align'                  => array( 'wide', 'full' ),
    'anchor'                 => true,
    '__experimentalSelector' => 'h1,h2,h3,h4,h5,h6',
),
    'attributes' => $attributes,
);
return array(
    'metadata' => $metadata,
    'css'      => function ( $id, $attrs, $css ) use( $metadata ) {
    $selectors = array(
        "h1.kb-heading-{$id}",
        "h2.kb-heading-{$id}",
        "h3.kb-heading-{$id}",
        "h4.kb-heading-{$id}",
        "h5.kb-heading-{$id}",
        "h6.kb-heading-{$id}",
        ".kb-heading.kb-heading-{$id} h1",
        ".kb-heading.kb-heading-{$id} h2",
        ".kb-heading.kb-heading-{$id} h3",
        ".kb-heading.kb-heading-{$id} h4",
        ".kb-heading.kb-heading-{$id} h5",
        ".kb-heading.kb-heading-{$id} h6"
    );
    $css[".kb-heading.kb-heading-{$id}"] = array_merge( array(
        'text-align' => kenta_blocks_block_attr( 'textAlign', $attrs, $metadata ),
        'align-self' => kenta_blocks_block_attr( 'alignSelf', $attrs, $metadata ),
        'max-width'  => kenta_blocks_block_attr( 'maxWidth', $attrs, $metadata ),
    ), kenta_blocks_advanced_css( $attrs, $metadata ) );
    $css[implode( ',', $selectors )] = array_merge(
        kenta_blocks_css()->colors( kenta_blocks_block_attr( 'color', $attrs, $metadata ), array(
        'initial'      => 'color',
        'link-initial' => array( '--kenta-link-initial-color', '--kb-link-initial-color' ),
        'link-hover'   => array( '--kenta-link-hover-color', '--kb-link-hover-color' ),
    ) ),
        kenta_blocks_css()->typography( kenta_blocks_block_attr( 'typography', $attrs, $metadata ) ),
        kenta_blocks_css()->shadow( kenta_blocks_block_attr( 'shadow', $attrs, $metadata ) ),
        kenta_blocks_css()->background( kenta_blocks_block_attr( 'background', $attrs, $metadata ) )
    );
    return $css;
},
);