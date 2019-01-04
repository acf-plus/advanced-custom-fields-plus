<?php
/**
 * Option pages
 *
 * @package  ACF
 */

namespace ACF\ACFPLUS\Admin\Callbacks;

/**
 * Class AcfPlusOptions for modules activation and more
 */
class AcfPlusOptions {

	/**
	 * AcfPlusOptions constructor.
	 */
	public function __construct() {

		// Init ACF Plus option page for plugin management.
		add_action( 'init', array( $this, 'acf_plus_option_page' ) );

		// Adding modules to ACF Plus option page.
		add_action( 'acf_load_modules', array( $this, 'acf_plus_modules' ) );

		// Hide the Advanced Custom Fields menu.
		add_filter( 'acf/settings/show_admin', array( $this, 'acf_plus_ui' ) );
	}

	/**
	 * Add a page for theme options and module control.
	 */
	public function acf_plus_option_page() {
		acf_add_options_page(
			array(
				'page_title'  => __( 'ACF Plus Options', 'acf_plus' ),
				'menu_slug'   => 'acf_plus_options_page',
				'parent_slug' => 'options-general.php',
			)
		);
		ModuleLoader::get_instance()->register_options_container();
	}

	/**
	 * Loads all built-in modules.
	 *
	 * @param array $loader A loader that includes modules.
	 */
	public function acf_plus_modules( $loader ) {
		$loader->add_module(
			'acf_event',
			array(
				'title'    => __( 'Event for acf', 'acf_plus' ),
				'pro'      => false,
				'wcf'      => 'acf',
				'path'     => 'acf_event',
				'url'      => 'acf_event',
				'redirect' => admin_url( 'post.php?post=4&action=edit' ),
			)
		);
	}

	/**
	 * Check if UI switch is true
	 */
	public function acf_plus_ui() {
		if ( ! get_field( 'acf_plus_ui_enable', 'option' ) ) {
			return false;
		} else {
			return true;
		}
	}

}
