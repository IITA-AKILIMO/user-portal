<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Forminator_Group
 */
class Forminator_Group extends Forminator_Field {

	/**
	 * Default field title
	 *
	 * @var string
	 */
	public $name = '';

	/**
	 * Slug
	 *
	 * @var string
	 */
	public $slug = 'group';

	/**
	 * Type
	 *
	 * @var string
	 */
	public $type = 'group';

	/**
	 * Position this field type on Add Field popup
	 *
	 * @var int
	 */
	public $position = 26;

	/**
	 * Options
	 *
	 * @var array
	 */
	public $options = array();

	/**
	 * Category
	 *
	 * @var string
	 */
	public $category = 'standard';

	/**
	 * Icon CSS class
	 *
	 * @var string
	 */
	public $icon = 'sui-icon forminator-icon-group';

	/**
	 * Forminator_Group constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->name = __( 'Field Group', 'forminator' );
	}

	/**
	 * Field defaults
	 *
	 * @return array
	 */
	public function defaults() {
		return array(
			'field_label' => __( 'Field Group', 'forminator' ),
			'is_repeater' => 'true',
		);
	}

	/**
	 * Autofill Setting
	 *
	 * @param array $settings Field settings.
	 *
	 * @return array
	 */
	public function autofill_settings( $settings = array() ) {
		// Unsupported Autofill.
		$autofill_settings = array();

		return $autofill_settings;
	}

	/**
	 * Field front-end markup
	 *
	 * @param array                  $field Field.
	 * @param Forminator_Render_Form $views_obj Forminator_Render_Form object.
	 *
	 * @return mixed
	 */
	public function markup( $field, $views_obj ) {
		$wrappers = $views_obj::get_grouped_wrappers( $field['element_id'] );
		$options  = self::prepare_field_options( $field );
		$html     = '';

		if ( ! empty( $field['field_label'] ) ) {
			$html .= sprintf(
				'<label class="forminator-label forminator-repeater-label">%s</label>',
				esc_html( $field['field_label'] )
			);
		}

		if ( ! empty( $field['description'] ) ) {
			$html .= sprintf(
				'<span class="forminator-description forminator-repeater-description">%s</span>',
				esc_html( $field['description'] )
			);
		}

		$html .= '<div class="forminator-all-group-copies' . ( ! empty( $field['group_styles'] ) && 'custom' === $field['group_styles'] ? '' : ' forminator-repeater-field' ) . '">';

		$i = 1;
		do {
			if ( 1 < $i ) {
				$wrappers = array_map(
					function( $wrapper ) use ( $i ) {
						if ( empty( $wrapper['fields'] ) ) {
							return $wrapper;
						}
						$wrapper['fields'] = array_map(
							function( $field ) use ( $i ) {
								$field['group_suffix'] = '-' . $i;
								return $field;
							},
							$wrapper['fields']
						);
						return $wrapper;
					},
					$wrappers
				);
			}
			$html .= '<div class="forminator-grouped-fields" data-options="' . esc_attr( wp_json_encode( $options ) ) . '">';
			$html .= $views_obj->render_wrappers( $wrappers );

			if ( $options['is_repeater'] && ( 'custom' !== $options['min_type'] || 'custom' !== $options['max_type']
					|| $options['max'] > $options['min'] ) ) {
				$html .= self::render_action_buttons( $options );
			}
			$html .= '</div>';
		} while ( ! empty( $views_obj->draft_data[ $field['element_id'] . '-copies' ] ) && $views_obj->draft_data[ $field['element_id'] . '-copies' ]['value'] >= ( ++$i ) );

		$html .= '</div>';

		return $html;
	}

	/**
	 * Prepare field options
	 *
	 * @param array $field Field options.
	 * @return array
	 */
	private static function prepare_field_options( $field ) {
		$min_limit_type = empty( $field['min_limit_type'] ) || 'variable' !== $field['min_limit_type'] ? 'custom' : $field['min_limit_type'];
		$max_limit_type = empty( $field['max_limit_type'] ) || 'variable' !== $field['max_limit_type'] ? 'custom' : $field['max_limit_type'];

		if ( 'custom' === $min_limit_type ) {
			$min = empty( $field['min_limit'] ) || 1 > intval( $field['min_limit'] ) ? 1 : intval( $field['min_limit'] );
		} else {
			$min = empty( $field['min_limit_field'] ) ? 1 : $field['min_limit_field'];
		}

		if ( 'custom' === $max_limit_type ) {
			$max = empty( $field['max_limit'] ) || 1 > intval( $field['max_limit'] ) ? PHP_INT_MAX : intval( $field['max_limit'] );
		} else {
			$max = empty( $field['max_limit_field'] ) ? PHP_INT_MAX : $field['max_limit_field'];
		}

		return array(
			'is_repeater'         => empty( $field['is_repeater'] ) || 'true' === $field['is_repeater'],
			'min_type'            => $min_limit_type,
			'max_type'            => $max_limit_type,
			'min'                 => $min,
			'max'                 => $max,
			'add_text'            => empty( $field['add_action_text'] ) ? __( 'Add item', 'forminator' ) : $field['add_action_text'],
			'remove_text'         => empty( $field['remove_action_text'] ) ? __( 'Remove item', 'forminator' ) : $field['remove_action_text'],
			'action_element_type' => empty( $field['action_element_type'] ) ? 'button' : $field['action_element_type'],
		);
	}

	/**
	 * Get Repeater actions
	 *
	 * @param array $options Field options.
	 * @return string
	 */
	private static function render_action_buttons( $options ) {
		$html  = '<div class="forminator-row forminator-action-buttons">';
		$html .= '<div class="forminator-col forminator-col-12">';

		if ( 'icon' === $options['action_element_type'] ) {
			// Icons.
			$html .= '<button class="forminator-repeater-action-icon forminator-repeater-add"><span class="forminator-icon-add" aria-hidden="true"></span><span class="sui-screen-reader-text">'. esc_html( $options['add_text'] ) .'</span></button>';
			$html .= '<button class="forminator-repeater-action-icon forminator-repeater-remove"><span class="forminator-icon-remove" aria-hidden="true"></span><span class="sui-screen-reader-text">' . esc_html( $options['remove_text'] ) . '</span></button>';
		} elseif ( 'link' === $options['action_element_type'] ) {
			// Links.
			$html .= '<a href="#" class="forminator-repeater-action-link forminator-repeater-add">' . esc_html( $options['add_text'] ) . '</a>';
			$html .= '<a href="#" class="forminator-repeater-action-link forminator-repeater-remove">' . esc_html( $options['remove_text'] ) . '</a>';
		} else {
			// Buttons.
			$html .= '<input type="button" value="' . esc_attr( $options['add_text'] ) . '" class="forminator-repeater-action-button forminator-repeater-add" />';
			$html .= '<input type="button" value="' . esc_attr( $options['remove_text'] ) . '" class="forminator-repeater-action-button forminator-repeater-remove" />';
		}

		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}
}
