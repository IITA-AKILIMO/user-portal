<?php

namespace KentaCompanion\DemoImporter;
/**
 * A class that extends WP_Customize_Setting so we can access
 * the protected updated method when importing options.
 *
 * Used in the Customizer importer.
 *
 * Code is mostly from the OCDI plugin.
 *
 * @see https://wordpress.org/plugins/one-click-demo-import/
 * @package Kenta Companion
 */
final class CustomizerOption extends \WP_Customize_Setting {
	/**
	 * Import an option value for this setting.
	 *
	 * @param mixed $value The option value.
	 *
	 * @return void
	 */
	public function import( $value ) {
		$this->update( $value );
	}
}
