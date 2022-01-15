<?php
/**
 * Nav Menu API: Template functions
 *
 */

/**
 * Displays a navigation menu.
 *
 */
function matebook_wp_nav_menu( $args = array() ) {

	$defaults = array(
		'menu'            => '',
		'container'       => '',
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul id="%1$s" data-menu="main" aria-label="All" class="%2$s">%3$s</ul>',
		'item_spacing'    => 'preserve',
		'depth'           => 1,
		'walker'          => '',
		'theme_location'  => '',
	);

	$args = wp_parse_args( $args, $defaults );

	/**
	 * Filters the arguments used to display a navigation menu.
	 *
	 * @since 3.0.0
	 *
	 * @see wp_nav_menu()
	 *
	 * @param array $args Array of wp_nav_menu() arguments.
	 */
	$args = (object) $args;

	// Get the nav menu based on the requested menu
	$menu = wp_get_nav_menu_object( $args->menu );

	// Get the nav menu based on the theme_location
	if ( ! $menu && $args->theme_location && ( $locations = get_nav_menu_locations() ) && isset( $locations[ $args->theme_location ] ) ) {
		$menu = wp_get_nav_menu_object( $locations[ $args->theme_location ] );
	}

	if ( empty( $args->menu ) ) {
		$args->menu = $menu;
	}

	// If the menu exists, get its items.
	if ( $menu && ! is_wp_error( $menu ) && ! isset( $menu_items ) ) {
		$menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );
	}

	if ( ! $menu || is_wp_error( $menu ) ) {
		return false;
	}

	$nav_menu = $items = '';

	// Set up the $menu_item variables
	_wp_menu_item_classes_by_context( $menu_items );

	$sorted_menu_items = $menu_items_with_children = array();
	foreach ( (array) $menu_items as $menu_item ) {
		$sorted_menu_items[ $menu_item->menu_order ] = $menu_item;
		if ( $menu_item->menu_item_parent ) {
			$menu_items_with_children[ $menu_item->menu_item_parent ] = true;
		}
	}

	// Add the menu-item-has-children class where applicable
	if ( $menu_items_with_children ) {
		foreach ( $sorted_menu_items as &$menu_item ) {
			if ( isset( $menu_items_with_children[ $menu_item->ID ] ) ) {
				$menu_item->classes[] = 'menu-item-has-children';
			}
		}
	}

	unset( $menu_items, $menu_item );

	$items .= matebook_walk_nav_menu_tree( $sorted_menu_items, $args->depth, $args );


	unset( $sorted_menu_items );

	// Don't print any markup if there are no items at this point.
	if ( empty( $items ) ) {
		return false;
	}

	$nav_menu .= $items;
	unset( $items );

	if ( $args->echo ) {
		echo $nav_menu;
	} else {
		return $nav_menu;
	}
}

/**
 * Retrieve the HTML list content for nav menu items.
 *
 * @uses Walker_Nav_Menu to create HTML list content.
 * @since 3.0.0
 *
 * @param array    $items The menu items, sorted by each menu item's menu order.
 * @param int      $depth Depth of the item in reference to parents.
 * @param stdClass $r     An object containing wp_nav_menu() arguments.
 * @return string The HTML list content for the menu items.
 */
function matebook_walk_nav_menu_tree( $items, $depth, $r ) {
	$walker = new Matebook_Walker_Nav_Menu();
	$args   = array( $items, $depth, $r );
	return call_user_func_array( array( $walker, 'walk' ), $args );
}

