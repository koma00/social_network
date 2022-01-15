<?php
$PeepSoUrlSegments = PeepSoUrlSegments::get_instance();
$user = get_user_by('slug', $PeepSoUrlSegments->get(1));
if (FALSE === $user) {
	$view_user_id = get_current_user_id();
} else {
	$view_user_id = $user->ID;
}

$PeepSoProfile = PeepSoProfile::get_instance();
$PeepSoUser = $PeepSoProfile->init($view_user_id);

$current = $PeepSoUrlSegments->get(2);
$is_profile_segment = isset($current) ? TRUE : FALSE;
$use_small_cover = $is_profile_segment && 0 == PeepSo::get_option('always_full_cover', 0);

$show_focus = "";
$focus_class = "";

if (class_exists('Gecko_Customizer')) {
	$settings = GeckoConfigSettings::get_instance();

	if (1 < $settings->get_option( 'opt_ps_profile_page_cover', 1 ) ) {
		$show_focus = 1;
	}

	if (1 == $settings->get_option( 'opt_ps_profile_page_cover_centered', 0 ) ) {
		$focus_class = "ps-focus--gecko ps-focus--centered";
	}
}

if (!$show_focus) {
	?>
	<div class="ps-focus <?php echo esc_attr($use_small_cover) ? 'ps-focus--small' : ''; ?> <?php echo esc_attr($focus_class); ?> ps-js-focus ps-js-focus--profile ps-js-focus--<?php echo esc_attr($PeepSoUser->get_id()) ?>">

		<div class="ps-focus__cover ps-js-cover">
			<div class="ps-focus__cover-image ps-js-cover-wrapper">
				<img class="ps-js-cover-image" src="<?php echo esc_url($PeepSoUser->get_cover()); ?>"
					 alt="<?php echo sprintf( '%s %s', $PeepSoUser->get_fullname(), esc_html__('cover photo', 'matebook')); ?>"
					 style="<?php echo esc_attr($PeepSoUser->get_cover_position()); ?>; opacity: 0; transition: opacity 0.5s" />
			</div>

			<div class="ps-focus__header">

				<div class="ps-focus_inner-header">

					<div class="ps-avatar ps-avatar--focus ps-js-avatar">
						<img class="ps-js-avatar-image" src="<?php echo esc_url($PeepSoUser->get_avatar('full')); ?>"
							 alt="<?php echo sprintf( '%s %s', $PeepSoUser->get_fullname(), esc_html__('avatar', 'matebook')); ?>" />
						<?php if ((1 != PeepSo::get_option('avatars_wordpress_only', 0)) && $PeepSoProfile->can_edit()) { ?>
							<a href="#" class="ps-focus__avatar-change ps-js-avatar-button">
								<i class="gcis gci-camera"></i>
							</a>
						<?php } ?>

						<?php if($PeepSoUser->get_online_status()) { ?>
							<div class="ps-online ps-online--focus ps-tip ps-tip--inline"
								 aria-label="<?php echo sprintf(__('%s is currently online','matebook'), $PeepSoUser->get_fullname()); ?>"><div class="ps-online__inner"></div></div>
						<?php } ?>
					</div>

					<div class="ps-focus__info">
						<div class="ps-focus__title">
							<?php
							if (!$is_profile_segment || 1 == PeepSo::get_option('always_full_cover', 0)) {
								echo '<div class="ps-focus__title-before">', do_action('peepso_profile_cover_full_before_name', $PeepSoUser->get_id()), '</div>';
							}
							?>
							<div class="ps-focus__name" data-hover-card="<?php echo esc_attr($PeepSoUser->get_id()) ?>">
								<?php
								//[peepso]_[action]_[WHICH_PLUGIN]_[WHERE]_[WHAT]_[BEFORE/AFTER]
								do_action('peepso_action_render_user_name_before', $PeepSoUser->get_id());

								echo esc_html($PeepSoUser->get_fullname());

								//[peepso]_[action]_[WHICH_PLUGIN]_[WHERE]_[WHAT]_[BEFORE/AFTER]
								do_action('peepso_action_render_user_name_after', $PeepSoUser->get_id());
								?>
							</div>
							<?php
							if (!$is_profile_segment || 1 == PeepSo::get_option('always_full_cover', 0)) {
								echo '<div class="ps-focus__title-after">', do_action('peepso_profile_cover_full_after_name', $PeepSoUser->get_id()), '</div>';
							}
							?>
						</div>
						<div class="ps-focus__details ps-js-focus-interactions">
							<?php $PeepSoProfile->interactions(); ?>
						</div>
						<div class="ps-focus__mobile-actions ps-js-focus-actions"><?php $PeepSoProfile->profile_actions(); ?></div>
						<div class="ps-focus__actions ps-js-profile-actions-extra"><?php $PeepSoProfile->profile_actions_extra(); ?></div>
					</div>

					<?php if ($PeepSoProfile->can_edit()) { ?>

						<div class="ps-focus__options ps-js-dropdown ps-js-cover-dropdown">

							<a href="#" class="ps-focus__options-toggle ps-js-dropdown-toggle">
								<i class="gcis gci-image"></i>
								<?php echo esc_html__('Edit Cover Image', 'matebook') ?>
							</a>

							<div class="ps-focus__options-menu ps-js-dropdown-menu">
								<a href="#" class="ps-js-cover-upload">
									<i class="gcis gci-paint-brush"></i>
									<?php echo esc_html__('Upload new', 'matebook'); ?>
								</a>
								<a href="#" class="ps-js-cover-reposition">
									<i class="gcis gci-arrows-alt"></i>
									<?php echo esc_html__('Reposition', 'matebook'); ?>
								</a>
								<a href="#" class="ps-js-cover-remove">
									<i class="gcis gci-trash"></i>
									<?php echo esc_html__('Delete', 'matebook'); ?>
								</a>
							</div>
						</div>

						<!-- Cover options dropdown -->
						<div class="ps-focus__cover-inner">
							<div class="ps-focus__cover-actions ps-js-focus-actions">
								<?php $PeepSoProfile->profile_actions(); ?>
							</div>
						</div>

						<!-- Reposition cover - buttons -->
						<div class="ps-focus__reposition ps-js-cover-reposition-actions" style="display:none">
							<div class="ps-focus__reposition-actions reposition-cover-actions">
								<a href="#" class="ps-theme-btn ps-focus__reposition-action ps-js-cover-reposition-cancel"><?php echo esc_html__('Cancel', 'matebook'); ?></a>
								<a href="#" class="ps-theme-btn ps-btn-primary ps-focus__reposition-action ps-js-cover-reposition-confirm"><i class="gcis gci-check"></i> <?php echo esc_html__('Save', 'matebook'); ?></a>
							</div>
						</div>

					<?php } else { ?>

						<div class="ps-focus__cover-inner">
							<div class="ps-focus__cover-actions ps-js-focus-actions">
								<?php $PeepSoProfile->profile_actions(); ?>
							</div>
						</div>

					<?php }?>

				</div>

			</div>

		</div>

		<div class="ps-focus__footer">

			<?php
			do_action('peepso_action_render_user_menu_before', $PeepSoUser->get_id());
			?>

			<?php

			if (!$is_profile_segment) {
				$current = 'stream';
			}

			?>
			<div class="ps-focus__menu ps-js-focus__menu">
				<div class="ps-focus__menu-inner ps-js-focus__menu-inner">
					<?php echo '' . $PeepSoProfile->profile_navigation(array('current'=>$current)); ?>
				</div>
				<div class="ps-focus__menu-shadow ps-focus__menu-shadow--left ps-js-aid-left"></div>
				<div class="ps-focus__menu-shadow ps-focus__menu-shadow--right ps-js-aid-right"></div>
			</div>
		</div>

	</div>
<?php } ?>