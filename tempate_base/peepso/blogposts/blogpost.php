<div class="ps-blogposts__post">
	<div class="ps-blogposts__post-inside">
		<div class="ps-blogposts__post-body">

			<!-- Featured image -->
			<?php
			$image_position = "";
			$image_size = "medium";

			if(PeepSo::get_option('blogposts_profile_featured_image_position') == "left") {
				$image_position = "ps-blogposts__post-image--left";
			}

			if(PeepSo::get_option('blogposts_profile_featured_image_position') == "right") {
				$image_position = "ps-blogposts__post-image--right";
			}

			if(PeepSo::get_option('blogposts_profile_featured_image_position') == "top") {
				$image_position = "ps-blogposts__post-image--top";
				$image_size = "large";
			}

			if(PeepSo::get_option('blogposts_profile_featured_image_enable') && (has_post_thumbnail($post) || PeepSo::get_option('blogposts_profile_featured_image_enable_if_empty'))) : ?>
				<div style="background-image: url('<?php echo get_the_post_thumbnail_url($post, $image_size);?>');" class="ps-blogposts__post-image <?php echo esc_attr($image_position); ?>">
					<a href="<?php echo get_permalink($post);?>"></a>
				</div>
			<?php endif; ?>

			<!-- Post title -->
			<h2 class="ps-blogposts__post-title">
				<a title="<?php echo get_the_title($post);?>" href="<?php echo get_permalink($post);?>">
					<?php echo get_the_title($post);?>
				</a>
			</h2>

			<!-- Post meta -->
			<div class="entry-meta">
				<?php echo matebook_blog_post_meta($post); ?>
			</div>

			<!-- Post content -->
			<?php if(FALSE !== $post_content):?>
				<div class="ps-blogposts__post-content">
					<?php echo stripslashes($post_content); ?>
				</div>
			<?php endif; ?>

			<div class="entry-foot">

				<?php if ( mad()->get_option('post-tag') ): ?>
					<?php
					$tags_list = get_the_tag_list( '', ', ', '', $post );
					if ( $tags_list ) {
						echo '<div class="tag-wrap">';
						echo sprintf( '%s', ' <div class="tagcloud"> ' . $tags_list . '</div>' );
						echo '</div>';
					}
					?>
				<?php endif; ?>

				<?php echo matebook_read_more_link($post) ?>

			</div>

		</div>
	</div>
</div>
