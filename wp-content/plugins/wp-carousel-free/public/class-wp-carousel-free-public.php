<?php
/**
 *  Enqueue public script for the WP Carousel
 *
 * @package WP Carousel
 * @subpackage wp-carousel-free/public
 */

/**
 * The public-facing functionality of the plugin.
 */
class WP_Carousel_Free_Public {

	/**
	 * Script and style suffix
	 *
	 * @since 2.0.0
	 * @access protected
	 * @var string
	 */
	protected $suffix;

	/**
	 * The ID of the plugin.
	 *
	 * @since 2.0.0
	 * @access protected
	 * @var string      $plugin_name The ID of this plugin
	 */
	protected $plugin_name;

	/**
	 * The version of the plugin
	 *
	 * @since 2.0.0
	 * @access protected
	 * @var string      $version The current version fo the plugin.
	 */
	protected $version;

	/**
	 * Initialize the class sets its properties.
	 *
	 * @since 2.0.0
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of the plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->suffix      = defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min';
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the plugin.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	public function enqueue_styles() {
		// Stylesheet loading problem solving here. Shortcode id to push page id option for getting how many shortcode in the page.
		$current_page_id    = get_queried_object_id();
		$option_key         = 'sp_wp_carousel_page_id' . $current_page_id;
		$found_generator_id = get_option( $option_key );
		if ( is_multisite() ) {
			$option_key         = 'sp_wp_carousel_page_id' . get_current_blog_id() . $current_page_id;
			$found_generator_id = get_site_option( $option_key );
		}

		if ( $found_generator_id ) {
			wp_enqueue_style( 'wpcf-swiper' );
			wp_enqueue_style( 'wp-carousel-free-fontawesome' );
			wp_enqueue_style( 'wp-carousel-free' );

			$the_wpcf_dynamic_css = '';
			foreach ( $found_generator_id as $post_id ) {
				if ( $post_id && is_numeric( $post_id ) && get_post_status( $post_id ) !== 'trash' ) {
					$upload_data    = get_post_meta( $post_id, 'sp_wpcp_upload_options', true );
					$shortcode_data = get_post_meta( $post_id, 'sp_wpcp_shortcode_options', true );
					include WPCAROUSELF_PATH . '/public/dynamic-style.php';
				}
			}
			include WPCAROUSELF_PATH . '/public/responsive.php';
			$dynamic_style         = self::minify_output( $the_wpcf_dynamic_css );
			$the_wpcf_dynamic_css .= trim( html_entity_decode( wpcf_get_option( 'wpcp_custom_css' ) ) );
			wp_add_inline_style( 'wp-carousel-free', $dynamic_style );
		} else {
			$the_wpcf_dynamic_css = '';
			// Include responsive breakpoints CSS.
			include WPCAROUSELF_PATH . '/public/responsive.php';
			wp_add_inline_style( 'wp-carousel-free', $the_wpcf_dynamic_css );
		}
	}

	/**
	 * Enqueue css and js files for live preview.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	public function admin_enqueue_scripts() {
		$current_screen        = get_current_screen();
		$the_current_post_type = $current_screen->post_type;
		if ( 'sp_wp_carousel' === $the_current_post_type ) {
			// Enqueue css file.
			wp_enqueue_style( 'wpcf-swiper' );
			wp_enqueue_style( 'wp-carousel-free-fontawesome' );
			wp_enqueue_style( 'wp-carousel-free' );

			// Enqueue js file.
			wp_enqueue_script( 'wpcf-swiper-js' );
		}
	}
	/**
	 * Register the All scripts for the public-facing side of the site.
	 *
	 * @since    2.0
	 */
	public function register_all_scripts() {
		/**
		 * Register the stylesheets for the public-facing side of the plugin.
		 */
		if ( wpcf_get_option( 'wpcp_enqueue_swiper_css', true ) ) {
			wp_register_style( 'wpcf-swiper', WPCAROUSELF_URL . 'public/css/swiper-bundle.min.css', array(), $this->version, 'all' );
		}
		if ( wpcf_get_option( 'wpcp_enqueue_fa_css', true ) ) {
			wp_register_style( 'wp-carousel-free-fontawesome', WPCAROUSELF_URL . 'public/css/font-awesome.min.css', array(), $this->version, 'all' );
		}
		wp_register_style( 'wp-carousel-free', WPCAROUSELF_URL . 'public/css/wp-carousel-free-public' . $this->suffix . '.css', array(), $this->version, 'all' );

		/**
		 * Register the JavaScript for the public-facing side of the plugin.
		 */
		wp_register_script( 'wpcp-preloader', WPCAROUSELF_URL . 'public/js/preloader' . $this->suffix . '.js', array( 'jquery' ), $this->version, true );
		wp_register_script( 'wpcf-swiper-js', WPCAROUSELF_URL . 'public/js/swiper-bundle.min.js', array( 'jquery' ), $this->version, true );
		wp_register_script( 'wpcf-swiper-config', WPCAROUSELF_URL . 'public/js/wp-carousel-free-public' . $this->suffix . '.js', array( 'jquery' ), $this->version, true );

	}
	/**
	 * Delete page shortcode ids array option on save
	 *
	 * @param  int $post_ID current post id.
	 * @return void
	 */
	public function delete_page_wp_carousel_option_on_save( $post_ID ) {
		if ( is_multisite() ) {
			$option_key = 'sp_wp_carousel_page_id' . get_current_blog_id() . $post_ID;
			if ( get_site_option( $option_key ) ) {
				delete_site_option( $option_key );
			}
		} else {
			if ( delete_option( 'sp_wp_carousel_page_id' . $post_ID ) ) {
				delete_option( 'sp_wp_carousel_page_id' . $post_ID );
			}
		}

	}
	/**
	 * Minify output
	 *
	 * @param  string $html output.
	 * @return statement
	 */
	public static function minify_output( $html ) {
		$html = preg_replace( '/<!--(?!s*(?:[if [^]]+]|!|>))(?:(?!-->).)*-->/s', '', $html );
		$html = str_replace( array( "\r\n", "\r", "\n", "\t" ), '', $html );
		while ( stristr( $html, '  ' ) ) {
			$html = str_replace( '  ', ' ', $html );
		}
		return $html;
	}
}
