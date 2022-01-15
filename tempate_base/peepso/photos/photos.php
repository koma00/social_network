<div class="peepso ps-page-profile">
	<?php PeepSoTemplate::exec_template( 'general', 'navbar' ); ?>

	<?php PeepSoTemplate::exec_template( 'profile', 'focus', array( 'current' => 'photos' ) ); ?>

	<?php if ( get_current_user_id() ) { ?>

		<div class="ps-tabs__wrapper">
			<div class="ps-tabs ps-tabs--arrows">
				<div class="ps-tabs__item <?php if ( 'latest' === $current )
					echo 'current' ?>"><a
							href="<?php echo PeepSoSharePhotos::get_url( $view_user_id, 'latest' ); ?>"><?php echo esc_html__( 'Photos', 'matebook' ); ?></a>
				</div>
				<div class="ps-tabs__item <?php if ( 'album' === $current )
					echo 'current' ?>"><a
							href="<?php echo PeepSoSharePhotos::get_url( $view_user_id, 'album' ); ?>"><?php echo esc_html__( 'Albums', 'matebook' ); ?></a>
				</div>
			</div>
			<?php
			if ( get_current_user_id() == $view_user_id && apply_filters( 'peepso_permissions_photos_upload', true ) ) {
				?>
					<div class="ps-page__actions">
						<a class="ps-theme-btn ps-theme-btn-action border17" href="#"
						   onclick="peepso.photos.show_dialog_album(<?php echo get_current_user_id(); ?>, this); return false;"><i
									class="material-icons">add_circle_outline</i><?php echo esc_html__( 'Create Album', 'matebook' ); ?>
						</a>
					</div>
				<?php
			}
			?>
		</div>

		<div class="ps-clearfix mb-20"></div>

		<div class="ps-page-filters ser" style="display:none;">
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
				 alt="<?php echo esc_attr__( 'Loading...', 'matebook' ) ?>" style="display:none"/>
		</div>
		<div class="ps-clearfix mb-20"></div>
	<?php } else {
		PeepSoTemplate::exec_template( 'general', 'login-profile-tab' );
	} ?>
</div><!--end row-->

<?php PeepSoTemplate::exec_template( 'activity', 'dialogs' ); ?>
