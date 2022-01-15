<?php

namespace Matebook\Includes;

class Admin {

	use \Matebook\Src\Traits\Instantiatable;

	public function __construct() {

		add_filter( 'rwmb_meta_boxes', [ $this, 'register_meta_boxes' ] );

		add_action( 'admin_init', [ $this, 'admin_init' ] );

		// Enqueue Admin Scripts and Styles.
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ], 30 );

	}

	public function admin_init() {

		if ( current_user_can( 'edit_theme_options' ) )  {

			if ( isset($_GET['theme_settings_export'] ) ) {

				// Widget settings
				$widget_settings = json_encode($this->export_widgets());

				// Sidebar settings
				$sidebar_settings = json_encode($this->export_sidebars());

				// Meta settings
				$meta_settings = json_encode($this->export_metadata());

				echo '<pre>'."\n"; echo '$widget_settings = "'; print_r($widget_settings); echo '";</pre>';
				echo '<pre>'."\n"; echo '$sidebar_settings = "'; print_r($sidebar_settings); echo '";</pre>'."\n\n";
				echo '<pre>'."\n"; echo '$meta_settings = "'; print_r($meta_settings); echo '";</pre>'."\n\n";
				exit();

			}

		}

	}

	public function export_widgets() {

		global $wp_registered_widgets;
		$saved_widgets = $options = array();

		foreach ($wp_registered_widgets as $registered) {
			if ( isset($registered['callback'][0]) && isset($registered['callback'][0]->option_name)) {
				$options[] = $registered['callback'][0]->option_name;
			}
		}

		foreach ($options as $key) {
			$widget = get_option($key, array());
			$treshhold = 1;
			if (array_key_exists("_multiwidget", $widget)) $treshhold = 2;

			if ($treshhold <= count($widget)) {
				$saved_widgets[$key] = $widget;
			}
		}

		$saved_widgets['sidebars_widgets'] = get_option('sidebars_widgets');
		return $saved_widgets;
	}

	function export_sidebars() {
		$custom_sidebars = get_option('matebook_registered_sidebars');

		if ( !empty($custom_sidebars) ) {
			return $custom_sidebars;
		}
		return '';
	}

	public function export_metadata() {
		global $wpdb;

		$meta_settings = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}product_catmeta", ARRAY_A);
		return $meta_settings;
	}

	/**
	 * Enqueue theme assets in wp-admin.
	 *
	 * @since 1.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'matebook-admin-general' );
	}

	public function register_meta_boxes( $meta_boxes ) {

		$prefix = 'mad-';

		$mad_list_menus = array('' => esc_html__('Default', 'matebook'));
		$mad_menu_terms = get_terms(array(
			'taxonomy' => 'nav_menu'
		));
		if ( !empty( $mad_menu_terms ) ) {
			foreach ($mad_menu_terms as $term) {
				$mad_list_menus[$term->term_id] = $term->name;
			}
		}

		// Layout Settings
		$meta_boxes[] = array(
				'id'       => 'layout-settings',
				'title'    => esc_html__( '[Matebook] Page Settings', 'matebook' ),
				'pages'    => array( 'product', 'page', 'post', 'mad_portfolio' ),
				'context'  => 'normal',
				'priority' => 'low',
				'fields'   => array(
					array(
						'type' => 'heading',
						'name' => esc_html__('Layout', 'matebook'),
					),
					array(
						'name'    => esc_html__('Page Title', 'matebook' ),
						'id'      => $prefix . 'page-title',
						'type'    => 'select',
						'std'     => 'inherit',
						'desc'    => esc_html__('Choose show or hide page title', 'matebook' ),
						'options' => array(
							'inherit' => esc_html__('Inherit settings from the theme options', 'matebook' ),
							'show' => esc_html__('Show', 'matebook' ),
							'hide' => esc_html__('Hide', 'matebook' )
						)
					),
					array(
						'type' => 'heading',
						'name' => esc_html__('Sidebar Options', 'matebook'),
					),
					array(
						'name'    => esc_html__('Display Sidebar', 'matebook' ),
						'id'      => $prefix . 'page-sidebar-position',
						'type'    => 'select',
						'std'     => '',
						'desc'    => esc_html__('Choose page sidebar position', 'matebook' ),
						'options' => array(
							'' => esc_html__('Default', 'matebook' ),
							'both' => esc_html__('Both', 'matebook' ),
							'no-sidebar' => esc_html__('Without Sidebar', 'matebook' )
						)
					),
					array(
						'name'    => esc_html__('Select Left Sidebar', 'matebook' ),
						'id'      => $prefix . 'page-left-sidebar',
						'type'    => 'select',
						'std'     => '',
						'desc'    => esc_html__('Choose a left sidebar', 'matebook' ),
						'options' => matebook_get_registered_sidebars([
							'' => esc_html__('Default', 'matebook' )
						])
					),
					array(
						'name'    => esc_html__('Select Right Sidebar', 'matebook' ),
						'id'      => $prefix . 'page-right-sidebar',
						'type'    => 'select',
						'std'     => '',
						'desc'    => esc_html__('Choose a right sidebar', 'matebook' ),
						'options' => matebook_get_registered_sidebars([
							'' => esc_html__('Default', 'matebook' )
						])
					),

		));

		return $meta_boxes;

	}

}
