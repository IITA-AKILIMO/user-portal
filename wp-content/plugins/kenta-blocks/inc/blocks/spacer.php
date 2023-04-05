<?php
/**
 * Spacer block config
 *
 * @package Kenta Blocks
 */

$attributes = array(
	'blockID' => array(
		'type' => 'string',
	),
	'height'  => array(
		'type'    => 'object',
		'default' => '100px',
	)
);

$metadata = array(
	'title'      => __( 'Spacer (KB)', 'kenta-blocks' ),
	'keywords'   => array( 'spacer', 'spacing' ),
	'supports'   => array(
		'anchor' => true,
	),
	'attributes' => $attributes,
);

return array(
	'metadata' => $metadata,
	'css'      => function ( $id, $attrs, $css ) use ( $metadata ) {

		$css[".kb-spacer-$id"] = array(
			'height' => kenta_blocks_block_attr( 'height', $attrs, $metadata )
		);

		return $css;
	}
);
