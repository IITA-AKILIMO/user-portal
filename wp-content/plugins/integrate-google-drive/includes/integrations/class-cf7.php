<?php

namespace IGD;

defined( 'ABSPATH' ) || exit;

class CF7 {
	/**
	 * @var null
	 */
	protected static $instance = null;

	public function __construct() {
		add_action( 'wpcf7_admin_init', [ $this, 'add_tag_generator' ], 99 );
		add_action( 'wpcf7_init', [ $this, 'add_data_handler' ] );
		add_filter( 'wpcf7_mail_tag_replaced_google_drive', [ $this, 'set_mail_tag' ], 10, 3 );
		add_filter( 'wpcf7_mail_tag_replaced_google_drive*', [ $this, 'set_mail_tag' ], 10, 3 );

		//after submit
		add_action( 'wpcf7_before_send_mail', [ $this, 'after_submit' ] );

		add_filter( 'wpcf7_validate_google_drive', [ $this, 'validate_field' ], 10, 2 );
		add_filter( 'wpcf7_validate_google_drive*', [ $this, 'validate_field' ], 10, 2 );

	}

	public function validate_field( $result, $tag ) {

		// Get the submitted form data
		$submission = \WPCF7_Submission::get_instance();

		// Check if the submission exists
		if ( $submission ) {
			// Get the value of your custom field
			$value = $submission->get_posted_data( $tag->name );

			// Perform validation (for example, checking if it's required and empty)
			$is_required = ( '*' == substr( $tag->type, - 1 ) );
			if ( $is_required && empty( $value ) ) {
				// Set an error for the field if it doesn't meet the requirements
				$result->invalidate( $tag, __( 'This field is required.', 'integrate-google-drive' ) );
			}
		}

		// Return the result object after validation
		return $result;
	}


	public function after_submit( $contact_form ) {
		$submission = \WPCF7_Submission::get_instance();

		if ( $submission ) {
			$posted_data = $submission->get_posted_data();

			$igd_fields = array_filter( $posted_data, function ( $field, $key ) {
				return strpos( $key, 'google_drive-' ) === 0;
			}, ARRAY_FILTER_USE_BOTH );

			if ( ! empty( $igd_fields ) ) {
				foreach ( $igd_fields as $key => $value ) {

					if ( empty( $value ) ) {
						continue;
					}

					$options  = $contact_form->scan_form_tags( [ 'name' => $key ] )[0]['options'][0];
					$igd_data = json_decode( base64_decode( str_replace( 'data:', '', $options ) ), true );

					$create_entry_folder = ! empty( $igd_data['createEntryFolders'] );
					if ( ! $create_entry_folder ) {
						continue;
					}

					$entry_folder_name_template = ! empty( $igd_data['entryFolderNameTemplate'] ) ? $igd_data['entryFolderNameTemplate'] : 'Entry (%entry_id%) - %form_title% ';

					$files = json_decode( $value, true );

					$tags = [
						'%form_title%' => $contact_form->title(),
						'%form_id%'    => $contact_form->id(),
						'%date%'       => date( 'Y-m-d' ),
						'%time%'       => date( 'H:i:s' ),
						'%unique_id%'  => uniqid(),
					];

					$upload_folder = $igd_data['folders'][0];

					Uploader::instance( $upload_folder['accountId'] )->create_entry_folder_and_move( $files, $entry_folder_name_template, $tags, $upload_folder );

				}
			}
		}

	}

	public function set_mail_tag( $output, $submission, $as_html ) {
		return apply_filters( 'igd_render_form_field_data', $submission, $as_html );
	}

	/**
	 * Add shortcode handler to CF7.
	 */
	public function add_data_handler() {
		if ( function_exists( 'wpcf7_add_form_tag' ) ) {
			wpcf7_add_form_tag( [ 'google_drive', 'google_drive*' ], [ $this, 'data_handler' ], true );
		}
	}

