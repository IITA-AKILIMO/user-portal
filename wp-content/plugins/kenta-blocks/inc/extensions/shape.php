<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'kenta_blocks_shape_attrs' ) ) {
	/**
	 * Shape divider attrs
	 *
	 * @return array
	 */
	function kenta_blocks_shape_attrs() {
		return array(
			'shape'         => array(
				'type'    => 'string',
				'default' => 'none',
			),
			'shapeSvg'      => array(
				'type'     => 'string',
				'source'   => 'html',
				'selector' => '.kb-shape-divider',
				'default'  => ''
			),
			'flipShape'     => array(
				'type'    => 'string',
				'default' => 'no',
			),
			'invertShape'   => array(
				'type'    => 'string',
				'default' => 'no',
			),
			'shapeWidth'    => array(
				'type'    => 'object',
				'default' => '100%',
			),
			'shapeHeight'   => array(
				'type'    => 'object',
				'default' => '50px',
			),
			'shapeColor'    => array(
				'type'    => 'string',
				'default' => 'var(--kb-base-100)'
			),
			'shapePosition' => array(
				'type'    => 'string',
				'default' => 'bottom',
			),
			'shapeZIndex'   => array(
				'type'    => 'object',
				'default' => 2,
			)
		);
	}
}
