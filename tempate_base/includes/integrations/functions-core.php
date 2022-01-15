<?php
/*	Post ID
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'matebook_page_id' ) ) {
	function matebook_page_id() {
		$object_id = get_queried_object_id();

		$post_id = false;

		if ( get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) && is_home() ) {
			$post_id = get_option( 'page_for_posts' );
		} else {
			// Use the $object_id if available.
			if ( isset( $object_id ) ) {
				$post_id = $object_id;
			}
			// If we're not on a singular post, set to false.
			if ( ! is_singular() ) {
				$post_id = false;
			}
			// Front page is the posts page.
			if ( isset( $object_id ) && 'posts' == get_option( 'show_on_front' ) && is_home() ) {
				$post_id = $object_id;
			}
			// The woocommerce shop page.
			if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) ) {
				$post_id = get_option( 'woocommerce_shop_page_id' );
			}
		}

		return $post_id;
	}
}

/*  Is peepso installed
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'matebook_is_peepso_installed' ) ) {
	function matebook_is_peepso_installed() {
		if ( class_exists( 'PeepSo' ) ) {
			return true;
		} else {
			return false;
		}
	}
}

/*  Is shop installed
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'matebook_is_shop_installed' ) ) {
	function matebook_is_shop_installed() {
		global $woocommerce;
		if ( isset( $woocommerce ) ) {
			return true;
		} else {
			return false;
		}
	}
}

/*  Is product
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'matebook_is_product' ) ) {
	function matebook_is_product() {
		return is_singular( array( 'product' ) );
	}
}

/*  Get WC page id
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'matebook_wc_get_page_id' ) ) {
	function matebook_wc_get_page_id( $page ) {

		if ( $page == 'pay' || $page == 'thanks' ) {
			_deprecated_argument( __FUNCTION__, '2.1', 'The "pay" and "thanks" pages are no-longer used - an endpoint is added to the checkout instead. To get a valid link use the WC_Order::get_checkout_payment_url() or WC_Order::get_checkout_order_received_url() methods instead.' );

			$page = 'checkout';
		}
		if ( $page == 'change_password' || $page == 'edit_address' || $page == 'lost_password' ) {
			_deprecated_argument( __FUNCTION__, '2.1', 'The "change_password", "edit_address" and "lost_password" pages are no-longer used - an endpoint is added to the my-account instead. To get a valid link use the wc_customer_edit_account_url() function instead.' );

			$page = 'myaccount';
		}

		$page = apply_filters( 'woocommerce_get_' . $page . '_page_id', get_option( 'woocommerce_' . $page . '_page_id' ) );

		return $page ? absint( $page ) : - 1;
	}
}

/*  Is shop
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'matebook_is_shop_archive' ) ) {
	function matebook_is_shop_archive() {
		return is_post_type_archive( 'product' );
	}
}

/*  Is product tax
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'matebook_is_product_tax' ) ) {
	function matebook_is_product_tax() {
		return is_tax( get_object_taxonomies( 'product' ) );
	}
}

/*  Is product category
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'matebook_is_product_category' ) ) {
	function matebook_is_product_category( $term = '' ) {
		return is_tax( 'product_cat', $term );
	}
}

/*  Is product tag
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'matebook_is_product_tag' ) ) {
	function matebook_is_product_tag( $term = '' ) {
		return is_tax( 'product_tag', $term );
	}
}

function matebook_strposa($haystack, $needles=array(), $offset=0) {
	$chr = array();
	foreach($needles as $needle) {
		$res = strpos($haystack, $needle, $offset);
		if ($res !== false) $chr[$needle] = $res;
	}
	if(empty($chr)) return false;
	return min($chr);
}

/*	Oembed html filter
/* ---------------------------------------------------------------------- */

if ( !function_exists('matebook_oembed_html') ) {

	function matebook_oembed_html($return) {

		$findme = array('twitter.com', 'instagram.com', 'facebook.com');

		if ( matebook_strposa($return, $findme) ) {
			return $return;
		}

		return '<div class="responsive-iframe">' . $return . '</div>';
	}
	add_filter('embed_oembed_html', 'matebook_oembed_html');
}


