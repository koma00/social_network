<div class="peepso ps-page-wpadverts">
	<?php
	PeepSoTemplate::exec_template( 'general', 'navbar' );
	if ( PeepSo::get_option( 'wpadverts_allow_guest_access_to_classifieds', 0 ) === 0 ) {
		PeepSoTemplate::exec_template( 'general', 'register-panel' );
	}
	if ( get_current_user_id() || PeepSo::get_option( 'wpadverts_allow_guest_access_to_classifieds', 0 ) === 1 ) { ?>
		<form class="ps-form ps-form-search" name="form-peepso-search" onsubmit="return false;">

			<div class="ps-wpadverts__header">

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

				<div class="ps-wpadverts__header-inner">
					<div class="ps-wpadverts__search">
						<input placeholder="<?php echo esc_html__( 'Start typing to search...', 'matebook' ); ?>"
							   type="text" class="ps-input ps-js-classifieds-query" name="query"
							   value="<?php echo esc_attr( $search ); ?>"/>
					</div>
					<a href="#" class="ps-wpadverts__filters-toggle ps-tooltip ps-form-search-opt"
					   onclick="return false;" data-tooltip="<?php echo esc_html__( 'Show filters', 'matebook' ); ?>">
						<i class="gcis gci-cog"></i>
					</a>
				</div>

			</div>

		</form>
		<?php
		$default_sorting = '';
		if ( ! strlen( esc_attr( $search ) ) ) {
			$default_sorting = PeepSo::get_option( 'classifieds_default_sorting', 'id' );
		}

		?>
		<div class="ps-wpadverts__filters ps-js-page-filters">
			<div class="ps-wpadverts__filters-inner">

				<div class="ps-wpadverts__filter">
					<label class="ps-wpadverts__filter-label"><?php echo esc_html__( 'Location', 'matebook' ); ?></label>
					<input placeholder="<?php esc_attr_e( 'Start typing to search...', 'matebook' ); ?>" type="text"
						   class="ps-input ps-js-classifieds-location" name="location"
						   value="<?php echo esc_attr( $location ); ?>"/>
				</div>

				<?php if ( $adverts_categories ) { ?>

					<div class="ps-wpadverts__filter">
						<label class="ps-wpadverts__filter-label"><?php echo esc_html__( 'Category', 'matebook' ); ?></label>
						<select class="ps-select ps-js-classifieds-category" style="margin-bottom:5px">
							<option value="0"><?php echo esc_html__( 'All categories', 'matebook' ); ?></option>
							<?php
							if ( count( $adverts_categories ) ) {
								$PeepSoInput = new PeepSoInput();
								$category    = $PeepSoInput->int( 'category', 0 );
								foreach ( $adverts_categories as $id => $cat ) {
									$selected = "";
									if ( $cat['value'] == $category ) {
										$selected = ' selected="selected"';
									}
									echo "<option value=\"{$cat['value']}\"{$selected}>" . str_repeat( ' - ', $cat['depth'] ) . "{$cat['text']}</option>";
								}
							}
							?>
						</select>
					</div>

				<?php } // ENDIF ?>

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
		<div class="ps-classifieds <?php echo esc_attr( $columns ); ?> ps-clearfix ps-js-classifieds"></div>
		<div class="ps-scroll ps-clearfix ps-js-classifieds-triggerscroll">
			<img class="post-ajax-loader ps-js-classifieds-loading"
				 src="<?php echo PeepSo::get_asset( 'images/ajax-loader.gif' ); ?>"
				 alt="<?php echo esc_attr__( 'Loading...', 'matebook' ) ?>" style="display:none"/>
		</div>
	<?php } ?>
</div><!--end row-->

<?php

if ( get_current_user_id() ) {
	PeepSoTemplate::exec_template( 'activity', 'dialogs' );
}
