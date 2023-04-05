<?php
/**
 * Kenta dynamic css
 */

use LottaFramework\Facades\Css;
use LottaFramework\Facades\CZ;
use LottaFramework\Utils;

/**
 * Cache key
 *
 * @since 1.1.5
 */
function kenta_dynamic_css_cache_key() {
	return apply_filters( 'kenta_filter_dynamic_css_cache_key', 'kenta_dynamic_css' );
}

/**
 * Sets our dynamic CSS cache if it doesn't exist.
 *
 * If the theme version changed, bust the cache.
 *
 * @since 1.1.4
 */
function kenta_set_dynamic_css_cache() {
	if ( apply_filters( 'kenta_ignore_dynamic_css_cache', false ) || is_customize_preview() ) {
		return;
	}

	$cached_css     = get_option( kenta_dynamic_css_cache_key(), false );
	$cached_version = get_option( kenta_dynamic_css_cache_key() . '_cached_version', '' );
	if ( apply_filters( 'kenta_should_dynamic_css_re_cached', ! $cached_css || KENTA_VERSION !== $cached_version ) ) {
		kenta_app()->instance( 'store.caching_css', true );

		$css = kenta_dynamic_css();

		update_option( kenta_dynamic_css_cache_key(), wp_strip_all_tags( $css ) );
		update_option( kenta_dynamic_css_cache_key() . '_cached_version', esc_html( apply_filters( 'kenta_filter_cached_dynamic_css_version', KENTA_VERSION ) ) );

		do_action( 'kenta_dynamic_css_cached', $css );
	}
}

/**
 * Enqueue global css variables
 */
function kenta_enqueue_global_vars( $selector = ':root', $suffix = '' ) {
	wp_register_style( 'kenta-dynamic-vars' . $suffix, false );
	wp_enqueue_style( 'kenta-dynamic-vars' . $suffix );
	wp_add_inline_style( 'kenta-dynamic-vars' . $suffix, kenta_global_css_vars( $selector, $suffix ) );
}

/**
 * Enqueue dynamic css for our theme
 */
function kenta_enqueue_transparent_header_css() {
	wp_register_style( 'kenta-transparent-header', false );
	wp_enqueue_style( 'kenta-transparent-header' );
	wp_add_inline_style( 'kenta-transparent-header', kenta_transparent_header_css() );
}

/**
 * Enqueue dynamic css for our theme
 */
function kenta_enqueue_dynamic_css() {
	wp_register_style( 'kenta-preloader', false );
	wp_enqueue_style( 'kenta-preloader' );
	wp_add_inline_style( 'kenta-preloader', kenta_preloader_css() );

	// Set dynamic css cache
	kenta_set_dynamic_css_cache();

	//
	// Check if we should use the cached dynamic CSS
	//
	// @since 1.1.4
	//
	$using_cached_dynamic_css = apply_filters( 'kenta_using_cached_dynamic_css', CZ::checked( 'kenta_enable_customizer_cache' ) );
	if ( ! $using_cached_dynamic_css || ! get_option( kenta_dynamic_css_cache_key(), false ) || is_customize_preview() || apply_filters( 'kenta_ignore_dynamic_css_cache', false ) ) {
		$css = kenta_dynamic_css();
	} else {
		$css = get_option( kenta_dynamic_css_cache_key() );
	}

	$css .= kenta_no_cache_dynamic_css();

	wp_register_style( 'kenta-dynamic', false );
	wp_enqueue_style( 'kenta-dynamic' );
	wp_add_inline_style( 'kenta-dynamic', $css );
}

/**
 * Enqueue dynamic css for our theme editor
 */
function kenta_enqueue_admin_dynamic_css() {
	wp_register_style( 'kenta-admin-dynamic', false );
	wp_enqueue_style( 'kenta-admin-dynamic' );
	wp_add_inline_style( 'kenta-admin-dynamic', kenta_admin_dynamic_css() );
}

/**
 * Update our CSS cache when done saving Customizer options.
 *
 * @since 1.1.4
 */
function kenta_update_dynamic_css_cache() {
	if ( apply_filters( 'kenta_ignore_dynamic_css_cache', false ) ) {
		return;
	}

	update_option( kenta_dynamic_css_cache_key(), false );
}

add_action( 'customize_save_after', 'kenta_update_dynamic_css_cache' );

