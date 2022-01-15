<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required vendors.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */

add_action( 'tgmpa_register', 'matebook_register_required_plugins' );

/**
 * Register the required vendors for this theme.
 *
 * In this example, we register two vendors - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function matebook_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */

	$plugins = array(
		array(
			'name'     => esc_html__('Redux Lite', 'matebook'),
			'slug'     => 'redux-framework',
			'required' => false
		),
		array(
			'name'     => esc_html__('WooCommerce', 'matebook'),
			'slug'     => 'woocommerce',
			'required' => false
		),
		array(
			'name'     => esc_html__('WPAdverts — Classifieds Plugin', 'matebook'),
			'slug'     => 'wpadverts',
			'required' => false
		),
		array(
			'name'      => esc_html__('Meta Box', 'matebook' ),
			'slug'      => 'meta-box',
			'required'  => true
		),
		array(
			'name'               => esc_html__('PeepSo', 'matebook'),
			'slug'               => 'peepso-core',
			'source'             => 'http://velikorodnov.com/wordpress/sample-data/matebook/pluginus12/peepso-core.zip',
			'required'           => false,
			'version'            => '3.1.0.0'
		),
		array(
			'name'               => esc_html__('Envato Market', 'matebook'),
			'slug'               => 'envato-market',
			'source'             => 'http://velikorodnov.com/wordpress/sample-data/pluginusan/envato-market.zip',
			'required'           => false,
			'version'            => '2.0.6'
		),
		array(
			'name'               => esc_html__('Matebook Theme Functionality', 'matebook'),
			'slug'               => 'matebook-theme-functionality',
			'source'             => 'http://velikorodnov.com/wordpress/sample-data/matebook/pluginus12/matebook-theme-functionality.zip',
			'required'           => true,
			'version'            => '1.0.1',
		)
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       => 'matebook', // Text domain - likely want to be the same as your theme.
		'id'           => 'matebook',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '', // Default absolute path to bundled vendors.
		'menu'         => 'install-required-vendors',
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate vendors after installation or not.
		'message'      => ''
	);

	tgmpa( $plugins, $config );

}