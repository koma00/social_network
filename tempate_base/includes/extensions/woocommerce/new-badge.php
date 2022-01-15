<?php
/**
 * New Badge class
 **/

namespace Matebook\Ext\WooCommerce;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class New_Badge {

	use \Matebook\Src\Traits\Instantiatable;

	public $settings = array();

	public function __construct() {

		add_filter( 'post_class', array( $this, 'wc_new_product_post_class' ), 22, 3 );

		// Init settings
		$this->settings = array(
			array(
				'name' => esc_html__( 'New Badge', 'matebook' ),
				'type' => 'title',
				'id'   => 'wc_nb_options'
			),
			array(
				'name'    => esc_html__( 'Enable label new', 'matebook' ),
				'desc'    => esc_html__( 'Visible label new in products', 'matebook' ),
				'id'      => 'wc_nb_label_new',
				'default' => 'no',
				'type'    => 'checkbox'
			),
			array(
				'name' => esc_html__( 'Product Newness', 'matebook' ),
				'desc' => esc_html__( "Display the 'New' flash for how many days?", 'matebook' ),
				'id'   => 'wc_nb_newness',
				'type' => 'number',
			),
			array( 'type' => 'sectionend', 'id' => 'wc_nb_options' ),
		);

		// Default options
		add_option( 'wc_nb_label_new', 'yes' );
		add_option( 'wc_nb_newness', '1000' );

		// Admin
		add_action( 'woocommerce_settings_general_options_after', array( &$this, 'admin_settings' ) );
		add_action( 'woocommerce_update_options_general', array( &$this, 'save_admin_settings' ) );
	}

	/*-----------------------------------------------------------------------------------*/
	/* Class Functions */
	/*-----------------------------------------------------------------------------------*/

	// Load the settings
	function admin_settings() {
		woocommerce_admin_fields( $this->settings );
	}

	// Save the settings
	function save_admin_settings() {
		woocommerce_update_options( $this->settings );
	}

	/*-----------------------------------------------------------------------------------*/
	/* Filter Functions */
	/*-----------------------------------------------------------------------------------*/

	function wc_new_product_post_class( $classes, $class = '', $post_id = '' ) {

		if ( ! $post_id || 'product' !== get_post_type( $post_id ) ) {
			return $classes;
		}

		$product = wc_get_product( $post_id );

		if ( $product ) {

			$postdate      = get_the_time( 'Y-m-d' );            // Post date
			$postdatestamp = strtotime( $postdate );            // Timestamped post date
			$newness       = get_option( 'wc_nb_newness' );    // Newness in days as defined by option

			if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ) { // If the product was published within the newness time frame display the new badge
				$classes[] = 'new-badge';
			}

		}

		return $classes;
	}

	/*-----------------------------------------------------------------------------------*/
	/* Frontend Functions */
	/*-----------------------------------------------------------------------------------*/

	// Display the new badge
	public static function show_product_loop_new_badge($post_id) {
		$postdate      = get_the_time( 'Y-m-d', $post_id );            // Post date
		$postdatestamp = strtotime( $postdate );            // Timestamped post date
		$newness       = get_option( 'wc_nb_newness' );    // Newness in days as defined by option
		$visible       = get_option( 'wc_nb_label_new' );

		if ( $visible == 'no' ) {
			return;
		}

		if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ) { // If the product was published within the newness time frame display the new badge
			echo '<span class="new-badge">' . esc_html__( 'New', 'matebook' ) . '</span>';
		}
	}
}