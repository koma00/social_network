<?php
global $matebook_settings, $matebook_config; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'entry', 'single' ) ); ?>>

	<div class="entry-single">

		<div class="entry-body">

			<div class="entry-main-content">

				<?php if ( is_singular('post') ): ?>

					<?php get_template_part( 'template-parts/post/featured', 'image' ); ?>

					<div class="entry-meta">
						<?php echo matebook_blog_post_meta(); ?>
					</div>

				<?php else: ?>

					<h3 class="entry-title"><?php the_title() ?></h3>

				<?php endif; ?>

				<div class="entry-content">

					<?php
					the_content(
						sprintf(
							__( 'Continue reading %s', 'matebook' ),
							'<span class="screen-reader-text">' . get_the_title() . '</span>'
						)
					);

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'matebook' ),
							'after'  => '</div>'
						)
					);
					?>

				</div><!--/ .entry-content-->

			</div><!--/ .entry-main-content-->

			<?php if ( mad()->get_option( 'single-post-tag' ) ): ?>
				<?php
				$tags_list = get_the_tag_list( ' ', ', ', ' ' );

				if ( $tags_list ) {
					echo '<div class="tag-wrap">';
					echo sprintf( '%s', '<div class="tagcloud"> ' . $tags_list . '</div>' );
					echo '</div>';
				}
				?>
			<?php endif; ?>

		</div><!--/ .entry-body-->

		<?php
		if ( mad()->get_option( 'single-post-comments' ) ) {
			if ( comments_open() || get_comments_number() ) { ?>
				<div class="entry-comments">
					<?php comments_template(); ?>
				</div>
			<?php }
		}
		?>

	</div><!--/ .entry-single-->

	<?php if ( mad()->get_option( 'single-post-navigation' ) ): ?>

		<?php
		the_post_navigation( array(
			'next_text' => '<span class="meta-nav">' . esc_html__( 'Next', 'matebook' ) . '</span>',
			'prev_text' => '<span class="meta-nav">' . esc_html__( 'Previous', 'matebook' ) . '</span>',
		) );
		?>

	<?php endif; ?>

</article>

