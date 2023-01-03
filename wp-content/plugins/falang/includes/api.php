<?php

/**
 * Translates a string ( previously registered with wpml_register_string )
 *
 * @param string $string the string to translate
 * @return string the string translation in the current language
 * @since 1.1
 * @since 1.3.28 manage string with encoded caractere
 *
 */
function falang__($string)
{
    return is_scalar($string) ? __(wp_specialchars_decode($string), 'falang_string') : $string; // PHPCS:ignore WordPress.WP.I18n
}

/**
 * Translates a string ( previously registered with falang_register_string )
 *
 * @param string $string the string to translate
 * @param string $lang language code
 * @return string the string translation in the requested language
 * @since 1.1
 *
 */
function falang_translate_string( $string, $lang ) {

	if (Falang() instanceof Falang_Public &&  falang_current_language() == $lang ) {
		return falang__( $string );
	}

	if ( ! is_scalar( $string ) ) {
		return $string;
	}

	static $cache; // Cache object to avoid loading the same translations object several times

	if ( empty( $cache ) ) {
		$cache = new Falang\Core\Cache();
	}

	if ( false === $mo = $cache->get( $lang ) ) {
		$mo = new Falang\Core\FALANG_MO();
		$mo->import_from_db( FALANG()->get_model()->get_language_by_slug( $lang ) );
		$cache->set( $lang, $mo );
	}

	return $mo->translate( $string );
}

/**
 * Returns the current language on frontend
 * Returns the language set in admin language filter on backend ( false if set to all languages )
 *
 * @since 1.1
 *
 * @param string $field Optional, the language field to return ( see Falang Language ), defaults to 'slug', pass OBJECT constant to get the language object.
 * @return string|Falang_Language|bool The requested field for the current language
 */
function falang_current_language( $field = 'slug' ) {
	if ( OBJECT === $field ) {
		return Falang()->current_language;
	}
	return isset( Falang()->current_language->$field ) ? Falang()->current_language->$field : false;
}

/**
 * Registers a string for translation in the "strings translation" panel
 *
 * @since 1.3.2
 *
 * @param string $name      a unique name for the string
 * @param string $string    the string to register
 * @param string $context   optional the group in which the string is registered, defaults to 'falang'
 * @param bool   $multiline optional whether the string table should display a multiline textarea or a single line input, defaults to single line
 */
function falang_register_string( $name, $string, $context = 'falang', $multiline = false ) {
	if ( Falang() instanceof Falang_Admin ) {
		//PLL_Admin_Strings::register_string( $name, $string, $context, $multiline );//polylang method
		FALANG_WPML_Compat::instance()->register_string( $context, $name, $string );
	}
}

/**
 * Our own version of wc_clean to prevent errors in case WC gets deactivated
 * @param  array|string $var
 * @return array|string
 */
function falang_clean( $var ) {
	if ( is_callable( 'wc_clean' ) ) {
		return wc_clean( $var );
	} else {
		if ( is_array( $var ) ) {
			return array_map( 'wpla_clean', $var );
		} else {
			return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		}
	}
}

/**
 * Display message when paid version activated
 * Since 1.3.29
 */
function display_free_message(){
    $file_path = 'falang-pro/falang-pro.php';
   if (!is_plugin_active($file_path)) {
      echo '    
        <div class="falang_free_msgr">
            <div class="alert alert-warning">
             <p>';
                echo __('You are using the FREE version of Falang.<br />Support the development by upgrading to the paid version: you will get full functionality as well as on-site support', 'falang');
                echo '
             </p>
                <a class="btn btn-free-msg" target="_blank"
                    href="https://www.faboba.com/en/wordpress/falang-for-wordpress/telechargement-achat.html?utm_source=WordPress&utm_medium=upgradebutton&utm_campaign=freeversion">
                    <i class="fas fa-heart"></i>';
                        echo __("Upgrade to Paid", "falang");
                    echo '
                </a>
             </div>
        </div>
    ';
   }
}

/**
 * Allows to access the Falang instance
 * It is always preferable to use API functions
 * Internal methods may be changed without prior notice
 *
 * @since 1.1
 */
function FALANG() { // PHPCS:ignore WordPress.NamingConventions.ValidFunctionName
	return $GLOBALS['falang_core'];
}
