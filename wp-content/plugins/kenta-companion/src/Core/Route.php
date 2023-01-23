<?php

namespace KentaCompanion\Core;

use KentaCompanion\API\Router;

class Route {

	/**
	 * Register api v1
	 */
	public static function api_v1() {
		$router = new Router( 'kenta-cmp/v1' );
		$router->use( [ Route::class, 'auth' ] );

		// get starter sites
		$router->read( '/starter/demos', [ Route::class, 'demos' ] );
		// import template
		$router->create( '/starter/demos', [ Route::class, 'import' ] );
		// install plugin
		$router->create( '/starter/plugins', [ Route::class, 'install_plugin' ] );

		$router->register();
	}

	/**
	 * API Auth
	 *
	 * @param $request
	 * @param $next
	 *
	 * @return mixed|\WP_Error|\WP_HTTP_Response|\WP_REST_Response
	 */
	public static function auth( $request, $next ) {

		if ( ! current_user_can( 'manage_options' ) ) {
			return rest_ensure_response( new \WP_Error( 403, __( 'Forbidden', 'kenta-companion' ) ) );
		}

		return $next( $request );
	}

	/**
	 * Get all demos
	 *
	 * @return \WP_Error|\WP_HTTP_Response|\WP_REST_Response
	 */
	public static function demos( $request ) {
		$force = $request->get_param( 'force' );

		return rest_ensure_response( kcmp( 'demos' )->all( $force == 'true' ) );
	}

	/**
	 * Do import action
	 *
	 * @return @return \WP_Error|\WP_HTTP_Response|\WP_REST_Response
	 */
	public static function import( $request ) {
		$slug   = $request->get_param( 'slug' );
		$type   = $request->get_param( 'type' );
		$switch = $request->get_param( 'switch' );

		// site_settings
		if ( ! in_array( $type, [ 'content', 'customizer', 'widgets', 'site_settings' ] ) ) {
			return rest_ensure_response(
				self::handle_wp_error( new \WP_Error( 422, __( 'Import type error' ) ) )
			);
		}

		if ( $switch ) {
			switch_theme( kcmp_current_template() );
		}

		return rest_ensure_response(
			self::handle_wp_error( kcmp( 'demos' )->import( $slug, [ $type ] ) )
		);
	}

	/**
	 * Install plugin
	 *
	 * @return \WP_Error|\WP_HTTP_Response|\WP_REST_Response
	 */
	public static function install_plugin( $request ) {
		$slug   = $request->get_param( 'slug' );
		$plugin = $request->get_param( 'plugin' );

		return rest_ensure_response(
			self::handle_wp_error( kcmp_install_plugin( $slug, $plugin ) )
		);
	}

	protected static function handle_wp_error( $response ) {

		if ( is_wp_error( $response ) ) {
			$response = [
				'errorCode'    => $response->get_error_code(),
				'errorMessage' => $response->get_error_message(),
			];
		}

		return $response;
	}
}