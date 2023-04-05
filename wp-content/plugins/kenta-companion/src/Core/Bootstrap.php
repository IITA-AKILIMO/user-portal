<?php

namespace KentaCompanion\Core;

class Bootstrap {

	/**
	 * All default singletons
	 *
	 * @var array
	 */
	protected static $singletons = [
		\KentaCompanion\Core\Extensions::class,
		\KentaCompanion\DemoImporter\Demos::class,
		\KentaCompanion\Utils\IO::class,
	];

	/**
	 * All default alias
	 *
	 * @var array
	 */
	protected static $aliases = [
		'extensions' => \KentaCompanion\Core\Extensions::class,
		'demos' => \KentaCompanion\DemoImporter\Demos::class,
		'io'    => \KentaCompanion\Utils\IO::class,
	];

	/**
	 * Default instances
	 *
	 * @var array
	 */
	protected static $instances = [
		//
	];

	/**
	 * Run plugin
	 */
	public static function run() {

		do_action( 'kcmp/before_bootstrap' );

		$app = new KentaCompanion();

		$app->instance( KentaCompanion::class, $app );

		foreach ( self::$singletons as $singleton ) {
			$app->singleton( $singleton );
		}

		foreach ( self::$aliases as $alias => $abs ) {
			$app->alias( $abs, $alias );
		}

		foreach ( self::$instances as $abs ) {
			$app->make( $abs );
		}

		do_action( 'kcmp/after_bootstrap' );
	}
}
