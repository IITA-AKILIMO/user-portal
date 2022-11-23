<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'kenta_blocks_container_global_style' ) ) {
	/**
	 * Global style for container
	 *
	 * @param array $defaults
	 *
	 * @return array[]
	 */
	function kenta_blocks_container_global_style( $defaults = array() ) {
		$defaults = wp_parse_args( $defaults, array(
			'color'          => array(
				'initial' => \KentaBlocks\Css::INITIAL_VALUE,
			),
			'typography'     => array(
				'family'     => \KentaBlocks\Css::INITIAL_VALUE,
				'fontSize'   => \KentaBlocks\Css::INITIAL_VALUE,
				'variant'    => \KentaBlocks\Css::INITIAL_VALUE,
				'lineHeight' => \KentaBlocks\Css::INITIAL_VALUE,
			),
			'overrideColors' => 'no',
			'primaryColor'   => array(
				'default' => \KentaBlocks\Css::INITIAL_VALUE,
				'active'  => \KentaBlocks\Css::INITIAL_VALUE,
			),
			'accentColor'    => array(
				'default' => \KentaBlocks\Css::INITIAL_VALUE,
				'active'  => \KentaBlocks\Css::INITIAL_VALUE,
			),
			'baseColor'      => array(
				'default' => \KentaBlocks\Css::INITIAL_VALUE,
				'300'     => \KentaBlocks\Css::INITIAL_VALUE,
				'200'     => \KentaBlocks\Css::INITIAL_VALUE,
				'100'     => \KentaBlocks\Css::INITIAL_VALUE,
			),
		) );

		return array(
			// global style
			'globalColor'                 => array(
				'type'    => 'object',
				'default' => $defaults['color']
			),
			'globalTypography'            => array(
				'type'    => 'object',
				'default' => $defaults['typography']
			),
			'overrideGlobalColorSettings' => array(
				'type'    => 'string',
				'default' => $defaults['overrideColors']
			),
			'globalPrimaryColor'          => array(
				'type'    => 'object',
				'default' => $defaults['primaryColor']
			),
			'globalAccentColor'           => array(
				'type'    => 'object',
				'default' => $defaults['accentColor']
			),
			'globalBaseColor'             => array(
				'type'    => 'object',
				'default' => $defaults['baseColor']
			)
		);
	}
}

if ( ! function_exists( 'kenta_blocks_container_global_css' ) ) {
	/**
	 * Global css for container
	 *
	 * @param $attrs
	 * @param $metadata
	 *
	 * @return array
	 */
	function kenta_blocks_container_global_css( $attrs, $metadata ) {
		$css = array_merge(
			kenta_blocks_css()->typography( kenta_blocks_block_attr( 'globalTypography', $attrs, $metadata ) ),
			kenta_blocks_css()->colors( kenta_blocks_block_attr( 'globalColor', $attrs, $metadata ), array(
				'initial' => [
					'color',
					'--kenta-headings-color',
					'--kenta-headings-h1-color',
					'--kenta-headings-h2-color',
					'--kenta-headings-h3-color',
					'--kenta-headings-h4-color',
					'--kenta-headings-h5-color',
					'--kenta-headings-h6-color',
				],
			) )
		);

		if ( 'yes' == kenta_blocks_block_attr( 'overrideGlobalColorSettings', $attrs, $metadata ) ) {
			$css = array_merge( $css,
				kenta_blocks_css()->colors( kenta_blocks_block_attr( 'globalPrimaryColor', $attrs, $metadata ), array(
					'default' => '--kb-primary-color',
					'active'  => '--kb-primary-active',
				) ),
				kenta_blocks_css()->colors( kenta_blocks_block_attr( 'globalAccentColor', $attrs, $metadata ), array(
					'default' => '--kb-accent-color',
					'active'  => '--kb-accent-active',
				) ),
				kenta_blocks_css()->colors( kenta_blocks_block_attr( 'globalBaseColor', $attrs, $metadata ), array(
					'default' => '--kb-base-color',
					'300'     => '--kb-base-300',
					'200'     => '--kb-base-200',
					'100'     => '--kb-base-100',
				) )
			);
		}

		return $css;
	}
}
