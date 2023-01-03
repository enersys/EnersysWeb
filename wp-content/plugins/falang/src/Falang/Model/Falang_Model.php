<?php

namespace Falang\Model;

use Falang\Core\Falang_Core;
use Falang\Core\Falang_Mo;
use Falang\Core\Language;

class Falang_Model {

	/**
	 * @from 1.0
	 *
	 * @var string
	 */
	var $option_name = 'falang';

	public $options;

	public $languages = null;
	public $languages_list = null;
	public $term_languages = null;


	/**
	 * Constructor
	 * setups translated objects sub models
	 * setups filters and actions
	 *
	 * @since 1.0
	 *
	 * @param array $options Falang options
	 */
	public function __construct() {
		$this->options = get_option($this->option_name);
		//add_filter( 'get_terms_args', array( $this, 'get_terms_args' ) );

	}

	/*
	 * Returns the list of available languages
	 *
 	 * List of parameters accepted in $args:
	 *
	 * args hide_default
	 * args hide_empty
	 * @since 1.0
	 * TODO Cache list the full and filter on it
	 * TODO BUG possible if the first call filter by hide_default
	 */
	public function get_languages_list( $args = array() ) {

		$hide_default = !isset($args['hide_default'])?false:$args['hide_default'];
		$default_locale = isset($this->options['default_language'])?$this->options['default_language']:'en_US';

		if (isset($this->languages)){
			$lg = $this->languages;
			if($hide_default){
				foreach ( $lg as $k => $v ) {
					if (($v->locale == $default_locale) ) {
						array_splice($lg,$k,1);
					}
				}
			}
			return $lg;
		}
		//get the list and apply filter
		if (!isset($this->languages_list)){
			$this->languages_list = get_terms( 'language', array( 'hide_empty' => false ) );
		}
		$languages = $this->languages_list;

		$languages = empty( $languages ) || is_wp_error( $languages ) ? array() : $languages;

		if (!isset($this->term_languages)){
			$this->term_languages = get_terms( 'term_language', array( 'hide_empty' => false ) );
		}
		$term_languages = $this->term_languages;
		$term_languages = empty( $term_languages ) || is_wp_error( $term_languages ) ?
			array() : array_combine( wp_list_pluck( $term_languages, 'slug' ), $term_languages );
		if ( ! empty( $languages ) && ! empty( $term_languages ) ) {
			// Don't use array_map + create_function to instantiate an autoloaded class as it breaks badly in old versions of PHP
			foreach ( $languages as $k => $v ) {
//                if ($hide_default && ($v->slug == $default_slug) ){
//	                unset($languages[$k]);
 //               } else {
	                $languages[ $k ] = new \Falang\Core\Language( $v, $term_languages[ 'falang_' . $v->slug ] );
 //               }
			}

			$languages = apply_filters( 'falang_languages_list', $languages, $this );
		}	else {
			$languages = array(); // In case something went wrong
		}

        //order $languages by order
        usort($languages, array($this, "cmp"));

		$this->languages = $languages;

		if (isset($this->languages)){
			$lg = $this->languages;
			if($hide_default){
				foreach ( $lg as $k => $v ) {
					if (($v->locale == $default_locale) ) {
						array_splice($lg,$k,1);
					}
				}
			}
			return $lg;
		}

		return $this->languages;
	}

	//order array use for languages
    private function cmp($a, $b) {
	    if (isset($a->order) && isset($b->order)){
            return strcmp($a->order, $b->order);
        } else {
	        return 0;
        }
    }

	/**
	 * Get the list of predefined languages
	 *
	 * @since 1.0
	 */
	public function get_predefined_languages() {
		require_once ABSPATH . 'wp-admin/includes/translation-install.php';
		include FALANG_INC . '/languages.php';

		$translations = wp_get_available_translations();

		// Keep only languages with existing WP language pack
		// Unless the transient has expired and we don't have an internet connection to refresh it
		if ( ! empty( $translations ) ) {
			$translations['en_US'] = ''; // Languages packs don't include en_US
			$languages = array_intersect_key( $languages, $translations );
		}

		/**
		 * Filter the list of predefined languages
		 * The languages arrays use associative keys instead of numerical keys
		 * @see inclues/languages.php
		 *
		 * @param array $languages
		 */
		$languages = apply_filters( 'falang_predefined_languages', $languages );

		// Keep only languages with all necessary informations
		foreach ( $languages as $k => $lang ) {
			if ( ! isset( $lang['code'], $lang['locale'], $lang['name'], $lang['dir'], $lang['flag'] ) ) {
				unset( $languages[ $k ] );
			}
		}

		return $languages;
	}

