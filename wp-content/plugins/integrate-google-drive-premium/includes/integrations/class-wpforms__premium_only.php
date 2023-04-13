<?php

namespace IGD;

defined( 'ABSPATH' ) || exit;


// Add Group
add_filter( 'wpforms_builder_fields_buttons', function ( $fields ) {
	$tmp = [
		'integrate_google_drive' => [
			'group_name' => 'Integrate Google Drive',
			'fields'     => [],
		],
	];

	return array_slice( $fields, 0, 1, true ) + $tmp + array_slice( $fields, 1, count( $fields ) - 1, true );
}, 8 );

class WPForms extends \WPForms_Field {
	public function init() {

		// Define field type information.
		$this->name  = __( 'Google Drive', 'integrate-google-drive' );
		$this->type  = 'igd-uploader';
		$this->group = 'integrate_google_drive';
		$this->icon  = 'fa-cloud-upload fa-lg';
		$this->order = 3;

		add_action( 'wpforms_builder_enqueues', [ $this, 'enqueue_scripts' ] );

		// Display values in a proper way
		add_filter( 'wpforms_html_field_value', [ $this, 'html_field_value' ], 10, 4 );
		add_filter( 'wpforms_plaintext_field_value', [ $this, 'plain_field_value' ], 10, 3 );
		add_filter( 'wpforms_pro_admin_entries_export_ajax_get_data', [ $this, 'export_value' ], 10, 2 );

		add_action( 'wpforms_process_complete', [ $this, 'may_create_entry_folder' ], 10, 4 );
	}