/*  Is really woocommerce pages
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'matebook_is_realy_woocommerce_page' ) ) {
	function matebook_is_realy_woocommerce_page( $shop_archive = true ) {

		if ( $shop_archive ) {
			if ( matebook_is_shop_archive() || matebook_is_product_tax() || matebook_is_product() ) {
				return true;
			}
		}

		$woocommerce_keys = array(
			"woocommerce_shop_page_id",
			"woocommerce_terms_page_id",
			"woocommerce_cart_page_id",
			"woocommerce_checkout_page_id",
			"woocommerce_pay_page_id",
			"woocommerce_thanks_page_id",
			"woocommerce_myaccount_page_id",
			"woocommerce_edit_address_page_id",
			"woocommerce_view_order_page_id",
			"woocommerce_change_password_page_id",
			"woocommerce_logout_page_id",
			"woocommerce_lost_password_page_id"
		);

		foreach ( $woocommerce_keys as $wc_page_id ) {

			if ( $wc_page_id == 0 ) {
				continue;
			}

			if ( get_the_ID() == get_option( $wc_page_id, 0 ) ) {
				return true;
			}
		}

		return false;
	}
}


/*	Get Site Icon
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'matebook_get_site_icon_url' ) ) {

	function matebook_get_site_icon_url( $size = 512, $url = '' ) {

		global $matebook_settings;

		$site_icon_id = '';
		$favicon_url = mad()->get_option('favicon', get_theme_file_uri('assets/images/favicon.png'));

		if ( isset( $matebook_settings['favicon']['id'] ) ) {
			$site_icon_id = $matebook_settings['favicon']['id'];
		}

		if ( $site_icon_id ) {
			if ( $size >= 512 ) {
				$size_data = 'full';
			} else {
				$size_data = array( $size, $size );
			}

			$url_data = wp_get_attachment_image_src( $site_icon_id, $size_data );
			if ( $url_data ) {
				$url = $url_data[0];
			}
		} elseif ( $favicon_url ) {
			return $favicon_url;
		}

		return $url;
	}
}

/*	Site Icon
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'matebook_wp_site_icon' ) ) {

	function matebook_wp_site_icon() {

		if ( ! has_site_icon() ) {

			global $matebook_settings;

			$favicon = $matebook_settings['favicon'];

			if ( ! $favicon ) {
				return;
			}

			$meta_tags = array(
				sprintf( '<link rel="icon" href="%s" sizes="32x32" />', esc_url( matebook_get_site_icon_url( 32 ) ) ),
				sprintf( '<link rel="icon" href="%s" sizes="192x192" />', esc_url( matebook_get_site_icon_url( 192 ) ) ),
				sprintf( '<link rel="apple-touch-icon-precomposed" href="%s">', esc_url( matebook_get_site_icon_url( 180 ) ) ),
				sprintf( '<meta name="msapplication-TileImage" content="%s">', esc_url( matebook_get_site_icon_url( 270 ) ) ),
			);

			$meta_tags = array_filter( $meta_tags );

			foreach ( $meta_tags as $meta_tag ) {
				echo "$meta_tag\n";
			}

		}

	}
}
add_action( 'wp_head', 'matebook_wp_site_icon', 99 );

/* 	Filter Hook for Comments
/* --------------------------------------------------------------------- */

if ( ! function_exists( 'matebook_output_comments' ) ) {

	function matebook_output_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; ?>

		<li class="comment" id="comment-<?php echo comment_ID() ?>">

		<article>

			<!-- - - - - - - - - - - - - - Avatar - - - - - - - - - - - - - - - - -->

			<div class="gravatar">
				<?php echo get_avatar( $comment, 84, '', esc_html( get_comment_author() ) ); ?>
			</div>

			<!-- - - - - - - - - - - - - - End of avatar - - - - - - - - - - - - - - - - -->

			<!-- - - - - - - - - - - - - - Comment body - - - - - - - - - - - - - - - - -->

			<div class="comment-body">

				<header class="comment-meta">

					<?php
					$author = '<h6 class="comment-author">' . get_comment_author() . '</h6>';
					$link   = get_comment_author_url();
					if ( ! empty( $link ) ) {
						$author = '<h6 class="comment-author"><a href="' . esc_url( $link ) . '">' . $author . '</a></h6>';
					}
					echo sprintf( '%s', $author );
					?>

					<div class="comment-info">
						<div class="entry-meta">

							<?php
							echo sprintf( '<time class="entry-date" datetime="%1$s">%2$s</time>',
								esc_attr( get_the_date( 'c' ) ),
								esc_attr( get_the_date( 'F j, Y, h:i A' ) )
							);
							?>

							<?php
							echo get_comment_reply_link( array_merge(
								array( 'reply_text' => esc_html__( 'Reply', 'matebook' ) ),
								array( 'depth' => $depth, 'max_depth' => $args['max_depth'] )
							) );
							?>
							<?php edit_comment_link( esc_html__( 'Edit', 'matebook' ), '[', ']' ); ?>

						</div><!--/ .entry-meta-->
					</div><!--/ .comment-info-->

				</header><!--/ .comment-meta-->

				<?php comment_text(); ?>

			</div><!--/ .comment-body-->

			<!-- - - - - - - - - - - - - - End of comment body - - - - - - - - - - - - - - - - -->

		</article>

		<?php
	}
}

