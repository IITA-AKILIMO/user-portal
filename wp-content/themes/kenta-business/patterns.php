<?php
/**
 * Theme patterns
 *
 * @package Kenta Business
 */

if ( ! function_exists( 'kenta_business_block_patterns_init' ) ) {
	/**
	 * Init block patterns
	 */
	function kenta_business_block_patterns_init() {
		// register custom pattern category
		if ( function_exists( 'register_block_pattern_category' ) ) {
			register_block_pattern_category( 'kenta-business', array(
				'label' => __( 'Kenta Business', 'kenta-business' )
			) );
		}

		// register custom patterns
		if ( function_exists( 'register_block_pattern' ) ) {
			register_block_pattern(
				'kenta-business/hero',
				array(
					'title'      => __( 'Big Hero', 'kenta-business' ),
					'content'    => kenta_business_pattern_markup( 'hero' ),
					'categories' => array( 'kenta-business', 'featured', 'header' )
				)
			);

			register_block_pattern(
				'kenta-business/features',
				array(
					'title'      => __( 'Three Columns of Feature Card', 'kenta-business' ),
					'content'    => kenta_business_pattern_markup( 'features' ),
					'categories' => array( 'kenta-business', 'featured', 'columns' )
				)
			);

			register_block_pattern(
				'kenta-business/price-table',
				array(
					'title'      => __( 'Price Table', 'kenta-business' ),
					'content'    => kenta_business_pattern_markup( 'price-table' ),
					'categories' => array( 'kenta-business', 'featured', 'columns' )
				)
			);

			register_block_pattern(
				'kenta-business/heading',
				array(
					'title'      => __( 'Heading with badge and paragraph', 'kenta-business' ),
					'content'    => kenta_business_pattern_markup( 'heading' ),
					'categories' => array( 'kenta-business', 'featured', 'heading' )
				)
			);

			register_block_pattern(
				'kenta-business/media-text',
				array(
					'title'      => __( 'Two Columns Media with Content, List and Button', 'kenta-business' ),
					'content'    => kenta_business_pattern_markup( 'media-text' ),
					'categories' => array( 'kenta-business', 'featured', 'columns', 'text' )
				)
			);

			register_block_pattern(
				'kenta-business/portfolio',
				array(
					'title'      => __( 'Three Columns Media with Badge and Heading', 'kenta-business' ),
					'content'    => kenta_business_pattern_markup( 'portfolio' ),
					'categories' => array( 'kenta-business', 'featured', 'columns', 'text' )
				)
			);

			register_block_pattern(
				'kenta-business/team',
				array(
					'title'      => __( 'Three Columns Team Member Card', 'kenta-business' ),
					'content'    => kenta_business_pattern_markup( 'team' ),
					'categories' => array( 'kenta-business', 'featured', 'columns', 'text' )
				)
			);

			register_block_pattern(
				'kenta-business/call-to-action',
				array(
					'title'      => __( 'Call to Action', 'kenta-business' ),
					'content'    => kenta_business_pattern_markup( 'call-to-action' ),
					'categories' => array( 'kenta-business', 'featured', 'header' )
				)
			);
		}
	}
}
add_action( 'init', 'kenta_business_block_patterns_init' );
