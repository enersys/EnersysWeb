<?php
/**
 * Created by PhpStorm.
 * User: Stéphane
 * Date: 17/05/2019
 * Time: 11:19
 */

namespace Falang\Core;


use Falang\Model\Falang_Model;

class Post {

	var $post_id;
	var $post_type;
	var $fields = array('post_title', 'post_name','post_content', 'post_excerpt');
	var $metakey;
	var $locale = 'all';
	var $option_name = 'falang';//todo not here



	public function __construct( $post_id = null ) {
		if ($post_id) {
			$this->post_id   = $post_id;
			$this->post_type = get_post_type( $post_id );
			$this->metakey   = get_post_meta( $post_id);
			$this->locale    = $this->get_post_locale();


		}
		//enable the filtering of field (content, exerpt
        $this->fields = $this->get_post_type_fields($this->post_type);

	}

	//TODO make the method
	public function is_published($locale = null){
		//tood check if local exit in configuration
		if (isset($this->metakey) && $this->locale == 'all' && !empty($locale)) {
			if (isset($this->metakey[Falang_Core::get_prefix($locale).'published'])){
				return $this->metakey[Falang_Core::get_prefix($locale).'published'][0];
			}
		}
		return false;
	}
	/**
	 * Get post_type meta keys
	 *
	 * @from 2.0
	 */
	public function query_post_type_metakeys($post_type) {
		global $wpdb;

		$prefixes = array();

		$falang_model = new Falang_Model();
		$languages = $falang_model->get_available_locales(array('exclude' => 'all'));

		foreach ($languages as $language) {

			$prefixes[] = Falang_Core::get_prefix($language);

		}

		$sql_prefixes = implode("%' AND meta.meta_key NOT LIKE '", array_map('esc_sql', $prefixes));
		$sql_blacklist = implode("', '", array_map('esc_sql', $this->get_post_meta_keys_blacklist()));
		$sql_post_type = esc_sql($post_type);

		// find all existing meta data for this post type
		$results = $wpdb->get_results("
			SELECT meta.meta_key, meta.meta_value
			FROM $wpdb->postmeta AS meta
			LEFT JOIN $wpdb->posts AS post ON (post.ID = meta.post_id)
			WHERE post.post_type = '$sql_post_type' AND meta.meta_key NOT LIKE '$sql_prefixes%' AND meta.meta_key NOT IN ('$sql_blacklist')
			GROUP BY meta.meta_key"
		);

		// empty array of meta data sorted by meta keys
		$meta_keys = array();

		// registered meta_keys
		$registered_meta_keys = $this->get_post_type_metakeys($post_type);

		foreach ($registered_meta_keys as $meta_key) {

			$meta_keys[$meta_key] = array();

		}

		// add database results
		foreach ($results as $row) {

			$meta_keys[$row->meta_key][] = substr(wp_strip_all_tags($row->meta_value, true), 0, 120);

		}

		/**
		 * Filter default post type option
		 *
		 * @from 1.0
		 *
		 * @param mixed. Default option
		 */
		$meta_keys = apply_filters("falang_post_type_metakeys", $meta_keys, $post_type);

		ksort($meta_keys);

		return $meta_keys;

	}

	/*
	 * List of post meta keys that should never be translated
	 *
	 * @from 1.5
	 */
	private function get_post_meta_keys_blacklist() {

		return apply_filters('falang_meta_keys_blacklist', array(
			'_wp_attached_file',
			'_wp_attachment_metadata',
			'_edit_lock',
			'_edit_last',
			'_wp_page_template'
		));

	}



	/**
	 *
	 * Get post_type single option for translation.
	 *
	 * @from 1.0

	 * @param string $post_type
	 * @param string $option_name. Accepts 'translatable', 'meta_keys', 'fields', 'title_cached', 'exclude_untranslated'
	 * @param mixed $fallback. Value returned when option is not defined.
	 *
	 * @return mixed
	 */
	public function get_post_type_option($post_type, $option_name, $fallback = false) {

		$post_type_options = $this->get_post_type_options($post_type);

		if (isset($post_type_options[$option_name])) {

			return $post_type_options[$option_name];

		}

		return $fallback;

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

		$options = get_option($this->option_name);

		if (isset($options[$option_name])) {

			return $options[$option_name];

		}

		return $default;
	}

