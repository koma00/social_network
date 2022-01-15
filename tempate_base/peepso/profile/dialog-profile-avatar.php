<?php
$PeepSoProfile=PeepSoProfile::get_instance();
$PeepSoUser = $PeepSoProfile->user;
?>
<div id="dialog-upload-avatar">
	<div id="dialog-upload-avatar-title"><?php echo esc_html__('Change Avatar', 'matebook'); ?></div>
	<div id="dialog-upload-avatar-content">
		<div class="ps-loading-image" style="display: none;">
			<img alt="<?php echo esc_attr__('Loading...', 'matebook') ?>" src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>">
			<div> </div>
		</div>

		<div class="ps-alert ps-alert-danger errors error-container ps-js-error"></div>

		<div class="ps-page-split">
			<div class="ps-page-half upload-avatar">
				<a class="ps-btn ps-btn-small ps-full-mobile fileinput-button" href="#" onclick="return false;">
					<?php echo esc_html__('Upload Photo', 'matebook'); ?>
				</a>
				<input class="fileupload" type="file" name="filedata" />
				<a id="div-remove-avatar"
				style="<?php if ($PeepSoUser->has_avatar()) { ?>display:none;<?php } ?> overflow:hidden;"
				href="#" onclick="profile.remove_avatar(<?php echo sprintf('%d', $PeepSoUser->get_id()); ?>); return false;"
				class="ps-btn ps-btn-danger ps-btn-small ps-full-mobile">
					<?php echo esc_html__('Remove Photo', 'matebook'); ?>
				</a>
				<?php if (PeepSo::get_option('avatars_gravatar_enable') == 1) : ?>
					<a class="ps-btn ps-btn-small ps-full-mobile fileinput-button"
						href="#" onclick="profile.use_gravatar(<?php echo sprintf('%d', $PeepSoUser->get_id()); ?>); return false;">
						<?php echo esc_html__('Use Gravatar', 'matebook'); ?>
					</a>
				<?php endif; ?>
				<div class="ps-gap"></div>

				<div class="ps-js-has-avatar" <?php echo ''. $PeepSoUser->has_avatar() ? '' : 'style="display:none"' ?>>
					<h5 class="ps-page-title"><?php echo esc_html__('Uploaded Photo', 'matebook'); ?></h5>
					<div id="imagePreview" class="imagePreview" style="position:relative">
						<img src="<?php echo esc_url($PeepSoUser->get_avatar('orig')); ?>?<?php echo time();?>" alt="<?php echo esc_attr__('Automatically Generated. (Maximum width: 160px)', 'matebook'); ?>"
							class="ps-image-preview large-profile-pic ps-name-tips" />
					</div>
					<div class="ps-page-footer">
						<a href="#" onclick="profileavatar.updateThumbnail(); return false;" class="update-thumbnail ps-btn ps-btn-small ps-full-mobile ps-avatar-crop ps-js-crop-avatar"><?php echo esc_html__('Crop Image', 'matebook'); ?></a>
						<a href="#" onclick="profileavatar.saveThumbnail(); return false;" class="update-thumbnail-save ps-btn ps-btn-small ps-btn-primary ps-full-mobile" style="display: none;"><?php echo esc_html__('Save Thumbnail', 'matebook'); ?></a>
					</div>
				</div>

				<div class="ps-js-no-avatar" <?php echo '' . $PeepSoUser->has_avatar() ? 'style="display:none"' : '' ?>>
					<div class="ps-alert"><?php echo esc_html__('No avatar uploaded. Use the button above to select and upload one.', 'matebook'); ?></div>
				</div>

			</div>

			<div class="ps-page-half ps-text--center show-avatar show-thumbnail">
				<h5 class="ps-page-title"><?php echo esc_html__('Avatar Preview', 'matebook'); ?></h5>

				<div class="ps-avatar js-focus-avatar">
					<img alt="<?php esc_attr_e('Avatar', 'matebook') ?>" src="<?php echo esc_url($PeepSoUser->get_avatar()); ?>?<?php echo time();?>">
				</div>
				<div class="ps-gap"></div>
				<p class="reset-gap ps-text--muted"><?php echo esc_html__('This is how your Avatar will appear throughout the entire community.', 'matebook'); ?></p>
			</div>
		</div>
	</div>

	<div class="dialog-action">
		<button class="ps-btn ps-btn-small ps-btn-primary" type="button" name="rep_submit" onclick="profile.confirm_avatar(this); return false;"><?php echo esc_html__('Done', 'matebook'); ?></button>
	</div>
</div>
<div style="display:none">
	<div id="profile-avatar-error-filetype"><?php echo esc_html__('The file type you uploaded is not allowed. Only JPEG/PNG allowed.', 'matebook'); ?></div>
	<div id="profile-avatar-error-filesize"><?php printf(__('The file size you uploaded is too big. The maximum file size is %s.', 'matebook'), '<strong>' . PeepSoGeneral::get_instance()->upload_size() . '</strong>'); ?></div>
	<iframe id="ps-profile-avatar-iframe" src="<?php echo esc_url($PeepSoUser->get_avatar()); ?>"></iframe>
</div>
