<?php

namespace Matebook\Ext\WooCommerce\Requests;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Get_Products {

	public static function get_products( $args, $settings ) {

		// Filter by category
		if ( $settings['select_categories'] ) {
			$args['tax_query'][] = [
				'taxonomy' => 'product_cat',
				'terms'    => $settings['select_categories'],
				'field'    => 'id'
			];
		}

		// Only display the selected listings
		if ( $settings['select_posts'] ) {
			$args['post__in'] = $settings['select_posts'];
		}

		$default = [
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'paged'               => '1',
			'orderby'             => $settings['order_by'],
			'order'               => strtoupper( $settings['order'] ),
			'posts_per_page'      => (int) $settings['posts_per_page']
		];

		$args = wp_parse_args($args, $default);

		$columns = absint( $settings['columns'] );

		$css_classes = [];
		$wrapper_attributes = [];

		if ( $settings['the_template'] == 'grid' ) {
			$css_classes[] = 'products';
			$css_classes[] = 'columns-' . $columns;
		}

		if ( $settings['the_template'] == 'carousel' ) {
			$css_classes[] = 'owl-carousel';
			$wrapper_attributes[] = 'data-max-items="'. esc_attr($columns) .'"';
			$wrapper_attributes[] = 'data-nav="false"';
			$wrapper_attributes[] = 'data-dots="true"';
			$wrapper_attributes[] = 'data-item-margin="30"';
		}

		$wrapper_attributes[] = 'class="'. esc_attr( trim( implode( ' ', array_filter( $css_classes ) ) ) ) . '"';

		$products = new \WP_Query($args);

		ob_start();

		if ( $products->have_posts() ): ?>

			<div class="products-holder">

				<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>
						<?php wc_get_template_part( 'content', 'product' ) ?>
					<?php endwhile ?>

				</div><!--/ .products-->

			</div><!--/ .products-holder-->

			<?php wp_reset_postdata(); ?>

		<?php endif;

		return ob_get_clean();
	}
}
