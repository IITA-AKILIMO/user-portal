<?php

/**
 * Buttons block config
 *
 * @package Kenta Blocks
 */
$attributes = array_merge( array(
    'blockID'    => array(
    'type' => 'string',
),
    'direction'  => array(
    'type'    => 'object',
    'default' => 'row',
),
    'justify'    => array(
    'type'    => 'object',
    'default' => 'flex-start',
),
    'alignItems' => array(
    'type'    => 'object',
    'default' => 'flex-start',
),
    'wrap'       => array(
    'type'    => 'string',
    'default' => 'yes',
),
    'gap'        => array(
    'type'    => 'object',
    'default' => '12px',
),
), kenta_blocks_advanced_attrs() );
$metadata = array(
    'title'      => __( 'Buttons (KB)', 'kenta-blocks' ),
    'keywords'   => array(
    'link',
    'button',
    'buttons',
    'icon'
),
    'supports'   => array(
    'anchor'                                 => true,
    'align'                                  => array( 'wide', 'full' ),
    '__experimentalExposeControlsToChildren' => true,
),
    'attributes' => $attributes,
);
return array(
    'metadata' => $metadata,
    'css'      => function ( $id, $attrs, $css ) use( $metadata ) {
    $css[".kb-buttons-{$id}"] = array_merge( array(
        'flex-direction'   => $attrs['direction'] ?? null,
        'justify-content'  => kenta_blocks_block_attr( 'justify', $attrs, $metadata ),
        'align-items'      => kenta_blocks_block_attr( 'alignItems', $attrs, $metadata ),
        'flex-wrap'        => ( ($attrs['wrap'] ?? 'yes') == 'yes' ? 'wrap' : 'no-wrap' ),
        '--kb-buttons-gap' => $attrs['gap'] ?? null,
    ), kenta_blocks_advanced_css( $attrs, $metadata ) );
    return $css;
},
);