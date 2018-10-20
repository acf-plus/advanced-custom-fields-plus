<?php
/**
 * Enqueue style and js
 *
 * @package  ACF
 */

namespace ACF\ACFPLUS\Frontend;

/**
 * Class Frontend
 *
 * @package ACF\ACFPLUS\Frontend
 */
class Frontend {

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
	}

	/**
	 * Register the Styles.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( dirname( dirname( __FILE__ ) ) ) . 'dist/main.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( dirname( dirname( __FILE__ ) ) ) . 'dist/main.js', array( 'jquery' ), $this->version, false );

	}


}
