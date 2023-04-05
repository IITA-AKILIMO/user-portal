<?php
/**
 * Frontend blocks dynamic script utils
 *
 * @package Kenta Blocks
 */

namespace KentaBlocks;

final class Script {
	/**
	 * Member Variable
	 *
	 * @var Script
	 */
	private static $instance;

	/**
	 * Constructor
	 */
	private function __construct() {
		//
	}

	/**
	 *  Initiator
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Get dynamic scripts from blocks
	 *
	 * @param $blocks
	 * @param string $scripts
	 *
	 * @return mixed|string
	 */
	public function dynamicScripts( $blocks, $scripts = '' ) {

		foreach ( $blocks as $block ) {
			if ( is_array( $block ) ) {

				$name = $block['blockName'];

				if ( '' === $name ) {
					continue;
				}

				if ( 'core/block' === $name ) {
					$id = ( isset( $block['attrs']['ref'] ) ) ? $block['attrs']['ref'] : 0;

					if ( $id ) {
						$content = get_post_field( 'post_content', $id );

						$reusable_blocks = kenta_blocks_parse_content( $content );

						$scripts .= $this->dynamicScripts( $reusable_blocks );

					}
				} else {
					$kenta_blocks = kenta_blocks_all();
					if ( isset( $kenta_blocks[ $name ] ) && isset( $kenta_blocks[ $name ]['script'] ) ) {

						if ( isset( $block['attrs'] ) && isset( $block['attrs']['blockID'] ) ) {
							$attrs = $block['attrs'] ?? [];
							$id    = $attrs['blockID'] ?? null;

							ob_start();
							$kenta_blocks[ $name ]['script']( $id, $attrs );
							$scripts .= ob_get_clean();
						}
					}
				}

				if ( isset( $block['innerBlocks'] ) ) {
					$scripts .= $this->dynamicScripts( $block['innerBlocks'] );
				}
			}
		}

		return $scripts;
	}

	/**
	 * Get dynamic scripts form post
	 *
	 * @param null $post
	 *
	 * @return mixed|string
	 */
	public function dynamicScriptsRaw( $post = null ) {
		$blocks = array();

		if ( ! $post ) {
			global $post;
		}

		if ( is_object( $post ) ) {
			$blocks = kenta_blocks_parse_content( $post->post_content );
		}

		return $this->dynamicScripts( $blocks );
	}

	/**
	 * @param $value
	 * @param null $default
	 *
	 * @return array|mixed[]|null[]
	 */
	public function sanitizeResponsiveValue( $value, $default = null ) {
		if ( is_array( $value ) ) {
			return array_merge( array(
				'desktop' => $default,
				'tablet'  => $default,
				'mobile'  => $default,
			), $value );
		}

		return [
			'desktop' => $value,
			'tablet'  => $default,
			'mobile'  => $default,
		];
	}
}