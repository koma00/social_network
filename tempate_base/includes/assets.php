<?php

namespace Matebook\Includes;

class Assets {

	use \Matebook\Src\Traits\Instantiatable;

	protected $google_fonts = [
		'Mulish' =>array('300', '300i', '400', '400i', '500', '500i', '600', '600i', '700', '700i', '800', '800i', '900', '900i')
	];

	/**
	 * Contains default charsets for the fonts of the theme.
	 *
	 * @access protected
	 * @var array
	 */
	protected $google_fonts_charsets = array( 'latin', 'latin-ext' );

	public function __construct() {
		// register scripts and styles
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts' ] );

		// enqueue assets
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 11 );
		add_action( 'wp_head', [ $this, 'print_head_content' ] );
		add_action( 'admin_head', [ $this, 'print_head_content' ] );
	}

	public function register_scripts() {
		$suffix = is_rtl() ? '-rtl' : '';

		wp_register_style( 'owl-carousel', mad()->template_uri( 'assets/vendor/owl-carousel/owl.carousel.css' ), [], MATEBOOK_THEME_VERSION );
		wp_register_script( 'owl-carousel', mad()->template_uri( 'assets/vendor/owl-carousel/owl.carousel.min.js' ), [], MATEBOOK_THEME_VERSION, true );

		// admin styles
        wp_register_style( 'matebook-admin-general', mad()->template_uri( 'assets/dist/admin/admin.css' ), [], MATEBOOK_THEME_VERSION );

		if ( class_exists('WooCommerce') ) {
			wp_register_script( 'matebook-woocommerce-mod', mad()->template_uri( 'assets/dist/frontend/woocommerce' . ( WP_DEBUG ? '' : '.min' ) . '.js' ), [], MATEBOOK_THEME_VERSION, true );
		}

	}

    /**
     * Load WP Editor custom styles.
     *
     * @since 1.0
     */
	public function add_editor_style( $stylesheet ) {
		// for backend editors
		if ( is_admin() ) {
			return add_editor_style( $stylesheet );
		}

	    global $editor_styles;
	    $stylesheet = (array) $stylesheet;
	    if ( is_rtl() ) {
	        $stylesheet[] = str_replace( '.css', '-rtl.css', $stylesheet[0] );
	    }

	    $editor_styles = array_merge( (array) $editor_styles, $stylesheet );
	}

	/**
     * Enqueue theme scripts.
     *
     * @since 1.0.0
	 */
	public function enqueue_scripts() {

		global $matebook_settings;

		// Load Google Fonts
		$elements = array( 'body', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'menu', 'sub-menu');

		foreach( $elements as $element ) {

			$option_name = sprintf('%s-font', $element);

			if ( isset($matebook_settings[$option_name]['google']) && $matebook_settings[$option_name]['google'] !== 'false' ) {

				$font_data = $matebook_settings[$option_name];
				$font = $matebook_settings[$option_name]['font-family'];

				if ( !isset($this->google_fonts[$font]) ) {
					$this->google_fonts[$font] = [];
				}

				$font_weight = isset($font_data['font-weight']) ? $font_data['font-weight'] : '400';
				$font_style = isset($font_data['font-style']) && $font_data['font-style'] == 'i' ? 'i' : '';
				$font_weight_final = $font_weight . $font_style;

				if ( !in_array($font_weight_final, $this->google_fonts[$font]) ) {
					$this->google_fonts[$font][] = $font_weight_final;
				}
			}

		}

		$scripts_deps = array( 'jquery' );

		$fonts_charsets_state = is_array($matebook_settings) && isset($matebook_settings['select-google-charset']) && $matebook_settings['select-google-charset'];
		$fonts_charsets = boolval($fonts_charsets_state) && isset($matebook_settings['google-charsets']) && !empty($matebook_settings['google-charsets']) ? $matebook_settings['google-charsets'] : $this->google_fonts_charsets;

		wp_enqueue_style('matebook-google-fonts', $this->google_fonts_url($this->google_fonts, $fonts_charsets), [], MATEBOOK_THEME_VERSION );
		wp_enqueue_style('matebook-google-icons', $this->google_fonts_icons(), [], MATEBOOK_THEME_VERSION);

		wp_enqueue_script( 'modernizr', mad()->template_uri('assets/dist/frontend/modernizr.min.js'));
		wp_enqueue_script( 'matebook-menu', mad()->template_uri('assets/dist/frontend/menu' . ( WP_DEBUG ? '' : '.min' ) . '.js'), $scripts_deps, MATEBOOK_THEME_VERSION);

		// animations
		wp_enqueue_style( 'animate', mad()->template_uri( 'assets/vendor/animate.min.css' ), [], MATEBOOK_THEME_VERSION );

		// Vendor
		wp_enqueue_style('owl-carousel');
		wp_enqueue_script('owl-carousel');

		// Frontend scripts.
		wp_enqueue_script( 'matebook-vendor', mad()->template_uri( 'assets/dist/frontend/vendor' . ( WP_DEBUG ? '' : '.min' ) . '.js' ), $scripts_deps, MATEBOOK_THEME_VERSION, true );
		wp_enqueue_script( 'matebook-general', mad()->template_uri( 'assets/dist/frontend/frontend' . ( WP_DEBUG ? '' : '.min' ) . '.js' ), $scripts_deps, MATEBOOK_THEME_VERSION, true );

		// Comment reply script
		if ( is_singular() && comments_open() && get_option('thread_comments') ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Custom JavaScript
		wp_add_inline_script( 'matebook-general', mad()->get_option('js-code-head') );

		// theme style.css
		wp_enqueue_style( 'matebook-theme-styles-default', mad()->template_uri( 'style.css' ), [], MATEBOOK_THEME_VERSION  );

		// Skin Styles
		wp_deregister_style( 'matebook-skin' );
		$prefix_name = 'skin_' . get_current_blog_id() . '.css';
		$wp_upload_dir = wp_upload_dir();
		$stylesheet_dynamic_dir = $wp_upload_dir['basedir'] . '/dynamic_matebook_dir';
		$stylesheet_dynamic_dir = str_replace('\\', '/', $stylesheet_dynamic_dir);
		$filename = trailingslashit($stylesheet_dynamic_dir) . $prefix_name;

		$version = get_option( 'matebook_stylesheet_version' . $prefix_name );
		if ( empty($version) ) $version = '1';

		$demo = get_option( 'matebook_demo' );
		if ( empty($demo) ) $demo = '1';

		if ( file_exists($filename) ) {
			if ( is_ssl() ) {
				$wp_upload_dir['baseurl'] = str_replace("http://", "https://", $wp_upload_dir['baseurl']);
			}
			wp_register_style( 'matebook-skin', $wp_upload_dir['baseurl'] . '/dynamic_matebook_dir/' . $prefix_name, null, $version );
		} else {
			wp_register_style( 'matebook-skin', get_theme_file_uri( "assets/dynamic/skin-{$demo}.css" ), null, $version );
		}
		wp_enqueue_style( 'matebook-skin' );

		if ( is_home() || is_archive() || is_single() || is_page() ) {
			wp_enqueue_style('media-element');
		}

	}

	public function google_fonts_icons() {

		$font_family = array(
			'Material Icons',
			'Material Icons Outlined',
			'Material Icons Round',
			'Material Icons Sharp',
			'Material Icons Two Tone'
		);

		$fonts_url = add_query_arg(array(
			'family' => urlencode(implode('|', $font_family))
		), 'https://fonts.googleapis.com/css');

		return esc_url_raw($fonts_url);
	}

	public function google_fonts_url( array $fonts_data = array(), array $charsets = array() ) {
		$fonts_url = '';
		$font_family = [];

		if ( $fonts_data ) {
			foreach( $fonts_data as $font => $font_weights ) {
				$font_state = sprintf( _x( 'on', '%s font: on or off', 'matebook' ), $font );

				if ( 'off' !== $font_state ) {
					$font_family[] = sprintf('%s:%s', $font, implode(',', $font_weights));
				}
			}
		}

		if ( $font_family ) {
			$fonts_url = add_query_arg(array(
				'family' => urlencode(implode('|', $font_family)),
				'subset' => urlencode(implode(',', $charsets))
			), 'https://fonts.googleapis.com/css');
		}

		return esc_url_raw($fonts_url);
	}

	/**
	 * Print content within the site <head></head>.
	 *
	 */
	public function print_head_content() {
		$data = apply_filters( 'matebook/localize-data', [
			'Helpers' => new \stdClass,
		] );

		foreach ( (array) $data as $key => $value ) {
			if ( ! is_scalar( $value ) ) {
				continue;
			}
			$data[ $key ] = html_entity_decode( (string) $value, ENT_QUOTES, 'UTF-8' );
		}

		printf( '<script type="text/javascript">var Matebook = %s;</script>', wp_json_encode( (object) $data ) );

		$cases = [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'header_sticky' => mad()->get_option('header-sticky-menu'),
			'woocommerce' => [],
		];

		foreach ( (array) $cases as $key => $value ) {
			if ( ! is_scalar( $value ) ) {
				continue;
			}
			$cases[ $key ] = html_entity_decode( (string) $value, ENT_QUOTES, 'UTF-8' );
		}

		printf( '<script type="text/javascript">var MAD = %s;</script>', wp_json_encode( (object) $cases ) );

		/**
		 * Add a pingback url auto-discovery header for singularly identifiable articles.
		 */
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
		}

	}
}
