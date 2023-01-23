<?php
/**
 * The template part for pages.
 *
 * @package Kenta
 */

use LottaFramework\Facades\CZ;
use LottaFramework\Utils;

$layout          = 'no-sidebar';
$container_style = 'boxed';

$page_sidebar   = kenta_get_current_post_meta( 'site-sidebar-layout' );
$page_container = kenta_get_current_post_meta( 'site-container-style' );

if ( $page_sidebar && $page_sidebar !== 'default' ) {
	$layout = $page_sidebar;
} else if ( ( ! is_front_page() || is_home() ) && CZ::checked( 'kenta_page_sidebar_section' ) ) {
	$layout = CZ::get( 'kenta_page_sidebar_layout' );
}

if ( $page_container && $page_container !== 'default' ) {
	$container_style = $page_container;
} else {
	$container_style = CZ::get( 'kenta_pages_container_style' );
}

/**
 * Hook - kenta_action_before_page_container.
 */
do_action( 'kenta_action_before_page_container', $layout );
?>

<div class="<?php Utils::the_clsx( kenta_container_css( $layout, $container_style ) ) ?>">
    <div id="content" class="kenta-article-content-wrap flex-grow max-w-full">
		<?php
		// posts loop
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook - kenta_action_before_page.
			 */
			do_action( 'kenta_action_before_page' );

			/**
			 * Hook - kenta_action_page.
			 */
			do_action( 'kenta_action_page', $layout );

			/**
			 * Hook - kenta_action_after_page.
			 */
			do_action( 'kenta_action_after_page' );
		}
		?>
    </div>

	<?php
	/**
	 * Hook - kenta_action_sidebar.
	 */
	do_action( 'kenta_action_sidebar', $layout );
	?>
</div>
