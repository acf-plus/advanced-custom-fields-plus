<?php
/**
 * Deactivate
 *
 * @package  ACF
 */

namespace ACF\ACFPLUS;

/**
 * Class Deactivate
 *
 * @package ACF\ACFPLUS
 */
class Deactivate {

	/**
	 * Deactivate
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}
}
