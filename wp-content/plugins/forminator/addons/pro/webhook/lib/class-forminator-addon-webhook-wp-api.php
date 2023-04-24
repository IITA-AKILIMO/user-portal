<?php

require_once dirname( __FILE__ ) . '/class-forminator-addon-webhook-wp-api-exception.php';
require_once dirname( __FILE__ ) . '/class-forminator-addon-webhook-wp-api-not-found-exception.php';

/**
 * Class Forminator_Addon_Webhook_Wp_Api
 */
class Forminator_Addon_Webhook_Wp_Api {

	/**
	 * Instances ofwebhook api
	 * key is md5(_endpoint)
	 *
	 * @var array
	 */
	private static $_instances = array();

	/**
	 * Webhook endpoint of static webhook
	 *
	 * @var string
	 */
	private $_endpoint = '';

	/**
	 * Last data sent towebhook
	 *
	 *
	 * @var array
	 */
	private $_last_data_sent = array();

	/**
	 * Last data received fromwebhook
	 *
	 *
	 * @var array
	 */
	private $_last_data_received = array();

	/**
	 * Last URL requested
	 *
	 *
	 * @var string
	 */
	private $_last_url_request = '';

	/**
	 * Forminator_Addon_Webhook_Wp_Api constructor.
	 *
	 *
	 *
	 * @param $_endpoint
	 *
	 * @throws Forminator_Addon_Webhook_Wp_Api_Exception
	 */
	public function __construct( $_endpoint ) {
		global $wpdb;
		$wpdb->last_error;
		//prerequisites
		if ( ! $_endpoint ) {
			throw new Forminator_Addon_Webhook_Wp_Api_Exception( __( 'Missing required Static Webhook URL', 'forminator' ) );
		}

		$this->_endpoint = $_endpoint;
	}

	/**
	 * Get singleton
	 *
	 *
	 *
	 * @param string $_endpoint
	 *
	 * @return Forminator_Addon_Webhook_Wp_Api|null
	 * @throws Forminator_Addon_Webhook_Wp_Api_Exception
	 */
	public static function get_instance( $_endpoint ) {
		if ( ! isset( self::$_instances[ md5( $_endpoint ) ] ) ) {
			self::$_instances[ md5( $_endpoint ) ] = new self( $_endpoint );
		}

		return self::$_instances[ md5( $_endpoint ) ];
	}

	/**
	 * Add custom user agent on request
	 *
	 *
	 *
	 * @param $user_agent
	 *
	 * @return string
	 */
	public function filter_user_agent( $user_agent ) {
		$user_agent .= ' ForminatorWebhook/' . FORMINATOR_ADDON_WEBHOOK_VERSION;

		/**
		 * Filter user agent to be used bywebhook api
		 *
		 * @since 1.1
		 *
		 * @param string $user_agent current user agent.
		 */
		$user_agent = apply_filters_deprecated( 'forminator_addon_zapier_api_user_agent', array( $user_agent ), '1.18.0', 'forminator_addon_webhook_api_user_agent' );
		$user_agent = apply_filters( 'forminator_addon_webhook_api_user_agent', $user_agent );

		return $user_agent;
	}

