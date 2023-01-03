<?php

/**
 * Fired during plugin deactivation
 *
 * @link       www.faboba.com
 * @since      1.0
 *
 * @package    Falang
 * @subpackage Falang/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0
 * @package    Falang
 * @subpackage Falang/includes
 * @author     Stéphane Bouey <stephane.bouey@faboba.com>
 */
class Falang_Deactivator {

	/**
	 *
	 * @since    1.0
	 */
	public static function deactivate() {
		//need to rewrite the rule to remove the default slug
		flush_rewrite_rules();
	}

}
