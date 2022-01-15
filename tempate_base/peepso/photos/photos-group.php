<div class="peepso ps-page-profile ps-page--group">
	<?php PeepSoTemplate::exec_template( 'general', 'navbar' ); ?>
	<?php //PeepSoTemplate::exec_template('general', 'register-panel'); ?>

	<?php $PeepSoGroupUser = new PeepSoGroupUser( $group->id, get_current_user_id() ); ?>
	<?php if ( $PeepSoGroupUser->can( 'access' ) ) { ?>

		<?php PeepSoTemplate::exec_template( 'groups', 'group-header', array( 'group'         => $group,
		                                                                      'group_segment' => $group_segment
		) ); ?>

		<div class="ps-photos-group">

			<?php if ( ! get_current_user_id() ) {
				PeepSoTemplate::exec_template( 'general', 'login-profile-tab' );
			} ?>

			<div class="ps-tabs__wrapper">
				<div class="ps-tabs ps-tabs--arrows">
					<div class="ps-tabs__item <?php if ( 'latest' === $current )
						echo 'current' ?>"><a
								href="<?php echo PeepSoSharePhotos::get_group_url( $view_group_id, 'latest' ); ?>"><?php echo esc_html__( 'Photos', 'matebook' ); ?></a>
					</div>
					<div class="ps-tabs__item <?php if ( 'album' === $current )
						echo 'current' ?>"><a
								href="<?php echo PeepSoSharePhotos::get_group_url( $view_group_id, 'album' ); ?>"><?php echo esc_html__( 'Albums', 'matebook' ); ?></a>
					</div>
				</div>
				<?php if ( $PeepSoGroupUser->can( 'post' ) ): ?>
					<div class="ps-page__actions">
						<a class="ps-theme-btn ps-theme-btn-action border17" href="#"
						   onclick="peepso.photos.show_dialog_album(<?php echo get_current_user_id(); ?>, this); return false;"><i
									class="ps-icon-plus"></i><?php echo esc_html__( 'Create Album', 'matebook' ); ?></a>
					</div>
				<?php endif; ?>
			</div>

			<div class="ps-clearfix mb-20"></div>

			<div class="ps-page-filters se" style="display:none;">
				<select class="ps-select ps-full ps-js-<?php echo esc_attr( $type ) ?>-sortby ps-js-<?php echo esc_attr( $type ) ?>-sortby--<?php echo apply_filters( 'peepso_user_profile_id', 0 ); ?>">
					<option value="desc"><?php echo esc_html__( 'Newest first', 'matebook' ); ?></option>
					<option value="asc"><?php echo esc_html__( 'Oldest first', 'matebook' ); ?></option>
				</select>
			</div>

			<div class="ps-clearfix mb-20"></div>
			<div class="ps-<?php echo esc_attr( $type ) ?> ps-js-<?php echo esc_attr( $type ) ?> ps-js-<?php echo esc_attr( $type ) ?>--<?php echo apply_filters( 'peepso_user_profile_id', 0 ); ?>"></div>
			<div class="ps-scroll ps-js-<?php echo esc_attr( $type ) ?>-triggerscroll ps-js-<?php echo esc_attr( $type ) ?>-triggerscroll--<?php echo apply_filters( 'peepso_user_profile_id', 0 ); ?>">
				<img class="post-ajax-loader ps-js-<?php echo esc_attr( $type ) ?>-loading"
					 src="<?php echo PeepSo::get_asset( 'images/ajax-loader.gif' ); ?>"
					 alt="<?php echo esc_attr( $type ) ?>" style="display:none"/>
			</div>
			<div class="ps-clearfix mb-20"></div>


		</div>

	<?php } ?>
</div><!--end row-->

<?php PeepSoTemplate::exec_template( 'activity', 'dialogs' ); ?>
