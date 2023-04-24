<?php

/**
 * The public-facing functionality of the plugin.
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
 * AYG_Public class.
 *
 * @since 1.0.0
 */
class AYG_Public {

	/**
	 * Get things started.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_shortcode( 'automatic_youtube_gallery', array( $this, 'shortcode_automatic_youtube_gallery' ) );
	}	

	/**
	 * Enqueue styles for the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function register_styles() {
		wp_register_style( 
			AYG_SLUG . '-public', 
			AYG_URL . 'public/assets/css/public.css', 
			array(), 
			AYG_VERSION, 
			'all' 
		);
	}

	/**
	 * Enqueue scripts for the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function register_scripts() {
		wp_register_script( 
			AYG_SLUG . '-public', 
			AYG_URL . 'public/assets/js/public.js', 
			array( 'jquery' ), 
			AYG_VERSION, 
			false 
		);

		$script_args = array(
			'current_url'   => get_permalink(),
			'ajax_url'      => admin_url( 'admin-ajax.php' ),
			'ajax_nonce'    => wp_create_nonce( 'ayg_ajax_nonce' ),
			'gallery_id'    => get_query_var( 'ayg_gallery' ),
			'video_id'      => get_query_var( 'ayg_video' ),
			'cookie_consent'=> 0,
			'top_offset'    => apply_filters( 'ayg_gallery_scrolltop_offset', 10 ),
			'i18n'          => array(
				'show_more' => '[+] ' . __( 'Show More', 'automatic-youtube-gallery' ),
				'show_less' => '[-] ' . __( 'Show Less', 'automatic-youtube-gallery' )
			)
		);

		if ( ! isset( $_COOKIE['ayg_gdpr_consent'] ) ) {
			$privacy_settings = get_option( 'ayg_privacy_settings' );

			if ( ! empty( $privacy_settings['cookie_consent'] ) && ! empty( $privacy_settings['consent_message'] ) && ! empty( $privacy_settings['button_label'] ) ) {
				$script_args['cookie_consent'] = 1;
				$script_args['consent_message'] = wp_kses_post( trim( $privacy_settings['consent_message'] ) );
				$script_args['button_label'] = esc_html( $privacy_settings['button_label'] );
			}
		}

		wp_localize_script( 
			AYG_SLUG . '-public', 
			'ayg_public', 
			$script_args
		);
	}

	/**
	 * Enqueue Gutenberg block assets for backend editor.
	 *
	 * @since 1.6.1
	 */
	public function enqueue_block_editor_assets() {
		// Styles
		$this->register_styles();
		wp_enqueue_style( AYG_SLUG . '-public' );

		// Scripts
		$this->register_scripts();
		wp_enqueue_script( AYG_SLUG . '-public' );
	}

	/**
	 * Process the shortcode [automatic_youtube_gallery].
	 *
	 * @since  1.0.0
	 * @param  array  $attributes An associative array of attributes.
	 * @return string             Shortcode HTML output.
	 */
	public function shortcode_automatic_youtube_gallery( $attributes ) {
		return ayg_build_gallery( $attributes );
	}

	/**
	 * Load more videos.
	 *
	 * @since 1.0.0
	 */
	public function ajax_callback_load_more_videos() {
		// Security check
		check_ajax_referer( 'ayg_ajax_nonce', 'security' );	

		// Proceed safe
		$json        = array();
		$attributes  = array_map( 'sanitize_text_field', $_POST );
		$source_type = $attributes['type'];

		$api_params = array(
			'type'       => $source_type,
			'src'        => $attributes['src'],
			'order'      => $attributes['order'], // works only when type=search
			'maxResults' => (int) $attributes['per_page'],
			'cache'      => (int) $attributes['cache'],
			'pageToken'  => $attributes['pageToken']
		);

		$youtube_api = new AYG_YouTube_API();
		$response = $youtube_api->query( $api_params );

		if ( ! isset( $response->error ) ) {
			if ( isset( $response->page_info ) ) {
				$json = $response->page_info;
			}

			if ( isset( $response->videos ) ) {
				$videos = $response->videos;

				ob_start();
				foreach ( $videos as $index => $video ) {
					echo'<div class="ayg-item ayg-col ayg-col-' . (int) $attributes['columns'] . '">';
					the_ayg_gallery_thumbnail( $video, $attributes );
					echo '</div>';
				}
				$json['html'] = ob_get_clean();
			}	

			wp_send_json_success( $json );			
		} else {
			$json['message'] =  $response->error_message;
			wp_send_json_error( $json );			
		}		
	}

	/**
	 * Set cookie for accepting the privacy consent.
	 *
	 * @since 2.0.0
	 */
	public function set_gdpr_cookie() {	
		// Security check
		check_ajax_referer( 'ayg_ajax_nonce', 'security' );	

		// Proceed safe
		setcookie( 'ayg_gdpr_consent', 1, time() + ( 30 * 24 * 60 * 60 ), COOKIEPATH, COOKIE_DOMAIN );		
		wp_send_json_success();			
	}

	/**
	 * [SMUSH] Skip YouTube iframes from lazy loading.
	 *
	 * @since  1.5.0
	 * @param  bool   $skip Should skip? Default: false.
	 * @param  string $src  Iframe url.
	 * @return bool
	 */
	public function smush( $skip, $src ) {
		return false !== strpos( $src, 'youtube' );
	}

}
