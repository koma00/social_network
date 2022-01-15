<?php
$PeepSoProfile = PeepSoProfile::get_instance();
$PeepSoUser = $PeepSoProfile->user;

foreach ( $links as $id => $link ) {
	$url = $PeepSoUser->get_profileurl() . $link['href'];

	if ( 'http' == substr( $link['href'], 0, 4 ) ) {
		$url = $link['href'];
	}

	?><a class="ps-focus__menu-item <?php if ( $current == $id ) {
		echo 'ps-focus__menu-item--active active ps-js-item-active';
	} ?> ps-js-item" href="<?php echo esc_url( $url ); ?>">
	<i class="<?php echo esc_attr( $link['icon'] ); ?>"></i>
	<span><?php echo esc_html( $link['label'] ); ?></span>
	</a><?php
}
?>

<a href="#" class="ps-focus__menu-item ps-focus__menu-item--more ps-tip ps-tip--arrow ps-js-item-more " aria-label="<?php echo esc_html__('More', 'matebook'); ?>" style="display:none">
	<i class="gcis gci-ellipsis-h"></i>
</a>
<div class="ps-focus__menu-more ps-dropdown ps-dropdown--menu ps-js-focus-more">
	<div class="ps-dropdown__menu ps-js-focus-link-dropdown"></div>
</div>
