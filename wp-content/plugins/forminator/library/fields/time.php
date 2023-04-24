<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Forminator_Time
 *
 * @property  array field
 * @since 1.0
 */
class Forminator_Time extends Forminator_Field {

	/**
	 * @var string
	 */
	public $name = '';

	/**
	 * @var string
	 */
	public $slug = 'time';

	/**
	 * @var string
	 */
	public $type = 'time';

	/**
	 * @var int
	 */
	public $position = 13;

	/**
	 * @var array
	 */
	public $options = array();

	/**
	 * @var string
	 */
	public $category = 'standard';

	/**
	 * @var string
	 */
	public $icon = 'sui-icon-clock';

	/**
	 * Forminator_Time constructor.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		parent::__construct();

		$this->name = __( 'Timepicker', 'forminator' );
	}

	/**
	 * Field defaults
	 *
	 * @since 1.0
	 * @return array
	 */
	public function defaults() {
		return array(
			'field_type'     => 'input',
			'time_type'      => 'twelve',
			'field_label'    => '',
			'hh_label'       => __( 'Hours', 'forminator' ),
			'hh_placeholder' => __( 'E.g. 08', 'forminator' ),
			'mm_label'       => __( 'Minutes', 'forminator' ),
			'mm_placeholder' => __( 'E.g. 00', 'forminator' ),
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
		$hours_providers   = apply_filters( 'forminator_field_' . $this->slug . '_hours_autofill', array(), $this->slug . '_hours' );
		$minutes_providers = apply_filters( 'forminator_field_' . $this->slug . '_minutes_autofill', array(), $this->slug . '_minutes' );
		$ampm_providers    = apply_filters( 'forminator_field_' . $this->slug . '_ampm_autofill', array(), $this->slug . '_ampm' );

		$autofill_settings = array(
			'time-hours'   => array(
				'values' => forminator_build_autofill_providers( $hours_providers ),
			),
			'time-minutes' => array(
				'values' => forminator_build_autofill_providers( $minutes_providers ),
			),
			'time-ampm'    => array(
				'values' => forminator_build_autofill_providers( $ampm_providers ),
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

		$settings    = $views_obj->model->settings;
		$this->field = $field;

		$html     = '';
		$id       = self::get_property( 'element_id', $field );
		$name     = $id;
		$required = self::get_property( 'required', $field, false, 'bool' );
		$design   = $this->get_form_style( $settings );
		// backward compatibilty when time doesnt have field_type.
		$field_type       = trim( self::get_property( 'field_type', $field, 'input' ) );
		$type             = trim( self::get_property( 'time_type', $field ) );
		$field_label      = esc_html( self::get_property( 'field_label', $field ) );
		$description      = self::get_property( 'description', $field, '' );
		$default_time     = esc_html( self::get_property( 'default_time', $field, '' ) );
		$increment_hour   = self::get_property( 'increment_hour', $field, 0 );
		$increment_minute = self::get_property( 'increment_minute', $field, 0 );
		$restrict_time    = self::get_property( 'restrict_time', $field, 'none' );
		$has_limiter      = 'specific' === $restrict_time ? 'has-time-limiter' : '';
		$required_origin  = $required;
		$draft_value      = isset( $draft_value['value'] ) ? $draft_value['value'] : '';
		$uniq_id          = Forminator_CForm_Front::$uid;

		$default_time_hour   = '';
		$default_time_minute = '';
		$default_time_ampm   = '';

		if ( 'default' === $default_time ) {
			$default_time_hour   = self::get_property( 'default_time_hour', $field, '' );
			$default_time_minute = self::get_property( 'default_time_minute', $field, '' );
			$default_time_ampm   = self::get_property( 'default_time_ampm', $field, '' );
		}

		// Parse prefill settings.
		$prefill = $this->parse_prefill( $field );

		if ( ! empty( $draft_value ) ) {

			if ( isset( $draft_value['hours'] ) ) {
				$default_time_hour = trim( $draft_value['hours'] );
			}

			if ( isset( $draft_value['minutes'] ) ) {
				$default_time_minute = trim( $draft_value['minutes'] );
			}

			if ( isset( $draft_value['ampm'] ) ) {
				$default_time_ampm = strtolower( trim( $draft_value['ampm'] ) );
			}
		} elseif ( ! empty( $prefill ) ) {
			if ( isset( $prefill['hour'] ) ) {
				$default_time_hour = $prefill['hour'];
			}

			if ( isset( $prefill['minutes'] ) ) {
				$default_time_minute = $prefill['minutes'];
			}

			if ( isset( $prefill['suffix'] ) ) {
				$default_time_ampm = strtolower( $prefill['suffix'] );
			}
		}

		if ( ! empty( $field_label ) ) {

			if ( $required ) {

				$html .= sprintf(
					'<label id="%s" class="forminator-label">%s %s</label>',
					'forminator-field-' . $id,
					$field_label,
					forminator_get_required_icon()
				);

			} else {

				$html .= sprintf(
					'<label id="%s" class="forminator-label">%s</label>',
					'forminator-field-' . $id,
					$field_label
				);
			}

			// mark hours and minutes required markup as false.
			$required = false;
		}

		$html .= '<div class="forminator-timepicker" ';
			if ( 'twelve' === $type && 'specific' === $restrict_time ) {
				$is_12_hr = 'twelve' === $type ? true : false;
				$html    .= 'data-start-limit="' . esc_attr( $this->get_time_limiter( $field, 'start', $is_12_hr ) ) . '" ';
				$html    .= 'data-end-limit="' . esc_attr( $this->get_time_limiter( $field, 'end', $is_12_hr ) ) . '"';
			}
		$html .= '>';

			$html .= '<div class="forminator-row" data-multiple="true">';

				// Determinate field cols.
				$cols = ( 'twelve' === $type ) ? 4 : 6;

				/**
				 * Create hours field
				 */
				$hours = array(
					'type'             => 'number',
					'name'             => $id . '-hours',
					'min'              => '0',
					'max'              => ( 'twelve' === $type ) ? '12' : '23',
					'placeholder'      => $this->sanitize_value( self::get_property( 'hh_placeholder', $field ) ),
					'id'               => 'forminator-field-' . $id . '-hours' . '_' . $uniq_id,
					'class'            => 'forminator-input time-hours ' . $has_limiter,
					'data-field'       => 'hours',
					'aria-describedby' => 'forminator-field-' . $id . '_' . $uniq_id . '-description',
				);

				$hours ['value'] = '0';
				if ( isset( $default_time_hour ) ) {
					$hours ['value'] = $default_time_hour;
				}

				if ( ! empty( $increment_hour ) ) {
					$hours ['step'] = (int) $increment_hour;
					$hours ['min']  = '0';
				}

				$html .= sprintf( '<div id="%s " class="forminator-col forminator-col-%s">', $hours['name'], $cols );

					$html .= '<div class="forminator-field">';

				if ( 'select' === $field_type ) {

					$hours_data = array(
						'name'             => $id . '-hours',
						'id'               => 'forminator-form-' . $settings['form_id'] . '__field--' . $id . '-hours' . '_' . $uniq_id,
						'class'            => 'forminator-select2 time-hours ' . $has_limiter,
						'data-field'       => 'hours',
						'aria-describedby' => 'forminator-field-' . $id . '_' . $uniq_id . '-description',
					);

					$limits = array();
					if ( 'twentyfour' === $type && 'specific' === $restrict_time ) {
						$limits = array(
							'start' => self::get_property( 'restrict_start_hour', $field, 0 ),
							'end'   => self::get_property( 'restrict_end_hour', $field, 0 ),
						);
					}

					$html .= self::create_select(
						$hours_data,
						self::get_property( 'hh_label', $field ),
						$this->get_hours( $type, $increment_hour, $default_time_hour, $limits ),
						$default_time_hour,
						'',
						$required
					);
				} else {

					$html .= self::create_input(
						$hours,
						self::get_property( 'hh_label', $field ),
						'',
						$required,
						$design
					);
				}

					$html .= '</div>';

				$html .= '</div>';

				/**
				 * Create mintues field
				 */
				$minutes = array(
					'type'        => 'number',
					'min'         => 0,
					'max'         => 59,
					'name'        => $id . '-minutes',
					'placeholder' => $this->sanitize_value( self::get_property( 'mm_placeholder', $field ) ),
					'id'          => 'forminator-field-' . $id . '-minutes' . '_' . $uniq_id,
					'class'       => 'forminator-input time-minutes ' . $has_limiter,
					'data-field'  => 'minutes',
					'aria-describedby' => 'forminator-field-' . $id . '_' . $uniq_id . '-description',
				);

				$minutes ['value'] = '0';
				if ( isset( $default_time_minute ) ) {
					$minutes ['value'] = $default_time_minute;
				}

				if ( ! empty( $increment_minute ) ) {
					$minutes ['step'] = (int) $increment_minute;
				}

				$html .= sprintf( '<div id="%s" class="forminator-col forminator-col-%s">', $minutes['name'], $cols );

					$html .= sprintf( '<div class="forminator-field">', $cols );

				if ( 'select' === $field_type ) {

					$minutes_data = array(
						'name'       => $id . '-minutes',
						'id'         => 'forminator-form-' . $settings['form_id'] . '__field--' . $id . '-minutes' . '_' . $uniq_id,
						'class'      => 'forminator-select2 time-minutes ' . $has_limiter,
						'data-field' => 'minutes',
						'aria-describedby' => 'forminator-field-' . $id . '_' . $uniq_id . '-description',
					);

					$html .= self::create_select(
						$minutes_data,
						self::get_property( 'mm_label', $field ),
						$this->get_minutes( $type, $increment_minute, $default_time_minute, $required_origin ),
						$default_time_minute,
						'',
						$required
					);
				} else {

					$html .= self::create_input(
						$minutes,
						self::get_property( 'mm_label', $field ),
						'',
						$required,
						$design
					);
				}

					$html .= '</div>';

				$html .= '</div>';

				if ( 'twelve' === $type ) {

					/**
					 * Create AM/PM field
					 */
					$ampm = array(
						'name'       => $id . '-ampm',
						'id'         => 'forminator-form-' . $settings['form_id'] . '__field--' . $id . '-ampm' . '_' . $uniq_id,
						'class'      => 'forminator-select2 time-ampm ' . $has_limiter,
						'data-field' => 'ampm',
						'aria-describedby' => 'forminator-field-' . $id . '_' . $uniq_id . '-description',
					);

					$options = array(

						array(
							'value' => 'am',
							'label' => __( 'AM', 'forminator' ),
						),

						array(
							'value' => 'pm',
							'label' => __( 'PM', 'forminator' ),
						),
					);

					$ampm_value = '';

					if ( ! empty( $default_time_ampm ) ) {
						$ampm_value = $default_time_ampm;
					}

					$html .= sprintf( '<div class="forminator-col forminator-col-%s">', $cols );

						$html .= '<div class="forminator-field">';

							$html .= self::create_select(
								$ampm,
								'',
								$options,
								$ampm_value
							);

						$html .= '</div>';

					$html .= '</div>';

				}

				$html .= '</div>';

				$html .= '</div>';

				$html .= self::get_description( $description, 'forminator-field-' . $id . '_' . $uniq_id );

				return apply_filters( 'forminator_field_time_markup', $html, $field );
	}

	/**
	 * Return hours
	 *
	 * @since 1.0.5
	 *
	 * @param $type
	 * @param $increment_hour
	 * @param string|int     $default_value Default value.
	 * @param array          $limits - The limits for 24hr format, 12hr limits are handled in the FE
	 *
	 * TO DO: Placeholder bug can be fixed here and in get_minutes
	 *
	 * @return array
	 */
	public function get_hours( $type, $increment_hour, $default_value, $limits = array() ) {
		$array = array();
		if ( 'twelve' === $type ) {
			$min = 1;
			$max = 12;
		} else {
			if ( ! empty( $limits ) ) {
				$min = $limits['start'];
				$max = $limits['end'];
			} else {
				$min = 0;
				$max = 23;
			}
		}

		for ( $i = $min; $i <= $max; $i ++ ) {
			$array[] = array(
				'label' => sprintf( '%02d', $i ),
				'value' => $i,
			);

			if ( ! empty( $increment_hour ) ) {
				$i += $increment_hour - 1;
			}
		}

		// 12th option should be the first one for 12h format.
		if ( 'twelve' === $type ) {
			$last = array_pop( $array );
			array_unshift( $array, $last );
		}

		// Add hyphen option to the beginning of the list.
		if ( '' === $default_value ) {
			array_unshift(
				$array,
				array(
					'label' => '-',
					'value' => '',
				)
			);
		}

		return apply_filters( 'forminator_field_time_get_hours', $array, $this );
	}

	/**
	 * Return minutes
	 *
	 * @param string            $type twelve|twentyfour Format type.
	 * @param $increment_minutes
	 * @param string|int        $default_value Default value.
	 * @param bool              $required Is required or not.
	 *
	 * @since 1.0.5
	 * @return array
	 */
	public function get_minutes( $type, $increment_minutes, $default_value, $required ) {
		$array = array();

		for ( $i = 0; $i < 60; $i ++ ) {
			$array[] = array(
				'label' => sprintf( '%02d', $i ),
				'value' => $i,
			);

			if ( ! empty( $increment_minutes ) ) {
				$i += ( $increment_minutes % 60 ) - 1;
			}
		}

		// Add hyphen option to the beginning of the list.
		if ( '' === $default_value ) {
			array_unshift(
				$array,
				array(
					'label' => '-',
					'value' => '',
				)
			);
		}

		return apply_filters( 'forminator_field_time_get_minutes', $array, $this );
	}

	/**
	 * Return field inline validation rules
	 *
	 * @since 1.0
	 * @return string
	 */
	public function get_validation_rules() {
		$field         = $this->field;
		$id            = self::get_property( 'element_id', $field );
		$is_required   = $this->is_required( $field );
		$type          = self::get_property( 'time_type', $field, 'twelve' );
		$restrict_time = self::get_property( 'restrict_time', $field, 'none' );
		$rules         = '';

		if ( 'specific' === $restrict_time || $is_required ) {
			$components  = array( 'hours', 'minutes' );
			$start_limit = 'twelve' === $type ? $this->get_time_limiter( $field ) : $this->get_time_limiter( $field, 'start', false );
			$end_limit   = 'twelve' === $type ? $this->get_time_limiter( $field, 'end' ) : $this->get_time_limiter( $field, 'end', false );
			$time_limit  = array(
				'start_limit' => $start_limit,
				'end_limit'   => $end_limit,
			);

			foreach ( $components as $part ) {
				$rules .= '"' . $this->get_id( $field ) . '-' . $part . '": {';

				if ( $is_required ) {
					$rules .= '"required": true,';
				}
				if ( 'specific' === $restrict_time && 'minutes' !== $part ) {
					$rules .= '"timeLimit": ' . json_encode( $time_limit ) . ',';
				}

				$rules .= '},';
			}
		}

		return apply_filters( 'forminator_field_time_validation_rules', $rules, $id, $field );
	}

	/**
	 * Return field inline validation errors
	 *
	 * @since 1.0
	 * @return string
	 */
	public function get_validation_messages() {
		$field            = $this->field;
		$id               = self::get_property( 'element_id', $field );
		$required_message = self::get_property( 'required_message', $field, '' );
		$type             = trim( self::get_property( 'time_type', $field, 'twelve' ) );
		$messages         = '';
		$hours_label      = self::get_property( 'hh_label', $field, 'Hours' );
		$minutes_label    = self::get_property( 'mm_label', $field, 'Minutes' );
		$restrict_time    = self::get_property( 'restrict_time', $field, 'none' );
		$start_limit      = 'twelve' === $type ? $this->get_time_limiter( $field ) : $this->get_time_limiter( $field, 'start', false );
		$end_limit        = 'twelve' === $type ? $this->get_time_limiter( $field, 'end' ) : $this->get_time_limiter( $field, 'end', false );
		$default_restrict_message = $this->get_default_restrict_message( $start_limit, $end_limit );
		$restrict_message = self::get_property( 'restrict_message', $field, $default_restrict_message );
		$restrict_message = apply_filters(
			'forminator_time_field_limit_validation_message',
			forminator_addcslashes( $restrict_message ),
			$id,
			$field
		);

		$messages .= '"' . $this->get_id( $field ) . '-hours": {' . "\n";
		$min_hour  = ( 'twelve' === $type ) ? '1' : '0';
		$max_hour  = ( 'twelve' === $type ) ? '12' : '23';
		$messages .= '"min": "' . sprintf(
			apply_filters(
				'forminator_time_field_hours_min_validation_message',
				/* translators: ... */
				__( 'Please enter a value greater than or equal to %1$s for %2$s.', 'forminator' )
			),
			$min_hour,
			forminator_addcslashes( $hours_label )
		) . '",' . "\n";

		$messages .= '"max": "' . sprintf(/* translators: ... */
			apply_filters( 'forminator_time_field_hours_max_validation_message', __( 'Please enter a value less than or equal to %1$s for %2$s.', 'forminator' ) ),
			$max_hour,
			forminator_addcslashes( $hours_label )
		) . '",' . "\n";
		$messages .= '"number": "' . sprintf(
			apply_filters(
				'forminator_time_field_hours_number_validation_message',
				/* translators: ... */
				__( 'Please enter a valid number for %1$s.', 'forminator' )
			),
			forminator_addcslashes( $hours_label )
		) . '",' . "\n";
		if ( $this->is_required( $field ) ) {
			// Hours validation.
			$hours_message = apply_filters(
				'forminator_time_field_hours_required_validation_message',
				( ! empty( $required_message ) ? '<strong>' . forminator_addcslashes( $hours_label ) . '</strong>: ' . forminator_addcslashes( $required_message ) : __( 'This field is required. Please input a valid hour.', 'forminator' ) ),
				$id,
				$field
			);

			$messages .= '"required": "' . $hours_message . '",' . "\n";
		}

		if ( 'specific' === $restrict_time ) {
			$messages .= '"timeLimit": "' . $restrict_message . '",' . "\n";
		}
		$messages .= '},' . "\n";

		// minutes.
		$messages .= '"' . $this->get_id( $field ) . '-minutes": {' . "\n";
		$messages .= '"min": "' . sprintf(/* translators: ... */
			apply_filters( 'forminator_time_field_minutes_min_validation_message', __( 'Please enter a value greater than or equal to 0 for %1$s.', 'forminator' ) ),
			forminator_addcslashes( $minutes_label )
		) . '",' . "\n";
		$messages .= '"max": "' . sprintf(
			apply_filters(
				'forminator_time_field_minutes_max_validation_message',
				/* translators: ... */
				__( 'Please enter a value less than or equal to 59 for %1$s.', 'forminator' )
			),
			forminator_addcslashes( $minutes_label )
		) . '",' . "\n";
		$messages .= '"number": "' . sprintf(
			apply_filters(
				'forminator_time_field_minutes_number_validation_message',
				/* translators: ... */
				__( 'Please enter a valid number for %1$s.', 'forminator' )
			),
			forminator_addcslashes( $minutes_label )
		) . '",' . "\n";
		if ( $this->is_required( $field ) ) {
			// Minutes validation.
			$minutes_message = apply_filters(
				'forminator_time_field_minutes_required_validation_message',
				( ! empty( $required_message ) ? '<strong>' . forminator_addcslashes( $minutes_label ) . '</strong>: ' . forminator_addcslashes( $required_message ) : __( 'This field is required. Please input a valid minute.', 'forminator' ) ),
				$id,
				$field
			);

			$messages .= '"required": "' . $minutes_message . '",' . "\n";
		}
		$messages .= '},' . "\n";

		return $messages;
	}

	/**
	 * Check if time is valid
	 *
	 * @since 1.10
	 *
	 * @param $hour
	 * @param $minute
	 * @param int    $format
	 *
	 * @return bool
	 */
	public function is_valid_time( $hour, $minute, $format = 24 ) {
		// Check if numeric values.
		if ( is_numeric( $hour ) && is_numeric( $minute ) ) {
			if ( 24 === $format ) {
				if ( ( $hour >= 0 && $hour < 24 ) && ( $minute >= 0 && $minute < 60 ) ) {
					return true;
				}
			} else {
				if ( ( $hour >= 0 && $hour < 13 ) && ( $minute >= 0 && $minute < 60 ) ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Parse prefill value
	 *
	 * @since 1.10
	 *
	 * @param $field
	 *
	 * @return array
	 */
	public function parse_prefill( $field ) {
		$value = array();
		$type  = trim( self::get_property( 'time_type', $field, 'twelve' ) );

		// Check if Pre-fill parameter used.
		if ( $this->has_prefill( $field ) ) {
			// We have pre-fill parameter, use its value or $value.
			$prefill = $this->get_prefill( $field, '' );

			if ( $prefill ) {
				// Check value length.
				$length = strlen( $prefill );

				// We have 24h format.
				if ( 5 === $length && 'twentyfour' === $type ) {
					$time = explode( ':', $prefill );

					if ( isset( $time[0] ) && isset( $time[1] ) ) {
						// Check if valid values.
						if ( $this->is_valid_time( $time[0], $time[1], 24 ) ) {
							$value = array(
								'hour'    => $time[0],
								'minutes' => $time[1],
							);
						}
					}
				}

				if ( 7 === $length && 'twelve' === $type ) {
					$time = explode( ':', $prefill );

					if ( isset( $time[0] ) && isset( $time[1] ) ) {
						if ( $this->is_valid_time( $time[0], substr( $time[1], 0, 2 ), 12 ) ) {
							$value = array(
								'hour'    => $time[0],
								'minutes' => substr( $time[1], 0, 2 ),
								'suffix'  => substr( $prefill, - 2 ),
							);
						}
					}
				}
			}
		}

		return $value;
	}

	/**
	 * Field back-end validation
	 *
	 * @since 1.0
	 *
	 * @param array        $field
	 * @param array|string $data
	 */
	public function validate( $field, $data ) {
		$isValid       = true;
		$type          = self::get_property( 'time_type', $field, 'twelve' );
		$restrict_time = self::get_property( 'restrict_time', $field, 'none' );
		$id            = self::get_property( 'element_id', $field );

		if ( $this->is_required( $field ) ) {
			$required_message = self::get_property( 'required_message', $field, '' );
			if ( empty( $data ) || ( ! empty( $data ) && '' === $data['hours'] ) ) {
				$isValid                                    = false;
				$this->validation_message[ $id . '-hours' ] = apply_filters(
					'forminator_time_field_hours_required_validation_message',
					( ! empty( $required_message ) ? $required_message : __( 'This field is required. Please input a valid hour.', 'forminator' ) ),
					$id,
					$field
				);
			}
			if ( empty( $data ) || ( ! empty( $data ) && '' === $data['minutes'] ) ) {
				$isValid                                      = false;
				$this->validation_message[ $id . '-minutes' ] = apply_filters(
					'forminator_time_field_minutes_required_validation_message',
					( ! empty( $required_message ) ? $required_message : __( 'This field is required. Please input a valid minute.', 'forminator' ) ),
					$id,
					$field
				);
			}
			// If required, hours and minutes cannot be both 0.
			if ( ! empty( $data ) && 'twelve' === $type && empty( $data['hours'] ) && empty( $data['minutes'] ) ) {
				$isValid                                    = false;
				$this->validation_message[ $id . '-hours' ] = apply_filters(
					'forminator_time_field_hours_required_validation_message',
					( ! empty( $required_message ) ? $required_message : __( 'This field is required. Hours and Minutes cannot be both 0.', 'forminator' ) ),
					$id,
					$field
				);
			}

			if ( ! $isValid ) {
				return;
			}
		}
		$hour                  = isset( $data['hours'] ) ? $data['hours'] : '';
		$minute                = isset( $data['minutes'] ) ? $data['minutes'] : '';
		$hours_error_message   = apply_filters(
			'forminator_time_field_minutes_validation_message',
			__( 'Please enter a valid hour.', 'forminator' ),
			$id,
			$field
		);
		$minutes_error_message = apply_filters(
			'forminator_time_field_minutes_validation_message',
			__( 'Please enter a valid minute.', 'forminator' ),
			$id,
			$field
		);
		if (
			( ! is_numeric( $hour ) && '' !== $hour ) ||
			( ! is_numeric( $minute ) && '' !== $minute )
		) {
			if ( ! is_numeric( $hour ) ) {
				$this->validation_message[ $id . '-hours' ] = $hours_error_message;
			}
			if ( ! is_numeric( $minute ) ) {
				$this->validation_message[ $id . '-minutes' ] = $minutes_error_message;
			}
		} else {
			// possible hour is string, because its sent from form data.
			$hour       = (int) $hour;
			$min_hour   = 0;
			$max_hour   = 'twelve' === $type ? 12 : 23;
			$max_minute = $hour > 23 ? 0 : 59;

			if ( $hour < $min_hour || $hour > $max_hour ) {
				$this->validation_message[ $id . '-hours' ] = $hours_error_message;
			}

			// In 12-hour format, hours cannot be 0 when minutes is not empty
			if ( 'twelve' === $type ) {
				if ( 0 === $hour ) {
					$max_minute = 0;
				}
				if ( $minute > $max_minute && $max_minute > 0 ) {
					$this->validation_message[ $id . '-minutes' ] = $minutes_error_message;
				}
				if ( empty( $hour ) && $minute > 0 ) {
					$this->validation_message[ $id . '-hours' ] = $hours_error_message;
				}
				if ( 0 === $minute && 0 === $hour ) {
					$this->validation_message[ $id . '-minutes' ] = $minutes_error_message;
					$this->validation_message[ $id . '-hours' ]   = $hours_error_message;
				}
			}
			// In military time, hours and minutes can be 0
			if ( 'twentyfour' === $type && $minute > $max_minute ) {
				$this->validation_message[ $id . '-minutes' ] = $minutes_error_message;
			}
		}
		// Reset $hour and $minute here.
		$hour   = isset( $data['hours'] ) ? $data['hours'] : '';
		$minute = isset( $data['minutes'] ) ? $data['minutes'] : '';
		if (
			'specific' === $restrict_time &&
			(
				( '' !== $hour && '' !== $minute ) ||
				( '' !== $hour && '' === $minute ) ||
				( '' === $hour && '' !== $minute )
			)
		) {

			if ( 'twelve' === $type ) {
				$data_time        = sprintf( '%02d', $hour ) . ':' . sprintf( '%02d', $minute ) . ' ' . $data['ampm'];
				$start_limit_time = $this->get_time_limiter( $field, 'start' );
				$end_limit_time   = $this->get_time_limiter( $field, 'end' );
			} else {
				$data_time        = sprintf( '%02d', $hour ) . ':' . sprintf( '%02d', $minute );
				$start_limit_time = $this->get_time_limiter( $field, 'start', false );
				$end_limit_time   = $this->get_time_limiter( $field, 'end', false );
			}
			if (
				( '' !== $hour && '' === $minute ) ||
				( '' === $hour && '' !== $minute ) ||
				strtotime( $data_time ) < strtotime( $start_limit_time ) ||
				strtotime( $data_time ) > strtotime( $end_limit_time )
			) {
				$default_restrict_message = $this->get_default_restrict_message( $start_limit_time, $end_limit_time );
				$this->validation_message[ $id . '-hours' ]   = apply_filters(
					'forminator_time_field_limit_validation_message',
					self::get_property( 'restrict_message', $field, $default_restrict_message ),
					$id,
					$field
				);
				$this->validation_message[ $id . '-minutes' ] = '';
				$this->validation_message[ $id . '-ampm' ]    = '';
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
		// Sanitize.
		if ( is_array( $data ) ) {
			$data = forminator_sanitize_array_field( $data );
		} else {
			$data = forminator_sanitize_field( $data );
		}

		return apply_filters( 'forminator_field_time_sanitize', $data, $field, $original_data );
	}

	/**
	 * Get the limiters for time
	 *
	 * @since 1.18.0
	 *
	 * @param array  $field - The field settings
	 * @param string $type - Either start or end
	 * @param bool   $is_12_hr
	 *
	 * @return string $time - the start of time limit
	 */
	public function get_time_limiter( $field, $type = 'start', $is_12_hr = true ) {
		$restrict_hour   = self::get_property( 'restrict_' . $type . '_hour', $field, 0 );
		$restrict_minute = self::get_property( 'restrict_' . $type . '_minute', $field, 0 );
		$meridiem        = self::get_property( 'restrict_' . $type . '_ampm', $field, 'am' );
		$meridiem        = $is_12_hr ? ' ' . $meridiem : '';

		return sprintf( '%02d', $restrict_hour ) . ':' . sprintf( '%02d', $restrict_minute ) . $meridiem;
	}

	/**
	 * Get the default message for Time limits
	 *
	 * @since 1.18.0
	 *
	 * @param string  $start_limit
	 * @param string $end_limit
	 *
	 * @return string
	 */
	public function get_default_restrict_message( $start_limit, $end_limit ) {
		return __( 'Please select a time within the specified time limits.', 'forminator' )
			. ' ('
			. str_replace( ' ', '', $start_limit )
			. ' - '
			. str_replace( ' ', '', $end_limit )
			. ')';
	}
}
