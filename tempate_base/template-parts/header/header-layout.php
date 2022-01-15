<div class="mad-header-section--sticky <?php if ( mad()->get_option('header-sticky-menu') ): ?>mad-header-section--sticky-xl<?php endif; ?>">

	<div class="site-header-inner <?php if (!mad()->get_option('header-style-search')): ?>has-not-search<?php endif; ?>">

		<div class="site-header-items site-header-item-logo">

			<div class="site-header-item">

				<div class="site-logo">
					<div class="logo-wrap">
						<?php echo matebook_site_title_or_logo(); ?>
					</div>
				</div>

				<div class="site-nav-buttons">
					<button class="site-nav-button" id="site-nav-button"></button>
					<button class="site-search-btn"></button>
				</div>

			</div>

		</div>

		<div class="site-header-items site-header-item-nav">

			<div class="site-menu-holder">
				<nav class="main-navigation">
					<?php echo matebook_main_navigation() ?>
				</nav>
			</div>

		</div>

		<?php if ( mad()->get_option('header-style-search') ): ?>

			<div class="site-header-items site-header-items-big">

				<div class="site-header__search">
					<div class="site-header__search-bar">
						<?php get_search_form(); ?>
					</div>
					<button class="site-close-search-form"></button>
				</div>

			</div>

		<?php endif; ?>

		<div class="site-header-items site-header-item-cart">

			<?php if ( mad()->get_option('header-style-widgets') ) : ?>

				<?php if ( class_exists('PeepSo') ) {
					the_widget( 'PeepSoWidgetUserBar', array(
						'guest_behavior' => 'hide',
						'content_position' => 'left',
						'show_notifications' => 1,
						'show_usermenu' => 1,
						'show_name' => 1,
						'show_logout' => 0,
						'show_avatar' => 1
					) );
				} ?>

			<?php endif; ?>

			<?php if ( mad()->get_option('header-style-cart') ) : ?>

				<?php if ( class_exists('WooCommerce') ): ?>

					<?php $cart_count = WC()->cart->get_cart_contents_count(); ?>

					<div class="site-header__cart-wrapper">
						<a href="javascript:void(0)" class="site-header__cart-toggle">
							<i class="material-icons-outlined">shopping_cart</i>

							<span class="woo-cart-count <?php echo esc_attr($cart_count) < 1 ? 'counter-hidden' : '' ?>">
								<?php echo number_format_i18n( $cart_count ) ?>
							</span>
						</a>
						<div class="shopping-cart">
							<div class="widget_shopping_cart_content"></div>
						</div>
					</div>

				<?php endif; ?>

			<?php endif; ?>

		</div>

	</div><!--/ .site-header-inner-->

</div><!--/ .site-header-section-->

