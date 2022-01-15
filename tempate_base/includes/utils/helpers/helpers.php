<?php

namespace Matebook\Utils\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Helpers {

	use \Matebook\Src\Traits\Instantiatable;

    // Get theme template path, with the given $path appended to it.
	public function template_path( $path ) {
		return get_theme_file_path($path);
	}

    // Get theme template uri, with the given $uri appended to it.
	public function template_uri( $uri = '' ) {
		return get_theme_file_uri($uri);
	}

    // URI to asset folder.
	public function asset( $asset ) {
		return $this->template_uri( "assets/$asset" );
	}

    // URI to images folder.
	public function image( $image ) {
		return $this->asset( "images/$image" );
	}

    // Retrieve the featured_image url for the given post, on the given size.
	public function featured_image( $postID, $size = 'large' ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), $size );
		return $image ? array_shift( $image ) : false;
	}

    // Retrieve the attachment_image url for the given post, on the given size.
	public function attachment_image( $attachment_id, $size = 'large' ) {
		$image = wp_get_attachment_image_src( $attachment_id, $size );
		return $image ? array_shift( $image ) : false;
	}

	public function count_widgets( $sidebar ) {
		global $sidebars_widgets;
		return count( $sidebars_widgets[$sidebar] );
	}

	public function get_title( $args = array(), $echo = false ) {

		$defaults = array(
			'heading' => 'h3',
			'holder' => true,
			'title' => '',
			'linktxt' => '',
			'linkurl' => '',
			'linktarget' => '',
			'subtitle' => '',
			'css_class' => 'section-title',
			'title_color' => '',
			'subtitle_color' => '',
			'align_title' => 'left'
		);

		$args = wp_parse_args( $args, $defaults );
		$args = (object) $args;

		if ( empty($args->title) ) return;

		$with_subtitle = '';

		$heading = $args->heading;
		$css_classes = array( $args->css_class );

		if ( strlen ( $args->subtitle ) > 0 ) {
			$with_subtitle = 'with-subtitle';
		}

		$css_class = implode( ' ', array_filter( $css_classes ) );

		$align_title = 'align-' . $args->align_title;

		ob_start();

		$link = '';

		if ( !empty( $args->linktxt ) ) {
			$link .= ' <a href="'. $args->linkurl .'" '.$args->linktarget.'>' . $args->linktxt . '</a>';
		}

		$output = '<div class="title-holder '. $align_title . ' heading-' . $args->heading  . ' ' . $with_subtitle . '">';
		$output .= "<{$heading} class='". esc_attr(trim($css_class)) ."'>" . esc_html($args->title) . $link ."</{$heading}>";

		if ( strlen ( $args->subtitle ) > 0 ) {
			$output .= "<p class='mad-title-subtitle'>" . esc_html($args->subtitle) . "</p>";
		}
		$output .= "</div>";
		$output .= ob_get_clean();

		if ( $echo ) {
			echo wp_kses($output, 'default');
		} else {
			return $output;
		}

	}

    // Get post terms from the given taxonomy.
	public function get_terms( $postID, $taxonomy = 'category' ) {
		$raw_terms = (array) wp_get_post_terms( $postID, $taxonomy );

		$terms = [];
		if ( ! empty( $raw_terms['errors'] ) ) {
			return $terms;
		}

		foreach ( $raw_terms as $raw_term ) {
			$terms[] = [
				'name' => $raw_term->name,
				'link' => get_term_link( $raw_term )
			];
		}

		return $terms;
	}

    // Print the post excerpt, limiting it to a given number of characters.
	public function the_excerpt( $charlength, $after = "&hellip;" ) {
		$excerpt = get_the_excerpt();
		$charlength++;
		$output = '';

		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) ) - 1;
			if ( $excut < 0 ) {
				$output .= mb_substr( $subex, 0, $excut );
			} else {
				$output .= $subex;
			}
			$output .= $after;
		} else {
			$output .= $excerpt;
		}

		echo wp_kses($output, 'default');
	}

	public function the_text_excerpt( $text, $charlength, $after = "&hellip;", $echo = true ) {
		$charlength++;
		$output = '';

		if ( mb_strlen( $text ) > $charlength ) {
			$subex = mb_substr( $text, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) ) - 1;
			if ( $excut < 0 ) {
				$output .= mb_substr( $subex, 0, $excut );
			} else {
				$output .= $subex;
			}
			$output .= $after;
		} else {
			$output .= $text;
		}

		if ( $echo ) {
			echo wp_kses($output, 'default');
			return;
		}

		return $output;
	}

	public function merge_options( $defaults, $options ) {
		return array_replace_recursive( $defaults, $options );
	}

	public function get_template( $template, $data = [] ) {
		if ( !locate_template("template-parts/{$template}.php") ) return;

		require locate_template("template-parts/{$template}.php");
	}

	public function get_terms_dropdown_array($args = [], $key = 'term_id', $value = 'name') {
		$options = [];
		$terms = get_terms($args);

		if ( is_wp_error($terms) ) {
			return [];
		}

		foreach ((array) $terms as $term) {
			$options[$term->{$key}] = $term->{$value};
		}

		return $options;
	}

	public function get_post_orderby_options()
	{
		$orderby = array(
			'ID' => 'Post ID',
			'author' => 'Post Author',
			'title' => 'Title',
			'date' => 'Date',
			'modified' => 'Last Modified Date',
			'parent' => 'Parent Id',
			'rand' => 'Random',
			'comment_count' => 'Comment Count',
			'menu_order' => 'Menu Order',
		);

		return $orderby;
	}

	public function get_posts_dropdown_array($args = [], $key = 'ID', $value = 'post_title') {
		$options = [];
		$posts = get_posts($args);

		foreach ((array) $posts as $term) {
			$options[$term->{$key}] = $term->{$value};
		}

		return $options;
	}

	public function get_icon_markup($icon_string)
	{
		if (strpos($icon_string, '://') !== false) {
			$icon_arr = explode('://', $icon_string);

			return "<i class=\"{$icon_arr[0]}\">{$icon_arr[1]}</i>";
		}

		return "<i class=\"{$icon_string}\"></i>";
	}

	public function get_option( $name, $fallback = '', array $data = array() ) {

		global $matebook_settings;

		$current_object_id = !empty($data) && isset($data['object_id']) && !empty($data['object_id']) ? intval($data['object_id']) : get_queried_object_id();

		if( function_exists('rwmb_get_value') && isset($data['overriden_by']) && $current_object_id) {
			if ( isset($data['depend_on']) ) {

				if( rwmb_get_value($data['depend_on']['key'], null, $current_object_id) == $data['depend_on']['value'] ) {
					$overriden_by = rwmb_get_value($data['overriden_by'], null, $current_object_id);

					if ( $overriden_by === false && isset($matebook_settings[$name] ) ) {
						return $matebook_settings[$name];
					}

					return (is_null($overriden_by) || (is_string($overriden_by) && !strlen($overriden_by)) || ($overriden_by === false)) ? $fallback : $overriden_by;
				} elseif( isset($matebook_settings[$name]) ) {
					return $matebook_settings[$name];
				} else {
					return $fallback;
				}
			} else {
				$overriden_by = rwmb_get_value($data['overriden_by'], $data, $current_object_id);

				if ( is_null($overriden_by) ||
				     (is_string($overriden_by) && !strlen($overriden_by)) ||
				     (is_array($overriden_by) && empty($overriden_by)) ||
				     ($overriden_by === false) ||
				     $overriden_by == 'inherit' )
				{

					if ( isset($matebook_settings[$name]) ) {
						return is_array( $matebook_settings[$name] ) && isset( $matebook_settings[$name]['url'] ) ? $matebook_settings[$name]['url'] : $matebook_settings[$name];
					} else {
						return $fallback;
					}

				} else {

					if ( isset($data['url']) && $data['url'] ) {
						return array_shift($overriden_by)['full_url'];
					} else {
						return $overriden_by;
					}

				}

			}
		}

		if ( isset($matebook_settings[$name]) ) {

			if ( is_array($matebook_settings[$name]) && isset( $matebook_settings[$name]['url'] ) ) {

				if ( !empty($matebook_settings[$name]['url']) ) {
					return $matebook_settings[$name]['url'];
				} else {
					return $fallback;
				}

			} else {

				if ( !empty($matebook_settings[$name]) ) {
					return $matebook_settings[$name];
				} else {
					return $fallback;
				}

			}

		} elseif( function_exists('rwmb_get_value') && $current_object_id ) {
			$current_object_value = rwmb_get_value($name, null, $current_object_id);
			return (is_null($current_object_value) || (is_string($current_object_value) && !strlen($current_object_value)) || ($current_object_value === false)) ? $fallback : $current_object_value;
		}

		return $fallback;
	}

	public function get_setting( $name, $fallback = '', array $data = array() ) {

		global $matebook_settings;

		if ( isset($data['overriden_by']) && !empty($data['overriden_by']) ) {

			$overriden_by = $data['overriden_by'];

			if ( is_null($overriden_by) || (is_string($overriden_by) && !strlen($overriden_by)) || ($overriden_by === false) ) {

				if ( isset($matebook_settings[$name]) ) {
					return is_array( $matebook_settings[$name] ) && isset( $matebook_settings[$name]['url'] ) ? $matebook_settings[$name]['url'] : $matebook_settings[$name];
				}

			} else {
				return $overriden_by;
			}

		}

		return $fallback;
	}

	public function get_site_logo() {
		if ($logo_obj = mad()->get_option('general_site_logo')) {
			return $logo_obj['sizes']['large'];
		}

		return '';
	}

	public function upload_file($file, $allowed_mime_types = [])
	{
		include_once( ABSPATH . 'wp-admin/includes/file.php' );
		include_once( ABSPATH . 'wp-admin/includes/media.php' );
		include_once( ABSPATH . 'wp-admin/includes/image.php' );

		$uploaded_file = new \stdClass();

		if ( ! in_array( $file['type'], $allowed_mime_types ) ) {
			return new \WP_Error( 'upload', sprintf( __( 'Uploaded files need to be one of the following file types: %s', 'matebook' ), implode( ', ', array_keys( $allowed_mime_types ) ) ) );
		}

		$upload = wp_handle_upload($file, ['test_form' => false]);

		if ( ! empty( $upload['error'] ) ) {
			return new \WP_Error( 'upload', $upload['error'] );
		}

		$wp_filetype = wp_check_filetype($upload['file']);
		$attach_id = wp_insert_attachment([
			'post_mime_type' => $wp_filetype['type'],
			'post_title' => sanitize_file_name($upload['file']),
			'post_content' => '',
			'post_status' => 'inherit'
			], $upload['file']);

		$attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
		wp_update_attachment_metadata( $attach_id, $attach_data );

		return $attach_id;
	}

	public function new_admin_page( $type = 'menu', $args = [] ) {
		if ( ! in_array( $type, [ 'menu', 'submenu', 'theme' ] ) ) return;

		call_user_func_array('add_' . $type . '_page', $args);
	}

	public function hexToRgb( $hex, $alpha = 1 ) {
		$rgb = [];

		if ( strpos( $hex, 'rgb' ) !== false ) {
			$hex = str_replace( ['rgba', 'rgb', '(', ')', ' '], '', $hex );
			$hexArr = explode( ',', $hex );

			$rgb['r'] = isset( $hexArr[0] ) ? absint( $hexArr[0] ) : 0;
			$rgb['g'] = isset( $hexArr[1] ) ? absint( $hexArr[1] ) : 0;
			$rgb['b'] = isset( $hexArr[2] ) ? absint( $hexArr[2] ) : 0;
			$rgb['a'] = isset( $hexArr[3] ) ? (float) $hexArr[3] : 1;

			return $rgb;
		}

		$hex      = str_replace( '#', '', $hex );
		$length   = strlen( $hex );
		$rgb['r'] = hexdec( $length == 6 ? substr( $hex, 0, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 0, 1 ), 2 ) : 0 ) );
		$rgb['g'] = hexdec( $length == 6 ? substr( $hex, 2, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 1, 1 ), 2 ) : 0 ) );
		$rgb['b'] = hexdec( $length == 6 ? substr( $hex, 4, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 2, 1 ), 2 ) : 0 ) );
		$rgb['a'] = $alpha;

		return $rgb;
	}

	public function getVideoEmbedUrl( $url )
	{
		// Check if youtube
		$rx = '~^(?:https?://)?(?:www\.)?(?:youtube\.com|youtu\.be)/watch\?v=(?<id>[^&]+)~x';
		preg_match($rx, $url, $matches);
		if (isset($matches['id']) && trim($matches['id']) != "") {
			return ['url' => "https://www.youtube.com/embed/{$matches['id']}?origin=*", 'type' => 'external', 'service' => 'youtube', 'video_id' => $matches['id']];
		}

		// Check if vimeo
		$rx = "/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*(?<id>[0-9]{6,11})[?]?.*/";
		preg_match($rx, $url, $matches);
		if (isset($matches['id']) && trim($matches['id']) != "") {
			return ['url' => "https://player.vimeo.com/video/{$matches['id']}?api=1&player_id=".$matches['id'], 'type' => 'external', 'service' => 'vimeo', 'video_id' => $matches['id']];
		}

		// Check if dailymotion
		$rx = "/^.+dailymotion.com\/(video|hub)\/(?<id>[^_]+)[^#]*(#video=(?<id2>[^_&]+))?/";
		preg_match($rx, $url, $matches);
		if (isset($matches['id']) && trim($matches['id']) != "") {
			return ['url' => "https://www.dailymotion.com/embed/video/{$matches['id']}", 'type' => 'external', 'service' => 'dailymotion', 'video_id'=>$matches['id']];
		}

		return false;
	}

	/**
	 * Get WPJM permalinks structure, with default values.
	 *
	 * @since 1.6.2
	 */
	public function get_permalink_structure() {
		return wp_parse_args( array_filter( (array) get_option( 'wpjm_permalinks', [] ) ), [
			'category_base' => 'category',
			'region_base' => 'region',
			'tag_base' => 'tag',
		] );
	}

	/**
	 * Safely output encoded data as html attribute.
	 *
	 * @since 1.6.2
	 */
	public function encode_attr( $string ) {
		return htmlspecialchars( json_encode( $string ), ENT_QUOTES, 'UTF-8' );
	}

	public function sanitized_css_classes( $classes = array(), $before = '' ) {
		return $before . implode(' ', array_unique(array_map('sanitize_html_class', $classes)));
	}

	/**
	 * Retrieve object class name.
	 *
	 * @since 1.7.2
	 * @param bool $namespaced Whether to include the namespace or only the basename.
	 */
	public function get_class_name( $object, $namespaced = false ) {
		if ( $namespaced ) {
			return get_class( $object );
		}

		$parts = explode( '\\', get_class( $object ) );
		return end( $parts );
	}

	public function get_share_opts( $socials ) {

		$options = [];

		if ( ! empty( $socials ) ) {
			foreach ( $socials as $key => $option ) {

				if ( $option == true ) {
					$options[] = $key;
				}
			}

			return $options;

		}

		return $options;

	}

}