/**
 * Generate global css vars
 *
 * @return mixed
 */
function kenta_global_css_vars( $selector, $suffix = '' ) {
	$suffix = $suffix === '' ? '' : '-' . $suffix;

	$vars = [
		'--kenta-transparent' . $suffix => 'rgba(0, 0, 0, 0)',
	];

	/**
	 * Palette
	 */
	$colors = apply_filters( 'kenta_content_color_vars', [
		'kenta_primary_color' => [
			'default' => 'kenta-primary-color',
			'active'  => 'kenta-primary-active',
		],
		'kenta_accent_color'  => [
			'default' => 'kenta-accent-color',
			'active'  => 'kenta-accent-active',
		],
		'kenta_base_color'    => [
			'default' => 'kenta-base-color',
			'100'     => 'kenta-base-100',
			'200'     => 'kenta-base-200',
			'300'     => 'kenta-base-300',
		],

		'kenta_content_base_color'     => [
			'initial' => 'kenta-content-base-color',
		],
		'kenta_content_drop_cap_color' => [
			'initial' => 'kenta-content-drop-cap-color',
		],
		'kenta_content_links_color'    => [
			'initial' => 'kenta-link-initial-color',
			'hover'   => 'kenta-link-hover-color',
		],
		'kenta_content_headings_color' => [
			'initial' => 'kenta-headings-color',
		],
	] );

	$palettes = Utils::array_path( CZ::getSettingArgs( 'kenta_color_palettes' ), 'options.palettes' );
	$palette  = $palettes[ CZ::get( 'kenta_color_palettes' ) ] ?? [];

	foreach ( $colors as $setting => $args ) {
		$color = CZ::get( $setting );
		foreach ( $args as $key => $var ) {
			if ( Utils::str_starts_with( $color[ $key ], 'var' ) && isset( $palette[ $var ] ) ) {
				$vars[ '--' . $var . $suffix ] = $palette[ $var ];
				continue;
			}

			$vars[ '--' . $var . $suffix ] = $color[ $key ];
		}
	}

	return Css::parse( [
		/**
		 * Css vars
		 */
		$selector => $vars,
	] );
}

/**
 * @param $scope
 * @param array $css
 *
 * @return array|mixed
 */
function kenta_content_typography_css( $scope, $css = [] ) {
	$fonts = apply_filters( 'kenta_content_typography_vars', [
		'kenta_content_base_typography'     => '',
		'kenta_content_drop_cap_typography' => '.has-drop-cap::first-letter',
	] );

	foreach ( $fonts as $id => $selector ) {
		$selector = $selector === '' ? $scope : $scope . ' ' . $selector;

		$css[ $selector ] = array_merge(
			Css::typography( CZ::get( $id ) ),
			$css[ $selector ] ?? []
		);
	}

	return $css;
}

/**
 * Button css
 *
 * @return array
 */
function kenta_content_buttons_css() {
	$preset = kenta_button_preset( 'kenta_content_buttons_', CZ::get( 'kenta_content_buttons_preset' ) );

	return array_merge(
		[
			'--kenta-button-height' => CZ::get( 'kenta_content_buttons_min_height' )
		],
		Css::shadow( CZ::get( 'kenta_content_buttons_shadow', $preset ), '--kenta-button-shadow' ),
		Css::shadow( CZ::get( 'kenta_content_buttons_shadow_active', $preset ), '--kenta-button-shadow-active' ),
		Css::typography( CZ::get( 'kenta_content_buttons_typography', $preset ) ),
		Css::border( CZ::get( 'kenta_content_buttons_border', $preset ), '--kenta-button-border' ),
		Css::dimensions( CZ::get( 'kenta_content_buttons_padding', $preset ), '--kenta-button-padding' ),
		Css::dimensions( CZ::get( 'kenta_content_buttons_radius', $preset ), '--kenta-button-radius' ),
		Css::colors( CZ::get( 'kenta_content_buttons_text_color', $preset ), [
			'initial' => '--kenta-button-text-initial-color',
			'hover'   => '--kenta-button-text-hover-color',
		] ),
		Css::colors( CZ::get( 'kenta_content_buttons_button_color', $preset ), [
			'initial' => '--kenta-button-initial-color',
			'hover'   => '--kenta-button-hover-color',
		] )
	);
}

/**
 * Transparent header css
 *
 * @return string
 */
