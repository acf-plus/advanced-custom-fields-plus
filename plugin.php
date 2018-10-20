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
 * Text Domain:       acf-plus
 * Domain Path:       /
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * Require once the Composer Autoload
 */
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
register_activation_hook(
	__FILE__,
	function() {

		ACF\ACFPLUS\Activate::activate();

	}
);

/**
 * The code that runs during plugin deactivation
 */
register_deactivation_hook(
	__FILE__,
	function() {

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
