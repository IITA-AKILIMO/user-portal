<?php
/**
 * Kenta Theme Setup
 *
 * @package Kenta
 */

use LottaFramework\Facades\CZ;
use LottaFramework\Typography\Fonts;


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function kenta_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Kenta, use a find and replace
	 * to change 'kenta' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'kenta', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Support align wide
	add_theme_support( 'align-wide' );

	// Gutenberg custom stylesheet
	add_theme_support( 'editor-styles' );
	add_editor_style( 'dist/css/editor-style' . ( defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min' ) . '.css' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	// Support responsive embeds
	add_theme_support( "responsive-embeds" );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Gutenberg editor color palette
	if ( CZ::checked( 'kenta_color_palette_in_gutenberg' ) ) {
		add_theme_support( 'editor-color-palette', array(
			array(
				'name'  => __( 'Primary Color', 'kenta' ),
				'slug'  => 'kenta-primary',
				'color' => 'var(--kenta-primary-color)'
			),
			array(
				'name'  => __( 'Primary Active', 'kenta' ),
				'slug'  => 'kenta-primary-active',
				'color' => 'var(--kenta-primary-active)'
			),
			array(
				'name'  => __( 'Accent Color', 'kenta' ),
				'slug'  => 'kenta-accent',
				'color' => 'var(--kenta-accent-color)'
			),
			array(
				'name'  => __( 'Accent Active', 'kenta' ),
				'slug'  => 'kenta-accent-active',
				'color' => 'var(--kenta-accent-active)'
			),
			array(
				'name'  => __( 'Base Color', 'kenta' ),
				'slug'  => 'kenta-base',
				'color' => 'var(--kenta-base-color)'
			),
			array(
				'name'  => __( 'Base 50', 'kenta' ),
				'slug'  => 'kenta-base-50',
				'color' => 'var(--kenta-base-50)'
			),
			array(
				'name'  => __( 'Base 100', 'kenta' ),
				'slug'  => 'kenta-base-100',
				'color' => 'var(--kenta-base-100)'
			),
			array(
				'name'  => __( 'Base 200', 'kenta' ),
				'slug'  => 'kenta-base-200',
				'color' => 'var(--kenta-base-200)'
			),
			array(
				'name'  => __( 'Base 300', 'kenta' ),
				'slug'  => 'kenta-base-300',
				'color' => 'var(--kenta-base-300)'
			),
		) );
	}

	// Starter Content
	add_theme_support( 'starter-content', apply_filters( 'kenta_filter_starter_content', array(
		'widgets'   => array(
			'primary-sidebar'           => array(
				'search',
				'text_about',
				'text_business_info',
			),
			'kenta_footer_el_widgets_1' => array(
				'text_business_info',
			),
			'kenta_footer_el_widgets_2' => array(
				'text_about',
			),
			'kenta_footer_el_widgets_3' => array(
				'recent-posts',
				'categories',
			),
			'kenta_footer_el_widgets_4' => array(
				'search',
				'recent-comments',
			),
		),
		'posts'     => array(
			'home' => array(
				'post_type'    => 'page',
				'post_title'   => __( 'Home', 'kenta' ),
				'post_content' => '',
			),
			'about',
			'contact',
			'blog',
		),
		'nav_menus' => array(
			'kenta_header_el_menu_1'           => array(
				'name'  => __( 'Header Menu #1', 'kenta' ),
				'items' => array(
					'link_home',
					'page_about',
					'page_contact',
					'page_blog',
					'post_news',
				),
			),
			'kenta_header_el_menu_2'           => array(
				'name'  => __( 'Header Menu #2', 'kenta' ),
				'items' => array(
					'link_home',
					'page_about',
					'page_contact',
					'page_blog',
					'post_news',
				),
			),
			'kenta_header_el_collapsable_menu' => array(
				'name'  => __( 'Collapsable Menu', 'kenta' ),
				'items' => array(
					'link_home',
					'page_about',
					'page_contact',
					'page_blog',
					'post_news',
				),
			),
			'kenta_footer_el_menu'             => array(
				'name'  => __( 'Footer Menu', 'kenta' ),
				'items' => array(
					'page_about',
					'page_contact',
					'page_blog',
				),
			),
		),
	) ) );
}

add_action( 'after_setup_theme', 'kenta_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kenta_widgets_init() {
	$sidebar_class = 'kenta-widget clearfix %2$s';
	if ( CZ::checked( 'kenta_global_sidebar_scroll-reveal' ) ) {
		$sidebar_class = 'kenta-scroll-reveal-widget ' . $sidebar_class;
	}

	$title_class = 'widget-title mb-half-gutter heading-content';
	$tag         = CZ::get( 'kenta_global_sidebar_title-tag' ) ?? 'h2';

	register_sidebar(
		array(
			'name'          => esc_html__( 'Primary Sidebar', 'kenta' ),
			'id'            => 'primary-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'kenta' ),
			'before_widget' => '<section id="%1$s" class="' . esc_attr( $sidebar_class ) . '">',
			'after_widget'  => '</section>',
			'before_title'  => '<' . $tag . ' class="' . esc_attr( $title_class ) . '">',
			'after_title'   => '</' . $tag . '>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Store Sidebar', 'kenta' ),
			'id'            => 'store-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'kenta' ),
			'before_widget' => '<section id="%1$s" class="' . esc_attr( $sidebar_class ) . '">',
			'after_widget'  => '</section>',
			'before_title'  => '<' . $tag . ' class="' . esc_attr( $title_class ) . '">',
			'after_title'   => '</' . $tag . '>',
		)
	);
}

