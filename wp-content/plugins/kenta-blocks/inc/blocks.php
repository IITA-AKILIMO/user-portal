<?php
/**
 * All blocks config file
 *
 * @package Kenta Blocks
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'kenta_blocks_block_attr' ) ) {
	/**
	 * Get default block attr
	 *
	 * @param $attr
	 * @param $attrs
	 * @param array $metadata
	 *
	 * @return mixed|null
	 */
	function kenta_blocks_block_attr( $attr, $attrs, $metadata = array() ) {
		if ( isset( $attrs[ $attr ] ) ) {
			return $attrs[ $attr ];
		}

		if ( isset( $metadata['attributes'] ) && isset( $metadata['attributes'][ $attr ] ) ) {
			return $metadata['attributes'][ $attr ]['default'] ?? null;
		}

		return null;
	}
}

/**
 * All extensions
 */
require KENTA_BLOCKS_PLUGIN_PATH . 'inc/extensions/advanced.php';
require KENTA_BLOCKS_PLUGIN_PATH . 'inc/extensions/box.php';
require KENTA_BLOCKS_PLUGIN_PATH . 'inc/extensions/container.php';
require KENTA_BLOCKS_PLUGIN_PATH . 'inc/extensions/overlay.php';
require KENTA_BLOCKS_PLUGIN_PATH . 'inc/extensions/shape.php';

/**
 * All blocks config
 */
return array(
	'kenta-blocks/templates'   => require KENTA_BLOCKS_PLUGIN_PATH . 'inc/blocks/templates.php',
	'kenta-blocks/section'     => require KENTA_BLOCKS_PLUGIN_PATH . 'inc/blocks/section.php',
	'kenta-blocks/column'      => require KENTA_BLOCKS_PLUGIN_PATH . 'inc/blocks/column.php',
	'kenta-blocks/button'      => require KENTA_BLOCKS_PLUGIN_PATH . 'inc/blocks/button.php',
	'kenta-blocks/icon-button' => require KENTA_BLOCKS_PLUGIN_PATH . 'inc/blocks/icon-button.php',
	'kenta-blocks/buttons'     => require KENTA_BLOCKS_PLUGIN_PATH . 'inc/blocks/buttons.php',
	'kenta-blocks/icon'        => require KENTA_BLOCKS_PLUGIN_PATH . 'inc/blocks/icon.php',
	'kenta-blocks/cover'       => require KENTA_BLOCKS_PLUGIN_PATH . 'inc/blocks/cover.php',
	'kenta-blocks/spacer'      => require KENTA_BLOCKS_PLUGIN_PATH . 'inc/blocks/spacer.php',
	'kenta-blocks/heading'     => require KENTA_BLOCKS_PLUGIN_PATH . 'inc/blocks/heading.php',
	'kenta-blocks/paragraph'   => require KENTA_BLOCKS_PLUGIN_PATH . 'inc/blocks/paragraph.php',
	'kenta-blocks/image'       => require KENTA_BLOCKS_PLUGIN_PATH . 'inc/blocks/image.php',
	'kenta-blocks/group'       => require KENTA_BLOCKS_PLUGIN_PATH . 'inc/blocks/group.php',
	'kenta-blocks/row'         => require KENTA_BLOCKS_PLUGIN_PATH . 'inc/blocks/row.php',
	'kenta-blocks/stack'       => require KENTA_BLOCKS_PLUGIN_PATH . 'inc/blocks/stack.php',
);
