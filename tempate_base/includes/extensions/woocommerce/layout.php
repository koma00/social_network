<?php

namespace Matebook\Ext\WooCommerce;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Layout {

	use \Matebook\Src\Traits\Instantiatable;

	public function __construct() {
		add_action( 'init', array( $this, 'woocommerce_init' ) );
	}

	public function woocommerce_init() {

		global $matebook_settings;

		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

		remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

		remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open');
		remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');
		remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title');
		remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

		remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
		remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

		/* Archive Hooks */
		add_action( 'woocommerce_get_catalog_ordering_args', [ $this, 'overwrite_catalog_ordering' ] );
		add_action( 'woocommerce_archive_description', [ $this, 'ordering_products' ] );
		add_action( 'woocommerce_after_single_product', 'woocommerce_upsell_display', 15 );
		add_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products', 20 );

		/* Content Product Hooks */
		add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'loop_product_thumbnail' ] );
		add_action( 'woocommerce_shop_loop_item_title', [ $this, 'shop_loop_product_title' ] );
		add_action( 'woocommerce_after_shop_loop_item_title', [ $this, 'after_shop_loop_item_title' ] );

		// Ajax cart fragments.
        add_action( 'woocommerce_add_to_cart_fragments', [ $this, 'cart_fragments' ], 30 );

		if ( $matebook_settings['product-crosssell'] ) {
			add_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 9 );
		}

		add_filter( 'loop_shop_columns', [ $this, 'get_shop_columns' ] );
		add_filter( 'loop_shop_per_page', [ $this, 'loop_per_page' ] );

		add_filter( 'woocommerce_show_page_title', function() { return false; } );
		add_filter( 'woocommerce_pagination_args', [ $this, 'pagination_args' ] );

		add_filter( 'woocommerce_general_settings', [ $this, 'woocommerce_general_settings_filter'] );
		add_filter( 'woocommerce_page_settings', [ $this, 'woocommerce_general_settings_filter'] );
		add_filter( 'woocommerce_catalog_settings', [ $this, 'woocommerce_general_settings_filter'] );
		add_filter( 'woocommerce_inventory_settings', [ $this, 'woocommerce_general_settings_filter'] );
		add_filter( 'woocommerce_shipping_settings', [ $this, 'woocommerce_general_settings_filter'] );
		add_filter( 'woocommerce_tax_settings', [ $this, 'woocommerce_general_settings_filter'] );
		add_filter( 'woocommerce_product_settings', [ $this, 'woocommerce_general_settings_filter'] );

		add_filter( 'woocommerce_upsell_display_args', [ $this, 'upsell_display_args' ] );
		add_filter( 'woocommerce_cross_sells_total', [ $this, 'cross_sells_total' ] );
		add_filter( 'woocommerce_cross_sells_columns', [ $this, 'cross_sells_columns' ] );
		add_filter( 'woocommerce_output_related_products_args', [ $this, 'related_products_args' ] );

		add_filter( 'woocommerce_product_categories_widget_args', [ $this, 'product_cat_widget_args'] );

	}

	function product_cat_widget_args($args) {
		$args['number'] = mad()->get_option( 'product-cat-number-widget-args' );
		return $args;
	}

	function woocommerce_general_settings_filter($options) {
		$delete = [ 'woocommerce_enable_lightbox' ];

		foreach ( $options as $key => $option ) {
			if (isset($option['id']) && in_array($option['id'], $delete)) {
				unset($options[$key]);
			}
		}
		return $options;
	}

	public function loop_product_thumbnail() { ?>

		<figure class="product-image">
			<a href="<?php echo esc_url(get_the_permalink()) ?>">
				<?php echo woocommerce_get_product_thumbnail( 'shop_catalog' ); ?>
			</a>
		</figure>

		<?php
	}

	public function shop_loop_product_title() {
		echo '<h6 class="product-name"><a href="'. esc_url(get_the_permalink()) .'">' . get_the_title() . '</a></h6>';
	}

	public function overwrite_catalog_ordering($args) {

		global $matebook_config;

		$keys = array( 'product_order', 'product_count' );
		if ( empty($matebook_config['woocommerce'])) $matebook_config['woocommerce'] = array();

		foreach ( $keys as $key ) {
			if (isset($_GET[$key]) ) {
				$_SESSION['Matebook_WooCommerce'][$key] = esc_attr($_GET[$key]);
			}
			if ( isset($_SESSION['Matebook_WooCommerce'][$key]) ) {
				$matebook_config['woocommerce'][$key] = $_SESSION['Matebook_WooCommerce'][$key];
			}
		}

		extract( $matebook_config['woocommerce'] );

		if ( isset($product_order) && !empty($product_order) ) {
			switch ( $product_order ) {
				case 'date'  : $orderby = 'date'; $order = 'desc'; $meta_key = '';  break;
				case 'price' : $orderby = 'meta_value_num'; $order = 'asc'; $meta_key = '_price'; break;
				case 'popularity' : $orderby = 'meta_value_num'; $order = 'desc'; $meta_key = 'total_sales'; break;
				case 'title' : $orderby = 'title'; $order = 'asc'; $meta_key = ''; break;
				case 'default':
				default : $orderby = 'menu_order title'; $order = 'asc'; $meta_key = ''; break;
			}
		}

		if ( isset($orderby) ) $args['orderby'] = $orderby;
		if ( isset($order) )   $args['order'] = $order;

		if ( !empty($meta_key) ) {
			$args['meta_key'] = $meta_key;
		}

		return $args;
	}

	public function after_shop_loop_item_title() {
		global $product;

		if ( $price_html = $product->get_price_html() ) {
			echo '<div class="pricing-area">';
			woocommerce_template_loop_price();
			woocommerce_template_loop_rating();
			echo '</div>';
		}
	}

	public function cart_fragments( $fragments ) {

        if ( WC()->cart->get_cart_contents_count() < 1 ) {
            $fragments['.site-header__cart-wrapper .woo-cart-count'] = '<span class="woo-cart-count counter-hidden"></span>';
        } else {
            $fragments['.site-header__cart-wrapper .woo-cart-count'] = sprintf(
                '<span class="woo-cart-count">%s</span>',
                number_format_i18n( WC()->cart->get_cart_contents_count() )
            );
        }

        return $fragments;
    }

	public function get_shop_columns() {
		global $matebook_settings;

		if ( isset($_GET['columns']) ) {
			return absint($_GET['columns']);
		} else {
			return $matebook_settings['product-archive-columns'];
		}

		return $matebook_settings['product-archive-columns'];

	}

	public function loop_per_page() {
		global $matebook_settings;
		return $matebook_settings['product-archive-per-page'];
	}

	public function ordering_products() {
		echo matebook()->woocommerce()->ordering->output();
	}

	public function pagination_args($args) {

		$args['prev_text'] = esc_html__('Previous', 'matebook' );
		$args['next_text'] = esc_html__('Next', 'matebook' );

		return $args;
	}

	public function upsell_display_args($args) {
		global $matebook_settings;

		$args['posts_per_page'] = $matebook_settings['product-upsells-count'];
		$args['columns'] = $matebook_settings['product-upsells-cols'];

		return $args;
	}

	public function cross_sells_total($limit) {
		global $matebook_settings;

		$count_limit = $matebook_settings['product-crosssell-count'];

		if ( $count_limit > 0 )
			return $count_limit;

		return $limit;
	}


	public function cross_sells_columns($columns) {
		global $matebook_settings;

		$count_columns = $matebook_settings['product-crosssell-columns'];

		if ( $count_columns > 0 )
			return $count_columns;

		return $columns;
	}

	public function related_products_args($args) {

		global $matebook_settings;
		$args['posts_per_page'] = $matebook_settings['product-related-count'];
		$args['columns'] = $matebook_settings['product-related-cols'];

		return $args;
	}

}
