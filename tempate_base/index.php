<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 */

get_header(); ?>

	<div class="<?php echo apply_filters( 'matebook_content_classes', [ 'site-main' ] ) ?>">

		<?php get_sidebar( 'left' ); ?>

		<div class="site-content">

			<?php if ( have_posts() ) : ?>

				<?php
				$css_classes = [
					'entry-holder'
				];

				$columns = mad()->get_option('post-columns');
				$css_classes[] = $columns;

				$wrapper_attributes   = [];
				$wrapper_attributes[] = 'class="' . esc_attr( trim( implode( ' ', array_filter( $css_classes ) ) ) ) . '"';
				$box_css_classes  = [
					'entry-box'
				];
				$box_attributes[] = 'class="' . esc_attr( trim( implode( ' ', array_filter( $box_css_classes ) ) ) ) . '"';
				?>

				<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

					<div <?php echo implode( ' ', $box_attributes ) ?>>

						<?php while ( have_posts() ) : the_post(); ?>

							<?php
							global $post;
							matebook_locate_template( 'template-parts/post/content-standard.php', [
								'post'       => $post,
								'image_size' => $columns == 'col2' ? 'matebook-375x420-center-center' : 'matebook-750x350-center-center'
							] );
							?>

						<?php endwhile; ?>

					</div><!--/ .entry-box-->

					<?php echo matebook_paging_nav(); ?>

				</div><!--/ .entry-holder-->

			<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>

		</div><!--/ .site-content-->

		<?php get_sidebar( 'right' ); ?>

	</div><!--/ .site-main-->

<?php get_footer(); ?>