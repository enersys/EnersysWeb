<?php
/**
 * A fully static class to manage strings translations on admin side
 * from: polylang
 *
 * @link       www.faboba.com
 * @since      1.0
 *
 * @package    Falang
 */

namespace Falang\Core;


class FString {

	static protected $strings = array(); // strings to translate
	static protected $default_strings; // default strings to register

	/**
	 * Add filters
	 *
	 * @since 1.0
	 */
	public static function init() {
	}


	/**
	 * Register strings for translation making sure it is not duplicate or empty
	 *
	 * @since 1.0
	 *
	 * @param string $name      A unique name for the string
	 * @param string $string    The string to register
	 * @param string $context   Optional, the group in which the string is registered, defaults to 'polylang'
	 * @param bool   $multiline Optional, whether the string table should display a multiline textarea or a single line input, defaults to single line
	 */
	public static function register_string( $name, $string, $context = 'falang', $multiline = false ) {
		if ( $string && is_scalar( $string ) ) {
			self::$strings[ md5( $string ) ] = compact( 'name', 'string', 'context', 'multiline' );
		}
	}

	/**
	 * Get registered strings
	 *
	 * @since 0.6.1
     * @since 1.3.13 move the WP strings blogname,blogdescripton,date_format,time_format
	 *
	 * @return array list of all registered strings
	 */
	public static function &get_strings() {
		self::$default_strings = array(
			'widget_title' => __( 'Widget title', 'falang' ),
			'widget_text'  => __( 'Widget text', 'falang' ),
		);

		// Widgets titles
		global $wp_registered_widgets;
		$sidebars = wp_get_sidebars_widgets();
		foreach ( $sidebars as $sidebar => $widgets ) {
			if ( 'wp_inactive_widgets' == $sidebar || empty( $widgets ) ) {
				continue;
			}

			foreach ( $widgets as $widget ) {
				// Nothing can be done if the widget is created using pre WP2.8 API :(
				// There is no object, so we can't access it to get the widget options
				if ( ! isset( $wp_registered_widgets[ $widget ]['callback'][0] ) || ! is_object( $wp_registered_widgets[ $widget ]['callback'][0] ) || ! method_exists( $wp_registered_widgets[ $widget ]['callback'][0], 'get_settings' ) ) {
					continue;
				}

				$widget_settings = $wp_registered_widgets[ $widget ]['callback'][0]->get_settings();
				$number = $wp_registered_widgets[ $widget ]['params'][0]['number'];

				// Don't enable widget translation if the widget is visible in only one language or if there is no title
				if ( empty( $widget_settings[ $number ]['falang_lang'] ) ) {
					if ( isset( $widget_settings[ $number ]['title'] ) && $title = $widget_settings[ $number ]['title'] ) {
						self::register_string( self::$default_strings['widget_title'], $title, 'Widget' );
					}

					if ( isset( $widget_settings[ $number ]['text'] ) && $text = $widget_settings[ $number ]['text'] ) {
						self::register_string( self::$default_strings['widget_text'], $text, 'Widget', true );
					}
				}
			}
		}

		/**
		 * Filter the list of strings registered for translation
		 * Mainly for use by our FALANG_WPML_Compat class
		 *
		 * @since 1.1
		 *
		 * @param array $strings list of strings
		 */
		self::$strings = apply_filters( 'falang_get_strings', self::$strings );

		return self::$strings;
	}


	/**
	 * Performs the sanitization ( before saving in DB ) of default strings translations
	 *
	 * @since 1.1
     * @yodate 1.3.13 clean code
	 *
	 * @param string $translation translation to sanitize
	 * @param string $name        unique name for the string
	 * @return string
	 */
	public static function sanitize_string_translation( $translation, $name ) {
		$translation = wp_unslash( trim( $translation ) );

		if ( $name == self::$default_strings['widget_title'] ) {
			$translation = sanitize_text_field( $translation );
		}

		if ( $name == self::$default_strings['widget_text'] && ! current_user_can( 'unfiltered_html' ) ) {
			$translation = wp_kses_post( $translation );
		}

		return $translation;
	}


}