/* 	Filter Hooks for Respond
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'matebook_comments_form_hook' ) ) {

	function matebook_comments_form_hook( $defaults ) {

		$commenter = wp_get_current_commenter();

		$req           = get_option( 'require_name_email' );
		$aria_req      = ( $req ? " aria-required='true'" : '' );
		$html_req      = ( $req ? " required='required'" : '' );
		$required_text = sprintf( ' ' . esc_html__( 'Required fields are marked %s', 'matebook' ), esc_html__( '(required)', 'matebook' ) );

		$defaults['fields']['author'] = '<p class="comment-form-author"><input id="author" name="author" placeholder="' . esc_attr__( 'Name', 'matebook' ) . ( $req ? '*' : '' ) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $html_req . ' /></p>';

		$defaults['fields']['email'] = '<p class="comment-form-email"><input id="email" name="email" placeholder="' . esc_attr__( 'Email', 'matebook' ) . ( $req ? '*' : '' ) . '" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" ' . $html_req . ' /></p><div class="clear"></div>';

		$defaults['fields']['url'] = '<p class="comment-form-url"><input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'matebook' ) . '" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>';

		$defaults['comment_notes_before'] = '<p class="comment-notes"><span id="email-notes">' . esc_html__( 'Your email address will not be published.', 'matebook' ) . '</span>' . ( $req ? $required_text : '' ) . '</p>';

		$defaults['comment_field'] = '<p class="comment-form-comment"><textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'matebook' ) . ' ' . ( $req ? '*' : '' ) . '" rows="2" required="required"></textarea></p>';


		if ( has_action( 'set_comment_cookies', 'wp_set_comment_cookies' ) && get_option( 'show_comments_cookies_opt_in' ) ) {
			$consent                       = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
			$defaults['fields']['cookies'] = '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' .
			                                 '<label for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'matebook' ) . '</label></p>';
		}

		$defaults['cancel_reply_link'] = ' - ' . esc_html__( 'Cancel reply', 'matebook' );
		$defaults['class_submit']      = '';
		$defaults['label_submit']      = esc_html__( 'Submit', 'matebook' );
		$defaults['submit_field']      = '<p class="form-submit">%1$s %2$s</p>';

		return $defaults;
	}

	add_filter( 'comment_form_defaults', 'matebook_comments_form_hook' );

}

/**
 * Get the list of registered sidebars
 *
 */
if ( ! function_exists( 'matebook_get_registered_sidebars' ) ):
	function matebook_get_registered_sidebars( $sidebars = [], $footer = false, $exclude = [] ) {

		global $wp_registered_sidebars;

		foreach ( $wp_registered_sidebars as $id => $sidebar ) {

			if ( $footer == true ) {
				if ( strpos( $id, 'footer' ) !== false ) {
					$sidebars[ $id ] = $sidebar['name'];
				}
			} else {
				if ( strpos( $id, 'footer' ) === false ) {

					$sidebars[ $id ] = $sidebar['name'];
				}
			}
		}

		$sidebars = apply_filters( 'matebook_modify_sidebars_list', $sidebars );

		return $sidebars;

	}
endif;

