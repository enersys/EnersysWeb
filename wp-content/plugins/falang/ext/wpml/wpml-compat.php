<?php
/**
 * WPML Compatibility class
 * Defines some WPML constants
 * Registers strings in a persistent way as done by WPML
 * from polylang
 *
 * @since 1.1
 */

use Falang\Core\Falang_Mo;

class FALANG_WPML_Compat {
	protected static $instance; // For singleton
	protected static $strings; // Used for cache
	public $api;

	/**
	 * Constructor
	 *
	 * @since 1.1
	 */
	protected function __construct() {
		// Load the WPML API
		require_once FALANG_EXT . '/wpml/wpml-legacy-api.php';
		require_once FALANG_EXT . '/wpml/wpml-api.php';
		$this->api = new FALANG_WPML_API();

		self::$strings = get_option( 'falang_wpml_strings', array() );
		add_filter( 'falang_get_strings', array( $this, 'get_strings' ) );

	}

	/**
	 * Access to the single instance of the class
	 *
	 * @since 1.1
	 *
	 * @return object
	 */
	public static function instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


	/**
	 * Unlike pll_register_string, icl_register_string stores the string in database
	 * so we need to do the same as some plugins or themes may expect this
	 * we use a serialized option to do this
	 *
	 * @since 1.0.2
	 *
	 * @param string $context The group in which the string is registered.
	 * @param string $name    A unique name for the string.
	 * @param string $string  The string to register.
	 */
	public function register_string( $context, $name, $string ) {
		$fmodel = new \Falang\Model\Falang_Model();
		// If a string has already been registered with the same name and context, let's replace it.
		$exist_string = $this->get_string_by_context_and_name( $context, $name );
		if ( $exist_string && $exist_string !== $string ) {
			$languages = $fmodel->get_languages_list(array( 'hide_default' => true));
			// Assign translations of the old string to the new string, except for the default language.
			foreach ( $languages as $language ) {
				$mo = new FALANG_MO();
				$mo->import_from_db( $language );
				/**
				 * Filter the string translation before it is saved in DB
				 * Allows to sanitize strings registered with pll_register_string
				 *
				 * @since 1.3.2
				 *
				 * @param string $translation The string translation.
				 * @param string $name        The name as defined in pll_register_string.
				 * @param string $context     The context as defined in pll_register_string.
				 */
				//$translation = apply_filters( 'falang_sanitize_string_translation', $mo->translate( $exist_string ), $string, $context );
				$translation = apply_filters( 'falang_sanitize_string_translation', $mo->translate( $exist_string ), $string );

				$mo->add_entry( $mo->make_entry( $string, $translation ) );
				$mo->export_to_db( $language );
			}
			$this->unregister_string( $context, $name );

		}

		// Registers the string if it does not exist yet (multiline as in WPML).
		$to_register = array( 'context' => $context, 'name' => $name, 'string' => $string, 'multiline' => true, 'icl' => true );
		if ( ! in_array( $to_register, self::$strings ) && $to_register['string'] ) {
			$key = md5( "$context | $name" );
			self::$strings[ $key ] = $to_register;
			update_option( 'falang_wpml_strings', self::$strings );
		}


	}

	/**
	 * Adds strings registered by icl_register_string to those registered by falang_register_string
	 *
	 * @since 1.1
	 *
	 * @param array $strings existing registered strings
	 * @return array registered strings with added strings through WPML API
	 */
	public function get_strings( $strings ) {
		return empty( self::$strings ) ? $strings : array_merge( $strings, self::$strings );
	}


	/**
	 * Get a registered string by its context and name
	 *
	 * @since 1.1
	 *
	 * @param string $context The group in which the string is registered.
	 * @param string $name    A unique name for the string.
	 * @return bool|string The registered string, false if none was found.
	 */
	public function get_string_by_context_and_name( $context, $name ) {
		$key = md5( "$context | $name" );
		return isset( self::$strings[ $key ] ) ? self::$strings[ $key ]['string'] : false;
	}

	/**
	 * Removes a string from the registered strings list
	 *
	 * @since 1.1
	 *
	 * @param string $context The group in which the string is registered.
	 * @param string $name    A unique name for the string.
	 */
	public function unregister_string( $context, $name ) {
		$key = md5( "$context | $name" );
		if ( isset( self::$strings[ $key ] ) ) {
			unset( self::$strings[ $key ] );
			update_option( 'falang_wpml_strings', self::$strings );
		}
	}
}
