<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Kenta
 */

use LottaFramework\Facades\CZ;
use LottaFramework\Icons\IconsManager;
use LottaFramework\Utils;

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function kenta_body_classes( $classes ) {

	$classes[] = 'kenta-body overflow-x-hidden';

	if ( is_page() ) {
		$classes[] = 'kenta-pages';
	}

	if ( is_single() ) {
		$classes[] = 'kenta-single_post';
	}

	if ( kenta_is_woo_shop() ) {
		$classes[] = 'kenta-store';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}

add_filter( 'body_class', 'kenta_body_classes' );

/**
 * Sets the post excerpt length to n words.
 *
 * function tied to the excerpt_length filter hook.
 *
 * @uses filter excerpt_length
 */
function kenta_excerpt_length( $length ) {

	if ( is_admin() || ! kenta_app()->has( 'store.excerpt_length' ) ) {
		return $length;
	}

	return absint( kenta_app()['store.excerpt_length'] );
}

add_filter( 'excerpt_length', 'kenta_excerpt_length' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a option from customizer
 *
 * @return string option from customizer prepended with an ellipsis.
 */
function kenta_excerpt_more( $link ) {
	if ( is_admin() || ! kenta_app()->has( 'store.excerpt_more_text' ) ) {
		return $link;
	}

	return kenta_app()['store.excerpt_more_text'];
}

add_filter( 'excerpt_more', 'kenta_excerpt_more' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function kenta_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

add_action( 'wp_head', 'kenta_pingback_header' );

/**
 * Add selective dynamic css output container
 */
function kenta_add_selective_css_container() {
	?>
    <style id="kenta-global-selective-css"></style>
    <style id="kenta-woo-selective-css"></style>
    <style id="kenta-header-selective-css"></style>
    <style id="kenta-footer-selective-css"></style>
    <style id="kenta-transparent-selective-css"></style>
	<?php
}

add_action( 'wp_head', 'kenta_add_selective_css_container' );

/**
 * Add primary sidebar
 *
 * @param $layout
 */
function kenta_add_primary_sidebar( $layout ) {
	// Include primary sidebar.
	if ( $layout === 'left-sidebar' || $layout === 'right-sidebar' ) {
		get_sidebar();
	}
}

add_action( 'kenta_action_sidebar', 'kenta_add_primary_sidebar' );

/**
 * Site header open
 */
function kenta_add_header_open() {
	$transparent = kenta_is_transparent_header();
	$device      = CZ::get( 'kenta_enable_transparent_header_device' );
	?>
    <header class="<?php Utils::the_clsx( [
		'kenta-site-header text-accent'    => true,
		'kenta-transparent-header'         => $transparent,
		'kenta-transparent-header-desktop' => $transparent && ( $device === 'all' || $device === 'desktop' ),
		'kenta-transparent-header-mobile'  => $transparent && ( $device === 'all' || $device === 'mobile' ),
	] ); ?>">
	<?php
}

add_action( 'kenta_action_before_header', 'kenta_add_header_open' );
/**
 * Site header closed
 */
function kenta_add_header_close() {
	?>
    </header>
	<?php
}

add_action( 'kenta_action_after_header', 'kenta_add_header_close' );

/**
 * Header render
 */
function kenta_header_render() {
	if ( kenta_get_current_post_meta( 'disable-site-header' ) !== 'yes' ) {

		if ( Kenta_Header_Builder::shouldRenderRow( 'modal' ) ) {
			Kenta_Header_Builder::render( 'modal' );
		}
		if ( Kenta_Header_Builder::shouldRenderRow( 'top_bar' ) ) {
			Kenta_Header_Builder::render( 'top_bar' );
		}
		if ( Kenta_Header_Builder::shouldRenderRow( 'primary_navbar' ) ) {
			Kenta_Header_Builder::render( 'primary_navbar' );
		}
		if ( Kenta_Header_Builder::shouldRenderRow( 'bottom_row' ) ) {
			Kenta_Header_Builder::render( 'bottom_row' );
		}
	}
}

add_action( 'kenta_action_header', 'kenta_header_render' );

function kenta_header_row_start( $id ) {
	$attrs = [
		'class'    => 'kenta-header-row kenta-header-row-' . $id,
		'data-row' => $id,
	];

	if ( is_customize_preview() ) {
		$attrs['data-shortcut']          = 'border';
		$attrs['data-shortcut-location'] = 'kenta_header:' . $id;
	}

	echo '<div ' . Utils::render_attribute_string( $attrs ) . '>';
}

add_action( 'kenta_start_header_row', 'kenta_header_row_start', 10 );

function kenta_header_row_container_start( $id ) {
	echo '<div class="container mx-auto text-xs px-gutter flex flex-wrap items-stretch">';
}

add_action( 'kenta_start_header_row', 'kenta_header_row_container_start', 20 );

function kenta_header_row_close() {
	echo '</div>';
}

// header row
add_action( 'kenta_after_header_row', 'kenta_header_row_close', 10 );
// container
add_action( 'kenta_after_header_row', 'kenta_header_row_close', 20 );

/**
 * Show posts pagination
 */
function kenta_show_posts_pagination() {
	global $wp_query;
	$pages = $wp_query->max_num_pages;

	global $paged;
	$paged = empty( $paged ) ? 1 : $paged;

	// Don't print empty markup in archives if there's only one page or pagination is disabled.
	if ( ! CZ::checked( 'kenta_archive_pagination_section' ) ||
	     ( $pages < 2 && ( is_home() || is_archive() || is_search() ) ) ) {
		return;
	}

	$type                 = CZ::get( 'kenta_pagination_type' );
	$show_disabled_button = CZ::checked( 'kenta_pagination_disabled_button' );

	$css = apply_filters( 'kenta_pagination_css', [ 'kenta-pagination' ], $type );

	$pagination_attrs = [
		'class'                     => Utils::clsx( $css ),
		'data-pagination-type'      => $type,
		'data-pagination-max-pages' => $pages,
	];

	if ( is_customize_preview() ) {
		$pagination_attrs['data-shortcut']          = 'border';
		$pagination_attrs['data-shortcut-location'] = 'kenta_archive:kenta_archive_pagination_section';
	}

	$btn_class          = 'kenta-btn';
	$current_btn_class  = $btn_class . ' kenta-btn-active';
	$disabled_btn_class = $btn_class . ' kenta-btn-disabled';

	$show_previous_button = function ( $disabled = false ) use ( $paged, $btn_class, $disabled_btn_class ) {
		$prev_type = CZ::get( 'kenta_pagination_prev_next_type' );

		if ( $disabled ) {
			echo '<span class="' . esc_attr( $disabled_btn_class . ' kenta-prev-btn kenta-prev-btn-' . $prev_type ) . '">';
		} else {
			echo '<a href="' . esc_url( get_pagenum_link( $paged - 1, true ) ) .
			     '" class="' . esc_attr( $btn_class . ' kenta-prev-btn kenta-prev-btn-' . $prev_type ) . '">';
		}

		if ( $prev_type === 'text' ) {
			echo '<span>' . esc_html( CZ::get( 'kenta_pagination_prev_text' ) ) . '</span>';
		} else {
			IconsManager::print( CZ::get( 'kenta_pagination_prev_icon' ) );
		}

		echo $disabled ? '</span>' : '</a>';
	};

	$show_next_button = function ( $disabled = false ) use ( $paged, $btn_class, $disabled_btn_class ) {
		$next_type = CZ::get( 'kenta_pagination_prev_next_type' );

		if ( $disabled ) {
			echo '<span class="' . esc_attr( $disabled_btn_class . ' kenta-next-btn kenta-next-btn-' . $next_type ) . '">';
		} else {
			echo '<a href="' . esc_url( get_pagenum_link( $paged + 1, true ) ) .
			     '" class="' . esc_attr( $btn_class . ' kenta-next-btn kenta-next-btn-' . $next_type ) . '">';
		}

		echo '<span>';
		if ( $next_type === 'text' ) {
			esc_html_e( CZ::get( 'kenta_pagination_next_text' ) );
		} else {
			IconsManager::print( CZ::get( 'kenta_pagination_next_icon' ) );
		}
		echo '</span>';

		echo $disabled ? '</span>' : '</a>';
	};

	echo '<nav ' . Utils::render_attribute_string( $pagination_attrs ) . '>';

	if ( 'prev-next' === $type ) {

		// Show previous button
		if ( $paged > 1 ) {
			$show_previous_button();
		} elseif ( $show_disabled_button ) {
			$show_previous_button( true );
		}

		// Show next button
		if ( $paged < $pages ) {
			$show_next_button();
		} elseif ( $show_disabled_button ) {
			$show_next_button( true );
		}

	} elseif ( 'numbered' === $type ) {
		$range     = 2;
		$showitems = ( $range * 2 ) + 1;

		// Show previous button
		if ( CZ::checked( 'kenta_pagination_prev_next_button' ) ) {
			if ( $paged > 1 ) {
				$show_previous_button();
			} elseif ( $show_disabled_button ) {
				$show_previous_button( true );
			}
		}

		// Show numeric buttons
		for ( $i = 1; $i <= $pages; $i ++ ) {
			if ( 1 !== $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
				if ( $paged === $i ) {
					echo '<span class="' . esc_attr( $current_btn_class ) . '">' . $i . '</span>';
				} else {
					echo '<a class="' . esc_attr( $btn_class ) . '" href="' . esc_url( get_pagenum_link( $i, true ) ) . '">' . $i . '</a>';
				}
			}
		}

		// Show next button
		if ( CZ::checked( 'kenta_pagination_prev_next_button' ) ) {
			if ( $paged < $pages ) {
				$show_next_button();
			} elseif ( $show_disabled_button ) {
				$show_next_button( true );
			}
		}
	}

	do_action( 'kenta_show_pagination', $type, $pages, $paged );

	echo '</nav>';
}

add_action( 'kenta_action_posts_pagination', 'kenta_show_posts_pagination' );

/**
 * Show page content
 */
function kenta_show_page_content() {
	kenta_show_article( 'kenta_pages', 'page' );
}

add_action( 'kenta_action_page', 'kenta_show_page_content' );

/**
 * Show single post content
 */
function kenta_show_single_post_content() {
	kenta_show_article( 'kenta_single_post', 'post' );
}

add_action( 'kenta_action_single_post', 'kenta_show_single_post_content' );

/**
 * Show posts navigation
 */
function kenta_add_post_navigation() {
	if ( ! CZ::checked( 'kenta_post_navigation' ) ) {
		return;
	}

	$attrs = [
		'class' => 'kenta-max-w-content mx-auto kenta-post-navigation',
	];

	if ( is_customize_preview() ) {
		$attrs['data-shortcut']          = 'border';
		$attrs['data-shortcut-location'] = 'kenta_single_post:kenta_post_navigation';
	}

	echo '<div ' . Utils::render_attribute_string( $attrs ) . '>';

	the_post_navigation( [
		'prev_text'          => IconsManager::render( CZ::get( 'kenta_post_navigation_prev_icon' ) ) . '<span class="px-gutter">%title</span>',
		'next_text'          => IconsManager::render( CZ::get( 'kenta_post_navigation_next_icon' ) ) . '<span class="px-gutter">%title</span>',
		'screen_reader_text' => '<span class="nav-subtitle screen-reader-text">' . esc_html__( 'Page', 'kenta' ) . '</span>',
	] );

	echo '</div>';
}

add_action( 'kenta_action_after_single_post', 'kenta_add_post_navigation' );

/**
 * Show post comments
 */
function kenta_show_post_comments() {
	// If comments are open, or we have at least one comment, load up the comment template.
	if ( ( comments_open() || get_comments_number() ) ) {
		comments_template();
	}
}

add_action( 'kenta_action_after_page', 'kenta_show_post_comments', 30 );
add_action( 'kenta_action_after_single_post', 'kenta_show_post_comments', 30 );

/**
 * Footer open
 */
function kenta_footer_open() {
	?>
    <footer class="kenta-footer-area text-accent">
	<?php
}

add_action( 'kenta_action_before_footer', 'kenta_footer_open' );


/**
 * Footer render
 */
function kenta_footer_render() {
	if ( kenta_get_current_post_meta( 'disable-site-footer' ) !== 'yes' ) {
		$rows = [ 'top', 'middle', 'bottom' ];

		foreach ( $rows as $row ) {
			if ( Kenta_Footer_Builder::shouldRenderRow( $row ) ) {
				Kenta_Footer_Builder::render( $row, function ( $css, $args ) {
					$css[] = 'flex';

					return $css;
				} );
			}
		}
	}
}

add_action( 'kenta_action_footer', 'kenta_footer_render' );

/**
 * Close footer
 */
function kenta_footer_close() {
	?>
    </footer>
	<?php
}

add_action( 'kenta_action_after_footer', 'kenta_footer_close' );