	/**
	 * Get the default language code
	 * default is en_US
	 * TODO set in the class the Language object
	 *
	 * @since 1.0
	 */
	public function get_default_language(){
		$locale = 'en_US';
		if (isset($this->options['default_language'])){
			$locale = $this->options['default_language'];
		}
		$language = $this->get_language_by_locale($locale);
		return $language;
	}


	/**
	 * Get the list of default languages flags
	 *
	 * @since 1.0
	 */
	public function get_flags_list(){
		include FALANG_INC . '/flags.php';
//TODO Change this not very nice.
		return $flags;
	}

	/**
	 * Adds a new language
	 * Creates a default category for this language
	 *
	 * List of arguments that $args must contain:
	 * name           -> language name ( used only for display )
	 * slug           -> language code ( ideally 2-letters ISO 639-1 language code )
	 * locale         -> WordPress locale. If something wrong is used for the locale, the .mo files will not be loaded...
	 * rtl            -> 1 if rtl language, 0 otherwise
	 *
	 * Optional arguments that $args can contain:
	 * no_default_cat -> if set, no default category will be created for this language
	 * flag           -> country code, see flags.php
	 *
	 * @since 1.0
     * @cince 1.3.20 reset language list only 1 time / make soft rewrite rules
     *
	 *
	 * @param array $args
	 * @return bool true if success / false if failed
	 */
	public function add_language($args){

		$errors = $this->validate_lang( $args );
		if ( $errors->get_error_code() ) { // Using has_errors() would be more meaningful but is available only since WP 5.0
			add_settings_error('general',$errors->get_error_code(),$errors->get_error_message(),'error');
			return false;
		}

		// First add the language taxonomy
		$description = serialize( array( 'locale' => $args['locale'], 'rtl' => (int) $args['rtl'], 'flag_code' => empty( $args['flag'] ) ? '' : $args['flag'], 'order' => empty( $args['order'] ) ? '' : $args['order'] ) );
		$r = wp_insert_term( $args['name'], 'language', array( 'slug' => $args['slug'], 'description' => $description ) );
		if ( is_wp_error( $r ) ) {
			// Avoid an ugly fatal error if something went wrong ( reported once in the forum )
			add_settings_error( 'general', 'falang_add_language', __( 'Impossible to add the language', 'falang' ) );
			return false;
		}

		// The term_language taxonomy
		// Don't want shared terms so use a different slug
		wp_insert_term( $args['name'], 'term_language', array( 'slug' => 'falang_' . $args['slug'] ) );

        // Update the languages list now ! to be find by get_language_by_slug
        $this->reset_languages_list();
        // Init a mo_id for this language
		$mo = new Falang_Mo();
		$mo->export_to_db( $this->get_language_by_slug( $args['slug'] ) );


		// Attempts to install the language pack
		if ( 'en_US' !== sanitize_html_class($_POST['locale'])) {
			require_once ABSPATH . 'wp-admin/includes/translation-install.php';
			if ( ! wp_download_language_pack( sanitize_html_class($_POST['locale']) ) ) {
				add_settings_error( 'general', 'falang_download_mo', __( 'The language was created, but the WordPress language file was not downloaded. Please install it manually.', 'falang' ) );
			}

			// Force checking for themes and plugins translations updates
			wp_clean_themes_cache();
			wp_clean_plugins_cache();
		}

		/**
		 * Fires when a language is added
		 * @param array $args arguments used to create the language
		 */
		do_action( 'falang_add_language', $args );

//		$this->clean_languages_cache(); // Again to set add mo_id in the cached languages list
        flush_rewrite_rules(false); // Refresh rewrite rules soft

		add_settings_error( 'general', 'falang_languages_created', __( 'Language added', 'falang' ), 'updated' );
		return true;

	}


