<div class="ps-blogposts__authorbox">

	<?php
	if(strlen($author_name_pre_text = PeepSo::get_option('blogposts_authorbox_author_name_pre_text',''))) {
		echo '<h5 class="author-name">' . $author_name_pre_text . '</h5>';
	}
	?>

	<div class="ps-author-body">

		<div class="ps-avatar">
			<a href="<?php echo esc_url($author->get_profileurl());?>">
				<img alt="<?php echo sprintf('%s - %s', $author->get_fullname(), esc_html__('avatar', 'matebook'));?>" title="<?php echo esc_attr($author->get_profileurl()); ?>" src="<?php echo esc_url($author->get_avatar('full'));?>">
			</a>
		</div>

		<div class="ps-author-inner">

			<div class="ps-author-links">

				<?php

				ob_start();
				do_action('peepso_action_render_user_name_before', $author->get_id());
				$before_fullname = ob_get_clean();

				ob_start();
				do_action('peepso_action_render_user_name_after', $author->get_id());
				$after_fullname = ob_get_clean();

				?>

				<?php echo wp_kses($before_fullname, 'default'); ?>
				<a href="<?php echo esc_url($author->get_profileurl()); ?>" data-hover-card="<?php echo esc_attr($author->get_id()) ?>">
					<?php echo wp_kses($author->get_fullname(), 'default'); ?>
				</a>
				<?php echo wp_kses($after_fullname, 'default'); ?>

			</div>

			<div class="ps-blogposts__authorbox-desc">
				<?php
				$PeepSoFieldAbout = PeepSoField::get_field_by_id('description', $author->get_id());
				$PeepSoFieldAbout->render();
				?>
			</div>

		</div>

	</div>

</div>

