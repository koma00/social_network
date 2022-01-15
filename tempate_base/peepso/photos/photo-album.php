<div class="peepso ps-page-profile">
	<?php PeepSoTemplate::exec_template( 'general', 'navbar' ); ?>

	<?php PeepSoTemplate::exec_template( 'profile', 'focus', array( 'current' => 'photos' ) ); ?>


	<div class="ps-theme-page__actions">
		<a class="ps-theme-btn ps-theme-btn-medium border21" href="<?php echo esc_url( $photos_url ); ?>"><i
					class="ps-icon-angle-left"></i> <?php echo esc_html__( 'Back to Photos', 'matebook' ); ?></a>
	</div>

	<div class="section-title-holder with-elem">

		<h5><?php echo sprintf( '%s %s', $the_album->pho_album_name, __( 'Album', 'matebook' ) ); ?></h5>

		<div class="ps-page-filters">
			<select class="ps-select ps-full ps-js-photos-sortby">
				<option value="desc"><?php echo esc_html__( 'Newest first', 'matebook' ); ?></option>
				<option value="asc"><?php echo esc_html__( 'Oldest first', 'matebook' ); ?></option>
			</select>
		</div>
	</div>

	<div class="ps-clearfix mb-20"></div>
	<div class="ps-photos ps-js-photos ps-js-photos--<?php echo apply_filters( 'peepso_user_profile_id', 0 ); ?>"></div>
	<div class="ps-scroll ps-js-photos-triggerscroll ps-js-photos-triggerscroll--<?php echo apply_filters( 'peepso_user_profile_id', 0 ); ?>">
		<img class="post-ajax-loader ps-js-photos-loading"
			 src="<?php echo PeepSo::get_asset( 'images/ajax-loader.gif' ); ?>"
			 alt="<?php echo esc_attr__( 'Loading...', 'matebook' ) ?>" style="display:none"/>
	</div>
	<div class="ps-clearfix mb-20"></div>
</div><!--end row-->
<?php PeepSoTemplate::exec_template( 'activity', 'dialogs' ); ?>
