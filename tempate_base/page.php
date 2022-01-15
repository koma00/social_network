<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 */

get_header(); ?>

	<!-- - - - - - - - - - - - - Page - - - - - - - - - - - - - - - -->

	<div class="<?php echo apply_filters( 'matebook_content_classes', [ 'site-main' ] ) ?>">

		<?php get_sidebar( 'left' ); ?>

		<div class="site-content">

			<?php if ( have_posts() ) : ?>

				<?php
				// Start the loop.
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', 'page' );

					if ( comments_open() || 0 !== intval( get_comments_number() ) ) {
						echo '<div class="entry-comments">';
						comments_template();
						echo '</div>';
					}

					// End the loop.
				endwhile;

				// Previous/next page navigation.
				the_posts_pagination( array(
					'prev_text'          => esc_html__( 'Previous page', 'matebook' ),
					'next_text'          => esc_html__( 'Next page', 'matebook' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'matebook' ) . ' </span>',
				) );

			// If no content, include the "No posts found" template.
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif;
			?>

		</div>

		<?php get_sidebar( 'right' ); ?>

	</div><!--/ .site-main-->

	<!-- - - - - - - - - - - - -/ Page - - - - - - - - - - - - - - -->

<?php get_footer();

