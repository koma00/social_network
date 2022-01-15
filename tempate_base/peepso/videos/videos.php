<div class="peepso ps-page-profile">
	<?php PeepSoTemplate::exec_template( 'general', 'navbar' ); ?>

	<?php PeepSoTemplate::exec_template( 'profile', 'focus', array( 'current' => 'videos' ) ); ?>

	<?php if ( get_current_user_id() ) { ?>

		<div class="section-title-holder with-elem">

			<h5><?php echo esc_html__( 'Audio and Video', 'matebook' ) ?></h5>

			<div class="ps-page-filters">
				<select class="ps-select ps-full ps-js-videos-sortby ps-js-videos-sortby--<?php echo apply_filters( 'peepso_user_profile_id', 0 ); ?>">
					<option value="desc"><?php echo esc_html__( 'Newest first', 'matebook' ); ?></option>
					<option value="asc"><?php echo esc_html__( 'Oldest first', 'matebook' ); ?></option>
				</select>
			</div>

		</div>

		<div class="ps-video mb-20"></div>
		<div class="ps-video ps-js-videos ps-js-videos--<?php echo apply_filters( 'peepso_user_profile_id', 0 ); ?>"></div>
		<div class="ps-video ps-js-videos-triggerscroll ps-js-videos-triggerscroll--<?php echo apply_filters( 'peepso_user_profile_id', 0 ); ?>">
			<img class="post-ajax-loader ps-js-videos-loading"
				 src="<?php echo PeepSo::get_asset( 'images/ajax-loader.gif' ); ?>"
				 alt="<?php echo esc_attr__( 'Loading...', 'matebook' ) ?>" style="display:none"/>
		</div>
	<?php } else {
		PeepSoTemplate::exec_template( 'general', 'login-profile-tab' );
	} ?>
</div><!--end row-->
<?php PeepSoTemplate::exec_template( 'activity', 'dialogs' ); ?>
