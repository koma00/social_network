<?php
$PeepSoActivity = PeepSoActivity::get_instance();
$PeepSoUser= PeepSoUser::get_instance($post_author);
$PeepSoPrivacy	= PeepSoPrivacy::get_instance();

$scheduled = ($post_status == 'future') ? TRUE : FALSE;


$comments_open = TRUE;
if (strlen(get_post_meta($ID, 'peepso_disable_comments', TRUE))) {
    $comments_open = FALSE;
}
?>

<div class="ps-post ps-js-activity <?php echo (TRUE == $pinned) ? 'ps-post--pinned ps-js-activity-pinned' : ''?> ps-js-activity--<?php echo esc_attr($act_id); ?>"
	data-id="<?php echo esc_attr($act_id); ?>" data-post-id="<?php echo esc_attr($ID); ?>" data-author="<?php echo esc_attr($post_author) ?>"
	data-module-id="<?php echo esc_attr($act_module_id) ?>" ps-data-pinned="<?php echo esc_html__('Pinned', 'matebook');?>">

	<?php if (TRUE == $pinned): ?>
		<div class="ps-post--pinned-hold">
			<div class="ps-post--pinned-tag" ps-data-pinned="<?php echo esc_html__('Pinned', 'matebook');?>"></div>
		</div>
	<?php endif; ?>

	<?php
	// if post is pinned and it's visibility is limited, display a warning
	if( PeepSo::is_admin() && TRUE == $pinned && !in_array($act_access, array(PeepSo::ACCESS_MEMBERS, PeepSo::ACCESS_PUBLIC)) ) {

		echo '<div class="ps-post__warning">', esc_html__('This pinned post will not display to all users because of its privacy settings.', 'matebook'),'</div>';
	}
	?>

  <div class="ps-post__header ps-js-post-header">
    <a class="ps-avatar ps-avatar--post" href="<?php echo esc_url($PeepSoUser->get_profileurl()); ?>">
      <img data-author="<?php echo esc_attr($post_author); ?>" src="<?php echo esc_url($PeepSoUser->get_avatar()); ?>" alt="<?php echo esc_attr($PeepSoUser->get_fullname()); ?> avatar" />
    </a>

    <div class="ps-post__meta">
      <div class="ps-post__title">
        <?php $PeepSoActivity->post_action_title(); ?>
				<span class="ps-post__subtitle ps-js-activity-extras"><?php
					$post_extras = apply_filters('peepso_post_extras', array());
					if(is_array($post_extras)) {
						echo implode(' ', $post_extras);
					}
				?></span>
      </div>
      <div class="ps-post__info">
				<?php
				$PeepSoActivity->post_edit_notice();
				?>
        <a class="ps-post__date ps-js-timestamp" href="<?php $PeepSoActivity->post_link(); ?>" data-timestamp="<?php $PeepSoActivity->post_timestamp(); ?>"><?php $PeepSoActivity->post_age(); ?></a>
				<?php if (($post_author == get_current_user_id() || PeepSo::is_admin()) && apply_filters('peepso_activity_has_privacy', TRUE)) { ?>
				<div class="ps-post__privacy ps-dropdown ps-dropdown--privacy ps-js-dropdown ps-js-privacy--<?php echo esc_attr($act_id); ?>" title="<?php echo esc_attr__('Post privacy', 'matebook');?>">
					<a href="#" data-value="" class="ps-post__privacy-toggle ps-dropdown__toggle ps-js-dropdown-toggle">
						<div class="ps-post__privacy-label dropdown-value">
							<?php $PeepSoActivity->post_access(); ?>
						</div>
					</a>
					<?php wp_nonce_field('change_post_privacy_' . $act_id, '_privacy_wpnonce_' . $act_id); ?>
					<?php echo ''. $PeepSoPrivacy->render_dropdown('activity.change_post_privacy(this, ' . $act_id . ')'); ?>
				</div>
				<?php } ?>
        <a class="ps-post__copy" href="<?php $PeepSoActivity->post_link(); ?>"><?php $PeepSoActivity->post_permalink(); ?></a>
      </div>
    </div>

    <div class="ps-post__options">
      <?php $PeepSoActivity->post_options(); ?>
    </div>
  </div>

  <div class="ps-post__body ps-js-post-body">
		<?php if(!strlen($human_friendly) || !strlen(PeepSo3_Mayfly::get('peepso_cache_hf_'.$ID))) { ?>
				<input type="hidden" name="peepso_set_human_friendly" value="<?php echo esc_attr($ID); ?>"/>
				<?php
				PeepSo3_Mayfly::set('peepso_cache_hf_' . $ID, 1, 600);
		}
		?>

		<div class="ps-post__content ps-js-activity-content ps-js-activity-content--<?php echo esc_attr($act_id); ?>"><?php $PeepSoActivity->content(); ?></div>
		<div class="ps-post__content ps-post__content--edit ps-js-activity-edit ps-js-activity-edit--<?php echo esc_attr($act_id); ?>" style="display:none"></div>
		<div class="ps-post__attachments ps-stream-attachments js-stream-attachments"><?php $PeepSoActivity->post_attachment(); ?></div>
  </div>

  <div class="ps-post__footer">
		<!-- post actions -->
	  <?php if(!$scheduled) {  ?>
			<?php $PeepSoActivity->post_actions(); ?>
	  <?php } ?>

		<?php if(!$scheduled) { do_action('peepso_post_before_comments'); } ?>

		<div class="ps-comments">
			<?php //do_action('peepso_post_before_comments'); ?>
			<div class="ps-comments__inner cstream-respond wall-cocs" id="wall-cmt-<?php echo esc_attr($act_id); ?>">
				<div class="ps-comments__list comment-container ps-js-comment-container ps-js-comment-container--<?php echo esc_attr($act_id); ?>"
					data-act-id="<?php echo esc_attr($act_id) ?>"
					data-post-id="<?php echo esc_attr($ID) ?>"
					data-comments-open="<?php echo intval($comments_open) ?>"><?php $PeepSoActivity->show_recent_comments(); ?></div>

				<?php $show_commentsbox = apply_filters('peepso_commentsbox_display', apply_filters('peepso_permissions_comment_create', TRUE), $ID); ?>

		        <?php if(!$comments_open) { $show_commentsbox = FALSE; } ?>

		        <?php if($scheduled) { $show_commentsbox = FALSE; } ?>

		        <?php if(is_user_logged_in() && !$comments_open) { ?>
		        <div class="ps-comments__closed">
		            <i class="fas fa-lock"></i> <?php echo esc_html__('Commments are closed', 'matebook');?>
		        </div>
		        <?php }  ?>

				<?php if (is_user_logged_in() && $show_commentsbox ) { ?>
				<div id="act-new-comment-<?php echo esc_attr($act_id); ?>" class="ps-comments__reply cstream-form stream-form wallform ps-js-comment-new ps-js-newcomment-<?php echo esc_attr($act_id); ?>"
						data-id="<?php echo esc_attr($act_id); ?>" data-type="stream-newcomment" data-formblock="true">
					<a class="ps-avatar cstream-avatar cstream-author" href="<?php echo PeepSouser::get_instance()->get_profileurl(); ?>">
						<img data-author="<?php echo esc_attr($post_author); ?>" src="<?php echo PeepSoUser::get_instance()->get_avatar(); ?>" alt="<?php esc_attr_e('Avatar', 'matebook') ?>" />
					</a>
					<div class="ps-comments__input-wrapper ps-textarea-wrapper cstream-form-input">
						<textarea
							data-act-id="<?php echo esc_attr($act_id);?>"
							class="ps-comments__input ps-textarea cstream-form-text"
							name="comment"
							oninput="return activity.on_commentbox_change(this);"
							placeholder="<?php echo esc_attr__('Write a comment...', 'matebook');?>"></textarea>
						<?php
						// call function to add button addons for comments
						$PeepSoActivity->show_commentsbox_addons();
						?>
					</div>
					<div class="ps-comments__reply-send cstream-form-submit" style="display:none;">
						<div class="ps-loading ps-comment-loading">
							<img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" alt="<?php esc_attr_e('Loading', 'matebook') ?>" />
							<div> </div>
						</div>
						<div class="ps-comments__reply-actions ps-comment-actions" style="display:none;">
							<button onclick="return activity.comment_cancel(<?php echo esc_attr($act_id); ?>);" class="ps-btn ps-button-cancel"><?php echo esc_html__('Clear', 'matebook'); ?></button>
							<button onclick="return activity.comment_save(<?php echo esc_attr($act_id); ?>, this);" class="ps-btn ps-btn--action ps-btn-primary ps-button-action" disabled><?php echo esc_html__('Post', 'matebook'); ?></button>
						</div>
					</div>
				</div>
				<?php } // is_user_loggged_in ?>
				<?php if (!is_user_logged_in()) { ?>
					<div class="ps-post__call-to-action">
						<i class="gcis gci-lock"></i>
						<span>
						<?php
							$disable_registration = intval(PeepSo::get_option('site_registration_disabled', 0));

							if (0 === $disable_registration) { ?>
								<?php echo sprintf( __('%sRegister%s or %sLogin%s to react or comment on this post.', 'matebook'),
										'<a href="' . PeepSo::get_page('register') . '">', '</a>',
									 	'<a href="javascript:" onClick="pswindow.show( peepsodata.login_dialog_title, peepsodata.login_dialog );">', '</a>');
										?>
							<?php } else { ?>
								<?php echo sprintf( __('%sLogin%s to react or comment on this post.', 'matebook'),
										 '<a href="javascript:" onClick="pswindow.show( peepsodata.login_dialog_title, peepsodata.login_dialog );">', '</a>');
										?>
							<?php } ?>
						</span>
					</div>
				<?php } // is_user_loggged_in ?>
			</div>
		</div>
  </div>
</div>