add_action( 'widgets_init', 'kenta_widgets_init' );

function kenta_register_meta_settings() {
	$object_subtype = apply_filters( 'kenta_filter_meta_object_subtype', '' );

	register_post_meta(
		$object_subtype,
		'site-container-style',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'default'       => 'default',
			'type'          => 'string',
			'auth_callback' => '__return_true',
		)
	);

	register_post_meta(
		$object_subtype,
		'site-container-layout',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'default'       => 'default',
			'type'          => 'string',
			'auth_callback' => '__return_true',
		)
	);

	register_post_meta(
		$object_subtype,
		'site-sidebar-layout',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'default'       => 'default',
			'type'          => 'string',
			'auth_callback' => '__return_true',
		)
	);

	register_post_meta(
		$object_subtype,
		'site-transparent-header',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'default'       => 'default',
			'type'          => 'string',
			'auth_callback' => '__return_true',
		)
	);

	register_post_meta(
		$object_subtype,
		'disable-article-header',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'default'       => 'default',
			'type'          => 'string',
			'auth_callback' => '__return_true',
		)
	);

	register_post_meta(
		$object_subtype,
		'disable-site-header',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'default'       => 'default',
			'type'          => 'string',
			'auth_callback' => '__return_true',
		)
	);

	register_post_meta(
		$object_subtype,
		'disable-site-footer',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'default'       => 'default',
			'type'          => 'string',
			'auth_callback' => '__return_true',
		)
	);

	register_post_meta(
		$object_subtype,
		'disable-content-area-spacing',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'default'       => 'default',
			'type'          => 'string',
			'auth_callback' => '__return_true',
		)
	);
}

add_action( 'init', 'kenta_register_meta_settings' );

/**
 * Enqueue scripts and styles.
 */
function kenta_enqueue_scripts() {
	$suffix = defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min';

	// Vendors
	wp_enqueue_style( 'lotta-fontawesome' );

	wp_enqueue_style(
		'kenta-style',
		get_template_directory_uri() . '/dist/css/style' . $suffix . '.css',
		array(),
		KENTA_VERSION
	);

	wp_enqueue_script(
		'kenta-script',
		get_template_directory_uri() . '/dist/js/app' . $suffix . '.js',
		array( 'jquery' ),
		KENTA_VERSION,
		true
	);


	kenta_enqueue_global_vars();
	kenta_enqueue_dynamic_css();
	kenta_enqueue_transparent_header_css();
	Fonts::enqueue_scripts( 'kenta_fonts', KENTA_VERSION );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'kenta_enqueue_scripts', 20 );

function kenta_enqueue_admin_scripts() {
	$suffix = defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min';

	kenta_enqueue_global_vars();
	kenta_enqueue_global_vars( ':root', 'admin' );
	kenta_enqueue_admin_dynamic_css();

	Fonts::enqueue_scripts( 'kenta_fonts', KENTA_VERSION );

	wp_register_script(
		'kenta-admin-script',
		get_template_directory_uri() . '/dist/js/admin' . $suffix . '.js',
		[ 'jquery' ],
		KENTA_VERSION
	);

	// Theme admin scripts
	wp_register_style(
		'kenta-admin-style',
		get_template_directory_uri() . '/dist/css/admin' . $suffix . '.css',
		[],
		KENTA_VERSION
	);

	wp_enqueue_script( 'kenta-admin-script' );
	wp_enqueue_style( 'kenta-admin-style' );

	// Admin script
	wp_localize_script( 'kenta-admin-script', 'KentaAdmin', [
		'install_cmp_url' => esc_url( add_query_arg( array( 'action' => 'kenta_install_companion' ), admin_url( 'admin.php' ) ) ),
	] );
}

add_action( 'admin_enqueue_scripts', 'kenta_enqueue_admin_scripts', 9999 );

function kenta_enqueue_block_editor_assets() {
	global $pagenow;

	if ( 'widgets.php' === $pagenow || is_customize_preview() ) {
		return;
	}

	$suffix = defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min';

	wp_register_script(
		'kenta-block-editor-scripts',
		get_template_directory_uri() . '/dist/js/block-editor' . $suffix . '.js',
		[ 'wp-plugins', 'wp-edit-post', 'wp-element' ],
		KENTA_VERSION
	);

	wp_enqueue_script( 'kenta-block-editor-scripts' );
}

add_action( 'enqueue_block_editor_assets', 'kenta_enqueue_block_editor_assets' );

/**
 * Enqueue scripts and styles for customizer.
 */
function kenta_enqueue_customizer_scripts() {
	$suffix = defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min';

	wp_enqueue_style(
		'kenta-customizer-style',
		get_template_directory_uri() . '/dist/css/customizer' . $suffix . '.css',
		array(),
		KENTA_VERSION
	);

	wp_enqueue_script(
		'kenta-customizer-script',
		get_template_directory_uri() . '/dist/js/customizer' . $suffix . '.js',
		array( 'lotta-customizer-script', 'customize-controls', 'jquery' ),
		KENTA_VERSION
	);
}

add_action( 'customize_controls_enqueue_scripts', 'kenta_enqueue_customizer_scripts', 10 );

function kenta_enqueue_customize_preview_scripts() {
	$suffix = defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min';

	wp_enqueue_script(
		'kenta-customizer-preview-script',
		get_template_directory_uri() . '/dist/js/customizer-preview' . $suffix . '.js',
		array( 'customize-preview', 'customize-selective-refresh' ),
		KENTA_VERSION
	);
}

add_action( 'customize_preview_init', 'kenta_enqueue_customize_preview_scripts', 20 );