	public function may_create_entry_folder( $fields, $entry, $form_data, $entry_id ) {
		$igd_fields = array_filter( $fields, function ( $field ) {
			return $field['type'] == 'igd-uploader';
		} );


		if ( ! empty( $igd_fields ) ) {
			foreach ( $igd_fields as $id => $field ) {
				$value = $field['value'];

				if ( empty( $value ) ) {
					continue;
				}

				$igd_data = json_decode( $form_data['fields'][ $id ]['data'], true );

				$create_entry_folder = ! empty( $igd_data['createEntryFolders'] );
				if ( ! $create_entry_folder ) {
					continue;
				}

				$entry_folder_name_template = ! empty( $igd_data['entryFolderNameTemplate'] ) ? $igd_data['entryFolderNameTemplate'] : 'Entry (%entry_id%) - %form_title% ';

				$files = json_decode( $value, true );

				$user_data = is_user_logged_in() ? get_userdata( get_current_user_id() ) : null;

				$tags = [
					'%form_title%'   => $form_data['settings']['form_title'],
					'%form_id%'      => $form_data['id'],
					'%entry_id%'     => $entry['id'],
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

	// Frontend - Field display on the form front-end.
	public function field_display( $field, $deprecated, $form_data ) {
		$data = json_decode( $field['data'], 1 );

		$data['type']           = 'uploader'; //shortcode type
		$data['isFormUploader'] = true;

		if ( ! empty( $field['required'] ) ) {
			$data['isRequired'] = true;
		}

		echo Shortcode::instance()->render_shortcode( [], $data );

		$field_id = sprintf( 'wpforms-%d-field_%d', $form_data['id'], $field['id'] );
		printf( "<input type='hidden' name='wpforms[fields][%d]' id='%s' class='upload-file-list'>", $field['id'], $field_id );
	}

	public function plain_field_value( $value, $field, $form_data ) {
		return $this->html_field_value( $value, $field, $form_data, false );
	}

	public function html_field_value( $value, $field, $form_data, $type ) {
		if ( $this->type !== $field['type'] ) {
			return $value;
		}

		// Reset $value as WPForms can truncate the content in e.g. the Entries table
		if ( isset( $field['value'] ) ) {
			$value = $field['value'];
		}

		$as_html = ( in_array( $type, [ 'entry-single', 'entry-table', 'email-html', 'smart-tag' ] ) );

		return apply_filters( 'igd_render_form_field_data', $value, $as_html );
	}

	public function export_value( $export_data, $request_data ) {
		foreach ( $export_data as $row_id => &$entry ) {
			if ( 0 === $row_id ) {
				continue; // Skip Headers
			}

			foreach ( $entry as $field_id => &$value ) {
				if ( $request_data['form_data']['fields'][ $field_id ]['type'] !== $this->type ) {
					continue; // Skip data that isn't related to this custom field
				}
				$value = $this->plain_field_value( $value, $request_data['form_data']['fields'][ $field_id ], $request_data['form_data'] );
			}
		}

		return $export_data;
	}


	/**
	 * Admin
	 * -----------------------------------------------------------------------------------------------------------------
	 * Format field value which is stored.
	 *
	 * @param int $field_id field ID
	 * @param mixed $field_submit field value that was submitted
	 * @param array $form_data form data and settings
	 */
	public function format( $field_id, $field_submit, $form_data ) {
		if ( $this->type !== $form_data['fields'][ $field_id ]['type'] ) {
			return;
		}

		$name = ! empty( $form_data['fields'][ $field_id ]['label'] ) ? sanitize_text_field( $form_data['fields'][ $field_id ]['label'] ) : '';

		wpforms()->process->fields[ $field_id ] = [
			'name'  => $name,
			'value' => $field_submit,
			'id'    => absint( $field_id ),
			'type'  => $this->type,
		];
	}

	// Enqueue scripts
	public function enqueue_scripts() {

		if ( empty( wp_styles()->registered['wp-components'] ) ) {
			wp_register_style( 'wp-components', includes_url( 'css/dist/components/style.css' ) );
		}

		Enqueue::instance()->admin_scripts( '', false );

	}

	// Field options panel inside the builder
	public function field_options( $field ) {
		// Options open markup.
		$this->field_option( 'basic-options', $field, [ 'markup' => 'open', ] );

		// Label
		$this->field_option( 'label', $field );

		// Description.
		$this->field_option( 'description', $field );

		ob_start(); ?>
        <div class="igd-form-uploader-config-wpforms" data-id="<?php echo esc_attr( $field['id'] ); ?>"></div>
		<?php

		$btn_container = ob_get_clean();

		$fld = $this->field_element(
			'text',
			$field,
			[
				'class' => 'igd-uploader-data',
				'slug'  => 'data',
				'name'  => __( 'Data', 'integrate-google-drive' ),
				'type'  => 'hidden',
				'value' => ! empty( $field['data'] ) ? $field['data'] : '',
			],
			false
		);

		$args = [
			'slug'    => 'data',
			'content' => $fld . $btn_container,
		];

		$this->field_element( 'row', $field, $args );

		// Required toggle.
		$this->field_option( 'required', $field );

		// Options close markup.
		$this->field_option(
			'basic-options', $field, [ 'markup' => 'close', ]
		);

		// Advanced field options

		// Options open markup.
		$this->field_option(
			'advanced-options',
			$field,
			[ 'markup' => 'open', ]
		);

		// Hide label.
		$this->field_option( 'label_hide', $field );

		// Custom CSS classes.
		$this->field_option( 'css', $field );

		// Options close markup.
		$this->field_option(
			'advanced-options',
			$field,
			[ 'markup' => 'close', ]
		);
	}

	// Field preview inside the builder.
	public function field_preview( $field ) {

		// Label.
		$this->field_preview_option( 'label', $field );

		// Description.
		$this->field_preview_option( 'description', $field );

		$default_data = [
			'id'             => $field['id'],
			'type'           => 'uploader',
			'isFormUploader' => true,
			'isRequired'     => ! empty( $field['required'] ),
		];

		$saved_data = ! empty( $field['data'] ) ? json_decode( $field['data'], 1 ) : [];

		$data = wp_parse_args( $saved_data, $default_data );

		echo Shortcode::instance()->render_shortcode( [], $data );

	}

}

new WPForms();