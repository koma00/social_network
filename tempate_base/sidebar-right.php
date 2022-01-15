<?php
global $matebook_config;

if ( isset($matebook_config['sidebar_position']) ) {
	if ( $matebook_config['sidebar_position'] == 'no-sidebar' ) {
		return;
	}
}

$sidebars = $matebook_config['sidebars'];
$sidebar = array_key_exists(1, $sidebars) ? $sidebars[1] : '';
$sticky = mad()->get_option('sticky-sidebar');
?>

<?php if ( $sidebar && is_active_sidebar($sidebar) ): ?>

	<div id="site-sidebar-right" class="site-sidebar sidebar--right <?php if ( !empty($sticky) && in_array($sidebar, $sticky) ): ?>sticky-bar<?php endif; ?>">
		<?php dynamic_sidebar( $sidebar ); ?>
	</div>

<?php endif;




