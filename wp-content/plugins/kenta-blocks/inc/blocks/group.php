<?php

$attributes = array(
    'blockID' => array(
    'type' => 'string',
),
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
    return $css;
},
);