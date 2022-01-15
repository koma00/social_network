<?php
/**
 * A class for displaying various tree-like structures.
 *
 * Extend the Walker class to use it, see examples below. Child classes
 * do not need to implement all of the abstract methods in the class. The child
 * only needs to implement the methods that are needed.
 *
 * @since 2.1.0
 *
 * @package WordPress
 * @abstract
 */
class Matebook_Walker {
	/**
	 * What the class handles.
	 *
	 * @since 2.1.0
	 * @var string
	 */
	public $tree_type;

	/**
	 * DB fields to use.
	 *
	 * @since 2.1.0
	 * @var array
	 */
	public $db_fields;

	/**
	 * Max number of pages walked by the paged walker
	 *
	 * @since 2.7.0
	 * @var int
	 */
	public $max_pages = 1;

	/**
	 * Whether the current element has children or not.
	 *
	 * To be used in start_el().
	 *
	 * @since 4.0.0
	 * @var bool
	 */
	public $has_children;

	public function start_main_lvl( &$output ) {}

	public function end_main_lvl( &$output ) {}

	/**
	 * Starts the list before the elements are added.
	 *
	 * The $args parameter holds additional values that may be used with the child
	 * class methods. This method is called at the start of the output list.
	 *
	 * @since 2.1.0
	 * @abstract
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param int    $depth  Depth of the item.
	 * @param array  $args   An array of additional arguments.
	 */
	public function start_lvl( &$output, $args = array() ) {}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * The $args parameter holds additional values that may be used with the child
	 * class methods. This method finishes the list at the end of output of the elements.
	 *
	 * @since 2.1.0
	 * @abstract
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param int    $depth  Depth of the item.
	 * @param array  $args   An array of additional arguments.
	 */
	public function end_lvl( &$output, $args = array() ) {}

	/**
	 * Start the element output.
	 *
	 * The $args parameter holds additional values that may be used with the child
	 * class methods. Includes the element output also.
	 *
	 * @since 2.1.0
	 * @abstract
	 *
	 * @param string $output            Used to append additional content (passed by reference).
	 * @param object $object            The data object.
	 * @param int    $depth             Depth of the item.
	 * @param array  $args              An array of additional arguments.
	 * @param int    $current_object_id ID of the current item.
	 */
	public function start_el( &$output, $object, $args = array(), $current_object_id = 0 ) {}

	/**
	 * Ends the element output, if needed.
	 *
	 * The $args parameter holds additional values that may be used with the child class methods.
	 *
	 * @since 2.1.0
	 * @abstract
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param object $object The data object.
	 * @param int    $depth  Depth of the item.
	 * @param array  $args   An array of additional arguments.
	 */
	public function end_el( &$output, $object, $args = array() ) {}

	public function display_top_level_element( $element, $args, &$output ) {
		if ( ! $element ) {
			return;
		}

		$cb_args = array_merge( array( &$output, $element ), $args );
		call_user_func_array( array( $this, 'start_el' ), $cb_args );
		call_user_func_array( array( $this, 'end_el' ), $cb_args );

	}

	public function display_children( $keys_children_elements, &$children_elements, $args, &$output ) {

		foreach ( $keys_children_elements as $id ) {

			if ( isset( $children_elements[ $id ] ) ) {

				$cb_args = array_merge( array( &$output, $id ), $args );
				call_user_func_array( array( $this, 'start_lvl' ), $cb_args );

				foreach ( $children_elements[$id] as $element ) {
					$cb_args = array_merge( array( &$output, $element ), $args );
					call_user_func_array( array( $this, 'start_el' ), $cb_args );
					call_user_func_array( array( $this, 'end_el' ), $cb_args );
				}

				$cb_args = array_merge( array( &$output ), $args );
				call_user_func_array( array( $this, 'end_lvl' ), $cb_args );

				}

			}

	}

	/**
	 * Display array of elements hierarchically.
	 *
	 * Does not assume any existing order of elements.
	 *
	 * $max_depth = -1 means flatly display every element.
	 * $max_depth = 0 means display all levels.
	 * $max_depth > 0 specifies the number of display levels.
	 *
	 * @since 2.1.0
	 *
	 * @param array $elements  An array of elements.
	 * @param int   $max_depth The maximum hierarchical depth.
	 * @return string The hierarchical item output.
	 */
	public function walk( $elements, $max_depth ) {
		$args   = array_slice( func_get_args(), 2 );
		$output = '';

		//invalid parameter or nothing to walk
		if ( $max_depth < -1 || empty( $elements ) ) {
			return $output;
		}

		$parent_field = $this->db_fields['parent'];

		/*
		 * Need to display in hierarchical order.
		 * Separate elements into two buckets: top level and children elements.
		 * Children_elements is two dimensional array, eg.
		 * Children_elements[10][] contains all sub-elements whose parent is 10.
		 */
		$top_level_elements = array();
		$children_elements  = array();
		foreach ( $elements as $e ) {
			if ( empty( $e->$parent_field ) ) {
				$top_level_elements[] = $e;
			} else {
				$children_elements[$e->$parent_field][] = $e;
			}
		}

		$keys_children_elements = array_keys($children_elements);

		if ( isset($top_level_elements) && !empty($top_level_elements) ) {

			call_user_func_array(array($this, 'start_main_lvl'), array(&$output));

			foreach ( $top_level_elements as $e ) {
				$this->display_top_level_element( $e, $args, $output );
			}

			call_user_func_array( array( $this, 'end_main_lvl' ), array(&$output));

		}

		if ( isset($children_elements) && !empty($children_elements) ) {
			$this->display_children( $keys_children_elements, $children_elements, $args, $output );
		}

		return $output;
	}

} // Walker
