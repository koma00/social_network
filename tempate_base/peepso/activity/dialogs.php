<?php
$PeepSoActivity = PeepSoActivity::get_instance();
$PeepSoShare 	= PeepSoShare::get_instance();
?>
<div id="ps-dialogs" style="display:none">
	<div id="ajax-loader-gif" style="display:none;">
		<div class="ps-loading-image">
			<img alt="<?php esc_attr_e('Loading', 'matebook') ?>" src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>">
			<div> </div>
		</div>
	</div>
	<div id="ps-dialog-comment">
		<div data-type="stream-newcomment" class="cstream-form stream-form wallform " data-formblock="true" style="display: block;">
			<form class="reset-gap">
				<div class="cstream-form-submit">
					<a href="#" data-action="cancel" onclick="return activity.comment_cancel(); return false;" class="ps-theme-btn ps-theme-btn-small cstream-form-cancel"><?php echo esc_html__('Cancel', 'matebook'); ?></a>
					<button data-action="save" onclick="return activity.comment_save();" class="ps-theme-btn ps-theme-btn-small ps-btn-primary"><?php echo esc_html__('Post Comment', 'matebook'); ?></button>
				</div>
			</form>
		</div>
	</div>

	<div id="ps-report-dialog">
		<div id="activity-report-title"><?php echo esc_html__('Report Content to Admin', 'matebook'); ?></div>
		<div id="activity-report-content">
			<div id="postbox-report-popup">
				<div><?php echo esc_html__('Reason for Report:', 'matebook'); ?></div>
				<div class="ps-text--danger"><?php $PeepSoActivity->report_reasons(); ?></div>
				<div class="ps-alert" style="display:none"></div>
			</div>
		</div>
		<div id="activity-report-actions">
			<button type="button" name="rep_cacel" class="ps-theme-btn ps-theme-btn-small ps-button-cancel" onclick="pswindow.hide(); return false;"><?php echo esc_html__('Cancel', 'matebook'); ?></button>
			<button type="button" name="rep_submit" class="ps-theme-btn ps-theme-btn-small ps-button-action" onclick="activity.submit_report(); return false;"><?php echo esc_html__('Submit Report', 'matebook'); ?></button>
		</div>
	</div>

	<span id="report-error-select-reason"><?php echo esc_html__('ERROR: Please select Reason for Report.', 'matebook'); ?></span>
	<span id="report-error-empty-reason"><?php echo esc_html__('ERROR: Please fill Reason for Report.', 'matebook'); ?></span>

	<div id="ps-share-dialog">
		<div id="share-dialog-title"><?php echo esc_html__('Share This', 'matebook'); ?></div>
		<div id="share-dialog-content">
			<h5 class="reset-gap"><?php echo esc_html__('Share this via Link:', 'matebook'); ?></h5>
			<?php $PeepSoShare->show_links();?>
			<div class="ps-clearfix"></div>
		</div>
	</div>

	<div id="default-delete-dialog">
		<div id="default-delete-title"><?php echo esc_html__('Confirm Delete', 'matebook'); ?></div>
		<div id="default-delete-content">
			<?php echo esc_html__('Are you sure you want to delete this?', 'matebook'); ?>
		</div>
		<div id="default-delete-actions">
			<button type="button" class="ps-theme-btn ps-theme-btn-small ps-button-cancel" onclick="pswindow.hide(); return false;"><?php echo esc_html__('Cancel', 'matebook'); ?></button>
			<button type="button" class="ps-theme-btn ps-theme-btn-small ps-button-action" onclick="pswindow.do_delete();"><?php echo esc_html__('Delete', 'matebook'); ?></button>
		</div>
	</div>

	<div id="default-acknowledge-dialog">
		<div id="default-acknowledge-title"><?php echo esc_html__('Confirm', 'matebook'); ?></div>
		<div id="default-acknowledge-content">
			<div>{content}</div>
		</div>
		<div id="default-acknowledge-actions">
			<button type="button" class="ps-theme-btn ps-theme-btn-small ps-button-action" onclick="return pswindow.hide();"><?php echo esc_html__('Okay', 'matebook'); ?></button>
		</div>
	</div>

	<div id="ps-profile-delete-dialog">
		<div id="profile-delete-title"><?php echo esc_html__('Confirm Delete', 'matebook'); ?></div>
		<div id="profile-delete-content">
			<div>
				<h4 class="ps-page__body-title"><?php echo esc_html__('Are you sure you want to delete your Profile?', 'matebook'); ?></h4>

				<p><?php echo esc_html__('This will remove all of your posts, saved information and delete your account.', 'matebook'); ?></p>

				<p><em class="ps-text--danger"><?php echo esc_html__('The delete cannot be undone.', 'matebook'); ?></em></p>

				<button type="button" name="rep_cacel" class="ps-theme-btn ps-button-cancel" onclick="pswindow.hide(); return false;"><?php echo esc_html__('Cancel', 'matebook'); ?></button>
				&nbsp;
				<button type="button" name="rep_submit" class="ps-theme-btn ps-button-action" onclick="profile.delete_profile_action(); return false;"><?php echo esc_html__('Delete My Profile', 'matebook'); ?></button>
			</div>
		</div>
	</div>

	<?php PeepSoTemplate::exec_template('activity', 'dialog-repost'); ?>
	<?php PeepSoTemplate::exec_template('members', 'search-popover-input'); ?>

	<?php $PeepSoActivity->dialogs(); // give add-ons a chance to output some HTML ?>
</div>
