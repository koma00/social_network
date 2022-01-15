<div class="ps-stream__filters">
<?php

/** STREAM ID **/

$stream_id = $user_stream_filters['stream_id'];
if(count($stream_id_list)) {

    $default = PeepSo::get_option('stream_id_default');

    if(!isset($stream_id_list[$stream_id]) && !array_key_exists($stream_id, $stream_id_list)) {
        $stream_id = $default;
    }

    if(!isset($stream_id_list[$stream_id]) && !array_key_exists($stream_id, $stream_id_list)) {
        reset($stream_id_list);
        $stream_id = key($stream_id_list);
    }

    $selected = $stream_id_list[$stream_id];

    ?>
    <input type="hidden" id="peepso_stream_id" value="<?php echo esc_attr($stream_id); ?>"/>
    <?php if (count($stream_id_list) > 1) { ?>

    <span class="ps-dropdown ps-dropdown--stream-filter ps-js-dropdown ps-js-activitystream-filter ps-mod-grow" data-id="peepso_stream_id">
      <button class="ps-mod-btn ps-js-dropdown-toggle" aria-haspopup="true">
        <i class="ps-icon-<?php echo esc_attr($selected['icon']); ?>"></i>
        <span><?php echo esc_html($selected['label']); ?></span>
      </button>
      <div role="menu" class="ps-dropdown__menu ps-js-dropdown-menu">
        <?php foreach ($stream_id_list as $key => $value) { ?>
        <a role="menuitem" class="ps-dropdown__group" data-option-value="<?php echo esc_attr($key); ?>" data-option-label-warning="<?php echo esc_attr($value['label_warning']);?>">
			<div class="ps-dropdown__inner">
				<span><?php echo esc_html($value['label']); ?></span>
				 <i class="ps-icon-<?php echo esc_attr($value['icon']); ?>"></i>
				  <div class="ps-checkbox">
					<input type="radio" name="peepso_stream_id" id="peepso_stream_id_opt_<?php echo esc_attr($key) ?>"
						   value="<?php echo esc_attr($key) ?>" <?php if ($key == $stream_id) echo "checked"; ?> />
					<label for="peepso_stream_id_opt_<?php echo esc_attr($key) ?>"></label>
				  </div>
			 	 <div class="ps-dropdown__group-desc"><?php echo esc_html($value['desc']); ?></div>
			</div>
        </a>
        <?php } ?>
        <div class="ps-dropdown__actions">
          <button class="ps-theme-btn ps-theme-btn-small ps-js-cancel"><?php echo esc_html__('Cancel', 'matebook'); ?></button>
          <button class="ps-theme-btn ps-theme-btn-small ps-theme-btn-primary ps-js-apply" ><?php echo esc_html__('Apply', 'matebook'); ?></button>
        </div>
      </div>
    </span>

    <?php } ?>
<?php } ?>

<?php

/** HIDE MY POSTS **/

$show_my_posts_list = array(
	'1' => array('label' => esc_html__('Show my posts', 'matebook')),
	'0' => array('label' => esc_html__('Hide my posts', 'matebook')),
);

$show_my_posts = $user_stream_filters['show_my_posts'];
$selected = $show_my_posts_list[$show_my_posts];

?>

