<div class="peepso ps-page-profile ps-page--group">
	<?php PeepSoTemplate::exec_template( 'general', 'navbar' ); ?>
	<?php //PeepSoTemplate::exec_template('general', 'register-panel'); ?>

	<?php $PeepSoGroupUser = new PeepSoGroupUser( $group->id, get_current_user_id() ); ?>
	<?php if ( $PeepSoGroupUser->can( 'access' ) ) { ?>

		<?php PeepSoTemplate::exec_template( 'groups', 'group-header', array( 'group'         => $group,
		                                                                      'group_segment' => $group_segment
		) ); ?>

		<?php if ( ! get_current_user_id() ) {
			PeepSoTemplate::exec_template( 'general', 'login-profile-tab' );
		} ?>

		<div class="section-title-holder with-elem">

			<h5><?php echo esc_html__( 'Audio and Video', 'matebook' ) ?></h5>

			<div class="ps-page-filters">
				<select class="ps-select ps-full ps-js-videos-sortby">
					<option value="desc"><?php echo esc_html__( 'Newest first', 'matebook' ); ?></option>
					<option value="asc"><?php echo esc_html__( 'Oldest first', 'matebook' ); ?></option>
				</select>
			</div>

		</div>

		<div class="ps-video mb-20"></div>
		<div class="ps-video ps-js-videos"></div> &nbsp;
		<div class="ps-video ps-js-videos-triggerscroll">
			<img class="post-ajax-loader ps-js-videos-loading"
				 src="<?php echo PeepSo::get_asset( 'images/ajax-loader.gif' ); ?>"
				 alt="<?php echo esc_attr__( 'Loading', 'matebook' ) ?>" style="display:none"/>
		</div>

	<?php } ?>

</div><!--end row-->
<?php PeepSoTemplate::exec_template( 'activity', 'dialogs' ); ?>
