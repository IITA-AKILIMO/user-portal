<?php

$attributes = array(
    'blockID' => array(
    'type' => 'string',
),
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
    return $css;
},
);