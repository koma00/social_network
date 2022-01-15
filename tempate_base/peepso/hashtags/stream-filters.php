<?php
/** SEARCH POSTS **/
$hashtag = FALSE;
$PeepSoUrlSegments = PeepSoUrlSegments::get_instance();

if('hashtag' == $PeepSoUrlSegments->get(1)) {
    $hashtag = $PeepSoUrlSegments->get(2);
}

?>
<input type="hidden" id="peepso_search_hashtag" value="<?php echo esc_attr($hashtag); ?>" />
<span class="ps-dropdown ps-dropdown--right ps-dropdown--stream-filter ps-js-dropdown ps-js-activitystream-filter" data-id="peepso_search_hashtag">
	<a class="ps-mod-btn ps-js-dropdown-toggle" aria-haspopup="true">
		<span data-empty="<?php esc_attr_e('#', 'matebook'); ?>"
			data-keyword="<?php esc_attr_e('#', 'matebook'); ?>"
		><i class="ps-icon-hashtag"></i></span>
	</a>
	<div role="menu" class="ps-dropdown__menu ps-js-dropdown-menu">
		<div class="ps-dropdown__actions">
			<i class="ps-icon-hashtag"></i><input maxlength="<?php echo PeepSo::get_option('hashtags_max_length',16);?>" type="text" class="ps-input ps-input--small ps-full"
				placeholder="<?php esc_attr_e('Type to search', 'matebook'); ?>" value="<?php echo esc_attr($hashtag);?>" />
        </div>
        <div class="ps-dropdown__desc">
        	<div class="ps-dropdown__desc-inner">
				<i class="ps-icon-info-circled"></i>
		        <?php
		        echo sprintf(
			        __('Letters and numbers only, minimum %d and maximum %d character(s)','matebook'),
			        PeepSo::get_option('hashtags_min_length',3),
			        PeepSo::get_option('hashtags_max_length',16)
		        );?>
			</div>
		</div>
		<div class="ps-dropdown__actions">
			<button class="ps-theme-btn ps-theme-btn-small ps-js-cancel"><?php echo esc_html__('Cancel', 'matebook'); ?></button>
			<button class="ps-theme-btn ps-theme-btn-small ps-theme-btn-primary ps-js-search-hashtag"><?php echo esc_html__('Apply', 'matebook'); ?></button>
		</div>
	</div>
</span>