	/**
	 * Get post_type options for translation.
	 *
	 * @from 1.0
	 *
	 * @return mixed
	 */
	public function get_post_types_options() {

		$post_types_options = null; //if set static to post types options problem when saving settings (aka like Taxonomy)

		if (!isset($post_types_options)) {

			$post_types_options = $this->get_option('post_type', array());

		}

		return $post_types_options;
	}


	/**
	 * Get post_type options for translation.
	 *
	 * @from 1.0
	 *
	 * @return mixed
	 */
	public function get_post_type_options($post_type, $default = array()) {

		$post_types_options = $this->get_post_types_options();

		if (isset($post_types_options[$post_type])) {

			$value = $post_types_options[$post_type];

		} else {

			/**
			 * Filter default post type option
			 *
			 * @from 2.3
			 *
			 * @param mixed. Default option
			 */
			$value = apply_filters("falang_default-$post_type", $default);

		}

		return $value;
	}


	/**
	 * Check if post_type is translatable.
	 *
	 * @from 1.0 $post_type should no longer be 'any' or array.
	 * @from 1.4.5
	 *
	 * @param string $post_type
	 *
	 * @return boolean
	 */
	public function is_post_type_translatable($post_type) {
		return $this->get_post_type_option($post_type, 'translatable');
	}

	/**
	 * Get post_type translatable fields.
	 *
	 * @from 1.0
	 *
	 * @param string $post_type
	 *
	 * @return array of strings
	 */
	public function get_post_type_fields($post_type) {

		return $this->get_post_type_option($post_type, 'fields', $this->fields);

	}


	/**
	 * Get post_type translatable meta keys.
	 *
	 * @from 1.0
	 *
	 * @param string $post_type
	 *
	 * @return array of strings
	 */
	public function get_post_type_metakeys($post_type) {

		return $this->get_post_type_option($post_type, 'meta_keys', array());

	}

    /**
     * Translate post meta
     * @from 1.3.8
     *
     * @param object WP_Post $post Post to translate field.
     * @param string $meta_key Meta key.
     * @param bool $single Single meta value.
     * @param object WP_Post $language Language.
     * @param string $fallback Fallback to return if no meta value.
     * @return string|array
     *
     */
    public function translate_post_meta($post, $meta_key, $single, $language = null, $fallback = null) {

        $translation = $this->get_post_meta_translation($post, $meta_key, $single, $language);

        if ($translation) {

            return $translation;

        } else if (isset($fallback)) {

            return $fallback;

        }

        return get_post_meta($post->ID, $meta_key, $single);
    }

	/**
	 * Get post meta translation if it exists
	 *
	 * @from 1.0
     * @update 1.3.8 don't return $default value anymore
	 *
	 * @param object WP_Post $post Post to translate field.
	 * @param string $meta_key Meta key.
	 * @param bool $single Single meta value.
	 * @param object $language Language.
	 * @return string|array|false
	 */
    public function get_post_meta_translation( $post, $meta_key, $single, $language ) {

        global $falang_core;

        //need to load publish as unstranslate_post_meta or infinite loop
        $published = $this->get_untranslated_post_meta( $post->ID, Falang_Core::get_prefix( $language->locale ) . 'published', true );

        if ( $falang_core->is_default( $language ) || !$published ) {
            return $this->get_untranslated_post_meta( $post->ID, $meta_key, $single );
        } else if ( in_array( $meta_key, $this->get_post_type_metakeys( $post->post_type ) ) ) {
            return  $this->get_untranslated_post_meta( $post->ID, Falang_Core::get_prefix( $language->locale ) . $meta_key, $single );
        } else {
            return false;
        }

    }

