<?php

/**
 * Automatic YouTube Gallery Gutenberg Block.
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package Automatic_YouTube_Gallery
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * AYG_Block class.
 *
 * @since 1.0.0
 */
class AYG_Block {

	/**
	 * Register our custom block category.
	 *
	 * @since  1.0.0
	 * @param  array $categories Default block categories.
	 * @return array             Modified block categories.
	 */
	public function block_categories( $categories ) {		
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'automatic-youtube-gallery',
					'title' => __( 'Automatic YouTube Gallery', 'automatic-youtube-gallery' ),
				),
			)
		);		
	}

	/**
	 * Enqueue block assets for backend editor.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_block_editor_assets() {
		$fields = ayg_get_editor_fields();
			
		foreach ( $fields as $key => $section ) {
			foreach ( $section['fields'] as $_key => $field ) {
				if ( isset( $field['description'] ) ) {
					$fields[ $key ]['fields'][ $_key ]['description'] = strip_tags( $field['description'] );
				}
			}
		}

		// Scripts
		wp_enqueue_script(
			'ayg-block-js',
			plugins_url( '/block/dist/blocks.build.js', dirname( __FILE__ ) ),
			array( 'wp-blocks', 'wp-i18n', 'wp-element' ),
			filemtime( plugin_dir_path( __DIR__ ) . 'block/dist/blocks.build.js' ),
			true
		);

		wp_localize_script( 
			'ayg-block-js', 
			'ayg_block',
			array(
				'options' => $fields,
				'i18n'    => array(
					'block_description' => __( 'Create automated YouTube galleries.', 'automatic-youtube-gallery' ),
					'block_title'       => __( 'Automatic YouTube Gallery', 'automatic-youtube-gallery' ),					
					'selected_color'    => __( 'Selected Color', 'automatic-youtube-gallery' ),
					'spinner_message'   => __( 'Waiting to finish your block configuration. This delay is to avoid frequent YouTube API calls.', 'automatic-youtube-gallery' )
				)
			)			
		);
	}

	/**
	 * Register our custom block.
	 * 
	 * @since 1.0.0
	 */
	public function register_block_type() {
		// Hook the post rendering to the block
		if ( function_exists( 'register_block_type' ) ) {			
			$attributes = array(
				'is_admin' => array(
					'type' => 'boolean'
				),
				'uid' => array(
					'type' => 'string'
				)
			);

			$fields = ayg_get_editor_fields();

			foreach ( $fields as $key => $section ) {
				foreach ( $section['fields'] as $field ) {
					$type = 'string';

					if ( 'number' == $field['type'] ) {
						$type = 'number';
					} elseif ( 'checkbox' == $field['type'] ) {
						$type = 'boolean';
					}

					$attributes[ $field['name'] ] = array(
						'type' => $type
					);
				}
			}

			register_block_type( 'automatic-youtube-gallery/block', array(
				'attributes'      => $attributes,
				'render_callback' => array( $this, 'render_block' ),
			));
		}
	}

	/**
	 * Render the block frontend.
	 *
	 * @since  1.0.0
	 * @param  array  $atts An associative array of attributes.
	 * @return string       HTML output.
	 */
	public function render_block( $atts ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        	return;
		}

		if ( ! empty( $atts['is_admin'] ) ) {			
			$atts['autoplay'] = false;
			$atts['autoadvance'] = false;
		}

		if ( ! empty( $atts['uid'] ) ) {			
			$atts['uid'] = md5( $atts['uid'] );
		}

		return ayg_build_gallery( $this->clean_attributes( $atts ) );
	}

	/**
	 * Clean attributes array.
	 * 
	 * @since  1.0.0
	 * @access private
	 * @param  array   $atts Array of attributes.
	 * @return array         Cleaned attributes array.
	 */
	private function clean_attributes( $atts ) {
		$attributes = array();
		
		foreach ( $atts as $key => $value ) {
			if ( is_null( $value ) ) {
				continue;
			}

			if ( is_bool( $value ) ) {
				$value = ( true === $value ) ? 1 : 0;
			}

			$attributes[ $key ] = $value;
		}
		
		return $attributes;
	}

}
