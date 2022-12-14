<?php
/**
 * The file that defines the plugin shortcode class.
 *
 * A class definition that define main carousel shortcode of the plugin.
 *
 * @link  https://shapedplugin.com/
 * @since 3.0.0
 *
 * @package    WP_Carousel_Free
 * @subpackage WP_Carousel_Free/includes
 */

/**
 * The Shortcode class.
 *
 * This is used to define shortcode, shortcode attributes, and carousel types.
 */
class WP_Carousel_Free_Shortcode {


	/**
	 * Holds the class object.
	 *
	 * @since 2.0.0
	 * @var   object
	 */
	public static $instance;

	/**
	 * Undocumented variable
	 *
	 * @var string $post_id The post id of the carousel shortcode.
	 */
	public $post_id;


	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @since  2.0.0
	 * @static
	 * @return WP_Carousel_Free_Shortcode Shortcode instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


	/**
	 * Full html show.
	 *
	 * @param array $upload_data get all layout options.
	 * @param array $shortcode_data get all meta options.
	 * @param array $post_id Shortcode ID.
	 * @param array $main_section_title section title.
	 */
	public static function wpcf_html_show( $upload_data, $shortcode_data, $post_id, $main_section_title ) {
		if ( empty( $upload_data ) ) {
			return;
		}
		$carousel_type = isset( $upload_data['wpcp_carousel_type'] ) ? $upload_data['wpcp_carousel_type'] : '';

		// General Settings.
		$section_title = isset( $shortcode_data['section_title'] ) ? $shortcode_data['section_title'] : '';

		$wpcp_layout = isset( $shortcode_data['wpcp_layout'] ) ? $shortcode_data['wpcp_layout'] : 'carousel';
		$item_gap    = isset( $shortcode_data['wpcp_slide_margin'] ) ? $shortcode_data['wpcp_slide_margin'] : array(
			'top'   => '20',
			'right' => '20',
		);
		// Carousel Column.
		$column_number = isset( $shortcode_data['wpcp_number_of_columns'] ) ? $shortcode_data['wpcp_number_of_columns'] : '';

		// Carousel Settings.
		$preloader = isset( $shortcode_data['wpcp_preloader'] ) ? $shortcode_data['wpcp_preloader'] : true;
		$nav_class = 'grid' === $wpcp_layout ? 'wpcp-gallery-wrapper' : ' nav-vertical-center';
		// Carousel Classes.
		$carousel_classes = 'wpcp-carousel-section sp-wpcp-' . $post_id . ' ' . $nav_class;
		if ( 'image-carousel' === $carousel_type ) {
			$carousel_classes .= ' wpcp-image-carousel';
		} elseif ( 'post-carousel' === $carousel_type ) {
			$carousel_classes .= ' wpcp-post-carousel';
		} elseif ( 'product-carousel' === $carousel_type ) {
			$carousel_classes .= ' wpcp-product-carousel';
		}

		// Preloader classes.
		if ( $preloader ) {
			wp_enqueue_script( 'wpcp-preloader' );
			$carousel_classes .= ' wpcp-preloader';
		}

		if ( 'carousel' === $wpcp_layout ) {

			$wpcp_dots = isset( $shortcode_data['wpcp_pagination'] ) ? $shortcode_data['wpcp_pagination'] : '';
			switch ( $wpcp_dots ) {
				case 'show':
					$dots        = 'true';
					$dots_mobile = 'true';
					break;
				case 'hide':
					$dots        = 'false';
					$dots_mobile = 'false';
					break;
				case 'hide_mobile':
					$dots        = 'true';
					$dots_mobile = 'false';
					break;
			}
			$wpcp_arrows = isset( $shortcode_data['wpcp_navigation'] ) ? $shortcode_data['wpcp_navigation'] : 'show';
			switch ( $wpcp_arrows ) {
				case 'show':
					$arrows        = 'true';
					$arrows_mobile = 'true';
					break;
				case 'hide':
					$arrows        = 'false';
					$arrows_mobile = 'false';
					break;
				case 'hide_mobile':
					$arrows        = 'true';
					$arrows_mobile = 'false';
					break;
			}

			// Responsive screen sizes.
			$wpcp_screen_sizes     = wpcf_get_option( 'wpcp_responsive_screen_setting' );
			$desktop_size          = isset( $wpcp_screen_sizes['desktop'] ) && ! empty( $wpcp_screen_sizes['desktop'] ) ? $wpcp_screen_sizes['desktop'] : '1200';
			$laptop_size           = isset( $wpcp_screen_sizes['laptop'] ) && ! empty( $wpcp_screen_sizes['laptop'] ) ? $wpcp_screen_sizes['laptop'] : '980';
			$tablet_size           = isset( $wpcp_screen_sizes['tablet'] ) && ! empty( $wpcp_screen_sizes['tablet'] ) ? $wpcp_screen_sizes['tablet'] : '736';
			$mobile_size           = isset( $wpcp_screen_sizes['mobile'] ) && ! empty( $wpcp_screen_sizes['mobile'] ) ? $wpcp_screen_sizes['mobile'] : '480';
			$old_column_lg_desktop = isset( $column_number['column1'] ) ? $column_number['column1'] : '5';
			$column_lg_desktop     = isset( $column_number['lg_desktop'] ) && ! empty( $column_number['lg_desktop'] ) ? $column_number['lg_desktop'] : $old_column_lg_desktop;
			$old_column_desktop    = isset( $column_number['column2'] ) ? $column_number['column2'] : '4';
			$column_desktop        = isset( $column_number['desktop'] ) && ! empty( $column_number['desktop'] ) ? $column_number['desktop'] : $old_column_desktop;
			$old_column_sm_desktop = isset( $column_number['column3'] ) ? $column_number['column3'] : '3';
			$column_sm_desktop     = isset( $column_number['laptop'] ) && ! empty( $column_number['laptop'] ) ? $column_number['laptop'] : $old_column_sm_desktop;
			$old_column_tablet     = isset( $column_number['column4'] ) ? $column_number['column4'] : '2';
			$column_tablet         = isset( $column_number['tablet'] ) && ! empty( $column_number['tablet'] ) ? $column_number['tablet'] : $old_column_tablet;
			$old_column_mobile     = isset( $column_number['column5'] ) ? $column_number['column5'] : '1';
			$column_mobile         = isset( $column_number['mobile'] ) && ! empty( $column_number['mobile'] ) ? $column_number['mobile'] : $old_column_mobile;
			$auto_play             = $shortcode_data['wpcp_carousel_auto_play'] ? 'true' : 'false';
			$old_autoplay_speed    = isset( $shortcode_data['carousel_auto_play_speed'] ) && is_numeric( $shortcode_data['carousel_auto_play_speed'] ) ? $shortcode_data['carousel_auto_play_speed'] : '3000';
			$autoplay_speed        = isset( $shortcode_data['carousel_auto_play_speed']['all'] ) && ! empty( $shortcode_data['carousel_auto_play_speed']['all'] ) ? $shortcode_data['carousel_auto_play_speed']['all'] : $old_autoplay_speed;
			$old_speed             = isset( $shortcode_data['standard_carousel_scroll_speed'] ) && is_numeric( $shortcode_data['standard_carousel_scroll_speed'] ) ? $shortcode_data['standard_carousel_scroll_speed'] : '600';
			$speed                 = isset( $shortcode_data['standard_carousel_scroll_speed']['all'] ) && ! empty( $shortcode_data['standard_carousel_scroll_speed']['all'] ) ? $shortcode_data['standard_carousel_scroll_speed']['all'] : $old_speed;
			$infinite              = $shortcode_data['carousel_infinite'] ? 'true' : 'false';
			$pause_on_hover        = $shortcode_data['carousel_pause_on_hover'] ? 'true' : 'false';
			$carousel_direction    = isset( $shortcode_data['wpcp_carousel_direction'] ) ? $shortcode_data['wpcp_carousel_direction'] : '';
			$lazy_load_image       = isset( $shortcode_data['wpcp_image_lazy_load'] ) ? $shortcode_data['wpcp_image_lazy_load'] : 'false';
			$draggable             = $shortcode_data['slider_draggable'] ? 'true' : 'false';
			$free_mode             = isset( $shortcode_data['free_mode'] ) && $shortcode_data['free_mode'] ? 'true' : 'false';
			$swipe                 = $shortcode_data['slider_swipe'] ? 'true' : 'false';
			$is_swipetoslide       = isset( $shortcode_data['carousel_swipetoslide'] ) ? $shortcode_data['carousel_swipetoslide'] : true;
			$swipetoslide          = $is_swipetoslide ? 'true' : 'false';
			$rtl                   = ( 'ltr' === $carousel_direction ) ? 'true' : 'false';
			$carousel_classes     .= ' wpcp-standard';
			$wpcp_swiper_options   = 'data-swiper=\'{ "accessibility":true, "spaceBetween":' . $item_gap['top'] . ', "arrows":' . $arrows . ', "freeMode": ' . $free_mode . ', "autoplay":' . $auto_play . ', "autoplaySpeed":' . $autoplay_speed . ', "dots":' . $dots . ', "infinite":' . $infinite . ', "speed":' . $speed . ', "pauseOnHover":' . $pause_on_hover . ',
			"slidesToShow":{"lg_desktop":' . $column_lg_desktop . ', "desktop": ' . $column_desktop . ', "laptop": ' . $column_sm_desktop . ', "tablet": ' . $column_tablet . ', "mobile": ' . $column_mobile . '}, "responsive":{"desktop":' . $desktop_size . ', "laptop": ' . $laptop_size . ', "tablet": ' . $tablet_size . ', "mobile": ' . $mobile_size . '}, "rtl":' . $rtl . ', "lazyLoad": "' . $lazy_load_image . '", "swipe": ' . $swipe . ', "draggable": ' . $draggable . ', "swipeToSlide":' . $swipetoslide . ' }\' ';
			// Carousel Configurations.
			if ( wpcf_get_option( 'wpcp_swiper_js', true ) ) {
				wp_enqueue_script( 'wpcf-swiper-js' );
			}
			wp_enqueue_script( 'wpcf-swiper-config' );
			include WPCAROUSELF_PATH . '/public/templates/carousel.php';
			$html = ob_get_contents();
			return apply_filters( 'sp_wpcp_carousel_slider', $html, $post_id );
		}
		if ( 'grid' === $wpcp_layout ) {
			include WPCAROUSELF_PATH . '/public/templates/gallery.php';
			$html = ob_get_contents();
			return apply_filters( 'sp_wpcp_carousel_gallery', $html, $post_id );
		}
	}

	/**
	 * A shortcode for rendering the carousel.
	 *
	 * @param  integer $attributes The ID the shortcode.
	 * @return void
	 */
	public function sp_wp_carousel_shortcode( $attributes ) {
		if ( empty( $attributes['id'] ) || ( get_post_status( $attributes['id'] ) === 'trash' ) ) {
			return;
		}
		$post_id = intval( $attributes['id'] );

		// Video Carousel.
		$upload_data        = get_post_meta( $post_id, 'sp_wpcp_upload_options', true );
		$shortcode_data     = get_post_meta( $post_id, 'sp_wpcp_shortcode_options', true );
		$main_section_title = get_the_title( $post_id );

		// Stylesheet loading problem solving here. Shortcode id to push page id option for getting how many shortcode in the page.
		$current_page_id    = get_queried_object_id();
		$option_key         = 'sp_wp_carousel_page_id' . $current_page_id;
		$found_generator_id = get_option( $option_key );
		if ( is_multisite() ) {
			$option_key         = 'sp_wp_carousel_page_id' . get_current_blog_id() . $current_page_id;
			$found_generator_id = get_site_option( $option_key );
		}
		ob_start();
		// This shortcode id not in page id option. Enqueue stylesheets in shortcode.
		if ( ! is_array( $found_generator_id ) || ! $found_generator_id || ! in_array( $post_id, $found_generator_id ) ) {

			wp_enqueue_style( 'wpcf-swiper' );
			wp_enqueue_style( 'wp-carousel-free-fontawesome' );
			wp_enqueue_style( 'wp-carousel-free' );

			$the_wpcf_dynamic_css = '';
			include WPCAROUSELF_PATH . '/public/dynamic-style.php';
			$the_wpcf_dynamic_css .= trim( html_entity_decode( wpcf_get_option( 'wpcp_custom_css' ) ) );
			echo '<style id="wp_carousel_dynamic_css' . $post_id . '">' . $the_wpcf_dynamic_css . '</style>';

		}
		if ( $found_generator_id ) {
			$found_generator_id = is_array( $found_generator_id ) ? $found_generator_id : array( $found_generator_id );
			if ( ! in_array( $post_id, $found_generator_id ) || empty( $found_generator_id ) ) {
				// If not found the shortcode id in the page options.
				array_push( $found_generator_id, $post_id );
				if ( is_multisite() ) {
					update_site_option( $option_key, $found_generator_id );
				} else {
					update_option( $option_key, $found_generator_id );
				}
			}
		} else {
			// If option not set in current page add option.
			if ( $current_page_id ) {
				if ( is_multisite() ) {
					add_site_option( $option_key, array( $post_id ) );
				} else {
					add_option( $option_key, array( $post_id ) );
				}
			}
		}

		self::wpcf_html_show( $upload_data, $shortcode_data, $post_id, $main_section_title );
		return ob_get_clean();
	}
}
