<?php
/**
 * Forminator Addon Mailerlite form hooks.
 *
 * @package Forminator
 */

/**
 * Class Forminator_Mailerlite_Form_Hooks
 *
 * Hooks that used by Mailerlite Integration defined here
 */
class Forminator_Mailerlite_Form_Hooks extends Forminator_Integration_Form_Hooks {

	/**
	 * Return special integration args
	 *
	 * @param array $submitted_data Submitted data.
	 * @param array $addon_setting_values Integration settings.
	 * @return array
	 */
	protected function get_special_addon_args( $submitted_data, $addon_setting_values ) {
		// If double opt in enabled, we need to send this data to API to make sure the subscriber will receive the confirmation email.
		if ( ! empty( $addon_setting_values['enable_double_opt_in'] ) ) {
			return array(
				'enable_double_opt_in' => true,
			);
		}
		return array();
	}
}
