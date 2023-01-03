<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       www.faboba.com
 * @since      1.0.0
 *
 * @package    Falang
 * @subpackage Falang/includes
 */
use Falang\Core\Falang_Core;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Falang
 * @subpackage Falang/includes
 * @author     Stéphane Bouey <stephane.bouey@faboba.com>
 */
class Falang {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Falang_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
     * @since   1.3.26 add $ajax_action_list
	 */
	public function __construct() {
		if ( defined( 'FALANG_VERSION' ) ) {
			$this->version = FALANG_VERSION;
		} else {
			$this->version = '1.0';
		}
		$this->plugin_name = 'falang';

		$this->load_dependencies();
		$this->set_locale();

		//add_action( 'init' , array( $this, 'register_taxonony' ), 9 );
		$this->register_taxonony();

		// Plugin initialization
		// Take no action before all plugins are loaded
		add_action( 'plugins_loaded', array( $this, 'init' ), 1 );

        //list of ajax action who need to be managed by public falang
        //allow the product translation
        $ajax_action_list = ['flatsome_quickview'];

        if ( is_admin()  ) {
            if (isset($_REQUEST['action']) && in_array($_REQUEST['action'], $ajax_action_list)) {
                $this->define_public_hooks();
            } else {
                $this->define_admin_hooks();
            }
        } else {
            $this->define_public_hooks();
        }

		// setups post types to translate now it's in option of falang
		//add_action( 'registered_post_type', array( $this, 'registered_post_type' ) );


		//TODO put this in class-falang-admin ??
		//add local column on pages
		add_filter( 'manage_pages_columns', array( $this, 'falang_pages_columns' ));
		//add local column on posts
		add_filter( 'manage_posts_columns', array( $this, 'falang_posts_columns'), 10, 2  );
		//display locale to posts on list
		add_action( 'manage_posts_custom_column', array( $this, 'falang_manage_posts_custom_column'), 10, 2 );
		//display locale to page on list
		add_action( 'manage_pages_custom_column', array( $this, 'falang_manage_posts_custom_column'), 10, 2 );

        //save post language and association
		add_action( 'save_post', array( $this, 'falang_save_post'), 10, 2);

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Falang_Loader. Orchestrates the hooks of the plugin.
	 * - Falang_i18n. Defines internationalization functionality.
	 * - Falang_Admin. Defines all hooks for the admin area.
	 * - Falang_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-falang-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-falang-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-falang-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-falang-public.php';

		$this->loader = new Falang_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Falang_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Falang_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		global $falang_core;

		$falang_core = new Falang_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $falang_core, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $falang_core, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $falang_core, 'add_admin_menu' );

        // enqueue ajax script
        $this->loader->add_action( 'admin_enqueue_scripts', $falang_core, 'ajax_enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
     * @since    1.3.24 add frontend_ajax parameter
	 * @access   private
	 */
	private function define_public_hooks() {
		global $falang_core;

		$falang_core = new Falang_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $falang_core, 'enqueue_styles' );

        if ($falang_core->get_model()->get_option('frontend_ajax',false)) {
            $this->loader->add_action('wp_enqueue_scripts', $falang_core, 'ajax_enqueue_scripts');
        }
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Falang_Loader    Orchestrates the hooks of the plugin.
	 */
	public function	get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}


