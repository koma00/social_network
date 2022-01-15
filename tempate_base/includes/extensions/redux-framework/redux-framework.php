<?php
namespace Matebook\Ext\Redux_Framework;

if ( ! defined('ABSPATH') ) {
	exit;
}

use Leafo\ScssPhp\Compiler;

class Redux_Framework {

	use \Matebook\Src\Traits\Instantiatable;

	/**
	 * Contains an instance of the ReduxFramework class.
	 *
	 * @access protected
	 * @var ReduxFramework
	 */
	public $ReduxFramework;

	public $version;

	/**
	 * Contains information about the theme.
	 *
	 * @access protected
	 * @var object
	 */
	protected $theme;

	/**
	 * Contains all sections of the theme options panel.
	 *
	 * @access protected
	 * @var array
	 */
	protected $sections = array();

	/**
	 * Contains all parameters for the ReduxFramework instance.
	 *
	 * @access protected
	 * @var array
	 */
	protected $args = array();

	/**
	 * Contains options that have been setted programmatically.
	 *
	 * @access protected
	 * @var array
	 */
	protected $setted_settings = array();

	public function __construct() {

		// Load the configurator.
		$this->ReduxFramework = Configurator::instance();

		add_action( 'redux/options/matebook_settings/saved', [ $this, 'save_theme_settings' ], 90, 2 );
		add_action( 'redux/options/matebook_settings/import', [ $this, 'save_theme_settings' ], 90, 2 );
		add_action( 'redux/options/matebook_settings/reset', [ $this, 'save_theme_settings' ] );
		add_action( 'redux/options/matebook_settings/section/reset', [ $this, 'save_theme_settings' ] );

		if ( get_option('matebook_init_theme', '0') != '1' ) {
			Functions::check_theme_options();
		}

	}

	public function save_theme_settings() {

		update_option( 'matebook_init_theme', '1' );
		$reduxFramework = $this->ReduxFramework->getReduxInstance();

		$template_dir = get_theme_file_path('assets/dynamic/sass/');

		// config file
		ob_start();
		require locate_template( 'assets/dynamic/config-sass.php' );
		$_config_css = ob_get_clean();
		$filename = $template_dir . 'config.scss';

		if ( file_exists($filename) ) {
			@unlink($filename);
		}

		$reduxFramework->filesystem->execute( 'put_contents', $filename, array( 'content' => $_config_css ) );

		try {

			ob_start();

			$scss = new Compiler();
			$scss->setImportPaths($template_dir);
			echo '' . $scss->compile('@import "skin.scss";');
			$config_css = ob_get_clean();

			$prefix_name = 'skin_' . get_current_blog_id() . '.css';
			$wp_upload_dir  = wp_upload_dir();
			$stylesheet_dynamic_dir = $wp_upload_dir['basedir'] . '/dynamic_matebook_dir';
			$stylesheet_dynamic_dir = str_replace('\\', '/', $stylesheet_dynamic_dir);

			$this->backend_create_folder($stylesheet_dynamic_dir);
			$file_name = trailingslashit($stylesheet_dynamic_dir) . $prefix_name;
			$create = $reduxFramework->filesystem->execute( 'put_contents', $file_name, array( 'content' => $config_css) );

			if ( $create === true ) {
				update_option( 'matebook_stylesheet_version' . $prefix_name, uniqid() );
			}

		} catch (Exception $e) {}

	}

	function backend_create_folder( &$folder, $addindex = true ) {
		if ( is_dir($folder) && $addindex == false ) {
			return true;
		}

		$created = wp_mkdir_p(trailingslashit($folder));

		if ( $addindex == false ) return $created;

		return $created;
	}

}
