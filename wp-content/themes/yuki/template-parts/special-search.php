<?php
/**
 * Template part for search result.
 *
 * @package Yuki
 */
?>

<?php if ( have_posts() ): ?>
    <header class="yuki-archive-header container mx-auto px-gutter">
        <h1 class="archive-title">
			<?php
			/* translators: %s: Keywords searched by users */
			printf( esc_html__( 'Search Results for: %s', 'yuki' ), '<span>' . get_search_query() . '</span>' );
			?>
        </h1>
    </header>
<?php endif; ?>

<?php get_template_part( 'template-parts/special', 'loop' ) ?>
