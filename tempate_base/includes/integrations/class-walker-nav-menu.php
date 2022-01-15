<?php
/**
 * Nav Menu API: Walker_Nav_Menu class
 *
 * @package WordPress
 * @subpackage Nav_Menus
 * @since 4.6.0
 */

/**
 * Core class used to implement an HTML list of nav menu items.
 *
 * @since 3.0.0
 *
 * @see Walker
 */
class Matebook_Walker_Nav_Menu extends Matebook_Walker {
	/**
	 * What the class handles.
	 *
	 * @since 3.0.0
	 * @var string
	 *
	 * @see Walker::$tree_type
	 */
	public $tree_type = array( 'post_type', 'taxonomy', 'custom' );

	/**
	 * Database fields to use.
	 *
	 * @since 3.0.0
	 * @todo Decouple this.
	 * @var array
	 *
	 * @see Walker::$db_fields
	 */
	public $db_fields = array(
		'parent' => 'menu_item_parent',
		'id'     => 'db_id',
	);

	function start_main_lvl( &$output ) {
		$output .= "<ul data-menu='main' class=\"menu__level\">\n";
	}

	function end_main_lvl( &$output ) {
		$output .= "</ul>";
	}

	function start_lvl( &$output, $id = 0, $args = array() ) {
		$output .= "<ul data-menu='submenu-$id' class=\"menu__level\">\n";
	}

	function end_lvl( &$output, $args = array() ) {
		$output .= "</ul>";
	}

	// add main/sub classes to li's and links
	function start_el( &$output, $item, $args = array(), $id = 0) {

		$active = "";

		// passed classes
		$classes = empty( $item->classes ) ? array() : (array)$item->classes;

		$class_names = esc_attr( implode( ' ', array_filter( $classes ) ) );

		$output .= '<li id="mobile-menu-item-'. $item->ID . '" class="menu__item ' . $class_names . ' ' . $active . '">';

		// link attributes
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_url( $item->url        ) .'"' : '';

		$item_output = $args->before;

		$item_output .= '<a data-submenu="submenu-'. $item->ID .'" class="menu__link" '. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= '</a>';

		$item_output .= $args->after;

		$output .= $item_output;
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_el()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Page data object. Not used.
	 * @param int      $depth  Depth of page. Not Used.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $args = array() ) {
		$output .= "</li>";
	}

}