	/**
	 * Update language properties
	 *
	 * List of arguments that $args must contain:
	 * lang_id    -> term_id of the language to modify
	 * name       -> language name ( used only for display )
	 * slug       -> language code ( ideally 2-letters ISO 639-1 language code
	 * locale     -> WordPress locale. If something wrong is used for the locale, the .mo files will not be loaded...
	 * rtl        -> 1 if rtl language, 0 otherwise
	 *
	 * Optional arguments that $args can contain:
	 * flag       -> country code, see flags.php
	 *
	 * @since 1.0
	 * @since 1.3.3 fix error display
	 *
	 * @param array $args
	 * @return bool true if success / false if failed
	 */
	public function update_language( $args ) {
    	$lang = $this->get_language( (int) $args['language_id'] );

		$errors = $this->validate_lang( $args, $lang );
		if ( $errors->get_error_code() ) { // Using has_errors() would be more meaningful but is available only since WP 5.0
			add_settings_error('general',$errors->get_error_code(),$errors->get_error_message(),'error');
			return false;
		}

		// Update links to this language in posts and terms in case the slug has been modified
		$slug = $args['slug'];
		$old_slug = $lang->slug;

		update_option( 'falang', $this->options );

		// And finally update the language itself
		$description = serialize( array( 'locale' => $args['locale'],
                'rtl' => (int) $args['rtl'],
                'flag_code' => empty( $args['flag'] ) ? '' : $args['flag'] ,
                'custom_flag' => empty( $args['custom_flag'] ) ? '' : $args['custom_flag'] ,
                'order' => $args['order'])
                                );
		wp_update_term( (int) $lang->term_id, 'language', array( 'slug' => $slug, 'name' => $args['name'], 'description' => $description ) );
		wp_update_term( (int) $lang->tl_term_id, 'term_language', array( 'slug' => 'falang_' . $slug, 'name' => $args['name'] ) );

		/**
		 * Fires when a language is updated
		 *
		 * @since 1.0
		 *
		 * @param array $args arguments used to modify the language
		 */
		do_action( 'falang_update_language', $args );

		//$this->clean_languages_cache();
		flush_rewrite_rules(); // Refresh rewrite rules
		add_settings_error( 'general', 'falang_languages_updated', __( 'Language updated', 'falang' ), 'updated' );
		return true;
	}


    /**
     * Update language order
     *
     * @since 1.3.9
     *
     * @param Language $language optional the language currently updated, the language is created if not set
     * @param int order order of langauge
     * @return bool true if success / false if failed
     */
    public function update_language_order( Language $language , $order )
    {
        $description = unserialize($language->description);
        $description['order'] = $order;
        $new_description = serialize($description);
        $update = wp_update_term( (int) $language->term_id, 'language', array( 'slug' => $language->slug, 'name' => $language->name, 'description' => $new_description) );
        if ( ! is_wp_error( $update ) ) {
            return true;
        } else {
            return false;
        }
    }

	/**
	 * Validates data entered when creating or updating a language
	 *
	 * @since 1.0
	 *
	 * @param array  $args
	 * @param object $lang optional the language currently updated, the language is created if not set
	 * @return bool true if success / false if failed
	 */
	protected function validate_lang( $args, $lang = null ) {
		$errors = new \WP_Error();

		// Validate locale with the same pattern as WP 4.3. See #28303
		if ( ! preg_match( '#^[a-z]{2,3}(?:_[A-Z]{2})?(?:_[a-z0-9]+)?$#', $args['locale'], $matches ) ) {
			$errors->add('falang_invalid_locale', __( 'Enter a valid WordPress locale', 'falang' ) );
		}

		// Validate slug characters
		if ( ! preg_match( '#^[a-z_-]+$#', $args['slug'] ) ) {
			$errors->add( 'falang_invalid_slug', __( 'The SEF language code contains invalid characters', 'falang' ) );
		}

		// Validate slug is unique
		foreach ( $this->get_languages_list() as $language ) {
			if ( $language->slug === $args['slug'] && ( null === $lang || ( isset( $lang ) && $lang->term_id != $language->term_id ) ) ) {
				$errors->add( 'falang_non_unique_slug', __( 'The language code must be unique', 'falang' ) );
			}
		}

		// Validate name
		// No need to sanitize it as wp_insert_term will do it for us
		if ( empty( $args['name'] ) ) {
			$errors->add( 'falang_invalid_name', __( 'The language must have a name', 'falang' ) );
		}

		// Validate flag
		if ( ! empty( $args['flag'] ) && ! file_exists( FALANG_DIR . '/flags/' . $args['flag'] . '.png' ) ) {
			$errors->add('falang_invalid_flag', __( 'The flag does not exist', 'falang' ) );
		}
		return $errors;
	}


