<?php

if ( ! defined('ABSPATH') ) {
	exit;
}

/**
 * Autoload classes.
 *
 * Matebook\Src      -> matebook/includes/classes
 * Matebook\Ext      -> matebook/includes/extensions
 * Matebook\Int      -> matebook/includes/integrations
 * Matebook\Utils    -> matebook/includes/utils
 * Matebook\Includes -> matebook/includes
 */
spl_autoload_register( function( $classname ) {
	$parts = explode( '\\', $classname );

	if ( $parts[0] !== 'Matebook' ) {
		return false;
	}

	if ( $parts[1] === 'Src' ) {
		$parts[1] = 'Includes' . DIRECTORY_SEPARATOR . 'Src';
	}

	if ( $parts[1] === 'Ext' ) {
		$parts[1] = 'Includes' . DIRECTORY_SEPARATOR . 'Extensions';
	}

	if ( $parts[1] === 'Int' ) {
		$parts[1] = 'Includes' . DIRECTORY_SEPARATOR . 'Integrations';
	}

	if ( $parts[1] === 'Utils' ) {
		$parts[1] = 'Includes' . DIRECTORY_SEPARATOR . 'Utils';
	}

	$path_parts = array_map( function( $part) {
		return strtolower( str_replace( '_', '-', $part ) );
	}, $parts );

	// unset matebook path part since that's already known.
	unset( $path_parts[0] );

	$path = join( DIRECTORY_SEPARATOR, $path_parts ) . '.php';

	if ( locate_template( $path ) ) {
		require_once locate_template( $path );
	}
} );


$files = [
	'lic.php',
	'util.php',
	'init.php',

	'integrations/class-template-args.php',
	'integrations/functions-core.php',
	'integrations/woocommerce.php',
	'integrations/class-walker.php',
	'integrations/class-walker-nav-menu.php',
	'integrations/nav-menu-template.php'
];

foreach ( $files as $path ) {
	require_once locate_template( "includes/{$path}" );
}