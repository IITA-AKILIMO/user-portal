<?php

namespace IGD;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

\GFForms::include_addon_framework();

class GravityForms extends \GFAddOn {

	protected $_version = '2.0';
	protected $_min_gravityforms_version = '2.5';
	protected $_slug = 'integrate_google_drive';
	protected $_path = IGD_INCLUDES . '/integrations/class-gravityforms.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Google Drive Add-On for GravityForms';
	protected $_short_title = 'Google Drive Add-On';

	public function init() {
		parent::init();

		if ( ! $this->is_gravityforms_supported( $this->_min_gravityforms_version ) ) {
			return;
		}

		// Add default value for field
		add_action( 'gform_editor_js_set_default_values', [ $this, 'field_defaults' ] );

		// Add a custom setting to the field
		add_action( 'gform_field_standard_settings', [ $this, 'custom_field_settings' ], 10, 2 );

		// Filter to add the tooltip for the field
		add_filter( 'gform_tooltips', [ $this, 'add_tooltip' ] );

		// Add support for wpDataTables <> Gravity Form integration
		if ( class_exists( 'WPDataTable' ) ) {
			add_action( 'wpdatatables_before_get_table_metadata', [ $this, 'render_wpdatatables_field' ], 10, 1 );
		}

		// Deprecated hooks, but still in use by e.g. GravityView + GravityFlow?
		add_filter( 'gform_entry_field_value', [ $this, 'filter_entry_field_value' ], 10, 4 );

		\GF_Fields::register( new GravityForms_Field() );

		//Preview scripts
		add_action( 'gform_preview_header', function () {
			Enqueue::instance()->frontend_scripts();
		} );

		add_action( 'gform_after_submission', [ $this, 'may_create_entry' ], 10, 2 );
	}

	public function may_create_entry( $entry, $form ) {
		// Get integrate_google_drive type fields
		$igd_fields = array_filter( $form['fields'], function ( $field ) {
			return $field->type == 'integrate_google_drive';
		} );

		if ( ! empty( $igd_fields ) ) {
			foreach ( $igd_fields as $field ) {
				$value = $entry[ $field->id ];

				if ( empty( $value ) ) {
					continue;
				}

				$igd_data = json_decode( $field->igdData, true );

				$create_entry_folder = ! empty( $igd_data['createEntryFolders'] );
				if ( ! $create_entry_folder ) {
					continue;
				}

				$entry_folder_name_template = ! empty( $igd_data['entryFolderNameTemplate'] ) ? $igd_data['entryFolderNameTemplate'] : 'Entry (%entry_id%) - %form_title%';

				$files = json_decode( $value, true );

				$tags = [
					'%form_title%'   => $form['title'],
					'%form_id%'      => $form['id'],
					'%entry_id%'     => $entry['id'],
					'%user_id%'      => $entry['created_by'],
					'%user_login%'   => get_userdata( $entry['created_by'] )->user_login,
					'%user_email%'   => get_userdata( $entry['created_by'] )->user_email,
					'%display_name%' => get_userdata( $entry['created_by'] )->display_name,
					'%date%'         => date( 'Y-m-d' ),
					'%time%'         => date( 'H:i:s' ),
					'%unique_id%'    => uniqid(),
				];

				$upload_folder = $igd_data['folders'][0];

				Uploader::instance( $upload_folder['accountId'] )->create_entry_folder_and_move( $files, $entry_folder_name_template, $tags, $upload_folder );
			}
		}

	}


	public function custom_field_settings( $position, $form_id ) {
		if ( 1430 == $position ) { ?>
            <li class="igd_settings field_setting">
                <label><?php esc_html_e( 'Configure', 'integrate-google-drive' ); ?><?php echo gform_tooltip( 'form_field_' . $this->_slug ); ?></label>
                <input type="hidden" class="igd-uploader-data" onchange="SetFieldProperty('igdData', this.value)"/>
                <div class="igd-form-uploader-config-gravityforms"></div>
            </li>
			<?php
		}
	}

	public function add_tooltip( $tooltips ) {
		$tooltips[ 'form_field_' . $this->_slug ] = esc_html__( 'Configure the uploader field.', 'integrate-google-drive' );

		return $tooltips;
	}

	public function field_defaults() {
		?>
        case 'integrate_google_drive':
        field.label = <?php echo json_encode( esc_html__( 'Attach your documents', 'integrate-google-drive' ) ); ?>;
        break;
		<?php
	}

	public function render_wpdatatables_field( $tableId ) {
		add_filter( 'gform_get_input_value', [ $this, 'entry_field_value' ], 10, 4 );
	}

	public function filter_entry_field_value( $value, $field, $entry, $form ) {
		return $this->entry_field_value( $value, $entry, $field, null );
	}

	public function entry_field_value( $value, $entry, $field, $input_id ) {
		if ( 'integrate_google_drive' !== $field->type ) {
			return $value;
		}

		return apply_filters( 'igd_render_form_field_data', html_entity_decode( $value ), true, $this );
	}
}

