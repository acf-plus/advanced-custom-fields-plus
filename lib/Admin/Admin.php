<?php
/**
 * Enqueue style and js
 *
 * @package  ACF
 */

namespace ACF\ACFPLUS\Admin;

use ACF\ACFPLUS\Admin\Callbacks\AcfPlusOptions;
use ACF\ACFPLUS\Admin\Callbacks\AdminCallbacks;

/**
 * Class Admin
 *
 * @package ACF\ACFPLUS\Admin
 */
class Admin {

	/**
	 * Plugin name
	 *
	 * @var string
	 */
	private $plugin_name;

	/**
	 * Plugin version
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Admin callbacks
	 *
	 * @var AdminCallbacks
	 */
	public $callbacks;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->callbacks = new AdminCallbacks();
		$this->callbacks = new AcfPlusOptions();

	}

	/**
	 * Register the Style for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( dirname( dirname( __FILE__ ) ) ) . 'dist/admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( dirname( dirname( __FILE__ ) ) ) . 'dist/admin.js', array( 'jquery' ), $this->version, true );

	}


}
