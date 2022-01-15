<div class="peepso ps-page-profile">
	<?php PeepSoTemplate::exec_template( 'general', 'navbar' ); ?>

	<?php PeepSoTemplate::exec_template( 'profile', 'focus', array( 'current' => 'blogposts' ) ); ?>

	<div class="section-title-holder with-elem">

		<h5><?php echo esc_html__( 'Blog', 'matebook' ); ?></h5>

		<?php
		$submissions = false;

		if ( class_exists( 'CMUserSubmittedPosts' ) && PeepSo::get_option( 'blogposts_submissions_enable' ) ) {
			$submissions = true;
		}
		if ( PeepSo::usp_enabled() && PeepSo::get_option( 'blogposts_submissions_enable_usp' ) ) {
			$submissions = true;
		}

		if ( $submissions ) {
			PeepSoTemplate::exec_template( 'blogposts', 'blogposts_tabs', array( 'create_tab' => false ) );
		}
		?>

		<div class="ps-page-filters">
			<select class="ps-select ps-full ps-js-blogposts-sortby ps-js-blogposts-sortby--<?php echo apply_filters( 'peepso_user_profile_id', 0 ); ?>">
				<option value="desc"><?php echo esc_html__( 'Newest first', 'matebook' ); ?></option>
				<option value="asc"><?php echo esc_html__( 'Oldest first', 'matebook' ); ?></option>
			</select>
		</div>

	</div>

	<div class="ps-clearfix mb-20"></div>

	<div class="ps-blogposts <?php echo PeepSo::get_option( 'blogposts_profile_two_column_enable', 0 ) ? 'ps-blogposts--half' : '' ?>
					ps-js-blogposts ps-js-blogposts--<?php echo apply_filters( 'peepso_user_profile_id', 0 ); ?>"
	></div>
	<div class="ps-scroll ps-clearfix ps-js-blogposts-triggerscroll">
		<img class="post-ajax-loader ps-js-blogposts-loading"
			 src="<?php echo PeepSo::get_asset( 'images/ajax-loader.gif' ); ?>"
			 alt="<?php echo esc_attr__( 'Loading...', 'matebook' ) ?>" style="display:none"/>
	</div>

</div><!--end row-->

<?php PeepSoTemplate::exec_template( 'activity', 'dialogs' ); ?>
