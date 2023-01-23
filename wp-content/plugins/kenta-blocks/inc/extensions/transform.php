<?php

// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( !function_exists( 'kenta_blocks_transform_attrs' ) ) {
    /**
     * Attrs for transform
     *
     * @param array $defaults
     *
     * @return array
     */
    function kenta_blocks_transform_attrs( $defaults = array() )
    {
        return array(
            'transform' => array(
            'type'    => 'string',
            'default' => 'no',
        ),
        );
    }

}
if ( !function_exists( 'kenta_blocks_transform_css' ) ) {
    /**
     * @param $attrs
     * @param $metadata
     *
     * @return array
     */
    function kenta_blocks_transform_css( $attrs, $metadata )
    {
        return array();
    }

}
if ( !function_exists( 'kenta_blocks_transform_hover_css' ) ) {
    /**
     * @param $attrs
     * @param $metadata
     *
     * @return array
     */
    function kenta_blocks_transform_hover_css( $attrs, $metadata )
    {
        return array();
    }

}