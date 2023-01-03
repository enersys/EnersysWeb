<?php

/**
 * A class to handle the WPML API based on hooks, introduced since WPML 3.2
 * It partly relies on the legacy API
 *
 * @see https://wpml.org/documentation/support/wpml-coding-api/wpml-hooks-reference/
 *
 * @since 1.0
 */
class FALANG_WPML_API {
	private static $original_language = null;

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {

		// Retrieving Localized Content
		add_filter( 'wpml_translate_single_string', array( $this, 'wpml_translate_single_string' ), 10, 4 );

		// Inserting Content
		add_action( 'wpml_register_single_string', 'icl_register_string', 10, 3 );

	}

	/**
	 * Translates a string
	 *
	 * @since 1.3
	 *
	 * @param string      $string  The string's original value
	 * @param string      $context The string's registered context
	 * @param string      $name    The string's registered name
	 * @param null|string $lang    Optional, return the translation in this language, defaults to current language
	 * @return string The translated string
	 */
	public function wpml_translate_single_string( $string, $context, $name, $lang = null ) {
		$has_translation = null; // Passed by reference
		return icl_translate( $context, $name, $string, false, $has_translation, $lang );
	}

}