	public function delete_language($language_id){
		global $wpdb;

		$language = $this->get_language( (int) $language_id );

		if ( empty( $language ) ) {
			return;
		}

		$prefix = Falang_Core::get_prefix($language->locale);

		//default language can't be delete

		// Delete all post translations
//		$post_meta_keys = array_merge($this->fields, $this->get_all_translatable_post_meta_keys());
//
//		if ($post_meta_keys) {
//
//			$post_meta_keys = esc_sql($this->prefix_array($post_meta_keys, $prefix));
//
//			$wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key IN ('".implode("','", $post_meta_keys)."')");
//
//		}
//
//		//deleta all local posts
//
//		// DELETE ALL TERM TRANSLATIONS !
//		$term_meta_keys = array_merge($this->taxonomy_fields, $this->get_all_translatable_term_meta_keys());
//
//		if ($term_meta_keys) {
//
//			$term_meta_keys = esc_sql($this->prefix_array($term_meta_keys, $prefix));
//
//			$wpdb->query("DELETE FROM $wpdb->termmeta WHERE meta_key IN ('".implode("','", $term_meta_keys)."')");
//
//		}


		// Delete menus locations

		// Delete users options

		// Delete the string translations
		//$post = wpcom_vip_get_page_by_title( 'falang_mo_' . $language->term_id, OBJECT, 'falang_mo' );
		$post = get_page_by_title( 'falang_mo_' . $language->term_id, OBJECT, 'falang_mo' );
		if ( ! empty( $post ) ) {
			wp_delete_post( $post->ID );
		}

		// Delete domain

		// Delete the language itself
		wp_delete_term( $language->term_id, 'language' );
		wp_delete_term( $language->tl_term_id, 'term_language' );


		// Update languages list
		$this->reset_languages_list();

		update_option( 'falang', $this->options );
		flush_rewrite_rules(); // refresh rewrite rules
		add_settings_error( 'general', 'falang_languages_deleted', __( 'Language deleted', 'falang' ), 'updated' );

	}

	//TODO ugly function remove it
    //look at the polylang clean_languages_cache
	public function reset_languages_list(){
		$this->languages = null;
		$this->languages_list = null;
		$this->term_languages = null;
		$this->get_languages_list();
	}

	/**
	 * Returns the language by its term_id, tl_term_id, slug or locale
	 * TODO Work only with term_id need to be updated
	 * @since 1
	 *
	 * @param int|string $value term_id, tl_term_id, slug or locale of the queried language
	 * @return object|bool PLL_Language object, false if no language found
	 */
	public function get_language( $value ) {
		if ( is_object( $value ) ) {
			return $value instanceof \Falang\Core\Language ? $value : $this->get_language( $value->term_id ); // will force cast to Language object
		}

		//$term_languages = get_terms( 'term_language', array( 'hide_empty' => false ) );
	    if (!isset($this->term_languages)){
		    $this->term_languages = get_terms( 'term_language', array( 'hide_empty' => false ) );
	    }
		$term_languages = $this->term_languages;

		foreach ($this->get_languages_list() as $k => $v) {
			if ($v->term_id == $value) {
				//$return = new \Falang\Core\Language( $v, $term_languages[ 'falang_' . $v->slug ] );
				$return = $v;

			}
		}
		return $return;
	}

	/*
	 * Get Language object by it's slug
	 * TODO put in other place
	 * since 1.0
	 * */
	public function get_language_by_slug($slug){
		//$term_languages = get_terms( 'term_language', array( 'hide_empty' => false ) );
		foreach ($this->get_languages_list() as $k => $v) {
			if ($v->slug == $slug) {
				//$return = new \Falang\Core\Language( $v, $term_languages[ 'falang_' . $v->slug ] );
				return $v;
			}
		}
		return null;
	}

