<?php
/**
 * Activate
 *
 * @package  ACF
 */

namespace ACF\ACFPLUS;

/**
 * Class Activate

 * @package ACF\ACFPLUS
 */
class Activate {

	/**
	 * Activate
	 */
	public static function activate() {
		flush_rewrite_rules();
	}
}
