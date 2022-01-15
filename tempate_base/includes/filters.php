<?php

namespace Matebook\Includes;

class Filters {

	use \Matebook\Src\Traits\Instantiatable;

	protected $actions = [
		'wp',
		'wp_body_open',
		'matebook_header_after'
	];

	protected $filters = [
		'matebook_content_classes',
		'body_class',
	];

	public function __construct() {
		$this->add_actions();
		$this->add_filters();
	}

	/*
	 * Register Filters.
	 */
	public function add_filters() {
		foreach ( $this->filters as $callback => $filter ) {
			$callback      = ! is_numeric( $callback ) ? $callback : $filter;
			$priority      = 10;
			$accepted_args = 1;

			if ( is_array( $filter ) ) {
				$_filter = $filter;

				$filter        = $_filter['filter'];
				$callback      = $_filter['callback'];
				$priority      = $_filter['priority'];
				$accepted_args = $_filter['accepted_args'];
			}

			add_filter( $filter, array( $this, "filter_{$callback}" ), $priority, $accepted_args );
		}
	}

	/*
	 * Register Actions.
	 */
	public function add_actions() {
		foreach ( $this->actions as $callback => $action ) {
			$callback = ! is_numeric( $callback ) ? $callback : $action;
			add_action( $action, [ $this, "action_{$callback}" ] );
		}
	}

	public function action_wp() {
		global $matebook_config;

		$header_classes    = [ 'site-header' ];
		$header_attributes = [];

		$header_classes[] = 'style-1';

		$header_attributes[] = 'class="' . implode( ' ', array_values( $header_classes ) ) . '"';

		$matebook_config['header_attributes'] = $header_attributes;

		$this->check_page_layout();
	}

	public function filter_body_class( $classes ) {

		global $matebook_config;

		if ( is_singular( 'post' ) ) {

			if ( '' !== get_the_post_thumbnail() ) {
				$classes[] = 'mad-single-has-post-thumbnail';
			}

			$classes[] = 'entry-single-post';
		}

		$classes[] = $matebook_config['sidebar_position'];

		return $classes;
	}

	public function filter_matebook_content_classes( $classes ) {

		global $matebook_config;

		$classes[] = $matebook_config['sidebar_position'];
		$classes[] = implode(' ', $matebook_config['has_sidebars']);


		return implode( ' ', $classes );
	}

