<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 */
?>

<?php extract($data); ?>

<div class="grid-item">

	<div <?php echo post_class('entry') ?>>

		<?php if ( '' !== get_the_post_thumbnail() ) : ?>
			<div class="thumbnail-attachment">
				<a href="<?php the_permalink(); ?>" class="entry-overlink">
					<?php the_post_thumbnail($image_size); ?>
				</a>
			</div>
		<?php endif; ?>

		<div class="entry-body">

			<h4 class="entry-title">
				<?php if ( is_sticky() ): ?>
					<div class="sticky-label"><span><?php esc_html_e('Featured', 'matebook') ?></span></div>
				<?php endif; ?>
				<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
			</h4>

			<div class="entry-meta">
				<?php echo matebook_blog_post_meta(); ?>
			</div>

			<?php if ( has_excerpt() ): ?>

				<div class="entry-excerpt">
					<?php mad()->the_excerpt(mad()->get_option('post-excerpt-limit')) ?>
				</div>

			<?php else: ?>

				<?php if ( '' !== get_the_content() ): ?>
					<div class="entry-excerpt">
						<?php echo apply_filters( 'the_content', get_the_content() ); ?>
					</div>
				<?php endif; ?>

			<?php endif; ?>

			<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'matebook'),
				'after'       => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			) );
			?>

			<div class="entry-foot">

				<?php if ( mad()->get_option('post-tag') ): ?>
					<?php
					$tags_list = get_the_tag_list( '', ', ', '' );
					if ( $tags_list ) {
						echo '<div class="tag-wrap">';
						echo sprintf( '%s', ' <div class="tagcloud"> ' . $tags_list . '</div>' );
						echo '</div>';
					}
					?>
				<?php endif; ?>

				<?php echo matebook_read_more_link() ?>

			</div>

		</div><!--/ .entry-body-->

	</div><!--/ .entry-->

</div><!--/ .grid-item-->
