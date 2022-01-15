<div class="peepso">
	<div class="ps-page ps-page--members">
		<?php PeepSoTemplate::exec_template('general', 'navbar'); ?>
		<?php PeepSoTemplate::exec_template('general', 'register-panel'); ?>

		<?php if(get_current_user_id() > 0 || (get_current_user_id() == 0 && $allow_guest_access)) { ?>
			<?php PeepSoTemplate::exec_template('general','wsi'); ?>
			<?php

				$PeepSoUser = PeepSoUser::get_instance(0);
				$profile_fields = new PeepSoProfileFields($PeepSoUser);

				$args = array(
					'post_name__in'=>array('gender')
				);

				$fields = $profile_fields->load_fields($args);
				if (isset($fields) && isset($fields[PeepSoField::USER_META_FIELD_KEY . 'gender'])) {
					$fieldGender = $fields[PeepSoField::USER_META_FIELD_KEY . 'gender'];
				}
            $input = new PeepSoInput();
            $search = $input->value('filter', NULL, FALSE); // SQL Safe

			?>
			<?php PeepSoTemplate::exec_template('members','members-tabs');?>

			<div class="ps-members__header">
				<div class="ps-members__search">
					<input class="ps-input ps-js-members-query" placeholder="<?php echo esc_html__('Start typing to search...', 'matebook'); ?>" value="<?php echo esc_attr($search); ?>" />
				</div>
				<a href="#" class="ps-members__filters-toggle ps-js-members-filters-toggle"><i class="gcis gci-cog"></i></a>
			</div>
			<div class="ps-members__filters ps-js-members-filters">
				<div class="ps-members__filters-inner">
					<?php if (isset($fieldGender) && ($fieldGender->published == 1)){ ?>
						<div class="ps-members__filter">
							<div class="ps-members__filter-label"><?php echo sprintf('%s', $fieldGender->title); ?></div>
							<select class="ps-input ps-input--sm ps-input--select ps-js-members-gender">
								<option value=""><?php echo esc_html__('Any', 'matebook'); ?></option>
								<?php

								if (!empty($genders) && is_array($genders)) {
									foreach ($genders as $key => $value) {
										echo '<option value="' . $key . '">' . $value . '</option>';
									}
								}

								?>
							</select>
						</div>
					<?php } ?>

					<?php $default_sorting = PeepSo::get_option('site_memberspage_default_sorting',''); ?>
					<div class="ps-members__filter">
						<div class="ps-members__filter-label"><?php echo esc_html__('Sort', 'matebook'); ?></div>
						<select class="ps-input ps-input--sm ps-input--select ps-js-members-sortby">
							<option value=""><?php echo esc_html__('Alphabetical', 'matebook'); ?></option>
							<option <?php echo ('peepso_last_activity' == $default_sorting) ? ' selected="selected" ' : '';?> value="peepso_last_activity|asc"><?php echo esc_html__('Recently online', 'matebook'); ?></option>
							<option <?php echo ('registered' == $default_sorting) ? ' selected="selected" ' : '';?>value="registered|desc"><?php echo esc_html__('Latest members', 'matebook'); ?></option>
							<?php if (PeepSo::get_option('site_likes_profile', TRUE)) : ?>
								<option <?php echo ('most_liked' == $default_sorting) ? ' selected="selected" ' : '';?>value="most_liked|desc"><?php echo esc_html__('Most liked', 'matebook'); ?></option>
							<?php endif; ?>
						</select>
					</div>

					<?php if(class_exists('PeepSoFriendsPlugin')) { ?>
						<div class="ps-members__filter">
							<div class="ps-members__filter-label"><?php echo esc_html__('Following', 'matebook');?></div>
							<select class="ps-input ps-input--sm ps-input--select ps-js-members-following">
								<option value="-1"><?php echo esc_html__('All members', 'matebook'); ?></option>
								<option value="1"><?php echo esc_html__('Members I follow', 'matebook'); ?></option>
								<option value="0"><?php echo esc_html__('Members I don\'t follow', 'matebook'); ?></option>
							</select>
						</div>
					<?php } else { ?>
						<input type="hidden" class="ps-js-members-following" value="1" />
					<?php } ?>

					<div class="ps-members__filter">
						<div class="ps-members__filter-label"><?php echo esc_html__('Avatars', 'matebook'); ?></div>
						<div class="ps-checkbox">
							<input type="checkbox" id="only-avatars" class="ps-checkbox__input ps-js-members-avatar" value="1">
							<label class="ps-checkbox__label" for="only-avatars"><?php echo esc_html__('Only users with avatars', 'matebook'); ?></label>
						</div>
					</div>

					<?php do_action('peepso_action_render_member_search_fields'); ?>
				</div>
			</div>

			<div class="ps-members ps-js-members"></div>
			<?php if (PeepSo::get_option('members_hide_before_search', 0)) { ?>
			<div class="ps-alert ps-js-members-noquery"><?php echo esc_html__('Type in the above search box to search for members.', 'matebook'); ?></div>
			<?php } ?>
			<div class="ps-members__loading ps-js-members-triggerscroll">
				<img class="ps-loading post-ajax-loader ps-js-members-loading" src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" alt="<?php echo esc_attr__('Loading', 'matebook'); ?>" />
			</div>
		<?php } ?>
	</div>
</div>
<?php

PeepSoTemplate::exec_template('activity', 'dialogs');

wp_enqueue_style('peepso-datepicker');