	public function register_taxonony(){
		$falang_model = new \Falang\Model\Falang_Model();

		//register language taxonomy
		$language_args= array(
			'hierarchical'      => false,
			'public'            => false,
			'show_ui'           => false, // hide the taxonomy on admin side, needed for WP 4.4.x
			'show_in_nav_menus'  => false,
			'publicly_queryable' => true, // since WP 4.5
			'query_var'          => 'lang',
			//TODO check this rewrite
			'rewrite'           => false,
			//'rewrite'            => $this->model->options['force_lang'] < 2, // no rewrite for domains and sub-domains
			'_falang'               => true, // falang taxonomy,
			'labels' => array(
				'name'          => __( 'Languages', 'falang' ),
				'singular_name' => __( 'Language', 'falang' ),
				'all_items'     => __( 'All languages', 'falang' ),
			)
		);

		register_taxonomy('language',	$falang_model->get_translated_post_types(),	$language_args);

		//register_language_groupe taxonomy
		register_taxonomy( 'languages_group',
			'term',
			array(
				'hierarchical' => false,
				'update_count_callback' => '',
				'show_ui' => false,
				'label'=>false,
				'rewrite' => false,
				'_builtin' => false,
				'show_in_nav_menus' => false
			)
		);


		$args = array( 'label' => false, 'public' => false, 'query_var' => false, 'rewrite' => false, '_falang' => true );
		register_taxonomy( 'term_language', 'term', $args );

		$args['update_count_callback'] = '_update_generic_term_count'; // count *all* posts to avoid deleting in clean_translations_terms
		register_taxonomy( 'term_translations', 'term', $args );

	}

	/**
	 * Falang initialization
	 *
	 *
	 * @since 1.1
	 * @since 1.3.2 add wpml-config parsing
	 */
	public function init(){

		if ( ! defined( 'FALANG_WPML_COMPAT' ) || FALANG_WPML_COMPAT ) {
			require_once FALANG_EXT . '/wpml/wpml-compat.php';
			require_once FALANG_EXT . '/wpml/wpml-config.php';
			FALANG_WPML_Compat::instance(); // WPML API
			FALANG_WPML_Config::instance(); // WPML wpml-config.xml parisng
		}

	}

	/**
	 * Check if registered post type must be translated
	 *
	 * @since 1.0
	 *
	 * @param string $post_type post type name
	 */
//	public function registered_post_type( $post_type ) {
//		$falang_model = new \Falang\Model\Falang_Model();
//
//		if ( $falang_model->is_translated_post_type( $post_type ) ) {
//			register_taxonomy_for_object_type( 'language', $post_type );
//			register_taxonomy_for_object_type( 'post_translations', $post_type );
//		}
//	}

	public function falang_pages_columns($posts_columns){
		return $this->falang_posts_columns( $posts_columns, 'page' );
	}


	/*
	 * Display locale and translate colum in post column
	 * */
	public function falang_posts_columns( $posts_columns, $post_type ) {
		$falang_model = new \Falang\Model\Falang_Model();

		if ( ! $falang_model->is_translated_post_type( $post_type ) ) {
			return $posts_columns;
		}

		if ( ! isset( $posts_columns['locale'] ) ) {
			$posts_columns = array_merge(
				array_slice( $posts_columns, 0, 3 ),
				array( 'locale' => __( 'Locale', 'falang' ) ),
				array_slice( $posts_columns, 3 ) );
		}

		if ( ! isset( $posts_columns['translation'] ) ) {
			$posts_columns = array_merge(
				array_slice( $posts_columns, 0, 3 ),
				array( 'translation' => __( 'Translations', 'falang' ) ),
				array_slice( $posts_columns, 3 ) );
		}

		return $posts_columns;
}