	public function get_language_by_locale($locale){
		//$term_languages = get_terms( 'term_language', array( 'hide_empty' => false ) );
		foreach ($this->get_languages_list() as $k => $v) {
			if ($v->locale == $locale) {
				//$return = new \Falang\Core\Language( $v, $term_languages[ 'falang_' . $v->slug ] );
				return $v;
			}
		}
		return null;
	}

	/**
	 * get an array of all languages values for one field
	 *
	 *	@from 1.0
	 *
	 * @param string $column.
	 * @return array
	 */
	public function get_language_column($column){
		$output = array();

		$languages = $this->get_languages_list();

		foreach ($languages as $language) {

			$output[] = isset($language->$column) ? $language->$column : false;

		}

		return $output;
	}
	/**
	 * Updates the default language
	 *
	 * @since 1.0
     * @since 1.3.30 update site language too
	 *
	 * @param string $locale new language slug
	 */
	public function update_default_lang( $locale ) {

        if (!empty($locale)){
            // Update falang default language in options
            $this->options['default_language'] = $locale;
            update_option( 'falang', $this->options );

            update_option('need_flush', 1);
            //site Language
            if ($locale == 'en_US') {
                update_option('WPLANG','');
            } else {
                update_option('WPLANG',$locale);
            }

        }

	}


	/**
	 * Returns post types that need to be translated
	 * TODO the post types list is cached for better better performance
	 * TODO Check is the right way with the below method get_transtable_post_types
	 * wait for 'after_setup_theme' to apply the cache to allow themes adding the filter in functions.php
	 *
	 * @since 1.0
	 *
	 * @param bool $filter true if we should return only valid registered post types
	 *  @param $excluded_post_type post type who need to be removed.(specific admin menu ex : menu,products....)
	 * @return array post type names for which Falang manages languages and translations
	 */
	public function get_translated_post_types( $filter = true , $excluded_post_type = null) {
		$post_types = get_post_types(array(), 'names' );
//		if ( false === $post_types = $this->cache->get( 'post_types' ) ) {
			//$post_types = array( 'post' => 'post', 'page' => 'page', 'wp_block' => 'wp_block','nav_menu_item' => 'nav_menu_item' );

			//TODO no option to translate post type
//			if ( ! empty( $this->options['media_support'] ) ) {
//				$post_types['attachment'] = 'attachment';
//			}

			if (!empty($excluded_post_type)){
				foreach ($excluded_post_type as $pt){
					unset($post_types[$pt]);
				}
			}

			if ( ! empty( $this->options['post_types'] ) && is_array( $this->options['post_types'] ) ) {
				$post_types = array_merge( $post_types, array_combine( $this->options['post_types'], $this->options['post_types'] ) );
			}

			/**
			 * Filter the list of post types available for translation.
			 * The default are post types which have the parameter ‘public’ set to true.
			 * The filter must be added soon in the WordPress loading process:
			 * in a function hooked to ‘plugins_loaded’ or directly in functions.php for themes.
			 *
			 * @since 1.0
			 *
			 * @param array $post_types  list of post type names
			 * @param bool  $is_settings true when displaying the list of custom post types in Falang settings
			 */
			$post_types = apply_filters( 'falang_get_post_types', $post_types, false );

//			if ( did_action( 'after_setup_theme' ) ) {
//				$this->cache->set( 'post_types', $post_types );
//			}
//		}

		return $filter ? array_intersect( $post_types, get_post_types() ) : $post_types;
	}

	/*
	 *  Return post type that can be translated due to falang option
	 *
	 *  @since 1.0
	 *
	 *  @param bool $filter true remove the default excluded post type
	 */
	public function get_transtable_post_types($filter=false){
		$exluded_post_type    = array( 'nav_menu_item','revision' );
		$post_types = $this->options['post_type'];
		foreach ($post_types as $index => $pt){
			if (isset($pt['translatable']) && $pt['translatable'] === false){
				unset($post_types[$index]);
			}
			if ($filter && in_array($index,$exluded_post_type)){
				unset($post_types[$index]);
			}
		}
		return array_keys($post_types);
	}

