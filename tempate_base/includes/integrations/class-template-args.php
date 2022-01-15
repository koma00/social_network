<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! class_exists( 'Matebook_Template_Args' ) ) {

	class Matebook_Template_Args {

		public static function footer() {
			$post_id = get_the_ID();
			global $matebook_settings;

			$parts = array(
				'main' => 'main-footer-widget-area',
			);

			$sidebars = array();

			foreach ( $parts as $part => $default ) {
				$sidebar = get_post_meta( $post_id, 'mad-show_custom_footer_' . $part, true );

				if ( $sidebar !== 'disable' ) {
					$custom = get_post_meta( $post_id, 'mad-custom_footer_' . $part, true );

					if ( $sidebar == 'custom' && ! empty( $custom ) ) {
						$sidebars[ $part ] = $custom;
					} else {

						if ( $matebook_settings["footer-show-{$part}"] ) {
							$sidebars[ $part ] = $default;
						}
					}
				}
			}

			$main_top_css = $main_css = $main_top_row_css = '';

			$main = isset( $sidebars['main'] ) &&
			        is_active_sidebar( $sidebars['main'] ) ?
					$sidebars['main'] :
					false;

			if ( $main ) {
				$main_top_css     = $main;
				$main_top_row_css = 'flex-row justify-content-between';
			}

			return array(
				'main'          => $main,
				'main_top_css'  => $main_top_css,
				'main_css'      => $main_css,
				'main_row_css'  => $main_top_row_css
			);
		}

	}

	new Matebook_Template_Args();

}