if ( ! function_exists( 'matebook_site_title_or_logo' ) ) {
	function matebook_site_title_or_logo( $echo = true ) {

		$logo = mad()->get_option('logo', get_theme_file_uri('assets/images/logo.png'));
		$logo_hidpi = mad()->get_option('logo_hidpi', get_theme_file_uri( 'assets/images/logo@2x.png' ));

		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {

			$html = get_custom_logo();

		} elseif ( $logo ) {

			$html = '<a class="logo" href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
			$html .= '<img class="standard-logo" src="' . esc_url(str_replace( array( 'http:', 'https:' ), '', $logo)) . '" srcset="'. esc_url( str_replace( array( 'http:', 'https:' ), '', $logo_hidpi ) ) .' 2x" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" />';
			$html .= '</a>';

		} else {

			$html = '<h4 class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></h4>';

			if ( '' !== get_bloginfo( 'description' ) ) {
				$html .= '<p class="site-description">' . esc_html( get_bloginfo( 'description', 'display' ) ) . '</p>';
			}
		}

		if ( ! $echo ) {
			return apply_filters( 'matebook_logo', $html );
		}

		echo apply_filters( 'matebook_logo', $html );

	}
}

if ( ! function_exists( 'matebook_main_navigation' ) ) {
	function matebook_main_navigation( $theme_location = 'primary', $menu_class = '' ) {

		if ( is_array( $menu_class ) ) {
			$menu_class = implode( " ", $menu_class );
		}

		$defaults = [
			'container'      => 'ul',
			'menu_class'     => $menu_class,
			'theme_location' => $theme_location,
			'fallback_cb'    => false
		];


		if ( has_nav_menu( $theme_location ) ) {
			wp_nav_menu( $defaults );
		} else {
			echo '<ul id="menu" class="clearfix">';
			wp_list_pages( 'title_li=' );
			echo '</ul>';
		}

	}

}

if ( ! function_exists( 'matebook_mobile_menu' ) ) {
	function matebook_mobile_menu( $args = array() ) {
		ob_start();

		$defaults = array(
			'container'      => '',
			'menu_class'     => 'menu__level',
			'theme_location' => 'primary',
			'fallback_cb'    => false,
			'before'         => '',
			'after'          => '',
			'link_before'    => '',
			'link_after'     => '',
			'depth'          => 1
		);

		$args = wp_parse_args( $args, $defaults );

		if ( has_nav_menu( 'primary' ) ) {
			matebook_wp_nav_menu( $args );
		} else {
			echo '<ul class="mobile-advanced">';
			wp_list_pages( 'title_li=' );
			echo '</ul>';
		}

		$output = str_replace( '&nbsp;', '', ob_get_clean() );

		return apply_filters( 'matebook_mobile_menu', $output );
	}
}

if ( ! function_exists( 'matebook_comments_link' ) ) :

	function matebook_comments_link( $id = false, $comments_without_text = false, $echo = false, $zero = false, $one = false, $more = false, $css_class = 'entry-comments-link' ) {
		$number = get_comments_number( $id );

		if ( post_password_required() ) {
			esc_html_e( 'Enter your password to view comments.', 'matebook' );

			return;
		}

		$output = '<div class="entry-comments"><i class="licon-bubble"></i><a href="';
		$output .= apply_filters( 'matebook_respond_link', get_permalink( $id ) . '#respond', $id );
		$output .= '"';

		if ( ! empty( $css_class ) ) {
			$output .= ' class="' . $css_class . '" ';
		}

		$output .= '>';

		if ( false === $more ) {

			if ( $comments_without_text ) {
				$output .= sprintf( '%s', number_format_i18n( $number ) );
			} else {
				$output .= sprintf( _n( '%s Comment', '%s Comments', $number, 'matebook' ), number_format_i18n( $number ) );
			}

		} else {
			// % Comments
			/* translators: If comment number in your language requires declension,
			 * translate this to 'on'. Do not translate into your own language.
			 */
			if ( 'on' === _x( 'off', 'Comment number declension: on or off', 'matebook' ) ) {
				$text = preg_replace( '#<span class="screen-reader-text">.+?</span>#', '', $more );
				$text = preg_replace( '/&.+?;/', '', $text ); // Kill entities
				$text = trim( strip_tags( $text ), '% ' );

				// Replace '% Comments' with a proper plural form
				if ( $text && ! preg_match( '/[0-9]+/', $text ) && false !== strpos( $more, '%' ) ) {
					/* translators: %s: number of comments */
					$new_text = _n( '%s Comment', '%s Comments', $number, 'matebook' );
					$new_text = trim( sprintf( $new_text, '' ) );

					$more = str_replace( $text, $new_text, $more );
					if ( false === strpos( $more, '%' ) ) {
						$more = '% ' . $more;
					}
				}
			}

			$output .= str_replace( '%', number_format_i18n( $number ), $more );
		}

		$output .= '</a></div>';

		if ( $echo ) {
			echo wp_kses( $output, 'default' );
		} else {
			return $output;
		}

	}
