<?php
/**
 * Show posts loop
 *
 * @package Kenta
 */

use LottaFramework\Facades\CZ;
use LottaFramework\Utils;

$layout = 'no-sidebar';

if ( CZ::checked( 'kenta_archive_sidebar_section' ) ) {
	$layout = CZ::get( 'kenta_archive_sidebar_layout' );
}

?>

<div class="<?php Utils::the_clsx( kenta_container_css( $layout, 'boxed', [ 'kenta-posts-container' ] ) ); ?>">
    <div id="content" class="kenta-posts flex-grow max-w-full">
		<?php kenta_render_posts_list(); ?>
    </div>

	<?php
	/**
	 * Hook - kenta_action_sidebar.
	 */
	do_action( 'kenta_action_sidebar', $layout );
	?>
</div>
