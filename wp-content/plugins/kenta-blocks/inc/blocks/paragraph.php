<?php

/**
 * Paragraph block config
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
    'selector' => 'p',
    'default'  => '',
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
    'title'      => __( 'Paragraph (KB)', 'kenta-blocks' ),
    'keywords'   => array( 'paragraph', 'text' ),
    'supports'   => array(
    'align'                  => array( 'wide', 'full' ),
    'anchor'                 => true,
    '__experimentalSelector' => 'p',
),
    'attributes' => $attributes,
);
return array(
    'metadata' => $metadata,
    'css'      => function ( $id, $attrs, $css ) use( $metadata ) {
    $selectors = array( "p.kb-paragraph-{$id}", ".kb-paragraph-{$id} p" );
    $css[".kb-paragraph.kb-paragraph-{$id}"] = array_merge( array(
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