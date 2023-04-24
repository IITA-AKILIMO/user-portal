<?php

namespace IGD;

use NF_Abstracts_Field;

defined( 'ABSPATH' ) || exit;

add_filter( 'ninja_forms_register_fields', function ( $fields ) {
	$fields['integrate_google_drive'] = new NinjaForms();

	return $fields;
} );

add_filter( 'ninja_forms_field_template_file_paths', function ( $file_paths ) {
	$file_paths[] = IGD_INCLUDES . '/integrations/templates__premium_only/';

	return $file_paths;
} );

add_action( 'ninja_forms_enqueue_scripts', function ( $data ) {
	$form_id = $data['form_id'];

	$fields = Ninja_Forms()->form( $form_id )->get_fields();

	foreach ( $fields as $field ) {
		if ( $field->get_setting( 'type' ) == 'integrate_google_drive' ) {
			wp_enqueue_style( 'igd-frontend' );
			wp_enqueue_script( 'igd-frontend' );
			break;
		}
	}

} );

// After entry is saved
add_action( 'ninja_forms_after_submission', function ( $data ) {

	$igd_fields = array_filter( $data['fields'], function ( $field ) {
		return $field['settings']['type'] == 'integrate_google_drive';
	} );

	$entry_post_id = $data['actions']['save']['sub_id'];
	$entry_id      = get_post_meta( $entry_post_id, '_seq_num', true );

	if ( ! empty( $igd_fields ) ) {
		foreach ( $igd_fields as $field ) {
			$value = $field['settings']['value'];

			if ( empty( $value ) ) {
				continue;
			}

			$igd_data = json_decode( $field['settings']['igd_data'], true );

			$create_entry_folder = ! empty( $igd_data['createEntryFolders'] );
			if ( ! $create_entry_folder ) {
				continue;
			}

			$entry_folder_name_template = ! empty( $igd_data['entryFolderNameTemplate'] ) ? $igd_data['entryFolderNameTemplate'] : 'Entry (%entry_id%) - %form_title%';

			$files = json_decode( $value, true );

			$user_data = is_user_logged_in() ? get_userdata( get_current_user_id() ) : null;

			$tags = [
				'%form_title%'   => $data['settings']['title'],
				'%form_id%'      => $data['form_id'],
				'%entry_id%'     => $entry_id,
				'%user_id%'      => is_user_logged_in() ? get_current_user_id() : '',
				'%user_login%'   => is_user_logged_in() ? $user_data->user_login : '',
				'%user_email%'   => is_user_logged_in() ? $user_data->user_email : '',
				'%display_name%' => is_user_logged_in() ? $user_data->display_name : '',
				'%date%'         => date( 'Y-m-d' ),
				'%time%'         => date( 'H:i:s' ),
				'%unique_id%'    => uniqid(),
			];

			$upload_folder = $igd_data['folders'][0];

			Uploader::instance( $upload_folder['accountId'] )->create_entry_folder_and_move( $files, $entry_folder_name_template, $tags, $upload_folder );
		}
	}

} );


class NinjaForms extends NF_Abstracts_Field {
	protected $_name = 'integrate_google_drive';
	protected $_type = 'integrate_google_drive';
	protected $_nicename = 'Google Drive';
	protected $_parent_type = 'textbox';
	protected $_section = 'common';
	protected $_templates = 'integrate_google_drive';
	protected $_icon = 'cloud-upload';
	protected $_test_value = false;
	protected $_settings_all_fields = array(
		'key',
		'label',
		'label_pos',
		'required',
		'classes',
		'manual_key',
		'help',
		'description',
	);

	public function __construct() {

		parent::__construct();

		$settings = [
			'igd_data' => array(
				'name'  => 'igd_data',
				'type'  => 'textarea',
				'value' => '',
				'label' => __( 'Configure Uploader', 'integrate-google-drive' ),
				'group' => 'primary',
				'width' => 'full',
				'help'  => __( 'Configure the file uploader with module builder.', 'integrate-google-drive' ),
			),

			'igd_configure' => array(
				'name'  => 'igd_configure',
				'type'  => 'html',
				'value' => '<div class="igd-form-uploader-config-btn">
                    <button type="button" class="igd-form-uploader-trigger igd-btn btn-primary">
                        <i class="dashicons dashicons-admin-generic"></i>
                        <span>Configure</span>
                    </button>
                </div>',
				'group' => 'primary',
				'width' => 'full',
			),
		];

		$this->_settings = array_merge( $this->_settings, $settings );

		add_action( 'nf_admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}


	public function process( $field, $data ) {


		foreach ( $data['fields'] as $key => $data_field ) {
			if ( $data_field['id'] != $field['id'] ) {
				continue;
			}

			$data['fields'][ $key ]['value'] = Hooks::instance()->render_form_field_data__premium_only( $data_field['value'], false );

		}

		return $data;
	}


	public function admin_enqueue_scripts() {
		Enqueue::instance()->admin_scripts( '',false );
	}

}