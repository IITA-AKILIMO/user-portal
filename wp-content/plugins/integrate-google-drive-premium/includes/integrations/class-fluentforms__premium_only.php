<?php


namespace IGD;

defined( 'ABSPATH' ) || exit;


use FluentForm\App\Helpers\Helper;
use FluentForm\App\Services\FormBuilder\BaseFieldManager;
use FluentForm\Framework\Helpers\ArrayHelper;

class FluentForms_Field extends BaseFieldManager {
	public $field_type = 'integrate_google_drive';

	public function __construct() {
		parent::__construct( $this->field_type, __( 'Google Drive', 'integrate-google-drive' ), [
			'cloud',
			'google',
			'drive',
			'documents',
			'files',
			'upload',
			'video',
			'audio',
			'media',
			'embed'
		], 'general' );

		// Data render
		add_filter( 'fluentform_response_render_' . $this->key, [ $this, 'renderResponse' ], 10, 3 );

		// Validation
		add_filter( 'fluentform_validate_input_item_' . $this->key, [ $this, 'validateInput' ], 10, 5 );

		//after form submission
		add_action( 'fluentform_submission_inserted', [ $this, 'may_create_entry_folder' ], 10, 3 );

	}

	public function may_create_entry_folder( $insertId, $formData, $form ) {

		$igd_fields = array_filter( $formData, function ( $field, $key ) {
			return strpos( $key, 'integrate_google_drive' ) === 0;
		}, ARRAY_FILTER_USE_BOTH );

		if ( ! empty( $igd_fields ) ) {
			foreach ( $igd_fields as $key => $value ) {

				if ( empty( $value ) ) {
					continue;
				}

				$form_fields = json_decode( $form->form_fields, true )['fields'];

				$field = array_filter( $form_fields, function ( $item ) use ( $key ) {
					return $item['attributes']['name'] === $key;
				} );

				$field = array_shift( $field );

				$igd_data = json_decode( $field['settings']['igd_data'], true );

				$create_entry_folder = ! empty( $igd_data['createEntryFolders'] );
				if ( ! $create_entry_folder ) {
					continue;
				}

				$entry_folder_name_template = ! empty( $igd_data['entryFolderNameTemplate'] ) ? $igd_data['entryFolderNameTemplate'] : 'Entry (%entry_id%) - %form_title%';

				$files = json_decode( $value, true );

				$user_data = is_user_logged_in() ? get_userdata( get_current_user_id() ) : null;

				$tags = [
					'%form_title%'   => $form->title,
					'%form_id%'      => $form->id,
					'%entry_id%'     => $insertId,
					'%user_id%'      => get_current_user_id(),
					'%user_login%'   => $user_data ? $user_data->user_login : '',
					'%user_email%'   => $user_data ? $user_data->user_email : '',
					'%display_name%' => $user_data ? $user_data->display_name : '',
					'%date%'         => date( 'Y-m-d' ),
					'%time%'         => date( 'H:i:s' ),
					'%unique_id%'    => uniqid(),
				];

				$upload_folder = $igd_data['folders'][0];

				Uploader::instance( $upload_folder['accountId'] )->create_entry_folder_and_move( $files, $entry_folder_name_template, $tags, $upload_folder );
			}
		}
	}

	public function getComponent() {
		return [
			'index'          => 99,
			'element'        => $this->key,
			'attributes'     => [
				'name'  => $this->key,
				'class' => '',
				'value' => '',
				'type'  => 'hidden',
			],
			'settings'       => [
				'container_class'    => '',
				'placeholder'        => '',
				'html_codes'         => $this->getUploaderPreview(),
				'label'              => esc_html__( 'Attach your documents', 'integrate-google-drive' ),
				'label_placement'    => '',
				'igd_data'           => '',
				'admin_field_label'  => '',
				'validation_rules'   => [
					'required' => [
						'value'   => false,
						'message' => esc_html__( 'This field is required', 'integrate-google-drive' ),
					],
				],
				'conditional_logics' => [],
			],
			'editor_options' => [
				'title'      => $this->title,
				'icon_class' => 'ff-edit-files',
				'template'   => 'customHTML',
			],
		];
	}

