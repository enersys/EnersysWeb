<?php
/**
 * Plugin Name: Gutenify - Gutenberg Fullsite Editing Template Kits - Advanced Blocks
 * Description: Gutenify is a World’s First True Gutenberg (Block) Template Kit pluigin that is compatible with WordPress Full Site Editing to help you create the website you always wanted. Gutenify is a free WordPress plugin which allows you to add different block effortlessly in your site.
 * Author: Codeyatri
 * Author URI: https://www.gutenify.com
 * Version: 1.2.7
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
define( 'GUTENIFY_VERSION', '1.2.7' );
define( 'GUTENIFY_BASE_DIR', plugin_dir_path( __FILE__ ) );
define( 'GUTENIFY_BASE_URL', plugin_dir_url( __FILE__ ) );
define( 'GUTENIFY_BASE_FILE', __FILE__ );
define( 'GUTENIFY_BRAND_LOGO', '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1080 1080" style="enable-background:new 0 0 1080 1080;" xml:space="preserve">
<style type="text/css">
  .st0 {
    fill: #FFFFFF;
  }

  .st1 {
    fill: #67BC45;
  }

</style>
<g>
  <g>
    <path class="st0" d="M828.5,552.9c-6.8,152.9-133.3,275.1-287.9,275.1c-158.9,0-288.2-129.3-288.2-288.2
		      c0-150.6,116.2-274.5,263.5-287.1V0.4C229.1,13.2,0.5,249.9,0.5,539.9c0,298.2,241.7,540.1,540.1,540.1
		      c293.9,0,533-234.8,539.8-527H828.5V552.9z" />
    <rect x="518.9" y="254.6" class="st1" width="309.8" height="298.2" />
  </g>
</g>
</svg>
' );

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