function kenta_transparent_header_css() {

	$transparent = kenta_is_transparent_header();

	if ( ! $transparent ) {
		return '';
	}

	$css = [];

	// header row
	$css['.kenta-transparent-header .kenta-header-row'] = array_merge(
		[ 'box-shadow' => 'none' ],
		Css::border( CZ::get( 'kenta_trans_header_border_top' ), 'border-top' ),
		Css::border( CZ::get( 'kenta_trans_header_border_bottom' ), 'border-bottom' ),
		Css::background( CZ::get( 'kenta_trans_header_bg' ) )
	);

	// site branding
	$css['.kenta-transparent-header .kenta-site-branding .kenta-has-transparent-logo .kenta-transparent-logo']                                                     = [
		'display' => 'inline-block',
	];
	$css['.kenta-transparent-header .kenta-site-branding .kenta-has-transparent-logo .kenta-logo']                                                                 = [
		'display' => 'none',
	];
	$css['.kenta-transparent-header .kenta-site-branding .site-identity .site-title, .kenta-transparent-header .kenta-site-branding .site-identity .site-tagline'] =
		Css::colors( CZ::get( 'kenta_trans_header_site_title_color' ), [
			'initial' => '--text-color',
			'hover'   => '--hover-color',
		] );

	// Raw text
	$css['.kenta-transparent-header, .kenta-transparent-header .kenta-data-time-element, .kenta-transparent-header .kenta-raw-html, .kenta-transparent-header .kenta-breadcrumbs-element'] = Css::colors( CZ::get( 'kenta_trans_header_raw_text_color' ), [
		'text'    => [ 'color', '--kenta-data-time-text-color', '--kenta-data-time-icon-color', '--breadcrumb-text' ],
		'initial' => [ '--kenta-link-initial-color', '--breadcrumb-link-initial' ],
		'hover'   => [ '--kenta-link-hover-color', '--breadcrumb-link-hover' ],
	] );

	// menu element
	$css['.kenta-transparent-header .kenta-menu'] = array_merge(
		Css::colors( CZ::get( 'kenta_trans_header_menu_color' ), [
			'initial' => '--menu-text-initial-color',
			'hover'   => '--menu-text-hover-color',
			'active'  => '--menu-text-active-color',
		] ),
		Css::colors( CZ::get( 'kenta_trans_header_menu_bg_color' ), [
			'initial' => '--menu-background-initial-color',
			'hover'   => '--menu-background-hover-color',
			'active'  => '--menu-background-active-color',
		] ),
		Css::colors( CZ::get( 'kenta_trans_header_menu_border_color' ), [
			'initial' => [
				'--lotta-border---menu-items-border-top-initial-color',
				'--lotta-border---menu-items-border-bottom-initial-color',
			],
			'active'  => [
				'--lotta-border---menu-items-border-top-active-initial-color',
				'--lotta-border---menu-items-border-bottom-active-initial-color',
			],
		] )
	);

	// button & icon button element
	$css['.kenta-transparent-header .kenta-button, .kenta-transparent-header .kenta-icon-button, .kenta-transparent-header .kenta-social-icon'] = array_merge(
		Css::colors( CZ::get( 'kenta_trans_header_button_color' ), [
			'initial' => [
				'--kenta-button-text-initial-color',
				'--kenta-icon-button-icon-initial-color',
				'--kenta-social-icon-initial-color',
			],
			'hover'   => [
				'--kenta-button-text-hover-color',
				'--kenta-icon-button-icon-hover-color',
				'--kenta-social-icon-hover-color',
			],
		] ),
		Css::colors( CZ::get( 'kenta_trans_header_button_border_color' ), [
			'initial' => [
				'--lotta-border-initial-color',
				'--lotta-border---kenta-button-border-initial-color',
				'--kenta-icon-button-border-initial-color',
				'--kenta-social-border-initial-color'
			],
			'hover'   => [
				'--lotta-border-hover-color',
				'--lotta-border---kenta-button-border-hover-color',
				'--kenta-icon-button-border-hover-color',
				'--kenta-social-border-hover-color',
			],
		] ),
		Css::colors( CZ::get( 'kenta_trans_header_button_bg_color' ), [
			'initial' => [
				'--kenta-button-initial-color',
				'--kenta-icon-button-bg-initial-color',
				'--kenta-social-bg-initial-color',
			],
			'hover'   => [
				'--kenta-button-hover-color',
				'--kenta-icon-button-bg-hover-color',
				'--kenta-social-bg-hover-color',
			],
		] )
	);

	$css        = Css::parse( apply_filters( 'kenta_filter_transparent_header_css', $css ) );
	$breakpoint = Css::desktop();
	$device     = CZ::get( 'kenta_enable_transparent_header_device' );

	if ( $device === 'mobile' ) {
		$css = '@media (max-width: ' . $breakpoint . ') {' . $css . '}';
	}

	if ( $device === 'desktop' ) {
		$css = '@media (min-width: ' . $breakpoint . ') {' . $css . '}';
	}

	return $css;
}

