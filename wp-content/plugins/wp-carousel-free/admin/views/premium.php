<?php
/**
 * The Upgrade to pro page for the WP Carousel
 *
 * @package WP Carousel
 * @subpackage wp-carousel-free/admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}  // if direct access.

/**
 * The help class for the WP Carousel
 */
class WP_Carousel_Free_Upgrade {


	/**
	 * Add admin menu.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	public function upgrade_admin_menu() {
		$landing_page = 'https://shapedplugin.com/wp-carousel/pricing/?ref=1';
		add_submenu_page(
			'edit.php?post_type=sp_wp_carousel',
			__( 'WP Carousel', 'wp-carousel-free' ),
			'<span class="sp-go-pro-icon"></span>Go Pro',
			'manage_options',
			$landing_page
		);
	}
}
