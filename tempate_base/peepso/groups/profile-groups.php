<div class="peepso">
	<div class="ps-page ps-page--profile ps-page--profile-groups">
		<?php PeepSoTemplate::exec_template('general', 'navbar'); ?>

		<div id="ps-profile" class="ps-profile">
			<?php PeepSoTemplate::exec_template('profile', 'focus', array('current'=>'groups')); ?>

			<div class="ps-groups">

				<?php if(PeepSoGroupUser::can_create()) { ?>

					<div class="section-title-holder with-elem">

						<h5><?php echo esc_html__('Groups', 'matebook');?></h5>

						<div class="ps-groups__header">
							<div class="ps-groups__header-inner">
								<div class="ps-groups__list-view">
									<div class="ps-btn__group">
										<a href="#" class="ps-theme-btn--app ps-btn--cp ps-tip ps-tip--arrow ps-js-groups-viewmode" data-mode="grid" aria-label="<?php echo esc_html__('Grid', 'matebook');?>"><i class="gcis gci-th-large"></i></a>
										<a href="#" class="ps-theme-btn--app ps-btn--cp ps-tip ps-tip--arrow ps-js-groups-viewmode" data-mode="list" aria-label="<?php echo esc_html__('List', 'matebook');?>"><i class="gcis gci-th-list"></i></a>
									</div>
								</div>
								<div class="ps-groups__actions">
									<a class="ps-theme-btn ps-theme-btn-action border17" href="#" onclick="peepso.groups.dlgCreate(); return false;">
										<i class="material-icons">add_circle_outline</i>
										<?php echo esc_html__('Create Group', 'matebook'); ?>
									</a>
								</div>
							</div>
						</div>

					</div>


				<?php } ?>

				<?php if(get_current_user_id()) { ?>
					<?php $single_column = PeepSo::get_option( 'groups_single_column', 0 ); ?>
					<div class="ps-groups__list <?php echo esc_attr($single_column) ? 'ps-groups__list--single' : '' ?> ps-js-groups ps-js-groups--<?php echo apply_filters('peepso_user_profile_id', 0); ?>" data-mode="<?php echo esc_attr($single_column) ? 'list' : 'grid' ?>"></div>
					<div class="ps-groups__loading ps-js-groups-triggerscroll ps-js-groups-triggerscroll--<?php echo apply_filters('peepso_user_profile_id', 0); ?>">
						<img class="ps-loading post-ajax-loader ps-js-groups-loading" src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" alt="<?php echo esc_attr__( 'Loading', 'matebook' ) ?>" />
					</div>
					<?php
				} else {
					PeepSoTemplate::exec_template('general','login-profile-tab');
				}?>
			</div>
		</div>
	</div>
</div>
<?php PeepSoTemplate::exec_template('activity', 'dialogs'); ?>

