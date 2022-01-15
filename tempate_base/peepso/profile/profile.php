<?php
$PeepSoProfile   = PeepSoProfile::get_instance();
$small_thumbnail = PeepSo::get_option( 'small_url_preview_thumbnail', 0 );
?>
<div class="peepso ps-page-profile">
	<?php PeepSoTemplate::exec_template( 'general', 'navbar' ); ?>
	<div id="cProfileWrapper" class="ps-clearfix">
		<?php PeepSoTemplate::exec_template( 'profile', 'focus' ); ?>

		<div id="editLayout-stop" class="page-action" style="display: none;">
			<a href="#"
			   onclick="profile.editLayout.stop(); return false;"><?php echo esc_html__( 'Finished Editing Apps Layout', 'matebook' ); ?></a>
		</div>

		<div class="ps-body">
			<?php
			// widgets top
			$widgets_profile_sidebar_top = apply_filters( 'peepso_widget_prerender', 'profile_sidebar_top' );

			// widgets bottom
			$widgets_profile_sidebar_bottom = apply_filters( 'peepso_widget_prerender', 'profile_sidebar_bottom' );
			?>

			<?php
			$sidebar = null;

			if ( count( $widgets_profile_sidebar_top ) > 0 || count( $widgets_profile_sidebar_bottom ) > 0 ) { ?>

				<?php
				ob_start();
				PeepSoTemplate::exec_template( 'sidebar', 'sidebar', array( 'profile_sidebar_top'    => $widgets_profile_sidebar_top,
				                                                            'profile_sidebar_bottom' => $widgets_profile_sidebar_bottom,
				) );
				$sidebar = ob_get_clean();

				echo sprintf( '%s', $sidebar );
				?>
			<?php } ?>

			<div class="ps-main <?php if ( strlen( $sidebar ) ) {
				echo '';
			} else {
				echo 'ps-main-full';
			} ?>">
				<!-- js_profile_feed_top -->
				<div class="activity-stream-front">
					<?php
					PeepSoTemplate::exec_template( 'general', 'postbox-legacy', array( 'is_current_user' => $PeepSoProfile->is_current_user() ) );
					?>

					<?php PeepSoTemplate::exec_template( 'activity', 'activity-stream-filters-simple', array() ); ?>

					<div class="tab-pane active" id="stream">
						<div id="ps-activitystream-recent"
							 class="ps-stream-container <?php echo ! empty( $small_thumbnail ) ? '' : 'ps-stream-container-narrow' ?>"
							 style="display:none"></div>
						<div id="ps-activitystream"
							 class="ps-stream-container <?php echo ! empty( $small_thumbnail ) ? '' : 'ps-stream-container-narrow' ?>"
							 style="display:none"></div>

						<div id="ps-activitystream-loading">
							<?php PeepSoTemplate::exec_template( 'activity', 'activity-placeholder' ); ?>
						</div>

						<div id="ps-no-posts" class="ps-alert"
							 style="display:none"><?php echo esc_html__( 'No posts found.', 'matebook' ); ?></div>
						<div id="ps-no-posts-match" class="ps-alert"
							 style="display:none"><?php echo esc_html__( 'No posts found.', 'matebook' ); ?></div>
						<div id="ps-no-more-posts" class="ps-alert"
							 style="display:none"><?php echo esc_html__( 'Nothing more to show.', 'matebook' ); ?></div>
					</div>
				</div><!-- end activity-stream-front -->

				<?php PeepSoTemplate::exec_template( 'activity', 'dialogs' ); ?>
				<div id="apps-sortable" class="connectedSortable"></div>
			</div><!-- cMain -->
		</div><!-- end row -->
	</div><!-- end cProfileWrapper --><!-- js_bottom -->
	<div id="ps-dialogs" style="display:none">
		<?php do_action( 'peepso_profile_dialogs' ); // give add-ons a chance to output some HTML ?>
	</div>
</div><!--end row-->