<input type="hidden" id="peepso_stream_filter_show_my_posts" value="<?php echo esc_attr($show_my_posts); ?>" />
<span class="ps-dropdown ps-dropdown--stream-filter ps-js-dropdown ps-js-activitystream-filter ps-mod-grow" data-id="peepso_stream_filter_show_my_posts">
	<button class="ps-mod-btn ps-js-dropdown-toggle" aria-haspopup="true">
		<i class="material-icons-outlined">library_books</i>
		<span><?php echo ''. $show_my_posts ? esc_html__('Show my posts', 'matebook') : esc_html__('Hide my posts', 'matebook'); ?></span>
	</button>
	<div role="menu" class="ps-dropdown__menu ps-js-dropdown-menu">
		<?php foreach ( $show_my_posts_list as $key => $value ) { ?>
			<a role="menuitem" class="ps-dropdown__group" data-option-value="<?php echo esc_attr($key); ?>">
				<div class="ps-dropdown__inner">
					<span><?php echo esc_html($value['label']); ?></span>
					<div class="ps-checkbox">
							<input type="radio" name="peepso_stream_filter_show_my_posts"
								   id="peepso_stream_filter_show_my_posts_opt_<?php echo esc_attr($key) ?>"
								   value="<?php echo esc_attr($key) ?>" <?php if ( $key == $show_my_posts ) {
								echo "checked";
							} ?> />
							<label for="peepso_stream_filter_show_my_posts_opt_<?php echo esc_attr($key) ?>"></label>
					  </div>
				</div>
			</a>
		<?php } ?>
		<div class="ps-dropdown__actions">
			<button class="ps-theme-btn ps-theme-btn-small ps-js-cancel"><?php echo esc_html__('Cancel', 'matebook'); ?></button>
			<button class="ps-theme-btn ps-theme-btn-small ps-theme-btn-primary ps-js-apply"><?php echo esc_html__('Apply', 'matebook'); ?></button>
		</div>
	</div>
</span>

<?php

/** SEARCH POSTS **/
$search = FALSE;
$PeepSoUrlSegments = PeepSoUrlSegments::get_instance();

#4158 ?search/querystring does not work with special chars
if('search' == $PeepSoUrlSegments->get(1)) {
    $search = $PeepSoUrlSegments->get(2);
}

#4158 ?search/querystring does not work with special chars
if(isset($_GET['filter'])) {
    $PeepSoInput = new PeepSoInput();
    $search = $PeepSoInput->value('filter', '', FALSE);
}
?>
<input type="hidden" id="peepso_search" value="<?php echo esc_attr($show_my_posts); ?>" />
<span class="ps-dropdown ps-dropdown--stream-filter ps-js-dropdown ps-js-activitystream-filter" data-id="peepso_search">
	<a class="ps-mod-btn ps-js-dropdown-toggle" aria-haspopup="true" aria-label="<?php esc_attr_e('Search', 'matebook'); ?>">
		<i class="ps-icon-search"></i>
		<span data-empty=""
			data-keyword="<?php esc_attr_e('Search: ', 'matebook'); ?>"></span>
	</a>
	<div role="menu" class="ps-dropdown__menu ps-js-dropdown-menu">
		<div class="ps-dropdown__actions">
			<input type="text" id="ps-activitystream-search" class="ps-input ps-input--small ps-full"
				placeholder="<?php esc_attr_e('Type to search', 'matebook'); ?>" value="<?php echo esc_attr($search); ?>" />
		</div>

		<a role="menuitem" class="ps-dropdown__group" data-option-value="exact">
			<div class="ps-dropdown__inner">
				<span><?php echo esc_html__('Exact phrase', 'matebook'); ?></span>
				<div class="ps-checkbox">
					<input type="radio" name="peepso_search" id="peepso_search_opt_exact" value="exact" checked />
					<label for="peepso_search_opt_exact"></label>
				</div>
			</div>

		</a>
		<a role="menuitem" class="ps-dropdown__group" data-option-value="any">
			<div class="ps-dropdown__inner">
				<span><?php echo esc_html__('Any of the words', 'matebook'); ?></span>
				<div class="ps-checkbox">
					<input type="radio" name="peepso_search" id="peepso_search_opt_any" value="any" />
					<label for="peepso_search_opt_any"></label>
				</div>
			</div>

		</a>
		<div class="ps-dropdown__actions">
			<button class="ps-theme-btn ps-theme-btn-small ps-js-cancel"><?php echo esc_html__('Cancel', 'matebook'); ?></button>
			<button class="ps-theme-btn ps-theme-btn-small ps-theme-btn-primary ps-js-search"><?php echo esc_html__('Search', 'matebook'); ?></button>
		</div>
	</div>
</span>

<?php

/** ADDITIONAL FILTERS - HOOKABLE **/

do_action('peepso_action_render_stream_filters');
?>
</div>
<div id="ps-stream__filters-warning" class="ps-stream__filters-warning">
  <i class="ps-icon-info-circled"></i>  <?php echo esc_html__('You are currently only viewing %s content.','matebook'); ?>
</div>