	/**
	 * Returns true if Falang manages languages and translations for this post type
	 *
	 * @since 1.0
	 *
	 * @param string|array $post_type post type name or array of post type names
	 * @return bool
	 */
	public function is_translated_post_type( $post_type ) {
		$post_types = $this->get_translated_post_types( false );
		return ( is_array( $post_type ) && array_intersect( $post_type, $post_types ) || in_array( $post_type, $post_types ) || 'any' === $post_type && ! empty( $post_types ) );
	}


	/*
	 *  Return term/taxo type that can be translated due to falang option
	 *
	 *  @since 1.0
	 *
	 *  @param bool $filter true remove the default excluded post type
	 */
	public function get_transtable_taxonomy_types($filter=false){
		$exluded_taxonomy_type    = array();
		$term_types = $this->options['taxonomy'];
		foreach ($term_types as $index => $tt){
			if (isset($tt['translatable']) && $tt['translatable'] === false){
				unset($term_types[$index]);
			}
			if ($filter && in_array($index,$exluded_taxonomy_type)){
				unset($term_types[$index]);
			}
		}
		return array_keys($term_types);
	}

	/*
	 * ref from www/wp-content/plugins/bogo/includes/functions.php
	 *
	 */

	//TODO check but must be removed.get_language_list is better

	public function get_available_locales($args = null) {
		$defaults = array(
			'exclude' => array(),
			'exclude_enus_if_inactive' => false,
			'current_user_can_access' => false,
		);

		$args = wp_parse_args( $args, $defaults );

		static $installed_locales = array();


		if ( empty( $installed_locales ) ) {
			//All language alwasy visible
			//CHANGE this with a param's
			$installed_locales[] = 'all';

			foreach ($this->get_languages_list() as $language)
			{
				$installed_locales[] = $language->locale;
			}

			$installed_locales[] = $this->get_default_locale();
		}

		$available_locales = $installed_locales;

//		if ( $args['current_user_can_access']
//		     && ! current_user_can( 'bogo_access_all_locales' ) ) {
//			$user_accessible_locales = bogo_get_user_accessible_locales(
//				get_current_user_id() );
//
//			$available_locales = array_intersect( $available_locales,
//				(array) $user_accessible_locales );
//		}
//
		if ( ! empty( $args['exclude'] ) ) {
			$available_locales = array_diff( $available_locales,
				(array) $args['exclude'] );
		}
//
//		if ( $args['exclude_enus_if_inactive']
//		     && bogo_is_enus_deactivated() ) {
//			$available_locales = array_diff( $available_locales,
//				array( 'en_US' ) );
//		}

		return array_unique( array_filter( $available_locales ) );


	}

	/*
	 * ref from www/wp-content/plugins/bogo/includes/functions.php
	 * don't support mulitsite and will not
	 *
	*/
	public function get_default_locale(){
		static $locale = '';
		if ( ! empty( $locale ) ) {
			return $locale;
		}

		if ( defined( 'WPLANG' ) ) {
			$locale = WPLANG;
		}

		$db_locale = get_option( 'WPLANG' );

		if ( $db_locale !== false ) {
			$locale = $db_locale;
		}

		if ( ! empty( $locale ) ) {
			return $locale;
		}

		return 'en_US';

	}

	/**
	 * Get option
	 *
	 * @param string $option_name. Option name
	 * @param mixed $default. Default value if option does not exist
	 * @return mixed
	 *
	 * @from 1.4.7
	 */
	public function get_option($option_name, $default = false) {
		if (isset($this->options[$option_name])) {

			return $this->options[$option_name];

		}

		return $default;
	}

	/**
	 * Update Option
	 *
	 * @from 2.0
	 */
	public function update_option($option_name, $value) {

		$options = get_option($this->option_name);
		$options[$option_name] = $value;
		update_option($this->option_name, $options);

	}

	/**
	 * Delete Option
	 *
	 * @from 2.0
	 */
	public function delete_option($option_name) {

		$options = get_option($this->option_name);
		unset($options[$option_name]);
		update_option($this->option_name, $options);

	}

	/*
	 * reload option in models
	 * @since 1.3.24
	 * */
    public function reload_options(){
        $this->options = get_option($this->option_name);
    }
}