/**
 * Preloader css
 *
 * @return mixed
 */
function kenta_preloader_css() {
	if ( ! CZ::checked( 'kenta_global_preloader' ) ) {
		return '';
	}

	$css = [
		'.kenta-preloader-wrap' => array_merge(
			[
				'--kenta-preloader-background' => 'var(--kenta-base-100)',
				'--kenta-preloader-primary'    => 'var(--kenta-primary-color)',
				'--kenta-preloader-accent'     => 'var(--kenta-accent-active)',
				'position'                     => 'fixed',
				'top'                          => '0',
				'left'                         => '0',
				'width'                        => '100%',
				'height'                       => '100%',
				'z-index'                      => '100000',
				'display'                      => 'flex',
				'align-items'                  => 'center',
				'background'                   => 'var(--kenta-preloader-background)',
			],
			Css::colors( CZ::get( 'kenta_preloader_colors' ), [
				'background' => '--kenta-preloader-background',
				'accent'     => '--kenta-preloader-accent',
				'primary'    => '--kenta-preloader-primary',
			] )
		),
	];

	$preset = kenta_get_preloader( CZ::get( 'kenta_preloader_preset' ) );

	return Css::parse( array_merge( $css, $preset['css'] ) ) . Css::keyframes( $preset['keyframes'] );
}

/**
 * Generate no cache dynamic css
 *
 * @return mixed
 * @since 1.1.4
 */