	/**
	 * Get untranslated post meta
	 *
	 * @from 1.0
	 */
	public function get_untranslated_post_meta($post_id, $meta_key, $single) {

		Falang()->translate_meta = false;

		$value = get_post_meta($post_id, $meta_key, $single);

		Falang()->translate_meta = true;

		return $value;
	}



	/**
	 * Get post locale.'all' by default
	 *
	 * @from 1.0
	 */
	public function get_post_locale() {
		if ( isset( $this->post_id ) ) {
			$locale = get_post_meta( $this->post_id, '_locale', true );
			if ( ! empty( $locale ) ) {
				return $locale;
			} else {
				return $this->locale;
			}
		} else {
			return $this->locale;
		}
	}


	/**
	 * get post field translation
	 *
	 * @from 1.0
	 *
	 * @param object WP_Post $post Post to translate field.
	 * @param object Language $language Language.
	 * @param string $field Field name. Accepts 'post_content', 'post_title', 'post_name', 'post_excerpt'
	 * @param string $fallback Defaut value to return when translation does not exist. Optional.
	 * @return string
	 */
	public function translate_post_field($post, $field, $language = null, $fallback = null) {

		$value = $this->get_post_field_translation($post, $field, $language);

		if ($value) {

			return $value;

		} else if (isset($fallback)) {

			return $fallback;

		}

		return $post->$field;

	}

	/**
	 * get post field translation if it exists
	 * TODO check this method to improve front performance
	 *
	 * @from 1.0
	 *
	 * @param object WP_Post $post Post to translate field.
	 * @param object Language $language Language.
	 * @param string $field Field name. Accepts 'post_content', 'post_title', 'post_name', 'post_excerpt'
	 * @return string
	 */
	public function get_post_field_translation($post, $field, $language = null) {
		global $falang_core;

		//front-part
		if ($falang_core instanceof \Falang_Public) {
			if ( $falang_core->is_default( $language ) ) {
				return $post->$field;
			}

			if ( isset( $language ) && $this->is_post_type_translatable( $post->post_type ) && in_array( $field, $this->get_post_type_fields( $post->post_type ) ) ) {
				//get translation publish //$this->>is_published() ne marche pas car Post n'est pas initilisé en front
				$published = $this->get_untranslated_post_meta( $post->ID, Falang_Core::get_prefix( $language->locale ) . 'published', true );
				if ( $published ) {
					return $this->get_untranslated_post_meta($post->ID, Falang_Core::get_prefix( $language->locale ) . $field, true);;

				} else {
					return $post->$field;
				}
			} else {
				return $post->$field;
			}
		}

		if ($falang_core instanceof \Falang_Admin) {
			return get_post_meta($post->ID,  Falang_Core::get_prefix($language->locale) . $field, true);
		}

		return $post->$field;
	}


	/**
	 * Translate custom post type
	 *
	 * @from 1.0
	 *
	 * @param string $original_cpt. Original custom post type name (e.g 'book')
	 * @param Language $language Object
	 * @return string|false Translated taxonomy if exists.
	 */
	public function get_cpt_translation($original_cpt, $language = null) {

		$falang_model = new Falang_Model();

		if (empty($language)) {

			$language = $falang_model->get_default_language();

		}

		$translations = $this->get_option('translations', array());

		if ($language && isset($translations['post_type'][$original_cpt][$language->locale]) && $translations['post_type'][$original_cpt][$language->locale]) {

			return $translations['post_type'][$original_cpt][$language->locale];

		}
		return false;

	}

	/**
	 * Translate custom post type
	 *
	 * @from 1.1
	 *
	 * @param string $original_cpt. Original custom post type name (e.g 'book')
	 * @param int $language_id. Language id
	 * @param string $fallback Fallback. Optional
	 * @return string Translated cpt (may be equal to original).
	 */
	public function translate_cpt($original_cpt, $language = null, $fallback = null) {

		$translated_cpt = $this->get_cpt_translation($original_cpt, $language);

		if ($translated_cpt) {

			return $translated_cpt;

		} else if (isset($fallback)) {

			return $fallback;

		}

		return $original_cpt;

	}

