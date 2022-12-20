<?php

$attributes = array(
    'blockID' => array(
    'type' => 'string',
),
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
    return $css;
},
);