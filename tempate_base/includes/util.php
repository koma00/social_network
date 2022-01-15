<?php

// Debugging helper
if ( ! function_exists('t_print_r') ) {
	function t_print_r($arr) {
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}
}
function matebook_locate_template( $template, $data = [] ) {
	if ( $template = locate_template( $template ) ) {
		require $template;
	}
}

// Helper function for accessing Matebook\includes\app instance.
function matebook() {
	return Matebook\Includes\App::instance();
}

function mad() {
	return matebook()->helpers();
}
// Start.
matebook();