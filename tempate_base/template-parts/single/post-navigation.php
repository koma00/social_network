<?php
/**
 * Template part for displaying portfolio project navigation
 *
 */

$next_post = get_next_post();
$prev_post = get_previous_post();

if ( ! $next_post && ! $prev_post ) {
	return;
}
?>

<nav class="nav-navigation" role="navigation">

	<div class="nav-links">

		<?php if ( $prev_post ) : ?>

			<div class="nav-previous">

				<div class="navigation__summary">
					<div class="nav-titles"><?php esc_html_e( 'Previous Post', 'matebook' ); ?></div>

					<h6 class="post-title">
						<a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>">
							<?php echo esc_html( $prev_post->post_title )  ?>
						</a>
					</h6>
				</div>

			</div>

		<?php endif; ?>

		<?php if ( $next_post ) : ?>

			<div class="nav-next">

				<div class="navigation__summary">
					<div class="nav-titles"><?php esc_html_e( 'Next Post', 'matebook' ); ?></div>

					<h6 class="post-title">
						<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>">
							<?php echo esc_html( $next_post->post_title )  ?>
						</a>
					</h6>
				</div>

			</div>

		<?php endif; ?>

	</div>

</nav>
