<?php

namespace KentaCompanion\API;

use KentaCompanion\API\Exception\EndpointExistedException;

class Router {

	/**
	 * Global namespace
	 *
	 * @var mixed|string
	 */
	protected $namespace;

	/**
	 * Registered routes
	 *
	 * @var array
	 */
	protected $routes = [];

	/**
	 * Global middlewares
	 *
	 * @var array
	 */
	protected $middlewares = [];

	/**
	 * Create new router instance
	 *
	 * @param $namespace
	 */
	public function __construct( $namespace ) {
		$this->namespace = $namespace;
	}

	/**
	 * Add read endpoint
	 *
	 * @param $path
	 * @param $action
	 * @param array $args
	 *
	 * @return mixed
	 * @throws EndpointExistedException
	 */
	public function read( $path, $action, $args = [] ) {
		return $this->add_endpoint( \WP_REST_Server::READABLE, $path, $action, $args );
	}

	/**
	 * Add create endpoint
	 *
	 * @param $path
	 * @param $action
	 * @param array $args
	 *
	 * @return mixed
	 * @throws EndpointExistedException
	 */
	public function create( $path, $action, array $args = [] ) {
		return $this->add_endpoint( \WP_REST_Server::CREATABLE, $path, $action, $args );
	}

	/**
	 * Add edit endpoint
	 *
	 * @param $path
	 * @param $action
	 * @param array $args
	 *
	 * @return mixed
	 * @throws EndpointExistedException
	 */
	public function edit( $path, $action, $args = [] ) {
		return $this->add_endpoint( \WP_REST_Server::EDITABLE, $path, $action, $args );
	}

	/**
	 * Add delete endpoint
	 *
	 * @param $path
	 * @param $action
	 * @param array $args
	 *
	 * @return mixed
	 * @throws EndpointExistedException
	 */
	public function delete( $path, $action, $args = [] ) {
		return $this->add_endpoint( \WP_REST_Server::DELETABLE, $path, $action, $args );
	}

	/**
	 * Add a global middleware
	 *
	 * @param $middleware
	 *
	 * @return $this
	 */
	public function use( $middleware ) {

		$this->middlewares[] = $middleware;

		return $this;
	}

	/**
	 * Register all endpoints
	 */
	public function register() {
		foreach ( $this->routes as $path => $endpoints ) {

			$args = [];

			foreach ( $endpoints as $method => $endpoint ) {
				$args[] = array_merge( [
					'methods'             => $method,
					'callback'            => [ $endpoint, 'handle' ],
					'permission_callback' => '__return_true',
					'args'                => [],
				], $endpoint->getArgs() );
			}

			register_rest_route( $this->namespace, $path, $args );
		}
	}

	/**
	 * Add an endpoint
	 *
	 * @param $method
	 * @param $path
	 * @param $action
	 * @param $args
	 *
	 * @return mixed
	 * @throws EndpointExistedException
	 */
	protected function add_endpoint( $method, $path, $action, $args ) {
		if ( ! isset( $this->routes[ $path ] ) ) {
			$this->routes[ $path ] = [];
		}

		if ( isset( $this->routes[ $path ][ $method ] ) ) {
			throw new EndpointExistedException( $this->namespace, $method, $path );
		}

		$this->routes[ $path ][ $method ] = new Endpoint( $method, $path, $action, $args, $this->middlewares );

		return $this->routes[ $path ][ $method ];
	}
}