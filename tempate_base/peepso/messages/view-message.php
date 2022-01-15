<?php
$PeepSoPostbox = PeepSoPostbox::get_instance();
$PeepSoMessages= PeepSoMessages::get_instance();
$PeepSoGeneral = PeepSoGeneral::get_instance();

// Conversation flags.
$muted = isset($muted) && $muted;
$read_notification = isset($read_notification) && $read_notification;
#$notif = isset($notif) && $notif;

add_filter('peepso_permissions_post_create', array('PeepSoMessagesPlugin', 'peepso_permission_message_create'), 99);
?>
<div class="peepso">
	<div class="ps-page ps-page--conversation">
		<?php PeepSoTemplate::exec_template('general', 'navbar'); ?>

		<div class="ps-conversation">
			<div class="ps-conversation__header">
				<div class="ps-conversation__header-inner">
					<div class="ps-conversation__back">
						<a class="ps-btn ps-btn--sm ps-btn--app" href="<?php echo PeepSo::get_page('messages') ?>">
							<i class="gcis gci-angle-left"></i><span><?php echo esc_html__('Back to Messages', 'matebook'); ?></span>
						</a>
					</div>

					<div class="ps-conversation__actions ps-btn__group">
						<?php if ($show_blockuser) { ?>
						<a href="javascript:" class="ps-btn ps-btn--sm ps-btn--app ps-btn--cp ps-tip ps-tip--inline ps-js-btn-blockuser" aria-label="<?php echo esc_html__('Block this user', 'matebook');?>" data-user-id="<?php echo esc_attr($show_blockuser_id); ?>">
							<i class="gcis gci-ban"></i>
						</a>
						<?php } ?>
						<a href="javascript:" id="add-recipients-toggle" class="ps-btn ps-btn--sm ps-btn--app ps-btn--cp ps-tip ps-tip--inline" aria-label="<?php echo esc_html__('Add People to the conversation', 'matebook');?>">
							<i class="gcis gci-user-plus"></i>
						</a>
						<?php if ($read_notification) { ?>
						<a href="javascript:" class="ps-btn ps-btn--sm ps-btn--app ps-btn--cp ps-tip ps-tip--inline ps-js-btn-toggle-checkmark <?php echo esc_attr($notif) ? '' : ' disabled' ?>" aria-label="<?php echo esc_attr($notif) ? esc_html__("Don't send read receipt", 'matebook') : esc_html__('Send read receipt', 'matebook'); ?>"
							onclick="return ps_messages.toggle_checkmark(<?php echo esc_attr($parent->ID);?>, <?php echo esc_attr($notif) ? 0 : 1 ?>);"
						>
							<i class="gcir gci-check-circle"></i>
						</a>
						<?php } ?>
						<a href="javascript:" class="ps-btn ps-btn--sm ps-btn--app ps-btn--cp ps-tip ps-tip--inline ps-js-btn-mute-conversation" aria-label="<?php echo esc_attr($muted) ? esc_html__('Unmute conversation', 'matebook') : esc_html__('Mute conversation', 'matebook'); ?>"
							onclick="return ps_messages.<?php echo esc_attr($muted) ? 'unmute' : 'mute'; ?>_conversation(<?php echo esc_attr($parent->ID);?>, <?php echo esc_attr($muted) ? 0 : 1; ?>);"
						>
							<i class="<?php echo esc_attr($muted) ? 'gcis gci-bell-slash' : 'gcir gci-bell'; ?>"></i>
						</a>
						<a class="ps-btn ps-btn--sm ps-btn--app ps-btn--cp ps-tip ps-tip--inline ps-tip--right" aria-label="<?php echo esc_html__('Leave this conversation', 'matebook');?>"
							href="<?php echo esc_url($PeepSoMessages->get_leave_conversation_url()); ?>"
							onclick="return ps_messages.leave_conversation('<?php echo esc_html__('Are you sure you want to leave this conversation?', 'matebook'); ?>', this)"
						>
							<i class="gcis gci-times"></i>
						</a>
					</div>
				</div>

				<div class="ps-conversation__add ps-js-recipients">
					<select name="recipients" id="recipients-search"
						data-placeholder="<?php echo esc_html__('Add People to the conversation', 'matebook');?>"
						data-loading="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>"
						multiple></select>
					<?php wp_nonce_field('add-participant', 'add-participant-nonce'); ?>
					<button class="ps-btn ps-btn--sm ps-btn--action" onclick="ps_messages.add_recipients(<?php echo esc_attr($parent->ID); ?>);">
						<?php echo esc_html__('Done', 'matebook'); ?>
						<img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" style="display:none;">
					</button>
				</div>

				<div class="ps-conversation__participants ps-js-participant-summary">
					<span><?php echo esc_html__('Conversation with', 'matebook'); ?>:</span> <span class="ps-conversation__status"><i class="gcir gci-clock"></i></span><?php $PeepSoMessages->display_participant_summary();?>
				</div>
			</div>

			<div class="ps-conversation__chat">
				<div class="ps-chat__messages">
					<div class="ps-chat__loading ps-js-loading">
						<img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>">
					</div>
					<div class="ps-chat__typing ps-js-currently-typing"></div>
				</div>
			</div>

			<div id="postbox-message" class="ps-postbox ps-conversation__postbox">
				<?php $PeepSoPostbox->before_postbox(); ?>
				<div class="ps-postbox__inner">
				  <div id="ps-postbox-status" class="ps-postbox__content ps-postbox-content">
				    <div class="ps-postbox__views ps-postbox-tabs"><?php $PeepSoPostbox->postbox_tabs('messages'); ?></div>
				    <?php PeepSoTemplate::exec_template('general', 'postbox-status'); ?>
				  </div>

				  <div class="ps-postbox__footer ps-js-postbox-footer ps-postbox-tab ps-postbox-tab-root" style="display: none;">
				    <div class="ps-postbox__menu ps-postbox__menu--tabs">
				      <?php $PeepSoGeneral->post_types(array('postbox_message' => TRUE)); ?>
				    </div>
				  </div>

				  <div class="ps-postbox__footer ps-conversation__postbox-footer ps-js-postbox-footer ps-postbox-tab selected interactions">
				    <div class="ps-postbox__menu ps-postbox__menu--interactions">
				      <?php $PeepSoPostbox->post_interactions(array('postbox_message' => TRUE)); ?>
				    </div>
				    <div class="ps-postbox__actions ps-postbox-action">
				      <div class="ps-checkbox ps-checkbox--enter">
				        <input type="checkbox" id="enter-to-send" class="ps-checkbox__input ps-js-checkbox-entertosend">
				        <label class="ps-checkbox__label" for="enter-to-send"><?php echo esc_html__('Press "Enter" to send', 'matebook'); ?></label>
				      </div>

				      <?php if(PeepSo::is_admin() && PeepSo::is_dev_mode('embeds')) { ?>
				      <button type="button" class="ps-btn ps-btn--sm ps-postbox__action ps-postbox__action--cancel ps-js-btn-preview"><?php echo esc_html__('Fetch URL', 'matebook'); ?></button>
				      <?php } ?>
				      <button type="button" class="ps-btn ps-btn--sm ps-postbox__action ps-tip ps-tip--arrow ps-postbox__action--cancel ps-button-cancel"
				        aria-label="<?php echo esc_html__('Cancel', 'matebook'); ?>"
				        style="display:none"><i class="gcis gci-times"></i></button>
				      <button type="button" class="ps-btn ps-btn--sm ps-btn--action ps-postbox__action ps-postbox__action--post ps-button-action postbox-submit"
				        style="display:none"><?php echo esc_html__('Post', 'matebook'); ?></button>
				    </div>
				    <div class="ps-loading ps-postbox-loading" style="display: none">
				      <img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>">
				      <div> </div>
				    </div>
				  </div>
				</div>
				<?php $PeepSoPostbox->after_postbox(); ?>
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function() {
		ps_messages.init_conversation_view(<?php echo esc_attr($parent->ID); ?>);
	});
</script>
<?php PeepSoTemplate::exec_template('activity', 'dialogs'); ?>
