<?php
/**
 * All settings
 *
 * @package Kenta Blocks
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'kb_sync_kenta_theme'          => array(
		'sanitize' => 'kenta_blocks_sanitize_checkbox',
		'default'  => 'no',
	),
	'kb_primary_color'             => array(
		'sanitize' => 'kenta_blocks_sanitize_rgba_color_collect',
		'default'  => array(
			'default' => '#0258c7',
			'active'  => '#0e80e8',
		),
	),
	'kb_accent_color'              => array(
		'sanitize' => 'kenta_blocks_sanitize_rgba_color_collect',
		'default'  => array(
			'default' => '#181f28',
			'active'  => '#334155',
		),
	),
	'kb_base_color'                => array(
		'sanitize' => 'kenta_blocks_sanitize_rgba_color_collect',
		'default'  => array(
			'300'     => '#e2e8f0',
			'200'     => '#f1f5f9',
			'100'     => '#f8fafc',
			'default' => '#ffffff',
		),
	),
	'kb_local_webfonts'            => array(
		'sanitize' => 'kenta_blocks_sanitize_checkbox',
		'default'  => 'no',
	),
	'kb_editor_responsive_preview' => array(
		'sanitize' => 'kenta_blocks_sanitize_checkbox',
		'default'  => 'no'
	)
);
