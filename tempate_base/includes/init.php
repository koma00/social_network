<?php
Matebook\Ext\Redux_Framework\Functions::check_theme_options();
Matebook\Includes\Admin::instance();
Matebook\Includes\Filters::instance();
Matebook\Includes\Assets::instance();

matebook()->register( 'woocommerce', Matebook\Ext\WooCommerce\WooCommerce::instance() );
matebook()->register( 'peepso', Matebook\Ext\Peepso\Peepso::instance() );
matebook()->register( 'helpers', Matebook\Utils\Helpers\Helpers::instance() );

/*
 * Configure theme textdomain, supported features, nav menus, etc.
 */
add_action( 'after_setup_theme', function() {

	global $content_width;

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Add support for the WooCommerce plugin.
	add_theme_support( 'woocommerce' );

	$content_width = apply_filters( 'matebook_content_width', 1380 );

	add_theme_support( 'align-wide' );

	// Post Thumbnails Support
	add_theme_support( 'post-thumbnails' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', 'Primary Menu' );

	/* Add image sizes */
	$image_sizes = apply_filters( 'matebook_modify_image_sizes', array(
		'matebook-375x420-center-center' => array( 'args' => array( 'w' => 375, 'h' => 420, 'crop' => 1 ) ),
		'matebook-750x350-center-center' => array( 'args' => array( 'w' => 750, 'h' => 350, 'crop' => 1 ) ),
		'matebook-1000x600-center-center' => array( 'args' => array( 'w' => 1000, 'h' => 600, 'crop' => 1 ) )
	) );

	if ( ! empty( $image_sizes ) ) {
		foreach ( $image_sizes as $id => $size ) {
			add_image_size( $id, $size['args']['w'], $size['args']['h'], $size['args']['crop'] );
		}
	}

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	add_editor_style( array( 'assets/dist/admin/editor-style.css' ) );



});

/*
 * Register theme sidebars.
 */
add_action( 'widgets_init', function() {

	$widget_args = array(
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>'
	);

	register_sidebar( array(
		'name'          => 'Sidebar Left',
		'id'            => 'sidebar-left',
		'before_widget' => $widget_args['before_widget'],
		'after_widget'  => $widget_args['after_widget'],
		'before_title'  => $widget_args['before_title'],
		'after_title'   => $widget_args['after_title']
	) );

	register_sidebar( array(
		'name'          => 'Sidebar Right',
		'id'            => 'sidebar-right',
		'before_widget' => $widget_args['before_widget'],
		'after_widget'  => $widget_args['after_widget'],
		'before_title'  => $widget_args['before_title'],
		'after_title'   => $widget_args['after_title']
	) );

	// Main Footer Widget Area
	register_sidebar( array(
		'name' => esc_html__('Main Footer', 'matebook' ),
		'id' => 'main-footer-widget-area',
		'before_widget' => $widget_args['before_widget'],
		'after_widget' => $widget_args['after_widget'],
		'before_title' => $widget_args['before_title'],
		'after_title' => $widget_args['after_title']
	));

});

add_action( 'matebook_get_footer', function() {
	mad()->get_template( 'nav-panel' );
}, 1 );