<?php
/**
 * The plugin bootstrap file
 *
 * @link              https://acf.plus
 * @since             1.0.0
 * @package           ACF
 *
 * @wordpress-plugin
 * Plugin Name:       Advanced Custom Fields Plus
 * Plugin URI:        https://acf.plus
 * Description:       A custom ACF plugin boilerplate
 * Version:           1.0.0
 * Author:            Dima Minka
 * Author URI:        https://acf.plus
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       acf_plus
 * Domain Path:       /
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Helper function for prettying up errors
 *
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$acf_error = function ( $message, $subtitle = '', $title = '' ) {
	$title   = $title ?: __( 'ACF &rsaquo; Error', 'acf_plus' );
	$footer  = '<a href="https://acf.plus/">acf.plus</a>';
	$message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
	wp_die( wp_kses_post( $message ), esc_attr( $title ) );
};

/**
 * Ensure compatible version of PHP is used
 */
if ( version_compare( '7.1', phpversion(), '>=' ) ) {
	$acf_error( __( 'You must be using PHP 7.1 or greater.', 'acf_plus' ), __( 'Invalid PHP version', 'acf_plus' ) );
}

/**
 * Ensure dependencies are loaded
 */

if ( ! file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	$acf_error(
		__( 'You must run <code>composer install</code> from the ACF Plus directory.', 'acf_plus' )
	);
} elseif ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * Displays a message that Advance Custom Fields/Ultimate Fields is needed for the theme.
 */
function acf_plus_checker() {
	if ( ! class_exists( 'acf' ) ) {
		$message = __( 'Please install and activate Advanced Custom Fields', 'acf_plus' );
		printf( '<div class="notice notice-error"><p>%s</p></div>', esc_attr( $message ) );
	}
}
add_action( 'admin_notices', 'acf_plus_checker' );

/**
 * The code that runs during plugin activation
 */
register_activation_hook(
	__FILE__,
	function () {

		ACF\ACFPLUS\Activate::activate();

	}
);

/**
 * The code that runs during plugin deactivation
 */
register_deactivation_hook(
	__FILE__,
	function () {

		ACF\ACFPLUS\Deactivate::deactivate();

	}
);

/**
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'ACF\\ACFPLUS\\Init' ) ) {
	$init = new ACF\ACFPLUS\Init();
	$init->run();
}