endif;

/* 	Pagination
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'matebook_paging_nav' ) ) {
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function matebook_paging_nav() {

		$args = array(
			'screen_reader_text' => '',
			'type'               => 'list',
			'next_text'          => '',
			'prev_text'          => '',
		);

		the_posts_pagination( $args );
	}
}

if ( ! function_exists( 'matebook_read_more_link' ) ) :
	function matebook_read_more_link($post = null) {
		$link = get_permalink();

		if ( $post !== null ) {
			$link = get_permalink($post);
		}

		return '<a class="more-link" href="' . $link . '">'. esc_html__('Continue Reading', 'matebook') .'</a>';
	}
endif;

/**
 * Get post meta
 */
if ( ! function_exists( 'matebook_blog_post_meta' ) ) :

	function matebook_blog_post_meta( $post_id = null ) {

		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		$post = get_post($post_id);

		$meta_data = array_keys( array_filter( mad()->get_option( 'lay_grid_meta' ) ) );

		$output = '';

		if ( ! empty( $meta_data ) ) {

			foreach ( $meta_data as $mkey ) {

				$meta = '';

				switch ( $mkey ) {
					case 'date':

						$time_string = sprintf( '<time datetime="%1$s">%2$s</time>',
							get_the_date( DATE_W3C, $post ),
							get_the_date('', $post)
						);
						$meta        = sprintf( '%1$s', $time_string );

						break;
					case 'category':

						$meta = get_the_category_list( ',&nbsp;', ' ', $post );

						break;
					case 'author':

						$post_author = $post->post_author;

						$meta = sprintf( '<div class="entry-author"><span><a href="%1$s">%2$s</a></span></div>',
							get_author_posts_url( get_the_author_meta( 'ID', $post_author ) ),
							ucfirst( get_the_author_meta( 'user_nicename', $post_author ) )
						);

						break;
					case 'comments':

						$meta = matebook_comments_link( $post_id, true );

						break;
				}

				if ( ! empty( $meta ) ) {
					$output .= '<div class="meta-item meta-' . $mkey . '">' . $meta . '</div>';
				}
			}
		}

		return $output;
	}
endif;

if ( ! function_exists( 'matebook_post_date' ) ) {
	function matebook_post_date() {
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				?>
				<span datetime="<?php esc_attr( get_the_date( 'c' ) ); ?>"><?php echo get_the_date(); ?></span>
				<span class="updated" datetime="<?php esc_attr( get_the_modified_date( 'c' ) ); ?>">
				  (<?php esc_html_e( 'updated', 'matebook' ); ?> <?php echo get_the_modified_date(); ?>)
				</span>
				<?php

			} else {
				?>
				<span datetime="<?php esc_attr( get_the_date( 'c' ) ); ?>"><?php echo get_the_date(); ?></span>
				<?php
			}
		}
	}
}

/**
 * Detect WordPress template
 *
 */

if ( ! function_exists( 'matebook_detect_template' ) ):
	function matebook_detect_template() {

		if ( is_single() ) {

			$type = get_post_type();

			if ( in_array( $type, array( 'product' ) ) ) {
				$template = $type;
			} else {
				$template = 'single';
			}

		} else if ( is_page() ) {
			$template = 'page';
		} else if ( is_category() ) {
			$template = 'category';
		} else if ( is_tag() ) {
			$template = 'tag';
		} else if ( is_search() ) {
			$template = 'archive';
		} else if ( is_author() ) {
			$template = 'author';
		} else if ( is_tax( 'series' ) ) {
			$template = 'series';
		} else if ( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) || is_post_type_archive( 'product' ) ) {
			$template = 'product_archive';
		} else if ( is_archive() ) {
			$template = 'archive';
		} else {
			$template = 'archive';
		}

		return $template;
	}
endif;

/*	Tag Archive Page
/* ---------------------------------------------------------------------- */

add_action( 'pre_get_posts', 'matebook_pre_get_posts' );

