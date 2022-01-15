<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 */
?>

<section class="no-results not-found">
	<div class="no-found">
		<header class="page-header">
			<span class="material-icons-outlined">search</span>
			<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'matebook' ); ?></h1>
		</header><!-- .page-header -->

		<div class="page-content">

			<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

				<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'matebook' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

			<?php elseif ( is_search() ) : ?>

				<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'matebook' ); ?></p>
				<?php get_search_form(); ?>

			<?php else : ?>

				<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'matebook' ); ?></p>
				<?php get_search_form(); ?>

			<?php endif; ?>

		</div><!-- .page-content -->
	</div>
</section><!-- .no-results -->