	public function data_handler( $tag ) {
		$tag = new \WPCF7_FormTag( $tag );

		if ( empty( $tag->name ) ) {
			return '';
		}

		// Validate our fields
		$validation_error = wpcf7_get_validation_error( $tag->name );

		$class = wpcf7_form_controls_class( $tag->type, 'upload-file-list igd-hidden' );

		if ( $validation_error ) {
			$class .= ' wpcf7-not-valid';
		}

		// Data
		$data                   = $tag->get_option( 'data', '', true );
		$data                   = json_decode( base64_decode( $data ), 1 );
		$data['isFormUploader'] = true;

		$required = ( '*' == substr( $tag->type, - 1 ) );
		if ( $required ) {
			$data['isRequired'] = true;
		}

		$atts = [
			'name'          => $tag->name,
			'class'         => $class,
			'tabindex'      => $tag->get_option( 'tabindex', 'signed_int', true ),
			'aria-invalid'  => $validation_error ? 'true' : 'false',
			'aria-required' => $tag->is_required() ? 'true' : 'false',
		];

		$atts = wpcf7_format_atts( $atts );


		$return = '<div class="wpcf7-form-control-wrap" data-name="' . esc_attr( $tag->name ) . '">';
		$return .= Shortcode::instance()->render_shortcode( [], $data );
		$return .= "<input " . $atts . " />";
		$return .= $validation_error;
		$return .= '</div>';

		return $return;
	}

	public function add_tag_generator() {
		if ( class_exists( 'WPCF7_TagGenerator' ) ) {
			$tag_generator = \WPCF7_TagGenerator::get_instance();
			$tag_generator->add( 'google_drive', __( 'Google Drive Upload', 'integrate-google-drive' ), [
				$this,
				'tag_generator_body'
			] );
		}
	}

	public function tag_generator_body( $contact_form, $args = '' ) {
		$args = wp_parse_args( $args, [] );
		$type = 'google_drive';

		$description = esc_html__( 'Generate a form-tag for this upload field.', 'integrate-google-drive' );
		?>
        <div class="control-box">
            <fieldset>
                <legend><?php echo esc_html( $description ); ?></legend>
                <table class="form-table">
                    <tbody>
                    <tr>
                        <th scope="row"><?php echo esc_html__( 'Field type', 'integrate-google-drive' ); ?></th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text"><?php echo esc_html__( 'Field type', 'integrate-google-drive' ); ?></legend>
                                <label>
                                    <input type="checkbox"
                                           name="required"/> <?php echo esc_html__( 'Required field', 'integrate-google-drive' ); ?>
                                </label>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>">
								<?php echo esc_html__( 'Name', 'integrate-google-drive' ); ?>
                            </label>
                        </th>
                        <td>
                            <input type="text" name="name" class="tg-name oneline"
                                   id="<?php echo esc_attr( $args['content'] . '-name' ); ?>"/>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="<?php echo esc_attr( $args['content'] . '-data' ); ?>">
								<?php echo esc_html__( 'Configure', 'integrate-google-drive' ); ?>
                            </label>
                        </th>
                        <td>
                            <input type="hidden" name="data" class="option oneline"
                                   id="<?php echo esc_attr( $args['content'] . '-data' ); ?>"/>
                            <div id="igd-form-uploader-config-cf7"></div>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </fieldset>
        </div>

        <div class="insert-box">
            <input type="text" name="<?php echo esc_attr( $type ); ?>" class="tag code" readonly="readonly"
                   onfocus="this.select()"/>

            <div class="submitbox">
                <input type="button" class="button button-primary insert-tag"
                       value="<?php echo esc_attr__( 'Insert Tag', 'integrate-google-drive' ); ?>"/>
            </div>

            <br class="clear"/>

            <p class="description mail-tag">
                <label for="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>">
					<?php printf( 'To list the uploads in your email, insert the mail-tag (%s) in the Mail tab.', '<strong><span class="mail-tag"></span></strong>' ); ?>
                    <input type="text" class="mail-tag code igd-hidden" readonly="readonly"
                           id="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>"/>
                </label>
            </p>
        </div>
		<?php
	}

	/**
	 * @return CF7|null
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

CF7::instance();