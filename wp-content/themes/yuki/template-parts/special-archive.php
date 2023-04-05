<?php
/**
 * The template for archive page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Yuki
 */

?>

<section class="yuki-archive-header container mx-auto px-gutter">
	<?php
	the_archive_title( '<h1 class="archive-title">', '</h1>' );
	the_archive_description( '<div class="archive-description">', '</div>' );
	?>
</section>

<?php get_template_part( 'template-parts/special', 'loop' ) ?>