	/*
	 * Display locale for a post in post column
	 * @since 1.3.31 use filter to display or not quickump translation flag on list
	 * */
	public function falang_manage_posts_custom_column( $column_name, $post_id){
		if ( 'locale' != $column_name && 'translation' != $column_name ) {
			return;
		}

		$post_type = get_post_type( $post_id );

		//TODO check if it's necessary to make a test on is_translated_pos
		$falang_model = new \Falang\Model\Falang_Model();

		if ( ! $falang_model->is_translated_post_type( $post_type ) ) {
			return;
		}

		$locale = get_post_meta( $post_id, '_locale', true );

		if ('locale' == $column_name) {

			if ( ! empty( $locale ) ) {
				$language = $falang_model->get_language_by_locale( $locale );
				//$language is not set if a specific local is set to the post
				// and language was removed with data not removed
				if (isset($language)){
					echo esc_html($language->name);
				} else {
					echo __( 'Language removed :' .$locale, 'falang' );
				}
			} else {
				echo __( 'All languages', 'falang' );
			}
		}

		if ('translation' == $column_name) {

			//filter to disabled translation link on cpt pages
            $display_link = apply_filters('falang_display_translation_link',true,$post_id);

			//display translation link for all or empty locale
			if ( (empty( $locale ) || 'all' == $locale) && $display_link ) {
				$default_local = $falang_model->get_default_language()->locale;
				$languages     = $falang_model->get_languages_list(array( 'hide_default' => true));
				foreach ( $languages as $language ) {
					//don't display link for default language
					if ($language->locale != $default_local ) {

						//get status
						$post_status = get_post_meta($post_id,Falang_Core::get_prefix($language->locale).'published' , true);
						$status = 'dashicons dashicons-marker';
						if (!empty($post_status)){
							if ($post_status){
								$status = 'dashicons dashicons-yes-alt';
							} else {
								$status = 'dashicons dashicons-dismiss';
							}
						}

						echo sprintf( '<a href="%1$s" target="_blank""><span class="falang_post_status %2$s">%3$s</span></a> ',
							esc_url( add_query_arg(
								array( 'page' => 'falang-translation', 'language' => $language->locale, 'action' => 'edit', 'post_id' => $post_id ),
								'admin.php') ),
							$status,
							$language->get_flag() );
					}
				}
			}


		}


	}

    /*
     * Save the post/page/product meta box
     *
     * @since 1.0
     * @since 1.3.24 add association
     *
     * */
    public function falang_save_post($post_id, $post){
		$falang_model = Falang()->get_model();
		if (!$falang_model->is_translated_post_type($post->post_type)) {
			return false;
		}
	    //TODO find why there are a waring on woocommerce without the check
	    if (!isset($_POST['post_locale_choice'])){return false;}

	    $current_locales = get_post_meta( $post_id, '_locale' ,true);
	    $locale = null;
	    $locale = sanitize_html_class($_POST['post_locale_choice']);//lower/upercase locale

	    //add local exist and not same ass previous
	    //if new local is all remove it
	    if (!empty($locale) && ($current_locales != $locale)) {
	    	if ($locale == 'all'){
				delete_post_meta($post_id,'_locale');
		    } else {
			    update_post_meta( $post_id, '_locale', $locale );
		    }
		    //when locale change need to flush rewrite_rules
            $falang_model->update_option( 'need_flush', 1 );

	    }

	    //support only page association in 1.3.24
        if ('page' == $post->post_type) {
            //set association
            foreach ($falang_model->get_languages_list(array('hide_default' => false)) as $language) {
                $name = '_falang_assoc_' . $language->locale;

                //remove association on default locale => post locale change
                //don't remove for all locale , keep old value =>not used in switcher
                if (($language->locale == $locale)) {
                    delete_post_meta($post_id, $name);
                }
                if (isset($_POST[$name])){
                    $associated_post_id = sanitize_key($_POST[$name]);
                }
                if (isset($associated_post_id) && !empty($associated_post_id)) {
                    //set the association for this post
                    update_post_meta($post_id, $name, $associated_post_id);

                    //update the associated post to this post
                    //TODO don't work completly for several language
                    $associated_post_locales = get_post_meta( $associated_post_id, '_locale' ,true);
                    if (!empty($associated_post_locales) && $associated_post_locales != 'all'){
                        $assoc_name = '_falang_assoc_' . $current_locales;
                        update_post_meta($associated_post_id,$assoc_name,$post_id);
                    }
                } else {
                    //get the associated post association to remove it on the associated post
                    $associated_post_id = get_post_meta( $post_id, $name ,true);
                    if (!empty($associated_post_id)){
                        $assoc_name = '_falang_assoc_' . $current_locales;
                        delete_post_meta($associated_post_id,$assoc_name);
                    }
                    delete_post_meta($post_id, $name);

                }

            }
        }

		return true;

    }
}
