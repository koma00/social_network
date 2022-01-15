<?php
$PeepSoActivity = PeepSoActivity::get_instance();

$user = PeepSoUser::get_instance(PeepSoProfileShortcode::get_instance()->get_view_user_id());

$can_edit = FALSE;
if($user->get_id() == get_current_user_id() || current_user_can('edit_users')) {
	$can_edit = TRUE;
}


$args = array('post_status'=>'publish');


$user->profile_fields->load_fields($args);
$fields = $user->profile_fields->get_fields();
?>

<div class="ps-page ps-page--profile ps-page--profile-about">
	<?php PeepSoTemplate::exec_template('general', 'navbar'); ?>

	<div class="ps-profile ps-profile--edit ps-profile--about">
		<?php PeepSoTemplate::exec_template('profile', 'focus', array('current'=>'about')); ?>

		<div class="ps-profile__edit">
			<?php if($can_edit) { PeepSoTemplate::exec_template('profile', 'profile-about-tabs', array('tabs'=>$tabs, 'current_tab'=> 'about'));} ?>

			<?php
			$stats = $user->profile_fields->profile_fields_stats;

			if( $can_edit ) {

				echo '<div class="ps-progress ps-completeness-info"';

				if( $stats['completeness'] >= 100 && $stats['missing_required'] <= 0) {
					echo ' style="display:none" ';
				}

				echo '>';

				echo '<div class="ps-progress-status ps-completeness-status ';

				if(1 === PeepSo::get_option('force_required_profile_fields',0) && $stats['filled_required'] < $stats['fields_required']) {
					echo 'ps-text--danger';
				}

				echo '"';

				if( $stats['completeness'] >= 100) {
					echo ' style="display:none" ';
				}

				echo '>' . $stats['completeness_message'];

				if(isset($stats['completeness_message_detail'])) {
					echo esc_html($stats['completeness_message_detail']);
				}

				do_action('peepso_action_render_profile_completeness_message_after', $stats);

				echo '</div>';

				echo '<div class="ps-progress-bar ps-completeness-bar" ';

				if( $stats['completeness'] >= 100) {
					echo ' style="display:none" ';
				}

				echo '><span style="width:' . $stats['completeness'] . '%;"></span>';

				echo "</div>";

				echo '<div class="ps-progress-message ps-missing-required-message" ';

				if( $stats['missing_required'] <= 0) {
					echo ' style="display:none" ';
				}

				echo '>';

				echo '<i class="ps-icon-warning-sign"></i> ' . $stats['missing_required_message'];

				echo '</div>';
				echo "</div>";
			} ?>

			<div data-ps-section="profile/about">
				<div class="ps-list--column ps-list--column-edit">
					<div class="ps-list__item">
						<button class="ps-theme-btn border17 ps-js-btn-edit-all">
							<i class="material-icons">edit</i><?php echo esc_html__('Edit All', 'matebook'); ?>
						</button>
						<button class="ps-theme-btn border17 ps-theme-btn-primary ps-js-btn-save-all" style="display:none">
							<i class="material-icons">save</i><?php echo esc_html__('Save All', 'matebook'); ?></button>
					</div>
				</div>
				<div class="ps-list--column cfield-list creset-list ps-js-profile-list">
					<?php

					if( count($fields) ) {
						foreach ($fields as $key => $field) {

							$field_can_edit = ($can_edit && !isset($field::$user_disable_edit));

							?>
							<div class="ps-list__item <?php if (TRUE == $field_can_edit) : ?> ps-list-info-mine <?php endif; ?> ps-js-profile-item">
								<?php
								if(!isset($field::$user_hide_title)) :
									?>
									<h4 class="ps-list-info-name creset-h" id="field-title-<?php echo esc_attr($field->id); ?>"><?php echo sprintf(__('%s', 'matebook'), $field->title);

										if(TRUE == $field_can_edit &&  1 == $field->prop('meta','validation','required' )) {
											echo " <strong>*</strong>";
										}
										?>
									</h4>
								<?php endif;?>

								<div class="ps-list-info-content">

									<div class="ps-list-info-content-text">

										<div class="ps-list-info-content-form-inner">

											<div class="ps-list-info-content-data"><?php $field->render(); ?></div>

											<?php if (TRUE == $field_can_edit) : ?>
												<div class="ps-list-info-action">
													<?php $field->render_access(); ?>
													<button class="ps-theme-btn ps-theme-btn-small ps-js-btn-edit"
															aria-label="<?php echo sprintf(__('Edit %s', 'matebook'), $field->title) ?>">
														<i class="material-icons">edit</i><?php echo esc_html__('Edit', 'matebook'); ?>
													</button>
												</div>
											<?php endif; ?>

										</div>

									</div>

									<?php if (TRUE == $field_can_edit) : ?>
										<div class="ps-list-info-content-form" style="display:none">

											<div class="ps-list-info-content-form-inner">

												<?php do_action('peepso_action_render_profile_field_edit_before', $field); ?>
												<div class="ps-list-render-inner">
													<?php $field->render_input(); ?>
												</div>

												<div class="ps-list-info-action">
													<button id="btn-save-<?php echo esc_attr($field->id); ?>" class="ps-theme-btn ps-theme-btn-big ps-theme-btn-primary border21 ps-js-btn-save"
															role="button" aria-labelledby="btn-save-<?php echo esc_attr($field->id); ?> field-title-<?php echo esc_attr($field->id); ?>">
														<i class="material-icons">save</i><?php echo esc_html__('Save', 'matebook'); ?>
														<img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" alt="<?php echo esc_attr__('Loading...', 'matebook') ?>" style="display:none" />
													</button>
													<button id="btn-cancel-<?php echo esc_attr($field->id); ?>" class="ps-theme-btn ps-theme-btn-big border21 ps-js-btn-cancel"
															role="button" aria-labelledby="btn-cancel-<?php echo esc_attr($field->id); ?> field-title-<?php echo esc_attr($field->id); ?>">
														<i class="material-icons">cancel</i><?php echo esc_html__('Cancel', 'matebook'); ?>
													</button>
												</div>

											</div>

											<div role="alert" class="ps-alert ps-alert--sm ps-alert-danger ps-list-info-content-error"></div>

											<?php

											if ($field->prop('meta','privacywarning')) {
												PeepSoTemplate::exec_template('general', 'safety-warning', array(
													'message' => $field->prop('meta','privacywarningtext'),
													'id' => $field->prop('id')
												));
											}
											?>

											<?php $field->render_validation(); ?>

										</div>
									<?php endif; ?>
								</div>
							</div>
							<?php
						}
					} else {
						echo sprintf('<div class="ps-alert">%s</div>', esc_html__('Sorry, no data to show', 'matebook'));
					}
					?>
				</div>
				<div class="ps-list--column ps-list--column-edit">
					<div class="ps-list__item">
						<button class="ps-theme-btn border17 ps-js-btn-edit-all">
							<i class="material-icons">edit</i><?php echo esc_html__('Edit All', 'matebook'); ?></button>
						<button class="ps-theme-btn border17 ps-theme-btn-primary ps-js-btn-save-all" style="display:none">
							<i class="material-icons">save</i><?php echo esc_html__('Save All', 'matebook'); ?></button>
					</div>
				</div>
			</div>

		</div>

	</div>

</div>

<div id="ps-dialogs" style="display:none">
	<?php $PeepSoActivity->dialogs(); // give add-ons a chance to output some HTML ?>
	<?php PeepSoTemplate::exec_template('activity', 'dialogs'); ?>
</div>
