<div class="peepso ps-page-profile">
	<?php PeepSoTemplate::exec_template( 'general', 'navbar' ); ?>

	<?php PeepSoTemplate::exec_template( 'profile', 'focus', array( 'current' => 'wpadverts' ) ); ?>

	<?php if ( get_current_user_id() ) { ?>
		<div class="ps-tabs__wrapper">
			<div class="ps-tabs ps-tabs--arrows">
				<div class="ps-tabs__item current"><a
							href="<?php echo PeepSo::get_page( 'wpadverts' ); ?>"><?php echo esc_html__( 'Classifieds', 'matebook' ); ?></a>
				</div>
				<div class="ps-tabs__item"><a
							href="<?php echo PeepSo::get_page( 'wpadverts' ) . '?category/'; ?>"><?php echo esc_html__( 'Classifieds Categories', 'matebook' ); ?></a>
				</div>
			</div>
			<div class="ps-page-actions">
				<a class="ps-theme-btn"
				   href="<?php echo PeepSo::get_page( 'wpadverts' ) . ( PeepSo::get_option( 'disable_questionmark_urls', 0 ) === 0 ? '?' : '' ) . 'create/'; ?>">
					<i class="material-icons">add_circle_outline</i><?php echo esc_html__( 'Create', 'matebook' ); ?>
				</a>
			</div>
		</div>

		<?php
		// Get columns number from WPAdverts config

		$columns = "";

		if ( class_exists( 'Adverts' ) ) {
			if ( PeepSo::get_option( 'wpadverts_display_ads_as' ) == "2" ) { // if Grid view selected
				$columns = 'ps-classifieds__grid ps-classifieds__grid--' . adverts_config( 'config.ads_list_default__columns' );
			}
		}
		?>

		<div class="ps-clearfix mb-20"></div>
		<div class="ps-clearfix ps-classifieds <?php echo esc_attr( $columns ); ?> ps-js-classifieds ps-js-classifieds--<?php echo apply_filters( 'peepso_user_profile_id', 0 ); ?>"></div>
		<div class="ps-scroll ps-classifieds-scroll ps-js-classifieds-triggerscroll ps-js-classifieds-triggerscroll--<?php echo apply_filters( 'peepso_user_profile_id', 0 ); ?>">
			<img class="post-ajax-loader ps-js-classifieds-loading"
				 src="<?php echo PeepSo::get_asset( 'images/ajax-loader.gif' ); ?>"
				 alt="<?php echo esc_attr__( 'Loading...', 'matebook' ) ?>" style="display:none"/>
		</div>
	<?php } else {
		PeepSoTemplate::exec_template( 'general', 'login-profile-tab' );
	} ?>
</div><!--end row-->
<?php PeepSoTemplate::exec_template( 'activity', 'dialogs' ); ?>
