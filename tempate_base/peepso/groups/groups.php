<?php

$categories_enabled = FALSE;
$categories_tab  = FALSE;

if(PeepSo::get_option('groups_categories_enabled', FALSE)) {

	$categories_enabled = TRUE;

	$PeepSoGroupCategories = new PeepSoGroupCategories(FALSE, NULL);
	$categories = $PeepSoGroupCategories->categories;
	if (!isset($_GET['category'])) {
		$categories_default_view = PeepSo::get_option('groups_categories_default_view', 0);
		$_GET['category'] = $categories_default_view;
	}

	if (!isset($_GET['category']) || (isset($_GET['category']) && intval($_GET['category'])==1)) {
		$categories_tab = TRUE;
	}
}
?>
<div class="peepso">

	<div class="ps-page ps-page--groups">
		<?php PeepSoTemplate::exec_template('general','navbar'); ?>
		<?php PeepSoTemplate::exec_template('general', 'register-panel'); ?>

		<div class="ps-groups">
			<?php if(get_current_user_id() || (get_current_user_id() == 0 && $allow_guest_access)) { ?>
				<div class="ps-groups__header">

					<div class="ps-groups__header-inner">

						<div class="ps-tabs__wrapper">

							<?php if ($categories_enabled) { ?>
								<div class="ps-tabs ps-tabs--arrows">
									<div class="ps-tabs__item  <?php if(!$categories_tab) echo "current";?>"><a href="<?php echo PeepSo::get_page('groups').'?category=0';?>"><?php echo esc_html__('Groups', 'matebook'); ?></a></div>
									<div class="ps-tabs__item  <?php if($categories_tab) echo "current";?>"><a href="<?php echo PeepSo::get_page('groups').'?category=1';?>"><?php echo esc_html__('Group Categories', 'matebook'); ?></a></div>
								</div>
							<?php } ?>

							<div class="ps-groups__list-view">
								<div class="ps-btn__group">
									<a href="#" class="ps-theme-btn--app ps-btn--cp ps-tip ps-tip--arrow ps-js-groups-viewmode" data-mode="grid" aria-label="<?php echo esc_html__('Grid', 'matebook');?>"><i class="gcis gci-th-large"></i></a>
									<a href="#" class="ps-theme-btn--app ps-btn--cp ps-tip ps-tip--arrow ps-js-groups-viewmode" data-mode="list" aria-label="<?php echo esc_html__('List', 'matebook');?>"><i class="gcis gci-th-list"></i></a>
								</div>
							</div>

							<?php if ( PeepSoGroupUser::can_create() ) { ?>
								<div class="ps-groups__actions ps-page-actions">
									<a class="ps-btn ps-btn--sm ps-btn--action" href="#" onclick="peepso.groups.dlgCreate(); return false;">
										<i class="material-icons">add_circle_outline</i>
										<?php echo esc_html__('Create Group', 'matebook');?>
									</a>
								</div>
							<?php } ?>

						</div>

					</div>

					<?php if(!$categories_tab) { ?>
						<div class="ps-groups__search-inner">
							<div class="ps-groups__search">
								<input placeholder="<?php echo esc_html__('Start typing to search...', 'matebook');?>" type="text" class="ps-input ps-groups__search-input ps-js-groups-query" name="query" value="<?php echo esc_attr($search); ?>" />
							</div>
							<a href="#" class="ps-groups__filters-toggle ps-tooltip ps-form-search-opt" onclick="return false;" data-tooltip="<?php echo esc_html__('Show filters', 'matebook');?>">
								<i class="gcis gci-cog"></i>
							</a>
						</div>
					<?php } ?>

					<?php if(!$categories_tab) { ?>
						<?php
						$default_sorting = '';
						if(!strlen(esc_attr($search)))
						{
							$default_sorting = PeepSo::get_option('groups_default_sorting','id');
							$default_sorting_order = PeepSo::get_option('groups_default_sorting_order','DESC');
						}
						?>

						<div class="ps-groups__filters ps-js-page-filters" style="<?php echo (esc_attr($categories_enabled) && !esc_attr($categories_tab)) ? "" : "display:none";?>">
							<div class="ps-groups__filters-inner">
								<div class="ps-groups__filter">
									<label class="ps-groups__filter-label"><?php echo esc_html__('Sort', 'matebook'); ?></label>
									<select class="ps-input ps-input--select ps-js-groups-sortby">
											<option value="id"><?php echo esc_html__('Recently added', 'matebook'); ?></option>
											<option <?php echo ('post_title' == $default_sorting) ? ' selected="selected" ' : '';?> value="post_title"><?php echo esc_html__('Alphabetical', 'matebook'); ?></option>
											<option <?php echo ('meta_members_count' == $default_sorting) ? ' selected="selected" ' : '';?>value="meta_members_count"><?php echo esc_html__('Members count', 'matebook'); ?></option>
									</select>
								</div>

								<div class="ps-groups__filter">
									<label class="ps-groups__filter-label">&nbsp;</label>
									<select class="ps-input ps-input--select ps-js-groups-sortby-order">
											<option value="DESC"><?php echo esc_html__('Descending', 'matebook'); ?></option>
											<option <?php echo ('ASC' == $default_sorting_order) ? ' selected="selected" ' : '';?> value="ASC"><?php echo esc_html__('Ascending', 'matebook'); ?></option>
									</select>
								</div>

								<?php if($categories_enabled) { ?>
									<div class="ps-groups__filter">
										<label class="ps-groups__filter-label"><?php echo esc_html__('Category', 'matebook'); ?></label>
										<select class="ps-input ps-input--select ps-js-groups-category">
											<option value="0"><?php echo esc_html__('No filter', 'matebook'); ?></option>
											<?php
											if(count($categories)) {
												foreach($categories as $id=>$cat) {
														$count = PeepSoGroupCategoriesGroups::update_stats_for_category($id);
													$selected = "";
													if($id==$category) {
														$selected = ' selected="selected"';
													}
													echo "<option value=\"$id\"{$selected}>{$cat->name} ($count)</option>";
												}
											}

											$count_uncategorized = PeepSoGroupCategoriesGroups::update_stats_for_category();
											if ($count_uncategorized > 0) {
												?>
												<option value="-1" <?php if(-1 == $category) { echo 'selected="selected"';}?>><?php echo esc_html__('Uncategorized', 'matebook'); ?></option>
												<?php
											}
											?>
										</select>
									</div>
								<?php } // ENDIF ?>
							</div>
						</div>
					<?php } ?>
				</div>


				<?php if($categories_tab) { ?>
					<?php $single_column = PeepSo::get_option( 'groups_single_column', 0 ); ?>
					<div class="mb-20"></div>
					<div class="ps-groups__categories ps-js-group-cats" data-mode="<?php echo esc_attr($single_column) ? 'list' : 'grid' ?>"></div>
					<div class="ps-groups__loading ps-js-group-cats-triggerscroll">
						<img class="ps-loading post-ajax-loader ps-js-group-cats-loading" src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" alt="<?php echo esc_attr__('Loading', 'matebook'); ?>" />
					</div>
				<?php } else { ?>
					<?php $single_column = PeepSo::get_option( 'groups_single_column', 0 ); ?>
					<div class="mb-20"></div>
					<div class="ps-groups__list <?php echo esc_attr($single_column) ? 'ps-groups__list--single' : '' ?> ps-js-groups" data-mode="<?php echo esc_attr($single_column) ? 'list' : 'grid' ?>"></div>
					<div class="ps-groups__loading ps-js-groups-triggerscroll">
						<img class="ps-loading post-ajax-loader ps-js-groups-loading" src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" alt="<?php echo esc_attr__('Loading', 'matebook'); ?>" />
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div><!-- .peepso wrapper -->

<?php

if(get_current_user_id()) {
	PeepSoTemplate::exec_template('activity', 'dialogs');
}
