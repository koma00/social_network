<div class="peepso ps-page-wpadverts">
	<?php
	PeepSoTemplate::exec_template( 'general', 'navbar' );
	if ( PeepSo::get_option( 'wpadverts_allow_guest_access_to_classifieds', 0 ) === 0 ) {
		PeepSoTemplate::exec_template( 'general', 'register-panel' );
	}
	if ( get_current_user_id() || PeepSo::get_option( 'wpadverts_allow_guest_access_to_classifieds', 0 ) === 1 ) { ?>

		<div class="ps-tabs__wrapper">
			<div class="ps-tabs ps-tabs--arrows">
				<div class="ps-tabs__item"><a
							href="<?php echo PeepSo::get_page( 'wpadverts' ); ?>"><?php echo esc_html__( 'Classifieds', 'matebook' ); ?></a>
				</div>
				<div class="ps-tabs__item current"><a
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

		<?php echo wp_kses( $ads_category, 'default' ); ?>
	<?php } ?>
</div><!--end row-->

<?php

if ( get_current_user_id() ) {
	PeepSoTemplate::exec_template( 'activity', 'dialogs' );
}
