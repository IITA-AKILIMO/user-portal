<?php

namespace KentaCompanion\API\Exception;

class EndpointExistedException extends \Exception {

	/**
	 * Create new endpoint already exists exception
	 *
	 * @param $namespace
	 * @param $method
	 * @param $path
	 */
	public function __construct( $namespace, $method, $path ) {

		$endpoint = '[' . $method . ']::' . $namespace . $path;
		$message  = $endpoint . ' Already exists!';

		parent::__construct( $message );
	}

}