function kenta_no_cache_dynamic_css() {
	$css = array();

	$post_type = 'archive';
	if ( is_page() ) {
		$post_type = 'pages';
	}

	if ( is_single() ) {
		$post_type = 'single_post';
	}

	if ( is_front_page() && ! is_home() ) {
		$post_type = 'homepage';
	}

	if ( kenta_is_woo_shop() ) {
		$post_type = 'store';
	}

	/**
	 * Global site
	 */
	$content_container_type = kenta_get_current_post_meta( 'site-container-layout' );
	if ( $content_container_type === 'default' ) {
		$content_container_type = CZ::get( 'kenta_' . $post_type . '_container_layout' ) ?? 'normal';
	}

	$site_wrap_css = [
		'--kenta-max-w-content'        => $content_container_type === 'normal' ? 'auto' : CZ::get( 'kenta_' . $post_type . '_container_max_width' ),
		'--kenta-content-area-spacing' => kenta_get_current_post_meta( 'disable-content-area-spacing' ) === 'yes'
			? '0px' : CZ::get( "kenta_{$post_type}_content_spacing" ),
		'--wp-admin-bar-height'        => ( ! is_admin_bar_showing() || is_customize_preview() ) ? '0px' : [
			'desktop' => '32px',
			'tablet'  => '32px',
			'mobile'  => '46px',
		],
	];

	// enable site wrap
	$css['.kenta-site-wrap'] = $site_wrap_css;

	// Posts, pages and store site background override
	if ( $post_type === 'pages' || $post_type === 'single_post' || $post_type === 'store' ) {
		$css[".kenta-{$post_type} .kenta-site-wrap"] = Css::background( CZ::get( 'kenta_' . $post_type . '_site_background' ) );
	}

	/**
	 * Post card
	 */
	if ( is_archive() || is_home() || is_search() ) {

		$css['.card-list'] = [
			'--card-gap'             => CZ::get( 'kenta_card_gap' ),
			'--card-thumbnail-width' => CZ::get( 'kenta_archive_image_width' ),
		];

		$archive_layout = CZ::get( 'kenta_archive_layout' );

		if ( $archive_layout === null || $archive_layout === 'archive-grid' || $archive_layout === 'archive-masonry' ) {
			$card_width = [];
			foreach ( CZ::get( 'kenta_archive_columns' ) as $device => $columns ) {
				$card_width[ $device ] = sprintf( "%.2f", substr( sprintf( "%.3f", ( 100 / (int) $columns ) ), 0, - 1 ) ) . '%';
			}
			$css['.card-wrapper'] = [
				'width' => $card_width,
			];
		} else {
			$css['.card-wrapper'] = [
				'width' => '100%',
			];
		}

		$css['.card'] = array_merge(
			[
				'text-align'               => CZ::get( 'kenta_card_content_alignment' ),
				'--card-thumbnail-spacing' => CZ::get( 'kenta_card_thumbnail_spacing' ),
				'--card-content-spacing'   => CZ::get( 'kenta_card_content_spacing' )
			],
			kenta_card_preset_style( CZ::get( 'kenta_card_style_preset' ) )
		);
	}

	/**
	 * Post elements
	 */
	$post_elements_scope = [
		'entry'         => [
			'condition' => is_archive() || is_home() || is_search(),
			'elements'  => [ 'title', 'metas', 'categories', 'tags', 'excerpt', 'thumbnail', 'divider', 'read-more' ],
			'selector'  => '.card'
		],
		'post'          => [
			'condition' => is_single(),
			'elements'  => [ 'title', 'metas', 'categories', 'tags' ],
			'selector'  => '.kenta-article-header'
		],
		'page'          => [
			'condition' => is_page(),
			'elements'  => [ 'title', 'metas', 'categories', 'tags' ],
			'selector'  => '.kenta-article-header'
		],
		'related_posts' => [
			'condition' => is_single() && CZ::checked( 'kenta_post_related_posts' ),
			'elements'  => [ 'title', 'metas', 'categories', 'tags', 'excerpt', 'thumbnail', 'divider', 'read-more' ],
			'selector'  => '.kenta-related-posts-wrap .card'
		],
	];

	foreach ( $post_elements_scope as $id => $scope ) {
		if ( ! $scope['condition'] ) {
			continue;
		}

		$scope_selector = $scope['selector'];

		$css = array_merge( $css, kenta_post_elements_css( $scope_selector, $id, $scope['elements'] ) );
	}

	/**
	 * Single post & page
	 */
	if ( is_single() || is_page() ) {
		$article_type = is_page() ? 'page' : 'post';
		$prefix       = 'kenta_' . $article_type;

		// Article content
		$content_preset                     = CZ::get( $prefix . '_content_style_preset' );
		$css['.kenta-article-content-wrap'] = array_merge(
			array(
				'padding' => $content_preset === 'ghost' ? '' : '24px',
			),
			kenta_card_preset_style( $content_preset )
		);

		// Article header
		$css['.kenta-article-header'] = array_merge(
			Css::dimensions( CZ::get( "{$prefix}_header_spacing" ), 'padding' ),
			[
				'text-align' => CZ::get( "{$prefix}_header_alignment" )
			]
		);

		// Article header background
		$css['.kenta-article-header-background::after'] = array_merge(
			[ 'opacity' => CZ::get( "{$prefix}_featured_image_background_overlay_opacity" ) ],
			Css::background( CZ::get( "{$prefix}_featured_image_background_overlay" ) )
		);
		$css['.kenta-article-header-background']        = array_merge(
			Css::dimensions( CZ::get( "{$prefix}_featured_image_background_spacing" ), 'padding' ),
			Css::colors( CZ::get( "{$prefix}_featured_image_elements_override" ), [
				'override' => '--kenta-article-header-override',
			] ),
			[
				'position'            => 'relative',
				'background-position' => 'center',
				'background-size'     => 'cover',
				'background-repeat'   => 'no-repeat',
			]
		);

		$css['.kenta-article-header-background img'] = Css::filters( CZ::get( "{$prefix}_featured_image_filter" ) );

		// Article thumbnail
		$css['.article-featured-image']     = Css::dimensions( CZ::get( "{$prefix}_featured_image_spacing" ), 'padding' );
		$css['.article-featured-image img'] = array_merge(
			[ 'height' => CZ::get( "{$prefix}_featured_image_height" ) ],
			Css::shadow( CZ::get( "{$prefix}_featured_image_shadow" ) ),
			Css::dimensions( CZ::get( "{$prefix}_featured_image_radius" ), 'border-radius' ),
			Css::filters( CZ::get( "{$prefix}_featured_image_filter" ) )
		);

		// Share box
		if ( CZ::checked( 'kenta_' . $article_type . '_share_box' ) ) {
			$css[ '.kenta-' . $article_type . '-socials' ] = array_merge(
				[
					'--kenta-social-icons-size'    => CZ::get( 'kenta_' . $article_type . '_share_box_icons_size' ),
					'--kenta-social-icons-spacing' => CZ::get( 'kenta_' . $article_type . '_share_box_icons_spacing' )
				],
				Css::dimensions( CZ::get( 'kenta_' . $article_type . '_share_box_padding' ) )
			);

			$css[ '.kenta-' . $article_type . '-socials .kenta-social-link' ] = array_merge(
				Css::colors( CZ::get( 'kenta_' . $article_type . '_share_box_icons_color' ), [
					'initial' => '--kenta-social-icon-initial-color',
					'hover'   => '--kenta-social-icon-hover-color',
				] ),
				Css::colors( CZ::get( 'kenta_' . $article_type . '_share_box_icons_bg_color' ), [
					'initial' => '--kenta-social-bg-initial-color',
					'hover'   => '--kenta-social-bg-hover-color',
				] ),
				Css::colors( CZ::get( 'kenta_' . $article_type . '_share_box_icons_border_color' ), [
					'initial' => '--kenta-social-border-initial-color',
					'hover'   => '--kenta-social-border-hover-color',
				] )
			);
		}

		// Author box
		if ( is_single() && CZ::checked( 'kenta_post_author_bio' ) ) {
			$css['.kenta-about-author-bio-box'] = array_merge(
				[
					'--kenta-author-bio-avatar-radius' => CZ::get( 'kenta_post_author_bio_avatar_radius' ),
					'text-align'                       => CZ::get( 'kenta_post_author_bio_alignment' )
				],
				Css::background( CZ::get( 'kenta_post_author_bio_background' ) ),
				Css::dimensions( CZ::get( 'kenta_post_author_bio_padding' ), 'padding' ),
				Css::dimensions( CZ::get( 'kenta_post_author_bio_spacing' ) ),
				Css::border( CZ::get( 'kenta_post_author_bio_border' ) ),
				Css::shadow( CZ::get( 'kenta_post_author_bio_shadow' ) )
			);
		}

		// Post navigation
		if ( is_single() ) {
			$css['.kenta-post-navigation'] = array_merge(
				Css::dimensions( CZ::get( 'kenta_post_navigation_padding' ) ),
				Css::colors( CZ::get( 'kenta_post_navigation_text_color' ), [
					'initial' => '--kenta-navigation-initial-color',
					'hover'   => '--kenta-navigation-hover-color',
				] )
			);
		}

		// Related posts
		if ( CZ::checked( 'kenta_post_related_posts' ) ) {
			$css['.kenta-related-posts-list'] = [
				'--card-gap' => CZ::get( 'kenta_related_posts_grid_items_gap' ),
			];

			$card_width = [];
			foreach ( CZ::get( 'kenta_related_posts_grid_columns' ) as $device => $columns ) {
				$card_width[ $device ] = sprintf( "%.2f", substr( sprintf( "%.3f", ( 100 / (int) $columns ) ), 0, - 1 ) ) . '%';
			}
			$css['.kenta-related-posts-list .card-wrapper'] = [
				'width' => $card_width,
			];

			$css['.kenta-related-posts-list .card'] = array_merge(
				[
					'text-align'               => CZ::get( 'kenta_related_posts_card_content_alignment' ),
					'--card-thumbnail-spacing' => CZ::get( 'kenta_related_posts_card_thumbnail_spacing' ),
					'--card-content-spacing'   => CZ::get( 'kenta_related_posts_card_content_spacing' )
				],
				kenta_card_preset_style( CZ::get( 'kenta_related_posts_card_style_preset' ) )
			);
		}
	}

	/**
	 * Article & shop
	 */
	if ( is_single() || is_page() || kenta_is_woo_shop() ) {
		// Article typography
		$css = kenta_content_typography_css( '.kenta-article-content', $css );
	}

	$css = apply_filters( 'kenta_filter_no_cache_dynamic_css', $css );

	return Css::parse( $css );
}

