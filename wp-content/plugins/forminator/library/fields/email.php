<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Forminator_Email
 *
 * @since 1.0
 */
class Forminator_Email extends Forminator_Field {

	/**
	 * @var string
	 */
	public $name = '';

	/**
	 * @var string
	 */
	public $slug = 'email';

	/**
	 * @var int
	 */
	public $position = 2;

	/**
	 * @var string
	 */
	public $type = 'email';

	/**
	 * @var array
	 */
	public $options = array();

	/**
	 * @var string
	 */
	public $category = 'standard';

	/**
	 * @var bool
	 */
	public $is_input = true;

	/**
	 * @var string
	 */
	public $icon = 'sui-icon-mail';

	/**
	 * Forminator_Email constructor.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		parent::__construct();
		$this->name = __( 'Email', 'forminator' );
	}

	/**
	 * Field defaults
	 *
	 * @since 1.0
	 * @return array
	 */
	public function defaults() {
		return array(
			'validation'  => false,
			'placeholder' => __( 'E.g. john@doe.com', 'forminator' ),
			'field_label' => __( 'Email Address', 'forminator' ),
		);
	}

	/**
	 * Autofill Setting
	 *
	 * @since 1.0.5
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
	public function autofill_settings( $settings = array() ) {
		$providers = apply_filters( 'forminator_field_' . $this->slug . '_autofill', array(), $this->slug );

		$autofill_settings = array(
			'email' => array(
				'values' => forminator_build_autofill_providers( $providers ),
			),
		);

		return $autofill_settings;
	}

	/**
	 * Field front-end markup
	 *
	 * @since 1.0
	 *
	 * @param $field
	 * @param Forminator_Render_Form $views_obj Forminator_Render_Form object.
	 *
	 * @return mixed
	 */
	public function markup( $field, $views_obj, $draft_value = null ) {

		$settings            = $views_obj->model->settings;
		$this->field         = $field;
		$this->form_settings = $settings;

		$html        = '';
		$id          = self::get_property( 'element_id', $field );
		$name        = $id;
		$design      = $this->get_form_style( $settings );
		$ariaid      = $id;
		$id          = 'forminator-field-' . $id . '_' . Forminator_CForm_Front::$uid;
		$required    = self::get_property( 'required', $field, false );
		$ariareq     = 'false';
		$placeholder = $this->sanitize_value( self::get_property( 'placeholder', $field ) );
		$value       = esc_html( self::get_property( 'value', $field ) );
		$label       = esc_html( self::get_property( 'field_label', $field ) );
		$description = esc_html( self::get_property( 'description', $field ) );

		if ( (bool) $required ) {
			$ariareq = 'true';
		}

		if ( isset( $draft_value['value'] ) ) {

			$value = esc_attr( $draft_value['value'] );

		} elseif ( $this->has_prefill( $field ) ) {

			// We have pre-fill parameter, use its value or $value.
			$value = $this->get_prefill( $field, $value );
		}

		$email_attr = array(
			'type'          => 'email',
			'name'          => $name,
			'value'         => $value,
			'placeholder'   => $placeholder,
			'id'            => $id,
			'class'         => 'forminator-input forminator-email--field',
			'data-required' => $required,
			'aria-required' => $ariareq,
		);

		$autofill_markup = $this->get_element_autofill_markup_attr( self::get_property( 'element_id', $field ) );

		$email_attr = array_merge( $email_attr, $autofill_markup );

		$html .= '<div class="forminator-field">';

			$html .= self::create_input(
				$email_attr,
				$label,
				$description,
				$required,
				$design
			);

		$html .= '</div>';

		return apply_filters( 'forminator_field_email_markup', $html, $id, $required, $placeholder, $value );
	}

	/**
	 * Return field inline validation rules
	 *
	 * @since 1.0
	 * @return string
	 */
	public function get_validation_rules() {
		$field       = $this->field;
		$id          = self::get_property( 'element_id', $field );
		$rules       = '"' . $this->get_id( $field ) . '": {' . "\n";
		$is_validate = self::get_property( 'validation', $field, false );
		if ( $this->is_required( $field ) ) {
			$rules .= '"required": true,';
		}

		if ( $is_validate ) {
			$rules .= '"emailWP": true,';
		} else {
			$rules .= '"email": false,';
		}

		$rules .= '},' . "\n";

		return apply_filters( 'forminator_field_email_validation_rules', $rules, $id, $field );
	}

	/**
	 * Return field inline validation errors
	 *
	 * @since 1.0
	 * @return string
	 */
	public function get_validation_messages() {
		$field              = $this->field;
		$id                 = $this->get_id( $field );
		$is_validate        = self::get_property( 'validation', $field );
		$validation_message = self::get_property( 'validation_message', $field, __( 'This is not a valid email.', 'forminator' ) );

		$validation_message = htmlentities( $validation_message );

		$messages = '"' . $id . '": {' . "\n";

		if ( $this->is_required( $field ) ) {
			$default_required_error_message =
				$this->get_field_multiple_required_message(
					$id,
					$field,
					'required_message',
					'',
					__( 'This field is required. Please input a valid email.', 'forminator' )
				);
			$messages                      .= '"required": "' . forminator_addcslashes( $default_required_error_message ) . '",' . "\n";
		}

		if ( $is_validate ) {
			$messages .= '"emailWP": "' . forminator_addcslashes( $validation_message ) . '",' . "\n";
			$messages .= '"email": "' . forminator_addcslashes( $validation_message ) . '",' . "\n";
		}

		$messages .= '},' . "\n";

		$messages = apply_filters(
			'forminator_email_field_validation_message',
			$messages,
			$id,
			$field,
			$validation_message
		);

		return $messages;
	}

	/**
	 * Field back-end validation
	 *
	 * @since 1.0
	 *
	 * @param array        $field
	 * @param array|string $data
	 *
	 * @return bool
	 */
	public function validate( $field, $data ) {
		$id                 = self::get_property( 'element_id', $field );
		$is_validate        = self::get_property( 'validation', $field );
		$validation_message = self::get_property( 'validation_message', $field, __( 'This is not a valid email.', 'forminator' ) );
		if ( $this->is_required( $field ) ) {
			$required_error_message =
				$this->get_field_multiple_required_message(
					$id,
					$field,
					'required_message',
					'',
					__( 'This field is required. Please input a valid email.', 'forminator' )
				);

			if ( empty( $data ) ) {
				$this->validation_message[ $id ] = $required_error_message;
				return false;
			}
		}

		if ( $is_validate && ! empty( $data ) ) {
			$validation_message = htmlentities( $validation_message );
			if ( 320 < strlen( $data ) || ! is_email( $data ) || ! filter_var( $data, FILTER_VALIDATE_EMAIL ) ) {
				$this->validation_message[ $id ] = $validation_message;
			}
		}
	}

	/**
	 * Sanitize data
	 *
	 * @since 1.0.2
	 *
	 * @param array        $field
	 * @param array|string $data - the data to be sanitized.
	 *
	 * @return array|string $data - the data after sanitization
	 */
	public function sanitize( $field, $data ) {
		$original_data = $data;
		$is_validate   = self::get_property( 'validation', $field );

		// Sanitize email.
		if ( is_string( $data ) ) {
			if ( $is_validate ) {
				$data = sanitize_email( $data );
			} else {
				$data = sanitize_text_field( $data );
			}
		}

		return apply_filters( 'forminator_field_email_sanitize', $data, $field, $original_data );
	}
}
