<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.faboba.com
 * @since      1.0.0
 *
 * @package    Falang
 * @subpackage Falang/public
 */

use Falang\Core\Falang_Rewrite;
use Falang\Core\Language;
use Falang\Core\Falang_Mo;
use Falang\Core\Cache;
use Falang\Core\Language_Switcher;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Falang
 * @subpackage Falang/public
 * @author     Stéphane Bouey <stephane.bouey@faboba.com>
 */
class Falang_Public extends Falang_Rewrite{

	/**
	 * @var boolean
	 */
	var $canonical = true;

	private $cache;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		parent::__construct($plugin_name, $version);

		$this->cache = new Cache();

		//change the locale language, based on the lang pass on the url.
		add_filter('locale', array($this, 'get_locale'));
		add_action('plugins_loaded', array($this, 'load'));

        //redirect for autotetect sooner
        add_action('setup_theme', array($this, 'setup_theme'));
	}

    /**
     * @from 1.3.18
     * redirect the home page when auto-detect language is done before the template is loaded.
     */
    public function setup_theme() {
        //front don't work with wordpress in subfolder
        //is_fornt_page don't work too
        $front =  $_SERVER["REQUEST_URI"] == '/' ? true:false;
        if ($front && $this->model->get_option('autodetect') && $this->model->get_option('show_slug')){
            //only on home page
            $language = $this->request_current_language();
            if (!$this->canonical) {
                $url =  home_url();
                //add language slug to url to make the redirect
                if (get_option('permalink_structure')) {
                    $url = $url . '/' . $language->slug . '/';
                } else {
                    $url = add_query_arg( array('lang' => $language->slug), $url);
                }
                wp_redirect($url);
                exit;
            }
        }
    }

	/**
	 * @from 1.0.0
     * @from 1.3.13 move WP_Strings translation
	 */
	public function load() {

		if ($this->current_language = $this->get_current_language()) {

			parent::load();

			$this->load_strings_translations($this->current_language->locale);

			// Strings translation ( must be applied before WordPress applies its default formatting filters )
			foreach ( array( 'widget_text', 'widget_title') as $filter ) {
				add_filter( $filter, array( $this,'falang__'), 1 );
			}

			//use for extra filter nav_menu,enfold...
			add_action( 'wp_loaded', array( $this, 'add_filters' ), 10 );

			// from sublanguage current (parent)
			add_action('parse_query', array( $this, 'parse_query' ) );
			add_filter('get_object_terms', array($this, 'filter_get_object_terms'), 10, 4);
			add_filter('get_term', array($this, 'translate_get_term'), 10, 2); // hard translate term
			add_filter('get_terms', array($this, 'translate_get_terms'), 10, 3); // hard translate terms
			add_filter('get_the_terms', array($this, 'translate_post_terms'), 10, 3);
			add_filter('list_cats', array($this, 'translate_term_name'), 10, 2);

			add_filter('the_posts', array($this, 'translate_the_posts'), 10, 2);
			add_filter('get_pages', array($this, 'translate_the_pages'), 10, 2);
			add_filter('falang_query_add_language', array($this, 'query_add_language'));

			//end of  current

			//filter post by local only current locale from slug (language code) and all language
			add_filter( 'posts_join', array($this,'posts_join'), 10, 2 );
			add_filter( 'posts_where', array($this,'posts_where'), 10, 2 );


			add_filter('the_content', array($this, 'translate_post_content'), 7);//change 9 to 8 for display post type plugin working and 7 for embeded
			add_filter('the_title', array($this, 'translate_post_title'), 10, 2);
			add_filter('get_the_excerpt', array($this, 'translate_post_excerpt'), 9,2);
			add_filter('single_post_title', array($this, 'translate_single_post_title'), 10, 2);
			add_filter('get_post_metadata', array($this, 'translate_meta_data'), 10, 4);
			add_filter('wp_setup_nav_menu_item', array($this, 'translate_menu_nav_item'));
			add_filter('wp_nav_menu_objects', array($this, 'filter_nav_menu_objects'), 10, 2); // -> @from 1.0. Filter list for hidden items
			add_filter('tag_cloud_sort', array($this,'translate_tag_cloud'), 10, 2);
			add_filter('query_vars', array($this,'query_vars') );
			add_action('init', array($this, 'init'));
			add_action('widgets_init', array($this, 'register_widget'));

			// Filters the widgets according to the current language
			add_filter( 'widget_display_callback', array( $this, 'widget_display_callback' ), 10, 2 );
			add_filter( 'sidebars_widgets', array( $this, 'sidebars_widgets' ) );


			//TODO check translate the post and the page.
//			add_filter('the_posts', array($this, 'translate_the_posts'), 10, 2);
//			add_filter('get_pages', array($this, 'translate_the_pages'), 10, 2);

			$this->add_options_filters();

			//translate image caption
            add_filter('wp_get_attachment_caption', array($this,'translate_attachment_caption'), 10, 2);

            //add the languge input to the comment form => use for redirect correctly
            add_action( 'comment_form_logged_in_after', array($this,'comment_form_additional_fields') );
            add_action( 'comment_form_after_fields', array($this,'comment_form_additional_fields' ));
            //fix comment post redirect
            add_filter( 'comment_post_redirect', array($this,'translate_comment_post_redirect'),10,2) ;
            //add language in comment meta after the comment is inserted
            add_action( 'comment_post', array($this,'comment_post'),10,3) ;

		}

	}

	/**
	 * @from 1.0
     * @from 1.3.13 call parent init to load WP Strings translation
	 */
	public function init() {

	    parent::init();

		if (get_option('permalink_structure')) {
			add_filter('query_vars', array($this, 'query_vars'));
			add_filter('request', array($this, 'catch_translation')); // detect query type and language out of query vars
    		add_action('wp', array($this, 'redirect_uncanonical'), 11);
		}

		//link filters only after request has been parsed
		add_action('parse_request', array($this, 'add_links_translation_filters'));

		// login
		add_filter('login_url', array($this, 'translate_login_url'));
		add_filter('lostpassword_url', array($this, 'translate_login_url'));
		add_filter('logout_url', array($this, 'translate_login_url'));
		add_filter('register_url', array($this, 'translate_login_url'));
		add_action('login_form', array($this, 'translate_login_form'));
		add_action('lostpassword_form', array($this, 'translate_login_form'));
		add_action('resetpass_form', array($this, 'translate_login_form'));
		add_action('register_form', array($this, 'translate_login_form'));
		add_filter('retrieve_password_message', array($this, 'translate_retrieve_password_message'));
		add_filter('lostpassword_redirect', array($this, 'lostpassword_redirect'));
		add_filter('registration_redirect', array($this, 'registration_redirect'));

		// print hreflang in template head
		add_action('wp_head', array($this, 'print_hreflang'));

		//API
		add_action('falang_print_language_switch', array($this, 'print_language_switch'));
		add_filter('falang_custom_translate', array($this, 'custom_translate'), 10, 3);

		//add shortcode
		add_shortcode('falang',array($this,'shortcode_falang'));
        //add shortcode falang
        add_shortcode( 'falangsw', array($this,'shortcode_falang_switcher') );


		/**
		 * Hook called after initializing most hooks and filters
		 *
		 * @from 1.0
		 *
		 * @param Falang_public object
		 */
		do_action('falang_init', $this);

	}


	/**
	 * Add links translation filters after all query variables for the current request have been parsed.
	 *
	 * @hook 'parse_request'
	 * @from 2.0
	 */
	public function add_links_translation_filters($wp = null) {

		add_filter('home_url', array($this,'translate_home_url'), 10, 4);
		add_filter('pre_post_link', array($this, 'pre_translate_permalink'), 10, 3);
		add_filter('post_link', array($this, 'translate_permalink'), 10, 3);
		add_filter('page_link', array($this, 'translate_page_link'), 10, 3);
		add_filter('post_type_link', array($this, 'translate_custom_post_link'), 9, 3);
		add_filter('attachment_link', array($this, 'translate_attachment_link'), 10, 2);
		add_filter('post_link_category', array($this, 'translate_post_link_category'), 10, 3); // not implemented yet
		add_filter('post_type_archive_link', array($this, 'translate_post_type_archive_link'), 10, 2);
		add_filter('year_link', array($this,'translate_month_link'));
		add_filter('month_link', array($this,'translate_month_link'));
		add_filter('day_link', array($this,'translate_month_link'));
		add_filter('term_link', array($this, 'translate_term_link'), 10, 3);
		add_filter('get_edit_post_link', array($this, 'translate_edit_post_link'), 10, 3);

	}

	/**
	 * Filter for 'locale'
	 *
	 * @from 1.0
	 */
	public function get_locale($locale) {

		if ($language = $this->get_current_language()) {

			return $language->locale;

		}

		return $locale;
	}

	/**
	 * Modifies some query vars
	 *
	 * @since 1.0
	 *
	 * @param object $query WP_Query object
	 */
	function query_vars( $query_vars ) {
		$query_vars[] = 'falang_slug';
		$query_vars[] = 'falang_page';
		$query_vars[] = 'preview_language';

		return $query_vars;
	}

	/**
	 * Intercept query_vars to find out type of query and get parent.
	 * Must return an array of query vars
	 *
	 * Hook for 'request'
	 *
	 * @from 1.0
	 */
	public function catch_translation($query_vars) {
		global $wp_rewrite;

		$falang_post = new \Falang\Core\Post();
		$falang_taxo = new \Falang\Core\Taxonomy();

		if (isset($query_vars['falang_page']) || isset($query_vars['pagename']) || isset($query_vars['name'])) { // -> page, post or custom post type

			$name = '';

			if (isset($query_vars['falang_page'])) {

				$name = $query_vars['falang_page'];

			} else if (isset($query_vars['pagename'])) {

				$name = $query_vars['pagename'];

			} else if (isset($query_vars['name'])) {

				$name = $query_vars['name'];

			}

			$ancestors = explode('/', $name);

			// -> remove the permalink structure prefix if there is one
			if (isset($query_vars['falang_page']) && !empty($wp_rewrite->front) && $wp_rewrite->front !== '/' && trim($wp_rewrite->front, '/') === $ancestors[0]) {

				array_shift($ancestors);

			}

			$post_name = array_pop($ancestors);

			$post_types = isset($query_vars['post_type']) ? array($query_vars['post_type']) : array('page', 'post');

			$post = $this->query_post($post_name, array(
				'post_types' => $post_types,
				'ancestor_names' => $ancestors
			));

			if ($post) {

				$post_type_obj = get_post_type_object($post->post_type);


				if (isset($query_vars['falang_slug']) && $query_vars['falang_slug'] !== $falang_post->translate_cpt($post->post_type, $this->get_current_language(), $post->post_type)) {

					// wrong slug
					$this->canonical = false;

				}

				if ($post_type_obj->hierarchical) {

					$path = '';
					$parent_id = $post->post_parent;

					while ($parent_id) {

						$parent = get_post($parent_id);
						$path = $parent->post_name . '/' . $path;
						$parent_id = $parent->post_parent;

					}

					if (isset($query_vars[$post->post_type])) {

						$query_vars[$post->post_type] = $path . $post->post_name;

					}

					if (isset($query_vars['name'])) {

						$query_vars['name'] = $path . $post->post_name;

					} else {

						$query_vars['pagename'] = $path . $post->post_name;

					}

				} else {

					if (isset($query_vars['pagename'])) {

						$query_vars['pagename'] = $post->post_name;

					} else {

						$query_vars['name'] =  $post->post_name;

					}

					if (isset($query_vars[$post->post_type])) {

						$query_vars[$post->post_type] = $post->post_name;

					}

				}

			} else if (isset($query_vars['falang_page'])) { // -> nothing found. Let's pretend we did not see

				$query_vars['name'] = $query_vars['falang_page'];

			}

		} else if (isset($query_vars['attachment']) && $falang_post->is_post_type_translatable('attachment')) { // -> attachment (this is a child of a "post" post-type)

			$post = $this->query_post($query_vars['attachment'], array(
				'post_types' => array('attachment')
			));

			if ($post) {

				$query_vars['attachment'] = $post->post_name;

			}

		} else if (isset($query_vars['post_type'])) { // -> custom-post-type archive

			$post_type = $query_vars['post_type'];

			if ($falang_post->is_post_type_translatable($post_type)) {

				if (isset($query_vars['falang_slug']) && $query_vars['falang_slug'] !== $falang_post->translate_cpt_archive($post_type, $this->get_current_language())) {

					// wrong slug
					$this->canonical = false;

				}

			}

		} else if ($results = array_filter(array_map(array($this, 'query_var_to_taxonomy'), array_keys($query_vars)), array($this, 'is_taxonomy_translatable'))) { // -> untranslated taxonomy

			if (isset($query_vars['falang_slug'])) {

				$taxonomy = '';

				foreach ($results as $r) {

					$taxonomy = $r;
					break;

				}

				if (!$taxonomy) throw new Exception('Taxonomy not found!');

				$tax_obj = get_taxonomy($taxonomy);
				$tax_qv = $tax_obj->query_var;
				$term_name = $query_vars[$tax_qv];
				$term = $this->query_taxonomy($term_name, $taxonomy);

				if ($term) {

					$query_vars[$tax_qv] = $term->slug; // -> restore original language name in query_var
                    //1.3.7 not necessary to pass the $taxonomy for fallback
					$tax_translation = $falang_taxo->translate_taxonomy($taxonomy, $this->get_current_language());

					if ($tax_translation !== $query_vars['falang_slug']) { // taxonomy should be translated

						$this->canonical = false;

					}

				}

			}

		}

		if (isset($query_vars['preview'])) {

			$this->canonical = true;

		}

		return $query_vars;

	}


	/**
	 * Find original post based on query vars info.
	 *
	 * @from 1.0
	 *
	 * @param string $post_name
	 * @param array $args {
	 *   Array of arguments
	 *	 @type array 		$post_types 			Array of post_type strings
	 *   @type array		$ancestor_names		Array of ancestor post_names
	 *   @type array		$exclude_ids			Array of post ids
	 * }
	 * @return WP_Post object $post. Queried post or null
	 */
	public function query_post($post_name, $args = array()) {
		global $wpdb;

		$post_name = esc_sql($post_name);

		if (isset($args['post_types']) && is_array($args['post_types']) && $args['post_types']) {

			$post_type_sql = $wpdb->prepare(implode(',', array_fill(0, count($args['post_types']), '%s')), $args['post_types']);

		}

		if (!$this->is_default()) {

			$post_ids = array_map('intval', $wpdb->get_col( $wpdb->prepare(
				"SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %s",
				$this->get_prefix($this->current_language->locale).'post_name',
				$post_name
			)));

			//TODO check if it's necessary to exclude non published post_name

			if (isset($args['exclude_ids']) && $post_ids) {

				$exclude_ids = array_map('intval', $args['exclude_ids']);
				$post_ids = array_diff($post_ids, $exclude_ids);

			}

		}

		if (isset($post_ids) && $post_ids) {

			$post_ids_sql = $wpdb->prepare(implode(',', array_fill(0, count($post_ids), '%d')), $post_ids);

			$wheres = array();

			$wheres[] = 'post.ID IN (' . $post_ids_sql . ')';

			if (isset($post_type_sql)) {

				$wheres[] = 'post.post_type IN (' . $post_type_sql . ')';

			}

			$posts = $wpdb->get_results(
				"SELECT post.* FROM $wpdb->posts AS post
				 WHERE ".implode(" AND ", $wheres)
			);

			foreach ($posts as $post) { // -> Translations found

				if (isset($args['ancestor_names']) && $args['ancestor_names']) { // -> verify ancestors recursively

					$query_args = $args;
					$query_args['exclude_ids'][] = $post->ID; // -> exclude this post to prevent a loop hole (multiple pages can share the same slug if parented differently)
					$parent_name = array_pop($query_args['ancestor_names']);

					$parent = $this->query_post($parent_name, $query_args);

					if ($parent && $post->post_parent == $parent->ID) {

						return $post;

					}

				} else if (!$post->post_parent) {

					// This one will just do
					return $post;

				}

			}

		}

		// no translation -> search untranslated posts with this name

		$wheres = array();

		$wheres[] = $wpdb->prepare('post.post_name = %s', $post_name);

		if (isset($post_type_sql)) {

			$wheres[] = 'post.post_type IN (' . $post_type_sql . ')';

		}

		if (isset($args['exclude_ids'])) {

			$exclude_ids = array_map('intval', $args['exclude_ids']);
			$exclude_sql = $wpdb->prepare(implode(',', array_fill(0, count($exclude_ids), '%d')), $exclude_ids);
			$wheres[] = 'post.ID NOT IN ('.$exclude_sql.')';

		}

		$posts = $wpdb->get_results(
			"SELECT post.* FROM $wpdb->posts AS post
			 WHERE ".implode(' AND ', $wheres)
		);

		if ($posts) {

			foreach ($posts as $post) {
				$falang_post = new \Falang\Core\Post( $post->ID );

				if ( isset( $args['ancestor_names'] ) && $args['ancestor_names'] ) { // -> verify ancestors recursively

					$query_args                  = $args;
					$query_args['exclude_ids'][] = $post->ID; // -> exclude this post to prevent a loop hole (multiple pages can share the same slug if parented differently)
					$parent_name                 = array_pop( $query_args['ancestor_names'] );

					$parent = $this->query_post( $parent_name, $query_args );

					// check if parent match and there is no specific translation...
					if ( $parent && $post->post_parent == $parent->ID ) {

						// Post found
//						if ($falang_post->is_post_type_translatable($post->post_type) && get_post_meta($post->ID, $this->get_prefix($this->current_language->locale) . 'post_name', true)) {
						if ( $falang_post->is_post_type_translatable( $post->post_type ) && $falang_post->is_published( $this->current_language->locale ) && get_post_meta( $post->ID, $this->get_prefix( $this->current_language->locale ) . 'post_name', true ) ) {

							// But there is a specific translation for this post
							$this->canonical = false;

						}

						return $post;

					}

				} else if ( ! $post->post_parent ) {

					// Post found
//					if ($falang_post->is_post_type_translatable($post->post_type) && get_post_meta($post->ID, $this->get_prefix($this->current_language->locale) . 'post_name', true)) {
					if ( $falang_post->is_post_type_translatable( $post->post_type ) && $falang_post->is_published( $this->current_language->locale ) && get_post_meta( $post->ID, $this->get_prefix( $this->current_language->locale ) . 'post_name', true ) ) {

						// But there is a specific translation for this post
						$this->canonical = false;

					}

					return $post;

				}

			}

		}

		// Nothing found. -> Search in other languages...

		$post_names = array();

		foreach ($this->model->get_languages_list() as $language) {

			if (!$this->is_default($language)) {

				$post_names[] = esc_sql($this->get_prefix($language->locale).'post_name');

			}

		}

		$post_names_sql = $wpdb->prepare(implode(',', array_fill(0, count($post_names), '%s')), $post_names);

		$wheres = array();
		$wheres[] = 'meta.meta_key IN ('.$post_names_sql.')';
		$wheres[] = $wpdb->prepare('meta.meta_value = %s', $post_name);

		if (isset($post_type_sql)) {

			$wheres[] = 'post.post_type IN (' . $post_type_sql . ')';

		}

		$posts = $wpdb->get_results(
			"SELECT post.* FROM $wpdb->posts AS post
			 INNER JOIN $wpdb->postmeta AS meta ON (post.ID = meta.post_id)
			 WHERE ".implode(' AND ', $wheres)
		);

		foreach ($posts as $post) { // -> Translations found

			if (isset($args['ancestor_names']) && $args['ancestor_names']) { // -> verify ancestors recursively

				$query_args = $args;
				$query_args['exclude_ids'][] = $post->ID; // -> exclude this post to prevent a loop hole (multiple pages can share the same slug if parented differently)
				$parent_name = array_pop($query_args['ancestor_names']);

				$parent = $this->query_post($parent_name, $query_args);

				if ($parent && $post->post_parent == $parent->ID) {

					$this->canonical = false;

					return $post;

				}

			} else if (!$post->post_parent) {

				$this->canonical = false;

				// This one will just do
				return $post;

			}

		}

	}

	/**
	 *	Find original term based on query vars info.
	 *
	 *  @from 1.0
	 *
	 * @param string $slug
	 * @param string|array $taxonomy
	 */
	public function query_taxonomy($slug, $taxonomies) {
		global $wpdb;

		$taxonomy_string = is_array($taxonomies) ? "'".implode("','", esc_sql($taxonomies))."'" : "'".esc_sql($taxonomies)."'";

		$translation_slug = $this->get_prefix($this->current_language->locale) . 'slug';

		$term_ids = $wpdb->get_col( $wpdb->prepare(
			"SELECT term_id FROM $wpdb->termmeta WHERE meta_key = %s AND meta_value = %s",
			$translation_slug,
			$slug
		));

		if ($term_ids) {

			// Translations found but we're not sure about taxonomy
			$term = $wpdb->get_row(
				"SELECT t.term_id, t.slug, tt.taxonomy, tt.parent FROM $wpdb->terms AS t 
					INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
					WHERE tt.taxonomy IN ($taxonomy_string)
						AND t.term_id IN (".implode(",", array_map('intval', $term_ids)).")"
			);

			return $term;

		}

		// -> no translated term for this slug
		$term = $wpdb->get_row( $wpdb->prepare(
			"SELECT t.term_id, t.slug, tt.taxonomy, tt.parent FROM $wpdb->terms AS t 
				INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
				WHERE tt.taxonomy IN ($taxonomy_string)
					AND t.slug = %s",
			$slug
		));

		if ($term) {
			$falang_taxo = new \Falang\Core\Taxonomy();

			if ($falang_taxo->is_taxonomy_translatable($term->taxonomy) && get_term_meta($term->term_id, $this->get_prefix($this->current_language->locale) . 'slug', true)) {

				// -> But there is a specific translation for this term
				$this->canonical = false;

			}

			return $term;

		} else {

			// Nothing found. -> Search in other languages...

			$language_slugs = $this->model->get_language_column('post_name');

			$term_ids = $wpdb->get_col( $wpdb->prepare(
				"SELECT term_id FROM $wpdb->termmeta WHERE meta_key IN ('_" . implode("slug','", esc_sql(array_map(array($this, 'create_prefix'), $language_slugs))) . "slug') AND meta_value = %s",
				$slug
			));

			if ($term_ids) {

				$term = $wpdb->get_row(
					"SELECT t.term_id, t.slug, tt.taxonomy, tt.parent FROM $wpdb->terms AS t 
						INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
						WHERE tt.taxonomy IN ($taxonomy_string)
							AND t.term_id IN (".implode(",", array_map('intval', $term_ids)).")"
				);

				if ($term) {

					// Term found in wrong language.
					$this->canonical = false;

					return $term;

				}

			}

		}

		return false;

	}
	/**
	 * Redirection when not canoncal url
	 * Must be fired after filters.
	 * Must be fired after conditional tags are set.
	 *
	 * @from 1.0
	 */
	public function redirect_uncanonical() {

		$query_object = get_queried_object();

		if (!$this->canonical) {

			if (is_singular()) {

				$url = get_permalink($query_object->ID);

			} else if (is_post_type_archive()) {

				$url = get_post_type_archive_link($query_object->name);

			} else if (is_category() || is_tag() || is_tax()) {

				$url = get_term_link($query_object->term_id, $query_object->taxonomy);

			} else {

				$url = home_url();

			}

			wp_redirect($url);

			exit;

		}

	}

	/**
	 * translate posts
	 *
	 * @filter 'the_posts'
	 *
	 * @from 1.1
	 * @from 2.5 perform update_post_caches before translation
	 */
	public function translate_the_posts($posts, $wp_query) {
		return $posts;
	}


	/**
	 * translate posts
	 *
	 * @filter 'get_pages'
	 *
	 * @from 2.0
	 */
	public function translate_the_pages($posts, $r) {
		return $posts;

//		if (!$this->is_default()) {
//
//			$posts = $this->translate_the_posts($posts);
//
//		}
//
//		return $posts;
	}


	public function posts_join( $join, $query ) {
		global $wpdb;

		$qv = &$query->query_vars;

//		if ( ! empty( $qv['falang_suppress_locale_query'] ) ) {
//			return $join;
//		}

		//todo check the slug is a supported language on the site

		$slug = empty( $qv['lang'] ) ? $slug = $this->current_language->slug : $qv['lang'];

		$language = $this->model->get_language_by_slug($slug);

		if ( !isset($language) ) {
			return $join;
		}

		if ( ! $meta_table = _get_meta_table( 'post' ) ) {
			return $join;
		}

		$join .= " LEFT JOIN $meta_table AS falang_postmeta ON ($wpdb->posts.ID = falang_postmeta.post_id AND falang_postmeta.meta_key = '_locale')";

		return $join;
	}
	/**
	 * filter posts
	 *
	 * @filter 'the_posts'
	 *
	 * @from 1.0
	 */
	public function posts_where( $where, $query) {
		global $wpdb;

		$qv = $query->query_vars;

//		if ( ! empty( $qv['falang_suppress_locale_query'] ) ) {
//			return $where;
//		}

		$slug = empty( $qv['lang'] ) ? $slug = $this->current_language->slug : $qv['lang'];

		//todo check the slug is a supported language on the site
		$language = $this->model->get_language_by_slug($slug);

		//tODO check if slug is not set correctly
		if ( !isset($language) ) {
			return $where;
		}

		if ( ! $meta_table = _get_meta_table( 'post' ) ) {
			return $where;
		}

		$where .= " AND (1=0";

		$where .= $wpdb->prepare( " OR falang_postmeta.meta_value LIKE %s", $language->locale );
//		$where .= $wpdb->prepare( " OR falang_postmeta.meta_value LIKE %s", 'all' );
		$where .= " OR falang_postmeta.meta_id IS NULL";


//		if ( bogo_is_default_locale( $language->locale ) ) {
//			$where .= " OR falang_postmeta.meta_id IS NULL";
//		}

		$where .= ")";

		return $where;
	}



	/**
	 *	Translate title to current language
	 *	Filter for 'the_title'
	 *
	 * @from 1.0
     * @since 1.3.6 check id as int
     * @since 1.3.11
     *
	 */
	public function translate_post_title($title, $id = null) {

		//id is like ID-slug when language switcher in menu
		//don't translate it in this case
		if (strpos($id,'-')){
			$id = substr($id,0, strpos($id,'-'));
		}
		$falang_menu_item = get_post_meta( $id, '_falang_menu_item', true );
		if (!empty($falang_menu_item)){
			return $title;
		}

        //$id not an integer when call not from get_the_title
        //https://developer.wordpress.org/reference/functions/the_title/
        //fix for Multi-column Tag Map
        if (!is_int($id)){
            return $title;
        }

		//normal post title translation
		$post = get_post($id);
		$falang_post = new \Falang\Core\Post($id);


		if ($post && !$this->is_default() && $falang_post->is_post_type_translatable($post->post_type)){
			$title =  $falang_post->translate_post_field($post, 'post_title', $this->current_language, $title);
		}

		return $title;

	}

	/**
	 *	Translate content to current language
	 *	Filter for 'the_content'
	 *
	 * @from 1.0
	 * @from 1.3 check wether content corresponds to global post ('the_content' filter may be used outside of The Loop or when global $post does not match)
     * @from 1.3.15 don't translate yootheme post_content
     *
     */
	public function translate_post_content($content) {
		global $post;
		$falang_post = new \Falang\Core\Post($post->ID);

        //TODO add something to filter which post_content needs to be non-translated
        //Divi edition page doesn't translate content
		if (isset($_GET['et_fb'])){return $content;}

        //check why yootheme builder doesn't translate it
        if ($post and $post->builder = preg_match('/<!--\s?{/', $post->post_content)) {
            return $content;
        }
        //another check on yootheme builder
        if ($post and preg_match('/<!-- Builder/',$content)){
            return $content;
        }

		if ($post && !$this->is_default() && $falang_post->is_post_type_translatable($post->post_type)){

			$content = $falang_post->translate_post_field($post, 'post_content', $this->current_language, $content);

			/*
			 * @since 1.3.27 add filter for content (use for readmore text)
			 * */
            $content = apply_filters( 'falang_translate_post_content', $content );

		}

		return $content;

	}


	/**
	 * Translate excerpt to current language (the_excerpt() and the_content() behave very differently!)
	 * @filter for 'get_the_excerpt'
	 *
	 * @from 1.0
	 * @from $post parameter (@since wp 4.5)
	 *
	 */
	public function translate_post_excerpt($excerpt, $post = null) {
		if (!isset($post)){
			return $excerpt;
		}
		$falang_post = new \Falang\Core\Post($post->ID);


		if ($post  && !$this->is_default() && $falang_post->is_post_type_translatable($post->post_type)){
//		if ($post && $this->is_sub() && $this->is_post_type_translatable($post->post_type) && empty($post->sublanguage)) {

			$excerpt = $falang_post->translate_post_field($post, 'post_excerpt', $this->current_language, $excerpt);

		}

		return $excerpt;

	}


	/**
	 *	Translate page title in wp_title()
	 *	Filter for 'single_post_title'
	 *
	 * @from 1.0
	 */
	public function translate_single_post_title($title, $post) {
		$falang_post = new \Falang\Core\Post($post->ID);

		if ($post && !$this->is_default() && $falang_post->is_post_type_translatable($post->post_type)) {

			$title = $falang_post->translate_post_field($post, 'post_title', $this->current_language, $title);

		}

		return $title;
	}


    /**
     *	Translate post meta data
     *
     *	Filter for "get_{$meta_type}_metadata"
     *
     * @from 1.0
     * @since 1.3.6 fix get_post_meta without key
     *              improve get_post_meta performance
     * @since 1.3.22 fix meta translation (view in wc _thumbnail translation
     * @sicne 1.3.26 fix return on single (modern event calendar support)
     */
    public function translate_meta_data($null, $object_id, $meta_key, $single) {
        static $disable = false;

        if ($disable) {
            return $null;
        }

        $object = get_post($object_id);
        $falang_post = new \Falang\Core\Post();

        if (isset($object->post_type) && !$this->is_default() && $this->translate_meta) {

            if (!$meta_key) { // meta_key is not defined -> more work

                $disable = true;
                //possible to use remove_filter and add_filter too. perhaps better than disabled.
                //remove_filter( 'get_post_metadata', array($this, 'translate_meta_data'), 10 );
                $meta_vals = get_post_meta($object_id);
                //add_filter('get_post_metadata', array($this, 'translate_meta_data'), 10, 4);

                foreach ($meta_vals as $key => $val) {

                    if (in_array($key, $falang_post->get_post_type_metakeys($object->post_type))) {

                        $meta_val = $falang_post->get_post_meta_translation($object, $key, $single, $this->current_language);

                        /**
                         * Filter whether an empty translation inherit original value
                         *
                         * @from 1.0
                         *
                         * @param mixed $meta_value
                         * @param string $meta_key
                         * @param int $object_id
                         */
                        if (apply_filters('falang_postmeta_override', $meta_val, $key, $object_id)) {

                            //$meta_vals[$key] = is_array($val) ? array($meta_val) : $meta_val; break wc
                            $meta_vals[$key] = $meta_val;

                        }
                    } else {
                        $meta_vals[$key] = $val;
                    }
                }

                $disable = false;

                return ($single && is_array($meta_vals)) ? array($meta_vals) : $meta_vals;

            } else if (in_array($meta_key, $falang_post->get_post_type_metakeys($object->post_type))) { // -> just one key

                $meta_val = $falang_post->get_post_meta_translation($object, $meta_key, $single,$this->current_language);

                /**
                 * Documented just above
                 */
                if (apply_filters('falang_postmeta_override', $meta_val, $meta_key, $object_id)) {

                    return ($single && is_array($meta_val)) ? array($meta_val) : $meta_val; // watch out: foresee meta_val array check in get_metadata()

                }

            }

        }

        return $null;
    }

	/**
	 *	Translate menu nav items
	 *	Filter for 'wp_setup_nav_menu_item'
	 */
	public function translate_menu_nav_item($menu_item) {
		$falang_post = new \Falang\Core\Post();
		$falang_taxo = new \Falang\Core\Taxonomy();

		if ($menu_item->type == 'post_type') {

			if ($falang_post->is_post_type_translatable($menu_item->object)) {

				$original_post = get_post($menu_item->object_id);

				$menu_item = $this->translate_nav_menu_item($menu_item);

				if (empty($menu_item->post_title)) {

					$menu_item->title = $falang_post->translate_post_field($original_post, 'post_title', $this->get_current_language(), $menu_item->title);

				} else {

					$menu_item->title = $menu_item->post_title;

				}

				$menu_item->url = get_permalink($original_post);

			}

		} else if ($menu_item->type == 'taxonomy') {

			if ($falang_taxo->is_taxonomy_translatable($menu_item->object)) {

				$original_term = get_term($menu_item->object_id, $menu_item->object);

				if ($original_term && !is_wp_error($original_term)) {

					$menu_item = $this->translate_nav_menu_item($menu_item);

					if (empty($menu_item->post_title)) {

						$menu_item->title = $falang_taxo->translate_term_field($original_term, $original_term->taxonomy, 'name', null, $menu_item->title);

					} else {

						$menu_item->title = $menu_item->post_title;

					}

					// url already filtered

				}

			}

		} else if ($menu_item->type == 'custom') {

			if ($menu_item->title == 'language') {

//				static $languages, $language_index;
//
//				if (!isset($languages)) {
//
//					$languages = $this->get_sorted_languages();
//
//				}
//
//				if (!isset($language_index) || $language_index >= count($languages)) {
//
//					$language_index = 0;
//
//				}
//
//				$language = $languages[$language_index];
//
//				/**
//				 * Filter language name
//				 *
//				 * @from 1.2
//				 *
//				 * @param WP_post object
//				 */
//				$menu_item->title = apply_filters('falang_language_name', $language->post_title, $language);
//				$menu_item->url = $this->get_translation_link($language);
//				$menu_item->classes[] = $this->is_current($language) ? 'active_language' : 'inactive_language';
//				$menu_item->classes[] = 'falang';
//				$menu_item->classes[] = $language->post_name;
//
//				$language_index++;

			}

			$menu_item = $this->translate_nav_menu_item($menu_item, true);

		}

		return $menu_item;

	}

	/**
	 * Translate a nav menu item
	 *
	 * @param object WP_Post $menu_item
	 * @return object WP_Post
	 *
	 * @from 1.0
	 */
	public function translate_nav_menu_item($menu_item, $fill_default_title = false) {
		$falang_post = new \Falang\Core\Post();


		if (!$this->is_default() && $falang_post->is_post_type_translatable('nav_menu_item')) {

			$menu_item->post_title = $falang_post->translate_post_field($menu_item, 'post_title', $this->get_current_language(), ($fill_default_title ? $menu_item->title : ''));
			$menu_item->description = $falang_post->translate_post_field($menu_item, 'post_content', $this->get_current_language(), $menu_item->description);
			$menu_item->attr_title = $falang_post->translate_post_field($menu_item, 'post_excerpt', $this->get_current_language(), $menu_item->attr_title);

            /*
             * @since 1.3.24
             * apply filter /use for yoothme to transalte custom menu item (use title not translated)
             * */
            $menu_item = apply_filters('falang_translate_nav_menu_item',$menu_item);

		}

		return $menu_item;
	}

	/**
	 * Remove items that need to be hidden in current language
	 *
	 * Filter for 'wp_nav_menu_objects'
	 *
	 * @from 1.5
	 */
	public function filter_nav_menu_objects($sorted_menu_items, $args) {
		$falang_post = new \Falang\Core\Post();

		if ($falang_post->is_post_type_translatable('nav_menu_item') && in_array('falang_hide', $falang_post->get_post_type_metakeys('nav_menu_item'))) {

			$filtered_items = array();

			foreach ($sorted_menu_items as $menu_item) {

				if (!$this->is_default() && !get_post_meta($menu_item->ID, $this->get_prefix($this->current_language->locale).'falang_hide', true) || !get_post_meta($menu_item->ID, 'falang_hide', true)) {

					$filtered_items[] = $menu_item;

				}

			}

			return $filtered_items;
		}

		return $sorted_menu_items;
	}

	/**
	 * Print language switch
	 *
	 * hook for 'falang_print_language_switch'
     * @since 1.3.20 add width an height and custom flags
     *
	 * @from 1.0
	 */
	public function print_language_switch($context = null) {
		$languages = $this->model->get_languages_list();
		$width = $this->model->get_option('flag_width','16');
        $height = $this->model->get_option('flag_height','11');

		if (has_action('print_custom_language_switch')) {

			/**
			 * Customize language switch output
			 *
			 * @from 1.2
			 *
			 * @param array of languages
			 * @param Falang_site $this The Falang instance.
			 * @param mixed context
			 */
			do_action_ref_array('print_custom_language_switch', array($languages, $this, $context));

		} else {

			$output = '<ul class="falang-language-switcher">';


			foreach ($languages as $language) {

				$class = array();
				$flag_url = '';
				if ( $this->is_default($language)) {
					$class[] = ' current';
				}

                //use custom flag if define
                if (isset($language->custom_flag) && !empty($language->custom_flag)) {
                    $flag_url = $language->custom_flag;
                }else {
                    $file = FALANG_DIR . '/flags/' . $language->flag_code . '.png';
                    if (!empty($language->flag_code) && file_exists($file)) {
                        $flag_url = plugins_url('flags/' . $language->flag_code . '.png', FALANG_FILE);
                    }
                }


				/**
				 * Filter language name
				 *
				 * @from 1.2
                 * @since 1.3.20 add witdh and heigh add language filter name
				 *
				 * @param string language name
				 * @param WP_Post language custom post
				 */
				//display flag
				$output .= sprintf(
					'<li><a class="%1$s" href="%2$s"><img src="%3$s" alt="%4$s" width="%5$spx" height="%6$spx" />%7$s</a></li>',
					implode(" ", $class),
					$this->get_translated_url($language),
					$flag_url,
                    $width,
                    $height,
                    apply_filters('falang_language_name', $language->name, $language),

					'');

			}

			$output .= '</ul>';

			echo $output;

		}

	}

	/**
	 * Custom translation. Falang API
	 *
	 * Filter for 'falang_custom_translate'
	 *
	 * @from 1.0
	 */
	public function custom_translate($content, $callback, $args = null) {

		if ($this->has_language()) {

			return call_user_func($callback, $content, $this->model->get_languages_list(), $this, $args);

		}

		return $content;
	}

    /**
     * Get language link
     *
     * @from 1.0
     * @since 1.3.26 add link filter before return
     */
	public function get_translated_url( $language ) {
		$args = array(
			'using_permalinks' => (bool) get_option( 'permalink_structure' ),
		);
		global $wp_query, $wp_rewrite;

		$query_object = get_queried_object();


		$this->set_language($language); // -> pretend this is the current language

		$link = '';

		if ( is_category() || is_tag() || is_tax() ) {

			$original_term = get_term( $query_object->term_id, $query_object->taxonomy );

			$link = get_term_link( $original_term, $original_term->taxonomy );

		} else if ( is_post_type_archive() ) {
			$link = get_post_type_archive_link( $query_object->name );

		} else if ( is_singular() || $wp_query->is_posts_page ) {

			$link = get_permalink( $query_object->ID );

		} else if ( is_date() ) {

			if ( is_day() ) {
				$link = get_day_link( get_query_var( 'year' ), get_query_var( 'monthnum' ), get_query_var( 'day' ) );
			} else if ( is_month() ) {
				$link = get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) );
			} else if ( is_year() ) {
				$link = get_year_link( get_query_var( 'year' ) );
			} else {
				$link = home_url( '/' );
			}

		} else if ( is_author() ) {

			$link = get_author_posts_url( get_user_by( 'slug', get_query_var( 'author_name' ) )->ID );

		} else if ( is_search() ) {

			$link = get_search_link( get_search_query() );

		} else { // is_home, is_404

			$link = home_url( '/' );

		}

		$this->restore_language();

		/*
		 * since 1.3.26 
		 * */
        $link = apply_filters( 'falang_get_translated_url', $link, $language);

		return $link;
	}

	/**
	 *	Translate tag cloud
	 *  Filter for 'tag_cloud_sort'
	 * @from 1.0
	 */
	public function translate_tag_cloud($tags, $args) {

		if (!$this->is_default()) {

			foreach ($tags as $term) {

				$this->translate_term($term);

			}

		}

		return $tags;

	}

	/**
	 * Translate term
	 *
	 * @from 1.0
	 */
	public function translate_term($term, $language = null) {
		$falang_taxo = new \Falang\Core\Taxonomy();

		if (empty($language)) {

			$language = $this->get_current_language();

		}

		if ($falang_taxo->is_taxonomy_translatable($term->taxonomy) && !$this->is_default($language)) {

			$term->name = $falang_taxo->translate_term_field($term, $term->taxonomy, 'name', $language);
			$term->slug = $falang_taxo->translate_term_field($term, $term->taxonomy, 'slug', $language);
			$term->description = $falang_taxo->translate_term_field($term, $term->taxonomy, 'description', $language);

		}

		return $term;

	}


	/**
	 * Requestion current language
	 *
	 * @from 1.0
	 *
	 * @return object WP_post|false
	 */
	public function request_current_language() {

		if (isset($_REQUEST[$this->language_query_var])) {

			return $this->model->get_language_by_slug($_REQUEST[$this->language_query_var]);

		} else if (isset($_SERVER['REQUEST_URI'])) {

			if (preg_match('/\/('.implode('|', $this->model->get_language_column('slug')).')(\/|$|\?|#)/', $_SERVER['REQUEST_URI'], $matches)) { // -> language detected!

				$language = $this->model->get_language_by_slug($matches[1]);

				if ($this->is_default($language) && !$this->model->get_option('show_slug')) {

					$this->canonical = false;

				}

			} else {

				if ($this->model->get_option('show_slug')) {

					//sbou manage 404 images
					if (!preg_match("/^.*\.(jpg|jpeg|png|gif|ico)$/i", $_SERVER['REQUEST_URI'])) {
						$this->canonical = false;
					}

				}

				if ($this->model->get_option('autodetect')) { // auto detect language on home page

					// detect only on home page? --> rtrim($_SERVER['SCRIPT_URI'], '/') == rtrim(home_url())

					$detected_language = $this->auto_detect_language();

					if ($detected_language) {

						$language = $detected_language;

					}

				}

			}

		}

		if (empty($language)) {

			$language = $this->model->get_default_language();

		}

		$GLOBALS['text_direction'] = $language->rtl?'rtl':'tlr';

		return $language;


	}

	/**
	 * Detect language
	 *
	 * @from 1.2
	 * @from 1.3.13 fix bug on available_langauge need to use slug and not locale
	 *
	 * @return WP_Post|false
	 */
	public function auto_detect_language() {

		$available_languages = array();
		foreach ($this->model->get_languages_list() as $language) {

			$available_languages[] = $language->slug;

		}

		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {

			$prefered_language = $this->prefered_language($available_languages, $_SERVER['HTTP_ACCEPT_LANGUAGE']);

			if ($prefered_language) {

				foreach ($prefered_language as $language_slug => $value) {

					return $this->model->get_language_by_slug($language_slug);

				}

			}

		}

		return false;
	}

	/**
	 * Find prefered language
	 * source: https://stackoverflow.com/a/25749660/2086505
	 *
	 * @from 1.0
	 *
	 * @param array $available_languages Available languages. Eg: array("en", "zh-cn", "es");
	 * @param string $http_accept_language HTTP Accepted languages. Eg: $_SERVER["HTTP_ACCEPT_LANGUAGE"] = 'en-us,en;q=0.8,es-cl;q=0.5,zh-cn;q=0.3';
	 * @return array prefered languages. Eg: Array([en] => 0.8, [es] => 0.4, [zh-cn] => 0.3)
	 */
	private function prefered_language($available_languages, $http_accept_language) {

		$available_languages = array_flip($available_languages);

		$langs = array();
		preg_match_all('~([\w-]+)(?:[^,\d]+([\d.]+))?~', strtolower($http_accept_language), $matches, PREG_SET_ORDER);
		foreach($matches as $match) {

			list($a, $b) = explode('-', $match[1]) + array('', '');
			$value = isset($match[2]) ? (float) $match[2] : 1.0;

			if(isset($available_languages[$match[1]])) {
				$langs[$match[1]] = $value;
				continue;
			}

			if(isset($available_languages[$a])) {
				$langs[$a] = $value - 0.1;
			}

		}
		arsort($langs);

		return $langs;
	}

	/**
	 * Find taxonomy by query var
	 *
	 * @from 1.0
	 */
	public function query_var_to_taxonomy($taxonomy_qv) {

		$results = get_taxonomies(array('query_var' => $taxonomy_qv));

		foreach ($results as $result) {

			return $result;

		}

		return false;

	}

	/**
	 * Check if taxonomy is translatable.
	 *
	 * @from 1.2.3
	 *
	 * @param string $taxonomy
	 *
	 * @return boolean
	 */
	public function is_taxonomy_translatable($taxonomy) {
		//TODO not the right place put it in core
		$falang_taxonomy = new \Falang\Core\Taxonomy();
		return $falang_taxonomy->is_taxonomy_translatable($taxonomy);
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Falang_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Falang_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/falang-public.css', array(), $this->version, 'all' );

	}


	/**
	 * Add language slug in login url
	 *
	 * Filter for 'login_url', 'logout_url', 'lostpassword_url', 'register_url'
	 *
	 * @from 1.0
	 */
	public function translate_login_url($login_url){

		if ($this->has_language()) {

			$login_url = add_query_arg(array($this->language_query_var => $this->get_current_language()->slug), $login_url);

		}

		return $login_url;

	}

	/**
	 * Add language input in login forms
	 *
	 * Hook for 'login_form', 'lostpassword_form', 'resetpass_form', 'register_form'
	 *
	 * @from 1.0
	 */
	public function translate_login_form() {

		echo '<input type="hidden" name="'.$this->language_query_var.'" value="'.$this->get_current_language()->slug.'"/>';

	}



