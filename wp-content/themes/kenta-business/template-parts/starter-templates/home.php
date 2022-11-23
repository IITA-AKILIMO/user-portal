<?php
/**
 * Template for home page
 */

echo kenta_business_pattern_markup( 'hero' );

echo kenta_business_pattern_markup( 'spacer', array( 'space' => '36px' ) );
echo kenta_business_pattern_markup( 'features' );
echo kenta_business_pattern_markup( 'spacer', array( 'space' => '48px' ) );

echo kenta_business_pattern_markup( 'media-text' );
echo kenta_business_pattern_markup( 'spacer', array( 'space' => '48px' ) );

echo kenta_business_pattern_markup( 'heading' );
echo kenta_business_pattern_markup( 'portfolio' );
echo kenta_business_pattern_markup( 'portfolio' );

echo kenta_business_pattern_markup( 'heading', array(
	'badge' => __( 'our team', 'kenta-business' ),
	'title' => __( 'Meet Our Team Members', 'kenta-business' )
) );
echo kenta_business_pattern_markup( 'team' );
echo kenta_business_pattern_markup( 'spacer', array( 'space' => '48px' ) );

echo kenta_business_pattern_markup( 'heading', array(
	'badge' => __( 'our plan', 'kenta-business' ),
	'title' => __( 'Simple Pricing, Unlimited Possibilities', 'kenta-business' )
) );
echo kenta_business_pattern_markup( 'price-table' );
echo kenta_business_pattern_markup( 'spacer', array( 'space' => '48px' ) );

echo kenta_business_pattern_markup( 'call-to-action' );
