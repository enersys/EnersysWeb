<?php
/**
 * Add User Profile Description translation
 *
 * @since 1.3.4
 */

namespace Falang\Filter\Site;


class User_Profile {

	/**
	 * Constructor
	 *
	 * @since 1.3.1
	 *
	 */
	public function __construct( ) {
		// Translates biography
		add_filter( 'get_user_metadata', array( $this, 'translate_user_metadata' ), 10, 4 );
	}

	/**
	 * Translates biography
	 *
	 * @since 1.3.4
	 *
	 * @param null   $null
	 * @param int    $id       User id
	 * @param string $meta_key
	 * @param bool   $single   Whether to return only the first value of the specified $meta_key
	 * @return null|string
	 */
	public function translate_user_metadata( $null, $id, $meta_key, $single ) {
		//stacic is used to disalow loop when default translated description loaded
		static $disable_profile = false;

		if ($disable_profile) {
			return $null;
		}
		if ('description' === $meta_key && !Falang()->is_default()){
			$key = '_'.Falang()->get_current_language()->locale.'_'.$meta_key;
			$translated_descrition = get_user_meta($id,$key,$single);
			if (!empty($translated_descrition)){
				return $translated_descrition;
			} else {
				$disable_profile = true;
				return get_user_meta($id,'description',$single);
			}

		} else {
			return $null;
		}
	}
}