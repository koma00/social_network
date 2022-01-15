<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 */
get_header(); ?>

<?php global $matebook_settings; ?>

	<!-- - - - - - - - - - - - - Page - - - - - - - - - - - - - - - -->

	<div class="<?php echo apply_filters( 'matebook_content_classes', [ 'site-main' ] ) ?>">

		<?php get_sidebar( 'left' ); ?>

		<div class="site-content">

			<?php while ( have_posts() ) : the_post();

				// Include the single post content template.
				get_template_part( 'template-parts/single/content', 'single' );

				// End of the loop.
			endwhile; ?>

		</div><!--/ .site-content-->

		<?php get_sidebar( 'right' ); ?>

	</div><!--/ .site-main-->

<?php get_footer(); ?>