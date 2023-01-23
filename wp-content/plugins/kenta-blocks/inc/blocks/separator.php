<?php
/**
 * Separator block config
 *
 * @package Kenta Blocks
 */

$attributes = array_merge(
	array(
		'blockID' => array(
			'type' => 'string',
		),
		'height'  => array(
			'type'    => 'object',
			'default' => '2px',
		),
		'width'   => array(
			'type' => 'object',
		),
		'color'   => array(
			'type'    => 'object',
			'default' => array(
				'default' => 'var(--kb-base-300)',
			),
		),
		'style'   => array(
			'type'    => 'string',
			'default' => 'solid',
		),
		'radius'  => array(
			'type'    => 'object',
			'default' => array(
				'top'    => '',
				'right'  => '',
				'bottom' => '',
				'left'   => '',
			)
		),
		'shadow'  => array(
			'type'    => 'object',
			'default' => array(
				'enable'     => 'no',
				'horizontal' => '0px',
				'vertical'   => '0px',
				'blur'       => '10px',
				'spread'     => '0px',
				'color'      => 'rgba(0, 0, 0, 0.15)',
			),
		)
	),
	kenta_blocks_advanced_attrs( array(
		'margin' => array(
			'top'    => '12px',
			'right'  => 'auto',
			'bottom' => '12px',
			'left'   => 'auto',
		)
	) )
);

$metadata = array(
	'title'      => __( 'Separator (KB)', 'kenta-blocks' ),
	'keywords'   => array( 'separator', 'divider' ),
	'supports'   => array(
		'anchor' => true,
		'align'  => array( 'wide', 'full' ),
	),
	'attributes' => $attributes,
);

return array(
	'metadata' => $metadata,
	'css'      => function ( $id, $attrs, $css ) use ( $metadata ) {

		$css[".kb-separator.kb-separator-$id, hr.kb-separator.kb-separator-$id"] = array_merge(
			array(
				'--kb-separator-height' => kenta_blocks_block_attr( 'height', $attrs, $metadata ),
				'width'                 => kenta_blocks_block_attr( 'width', $attrs, $metadata ),
				'border-top-style'      => kenta_blocks_block_attr( 'style', $attrs, $metadata ),
			),
			kenta_blocks_advanced_css( $attrs, $metadata, array( 'padding' ) ),
			kenta_blocks_css()->dimensions( kenta_blocks_block_attr( 'margin', $attrs, $metadata ), '--kb-separator-margin' ),
			kenta_blocks_css()->dimensions( kenta_blocks_block_attr( 'radius', $attrs, $metadata ), 'border-radius' ),
			kenta_blocks_css()->shadow( kenta_blocks_block_attr( 'shadow', $attrs, $metadata ) ),
			kenta_blocks_css()->colors( kenta_blocks_block_attr( 'color', $attrs, $metadata ), array(
				'default' => '--kb-separator-color',
			) )
		);

		return $css;
	}
);
