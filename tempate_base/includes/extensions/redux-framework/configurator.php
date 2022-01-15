<?php

namespace Matebook\Ext\Redux_Framework;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use ReduxFramework;

class Configurator {

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

	public function __construct() {

		// Load the plugin.
		if ( ! class_exists( 'ReduxFramework' ) ) {
			return;
		}

		$this->theme = wp_get_theme();
		$this->setArgs();
		$this->setSections();

		if ( ! isset( $this->args['opt_name'] ) ) {
			return;
		}

		$this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
	}

	/**
	 * Returns the ReduxFramework instance.
	 *
	 * @access public
	 * @return ReduxFramework
	 */
	public function getReduxInstance()
	{
		return $this->ReduxFramework;
	}

	/**
	 * Packs all sections of the theme options panel to dedicated array.
	 *
	 * @param array $sections
	 *
	 * @access protected
	 * @return array
	 */
	public function setSections() {

		$this->sections[] = array(
			'icon'       => 'el-icon-dashboard',
			'icon_class' => 'icon',
			'title'      => esc_html__( 'General', 'matebook' ),
			'fields'     => array(
				array(
					'id'      => 'show-loading-overlay',
					'type'    => 'switch',
					'title'   => esc_html__( 'Loading Overlay', 'matebook' ),
					'default' => false,
					'on'      => esc_html__( 'Show', 'matebook' ),
					'off'     => esc_html__( 'Hide', 'matebook' ),
				),
			)
		);

		// Logo
		$this->sections[] = array(
			'icon_class' => 'icon',
			'subsection' => true,
			'title'      => esc_html__( 'Media', 'matebook' ),
			'desc'       => esc_html__( 'Personalize theme by adding your own images', 'matebook' ),
			'fields'     => array(
				array(
					'id'       => 'logo',
					'type'     => 'media',
					'url'      => true,
					'readonly' => false,
					'title'    => esc_html__( 'Logo', 'matebook' ),
					'default'  => array(
						'url' => get_theme_file_uri( 'assets/images/logo.png' )
					)
				),
				array(
					'id'       => 'logo_hidpi',
					'type'     => 'media',
					'url'      => true,
					'readonly' => false,
					'title'    => esc_html__( 'Logo HiDPI', 'matebook' ),
					'default'  => array(
						'url' => get_theme_file_uri( 'assets/images/logo@2x.png' )
					)
				),
				array(
					'id'     => '122',
					'type'   => 'info',
					'title'  => esc_html__( 'Favicon', 'matebook' ),
					'notice' => false
				),
				array(
					'id'       => 'favicon',
					'type'     => 'media',
					'url'      => true,
					'readonly' => false,
					'title'    => esc_html__( 'Favicon', 'matebook' ),
					'default'  => array(
						'url' => get_theme_file_uri( 'assets/images/favicon.png' )
					)
				),
			)
		);

		// Skin Styling
		$this->sections[] = array(
			'icon'       => 'el-icon-broom',
			'icon_class' => 'icon',
			'title'      => esc_html__( 'Skin', 'matebook' ),
			'fields'     => array(
				array(
					'id'      => 'selection-color',
					'type'    => 'color',
					'desc'    => esc_html__( 'The ::selection selector matches the portion of an element that is selected by a user.', 'matebook' ),
					'title'   => esc_html__( 'Selection background color', 'matebook' ),
					'default' => '#1e1e1e',
				),
				array(
					'id'       => 'primary-color',
					'type'     => 'color',
					'title'    => esc_html__( 'Primary Color', 'matebook' ),
					'default'  => '#2186c3',
					'validate' => 'color',
				),
				array(
					'id'       => 'secondary-color',
					'type'     => 'color',
					'title'    => esc_html__( 'Secondary Color', 'matebook' ),
					'default'  => '#f75411',
					'validate' => 'color',
				),
			)
		);

		$this->sections[] = array(
			'icon_class' => 'icon',
			'subsection' => true,
			'title'      => esc_html__( 'Typography', 'matebook' ),
			'fields'     => array(
				array(
					'id'      => 'select-google-charset',
					'type'    => 'switch',
					'title'   => esc_html__( 'Select Google Font Character Sets', 'matebook' ),
					'default' => false,
					'on'      => esc_html__( 'Yes', 'matebook' ),
					'off'     => esc_html__( 'No', 'matebook' ),
				),
				array(
					'id'       => 'google-charsets',
					'type'     => 'button_set',
					'title'    => esc_html__( 'Google Font Character Sets', 'matebook' ),
					'multi'    => true,
					'required' => array( 'select-google-charset', 'equals', true ),
					'options'  => array(
						'cyrillic'     => 'Cyrrilic',
						'cyrillic-ext' => 'Cyrrilic Extended',
						'greek'        => 'Greek',
						'greek-ext'    => 'Greek Extended',
						'khmer'        => 'Khmer',
						'latin'        => 'Latin',
						'latin-ext'    => 'Latin Extneded',
						'vietnamese'   => 'Vietnamese'
					),
					'default'  => array(
						'latin',
						'greek-ext',
						'cyrillic',
						'latin-ext',
						'greek',
						'cyrillic-ext',
						'vietnamese',
						'khmer'
					)
				),
				array(
					'id'         => 'body-font',
					'type'       => 'typography',
					'title'      => esc_html__( 'Body Font', 'matebook' ),
					'google'     => true,
					'subsets'    => false,
					'font-style' => false,
					'text-align' => false,
					'default'    => array(
						'color'       => "#41484f",
						'google'      => true,
						'font-weight' => '400',
						'font-family' => 'Mulish',
						'font-size'   => '14',
						'line-height' => '28'
					),
				),
				array(
					'id'         => 'h1-font',
					'type'       => 'typography',
					'title'      => esc_html__( 'H1 Font', 'matebook' ),
					'google'     => true,
					'subsets'    => false,
					'font-style' => false,
					'text-align' => false,
					'default'    => array(
						'color'       => "#2a2e33",
						'google'      => true,
						'font-weight' => '600',
						'font-family' => 'Poppins',
						'font-size'   => '38',
						'line-height' => '42'
					),
				),
				array(
					'id'         => 'h2-font',
					'type'       => 'typography',
					'title'      => esc_html__( 'H2 Font', 'matebook' ),
					'google'     => true,
					'subsets'    => false,
					'font-style' => false,
					'text-align' => false,
					'default'    => array(
						'color'       => "#2a2e33",
						'google'      => true,
						'font-weight' => '600',
						'font-family' => 'Poppins',
						'font-size'   => '28',
						'line-height' => '35'
					),
				),
				array(
					'id'         => 'h3-font',
					'type'       => 'typography',
					'title'      => esc_html__( 'H3 Font', 'matebook' ),
					'google'     => true,
					'subsets'    => false,
					'font-style' => false,
					'text-align' => false,
					'default'    => array(
						'color'       => "#2a2e33",
						'google'      => true,
						'font-weight' => '600',
						'font-family' => 'Poppins',
						'font-size'   => '26',
						'line-height' => '35'
					),
				),
				array(
					'id'         => 'h4-font',
					'type'       => 'typography',
					'title'      => esc_html__( 'H4 Font', 'matebook' ),
					'google'     => true,
					'subsets'    => false,
					'font-style' => false,
					'text-align' => false,
					'default'    => array(
						'color'       => "#2a2e33",
						'google'      => true,
						'font-weight' => '600',
						'font-family' => 'Poppins',
						'font-size'   => '20',
						'line-height' => '28'
					),
				),
				array(
					'id'         => 'h5-font',
					'type'       => 'typography',
					'title'      => esc_html__( 'H5 Font', 'matebook' ),
					'google'     => true,
					'subsets'    => false,
					'font-style' => false,
					'text-align' => false,
					'default'    => array(
						'color'       => "#2a2e33",
						'google'      => true,
						'font-weight' => '600',
						'font-family' => 'Poppins',
						'font-size'   => '18',
						'line-height' => '21'
					),
				),
				array(
					'id'         => 'h6-font',
					'type'       => 'typography',
					'title'      => esc_html__( 'H6 Font', 'matebook' ),
					'google'     => true,
					'subsets'    => false,
					'font-style' => false,
					'text-align' => false,
					'default'    => array(
						'color'       => "#2a2e33",
						'google'      => true,
						'font-weight' => '600',
						'font-family' => 'Poppins',
						'font-size'   => '14',
						'line-height' => '21'
					),
				),
			)
		);

		$this->sections[] = array(
			'icon_class' => 'icon',
			'subsection' => true,
			'title'      => esc_html__( 'Backgrounds', 'matebook' ),
			'fields'     => array(
				array(
					'id'     => '1',
					'type'   => 'info',
					'title'  => esc_html__( 'Body Background', 'matebook' ),
					'notice' => false
				),
				array(
					'id'      => 'body-bg',
					'type'    => 'background',
					'default' => array(
						'background-image'      => 'none',
						'background-color'      => '#f1f2f4',
						'background-repeat'     => 'no-repeat',
						'background-size'       => 'contain',
						'background-attachment' => 'inherit',
						'background-position'   => 'center top'
					),
					'title'   => esc_html__( 'Background', 'matebook' )
				)
			)
		);

		$this->sections[] = array(
			'icon_class' => 'icon',
			'subsection' => true,
			'title'      => esc_html__( 'Main Menu', 'matebook' ),
			'fields'     => array(
				array(
					'id'     => '12',
					'type'   => 'info',
					'title'  => esc_html__( 'Top Level Menu Item', 'matebook' ),
					'notice' => false
				),
				array(
					'id'          => 'menu-font',
					'type'        => 'typography',
					'title'       => esc_html__( 'Menu Font', 'matebook' ),
					'google'      => true,
					'subsets'     => false,
					'font-style'  => false,
					'text-align'  => false,
					'line-height' => false,
					'color'       => false,
					'default'     => array(
						'google'      => true,
						'font-weight' => '400',
						'font-family' => 'Mulish',
						'font-size'   => '16',
					),
				),
				array(
					'id'      => 'menu-text-transform',
					'type'    => 'button_set',
					'title'   => esc_html__( 'Text Transform', 'matebook' ),
					'options' => array(
						'none'       => esc_html__( 'None', 'matebook' ),
						'capitalize' => esc_html__( 'Capitalize', 'matebook' ),
						'uppercase'  => esc_html__( 'Uppercase', 'matebook' ),
						'lowercase'  => esc_html__( 'Lowercase', 'matebook' ),
						'initial'    => esc_html__( 'Initial', 'matebook' )
					),
					'default' => 'none'
				),
				array(
					'id'      => 'primary-toplevel-link-color',
					'type'    => 'link_color',
					'active'  => false,
					'hover'   => false,
					'title'   => esc_html__( 'Link Color', 'matebook' ),
					'default' => array(
						'regular' => '#fff'
					)
				),
				array(
					'id'     => '231',
					'type'   => 'info',
					'title'  => esc_html__( 'Sub Menu', 'matebook' ),
					'notice' => false
				),
				array(
					'id'       => 'sub-menu-bg-color',
					'type'     => 'color',
					'title'    => esc_html__( 'Background Color for sub menu', 'matebook' ),
					'default'  => '#fff',
					'validate' => 'color',
				),
				array(
					'id'          => 'sub-menu-font',
					'type'        => 'typography',
					'title'       => esc_html__( 'Sub Menu Font', 'matebook' ),
					'google'      => true,
					'subsets'     => false,
					'font-style'  => false,
					'text-align'  => false,
					'line-height' => false,
					'color'       => false,
					'default'     => array(
						'google'      => true,
						'font-weight' => '400',
						'font-family' => 'Mulish',
						'font-size'   => '13'
					),
				),
				array(
					'id'      => 'sub-menu-text-color',
					'type'    => 'link_color',
					'title'   => esc_html__( 'Link Color', 'matebook' ),
					'default' => array(
						'regular' => '#2186c4',
						'hover'   => '#fff',
						'active'  => '#2186c4'
					)
				),
				array(
					'id'      => 'sub-menu-bg-active-color',
					'type'    => 'color',
					'title'   => esc_html__( 'Background Active Color', 'matebook' ),
					'default' => '#2186c3',
					'validate' => 'color'
				),
				array(
					'id'     => '131',
					'type'   => 'info',
					'title'  => esc_html__( 'Mobile Menu', 'matebook' ),
					'notice' => false
				),
				array(
					'id'       => 'mobile-menu-color',
					'type'     => 'color',
					'title'    => esc_html__( 'Color for toplevel link', 'matebook' ),
					'default'  => '#bdbdbd',
					'validate' => 'color',
				),
				array(
					'id'       => 'mobile-menu-active-color',
					'type'     => 'color',
					'title'    => esc_html__( 'Color for active toplevel link', 'matebook' ),
					'default'  => '#bee6fd',
					'validate' => 'color',
				)
			)
		);

		$this->sections[] = array(
			'icon_class' => 'icon',
			'subsection' => true,
			'title'      => esc_html__( 'Header', 'matebook' ),
			'fields'     => array(
				array(
					'id'      => 'header-bg-color',
					'type'    => 'color',
					'title'   => esc_html__( 'Header Background Color', 'matebook' ),
					'default' => '#363c42'
				)
			)
		);

		$this->sections[] = array(
			'icon_class' => 'icon',
			'subsection' => true,
			'title'      => esc_html__( 'Footer', 'matebook' ),
			'fields'     => array(
				array(
					'id'      => 'footer-bg',
					'type'    => 'background',
					'title'   => esc_html__( 'Background', 'matebook' ),
					'default' => array(
						'background-image'      => 'none',
						'background-color'      => '#262a2e',
						'background-size'       => 'cover',
						'background-attachment' => 'inherit',
						'background-position'   => 'center center',
						'background-repeat'     => 'no-repeat'
					)
				),
				array(
					'id'       => 'footer-heading-color',
					'type'     => 'color',
					'title'    => esc_html__( 'Heading Color', 'matebook' ),
					'default'  => '#fff',
					'validate' => 'color',
				),
			)
		);

		// Header Settings
		$this->sections[] = array(
			'icon'       => 'el-icon-website',
			'icon_class' => 'icon',
			'title'      => esc_html__( 'Header', 'matebook' ),
			'fields'     => array(
				array(
					'id'       => 'header-style-search',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Search', 'matebook' ),
					'default'  => true,
					'on'       => esc_html__( 'Yes', 'matebook' ),
					'off'      => esc_html__( 'No', 'matebook' ),
				),
				array(
					'id'       => 'header-style-widgets',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Widgets', 'matebook' ),
					'default'  => true,
					'on'       => esc_html__( 'Yes', 'matebook' ),
					'off'      => esc_html__( 'No', 'matebook' ),
				),
				array(
					'id'       => 'header-style-cart',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show Cart', 'matebook' ),
					'default'  => true,
					'on'       => esc_html__( 'Yes', 'matebook' ),
					'off'      => esc_html__( 'No', 'matebook' ),
				),
				array(
					'id'     => '223',
					'type'   => 'info',
					'title'  => esc_html__( 'Sticky Header', 'matebook' ),
					'desc'   => esc_html__( 'Modify and style your sticky header area', 'matebook' ),
					'notice' => false
				),
				array(
					'id'      => 'header-sticky-menu',
					'type'    => 'switch',
					'title'   => esc_html__( 'Sticky Navigation', 'matebook' ),
					'default' => true,
					'desc'    => esc_html__( 'The sticky navigation menu is a vital part of a website, helping users move between pages and find desired information.', 'matebook' ),
					'on'      => esc_html__( 'Yes', 'matebook' ),
					'off'     => esc_html__( 'No', 'matebook' ),
				),
			)
		);

		$this->sections[] = array(
			'icon_class' => 'el-icon-list',
			'title'     => esc_html__( 'Sidebar', 'matebook' ),
			'desc' => wp_kses( sprintf( __( 'You can manage sidebars content in the <a href="%s">Apperance -> Widgets</a> settings.', 'matebook' ), admin_url( 'widgets.php' ) ), wp_kses_allowed_html( 'post' ) ),
			'fields'    => array(
				array(
					'id'        => 'sticky-sidebar',
					'type'      => 'select',
					'title'     => esc_html__( 'Sticky sidebar', 'matebook' ),
					'subtitle'  => esc_html__( 'Choose a sticky sidebar', 'matebook' ),
					'default'   => array('sidebar-left', 'sidebar-right'),
					'multi' => true,
					'data' => 'sidebars'
				)
			)
		);

		// Footer Settings
		$this->sections[] = array(
			'icon'       => 'el-icon-website',
			'icon_class' => 'icon',
			'title'      => esc_html__( 'Footer', 'matebook' ),
			'fields'     => array(
				array(
					'id' => 'footer-show-main',
					'type' => 'switch',
					'title' => esc_html__('Show Main Footer', 'matebook' ),
					'default' => true,
					'on' => esc_html__('Yes', 'matebook' ),
					'off' => esc_html__('No', 'matebook' ),
				),
				array(
					'id' => 'footer-show-copyright',
					'type' => 'switch',
					'title' => esc_html__('Show Copyright', 'matebook' ),
					'default' => true,
					'on' => esc_html__('Yes', 'matebook' ),
					'off' => esc_html__('No', 'matebook' ),
				),
				array(
					'id' => 'footer-copyright',
					'type' => 'editor',
					'title' => esc_html__( 'Copyright', 'matebook' ),
					'subtitle' => esc_html__( 'Specify the copyright text to show at the bottom of the website', 'matebook' ),
					'default' => sprintf( __('Copyright &copy; %s &nbsp;<a href="%s">%s</a>. All Rights Reserved.', 'matebook' ), date('Y'), home_url('/'), get_bloginfo('blogname') ),
					'args' => array(
						'textarea_rows'    => 3  ,
						'default_editor' => 'html'
					),
					'required' => array( 'footer-show-copyright', '=', true )
				),
			)
		);

		$this->sections[] = array(
			'icon'       => 'el-icon-website',
			'icon_class' => 'icon',
			'title'      => esc_html__( 'Pages', 'matebook' ),
			'fields'     => array(
				array(
					'id'      => 'page_use_sidebar',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Display Sidebar', 'matebook' ),
					'options' => Functions::sidebar_position(),
					'default' => 'both'
				),
				array(
					'id' => 'page-title',
					'type' => 'select',
					'title' => esc_html__('Page Title', 'matebook' ),
					'options' => array(
						'show' => esc_html__( 'Show', 'matebook' ),
						'hide' => esc_html__( 'Hide', 'matebook' ),
					),
					'default' => 'show'
				),
				array(
					'id'       => 'page_left_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Select Left Sidebar', 'matebook' ),
					'desc'     => esc_html__( 'Choose a page standard left sidebar', 'matebook' ),
					'required' => array( 'page_use_sidebar', 'equals', array('left-sidebar', 'both') ),
					'data'     => 'sidebars',
					'default'  => 'sidebar-left'
				),
				array(
					'id'       => 'page_right_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Select Right Sidebar', 'matebook' ),
					'desc'     => esc_html__( 'Choose a page standard right sidebar', 'matebook' ),
					'required' => array( 'page_use_sidebar', 'equals', array('right-sidebar', 'both') ),
					'data'     => 'sidebars',
					'default'  => 'sidebar-right'
				)
			)
		);

		$this->sections[] = array(
			'icon'    => 'el-icon-th-large',
			'title'   => esc_html__( 'Post', 'matebook' ),
			'heading' => false,
			'fields'  => array(
				array(
					'id'      => 'post-tag',
					'type'    => 'switch',
					'title'   => esc_html__( 'Show Tags', 'matebook' ),
					'default' => true,
					'on'      => esc_html__( 'Yes', 'matebook' ),
					'off'     => esc_html__( 'No', 'matebook' ),
				),
				array(
					'id'      => 'post-columns',
					'type'    => 'button_set',
					'title'   => esc_html__( 'Columns', 'matebook' ),
					'options' => array(
						'col1' => 1,
						'col2' => 2
					),
					'default' => 'col1'
				),
				array(
					'id' => 'post-excerpt-limit',
					'type' => 'text',
					'class' => 'small-text',
					'title' => esc_html__( 'Excerpt limit', 'matebook' ),
					'subtitle' => esc_html__( 'Specify your excerpt limit', 'matebook' ),
					'desc' => esc_html__( 'Note: Value represents number of characters', 'matebook' ),
					'default' => 250,
					'validate' => 'numeric',
				),
				array(
					'id'        => 'lay_grid_meta',
					'type'      => 'sortable',
					'mode'      => 'checkbox',
					'title'     => esc_html__( 'Meta data', 'matebook' ),
					'subtitle'  => esc_html__( 'Check which meta data to show for posts in Layout Default', 'matebook' ),
					'options'   => Functions::get_meta_opts(),
					'default' => Functions::get_meta_opts( [ 'date', 'author', 'category' ] )
				),
			)
		);

		$this->sections[] = array(
			'icon_class' => 'el-icon-pencil',
			'title'      => esc_html__( 'Single Post', 'matebook' ),
			'fields'     => array(
				array(
					'id'      => 'post_use_sidebar',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Display Sidebar', 'matebook' ),
					'options' => Functions::sidebar_position(),
					'default' => 'both'
				),
				array(
					'id'       => 'post_left_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Select Left Sidebar', 'matebook' ),
					'desc'     => esc_html__( 'Choose a post standard left sidebar', 'matebook' ),
					'required' => array( 'post_use_sidebar', 'equals', array('left-sidebar', 'both') ),
					'data'     => 'sidebars',
					'default'  => 'sidebar-left'
				),
				array(
					'id'       => 'post_right_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Select Right Sidebar', 'matebook' ),
					'desc'     => esc_html__( 'Choose a post standard right sidebar', 'matebook' ),
					'required' => array( 'post_use_sidebar', 'equals', array('right-sidebar', 'both') ),
					'data'     => 'sidebars',
					'default'  => 'sidebar-right'
				),
				array(
					'id'        => 'lay_single_meta',
					'type'      => 'sortable',
					'mode'      => 'checkbox',
					'title'     => esc_html__( 'Meta data', 'matebook' ),
					'subtitle'  => esc_html__( 'Check which meta data to show for posts', 'matebook' ),
					'options'   => Functions::get_meta_opts(),
					'default' => Functions::get_meta_opts( [ 'date', 'author', 'category' ] )
				),
				array(
					'id'      => 'single-post-tag',
					'type'    => 'switch',
					'title'   => esc_html__( 'Show Tags', 'matebook' ),
					'default' => true,
					'on'      => esc_html__( 'Yes', 'matebook' ),
					'off'     => esc_html__( 'No', 'matebook' ),
				),
				array(
					'id'      => 'single-post-comments',
					'type'    => 'switch',
					'title'   => esc_html__( 'Show Comments', 'matebook' ),
					'default' => true,
					'on'      => esc_html__( 'Yes', 'matebook' ),
					'off'     => esc_html__( 'No', 'matebook' ),
				),
				array(
					'id'      => 'single-post-navigation',
					'type'    => 'switch',
					'title'   => esc_html__( 'Navigation', 'matebook' ),
					'default' => true,
					'on'      => esc_html__( 'Yes', 'matebook' ),
					'off'     => esc_html__( 'No', 'matebook' ),
				),
			)
		);

		$this->sections[] = array(
			'icon'   => 'el-icon-folder-open',
			'title'  => esc_html__( 'Archive Template', 'matebook' ),
			'desc'   => esc_html__( 'Manage settings for other miscellaneous templates like date archives, post format archives, index (latest posts) page, etc...', 'matebook' ),
			'fields' => array(

				array(
					'id'      => 'archive_use_sidebar',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Display Sidebar', 'matebook' ),
					'options' => Functions::sidebar_position(),
					'default' => 'both'
				),
				array(
					'id'       => 'archive_left_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Select Left Sidebar', 'matebook' ),
					'desc'     => esc_html__( 'Choose a archive standard left sidebar', 'matebook' ),
					'required' => array( 'archive_use_sidebar', 'equals', array('left-sidebar', 'both') ),
					'data'     => 'sidebars',
					'default'  => 'sidebar-left'
				),
				array(
					'id'       => 'archive_right_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Select Right Sidebar', 'matebook' ),
					'desc'     => esc_html__( 'Choose a archive standard right sidebar', 'matebook' ),
					'required' => array( 'archive_use_sidebar', 'equals', array('right-sidebar', 'both') ),
					'data'     => 'sidebars',
					'default'  => 'sidebar-right'
				),
				array(
					'id'       => 'archive_ppp',
					'type'     => 'radio',
					'title'    => esc_html__( 'Posts per page', 'matebook' ),
					'subtitle' => esc_html__( 'Choose how many posts per page you want to display', 'matebook' ),
					'options'  => array(
						'inherit' => wp_kses( sprintf( __( 'Inherit from global option in <a href="%s">Settings->Reading</a>', 'matebook' ), admin_url( 'options-reading.php' ) ), wp_kses_allowed_html( 'post' ) ),
						'custom'  => esc_html__( 'Custom number', 'matebook' )
					),
					'default'  => 'inherit'
				),
				array(
					'id'       => 'archive_ppp_num',
					'type'     => 'text',
					'class'    => 'small-text',
					'title'    => esc_html__( 'Number of posts per page', 'matebook' ),
					'default'  => get_option( 'posts_per_page' ),
					'required' => array( 'archive_ppp', '=', 'custom' ),
					'validate' => 'numeric'
				),
			)
		);

		// Shop
		$this->sections[] = array(
			'icon'       => 'el-icon-shopping-cart',
			'icon_class' => 'icon',
			'title'      => esc_html__( 'Shop', 'matebook' ),
			'fields'     => array(
				array(
					'id'      => 'product-archive-columns',
					'type'    => 'button_set',
					'title'   => esc_html__( 'Archive Columns', 'matebook' ),
					'options' => array(
						2 => 2,
						3 => 3,
						4 => 4
					),
					'default' => 3
				),
				array(
					'id'      => 'product-archive-per-page',
					'type'    => 'text',
					'title'   => esc_html__( 'Number of products displayed per page', 'matebook' ),
					'default' => 12
				),
				array(
					'id'      => 'product_archive_use_sidebar',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Page Archive Layout', 'matebook' ),
					'options' => Functions::sidebar_position(),
					'default' => 'both'
				),
				array(
					'id'      => 'product_use_sidebar',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Page Layout for base page of your shop', 'matebook' ),
					'options' => Functions::sidebar_position(),
					'default' => 'both'
				),
				array(
					'id'       => 'product_left_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Select Left Sidebar', 'matebook' ),
					'desc'     => esc_html__( 'Choose a page standard left sidebar', 'matebook' ),
					'required' => array( 'page_use_sidebar', 'equals', array('left-sidebar', 'both') ),
					'data'     => 'sidebars',
					'default'  => 'sidebar-left'
				),
				array(
					'id'       => 'product_right_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Select Right Sidebar', 'matebook' ),
					'desc'     => esc_html__( 'Choose a page standard right sidebar', 'matebook' ),
					'required' => array( 'page_use_sidebar', 'equals', array('right-sidebar', 'both') ),
					'data'     => 'sidebars',
					'default'  => 'sidebar-right'
				),
				array(
					'id'       => 'product_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Select Sidebar', 'matebook' ),
					'required' => array( 'product_use_sidebar', 'equals', Functions::sidebars() ),
					'data'     => 'sidebars',
					'default'  => 'shop-widget-area'
				),
				array(
					'id'      => 'product-new',
					'type'    => 'switch',
					'title'   => esc_html__( 'Show "New" Status', 'matebook' ),
					'default' => true,
					'on'      => esc_html__( 'Yes', 'matebook' ),
					'off'     => esc_html__( 'No', 'matebook' ),
				),
				array(
					'id'       => 'product-cat-number-widget-args',
					'type'     => 'text',
					'title'    => esc_html__( 'Widget Product Categories - Number Categories', 'matebook' ),
					'default'  => 5
				),
			)
		);

		$this->sections[] = array(
			'icon_class' => 'icon',
			'subsection' => true,
			'title'      => esc_html__( 'Single Product', 'matebook' ),
			'fields'     => array(
				array(
					'id'      => 'product_single_use_sidebar',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Single Layout', 'matebook' ),
					'options' => Functions::sidebar_position(),
					'default' => 'no-sidebar'
				),
				array(
					'id'       => 'product_single_sidebar',
					'type'     => 'select',
					'title'    => esc_html__( 'Select Sidebar', 'matebook' ),
					'required' => array( 'product_single_use_sidebar', 'equals', Functions::sidebars() ),
					'data'     => 'sidebars',
					'default'  => 'shop-widget-area'
				),
				array(
					'id'      => 'product-upsells',
					'type'    => 'switch',
					'title'   => esc_html__( 'Show Up-Sells', 'matebook' ),
					'default' => true,
					'on'      => esc_html__( 'Yes', 'matebook' ),
					'off'     => esc_html__( 'No', 'matebook' ),
				),
				array(
					'id'       => 'product-upsells-count',
					'type'     => 'text',
					'required' => array( 'product-upsells', 'equals', true ),
					'title'    => esc_html__( 'Up-Sells Count items', 'matebook' ),
					'default'  => 3
				),
				array(
					'id'       => 'product-upsells-cols',
					'type'     => 'button_set',
					'required' => array( 'product-upsells', 'equals', true ),
					'title'    => esc_html__( 'Up-Sells Product Columns', 'matebook' ),
					'options'  => Functions::product_columns(),
					'default'  => 3,
				),
				array(
					'id'      => 'product-related',
					'type'    => 'switch',
					'title'   => esc_html__( 'Show Related', 'matebook' ),
					'default' => true,
					'on'      => esc_html__( 'Yes', 'matebook' ),
					'off'     => esc_html__( 'No', 'matebook' ),
				),
				array(
					'id'       => 'product-related-count',
					'type'     => 'text',
					'required' => array( 'product-related', 'equals', true ),
					'title'    => esc_html__( 'Related Count items', 'matebook' ),
					'default'  => 3
				),
				array(
					'id'       => 'product-related-cols',
					'type'     => 'button_set',
					'required' => array( 'product-related', 'equals', true ),
					'title'    => esc_html__( 'Related Product Columns', 'matebook' ),
					'options'  => Functions::product_columns(),
					'default'  => 3,
				),
			)
		);

		$this->sections[] = array(
			'icon_class' => 'icon',
			'subsection' => true,
			'title'      => esc_html__( 'Cart', 'matebook' ),
			'fields'     => array(
				array(
					'id'      => 'product-crosssell',
					'type'    => 'switch',
					'title'   => esc_html__( 'Show Cross-Sells', 'matebook' ),
					'default' => true,
					'on'      => esc_html__( 'Yes', 'matebook' ),
					'off'     => esc_html__( 'No', 'matebook' ),
				),
				array(
					'id'       => 'product-crosssell-columns',
					'type'     => 'text',
					'required' => array( 'product-crosssell', 'equals', true ),
					'title'    => esc_html__( 'Cross Sells Columns', 'matebook' ),
					'default'  => '3'
				),
				array(
					'id'       => 'product-crosssell-count',
					'type'     => 'text',
					'required' => array( 'product-crosssell', 'equals', true ),
					'title'    => esc_html__( 'Cross Sells Limit', 'matebook' ),
					'default'  => '3'
				),
			)
		);

		// Javascript Code
		$this->sections[] = array(
			'icon_class' => 'el-icon-edit',
			'title'      => esc_html__( 'Javascript Code', 'matebook' ),
			'fields'     => array(
				array(
					'id'       => 'js-code-head',
					'type'     => 'ace_editor',
					'title'    => esc_html__( 'Javascript Code Before &lt;/head&gt;', 'matebook' ),
					'subtitle' => esc_html__( 'Paste your JS code here.', 'matebook' ),
					'mode'     => 'javascript',
					'theme'    => 'monokai',
					'default'  => '',
					'options'  => array(
						'minLines' => 35
					)
				)
			)
		);

		// 404 Page
		$this->sections[] = array(
			'icon'       => 'el-icon-error',
			'icon_class' => 'icon',
			'title'      => esc_html__( '404 Page', 'matebook' ),
			'fields'     => array(
				array(
					'id'           => 'error-content',
					'type'         => 'textarea',
					'title'        => esc_html__( 'Error text', 'matebook' ),
					'validate'     => 'html_custom',
					'default'      => sprintf( '<h1>404</h1><h5>%1$s</h5><p>%2$s %3$s<a href="%4$s" class="link-text">%5$s</a> %6$s:</p>',
						esc_html__( 'We\'re sorry, but we can\'t find the page you were looking for.', 'matebook' ),
						esc_html__( 'It\'s probably some thing we\'ve done wrong but now we know about it and we\'ll try to fix it.', 'matebook' ),
						esc_html__( 'Go', 'matebook' ),
						home_url( '/' ),
						esc_html__( 'Home', 'matebook' ),
						esc_html__( 'or try to search', 'matebook' ) ),
					'allowed_html' => array(
						'h1'     => array(
							'class' => array()
						),
						'h2'     => array(
							'class' => array()
						),
						'h3'     => array(
							'class' => array()
						),
						'h4'     => array(
							'class' => array()
						),
						'h5'     => array(
							'class' => array()
						),
						'p'      => array(
							'class' => array()
						),
						'a'      => array(
							'href'  => array(),
							'title' => array()
						),
						'br'     => array(),
						'em'     => array(),
						'strong' => array()
					)
				),
			)
		);

	}

	/**
	 * Returns parameters for the ReduxFramework instance.
	 *
	 * @access protected
	 * @return array
	 */
	protected function setArgs() {
		$theme = $this->theme;

		$this->args = array(
			'opt_name'        => 'matebook_settings',
			'display_name'    => $theme->get( 'Name' ) . ' ' . esc_html__( 'Theme Options', 'matebook' ),
			'display_version' => esc_html__( 'Theme Version: ', 'matebook' ) . strtolower( $theme->get( 'Version' ) ),
			'menu_type'       => 'submenu',
			'allow_sub_menu'  => true,
			'menu_title'      => esc_html__( 'Theme Options', 'matebook' ),
			'page_title'      => esc_html__( 'Theme Options', 'matebook' ),
			'footer_credit'   => esc_html__( 'Theme Options', 'matebook' ),

			'google_api_key'            => 'AIzaSyBQft4vTUGW75YPU6c0xOMwLKhxCEJDPwg',
			'disable_google_fonts_link' => true,

			'async_typography'   => false,
			'admin_bar'          => false,
			'admin_bar_icon'     => 'dashicons-admin-generic',
			'admin_bar_priority' => 50,
			'global_variable'    => '',
			'dev_mode'           => false,
			'customizer'         => false,
			'compiler'           => false,

			'page_priority'       => null,
			'page_parent'         => 'themes.php',
			'page_permissions'    => 'manage_options',
			'menu_icon'           => '',
			'last_tab'            => '',
			'page_icon'           => 'icon-themes',
			'page_slug'           => 'matebook_settings',
			'save_defaults'       => true,
			'default_show'        => false,
			'default_mark'        => '',
			'show_import_export'  => true,
			'show_options_object' => false,

			'transient_time' => 60 * MINUTE_IN_SECONDS,
			'output'         => false,
			'output_tag'     => false,

			'database'    => '',
			'system_info' => false,

			'hints'     => array(
				'icon'          => 'icon-question-sign',
				'icon_position' => 'right',
				'icon_color'    => 'lightgray',
				'icon_size'     => 'normal',
				'tip_style'     => array(
					'color'   => 'light',
					'shadow'  => true,
					'rounded' => false,
					'style'   => '',
				),
				'tip_position'  => array(
					'my' => 'top left',
					'at' => 'bottom right',
				),
				'tip_effect'    => array(
					'show' => array(
						'effect'   => 'slide',
						'duration' => '500',
						'event'    => 'mouseover',
					),
					'hide' => array(
						'effect'   => 'slide',
						'duration' => '500',
						'event'    => 'click mouseleave',
					),
				),
			),
			'ajax_save' => false,
			'use_cdn'   => true,
		);
	}

}
