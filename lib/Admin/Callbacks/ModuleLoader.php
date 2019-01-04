<?php
/**
 * Admin callback
 *
 * @package  ACF
 */

namespace ACF\ACFPLUS\Admin\Callbacks;

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class ModuleLoader
 *
 * This is just a helper class, if you are here to see how Advanced Custom Fields
 * works, don't focus on it. If you want to build a acf_plus module, read it.
 *
 * @package ACF\ACFPLUS\Admin\Callbacks
 */
class ModuleLoader {

	/**
	 * Holds the definition of every module that is loaded.
	 *
	 * @var mixed[]
	 */
	protected $modules = array();

	/**
	 * Saves a flag, which contains disabled modules.
	 *
	 * @var string[]
	 */
	protected $disabled = array();

	/**
	 * Creates and returns an instance of the loader.
	 *
	 * @return ModuleLoader
	 */
	public static function get_instance() {
		static $instance;

		if ( is_null( $instance ) ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Loads all modules from the database.
	 */
	private function __construct() {
		// If the plugin is not loaded, there is nothing else to load.
		if ( ! class_exists( 'acf' ) ) {
			return;
		}

		/**
		 * Allow additional modules to be registered.
		 *
		 * @since 3.0
		 *
		 * @param ModuleLoader $loader The loader to add modules to.
		 */
		do_action( 'acf_load_modules', $this );

		// Load enabled modules.
		$option = get_field( 'acf_plus_modules', 'option' );
		if ( $option && is_array( $option ) ) {
			foreach ( $option as $id ) {
				$path = $this->modules[ $id ]['path'];
				if ( ! isset( $this->modules[ $id ] ) || ! file_exists( $path . 'fields.php' ) ) {
					continue;
				}
				require_once $path . 'fields.php';
			}
		}

		// Add hooks.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_styles' ), 11 );
	}

	/**
	 * Adds a module to the theme.
	 *
	 * @since 3.0
	 *
	 * @param string $id The ID of the module.
	 * @param array  $module Module array with parameters.
	 *
	 * @return $this
	 */
	public function add_module( $id, $module ) {

		if ( ! isset( $module['title'] ) || ! isset( $module['pro'] ) || ! isset( $module['path'] ) || ! isset( $module['url'] ) || ! isset( $module['redirect'] ) ) {
			wp_die( 'A module needs the following attributes: title, pro, path, url and redirect!' );
		}

		if ( $module['pro'] && ! class_exists( 'acf_pro' ) ) {
			$this->disabled[] = $module['title'];

			return $this;
		}

		/**
		 * Prepare ACF Plus modules path and url.
		 */
		$modules_dir          = 'modules/';
		$module_path          = dirname( __FILE__, 3 ) . '/' . $modules_dir;
		$module_url           = plugin_dir_url( dirname( __FILE__, 2 ) ) . $modules_dir;
		$module['path']       = trailingslashit( $module_path . $module['path'] );
		$module['url']        = trailingslashit( $module_url . $module['url'] );
		$this->modules[ $id ] = $module;

		return $this;
	}

	/**
	 * Enqueue the styles and scripts for each module.
	 */
	public function enqueue_scripts_styles() {
		foreach ( $this->modules as $id => $module ) {
			if ( file_exists( $module['path'] . 'script.js' ) ) {
				wp_enqueue_script( $id . '-js', $module['url'] . 'script.js', array( 'jquery' ), true, true );
			}

			if ( file_exists( $module['path'] . 'style.css' ) ) {
				wp_enqueue_style( $id, $module['url'] . 'style.css', true, true );
			}
		}
	}

	/**
	 * Add settings to the theme options page.
	 *
	 * @since 3.0
	 *
	 * @throws \StoutLogic\AcfBuilder\FieldNameCollisionException - AcfBuilder helper.
	 */
	public function register_options_container() {
		$modules = array();
		$active  = get_field( 'acf_plus_modules', 'option' );

		if ( ! $active ) {
			$active = array();
		}

		foreach ( $this->modules as $id => $data ) {
			$title = $data['title'];

			if ( isset( $data['redirect'] ) && in_array( $id, $active, true ) ) {
				$title .= sprintf(
					'[<a href="%s">View</a>]',
					is_callable( $data['redirect'] )
						? call_user_func( $data['redirect'] )
						: $data['redirect']
				);
			}

			if ( ! class_exists( 'acf' ) ) {
				continue;
			} else {
				$modules[ $id ] = $title;
			}
		}

		$description = __( 'Select the modules you want to have enabled as a ACF Plus.', 'acf_plus' );

		if ( ! empty( $this->disabled ) ) {
			$description .= "\n\n" . __( 'Some modules are ignored because they require Advanced Custom Fields Pro', 'acf_plus' );
		}

		$acf_modules = new FieldsBuilder( 'acf_plus_modules' );
		$acf_modules
			->addMessage(
				'acf_plus_ui_enable_description',
				__( 'Default visual custom fields editor', 'acf_plus' ),
				[
					'label'     => __( 'Enable ACF UI', 'acf_plus' ),
					'wrapper'   => [
						'width' => '22%',
						'id'    => 'major-publishing-actions',
					],
					'esc_html'  => 0,
					'new_lines' => 'wpautop',
				]
			)
			->addTrueFalse(
				'acf_plus_ui_enable',
				[
					'label'   => '',
					'ui'      => 1,
					'wrapper' => [
						'width' => '78%',
					],
				]
			)
			->addMessage(
				'acf_plus_modules_description',
				$description,
				[
					'label'     => __( 'Modules', 'acf_plus' ),
					'wrapper'   => [
						'width' => '22%',
						'id'    => 'major-publishing-actions',
					],
					'esc_html'  => 0,
					'new_lines' => 'wpautop',
				]
			)
			->addCheckbox(
				'acf_plus_modules',
				[
					'label'   => '',
					'layout'  => 'vertical',
					'choices' => $modules,
					'wrapper' => [
						'width' => '78%',
					],
				]
			)
			->setLocation( 'options_page', '==', 'acf_plus_options_page' );

		acf_add_local_field_group( $acf_modules->build() );
	}

	/**
	 * Returns all registered modules.
	 *
	 * @since 3.0
	 *
	 * @return array
	 */
	public function get_modules() {
		$partials = array();
		$option   = get_field( 'acf_plus_modules', 'option' );
		if ( $option && is_array( $option ) ) {
			foreach ( $option as $id ) {
				$path = $this->modules[ $id ]['path'];
				if ( ! isset( $path ) || ! file_exists( $path . 'partial.blade.php' ) ) {
					continue;
				}
				$partials[] = basename( str_replace( 'partial.blade.php', '', $path ) ) . '.partial';
			}
		}

		return $partials;
	}
}