/**
 * Generate cached dynamic css
 *
 * @return mixed
 */
function kenta_dynamic_css() {

	$css = [
		':root' => array_merge(
			Css::typography( CZ::get( 'kenta_site_global_typography' ) ),
			Css::filters( CZ::get( 'kenta_site_filters' ) )
		),
	];

	/**
	 * Global site
	 */
	$site_wrap_css = array_merge(
		Css::typography( CZ::get( 'kenta_site_global_typography' ) ),
		Css::background( CZ::get( 'kenta_site_background' ) )
	);

	// enable site wrap
	if ( CZ::checked( 'kenta_enable_site_wrap' ) ) {
		$css['.kenta-body'] = Css::background( CZ::get( 'kenta_site_body_background' ) );
		$site_wrap_css      = array_merge( $site_wrap_css,
			Css::shadow( CZ::get( 'kenta_site_wrap_shadow' ) ),
			[ '--kenta-site-wrap-width' => '1600px', 'margin' => '0 auto' ]
		);
	}

	$css['.kenta-site-wrap'] = $site_wrap_css;

	/**
	 * header
	 */
	$css['.kenta-site-header'] = array_merge(
		Css::colors( CZ::get( 'kenta_header_primary_color' ), [
			'default' => '--kenta-primary-color',
			'active'  => '--kenta-primary-active',
		] ),
		Css::colors( CZ::get( 'kenta_header_accent_color' ), [
			'default' => '--kenta-accent-color',
			'active'  => '--kenta-accent-active',
		] ),
		Css::colors( CZ::get( 'kenta_header_base_color' ), [
			'default' => '--kenta-base-color',
			'100'     => '--kenta-base-100',
			'200'     => '--kenta-base-200',
			'300'     => '--kenta-base-300',
		] )
	);

	// footer
	$css['.kenta-footer-area'] = array_merge(
		Css::colors( CZ::get( 'kenta_footer_primary_color' ), [
			'default' => '--kenta-primary-color',
			'active'  => '--kenta-primary-active',
		] ),
		Css::colors( CZ::get( 'kenta_footer_accent_color' ), [
			'default' => '--kenta-accent-color',
			'active'  => '--kenta-accent-active',
		] ),
		Css::colors( CZ::get( 'kenta_footer_base_color' ), [
			'default' => '--kenta-base-color',
			'100'     => '--kenta-base-100',
			'200'     => '--kenta-base-200',
			'300'     => '--kenta-base-300',
		] )
	);

	/**
	 * Archive title
	 */
	$css['.kenta-archive-header']                      = array_merge(
		[ 'text-align' => CZ::get( 'kenta_archive_header_alignment' ) ],
		Css::background( CZ::get( 'kenta_archive_header_background' ) )
	);
	$css['.kenta-archive-header .container']           = Css::dimensions( CZ::get( 'kenta_archive_header_padding' ), 'padding' );
	$css['.kenta-archive-header .archive-title']       = array_merge(
		Css::typography( CZ::get( 'kenta_archive_title_typography' ) ),
		Css::colors( CZ::get( 'kenta_archive_title_color' ), [
			'initial' => 'color',
		] )
	);
	$css['.kenta-archive-header .archive-description'] = array_merge(
		Css::typography( CZ::get( 'kenta_archive_description_typography' ) ),
		Css::colors( CZ::get( 'kenta_archive_description_color' ), [
			'initial' => 'color',
		] )
	);

	$css['.kenta-archive-header::after'] = array_merge(
		[ 'opacity' => CZ::get( 'kenta_archive_header_overlay_opacity' ) ],
		Css::background( CZ::get( 'kenta_archive_header_overlay' ) )
	);

	/**
	 * Posts Pagination
	 */
	if ( CZ::checked( 'kenta_archive_pagination_section' ) ) {
		$pagination_type = CZ::get( 'kenta_pagination_type' );
		$pagination_css  = [];

		if ( $pagination_type === 'numbered' || $pagination_type === 'prev-next' ) {
			$pagination_css = array_merge(
				Css::border( CZ::get( 'kenta_pagination_button_border' ), '--kenta-pagination-button-border' ),
				Css::colors( CZ::get( 'kenta_pagination_button_color' ), [
					'initial' => '--kenta-pagination-initial-color',
					'active'  => '--kenta-pagination-active-color',
					'accent'  => '--kenta-pagination-accent-color',
				] ),
				[ '--kenta-pagination-button-radius' => CZ::get( 'kenta_pagination_button_radius' ) ]
			);
		}

		$css['.kenta-pagination'] = array_merge( $pagination_css,
			Css::typography( CZ::get( 'kenta_pagination_typography' ) ),
			[ 'justify-content' => CZ::get( 'kenta_pagination_alignment' ) ]
		);
	}

	/**
	 * Sidebar
	 */
	$sidebar_style        = CZ::get( 'kenta_global_sidebar_sidebar-style' );
	$widgets_style_preset = CZ::get( 'kenta_global_sidebar_widgets-style' );
	$widgets_css          = $widgets_style_preset === 'custom' ? array_merge(
		Css::background( CZ::get( 'kenta_global_sidebar_widgets-background' ) ),
		Css::border( CZ::get( 'kenta_global_sidebar_widgets-border' ) ),
		Css::shadow( CZ::get( 'kenta_global_sidebar_widgets-shadow' ) )
	) : kenta_card_preset_style( $widgets_style_preset );

	$widgets_css = array_merge(
		$widgets_css,
		Css::dimensions( CZ::get( 'kenta_global_sidebar_widgets-padding' ), 'padding' ),
		Css::dimensions( CZ::get( 'kenta_global_sidebar_widgets-radius' ), 'border-radius' )
	);

	if ( $sidebar_style === 'style-1' ) {
		$css[".kenta-sidebar .kenta-widget"] = $widgets_css;
	}

	$css[".kenta-sidebar"] = array_merge(
		$sidebar_style === 'style-2' ? $widgets_css : [],
		Css::typography( CZ::get( 'kenta_global_sidebar_content-typography' ) ),
		Css::colors( CZ::get( 'kenta_global_sidebar_content-color' ), [
			'text'    => '--kenta-widgets-text-color',
			'initial' => '--kenta-widgets-link-initial',
			'hover'   => '--kenta-widgets-link-hover',
		] ),
		[
			'--kenta-sidebar-width'   => CZ::get( 'kenta_global_sidebar_width' ) ?? '27%',
			'--kenta-sidebar-gap'     => CZ::get( 'kenta_global_sidebar_gap' ) ?? '24px',
			'--kenta-widgets-spacing' => CZ::get( 'kenta_global_sidebar_widgets-spacing' ),
		]
	);

	$css[".kenta-sidebar .widget-title"] = array_merge(
		Css::typography( CZ::get( 'kenta_global_sidebar_title-typography' ) ),
		Css::colors( CZ::get( 'kenta_global_sidebar_title-color' ), [
			'initial'   => 'color',
			'indicator' => '--kenta-heading-indicator',
		] )
	);

	// Buttons
	$button_selectors                         = [
		'[type="submit"]',
		// woocommerce
		'.woocommerce a.button',
		'.woocommerce button.button',
		// widgets
		'.wp-block-search__button',
		'.wc-block-product-search__button',
		// article
		'.kenta-article-content .wp-block-button',
		'.kenta-article-content button',
		'.kenta-prose .wp-block-button',
		'.kenta-prose button'
	];
	$css[ implode( ',', $button_selectors ) ] = kenta_content_buttons_css();

	// Forms
	$css['.kenta-form, form, [type="submit"]'] = Css::typography( CZ::get( 'kenta_content_form_typography' ) );

	$form_presets                                       = kenta_form_style_presets();
	$css[ implode( ',', array_keys( $form_presets ) ) ] = array_merge(
		Css::colors( CZ::get( 'kenta_content_form_color' ), [
			'background' => '--kenta-form-background-color',
			'border'     => '--kenta-form-border-color',
			'active'     => '--kenta-form-active-color',
		] )
	);

	foreach ( $form_presets as $selector => $preset ) {
		$css[ $selector ] = $preset;
	}

	$css = apply_filters( 'kenta_filter_dynamic_css', $css );

	return Css::parse( $css );
}

/**
 * Generate dynamic css for admin
 *
 * @return mixed
 */
function kenta_admin_dynamic_css() {
	$css = [];

	$css['.editor-styles-wrapper'] = array_merge(
		Css::background( CZ::get( 'kenta_site_background' ) )
	);

	$css['.editor-styles-wrapper .wp-block-button'] = kenta_content_buttons_css();

	return Css::parse( apply_filters(
		'kenta_filter_admin_dynamic_css',
		kenta_content_typography_css( '.editor-styles-wrapper', $css )
	) );
}
