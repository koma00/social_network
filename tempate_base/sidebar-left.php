<?php
global $matebook_config;

if ( isset($matebook_config['sidebar_position']) ) {
	if ( $matebook_config['sidebar_position'] == 'no-sidebar' ) {
		return;
	}
}

$sidebars = $matebook_config['sidebars'];
$sidebar = array_key_exists(0, $sidebars) ? $sidebars[0] : '';
$sticky = mad()->get_option('sticky-sidebar');
?>

<?php if ( $sidebar && is_active_sidebar($sidebar) ): ?>

	<div id="site-sidebar-left" class="site-sidebar sidebar--left <?php if ( !empty($sticky) && in_array($sidebar, $sticky) ): ?>sticky-bar<?php endif; ?>">
		<?php dynamic_sidebar( $sidebar ); ?>
	</div>

<?php endif;