//use core
//	public function translate_home_url($url, $path, $orig_scheme, $blog_id) {
//
//		$language = $this->get_current_language();
//
//		if (get_option('permalink_structure')) {
//
//			$url = rtrim(substr($url, 0, strlen($url) - strlen($path)), '/') . '/' . $language->slug . '/' . ltrim($path, '/');
//
//		} else {
//
//			$url = add_query_arg( array('lang' => $language->slug), $url);
//
//		}
//		return $url;
//	}

	/**
	 * Translate link in retrieve password message
	 *
	 * Filter for 'retrieve_password_message'
	 *
	 * @from 1.0
	 */
	public function translate_retrieve_password_message($message) {

		return  preg_replace('/(wp-login\.php[^>]*)/', '$1'.'&'.$this->language_query_var.'='.$this->get_current_language()->slug, $message);

	}

	/**
	 * lostpassword redirect
	 *
	 * Filter for 'lostpassword_redirect'
	 *
	 * @from 1.2
	 */
	public function lostpassword_redirect($redirect_to) {

		return 'wp-login.php?checkemail=confirm'.'&'.$this->language_query_var.'='.$this->get_current_language()->slug;

	}

	/**
	 * registration redirect
	 *
	 * Filter for 'registration_redirect'
	 *
	 * @from 1.0
	 */
	public function registration_redirect($redirect_to) {

		return 'wp-login.php?checkemail=registered'.'&'.$this->language_query_var.'='.$this->get_current_language()->slug;

	}

    /**
     * Print hreflang
     *
     * Filter for 'wp_head'
     *
     * @from 1.3.7
     */
    public function print_hreflang() {

        $hreflangs = array();
        $languages = $this->model->get_languages_list();

        foreach ($languages as $language) {
            //hreflang code ISO 639-1 en-GB , fr-FR and not like wordpress locale en_GB,fr_FR
            $lang =  str_replace('_','-',$language->locale);
            $hreflangs[ $lang ] = $this->get_translated_url($language);
        }

        // Adds the site root url when the default language code is not hidden
        // see polylang thread
        // See https://wordpress.org/support/topic/implementation-of-hreflangx-default
        if ( is_home() && $this->model->get_option('show_slug' ) ){
            //need to remove the language locale /en_us and leave a / at the end
            $home_url = str_replace('/'.$this->current_language->slug,'',home_url ('/'));

            $hreflangs['x-default'] = $home_url;
        }


        /**
         * Filters the list of rel hreflang attributes
         *
         * @since 1.3.7
         *
         * @param array $hreflangs Array of urls with language codes as keys
         */
        apply_filters('falang_hreflang', $hreflangs);

        foreach ( $hreflangs as $lang => $url ) {
            printf( '<link rel="alternate" href="%s" hreflang="%s" />' . "\n", esc_url( $url ), esc_attr( $lang ) );
        }
    }


	/**
	 *	Pre translate post link
	 *	Filter for 'pre_post_link'
	 *
	 * @from 1.0
	 */
	public function pre_translate_permalink($permalink, $post, $leavename) {
		if (!$this->is_default()) {

			$permalink = str_replace('%postname%', '%translated_postname%', $permalink);
			$permalink = str_replace('%pagename%', '%translated_postname%', $permalink);

		}

		return $permalink;
	}

	/**
	 * Translate permalink
	 * Filter for 'post_link'
	 *
	 * @from 1.0
	 */
	public function translate_permalink($permalink, $post, $leavename) {

		if (!$this->is_default()) {
			$falang_post = new \Falang\Core\Post($post->ID);

			$translated_name = $falang_post->translate_post_field($post, 'post_name',$this->get_current_language());

			$permalink = str_replace('%translated_postname%', $translated_name, $permalink);

		}

		return $permalink;

	}

	/**
	 * Translate page link
	 * Filter for 'page_link'
	 *
	 *
	 * @from 1.0
	 */
	public function translate_page_link($link, $post_id, $sample = false) {
		$falang_post = new \Falang\Core\Post();

		if (!$sample && !$this->is_default() && $falang_post->is_post_type_translatable('page')) {

			$original = get_post($post_id);

			$translated_slug = $falang_post->translate_post_field($original, 'post_name',$this->get_current_language());

			// hierarchical pages
			while ($original->post_parent != 0) {

				$original = get_post($original->post_parent);

				$parent_slug = $falang_post->translate_post_field($original, 'post_name',$this->get_current_language());

				$translated_slug = $parent_slug.'/'.$translated_slug;

			}

			$link = get_page_link($original, true, true);
			$link = str_replace('%pagename%', $translated_slug, $link);

		}

		return $link;
	}


	/**
	 * Translate attachment link
	 * Filter for 'attachment_link'
	 *
	 * @from 1.0
	 */
	public function translate_attachment_link($link, $post_id) {
		global $wp_rewrite;
		$falang_post = new \Falang\Core\Post();

		if (!$this->is_default()) {

			$link = trailingslashit($link);
			$post = get_post( $post_id );
			$parent = ( $post->post_parent > 0 && $post->post_parent != $post->ID ) ? get_post( $post->post_parent ) : false;

			if ( $wp_rewrite->using_permalinks() && $parent ) {

				$translation_name = $falang_post->translate_post_field($post, 'post_name',$this->get_current_language());

				$link = str_replace ('/'.$post->post_name.'/', '/'.$translation_name.'/', $link);

				do {

					$translation_parent_name = $falang_post->translate_post_field($parent, 'post_name',$this->get_current_language());

					$link = str_replace ('/'.$parent->post_name.'/', '/'.$translation_parent_name.'/', $link);

					$parent = ( $parent->post_parent > 0 && $parent->post_parent != $parent->ID ) ? get_post( $parent->post_parent ) : false;

				} while ($parent);

			}

		}

		return $link;
	}

	/**
	 *	Translate post link category
	 *	Filter for 'post_link_category'
	 *
	 * @from 1.0
	 */
	public function translate_post_link_category($cat, $cats, $post) {

		//TODO to be done...

		return $cat;
	}

	/**
	 * Translation post type archive link
	 *
	 * Filter for 'post_type_archive_link'
	 *
	 * @from 1.0
	 * @from 1.3 use specific archive slug if any
     * @since 1.3.25 post_type_obj->rewrite can be set to false
	 */
	function translate_post_type_archive_link($link, $post_type) {
		global $wp_rewrite;
		$falang_post = new \Falang\Core\Post();

		if ($falang_post->is_post_type_translatable($post_type)) {

			$post_type_obj = get_post_type_object($post_type);

			if ($post_type_obj && get_option( 'permalink_structure' )) {

				$struct = $falang_post->translate_cpt_archive($post_type,$this->get_current_language());

                //$post_type_obj->rewrite can be set to false
                if ( isset($post_type_obj->rewrite['with_front']) && $post_type_obj->rewrite['with_front'] )
					$struct = $wp_rewrite->front . $struct;
				else
					$struct = $wp_rewrite->root . $struct;

				$link = home_url( user_trailingslashit( $struct, 'post_type_archive' ) );
			}

		}

		return $link;
	}

	/**
	 * Translate month link
	 * Filter for 'month_link'
	 *
	 * @from 1.0
	 */
	public function translate_month_link($monthlink) {

		return $monthlink;

	}

	/**
	 * Translate term link
	 *
	 * @filter 'term_link'
	 *
     * @param string  $termlink Term link URL.
     * @param WP_Term $term     Term object.
     * @param string  $taxonomy Taxonomy slug.
     *
	 * @from 1.0
	 */
	public function translate_term_link($termlink, $term, $taxonomy) {
		global $wp_rewrite;
		$falang_taxo = new \Falang\Core\Taxonomy();

		if (get_option('permalink_structure') && $falang_taxo->is_taxonomy_translatable($taxonomy)) {

			$taxonomy_obj = get_taxonomy($taxonomy);
			$termlink = ($taxonomy_obj->rewrite['with_front']) ? $wp_rewrite->front : $wp_rewrite->root;
			$termlink .= $falang_taxo->translate_taxonomy($taxonomy, $this->get_current_language(), $taxonomy);

			// -> todo: handle hierarchical taxonomy...

			$translated_slug = $falang_taxo->translate_term_field($term, $taxonomy, 'slug',$this->get_current_language());
			$termlink = home_url(user_trailingslashit($termlink . '/' . $translated_slug, 'category'));

		}

		return $termlink;
	}

	/**
	 * Add language in edit link
	 *
	 * Filter for 'get_edit_post_link'
	 *
	 * @from 1.0
	 */
	public function translate_edit_post_link($url, $post_id, $context) {
		$falang_post = new \Falang\Core\Post();

		if (!$this->is_default()) {

			$post = get_post($post_id);

			$language = $this->get_current_language();

			if (isset($post->post_type) && $falang_post->is_post_type_translatable($post->post_type)) {

				$url = add_query_arg(array($this->language_query_var => $language->slug), $url);

			}

		}

		return $url;

	}

	/**
	 * Handle search query
	 *
	 * @hook for 'parse_query'
	 *
	 * @from 1.0
	 */
	public function parse_query($wp_query) {

		if ($this->is_query_translatable($wp_query->query_vars)) {

			$language = isset($wp_query->query_vars['falang']) ? $this->model->get_language_by_slug($wp_query->query_vars['falang']) : $this->get_current_language();

			if (isset($wp_query->query_vars['s']) && $wp_query->query_vars['s']) { // query_vars['s'] is empty string by default

				$search_meta_fields = array();

				if (!$this->is_default($language)) {

					$search_meta_fields = array(
						$this->get_prefix($language->locale) . 'post_title',
						$this->get_prefix($language->locale) . 'post_content',
						$this->get_prefix($language->locale) . 'post_excerpt'
					);

				}

				/**
				 * Filter meta keys searcheable for translation
				 *
				 * @from 1.0
				 *
				 * @param array $search_meta_fields. Array of custom field keys to search into
				 * @param WP_Query object $query
				 * @param Post object $language
				 * @param Falang_current object $this
				 */
				$search_meta_fields = apply_filters('falang_search_meta', $search_meta_fields, $wp_query, $language, $this);

				if ($search_meta_fields) {

					$wp_query->query_vars['falang_search_meta'] = $search_meta_fields;
					$wp_query->query_vars['falang_search_alias'] = 'postmeta_search';

					add_filter('posts_join_request', array($this, 'meta_search_join'), 10, 2);
					add_filter('posts_search', array($this, 'meta_search'), 10, 2);
					add_filter('posts_distinct_request', array($this, 'meta_search_distinct'), 10, 2);

				}

			}

			/**
			 * Hook called on parsing a query that needs translation
			 *
			 * @from 1.0
			 *
			 * @param WP_Query object $query
			 * @param Falang_current object $this
			 */
			do_action('falang_parse_query', $wp_query, $language, $this);

		}

	}

	/**
	 * @filter 'posts_join'
	 *
	 * @from 1.3
	 */
	public function meta_search_join($join, $wp_query) {
		global $wpdb;

		if (isset($wp_query->query_vars['falang_search_alias'])) {
			$alias = $wp_query->query_vars['falang_search_alias'];
			$fields = $wp_query->query_vars['falang_search_meta'];
			return "LEFT JOIN $wpdb->postmeta AS $alias ON ($wpdb->posts.ID = $alias.post_id AND $alias.meta_key IN ('".implode("','", esc_sql($fields))."')) " . $join;
		}

		return $join;
	}

	/**
	 * @filter 'posts_distinct_request'
	 *
	 * @from 1.3
	 */
	public function meta_search_distinct($distinct, $wp_query) {
		if (isset($wp_query->query_vars['falang_search_alias'])) {
			return 'DISTINCT';
		}
		return $distinct;
	}

	/**
	 * @filter 'posts_search'
	 *
	 * @from 1.3
	 */
	public function meta_search($search, $wp_query) {
		global $wpdb;

		if (isset($wp_query->query_vars['falang_search_alias'])) {
			$alias = $wp_query->query_vars['falang_search_alias'];

			$q = $wp_query->query_vars;

			$search = '';

			// added slashes screw with quote grouping when done early, so done later
			$q['s'] = stripslashes( $q['s'] );
			if ( empty( $_GET['s'] ) && $wp_query->is_main_query() )
				$q['s'] = urldecode( $q['s'] );
			// there are no line breaks in <input /> fields
			$q['s'] = str_replace( array( "\r", "\n" ), '', $q['s'] );
			$q['search_terms_count'] = 1;
			if ( ! empty( $q['sentence'] ) ) {
				$q['search_terms'] = array( $q['s'] );
			} else {
				if ( preg_match_all( '/".*?("|$)|((?<=[\t ",+])|^)[^\t ",+]+/', $q['s'], $matches ) ) {
					$q['search_terms_count'] = count( $matches[0] );
					$q['search_terms'] = $wp_query->parse_search_terms( $matches[0] );
					// if the search string has only short terms or stopwords, or is 10+ terms long, match it as sentence
					if ( empty( $q['search_terms'] ) || count( $q['search_terms'] ) > 9 )
						$q['search_terms'] = array( $q['s'] );
				} else {
					$q['search_terms'] = array( $q['s'] );
				}
			}

			$n = ! empty( $q['exact'] ) ? '' : '%';
			$searchand = '';
			$q['search_orderby_title'] = array();

			/**
			 * Filters the prefix that indicates that a search term should be excluded from results.
			 *
			 * @since 4.7.0
			 *
			 * @param string $exclusion_prefix The prefix. Default '-'. Returning
			 *                                 an empty value disables exclusions.
			 */
			$exclusion_prefix = apply_filters( 'wp_query_search_exclusion_prefix', '-' );

			foreach ( $q['search_terms'] as $term ) {
				// If there is an $exclusion_prefix, terms prefixed with it should be excluded.
				$exclude = $exclusion_prefix && ( $exclusion_prefix === substr( $term, 0, 1 ) );
				if ( $exclude ) {
					$like_op  = 'NOT LIKE';
					$andor_op = 'AND';
					$term     = substr( $term, 1 );
				} else {
					$like_op  = 'LIKE';
					$andor_op = 'OR';
				}

				if ( $n && ! $exclude ) {
					$like = '%' . $wpdb->esc_like( $term ) . '%';
					$q['search_orderby_title'][] = $wpdb->prepare( "{$wpdb->posts}.post_title LIKE %s", $like );
				}

				$like = $n . $wpdb->esc_like( $term ) . $n;

				$termsearch = $wpdb->prepare( "($wpdb->posts.post_title $like_op %s) $andor_op ($wpdb->posts.post_excerpt $like_op %s) $andor_op ($wpdb->posts.post_content $like_op %s)", $like, $like, $like );

				// -> modified
				$termsearch .= $wpdb->prepare( " $andor_op ($alias.meta_value $like_op %s)", $like );

				$search .= "{$searchand}($termsearch)";

				$searchand = ' AND ';
			}

			if ( ! empty( $search ) ) {
				$search = " AND ({$search}) ";
				if ( ! is_user_logged_in() ) {
					$search .= " AND ({$wpdb->posts}.post_password = '') ";
				}
			}

		}

		return $search;

	}

	/**
	 * Helper for parse_query(). Check if query is to be translated
	 *
	 * @param array $query_vars.
	 *
	 * @from 1.0
	 */
	public function is_query_translatable($query_vars) {
		$falang_post = new \Falang\Core\Post();

		$post_type = isset($query_vars['post_type']) ? $query_vars['post_type'] : 'post';

		if ($post_type === 'any') {

			return true; // lets pretend it is...

		} else if (is_string($post_type)) {

			return $falang_post->is_post_type_translatable($post_type);

		} else if (is_array($post_type)) {

			return array_filter($post_type, array($falang_post, 'is_post_type_translatable')); // at least one is

		}

	}

	/**
	 *	Enqueue terms for translation as they are queried
	 *	Filter for 'get_object_terms'
	 *
	 * @from 1.4.5
	 */
	public function filter_get_object_terms($terms, $object_ids, $taxonomies, $args) {

		return $this->translate_get_terms($terms, $taxonomies, $args);

	}

	/**
	 * Filter post terms. Hard translate
	 *
	 * @filter 'get_terms'
	 *
	 * @from 1.1
	 */
	public function translate_get_terms($terms, $taxonomies, $args) {

		if (isset($args[$this->language_query_var])) {

			if (!$args[$this->language_query_var]) { // false -> do not translate

				// Documented below
				return apply_filters('falang_translate_the_terms', $terms, $terms, null, $args, $this);

			} else { // language slug

				$language = $this->model->get_language_by_slug($args[$this->language_query_var]);

			}

		} else { // language not set -> use current

			$language = null;

		}

		if (!$this->is_default($language)) {

			if (isset($args['fields']) && $args['fields'] == 'names') { // -> Added in 1.4.4

				$terms = array(); // -> restart query

				unset($args['fields']);

				$results = get_terms($taxonomies, $args);

				foreach ($results as $term) {

					$terms[] = $this->translate_term_field($term, $term->taxonomy, 'name');

				}

				return $terms;
			}

			if (empty($args['fields']) || $args['fields'] == 'all' || $args['fields'] == 'all_with_object_id') {

				/**
				 * Filter the terms after translation
				 *
				 * @from 2.0
				 *
				 * @param array of object WP_Term $translated terms.
				 * @param array of object WP_Term $original terms.
				 * @param object WP_Post $language.
				 * @param object $args.
				 * @param object Falang_core $this.
				 */
				$terms = apply_filters('falang_translate_the_terms', $this->translate_terms($terms, $language), $terms, $language, $args, $this);

			}

		}

		return $terms;
	}

	/**
	 * Translate terms
	 *
	 * @from 2.0
	 *
	 * @param array of object WP_Terms $terms
	 * @param object language
	 */
	public function translate_terms($terms, $language = null) {

		$new_terms = array();

		foreach ($terms as $term) {

			/**
			 * Filter the term after translation
			 *
			 * @from 2.0
			 *
			 * @param object WP_Term $translated post.
			 * @param object WP_Term $original post.
			 * @param object WP_Term $language.
			 * @param object Falang_core $this.
			 */
			$new_terms[] = apply_filters('falang_translate_the_term', $this->translate_term($term, $language), $term, $language, $this);

		}

		return $new_terms;
	}


	/**
	 * get term field translation if it exists
	 *
	 * @from 2.0
	 *
	 * @param object WP_Term $term.
	 * @param string $taxonomy.
	 * @param string $field. Accepts 'name', 'slug', 'description'
	 * @param object WP_Post $language.
	 * @return string
	 */
	public function get_term_field_translation($term, $taxonomy, $field, $language = null) {
		$falang_taxo = new \Falang\Core\Taxonomy();

		if (empty($language)) {

			$language = $this->get_current_language();

		}

		if (!$this->is_default($language) && $falang_taxo->is_taxonomy_translatable($term->taxonomy)) {

			return get_term_meta($term->term_id, $this->get_prefix($language->locale) . $field, true);

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

	/**
	 * Hard translate term
	 * @filter 'get_term'
	 *
	 * @from 1.2
	 */
	public function translate_get_term($term, $taxonomy) {
		if ($taxonomy == 'language' || $taxonomy == 'term_language'){return $term;}

		//TODO remove this object creation
		$falang_taxo = new \Falang\Core\Taxonomy();

		if (!$this->is_default() && $falang_taxo->is_taxonomy_translatable($taxonomy)) {
            //TODO use $this->get_current_language()
			$this->translate_term($term,$this->request_current_language());

		}

		return $term;

	}


	/**
	 * Filter post terms
	 *
	 * @filter 'get_the_terms'
	 *
	 * @from 1.0
	 */
	public function translate_post_terms($terms, $post_id, $taxonomy) {
		//TODO remove this object creation
		$falang_taxo = new \Falang\Core\Taxonomy();

		if (!$this->is_default() && $falang_taxo->is_taxonomy_translatable($taxonomy)) {

			foreach ($terms as $term) {

				$this->translate_term($term);

			}

		}

		return $terms;

	}


	/**
	 *	Translate term name
	 *	Filter for 'list_cats'
	 *
	 * @from 1.0
	 */
	public function translate_term_name($name, $term = null) {

		if (!isset($term)) { // looks like there are 2 differents list_cats filters

			return $name;

		}

		return $this->translate_term_field($term, $term->taxonomy, 'name', null, $name);
	}


	/**
	 * Add language query args to url (Public API)
	 *
	 * @filter 'falang_query_add_language'
	 *
	 * @from 1.0
	 */
	public function query_add_language($url) {

		if (!$this->is_default()) {

			$url = add_query_arg(array($this->language_query_var => $this->get_current_language()->slug), $url);

		}

		return $url;
	}

	/**
	 * Add filters for options translation
	 *
	 * @from 1.0
	 */
	public function add_options_filters() {

		$translations = $this->model->get_option('translations', array());

		$language = $this->get_current_language();

		if ($language && isset($translations['option'][$language->locale])) {

			foreach ($translations['option'][$language->locale] as $option => $val) {

				add_filter('option_' . $option, array($this,  'filter_option'), 10, 2);

			}

		}

	}

	/**
	 * Add filters for options translation
	 *
	 * @from 1.0
	 */
	public function filter_option($value, $option = null) {

		if (empty($option)) return $value; // $option is only defined since wp 4.4

		$translations = $this->model->get_option('translations', array());

		$language = $this->get_current_language();

		if ($language && isset($translations['option'][$language->locale][$option])) {

			$this->translate_option($value, $translations['option'][$language->locale][$option]);

		}

		return $value;
	}

	/**
	 * translate options
	 *
	 * @from 1.5.3 add striplashes
	 * @from 1.5
	 */
	private function translate_option(&$option, $translation ) {

		if (is_array($translation)) {

			foreach ($translation as $key => $value) {

				if (isset($option[$key])) {

					$item = $this->translate_option($option[$key], $value );

				}

			}

		} else {

			$option = stripslashes($translation);

		}

	}


	/**
	 * Loads user defined strings translations
	 *
	 * @since 1.0
	 *
	 * @param string $locale Locale. Defaults to current locale.
	 */
	public function load_strings_translations($locale = '' ){
		if ( empty( $locale ) ) {
			$locale =  $this->get_current_language()->locale;
		}
		$language = $this->model->get_language_by_locale( $locale );

		if ( ! empty( $language ) ) {
			$mo = new Falang_Mo();
			$mo->import_from_db( $language );
			$GLOBALS['l10n']['falang_string'] = &$mo;
		} else {
			unset( $GLOBALS['l10n']['falang_string'] );
		}

	}

	/**
	 *	Append language slug to home url
	 *	Filter for 'home_url'
	 *  exist for back too
	 *
	 * @from 1.0
	 * @update 1.3.3 put a version for front and back
     * @update 1.3.13 fix url with double language prefix (ex widget sorting from savoy theme) jurij_c
	 */
	public function translate_home_url($url, $path, $orig_scheme, $blog_id) {
		$language = $this->get_current_language();

		if (!$this->disable_translate_home_url
		    && $language
		    &&  ($this->model->get_option('show_slug') || !$this->is_default())) {
			if ( get_option( 'permalink_structure' ) ) {

                //fix url with double language slug (due to some widget code)
                $languagesprefix = $language->slug . '/';
                if(substr($path, 0, strlen($languagesprefix)) === $languagesprefix)
                {
                    $path = substr($path, strlen($languagesprefix));
                    $url= str_replace("/".$languagesprefix,"/",$url);
                }

				$url = rtrim( substr( $url, 0, strlen( $url ) - strlen( $path ) ), '/' ) . '/' . $language->slug . '/' . ltrim( $path, '/' );

			} else {

				$url = add_query_arg( array( 'lang' => $language->slug ), $url );

			}
		}
		return $url;
	}


	/**
	 * Filters the widgets according to the current language
	 * Don't display if a language filter is set and this is not the current one
	 *
	 * @since 1.2
	 *
	 * @param array  $instance Widget settings
	 * @param object $widget   WP_Widget object
	 * @return bool|array false if we hide the widget, unmodified $instance otherwise
	 */
	public function widget_display_callback( $instance, $widget ) {
		// FIXME it looks like this filter is useless, now the we use the filter sidebars_widgets
		$test = $this->get_current_language();
		return ! empty( $instance['falang_lang'] ) && $instance['falang_lang'] != $this->get_current_language()->locale ? false : $instance;
	}

	/**
	 * Remove widgets from sidebars if they are not visible in the current language
	 * Needed to allow is_active_sidebar() to return false if all widgets are not for the current language. See #54
	 *
	 * @since 1.2 The result is cached as the function can be very expensive in case there are a lot of widgets
	 *
	 * @param array $sidebars_widgets An associative array of sidebars and their widgets
	 * @return array
	 */
	public function sidebars_widgets( $sidebars_widgets ) {
		global $wp_registered_widgets;

		if ( empty( $wp_registered_widgets ) ) {
			return $sidebars_widgets;
		}

		$cache_key         = md5( maybe_serialize( $sidebars_widgets ) );
		$_sidebars_widgets = $this->cache->get( "sidebars_widgets_{$cache_key}" );

		if ( false !== $_sidebars_widgets ) {
			return $_sidebars_widgets;
		}

		foreach ( $sidebars_widgets as $sidebar => $widgets ) {
			if ( 'wp_inactive_widgets' === $sidebar || empty( $widgets ) ) {
				continue;
			}

			foreach ( $widgets as $key => $widget ) {
				// Nothing can be done if the widget is created using pre WP2.8 API :(
				// There is no object, so we can't access it to get the widget options
				if ( ! isset( $wp_registered_widgets[ $widget ]['callback'] ) || ! is_array( $wp_registered_widgets[ $widget ]['callback'] ) || ! isset( $wp_registered_widgets[ $widget ]['callback'][0] ) || ! is_object( $wp_registered_widgets[ $widget ]['callback'][0] ) || ! method_exists( $wp_registered_widgets[ $widget ]['callback'][0], 'get_settings' ) ) {
					continue;
				}

				$widget_settings = $wp_registered_widgets[ $widget ]['callback'][0]->get_settings();
				$number          = $wp_registered_widgets[ $widget ]['params'][0]['number'];

				// Remove the widget if not visible in the current language
				if ( ! empty( $widget_settings[ $number ]['falang_lang'] ) && $widget_settings[ $number ]['falang_lang'] !== $this->get_current_language()->locale ) {
					unset( $sidebars_widgets[ $sidebar ][ $key ] );
				}
			}
		}

		$this->cache->set( "sidebars_widgets_{$cache_key}", $sidebars_widgets );

		return $sidebars_widgets;
	}



	/**
	 * Setup filters for admin pages
	 *
	 * @since 1.2.1
     * @since 1.3.27 change flatsome test
	 */
	public function add_filters() {
		$classes = array('Nav_Menu','User_Profile','Widget_Pages');

		foreach ( $classes as $class ) {
			$obj = strtolower( $class );
			/**
			 * Filter the class to instantiate when loading admin filters
			 *
			 * @since 1.2.1
			 *
			 * @param string $class class name
			 */
			$class = apply_filters( 'falang_' . $obj, $class );
			$class = '\Falang\Filter\Site\\'.$class;
			$this->$obj = new $class( $this );
		}

		//WooCommerce Framework
		if (in_array('woocommerce/woocommerce.php',apply_filters( 'active_plugins', get_option( 'active_plugins' )))) {
			$this->woocommerce = new \Falang\Filter\Site\WooCommerce();
		}

		//Enfold Avia Framework
		if ( defined( 'AV_FRAMEWORK_VERSION' ) ) {
			$this->enfold =	new \Falang\Filter\Site\Enfold();
		}

        //Flatsome Framework use UX_BUILDER_VERSION not found other define for it
        if ('flatsome' == wp_get_theme()->get('Template')){
            $this->flatsome =	new \Falang\Filter\Site\Flatsome();
        }

        //Rank Math Seo plugin
        if (in_array('seo-by-rank-math/rank-math.php',apply_filters( 'active_plugins', get_option( 'active_plugins' )))) {
            $this->rankmath = new \Falang\Filter\Site\RankMath();
        }

        // Dont load if Yoast SEO is not active.
        if (in_array('wordpress-seo/wp-seo.php',apply_filters( 'active_plugins', get_option( 'active_plugins' )))) {
            $this->yoast = new \Falang\Filter\Site\Yoast();
        }

	}

	/**
	 * Display the shortcode only for selected language
	 * Shortcode [falang lang="en_GB"] [/falang]
	 *
	 * @since 1.3.1
	 */
	public function shortcode_falang($attr, $content = null){
		extract(shortcode_atts(array(
			'language' => '',
		), $attr));

		if ($this->current_language->locale == $attr['lang']){
			$output = do_shortcode($content);
		} else {
			$output = "";
		}
		return $output;
	}

    /**
     * Display the switcher by shortcode
     * [falangsw]
     *
     * @since 1.3.22
     */
    public function shortcode_falang_switcher($atts){

        $default = array(
            'dropdown' => 0,
            'display_name' => 1,
            'display_flags' => 0,
            'hide_current' => 0,
            'positioning' => 'h',
            'echo' => true,//why ? it's stupid
        );
        $attr = shortcode_atts( $default,$atts );
        $lswitcher = new Language_Switcher($attr);
        $lswitcher->display_switcher();
    }


    /**
     *	Translate attachment caption wp_get_attachment_caption
     *	Filter for 'wp_get_attachment_caption'
     *  Caption is stored in post_excerpt
     *
     * @from 1.3.6
     */
    public function translate_attachment_caption($caption, $post_id) {
        $falang_post = new \Falang\Core\Post($post_id);
        $post = get_post($post_id);

        if ($post && !$this->is_default() && $falang_post->is_post_type_translatable($post->post_type)) {

            $caption = $falang_post->translate_post_field($post, 'post_excerpt', $this->get_current_language(), $caption);

        }

        return $caption;
    }


    /**
     * Add language to comment form
     * @since 1.3.10
     */
    public function comment_form_additional_fields () {
        echo '<input id="lang" name="lang" type="hidden" value="'.$this->current_language->slug.'" />';
    }

    /**
     * Fix comment redirect
     * use part of admin/class-falang-admin.php
     * method translate_sample_permalink
     * TODO must be done probably before during permalink creation
     *
     * @since 1.3.10
     */
    public function translate_comment_post_redirect($location, $comment){
        $post = get_post($comment->comment_post_ID);
        $falang_post = new \Falang\Core\Post($post->ID);
        if ($falang_post->is_post_type_translatable($post->post_type)) {
            $current = $this->current_language;
            if ( get_option( 'permalink_structure' ) ) {
                $translation = $falang_post->translate_cpt($post->post_type, $this->get_current_language(), $post->post_type);

                if ($this->model->get_option('show_slug') || !$this->is_default()) {
                    $location = str_replace("%{$post->post_type}-slug%", $this->get_current_language()->slug . '/' .$translation, $location);
                } else {
                    $location = str_replace("%{$post->post_type}-slug%", $translation, $location);
                }

            } else {

                $location = add_query_arg( array( 'lang' => $this->get_current_language()->slug ), $location );

            }


        }
        return $location;
    }

    /*
     * $approved 1 if the comment is approved, 0 if not, 'spam' if spam.
	 * @param int        $comment_ID       The comment ID.
	 * @param int|string $comment_approved 1 if the comment is approved, 0 if not, 'spam' if spam.
     * @param array      $commentdata      Comment data. added in 4.5.0
     * */
    public function comment_post ($comment_ID,$comment_approved,$commentdata){
        if (isset($_POST['lang'])){
            $slug = sanitize_text_field($_POST['lang']);
            $language = $this->model->get_language_by_slug($slug);
            if (isset($language)){
                return add_comment_meta($comment_ID,'language', $language->locale);
            }
        }

        return false;
    }
}
