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
		$general_settings = ayg_get_option( 'ayg_general_settings' );
		
		// Register Styles
		wp_register_style( 
			AYG_SLUG . '-public', 
			AYG_URL . 'public/assets/css/public.min.css', 
			array(), 
			AYG_VERSION, 
			'all' 
		);

		// Enqueue Styles
		if ( ! empty( $general_settings['force_load_assets']['css'] ) ) {
			wp_enqueue_style( AYG_SLUG . '-public' );
		}
	}

	/**
	 * Enqueue scripts for the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function register_scripts() {
		$general_settings = ayg_get_option( 'ayg_general_settings' );
		$gallery_settings = ayg_get_option( 'ayg_gallery_settings' );
		$player_settings  = ayg_get_option( 'ayg_player_settings' );
		$privacy_settings = ayg_get_option( 'ayg_privacy_settings' );
		$strings_settings = ayg_get_option( 'ayg_strings_settings' );

		$scroll_top_offset = ( isset( $gallery_settings['scroll_top_offset'] ) && ! empty( $gallery_settings['scroll_top_offset'] ) ) ? (int) $gallery_settings['scroll_top_offset'] : 10;
		$scroll_top_offset = apply_filters( 'ayg_gallery_scrolltop_offset', $scroll_top_offset ); // Backward compatibility to 2.4.3
		$scroll_top_offset = apply_filters( 'ayg_gallery_scroll_top_offset', $scroll_top_offset );

		$show_more_label = ! empty( $strings_settings['show_more_label'] ) ? sanitize_text_field( $strings_settings['show_more_label'] ) : __( 'Show More', 'automatic-youtube-gallery' );
		$show_less_label = ! empty( $strings_settings['show_less_label'] ) ? sanitize_text_field( $strings_settings['show_less_label'] ) : __( 'Show Less', 'automatic-youtube-gallery' );

		$script_args = array(
			'plugin_url'            => AYG_URL,
			'plugin_version'        => AYG_VERSION,
			'ajax_url'              => admin_url( 'admin-ajax.php' ),
			'ajax_nonce'            => wp_create_nonce( 'ayg_ajax_nonce' ),	
			'current_page_url'      => get_permalink(),
			'current_gallery_id'    => get_query_var( 'ayg_gallery_id' ),					
			'player_type'           => isset( $player_settings['player_type'] ) ? sanitize_text_field( $player_settings['player_type'] ) : 'youtube',
			'player_color'          => isset( $player_settings['player_color'] ) ? sanitize_text_field( $player_settings['player_color'] ) : '#00b3ff',	
			'privacy_enhanced_mode' => isset( $player_settings['privacy_enhanced_mode'] ) ? (int) $player_settings['privacy_enhanced_mode'] : 0,
			'origin'                => '',
			'cookieconsent'         => 0,
			'top_offset'            => $scroll_top_offset,
			'i18n'                  => array(
				'show_more' => $show_more_label,
				'show_less' => $show_less_label
			)
		);

		if ( isset( $player_settings['origin'] ) && ! empty( $player_settings['origin'] ) ) {
			$url_parts = parse_url( site_url() );
			$script_args['origin'] = $url_parts['scheme'] . '://' . $url_parts['host'];
		}

		if ( ! isset( $_COOKIE['ayg_gdpr_consent'] ) ) {
			if ( ! empty( $privacy_settings['cookie_consent'] ) && ! empty( $privacy_settings['consent_message'] ) && ! empty( $privacy_settings['button_label'] ) ) {
				$script_args['cookieconsent'] = 1;
				$script_args['cookieconsent_message'] = wp_kses_post( trim( $privacy_settings['consent_message'] ) );
				$script_args['cookieconsent_button_label'] = esc_html( $privacy_settings['button_label'] );
			}
		}

		// Register Scripts
		$deps = array( 'jquery' );

		wp_register_script( 
			AYG_SLUG . '-plyr', 
			AYG_URL . 'vendor/plyr/plyr.polyfilled.js', 
			array(), 
			'3.7.8', 
			array( 'strategy' => 'defer' )  
		);		
		
		if ( empty( $general_settings['force_load_assets']['js'] ) ) {
			if ( isset( $player_settings['player_type'] ) && 'custom' == $player_settings['player_type'] ) {
				$deps[] = AYG_SLUG . '-plyr';
			}
		}

		wp_register_script( 
			AYG_SLUG . '-public', 
			AYG_URL . 'public/assets/js/public.min.js', 
			$deps, 
			AYG_VERSION, 
			array( 'strategy' => 'defer' )  
		);

		wp_localize_script( 
			AYG_SLUG . '-public', 
			'ayg_config', 
			$script_args
		);

		wp_register_script( 
			AYG_SLUG . '-theme-classic', 
			AYG_URL . 'public/assets/js/theme-classic.min.js', 
			array( 'jquery' ), 
			AYG_VERSION, 
			array( 'strategy' => 'defer' )  
		);

		// Enqueue Scripts
		if ( ! empty( $general_settings['force_load_assets']['js'] ) ) {
			wp_enqueue_script( AYG_SLUG . '-public' );
		}
	}

	/**
	 * Enqueue block assets inside the block editor (iframe).
	 *
	 * Hooked to enqueue_block_assets with an is_admin() guard so styles and scripts
	 * are injected inside the iframed block editor (WP 6.3+ / WP 7.0 always) only,
	 * and not duplicated on the front end where wp_enqueue_scripts already handles them.
	 *
	 * @since 2.7.2
	 */
	public function enqueue_block_assets() {
		if ( ! is_admin() ) {
			return;
		}

		$this->enqueue_editor_assets();
	}

	/**
	 * Enqueue the plugin's public styles and scripts in any editor context.
	 *
	 * Called by enqueue_block_assets() (WordPress block editor, guarded by is_admin())
	 * and hooked directly to Elementor actions so assets are also available in the
	 * Elementor editor panel and its frontend live-preview iframe:
	 *   - elementor/editor/after_enqueue_scripts  (admin context)
	 *   - elementor/preview/enqueue_scripts       (frontend context, is_admin() = false)
	 *
	 * @since 1.6.1
	 */
	public function enqueue_editor_assets() {
		// Styles
		$this->register_styles();
		wp_enqueue_style( AYG_SLUG . '-public' );

		// Scripts
		$this->register_scripts();

		wp_enqueue_script( AYG_SLUG . '-public' );
		wp_enqueue_script( AYG_SLUG . '-theme-classic' );
	}

	/**
	 * Process the shortcode [automatic_youtube_gallery].
	 *
	 * @since  1.0.0
	 * @param  array  $attributes An associative array of attributes.
	 * @param  string $content    Enclosing content.
	 * @return string             Shortcode HTML output.
	 */
	public function shortcode_automatic_youtube_gallery( $attributes, $content = null ) {
		if ( ! empty( $content ) ) {
			$attributes['content'] = $content;
		}

		return ayg_build_gallery( $attributes );
	}

	/**
	 * Load more videos.
	 *
	 * @since 1.0.0
	 */
	public function ajax_callback_load_videos() {
		// Security check
		check_ajax_referer( 'ayg_ajax_nonce', 'security' );	

		// Proceed safe
		$json        = array();
		$attributes  = array_map( 'sanitize_text_field', $_POST );
		$source_type = $attributes['type'];

		$api_params = array(
			'uid'        => $attributes['uid'],
			'type'       => $source_type,
			'src'        => $attributes['src'],
			'order'      => $attributes['order'], // works only when type=search
			'limit'      => (int) $attributes['limit'],
			'maxResults' => (int) $attributes['per_page'],
			'cache'      => (int) $attributes['cache'],
			'pageToken'  => $attributes['pageToken']
		);

		if ( ! empty( $attributes['searchTerm'] ) ) {
			$api_params['searchTerm'] = $attributes['searchTerm'];
		}

		$youtube_api = new AYG_YouTube_API();
		$response = $youtube_api->query( $api_params );

		if ( ! isset( $response->error ) ) {
			if ( isset( $response->page_info ) ) {
				$json = $response->page_info;
				$json['message'] = sprintf(
					_n( '%s video found matching your query.', '%s videos found matching your query.', $json['videos_found'], 'automatic-youtube-gallery' ), 
					number_format_i18n( $json['videos_found'] )
				);
			}

			if ( isset( $response->videos ) ) {
				$videos = $response->videos;
				$columns = (int) $attributes['columns'];

				ob_start();
				foreach ( $videos as $index => $video ) {
					$classes = array(); 
					$classes[] = 'ayg-video';
					$classes[] = 'ayg-video-' . $video->id;
					$classes[] = 'ayg-col';
					$classes[] = 'ayg-col-' . $columns;
					if ( $columns > 3 ) $classes[] = 'ayg-col-sm-3';
					if ( $columns > 2 ) $classes[] = 'ayg-col-xs-2';

					echo'<div class="' . implode( ' ', $classes ) . '">';
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