	public function check_page_layout() {
		global $matebook_config;

		$sidebar_position = 'both';
		$defaults = array('sidebar-left', 'sidebar-right');
		$sidebars = array();
		$has_sidebars = array();

		if ( is_archive() || is_search() || is_front_page() || is_attachment() ) {

			$sidebar_position = mad()->get_option( 'archive_use_sidebar' );

			if ( $sidebar_position == 'both' ) {

				$sidebar_left = mad()->get_option( 'archive_left_sidebar', 'sidebar-left');
				$sidebar_right = mad()->get_option( 'archive_right_sidebar', 'sidebar-right');

				if ( ! empty( $sidebar_left ) ) {
					if ( is_active_sidebar($sidebar_left) ) {
						$sidebars[0] = $sidebar_left;
						$has_sidebars[] = 'has-sidebar--left';
					}
				}

				if ( ! empty( $sidebar_right ) ) {
					if ( is_active_sidebar($sidebar_right) ) {
						$sidebars[1] = $sidebar_right;
						$has_sidebars[] = 'has-sidebar--right';
					}
				}
			}

			if ( empty($sidebars) && $sidebar_position == 'both' ) {
				$sidebar_position = 'no-sidebar';
			}
		}

		if ( is_404() || is_author() ) {
			$sidebar_position = 'no-sidebar';
		}

		if ( is_singular( [ 'page' ] ) ) {

			$sidebar_position = mad()->get_option( 'page_use_sidebar', 'no-sidebar', array(
				'overriden_by' => 'mad-page-sidebar-position'
			) );

			if ( $sidebar_position == 'both' ) {

				$sidebar_left = mad()->get_option( 'page_left_sidebar', 'sidebar-left', array(
					'overriden_by' => 'mad-page-left-sidebar'
				) );

				$sidebar_right = mad()->get_option( 'page_right_sidebar', 'sidebar-right', array(
					'overriden_by' => 'mad-page-right-sidebar'
				) );

				if ( ! empty( $sidebar_left ) ) {
					if ( is_active_sidebar($sidebar_left) ) {
						$sidebars[0] = $sidebar_left;
						$has_sidebars[] = 'has-sidebar--left';
					}
				}

				if ( ! empty( $sidebar_right ) ) {
					if ( is_active_sidebar($sidebar_right) ) {
						$sidebars[1] = $sidebar_right;
						$has_sidebars[] = 'has-sidebar--right';
					}
				}
			}

			if ( empty($sidebars) && $sidebar_position == 'both' ) {
				$sidebar_position = 'no-sidebar';
			}

		}

		if ( is_singular( ['post'] ) ) {

			$sidebar_position = mad()->get_option( 'post_use_sidebar', 'both', array(
				'overriden_by' => 'mad-page-sidebar-position'
			) );

			if ( $sidebar_position == 'both' ) {

				$sidebar_left = mad()->get_option( 'post_left_sidebar', 'sidebar-left', array(
					'overriden_by' => 'mad-page-left-sidebar'
				) );

				$sidebar_right = mad()->get_option( 'post_right_sidebar', 'sidebar-right', array(
					'overriden_by' => 'mad-page-right-sidebar'
				) );

				if ( ! empty( $sidebar_left ) ) {
					if ( is_active_sidebar($sidebar_left) ) {
						$sidebars[0] = $sidebar_left;
						$has_sidebars[] = 'has-sidebar--left';
					}
				}

				if ( ! empty( $sidebar_right ) ) {
					if ( is_active_sidebar($sidebar_right) ) {
						$sidebars[1] = $sidebar_right;
						$has_sidebars[] = 'has-sidebar--right';
					}
				}

			}

			if ( empty($sidebars) && $sidebar_position == 'both' ) {
				$sidebar_position = 'no-sidebar';
			}

		}

		if ( matebook_is_peepso_installed() ) {
			$PeepSoUrlSegments = \PeepSoUrlSegments::get_instance();
			$current = $PeepSoUrlSegments->get(2) ? $PeepSoUrlSegments->get(2) : '';

			if ( !empty($current) ) {

				$sidebar_position = 'both';

			}
		}

		if ( matebook_is_shop_installed() ) {

			if (is_post_type_archive( 'product' )
			    || is_cart()
			    || is_checkout()
				|| matebook_is_realy_woocommerce_page( false )
			    || matebook_is_product_category()
			    || matebook_is_product_tax()
				|| matebook_is_product()
			) {

				if ( is_post_type_archive( 'product' ) || is_cart() || is_checkout() ) {
					$sidebar_position = mad()->get_option( 'product_use_sidebar' );
				}

				if ( matebook_is_realy_woocommerce_page( false ) || matebook_is_product_category() || matebook_is_product_tax() ) {
					$sidebar_position = mad()->get_option( 'product_archive_use_sidebar' );
				}

				if ( matebook_is_product() ) {
					$sidebar_position = mad()->get_option( 'product_single_use_sidebar' );
				}

				if ( $sidebar_position == 'both' ) {

					$sidebar_left = mad()->get_option( 'product_left_sidebar', 'sidebar-left', array(
						'overriden_by' => 'mad-page-left-sidebar'
					) );

					$sidebar_right = mad()->get_option( 'product_right_sidebar', 'sidebar-right', array(
						'overriden_by' => 'mad-page-right-sidebar'
					) );

					if ( ! empty( $sidebar_left ) ) {
						if ( is_active_sidebar($sidebar_left) ) {
							$sidebars[0] = $sidebar_left;
							$has_sidebars[] = 'has-sidebar--left';
						}
					}

					if ( ! empty( $sidebar_right ) ) {
						if ( is_active_sidebar($sidebar_right) ) {
							$sidebars[1] = $sidebar_right;
							$has_sidebars[] = 'has-sidebar--right';
						}
					}

				}

				if ( empty($sidebars) && $sidebar_position == 'both' ) {
					$sidebar_position = 'no-sidebar';
				}

			}

		}

		if ( ! $sidebar_position ) {
			$sidebar_position = 'both';
		}

		if ( $sidebar_position ) {
			$matebook_config['sidebar_position'] = $sidebar_position;
		}

		$matebook_config['has_sidebars'] = $has_sidebars;

		if ( $sidebars ) {
			$matebook_config['sidebars'] = $sidebars;
		} else {
			$matebook_config['sidebars'] = $defaults;
		}

	}

	public function action_matebook_header_after() {

		$pageTitle = mad()->get_option('page-title', 'show', [
			'overriden_by' => 'mad-page-title'
		] );

		if ( is_singular(array('page', 'post')) && $pageTitle == 'show' ) {
			get_template_part( 'template-parts/page', 'title' );
		}

	}

	/**
	 * Add icon list as svg after <body> tag and hide it
	 */
	public function action_wp_body_open() {
		if ( mad()->get_option('show-loading-overlay') ) {
			echo '<div class="mad-preloader"></div>';
		}
	}

}