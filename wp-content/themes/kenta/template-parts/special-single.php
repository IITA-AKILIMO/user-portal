<?php
/**
 * The template part for single post.
 *
 * @package Kenta
 */

use LottaFramework\Facades\CZ;
use LottaFramework\Utils;

$layout          = 'no-sidebar';
$container_style = 'boxed';

$post_sidebar   = kenta_get_current_post_meta( 'site-sidebar-layout' );
$page_container = kenta_get_current_post_meta( 'site-container-style' );

if ( $post_sidebar && $post_sidebar !== 'default' ) {
	$layout = $post_sidebar;
} else if ( CZ::checked( 'kenta_post_sidebar_section' ) ) {
	$layout = CZ::get( 'kenta_post_sidebar_layout' );
}

if ( $page_container && $page_container !== 'default' ) {
	$container_style = $page_container;
} else {
	$container_style = CZ::get( 'kenta_single_post_container_style' );
}

?>

<div class="<?php Utils::the_clsx( kenta_container_css( $layout, $container_style ) ) ?>">
    <div id="content" class="flex-grow max-w-full">
		<?php
		// posts loop
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook - kenta_action_before_single_post.
			 */
			do_action( 'kenta_action_before_single_post' );

			/**
			 * Hook - kenta_action_single_post.
			 */
			do_action( 'kenta_action_single_post' );

			/**
			 * Hook - kenta_action_after_single_post.
			 */
			do_action( 'kenta_action_after_single_post' );
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
