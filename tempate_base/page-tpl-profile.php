<?php
/*
  Template Name: User Profile
*/

get_header();

$PeepSoUrlSegments = PeepSoUrlSegments::get_instance();
$current = $PeepSoUrlSegments->get(2) ? $PeepSoUrlSegments->get(2) : 'stream';
?>

	<div class="site-profile profile-page--full">

		<?php get_template_part( 'template-parts/peepso/focus' ); ?>

		<div class="<?php echo apply_filters( 'matebook_content_classes', [ 'site-main', 'profile-segment-' . $current ] ) ?>">

			<?php get_sidebar( 'left' ); ?>

			<div class="site-content">
				<?php if ( have_posts() ) : ?>

					<?php
					// Start the loop.
					while ( have_posts() ) : the_post();

						the_content();

						// End the loop.
					endwhile;
				endif;
				?>
			</div>

			<?php get_sidebar( 'right' ); ?>

		</div>

	</div>

<?php

get_footer();