	/**
	 * get original custom post type
	 *
	 * @from 1.1
	 *
	 * @param string $translated_taxonomy. Translated custom post type name (e.g 'livre')
	 * @param Language $language Object
	 * @return string|false
	 */
	public function get_cpt_original($translated_cpt, $language = null) {

		$falang_model = new Falang_Model();

		if (empty($language)) {

			$language = $falang_model->get_default_language();

		}

		$translations = $this->get_option('translations', array());

		if ($language && isset($translations['post_type'])) {

			foreach ($translations['post_type'] as $original => $translation) {

				if (isset($translation[$language->ID]) && $translation[$language->locale] === $translated_cpt) {

					return $original;

				}

			}

		}

		return false;

	}

	/**
	 * get slug used by custom post type archive link
	 *
	 * @from 2.3
	 *
	 * @param string $original_cpt. Original custom post type name (e.g 'book')
	 * @param int $language_id. Language id
	 * @return string Translated cpt (may be equal to original).
	 */
	public function get_cpt_archive_translation($original_cpt, $language = null) {

		$falang_model = new Falang_Model();

		if (empty($language)) {

			$language = $falang_model->get_default_language();

		}


		$translations = $this->get_option('translations', array());

		if ($language && isset($translations['cpt_archive'][$original_cpt][$language->locale]) && $translations['cpt_archive'][$original_cpt][$language->locale]) {

			return $translations['cpt_archive'][$original_cpt][$language->locale];

		}

		return false;
	}

	/**
	 * Translate slug used by custom post type archive link
	 *
	 * @from 2.3
	 *
	 * @param string $original_cpt. Original custom post type name (e.g 'book')
	 * @param int $language_id. Language id
	 * @param string $fallback Fallback. Optional
	 * @return string Translated cpt (may be equal to original).
	 */
	public function translate_cpt_archive($original_cpt, $language = null, $fallback = null) {

		$translated_cpt = $this->get_cpt_archive_translation($original_cpt, $language);

		if ($translated_cpt) {

			return $translated_cpt;

		} else if (isset($fallback)) {

			return $fallback;

		}

		return $this->translate_cpt($original_cpt, $language, $fallback);
	}

	/**
	 * get original custom post type by translated archive slug
	 *
	 * @from 2.3
	 *
	 * @param string $translated_taxonomy. Translated custom post type name (e.g 'livre')
	 * @param int $language_id. Language id
	 * @return string|false
	 */
	public function get_cpt_archive_original($translated_cpt_archive, $language = null) {

		$falang_model = new Falang_Model();

		if (empty($language)) {

			$language = $falang_model->get_default_language();

		}


		$translations = $this->get_option('translations', array());

		if ($language && isset($translations['cpt_archive'])) {

			foreach ($translations['cpt_archive'] as $original => $translation) {

				if (isset($translation[$language->locale]) && $translation[$language->locale] === $translated_cpt_archive) {

					return $original;

				}

			}

		}

		return $this->get_cpt_original($translated_cpt_archive, $language);
	}

    /**
     * Check whether meta key is translatable
     *
     * @from 1.3.8
     *
     * @param string $meta_key Meta key
     * @return boolean
     */
    public function is_meta_key_translatable($post_type, $meta_key) {

        return $this->is_post_type_translatable($post_type) && in_array($meta_key, $this->get_post_type_metakeys($post_type));

    }

    /**
     * Check whether meta key is translatable
     *
     * @from 1.3.17
     *
     * @param string $key name post_name, post_title
     * @return $key readable name
     */

    public function get_keyname_from_field($key, $domain = 'default')
    {
        //default
        switch($key) {
            case 'post_name':
                $return = __('Slug',$domain);
                break;
            case 'post_title':
                $return = __('Title',$domain);
                break;
            case 'post_content':
                $return = __('Content',$domain);
                break;
            case 'post_excerpt':
                $return = __('Excerpt',$domain);
                break;
            default:
                $return = $key;
        }
        return $return;
    }

}