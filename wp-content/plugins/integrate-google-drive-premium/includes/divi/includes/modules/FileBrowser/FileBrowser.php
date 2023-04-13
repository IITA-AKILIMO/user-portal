<?php

namespace IGD\divi\includes\modules\FileBrowser;

if ( ! defined( 'IGD_VERSION' ) ) {
	return;
}

class FileBrowser extends \ET_Builder_Module {
	public $slug = 'file_browser';
	public $vb_support = 'on';
	public $use_raw_content = true;

	protected $module_credits = [
		'module_uri' => 'https://softlabbd.com/integrate-google-drive',
		'author'     => 'SoftLab',
		'author_uri' => 'https://softlabbd.com',
	];

	public function init() {
		$this->name = 'Google Drive File Browser Module';

		$this->settings_modal_toggles = [
			'general' => [
				'toggles' => [
					'main_content' => 'Module Configuration',
				],
			],
		];

		$this->advanced_fields = [
			'background'     => false,
			'borders'        => false,
			'box_shadow'     => false,
			'button'         => false,
			'filters'        => false,
			'fonts'          => false,
			'margin_padding' => false,
			'text'           => false,
			'link_options'   => false,
			'height'         => false,
			'scroll_effects' => false,
			'animation'      => false,
			'transform'      => false,
		];
	}

	public function get_fields() {
		return [
			'shortcode' => [
				'label'           => esc_html__( 'Raw module shortcode', 'integrate-google-drive' ),
				'type'            => 'wpcp_shortcode_field',
				'option_category' => 'configuration',
				'description'     => esc_html__( 'Edit this module via the Module Builder or manually via the raw code', 'integrate-google-drive' ),
				'default'         => '[useyourdrive mode="files"]',
				'ajax_url'        => USEYOURDRIVE_ADMIN_URL,
				'plugin_slug'     => 'useyourdrive',
				'toggle_slug'     => 'main_content',
			],
		];
	}

	public function render( $attrs, $content = null, $render_slug = '' ) {
		$shortcode = html_entity_decode( ( $this->props['shortcode'] ) );

		if ( empty( $shortcode ) ) {
			return esc_html__( 'Please configure the module first', 'integrate-google-drive' );
		}

		ob_start();

		echo do_shortcode( $shortcode );

		$content = ob_get_clean();

		if ( empty( $content ) ) {
			return '';
		}

		return $content;
	}
}

new FileBrowser();
