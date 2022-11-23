<?php

namespace KentaCompanion\Utils;

class IO {

	/**
	 * Append content to the file.
	 *
	 * @param $content
	 * @param $file_path
	 * @param string $separator_text
	 *
	 * @return bool|\WP_Error
	 */
	public function append_to_file( $content, $file_path, $separator_text = '' ) {
		// Verify WP file-system credentials.
		$verified_credentials = self::check_wp_filesystem_credentials();

		if ( is_wp_error( $verified_credentials ) ) {
			return $verified_credentials;
		}

		// By this point, the $wp_filesystem global should be working, so let's use it to create a file.
		global $wp_filesystem;

		$existing_data = '';
		if ( file_exists( $file_path ) ) {
			$existing_data = $wp_filesystem->get_contents( $file_path );
		}

		// Style separator.
		$separator = PHP_EOL . '---' . $separator_text . '---' . PHP_EOL;

		if ( ! $wp_filesystem->put_contents( $file_path, $existing_data . $separator . $content . PHP_EOL ) ) {
			return new \WP_Error(
				'failed_writing_file_to_server',
				sprintf( /* translators: %1$s - br HTML tag, %2$s - file path */
					__( 'An error occurred while writing file to your server! Tried to write a file to: %1$s%2$s.', 'kenta-companion' ),
					'<br>',
					$file_path
				)
			);
		}

		return true;
	}

	/**
	 * Get data from a file
	 *
	 * @param string $file_path file path where the content should be saved.
	 *
	 * @return string|\WP_Error $data
	 */
	public function data_from_file( $file_path ) {
		// Verify WP file-system credentials.
		$verified_credentials = $this->check_wp_filesystem_credentials();

		if ( is_wp_error( $verified_credentials ) ) {
			return $verified_credentials;
		}

		// By this point, the $wp_filesystem global should be working, so let's use it to read a file.
		global $wp_filesystem;

		$data = $wp_filesystem->get_contents( $file_path );

		if ( ! $data ) {
			return new \WP_Error(
				'failed_reading_file_from_server',
				sprintf( /* translators: %1$s - br HTML tag, %2$s - file path */
					__( 'An error occurred while reading a file from your server! Tried reading file from path: %1$s%2$s.', 'kenta-companion' ),
					'<br>',
					$file_path
				)
			);
		}

		// Return the file data.
		return $data;
	}

	/**
	 * Write content to a file.
	 *
	 * @param string $content content to be saved to the file.
	 * @param string $file_path file path where the content should be saved.
	 *
	 * @return string|\WP_Error path to the saved file or WP_Error object with error message.
	 */
	public function write_to_file( $content, $file_path ) {
		// Verify WP file-system credentials.
		$verified_credentials = $this->check_wp_filesystem_credentials();

		if ( is_wp_error( $verified_credentials ) ) {
			return $verified_credentials;
		}

		// By this point, the $wp_filesystem global should be working, so let's use it to create a file.
		global $wp_filesystem;

		if ( ! $wp_filesystem->put_contents( $file_path, $content ) ) {
			return new \WP_Error(
				'failed_writing_file_to_server',
				sprintf( /* translators: %1$s - br HTML tag, %2$s - file path */
					__( 'An error occurred while writing file to your server! Tried to write a file to: %1$s%2$s.', 'kenta-companion' ),
					'<br>',
					$file_path
				)
			);
		}

		// Return the file path on successful file write.
		return $file_path;
	}

	/**
	 * Deletes a file or directory.
	 *
	 * @param $file
	 * @param false $recursive
	 * @param false $type
	 *
	 * @return bool|\WP_Error True on success, false on failure.
	 */
	public function delete( $file, $recursive = false, $type = false ) {

		// Verify WP file-system credentials.
		$verified_credentials = $this->check_wp_filesystem_credentials();

		if ( is_wp_error( $verified_credentials ) ) {
			return $verified_credentials;
		}

		// By this point, the $wp_filesystem global should be working, so let's use it to create a file.
		global $wp_filesystem;

		return $wp_filesystem->delete( $file, $recursive, $type );
	}

	/**
	 * Helper function: check for WP file-system credentials needed for reading and writing to a file.
	 *
	 * @return boolean|\WP_Error
	 */
	private function check_wp_filesystem_credentials() {

		// Check if the file-system method is 'direct', if not display an error.
		if ( ! ( 'direct' === get_filesystem_method() ) ) {
			return new \WP_Error(
				'no_direct_file_access',
				sprintf( /* translators: %1$s and %2$s - strong HTML tags, %3$s - HTML link to a doc page. */
					__( 'This WordPress page does not have %1$sdirect%2$s write file access. This plugin needs it in order to save the demo import xml file to the upload directory of your site. You can change this setting with these instructions: %3$s.', 'kenta-companion' ),
					'<strong>',
					'</strong>',
					'<a href="http://gregorcapuder.com/wordpress-how-to-set-direct-filesystem-method/" target="_blank">How to set <strong>direct</strong> filesystem method</a>'
				)
			);
		}

		// Get plugin page settings.
		$plugin_page_setup = kcmp_plugin_starter_page();

		// Get user credentials for WP file-system API.
		$demo_import_page_url = wp_nonce_url( $plugin_page_setup['parent_slug'] . '?page=' . $plugin_page_setup['menu_slug'], $plugin_page_setup['menu_slug'] );

		if ( false === ( $creds = request_filesystem_credentials( $demo_import_page_url, '', false, false, null ) ) ) {
			return new \WP_error(
				'filesystem_credentials_could_not_be_retrieved',
				__( 'An error occurred while retrieving reading/writing permissions to your server (could not retrieve WP filesystem credentials)!', 'kenta-companion' )
			);
		}

		// Now we have credentials, try to get the wp_filesystem running.
		if ( ! \WP_Filesystem( $creds ) ) {
			return new \WP_Error(
				'wrong_login_credentials',
				__( 'Your WordPress login credentials don\'t allow to use WP_Filesystem!', 'kenta-companion' )
			);
		}

		return true;
	}
}