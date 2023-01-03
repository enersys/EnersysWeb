<?php
/**
 * Created by PhpStorm.
 * User: Stéphane
 * Date: 27/05/2019
 * Time: 17:13
 */

namespace Falang\Core;


use Falang\Model\Falang_Model;

class Taxonomy {

	/**
	 * @from 1.0
	 *
	 * @var array
	 */
	var $taxonomy_fields = array('name', 'slug', 'description');
	var $option_name = 'falang';
	public $options;//there are in model

	var $term_id;
	var $metakey;

    /**
     * Constructor
     *
     * @from 1.0
     * @since 1.3.22 change constructor signaure
     *
     * @return mixed
     */
	public function __construct($term_id = null){
		$this->options = get_option($this->option_name);
		if ($term_id){
			$this->metakey = get_term_meta($term_id);
		}
	}

	/**
	 * Get taxonomies options for translation.
	 *
	 * @from 1.0
	 *
	 * @return mixed
	 */
	public function get_taxonomies_options() {

		$taxonomy_options = null; //if set static to taxonomy problem when saving settings (aka like post)

		if (!isset($taxonomy_options)) {

			//$taxonomy_options = $this->options->get_option('taxonomy', array());//use for model
			$taxonomy_options = $this->options['taxonomy'];

		}

		return $taxonomy_options;
	}

	/**
	 * Get taxonomies options for translation.
	 *
	 * @from 2.3
	 *
	 * @return mixed
	 */
	public function get_taxonomy_options($taxonomy, $default = array()) {

		$taxonomies_options = $this->get_taxonomies_options();

		if (isset($taxonomies_options[$taxonomy])) {

			$value = $taxonomies_options[$taxonomy];

		} else {

			/**
			 * Filter default taxonomy options
			 *
			 * @from 2.3
			 *
			 * @param mixed. Default option
			 */
			$value = apply_filters("falang_taxonomy_default-$taxonomy", $default);

		}

		return $value;

	}

	/**
	 * Get taxonomy single option for translation.
	 *
	 * @from 1.0
	 *
	 * @param string $taxonomy
	 * @param string $option_name. Accepts 'translatable', 'meta_keys', 'fields'
	 * @param mixed $fallback. Value returned when option is not defined.
	 *
	 * @return mixed
	 */
	public function get_taxonomy_option($taxonomy, $option_name, $fallback = false) {

		$taxonomy_options = $this->get_taxonomy_options($taxonomy);

		if (isset($taxonomy_options[$option_name])) {

			return $taxonomy_options[$option_name];

		}

		return $fallback;
	}

	/**
	 * Check if taxonomy is translatable.
	 *
	 * @from 2.0 $taxonomy should no longer be an array.
	 * @from 1.4.5
	 *
	 * @param string $taxonomy
	 *
	 * @return boolean
	 */
	public function is_taxonomy_translatable($taxonomy) {

		return $this->get_taxonomy_option($taxonomy, 'translatable');

	}

	/**
	 * Get taxonomy translatable meta keys.
	 *
	 * @from 2.0
	 *
	 * @param string $taxonomy
	 *
	 * @return array of strings
	 */
	public function get_taxonomy_metakeys($taxonomy) {

		return $this->get_taxonomy_option($taxonomy, 'meta_keys', array());

	}

	/**
	 * Get taxonomy translatable fields.
	 *
	 * @from 2.0
	 *
	 * @param string $taxonomy
	 *
	 * @return array of strings
	 */
	public function get_taxonomy_fields($taxonomy) {

		return $this->get_taxonomy_option($taxonomy, 'fields', $this->taxonomy_fields);

	}

