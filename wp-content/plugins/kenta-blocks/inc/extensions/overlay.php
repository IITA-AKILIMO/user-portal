<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'kenta_blocks_overlay_attrs' ) ) {
	/**
	 * Overlay attrs
	 *
	 * @return array
	 */
	function kenta_blocks_overlay_attrs( $defaults = array() ) {
		$defaults = wp_parse_args( $defaults, array(
			'overlay'    => 'no',
			'background' => array(
				'type'  => 'color',
				'color' => 'rgba(0,0,0,0.25)'
			),
		) );

		return array(
			'overlay'           => array(
				'type'    => 'string',
				'default' => $defaults['overlay']
			),
			'overlayZIndex'     => array(
				'type'    => 'object',
				'default' => \KentaBlocks\Css::INITIAL_VALUE
			),
			'overlayOpacity'    => array(
				'type'    => 'object',
				'default' => \KentaBlocks\Css::INITIAL_VALUE
			),
			'overlayFilter'     => array(
				'type' => 'object'
			),
			'overlayBlendMode'  => array(
				'type'    => 'string',
				'default' => ''
			),
			'overlayBackground' => array(
				'type'    => 'object',
				'default' => $defaults['background']
			),
		);
	}
}

if ( ! function_exists( 'kenta_blocks_overlay_css' ) ) {
	/**
	 * @param $attrs
	 * @param $metadata
	 *
	 * @return array|null[]
	 */
	function kenta_blocks_overlay_css( $attrs, $metadata ) {
		return array_merge(
			array(
				'z-index'        => kenta_blocks_block_attr( 'overlayZIndex', $attrs, $metadata ),
				'opacity'        => kenta_blocks_block_attr( 'overlayOpacity', $attrs, $metadata ),
				'mix-blend-mode' => kenta_blocks_block_attr( 'overlayBlendMode', $attrs, $metadata )
			),
			kenta_blocks_css()->filter(
				kenta_blocks_block_attr( 'overlayFilter', $attrs, $metadata )
			),
			kenta_blocks_css()->background(
				kenta_blocks_block_attr( 'overlayBackground', $attrs, $metadata )
			)
		);
	}
}
