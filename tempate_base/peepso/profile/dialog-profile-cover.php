<?php
$PeepSoProfile=PeepSoProfile::get_instance();
$PeepSoUser = $PeepSoProfile->user;
?>
<div id="dialog-upload-cover">
	<div id="dialog-upload-cover-title" class="hidden"><?php echo esc_html__('Change Cover Photo', 'matebook'); ?></div>
	<div id="dialog-upload-cover-content">
		<div class="ps-loading-image" style="display: none;">
			<img alt="<?php echo esc_attr__('Loading...', 'matebook') ?>" src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>">
			<div> </div>
		</div>

		<div class="ps-alert ps-alert-danger errors error-container ps-js-error"></div>

		<ul class="ps-list <?php if ($PeepSoUser->has_cover()) { echo 'ps-list-half'; } ?> upload-cover">
			<li class="ps-list-item">
				<span class="ps-btn ps-full fileinput-button">
					<?php echo esc_html__('Upload Photo', 'matebook'); ?>
					<input class="fileupload" type="file" name="filedata" />
				</span>
			</li>

			<?php if ($PeepSoUser->has_cover()) { ?>
			<li class="ps-list-item">
				<a href="#" onclick="profile.remove_cover_photo(<?php echo sprintf('%d', $PeepSoUser->get_id()); ?>); return false;" class="ps-btn ps-btn-danger ps-full"><?php echo esc_html__('Remove Cover Photo', 'matebook'); ?></a>
			</li>
			<?php } ?>

		</ul>
		<?php wp_nonce_field('cover-photo', '_covernonce'); ?>
	</div>
</div>
<div style="display: none;">
	<div id="profile-cover-error-filetype"><?php echo esc_html__('The file type you uploaded is not allowed. Only JPEG/PNG allowed.', 'matebook'); ?></div>
	<div id="profile-cover-error-filesize"><?php printf(__('The file size you uploaded is too big. The maximum file size is %s.', 'matebook'), '<strong>' . PeepSoGeneral::get_instance()->upload_size() . '</strong>'); ?></div>
</div>
