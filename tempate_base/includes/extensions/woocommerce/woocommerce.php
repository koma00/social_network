<?php

namespace Matebook\Ext\WooCommerce;

if ( ! defined('ABSPATH') ) {
	exit;
}

class WooCommerce {

	use \Matebook\Src\Traits\Instantiatable;

	public function __construct() {

		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		add_action( 'after_setup_theme', array( $this, 'after_setup') );
		add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
		update_option( 'woocommerce_thumbnail_cropping', '1:1' );


		$this->layout = Layout::instance();
		$this->ordering = Ordering::instance();
		$this->new = New_Badge::instance();

        // WooCommerce scripts.
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 30 );
	}

	public function after_setup() {

		add_theme_support( 'woocommerce', apply_filters( 'matebook_woocommerce_args', array(
			'thumbnail_image_width' => 450,
			'gallery_thumbnail_image_width' => 250,
			'single_image_width' => 750,
			'product_grid'          => array(
				'default_columns' => 4,
				'default_rows'    => 4,
				'min_columns'     => 2,
				'max_columns'     => 4,
				'min_rows'        => 1
			)
		) ) );

		add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
			return array(
				'width' => 450,
				'height' => 450,
				'crop' => 1,
			);
		} );

		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		/**
		 * Add 'matebook_woocommerce_setup' action.
		 *
		 */
		do_action( 'matebook_woocommerce_setup' );

	}

    /**
     * Register/deregister WooCommerce scripts.
     *
     * @since 1.7.0
     */
    public function enqueue_scripts() {
	    wp_enqueue_script( 'matebook-woocommerce-mod' );
    }

}
