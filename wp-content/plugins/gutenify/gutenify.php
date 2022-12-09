<?php
/**
 * Plugin Name: Gutenify - Gutenberg Fullsite Editing Template Kits - Advanced Blocks
 * Description: Gutenify is a World’s First True Gutenberg (Block) Template Kit pluigin that is compatible with WordPress Full Site Editing to help you create the website you always wanted. Gutenify is a free WordPress plugin which allows you to add different block effortlessly in your site.
 * Author: Gutenify
 * Author URI: https://www.gutenify.com
 * Version: 1.2.5
 * Text Domain: gutenify
 * Domain Path: /languages
 * Tested up to: 6.0
 *
 * Gutenify is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * You should have received a copy of the GNU General Public License
 * along with Gutenify. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package Gutenify
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define constants.
define( 'GUTENIFY_VERSION', '1.2.5' );
define( 'GUTENIFY_BASE_DIR', plugin_dir_path( __FILE__ ) );
define( 'GUTENIFY_BASE_URL', plugin_dir_url( __FILE__ ) );
define( 'GUTENIFY_BASE_FILE', __FILE__ );
define( 'GUTENIFY_BRAND_LOGO', GUTENIFY_BASE_URL . '/assets/images/gutenify-logo.svg' );

// Depricated
// define( 'GUTENIFY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
// define( 'GUTENIFY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
// define( 'GUTENIFY_PLUGIN_FILE', __FILE__ );
// define( 'GUTENIFY_PLUGIN_BASE', plugin_basename( __FILE__ ) );

function gutenify() {
	require 'inc/bootstrap.php';
	if ( function_exists( 'gutenify_pro' ) ) {
		gutenify_pro();
	}
}

gutenify();

function gutenify_activation_redirect( $plugin ) {
	if ( function_exists( 'get_current_screen' ) ) {
		$screen = get_current_screen();
		if ( ! empty( $screen->id ) && 'appearance_page_tgmpa-install-plugins' === $screen->id ) {
			return false;
		}
	}

	if ( $plugin == plugin_basename( __FILE__ ) ) {
		wp_safe_redirect( admin_url( 'admin.php?page=gutenify' ) );
		exit;
	}
}
// add_action( 'activated_plugin', 'gutenify_activation_redirect' );
