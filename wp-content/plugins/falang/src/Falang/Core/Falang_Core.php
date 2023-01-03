<?php
/**
 * Base class for Falang_Public in front-end and Falang_Admin in admin.
 *
 * @link       www.faboba.com
 * @since      1.0
 *
 * @package    Falang
 */

namespace Falang\Core;


use Falang\Model\Falang_Model;
use Falang\Core\Falang_Translate_Option;

class Falang_Core {


	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	protected $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	protected $version;

	const InputPrefix 		= 'falang_';
	const OptionPrefix 		= 'falang_';


	/**
	 * @var current langauge
	 */
	var $current_language;

	/**
	 * @from 1.0
	 *
	 * @var string
	 */
	var $language_query_var = 'lang';

	/**
	 * @var bool
	 *
	 * Control wether get_post_meta() is being translated
	 *
	 * @from 1.0
	 */
	var $translate_meta = true;


	protected $model;

	/**
	 * @from 1.0
	 *
	 * @var boolean
	 */
	var $disable_translate_home_url = false;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
     * @since 1.3.14 add short-circuit for _load_textdomain_just_in_time
	 *
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->model = new \Falang\Model\Falang_Model();

        $GLOBALS['l10n_unloaded']['falang_string'] = true; // Short-circuit _load_textdomain_just_in_time() for 'falang_string' domain in WP 4.6+

    }

	public function get_version(){
		return $this->version;
	}

	public function get_model(){
		return $this->model;
	}

	/**
	 * Register all filters needed for site and admin section
	 *
	 * @from 1.0
     * @from 1.3.13 add init action
	 */
	public function load() {
        add_action('init', array($this, 'init'));
		add_action( 'widgets_init', array($this, 'register_widget'));
//		add_filter('parse_query', array($this, 'parse_query'));

	}

    /**
    *
    * @since 1.3.13 add WP String Translation
    *
    * @return void
    */
    public function init() {
        // WordPress options.
        new Falang_Translate_Option( 'blogname', array(), array( 'context' => 'WordPress' ) );
        new Falang_Translate_Option( 'blogdescription', array(), array( 'context' => 'WordPress' ) );
        new Falang_Translate_Option( 'date_format', array(), array( 'context' => 'WordPress' ) );
        new Falang_Translate_Option( 'time_format', array(), array( 'context' => 'WordPress' ) );

    }

	protected function request_action() {
		if ( ( isset($_REQUEST['action']  ) ) && ( $_REQUEST['action']  != '' ) && ( $_REQUEST['action']  != '-1' ) ) return $_REQUEST['action'];
		if ( ( isset($_REQUEST['action2'] ) ) && ( $_REQUEST['action2'] != '' ) && ( $_REQUEST['action2'] != '-1' ) ) return $_REQUEST['action2'];
		return false;
	}


	protected function get_value_from_post( $insKey, $insPrefix = null ) {
		if ( is_null( $insPrefix ) ) {
			$insKey = self::InputPrefix.$insKey;
		}
		return ( isset( $_POST[$insKey] ) ? $_POST[$insKey] : false );
	}


	/**
	 * Create prefix for translation meta keys
	 *
	 * @from 1.0
	 *
	 * @param string $language_locale
	 * @return string
	 */
	public static function create_prefix($locale) {

		return '_' . $locale . '_';

	}

	/**
	 * Get prefix for translation meta keys
	 * TODO no local for defautl
	 *
	 * @from 1.0
	 *
	 * @param object . Optional
	 * @return string
	 */
	public static function get_prefix($locale = null) {

		if (empty($locale)) {
			$falang_model = new Falang_Model();
			$locale = $falang_model->get_default_locale();;

		}

		if (empty($locale)) {

			return false;

		}

		return self::create_prefix($locale);

	}


	// custom tooltips
	public static function falang_tooltip( $desc ) {
		echo '<img class="help_tip" data-tip="' . esc_attr( $desc ) . '" src="' . FALANG_ADMIN_URL . '/img/help.png" height="16" width="16" />';
	}

	/**
	 * Register widget
	 *
	 * @from 1.0
	 */
	public function register_widget() {

		require( FALANG_INC . '/widgets-language.php');
		register_widget( 'Falang_Widget_Language_Switcher' );

	}



	/**
	 * Check whether language is default
	 *
	 * @from 1.0
	 *
	 * @param object  $language Language. Optional
	 * @return boolean
	 */
	public function is_default($language = null) {

		if (empty($language)) {

			$language = $this->get_current_language();

		}
        //TODO pb here need to return only a bool => check impact
		return $language && $language->locale == $this->model->get_default_language()->locale;

	}

	/**
	 * Get current language
	 *
	 * @from 2.0
	 *
	 * @return object WP_post|false
	 */
	public function get_current_language() {

		if (!isset($this->current_language)) {

			$this->current_language = $this->request_current_language();

		}

		return $this->current_language;
	}

	/**
	 * Requestion current language
	 * TODO check if it's necessary on backend
	 *
	 * @from 2.0
	 *
	 * @return object Language
	 */
	public function request_current_language() {

		if (isset($_REQUEST[$this->language_query_var])) {

			return $this->model->get_language_by_slug($_REQUEST[$this->language_query_var]);

		}

		return $this->get_default_language();
	}

	/**
	 * Set current language
	 *
	 * @from 2.0
	 *
	 * @param object Language $language Language. Optional
	 */
	public function set_language($language = null) {

		static $original;

		if (!isset($original)) {

			$original = $this->get_current_language();

		}

		if (empty($language)) {

			$language = $original;

		}

		$this->current_language = $language;

		/**
		 * Fires when the current language is defined
		 *
		 * @since 0.9.5
		 *
		 * @param string $slug    current language code
		 * @param object $curlang current language object
		 */
		do_action( 'falang_language_defined', $language->locale, $this->current_language );

	}


    /**
     * Restore original language after changing with set_language()
     *
     * @from 1.0
     * @since 1.3.8 move from public to core
     */
    public function restore_language() {

        $this->set_language();

    }

	/**
	 * Get default language
	 *
	 * @from 1.2
	 *
	 * @return Language object
	 */
	public function get_default_language() {

		return $this->model->get_default_language();

	}

	/**
	 * Check wether current language is defined
	 *
	 * @from 1.0
	 *
	 * @return bool
	 */
	public function has_language() {

		return isset($this->current_language) && $this->current_language;

	}


	/**
	 * Translates a string ( previously registered with falang_register_string )
	 *
	 * @since 1.0
     * @since 1.3.11 fix problem with empty string (widget => return 1) see msow site.
	 *
	 * @param string $string the string to translate
	 * @return string the string translation in the current language
	 */

	public function falang__( $string ) {
		return is_scalar( $string ) && !empty($string) ? __( $string, 'falang_string' ) : $string; // PHPCS:ignore WordPress.WP.I18n.NonSingularStringLiteralText
	}

	/**
	 * Translates a string ( previously registered with falang_register_string ) and escapes it for safe use in HTML output.
	 *
	 * @since 2.1
	 *
	 * @param string $string the string to translate
	 * @return string translation in the current language
	 */
	function falang_esc_html__( $string ) {
		return esc_html( falang__( $string ) );
	}

	/**
	 * Translates a string ( previously registered with falang_register_string ) and escapes it for safe use in HTML attributes.
	 *
	 * @since 2.1
	 *
	 * @param string $string The string to translate
	 * @return string
	 */
	function falang_esc_attr__( $string ) {
		return esc_attr( falang__( $string ) );
	}

	/**
	 * Echoes a translated string ( previously registered with falang_register_string )
	 *
	 * @since 0.6
	 *
	 * @param string $string The string to translate
	 */
	function falang_e( $string ) {
		echo falang__( $string );
	}

	/**
	 * Echoes a translated string ( previously registered with falang_register_string ) and escapes it for safe use in HTML output.
	 *
	 * @since 2.1
	 *
	 * @param string $string The string to translate
	 */
	function falang_esc_html_e( $string ) {
		echo falang_esc_html__( $string );
	}

	/**
	 * Echoes a translated a string ( previously registered with falang_register_string ) and escapes it for safe use in HTML attributes.
	 *
	 * @since 2.1
	 *
	 * @param string $string The string to translate
	 */
	function falang_esc_attr_e( $string ) {
		echo falang_esc_attr__( $string );
	}

	/**
	 * Translates a string ( previously registered with falang_register_string )
	 *
	 * @since 1.0
	 *
	 * @param string $string the string to translate
	 * @param string $lang   language code
	 * @return string the string translation in the requested language
	 */
	function falang_translate_string( $string, $lang ) {

		if ( ! is_scalar( $string ) ) {
			return $string;
		}

        $mo = new Falang_Mo();
        $mo->import_from_db( $this->model->get_language_by_slug( $lang ) );

		return $mo->translate( $string );
	}

	/**
	 * Translate custom post type link
	 * Filter for 'post_type_link'
	 *
	 * @since 1.2.3 move from public to core
     * @sicne 1.3.20 fix notice when $post_type_obj->rewrite['with_front'] is not an array
     * @since 1.3.26 add_filter use for flatsome
	 * @from 1.0
	 */
	public function translate_custom_post_link($link, $post_id, $sample = false) {
		$falang_post = new \Falang\Core\Post();
		global $wp_rewrite;

		if (!$sample) {

			$post = get_post($post_id);

			if ($post && $falang_post->is_post_type_translatable($post->post_type) && get_option('permalink_structure')) {

				$post_type_obj = get_post_type_object($post->post_type);

				$translated_cpt = is_array($post_type_obj->rewrite) && isset($post_type_obj->rewrite['with_front']) ? $wp_rewrite->front : $wp_rewrite->root;

				$translated_cpt .= $falang_post->translate_cpt($post->post_type, $this->get_current_language(), $post->post_type);

				$translated_slug = $falang_post->translate_post_field($post, 'post_name',$this->get_current_language());

				if ($post_type_obj->hierarchical) {

					$parent_id = $post->post_parent;

					while ($parent_id != 0) {

						$parent = get_post($parent_id);
						$parent_slug = $falang_post->translate_post_field($parent, 'post_name',$this->get_current_language());
						$translated_slug = $parent_slug.'/'.$translated_slug;
						$parent_id = $parent->post_parent;

					}

				}

				$post_link = $translated_cpt.'/'.user_trailingslashit($translated_slug);

				/*
				 * @since 1.3.26 add for flatsome
				 * */
                $post_link= apply_filters('falang_translate_custom_post_link',$post_link,$post_id,$this->get_current_language());

				$link = home_url($post_link);

			}

		}
		return $link;
	}

    /**
     * Get language link
     * fix for WP 5.8 => widget page
     * overrided in the public falang class
     *
     * @from 1.3.16
     */
    public function get_translated_url( $language )
    {
        $link ='#'.$language->slug;
        return $link;
    }

    /**
     * Print javascript data for ajax
     *
     * Hook for 'admin_enqueue_script', 'falang_prepare_ajax', wp_enqueue_scripts
     *
     * @from 1.3.8
     *
     * @since 1.3.24 use in front too the same function for front and back
     */
    public function ajax_enqueue_scripts()
    {

        $language = $this->get_current_language();

        //current must be a slug and not the locale it's passed by request on updtate
        $falang = array(
            'current' => $language ? $language->slug : 0,
            'languages' => array(),
            'query_var' => $this->language_query_var,
        );

        $languages = $this->get_model()->get_languages_list();
        foreach ($languages as $language) {

            $this->set_language($language);
            $home_url = home_url();
            $this->restore_language();

            $falang['languages'][] = array(
                'name' => $language->name,
                'locale' => $language->locale,
                'slug' => $language->slug,
                'flag' => $language->get_flag(),
                'isDefault' => $this->is_default($language),
                'home_url' => $home_url
            );

        }

        wp_register_script('falang-ajax', plugin_dir_url(__FILE__) . '../../../public/js/ajax.js', array('jquery'), $this->version, true);
        wp_localize_script('falang-ajax', 'falang', $falang);
        wp_enqueue_script('falang-ajax');

    }
}