class GravityForms_Field extends \GF_Field {
	public $type = 'integrate_google_drive';
	public $defaultValue = '';

	public function get_form_editor_field_title() {
		return __( 'Google Drive', 'integrate-google-drive' );
	}

	public function add_button( $field_groups ) {
		$field_groups = $this->maybe_add_field_group( $field_groups );

		return parent::add_button( $field_groups );
	}

	public function maybe_add_field_group( $field_groups ) {
		foreach ( $field_groups as $field_group ) {
			if ( 'igd_group' == $field_group['name'] ) {
				return $field_groups;
			}
		}

		$field_groups[] = [
			'name'   => 'igd_group',
			'label'  => __( 'Integrate Google Drive Fields', 'integrate-google-drive' ),
			'fields' => [],
		];

		return $field_groups;
	}

	public function get_form_editor_button() {
		return [
			'group' => 'igd_group',
			'text'  => $this->get_form_editor_field_title(),
		];
	}

	public function get_form_editor_field_icon() {
		return 'gform-icon--upload';
	}

	public function get_form_editor_field_description() {
		return esc_attr__( 'Let users attach files to this form. The files will be stored in the Google Drive', 'integrate-google-drive' );
	}

	public function get_form_editor_field_settings() {
		return [
			'conditional_logic_field_setting',
			'error_message_setting',
			'label_setting',
			'label_placement_setting',
			'admin_label_setting',
			'rules_setting',
			'visibility_setting',
			'duplicate_setting',
			'description_setting',
			'css_class_setting',
			'igd_settings',
		];
	}

	public function get_value_default() {
		return $this->is_form_editor() ? $this->defaultValue : \GFCommon::replace_variables_prepopulate( $this->defaultValue );
	}

	public function is_conditional_logic_supported() {
		return false;
	}

	public function get_field_input( $form, $value = '', $entry = null ) {
		$form_id         = $form['id'];
		$is_entry_detail = $this->is_entry_detail();
		$id              = $this->id;

		if ( $is_entry_detail ) {
			$input = "<input type='hidden' id='input_{$id}' name='input_{$id}' value='{$value}' />";

			return $input . '<br/>' . esc_html__( 'This field is not editable', 'integrate-google-drive' );
		}

		$default_data = [
			'id'             => $id,
			'type'           => 'uploader',
			'isFormUploader' => true,
			'isRequired'     => ! empty( $this->isRequired ),
		];

		$saved_data = json_decode( $this->igdData, 1 );

		$data = wp_parse_args( $saved_data, $default_data );

		$input = Shortcode::instance()->render_shortcode( '', $data );

		$input .= "<input type='hidden' name='input_" . $id . "' id='input_" . $form_id . '_' . $id . "'  class='upload-file-list' value='" . ( isset( $_REQUEST[ 'input_' . $id ] ) ? stripslashes( $_REQUEST[ 'input_' . $id ] ) : '' ) . "'>";

		return $input;
	}


	public function validate( $value, $form ) {
		if ( ! $this->isRequired ) {
			return;
		}

		// Get information uploaded files from hidden input
		$attached_files = json_decode( $value );

		if ( empty( $attached_files ) ) {
			$this->failed_validation = true;

			if ( ! empty( $this->errorMessage ) ) {
				$this->validation_message = $this->errorMessage;
			} else {
				$this->validation_message = esc_html__( 'This field is required. Please upload your files.', 'integrate-google-drive' );
			}
		}
	}

	public function get_value_merge_tag( $value, $input_id, $entry, $form, $modifier, $raw_value, $url_encode, $esc_html, $format, $nl2br ) {
		return $this->renderUploadedFiles( html_entity_decode( $value ), ( 'html' === $format ) );
	}

	public function get_value_entry_detail( $value, $currency = '', $use_text = false, $format = 'html', $media = 'screen' ) {
		return $this->renderUploadedFiles( html_entity_decode( $value ), ( 'html' === $format ) );
	}

	public function get_value_entry_list( $value, $entry, $field_id, $columns, $form ) {
		if ( ! empty( $value ) ) {
			return $this->renderUploadedFiles( html_entity_decode( $value ) );
		}
	}

	public function get_value_export( $entry, $input_id = '', $use_text = false, $is_csv = false ) {
		$value = rgar( $entry, $input_id );

		return $this->renderUploadedFiles( html_entity_decode( $value ), false );
	}

	public function renderUploadedFiles( $data, $as_html = true ) {
		return apply_filters( 'igd_render_form_field_data', $data, $as_html, $this );
	}

	public function get_field_container_tag( $form ) {
		if ( \GFCommon::is_legacy_markup_enabled( $form ) ) {
			return parent::get_field_container_tag( $form );
		}

		return 'fieldset';
	}
}

new GravityForms();
