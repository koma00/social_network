<?php
$config = array();
$config['hideempty'] = (isset($instance['hideempty']) && true == $instance['hideempty']) ? 1 : 0;
$config['totalmember'] = (isset($instance['totalmember']) && true == $instance['totalmember']) ? 1 : 0;
$config['limit'] = (isset($instance['limit']) && is_int($instance['limit'])) ? $instance['limit'] : 5;

$config['id'] = 'peepso-latest-members-'.md5(implode($config));

$PeepSoMemberSearch = PeepSoMemberSearch::get_instance();
echo '' . $args['before_widget'];

?><div class="ps-widget--members__wrapper ps-widget__wrapper<?php echo sprintf('%s', $instance['class_suffix']); ?> ps-widget<?php echo sprintf('%s', $instance['class_suffix']); ?> ps-js-widget-latest-members"
        data-hideempty="<?php echo esc_attr($config['hideempty']); ?>"
        data-totalmember="<?php echo esc_attr($config['totalmember']); ?>"
        data-limit="<?php echo esc_attr($config['limit']); ?>">

    <div class="ps-widget__header<?php echo sprintf('%s', $instance['class_suffix']); ?>">
        <?php
			if (!empty($instance['title'])) {
				echo '' . $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
			}
		?>
    </div>
    <div class="ps-widget__body<?php echo sprintf('%s', $instance['class_suffix']); ?>">
        <div class="ps-widget--members ps-js-widget-content" id="<?php echo esc_attr($config['id']);?>">
            <img alt="<?php echo esc_attr__('Loading...', 'matebook') ?>" src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>">
        </div>
    </div>

</div><?php

echo '' . $args['after_widget'];
// EOF