	/**
	 * Get taxonomy meta keys
	 *
	 * @from 2.0
	 */
	public function query_taxonomy_metakeys($taxonomy) {
		global $wpdb;

		$languages = Falang()->get_model()->get_available_locales(array('exclude' => 'all'));

		foreach ($languages as $language) {

			$prefixes[] = Falang_Core::get_prefix($language);

		}


		$sql_prefixes = implode("%' AND meta.meta_key NOT LIKE '", array_map('esc_sql', $prefixes));
		$sql_blacklist = implode("', '", array_map('esc_sql', $this->get_taxonomy_meta_keys_blacklist()));
		$sql_taxonomy = esc_sql($taxonomy);

		// find all existing meta data for this post type
		$results = $wpdb->get_results("
			SELECT meta.meta_key, meta.meta_value
			FROM $wpdb->termmeta AS meta
			LEFT JOIN $wpdb->term_taxonomy AS tt ON (tt.term_id = meta.term_id)
			WHERE tt.taxonomy = '$sql_taxonomy' AND meta.meta_key NOT LIKE '$sql_prefixes%' AND meta.meta_key NOT IN ('$sql_blacklist')
			GROUP BY meta.meta_key"
		);

		// empty array of meta data sorted by meta keys
		$meta_keys = array();

		// registered meta_keys
		$registered_meta_keys = $this->get_taxonomy_metakeys($taxonomy);

		foreach ($registered_meta_keys as $meta_key) {

			$meta_keys[$meta_key] = array();

		}

		// add database results
		foreach ($results as $row) {

			$meta_keys[$row->meta_key][] = substr(wp_strip_all_tags($row->meta_value, true), 0, 120);

		}

		ksort($meta_keys);

		return $meta_keys;

	}

	/*
	 * List of taxonomy meta keys that should never be translated
	 *
	 * @from 1.5
	 */
	private function get_taxonomy_meta_keys_blacklist() {

		return apply_filters('falang_meta_keys_blacklist', array());

	}

	/**
	 * get taxonomy translation
	 *
	 * @from 1.1
	 *
	 * @param string $original_taxonomy. Original taxonomy name (e.g 'category')
	 * @param string $language locale
	 * @return string|false Translated taxonomy if exists.
	 */
	public function get_taxonomy_translation($original_taxonomy, $language = null) {


		if (empty($language)) {

			$language = Falang()->get_model()->get_default_language();

		}

		$translations = Falang()->get_model()->get_option('translations', array());

		if ($language && isset($translations['taxonomy'][$original_taxonomy][$language->locale]) && $translations['taxonomy'][$original_taxonomy][$language->locale]) {

			return $translations['taxonomy'][$original_taxonomy][$language->locale];

		}

		return false;
	}

	/**
	 * Translate taxonomy
	 *
	 * @from 1.1
	 *
	 * @param string $original_taxonomy. Original taxonomy name (e.g 'category')
	 * @param int $language_id. Language id
	 * @param string $fallback
	 * @return string Translated taxonomy
	 */
	public function translate_taxonomy($original_taxonomy, $language = null, $fallback = null) {

		$translated_taxonomy = $this->get_taxonomy_translation($original_taxonomy, $language);

		if ($translated_taxonomy) {

			return $translated_taxonomy;

		} else if (isset($fallback)) {

			return $fallback;

		}

		return $original_taxonomy;
	}

	/**
	 * get term field translation if it exists
	 *
	 * @from 1.0
	 *
	 * @param object WP_Term $term.
	 * @param string $taxonomy.
	 * @param string $field. Accepts 'name', 'slug', 'description'
	 * @param object WP_Post $language.
	 * @return string
	 */
	public function get_term_field_translation($term, $taxonomy, $field, $language = null) {
		global $falang_core;


		if (empty($language)) {

			$language = Falang()->get_model()->get_default_language();

		}

		if (!$falang_core->is_default($language) && $this->is_taxonomy_translatable($term->taxonomy)) {

			return get_term_meta($term->term_id, Falang_Core::get_prefix($language->locale) . $field, true);

		} else {

			return $term->$field;

		}

	}


	/**
	 * Get term field translation
	 *
	 * @from 2.0 Changed parameters
	 * @from 1.1
	 *
	 * @param object WP_Term $term.
	 * @param string $taxonomy.
	 * @param string $field. Accepts 'name', 'slug', 'description'
	 * @param object WP_Post $language.
	 * @param string $fallback Defaut value to return when translation does not exist. Optional.
	 * @return string.
	 */
	public function translate_term_field($term, $taxonomy, $field, $language = null, $fallback = null) {

		$value = $this->get_term_field_translation($term, $taxonomy, $field, $language);

		if ($value) {

			return $value;

		} else if (isset($fallback)) {

			return $fallback;

		}

		return $term->$field;

	}


	//TODO make the method
	public function is_published($locale = null){
		//tood check if local exit in configuration
		if (isset($this->metakey) && !empty($locale)) {
			if (isset($this->metakey[Falang_Core::get_prefix($locale).'published'])){
				return $this->metakey[Falang_Core::get_prefix($locale).'published'][0];
			}
		}
		return false;
	}
}