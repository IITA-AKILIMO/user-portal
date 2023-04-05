<?php

namespace KentaCompanion\API;

class Endpoint {

	/**
	 * Http method
	 *
	 * @var string
	 */
	protected $method;

	/**
	 * Endpoint path
	 *
	 * @var
	 */
	protected $path;

	/**
	 * Endpoint callback
	 *
	 * @var mixed
	 */
	protected $action;

	/**
	 * All middlewares
	 *
	 * @var array
	 */
	protected $middlewares = [];

	/**
	 * Endpoint args
	 *
	 * @var array
	 */
	protected $args = [];

	/**
	 * Create new endpoint
	 *
	 * @param $method
	 * @param $path
	 * @param $action
	 * @param $args
	 * @param array $middlewares
	 */
	public function __construct( $method, $path, $action, $args, $middlewares = [] ) {
		$this->method = $method;
		$this->path   = $path;
		$this->args   = $args;

		$this->action = function ( $request ) use ( $action ) {
			return call_user_func( $action, $request );
		};

		foreach ( $middlewares as $middleware ) {
			$this->use( $middleware );
		}
	}

	/**
	 * Add a middleware to this endpoint
	 *
	 * @param $middleware
	 *
	 * @return Endpoint $this
	 */
	public function use( $middleware ) {

		$this->middlewares[] = function ( $next ) use ( $middleware ) {
			return function ( $request ) use ( $middleware, $next ) {
				return call_user_func( $middleware, $request, $next );
			};
		};

		return $this;
	}

	/**
	 * Get endpoint args
	 *
	 * @return array
	 */
	public function getArgs() {
		return $this->args;
	}

	/**
	 * Handle middlewares and action
	 *
	 * @param $request
	 *
	 * @return mixed
	 */
	public function handle( $request ) {

		$handler = $this->action;

		foreach ( array_reverse( $this->middlewares ) as $middleware ) {
			$handler = $middleware( $handler );
		}

		return $handler( $request );
	}
}