	public function getGeneralEditorElements() {
		return [
			'label',
			'admin_field_label',
			'value',
			'igd_data',
			'label_placement',
			'validation_rules',
		];
	}

	public function generalEditorElement() {
		return [
			'igd_data' => [
				'template'         => 'inputTextarea',
				'label'            => 'Shortcode Data',
				'help_text'        => __( 'Grab the Shortcode Data via the shortcode builder and copy + paste in this field.', 'integrate-google-drive' ),
				'css_class'        => 'igd-uploader-data',
				'inline_help_text' => sprintf( '<br/><div class="igd-form-uploader-config-fluentforms"><button type="button" class="igd-form-uploader-trigger igd-btn btn-primary"><i class="dashicons dashicons-admin-generic"></i><span>%s</span></button></div><br/>%s', __( 'Configure', 'integrate-google-drive' ), __( 'Configure the uploader field using the module shortcode builder and copy + paste the Shortcode Data in this field.', 'integrate-google-drive' ) ),
				'rows'             => 8,
			],
		];
	}

	public function getAdvancedEditorElements() {
		return [
			'name',
			'help_message',
			'container_class',
			'class',
			'conditional_logics',
		];
	}

	public function getUploaderPreview() {

		$default_data = [
			'id'             => $this->key,
			'type'           => 'uploader',
			'isFormUploader' => true,
			'isRequired'     => false,
		];

		$saved_data = [];

		$data = wp_parse_args( $saved_data, $default_data );

		return Shortcode::instance()->render_shortcode( [], $data );
	}

	public function render( $data, $form ) {
		$elementName = $data['element'];

		$data = apply_filters( 'fluenform_rendering_field_data_' . $elementName, $data, $form );

		$default_data = [
			'id'             => $this->key,
			'type'           => 'uploader',
			'isFormUploader' => true,
			'isRequired'     => ! empty( $data['settings']['validation_rules']['required']['value'] ),
		];

		$saved_data       = json_decode( $data['settings']['igd_data'], true );
		$shortcode_data   = wp_parse_args( $saved_data, $default_data );
		$shortcode_render = Shortcode::instance()->render_shortcode( [], $shortcode_data );

		$field_id = $this->makeElementId( $data, $form ) . '_' . Helper::$formInstance;
		$prefill  = ( isset( $_REQUEST[ $field_id ] ) ? stripslashes( $_REQUEST[ $field_id ] ) : '' );

		$data['attributes']['type']  = 'hidden';
		$data['attributes']['id']    = $field_id;
		$data['attributes']['class'] = 'upload-file-list';
		$data['attributes']['value'] = $prefill;

		$elMarkup = "%s <input %s>";
		$elMarkup = sprintf( $elMarkup, $shortcode_render, $this->buildAttributes( $data['attributes'], $form ) );
		$html     = $this->buildElementMarkup( $elMarkup, $data, $form );

		echo apply_filters( 'fluenform_rendering_field_html_' . $elementName, $html, $data, $form );
	}

	/**
	 * @param $response string|array|number|null - Original input from form submission
	 * @param $field array - the form field component array
	 * @param $form_id - form id
	 *
	 * @return string
	 */
	public function renderResponse( $response, $field, $form_id ) {
		// $response is the original input from your user
		// you can now alter the $response and return
		$ashtml = true;

		return apply_filters( 'igd_render_form_field_data', $response, $ashtml, $this );
	}

	public function validateInput( $errorMessage, $field, $formData, $fields, $form ) {
		$fieldName = $field['name'];

		if ( empty( $formData[ $fieldName ] ) ) {
			return $errorMessage;
		}

		$value = $formData[ $fieldName ]; // This is the user input value

		$uploaded_files = json_decode( $value, true );

		$is_required = ! empty( $field['rules']['required']['value'] );
		if ( $is_required && ( empty( $uploaded_files ) || ( 0 === count( (array) $uploaded_files ) ) ) ) {
			return [ ArrayHelper::get( $field, 'raw.settings.validation_rules.required.message' ) ];
		}

		return $errorMessage;
	}

}

new FluentForms_Field();