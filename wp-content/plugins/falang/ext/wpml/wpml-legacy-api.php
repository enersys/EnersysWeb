<?php

/**
 * Compatibility with WPML legacy API
 * Deprecated since WPML 3.2 and no more documented
 * But a lot of 3rd party plugins / themes are still using these functions
 */


if ( ! function_exists( 'icl_register_string' ) ) {
	/**
	 * Registers a string for translation in the "strings translation" panel
	 *
	 * @since 0.9.3
	 *
	 * @param string $context           the group in which the string is registered, defaults to 'polylang'
	 * @param string $name              a unique name for the string
	 * @param string $string            the string to register
	 * @param bool   $allow_empty_value not used
	 * @param string $source_lang       not used by Polylang
	 */
	function icl_register_string( $context, $name, $string, $allow_empty_value = false, $source_lang = '' ) {
		FALANG_WPML_Compat::instance()->register_string( $context, $name, $string );
	}
}

if ( ! function_exists( 'icl_unregister_string' ) ) {
	/**
	 * Removes a string from the "strings translation" panel
	 *
	 * @since 1.0.2
	 *
	 * @param string $context the group in which the string is registered, defaults to 'polylang'
	 * @param string $name    a unique name for the string
	 */
	function icl_unregister_string( $context, $name ) {
		FALANG_WPML_Compat::instance()->unregister_string( $context, $name );
	}
}

if ( ! function_exists( 'icl_t' ) ) {
	/**
	 * Gets the translated value of a string ( previously registered with icl_register_string or pll_register_string )
	 *
	 * @since 0.9.3
	 * @since 1.9.2 argument 3 is optional
	 * @since 2.0   add support for arguments 4 to 6
	 *
	 * @param string      $context         the group in which the string is registered
	 * @param string      $name            a unique name for the string
	 * @param string      $string          the string to translate, optional for strings registered with icl_register_string
	 * @param bool|null   $has_translation optional, not supported in Polylang
	 * @param bool        $bool            optional, not used
	 * @param string|null $lang            optional, return the translation in this language, defaults to current language
	 * @return string the translated string
	 */
	function icl_t( $context, $name, $string = false, &$has_translation = null, $bool = false, $lang = null ) {
		return icl_translate( $context, $name, $string, false, $has_translation, $lang );
	}
}

if ( ! function_exists( 'icl_translate' ) ) {
	/**
	 * Undocumented function used by NextGen Gallery
	 * used in PLL_Plugins_Compat for Jetpack with only 3 arguments
	 *
	 * @since 1.1   add support for arguments 5 and 6, strings are no more automatically registered
	 *
	 * @param string      $context         the group in which the string is registered
	 * @param string      $name            a unique name for the string
	 * @param string      $string          the string to translate, optional for strings registered with icl_register_string
	 * @param bool        $bool            optional, not used
	 * @param bool|null   $has_translation optional, not supported in Falang/Polylang
	 * @param string|null $lang            optional, return the translation in this language, defaults to current language
	 * @return string the translated string
	 */
	function icl_translate( $context, $name, $string = false, $bool = false, &$has_translation = null, $lang = null ) {
		// FIXME WPML can automatically registers the string based on an option
		if ( empty( $string ) ) {
			$string = FALANG_WPML_Compat::instance()->get_string_by_context_and_name( $context, $name );
		}
		return empty( $lang ) ? falang__( $string ) : falang_translate_string( $string, $lang );
	}
}

