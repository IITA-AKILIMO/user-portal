<?php

/**
 * Icon Button block config
 *
 * @package Kenta Blocks
 */
require dirname( __FILE__ ) . '/button.php';
$attributes = array(
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
    'url'        => array(
    'type'      => 'string',
    'source'    => 'attribute',
    'selector'  => 'a',
    'attribute' => 'href',
    'default'   => '',
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
    'preset'     => array(
    'type'    => 'string',
    'default' => 'primary',
),
    'iconSize'   => array(
    'type'    => 'object',
    'default' => '1.2rem',
),
    'buttonSize' => array(
    'type'    => 'object',
    'default' => '2.5em',
),
    'radius'     => array(
    'type'    => 'object',
    'default' => array(
    'top'    => '100%',
    'right'  => '100%',
    'bottom' => '100%',
    'left'   => '100%',
    'linked' => true,
),
),
);
$metadata = array(
    'title'      => __( 'Icon Button (KB)', 'kenta-blocks' ),
    'keywords'   => array(
    'icon',
    'link',
    'button',
    'buttons'
),
    'parent'     => array( 'kenta-blocks/buttons' ),
    'supports'   => array(
    'anchor' => true,
),
    'attributes' => $attributes,
);
return array(
    'metadata' => $metadata,
    'css'      => function ( $id, $attrs, $css ) use( $metadata ) {
    $button_css = kenta_blocks_button_css( $attrs, $metadata, array(
        'font-size'             => kenta_blocks_block_attr( 'iconSize', $attrs, $metadata ),
        '--kb-icon-button-size' => kenta_blocks_block_attr( 'buttonSize', $attrs, $metadata ),
    ) );
    $css[".kb-icon-button.kb-icon-button-{$id}"] = $button_css;
    return $css;
},
);