	/**
	 * HTTP Request
	 *
	 *
	 *
	 * @param string $verb
	 * @param        $path
	 * @param array  $args
	 *
	 * @return array|mixed|object
	 * @throws Forminator_Addon_Webhook_Wp_Api_Exception
	 * @throws Forminator_Addon_Webhook_Wp_Api_Not_Found_Exception
	 */
	private function request( $verb, $path, $args = array() ) {
		// Adding extra user agent for wp remote request.
		add_filter( 'http_headers_useragent', array( $this, 'filter_user_agent' ) );

		$url  = trailingslashit( $this->_endpoint ) . $path;
		$verb = ! empty( $verb ) ? $verb : 'GET';

		/**
		 * Filterwebhook url to be used on sending api request
		 *
		 * @since 1.1
		 *
		 * @param string $url  full url with scheme.
		 * @param string $verb `GET` `POST` `PUT` `DELETE` `PATCH`.
		 * @param string $path requested path resource.
		 * @param array  $args argument sent to this function.
		 */
		$url = apply_filters_deprecated( 'forminator_addon_zapier_api_url', array( $url, $verb, $path, $args ), '1.18.0', 'forminator_addon_webhook_api_url' );
		$url = apply_filters( 'forminator_addon_webhook_api_url', $url, $verb, $path, $args );

		$this->_last_url_request = $url;

		$headers = array(
			'Accept'       => 'application/json',
			'Content-Type' => 'application/json',
		);

		/**
		 * Filterwebhook headers to sent on api request
		 *
		 * @since 1.1
		 *
		 * @param array  $headers
		 * @param string $verb `GET` `POST` `PUT` `DELETE` `PATCH`.
		 * @param string $path requested path resource.
		 * @param array  $args argument sent to this function.
		 */
		$headers = apply_filters_deprecated( 'forminator_addon_zapier_api_request_headers', array( $headers, $verb, $path, $args ), '1.18.0', 'forminator_addon_webhook_api_request_headers' );
		$headers = apply_filters( 'forminator_addon_webhook_api_request_headers', $headers, $verb, $path, $args );

		$_args = array(
			'method'  => $verb,
			'headers' => $headers,
		);

		// X-Hook-Test handler.
		if ( isset( $args['is_test'] ) ) {
			if ( true === $args['is_test'] ) {
				// Add `X-Hook-Test` header to avoid execute task onwebhook.
				$_args['headers']['X-Hook-Test'] = 'true';
			}
			// always unset when exist.
			unset( $args['is_test'] );
		}

		$request_data = $args;
		/**
		 * Filterwebhook request data to be used on sending api request
		 *
		 * @since 1.1
		 *
		 * @param array  $request_data it will be `http_build_query`-ed when `GET` or `wp_json_encode`-ed otherwise.
		 * @param string $verb         `GET` `POST` `PUT` `DELETE` `PATCH`.
		 * @param string $path         requested path resource.
		 */
		$args = apply_filters_deprecated( 'forminator_addon_zapier_api_request_data', array( $request_data, $verb, $path ), '1.18.0', 'forminator_addon_webhook_api_request_data' );
		$args = apply_filters( 'forminator_addon_webhook_api_request_data', $args, $verb, $path );

		if ( 'GET' === $verb ) {
			$url .= ( '?' . http_build_query( $args ) );
		} else {
			$_args['body'] = wp_json_encode( $args );
		}

		$this->_last_data_sent = $args;

		$res         = wp_remote_request( $url, $_args );
		$wp_response = $res;

		remove_filter( 'http_headers_useragent', array( $this, 'filter_user_agent' ) );

		if ( is_wp_error( $res ) || ! $res ) {
			forminator_addon_maybe_log( __METHOD__, $res );
			throw new Forminator_Addon_Webhook_Wp_Api_Exception(
				__( 'Failed to process request, make sure your Webhook URL is correct and your server has internet connection.', 'forminator' )
			);
		}

		if ( isset( $res['response']['code'] ) ) {
			$status_code = $res['response']['code'];
			$msg         = '';
			if ( $status_code >= 400 ) {
				if ( isset( $res['response']['message'] ) ) {
					$msg = $res['response']['message'];
				}

				if ( strpos( $url, 'trayapp.io' ) ) {
					throw new Forminator_Addon_Webhook_Wp_Api_Exception( esc_html__( 'Failed to process request : Enable Tray.io workflow first', 'forminator' ) );
				}

				if ( 404 === $status_code ) {
					/* translators: ... */
					throw new Forminator_Addon_Webhook_Wp_Api_Not_Found_Exception( sprintf( __( 'Failed to process request : %s', 'forminator' ), esc_html( $msg ) ) );
				}
				/* translators: ... */
				throw new Forminator_Addon_Webhook_Wp_Api_Exception( sprintf( __( 'Failed to process request : %s', 'forminator' ), esc_html( $msg ) ) );
			}
		}

		$body = wp_remote_retrieve_body( $res );

		// probably silent mode.
		if ( ! empty( $body ) ) {
			$res = json_decode( $body );
		}

		$response = $res;
		/**
		 * Filterwebhook api response returned to addon
		 *
		 * @since 1.1
		 *
		 * @param mixed          $response    original wp remote request response or decoded body if available.
		 * @param string         $body        original content of http response's body.
		 * @param array|WP_Error $wp_response original wp remote request response.
		 */
		$res = apply_filters_deprecated( 'forminator_addon_zapier_api_response', array( $response, $body, $wp_response ), '1.18.0', 'forminator_addon_webhook_api_response' );
		$res = apply_filters( 'forminator_addon_webhook_api_response', $res, $body, $wp_response );

		$this->_last_data_received = $res;

		forminator_addon_maybe_log( $res );

		return $res;
	}


	/**
	 * Send data to static webhookwebhook URL
	 *
	 *
	 *
	 * @param $args
	 * add `is_test` => true to add `X-Hook-Test: true`
	 *
	 * @return array|mixed|object
	 * @throws Forminator_Addon_Webhook_Wp_Api_Exception
	 * @throws Forminator_Addon_Webhook_Wp_Api_Not_Found_Exception
	 */
	public function post_( $args ) {

		return $this->request(
			'POST',
			'',
			$args
		);
	}

	/**
	 * Get last data sent
	 *
	 *
	 *
	 * @return array
	 */
	public function get_last_data_sent() {
		return $this->_last_data_sent;
	}

	/**
	 * Get last data received
	 *
	 *
	 *
	 * @return array
	 */
	public function get_last_data_received() {
		return $this->_last_data_received;
	}

	/**
	 * Get last data received
	 *
	 *
	 *
	 * @return string
	 */
	public function get_last_url_request() {
		return $this->_last_url_request;
	}
}