if ( ! function_exists( 'matebook_pre_get_posts' ) ):
	function matebook_pre_get_posts( $query ) {

		if ( ! is_admin() && $query->is_main_query() ) {

			$template = matebook_detect_template();
			$ppp      = mad()->get_option( $template . '_ppp' );

			if ( $ppp == 'custom' ) {
				$ppp_num = absint( mad()->get_option( $template . '_ppp_num' ) );
				$query->set( 'posts_per_page', $ppp_num );
			}

		}

	}
endif;

/**
 * Get archive title
 */
if ( ! function_exists( 'matebook_the_archive_title' ) ):
	function matebook_the_archive_title( $before = '', $after = '' ) {

		$title = matebook_get_the_archive_title();

		if ( ! empty( $title ) ) {
			echo sprintf('%s %s %s', $before, $title, $after);
		}
	}
endif;

/**
 * Retrieve the archive title based on the queried object.
 *
 * @return string Archive title.
 */
function matebook_get_the_archive_title() {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_year() ) {
		$title = get_the_date( 'Y' );
	} elseif ( is_month() ) {
		$title = get_the_date( 'F Y' );
	} elseif ( is_day() ) {
		$title = get_the_date( 'F j, Y' );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title', 'matebook' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title', 'matebook' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title', 'matebook' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title', 'matebook' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title', 'matebook' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title', 'matebook' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title', 'matebook' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title', 'matebook' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title', 'matebook' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$tax   = get_taxonomy( get_queried_object()->taxonomy );
		$title = sprintf( __( '%1$s: %2$s', 'matebook' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = esc_html__( 'Archives', 'matebook' );
	}

	return apply_filters( 'matebook_get_the_archive_title', $title );
}


function matebook_peepso_current_url_segment( $segment ) {

	if ( $segment == 'friends'
	     || $segment == 'media'
	     || $segment == 'about'
		 || $segment == 'groups'
	) {
		return false;
	}

	return true;
}

function matebook_author_info_box() {

	global $post; ?>

	<?php if ( is_singular( 'post' ) && isset( $post->post_author ) ):

		$display_name = get_the_author_meta( 'display_name', $post->post_author );

		if ( empty( $display_name ) ) {
			$display_name = get_the_author_meta( 'nickname', $post->post_author );
		}

		$user_description = get_the_author_meta( 'user_description', $post->post_author );
		$user_posts       = get_author_posts_url( get_the_author_meta( 'ID', $post->post_author ) );
		?>

		<div class="author-bio-section">

			<?php if ( ! empty( $display_name ) ): ?>
				<h5 class="author-name"><?php echo esc_html__( 'About the author', 'matebook' ) ?></h5>
			<?php endif; ?>

			<div class="author-body">

				<div class="author-avatar">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), 70 ) ?>
				</div>

				<div class="author-links">
					<a href="<?php echo esc_url( $user_posts ) ?>"><?php echo esc_html( $display_name ) ?></a>
				</div>

			</div>

			<?php if ( ! empty( $user_description ) ): ?>
				<div class="author-details"><?php echo nl2br( $user_description ) ?></div>
			<?php endif; ?>

		</div><!--/ .author-bio-section-->

	<?php endif;

}


add_action("adverts_template_load", "matebook_override_templates");

/**
 * Loads WPAdverts templates from current theme or child-theme directory.
 *
 * By default WPAdverts loads templates from wpadverts/templates directory,
 * this function tries to load files from your current theme 'matebook'
 * directory for example wp-content/themes/twentytwelve/wpadverts.
 *
 * The function will look for templates in three places, if the template will
 * be found in fist one the other places are not being checked.

 * @param string $tpl Absolute path to template file
 * @return string
 */
function matebook_override_templates( $tpl ) {

	$upload_dir = wp_upload_dir();
	$dirs = array();
	// take the custom templates that Joe built
	$dirs[] = $upload_dir["basedir"] . "/wpadverts/";
	// next check in parent theme directory
	$dirs[] = get_template_directory() . "/wpadverts/";
	// if nothing else use default template
	$dirs[] = ADVERTS_PATH . "/templates/";
	// use absolute path in case the full path to the file was passed
	$dirs[] = dirname( $tpl ) . '/';

	$basename = basename( $tpl );

	foreach($dirs as $dir) {
		if( file_exists( $dir . $basename ) ) {
			return $dir . $basename;
		}
	}
}