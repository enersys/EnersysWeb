<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.faboba.com
 * @since      1.0
 *
 * @package    Falang
 * @subpackage Falang/admin
 */

use Falang\Core\Falang_Rewrite;
use Falang\Core\Falang_Core;
use Falang\Core\Falang_Mo;
use Falang\Core\Falang_Upgrade;
use Falang\Core\FString;
use Falang\Core\Walker_Dropdown;
use Falang\Core\Admin_Notices;
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Falang
 * @subpackage Falang/admin
 * @author     Stéphane Bouey <stephane.bouey@faboba.com>
 */
class Falang_Admin extends Falang_Rewrite
{

    protected $active_tab;

    /**
     * @from 1.0
     *
     * @var boolean
     */
    var $disable_translate_home_url = false;

    public $filters_columns;//reference to Admin_Filters_Columns object

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     *
     */
    public function __construct($plugin_name, $version)
    {

        parent::__construct($plugin_name, $version);

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_action('plugins_loaded', array($this, 'load'));

        if (isset($_GET['page'])) {
            $this->active_tab = 'falang' === $_GET['page'] ? 'falang' : substr(sanitize_key($_GET['page']), 7);
        }
    }

    public function load()
    {

        parent::load();

        add_action( 'upgrader_process_complete', array($this,'upgrader_process_complete'),10, 2);

        // register post types without UI not use for all (ex: menu)
//		add_action('init', array($this, 'register_extra_post'), 20);
        $this->notices = new Admin_Notices();

        // Setup filters for admin pages
        // Priority 5 to make sure filters are there before customize_register is fired
        add_action('wp_loaded', array($this, 'add_filters'), 5);

        //post settings option
        //TODO put this in Ajax Handler
        add_action('wp_ajax_falang_settings_post_options', array(&$this, 'ajax_settings_post_options'));
        add_action('wp_ajax_falang_settings_taxonomy_options', array(&$this, 'ajax_settings_taxonmy_options'));

        // update post settings optons
        add_action('wp_ajax_update_settings_post_options', array(&$this, 'ajax_update_settings_post_options'));
        add_action('wp_ajax_update_settings_taxonomy_options', array(&$this, 'ajax_update_settings_taxonomy_options'));

        //term translation popup
        add_action('wp_ajax_falang_term_translation', array(&$this, 'ajax_falang_term_translation'));

        //ajax delete term translation
        add_action('wp_ajax_falang_term_delete_translation', array(&$this, 'ajax_falang_term_delete_translation'));

        //string translation popup
        add_action('wp_ajax_falang_string_translation', array(&$this, 'ajax_falang_string_translation'));

        //option translation popup
        add_action('wp_ajax_falang_option_translation', array(&$this, 'ajax_falang_option_translation'));

        //update term/taxonomy translation
        add_action('wp_ajax_falang_term_update_translation', array(&$this, 'ajax_update_term_translation'));

        //update string translation
        add_action('wp_ajax_falang_string_update_translation', array(&$this, 'ajax_update_string_translation'));
        //ajax delete post
        add_action('wp_ajax_falang_string_delete_translation', array(&$this, 'ajax_falang_string_delete_translation'));

        //update option translation
        add_action('wp_ajax_falang_option_update_translation', array(&$this, 'ajax_update_option_translation'));
        //ajax delete option translation
        add_action('wp_ajax_falang_option_delete_translation', array(&$this, 'ajax_delete_option_translation'));

        //ajax delete post
        add_action('wp_ajax_falang_post_delete_translation', array(&$this, 'ajax_falang_post_delete_translation'));
        //ajax delete menu
        add_action('wp_ajax_falang_menu_delete_translation', array(&$this, 'ajax_falang_menu_delete_translation'));


        // register ajax hooks for getting/setting
        add_action('wp_ajax_falang_export_options', array($this, 'ajax_export_options'));
        add_action('wp_ajax_falang_option_translations', array($this, 'ajax_get_option_translations'));
        add_action('wp_ajax_falang_set_option_translation', array($this, 'ajax_set_option_translation'));


        // set posts, pages and taxonomy translatable by default
        add_filter('falang_default-post', array($this, 'set_post_type_translatable'));
        add_filter('falang_default-page', array($this, 'set_post_type_translatable'));
        add_filter('falang_taxonomy_default-category', array($this, 'set_post_type_translatable'));

        // Flush rewrite rules if needed
        add_action('wp_loaded', array($this, 'flush_rewrite_rules'), 12);
        add_action('generate_rewrite_rules', array($this, 'generate_rewrite_rules'));
        add_action('save_post_page', array($this, 'save_page'), 10, 3);
        add_action('post_updated', array($this, 'update_page'), 10, 3);

        // set nav menu item translation defaults
        add_filter('falang_default-nav_menu_item', array($this, 'nav_menu_item_default_options'));
        add_filter('falang_type_metakeys', array($this, 'nav_menu_item_metakeys'), 10, 2);

        // Widgets languages filter
        add_action('in_widget_form', array($this, 'in_widget_form'), 10, 3);
        add_filter('widget_update_callback', array($this, 'widget_update_callback'), 10, 4);

        // Adds row meta links to the plugin list table aka Documentation and Faq
        add_filter('plugin_row_meta', array($this, 'plugin_row_meta'), 10, 2);

        // on load post.php
        add_action('load-post.php', array($this, 'admin_post_page'));
        add_action('load-post-new.php', array($this, 'admin_post_page'));

        //on post meta-box-display add js
        add_action('admin_print_styles-post.php', array($this, 'metabox_post_enqueue_script'));
        add_action('admin_print_styles-post-new.php', array($this, 'metabox_post_enqueue_script'));

        //get permaling translation on post page
        add_filter('preview_post_link', array($this, 'translate_preview_post_link'), 10, 2);
        add_filter('get_sample_permalink', array($this, 'translate_sample_permalink'), 10, 5);
        add_filter('post_type_link', array($this, 'translate_custom_post_link'), 9, 3);//change priority to 9 for wc shop base with category

        //debug post popup
        add_action('wp_ajax_falang_debug_display', array(&$this, 'ajax_falang_debug_display'));

        // tags table
        add_action('load-edit-tags.php', array($this, 'admin_edit_tags'));
        // save term translations in wp term view (categories...)
        add_action('edit_term', array($this, 'save_admin_term_translation'), 10, 3);

        //filter for string translation
        add_filter('falang_sanitize_string_translation', array(FString::class, 'sanitize_string_translation'), 10, 2);

        //manage ajax query for yandex translation cloud v2 don't support direct jquery call
        add_action('wp_ajax_yandex_translate', array(Falang\Translator\TranslatorYandex::class, 'ajax_yandex_translate'));

        // add/update/delete post meta data //only update necessary for attachments
        add_filter('update_post_metadata', array($this, 'update_translated_postmeta'), 10, 5);
        //add_filter('add_post_metadata', array($this, 'add_translated_postmeta'), 10, 5);
        //add_filter('delete_post_metadata', array($this, 'delete_translated_meta_data'), 10, 5);

        add_action('wp_ajax_falang_language_ordering',  array(&$this, 'ajax_falang_language_ordering'));

        //manage ajax admin notice dismiss
        add_action( 'wp_ajax_falang_set_admin_notice_viewed', array( $this, 'ajax_set_admin_notice_viewed' ) );

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/falang-admin.css', array(), $this->version, 'all');
        wp_enqueue_style('select2', plugin_dir_url(__FILE__) . 'css/select2.min.css', array(), '4.0.11', 'all');
        //font awesome
        wp_enqueue_style('fontawesome513', plugin_dir_url(__FILE__) . 'css/all.min.css', array(), '5.13.0', 'all');

        //add resizable css for string translation
        wp_enqueue_style('wp-jquery-ui-dialog');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     * @since    1.3.24 load tiptip/select2 only on falang page when needed
     */
    public function enqueue_scripts()
    {

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/falang-admin.js', array('jquery','jquery-ui-resizable'), $this->version, false);

        switch ($this->active_tab) {
            case 'language':
                // enqueue select2.js
                wp_register_script('jquery-select2', plugin_dir_url(__FILE__) . 'js/select2.min.js', array('jquery'), '4.0.11', true);
                wp_enqueue_script('jquery-select2');

                wp_enqueue_script('jquery-ui-sortable');
                break;
            case 'settings':
                // enqueue tipTip.js
                wp_register_script('jquery-tiptip', plugin_dir_url(__FILE__) . 'js/jquery-tiptip/jquery.tipTip.min.js', array('jquery'), $this->version, true);
                wp_enqueue_script('jquery-tiptip');
                break;
        }

    }

    public function add_admin_menu()
    {
        $falang_post = new \Falang\Core\Post();

        //TODO check if we add a menu link to all translateble post_type
        $post_types = get_post_types(array(
            'show_ui' => true
        ));
        foreach ($post_types as $post_type) {
            if ($falang_post->is_post_type_translatable($post_type)) {
            }
        }

        // Prepare the list of tabs
        $tabs = array();

        // Only if at least one language has been created
        if ($this->model->get_languages_list()) {
            $tabs['translation'] = __('Translate Posts', 'falang');
            $tabs['terms'] = __('Translate Terms/Taxo', 'falang');
            $tabs['menus'] = __('Translate Menus', 'falang');
            $tabs['strings'] = __('Translate Strings', 'falang');
            $tabs['options'] = __('Translate Options', 'falang');
        }


        $tabs['language'] = __('Languages', 'falang');
        $tabs['settings'] = __('Settings', 'falang');
        $tabs['help'] = __('Get Help', 'falang');
        //$tabs = apply_filters( 'falang_settings_tabs', $tabs );


        //add falang top level menu and submbenu
        foreach ($tabs as $tab => $title) {
            $page = 'falang' === $tab ? 'falang' : "falang-$tab";
            if (empty($parent)) {
                $parent = $page;
                add_menu_page($title, __('Falang', 'falang'), 'manage_options', $page, null, FALANG_ADMIN_URL . '/img/icon-20.png', '90');
            }

            add_submenu_page($parent, $title, $title, 'manage_options', $page, array($this, 'languages_page'));
        }

    }

    /*
     * @since 1.0
     * @since 1.3.32 improve get_post load object limited to the display
     *
    */
    public function languages_page()
    {

        // Handle user input
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

        //prepare page for display
        switch ($this->active_tab) {
            case 'language':

                if ('add_new_language' === $action) {
                    return $this->display_edit_language_page();
                }

                if ('edit' === $action && !empty($_GET['id'])) {
                    return $this->display_edit_language_page(intval($_GET['id']));
                } else {
                    //default action for edit_language_page
                    $this->handle_language_actions($action);
                }

                // Prepare the list table of languages
                $this->model->reset_languages_list();//TODO remove this ugly code but it's necessary due to falang_rewrite and the registered_taxonomy action.
                $language_list_table = new \Falang\Table\Languages();
                $language_list_table->prepare_items($this->model->get_languages_list());

                break;
            case 'translation':
                //list table loaded even on edit page for the cancel action //TODO change this
                $post_list_table = new \Falang\Table\Post($this->model);
                $post_list_table->prepare_items();

                if ('edit' === $action) {
                    $post_id = intval($_GET['post_id']);
                    $target_language_locale = sanitize_html_class($_GET['language']);//local in the url

                    //keep <p> tags in Falang & Classic editor
                    add_filter('tiny_mce_before_init', array($this, 'tags_tinymce_fix'));

                    return $this->display_edit_post_page($post_id, $target_language_locale);
                } else {
                    //default action for edit_language_page
                    $this->handle_translation_actions($action);
                    //1.3.3 update (Save button ) redirect to edit page else close it
                    if (isset($_POST['update'])) {
                        $post_id = intval($_POST['post_id']);
                        $target_language_locale = sanitize_html_class($_POST['target_language']);//local in the url

                        //keep <p> tags in Falang & Classic editor
                        add_filter('tiny_mce_before_init', array($this, 'tags_tinymce_fix'));

                        return $this->display_edit_post_page($post_id, $target_language_locale);
                    }
                }
                break;

            case 'terms':
                $term_list_table = new \Falang\Table\Term();
                //TODO put this like translation in another place.
                if (isset($_REQUEST['tt-filter']) && $_REQUEST['tt-filter']) {
                    $args = array(
                        'name' => $_REQUEST['tt-filter']
                    );
                    $translable_term_list = $this->get_terms_to_translate($args);
                } else {
                    $translable_term_list = $this->get_terms_to_translate();
                }
                $term_list_table->prepare_items($translable_term_list);

                //need to laoad Translator for thibox don't work inside
                if ($this->model->get_option('enable_service')) {
                    //no target language
                    \Falang\Factory\TranslatorFactory::getTranslator($this->model->get_default_locale());
                }

                if ('' === $action) {
                    //return $this->display_edit_terms_page();
                } else {
                    //default action for edit_language_page
                    $this->handle_terms_actions($action);
                }
                break;
            case 'menus':
                $menu_list_table = new \Falang\Table\Menu();
                $translable_menu_list = get_posts(array(
                    'post_type' => 'nav_menu_item',
                    'post_status' => array('publish', 'pending', 'draft', 'future', 'private'),
                    'orderby' => 'post_title',
                    'order' => 'ASC',
                    'nopaging' => true
                ));
                $menu_list_table->prepare_items($translable_menu_list);
                if ('edit' === $action) {
                    return $this->display_edit_menu_page();
                } else {
                    //default action for edit_language_page
                    $this->handle_menus_actions($action);
                }
                break;
            case 'settings' :
                if ('' === $action) {
                    return $this->display_settings_page();
                } else {
                    //default action for edit_language_page
                    $this->handle_settings_actions($action);
                    //return to settings here due to error on update
                    return $this->display_settings_page();
                }
                break;
            case 'strings' :
                $strings_list_table = new \Falang\Table\FStrings($this->model);
                $strings_list_table->prepare_items();

                //need to laoad Translator for thibox don't work inside
                if ($this->model->get_option('enable_service')) {
                    //no target language
                    \Falang\Factory\TranslatorFactory::getTranslator($this->model->get_default_locale());
                }

                if ('edit' === $action) {
                    return $this->display_strings_page();
                } else {
                    //default action for edit_language_page
                    $this->handle_strings_actions($action);
                }
                break;
            case 'options' :

                $options_list_table = new  \Falang\Table\FOptions($this->model);
                if ('edit' === $action) {
                    return $this->display_options_page();
                    break;
                }
                //prefilter option by the search
                if (isset($_REQUEST['s']) && $_REQUEST['s']) {
                    $translable_options_list = $this->get_options_to_translate($_REQUEST['s']);
                } else {
                    $translable_options_list = $this->get_options_to_translate();
                }
                $options_list_table->prepare_items($translable_options_list);

                //need to laoad Translator for thibox don't work inside
                if ($this->model->get_option('enable_service')) {
                    //no target language
                    \Falang\Factory\TranslatorFactory::getTranslator($this->model->get_default_locale());
                }

                //default action for option_language_page
                $this->handle_options_actions($action);
                break;
        }


        //display page
        include_once 'views/falang-admin-display.php';
        //$this->display('falang-admin-display');

    }


    /**
     * Manages the user input for the languages pages
     *
     * @param string $action
     */
    public function handle_language_actions($action)
    {
        $falangModel = $this->model;

        switch ($action) {
            case 'add':
                //check_admin_referer( 'add', '_wpnonce_add' );
                $falangModel->add_language($_POST);
                $this->display('views/falang-admin-display.php');
                break;
            case 'delete':
                //TODO the delete/default use the id of the language and not the locale - change this
                //check_admin_referer( 'delete' );
                if (!empty($_GET['language'])) {
                    $falangModel->delete_language(intval($_GET['language']));
                }
                //self::redirect(); // To refresh the page
                break;
            case 'update':
                $falangModel->update_language($_POST);
                break;
            case 'default':
                //TODO the delete/default use the id of the language and not the locale - change this
                check_admin_referer('default');
                $language = $falangModel->get_language(intval($_GET['language']));
                if ($language instanceof \Falang\Core\Language) {
                    $falangModel->update_default_lang($language->locale);
                }
                //self::redirect(); // To refresh the page
                break;

                break;
            case 'publish':
                break;
            case 'unpublish':
                break;

            default:
                break;
        }
    }

    /**
     * Manages the user input for the translations pages
     * @param string $action
     * @since 1.0
     */
    public function handle_translation_actions($action)
    {
        //if ( ! current_user_can('manage_post_translation') ) return;

        $request_action = $this->request_action();

        // save/update translation
        if ($request_action == 'falang_save_post') {
            //check_admin_referer( 'falang_save_pody' );
            $this->save_translation_post();
        }

    }

    /**
     * Manages the user input for the terms pages
     *
     * @param string $action
     */
    public function handle_terms_actions($action)
    {
        //if ( ! current_user_can('manage_terms_translation') ) return;

        $request_action = $this->request_action();

        // save accounts
//		if ( $request_action == 'falang_save_terms' ) {
        //check_admin_referer( 'falang_save_pody' );
        //$this->save_translation_terms();
//		}

//		if ($request_action == 'delete' ) {
//			$this->delete_translation_terms();
//		}

    }

    /**
     * Manages the user input for the translations pages
     *
     * @param string $action
     */
    public function handle_menus_actions($action)
    {
        //if ( ! current_user_can('manage_post_translation') ) return;

        $request_action = $this->request_action();

        // save accounts
        if ($request_action == 'falang_save_menu') {
            //check_admin_referer( 'falang_save_pody' );
            $this->save_translation_menu();
        }

    }

    public function handle_strings_actions($action)
    {
        $request_action = $this->request_action();

        // save string (done directoy by ajax)
        if ($request_action == 'falang_save_string') {
            //check_admin_referer( 'falang_save_pody' );
            //$this->save_translation_string();
        }
        //
        if ($request_action == 'falang_clean_string') {
            $this->clean_translation_string();
        }

    }

    public function handle_options_actions($action)
    {
        $request_action = $this->request_action();

        // save string
        if ($request_action == 'falang_save_options') {
            //check_admin_referer( 'falang_save_pody' );
            //$this->save_translation_string();
        }

    }

    public function ajax_falang_post_delete_translation()
    {

        $response = new stdClass();
        $response->success = true;
        $response->success = $this->post_delete_translation();
        if ($response->success) {
            $response->message = esc_html__('Post translation deleted', 'falang');
        } else {
            $response->message = esc_html__('Post translation not deleted', 'falang');
        }
        $this->return_json($response);
        exit();

    }

    public function post_delete_translation()
    {
        $post_id = empty($_GET['post_id']) ? '' : intval($_GET['post_id']);
        $language_locale = empty($_GET['language']) ? '' : sanitize_html_class($_GET['language']);

        if (wp_verify_nonce($_GET['_wpnonce'], 'delete-post-translation') &&
            !empty($post_id) &&
            !empty($language_locale)
        ) {

            $post_type = get_post_type($post_id);
            //get translatable field
            $falang_post = new \Falang\Core\Post();
            //TODO get the list of all field not only the enabled
            $translated_post_metakeys = $falang_post->get_post_type_option($post_type, 'fields', $falang_post->fields);//TODO remove the $this->fields must be in option
            //add published to the list of $translated_post_metakeys fields
            $translated_post_metakeys[] = 'published';
            foreach ($translated_post_metakeys as $field) {
                delete_post_meta($post_id, Falang_Core::get_prefix($language_locale) . $field);
            }

            return true;
        } else {
            return false;
        }
    }


    /**
     * Manages the user input for the translations pages
     *
     * @param string $action
     */
    public function handle_settings_actions($action)
    {
        //if ( ! current_user_can('manage_post_translation') ) return;

        $request_action = $this->request_action();

        // save accounts
        if ($request_action == 'falang_save_settings') {
            //check_admin_referer( 'falang_save_pody' );
            $this->save_settings();
        }

    }

    /**
     * Save translation post field and meta
     *
     * @since 1.0
     * @update 1.3.3 only non empty are stored / or remove meta key
     * @update 1.3.18 flush permalink if the slug change
     */
    public function save_translation_post()
    {
        $language = $this->get_value_from_post('target_language', '');
        $post_id = $this->get_value_from_post('post_id', '');
        $post = get_post($post_id);
        $falang_post = new \Falang\Core\Post($post_id);
        $fields = $falang_post->get_post_type_option($post->post_type, 'fields', $falang_post->fields);//TODO Fallback pas normal ici on doit utiliser les optiosn
        $post_meta_key = $falang_post->get_post_type_metakeys($post->post_type);
        $need_flush = false;

        //save fields
        foreach ($fields as $field) {
            //alias(postname) and title need to be sanitized
            if ('post_name' == $field) {
                $objlanguage = $this->model->get_language_by_locale($language);//need to use language object for previous
                $previous = $falang_post->get_post_field_translation($post,'post_name',$objlanguage);
                $field_value = $this->sanitize_slug($this->get_value_from_post($field, ''));
                if ($previous != $field_value){$need_flush= true;}
            } else {
                //todo sanitize other field type
                $field_value = $this->get_value_from_post($field, '');
            }
            $meta_key = Falang_Core::get_prefix($language) . $field;
            if (strlen($field_value) > 0) {
                update_post_meta($post_id, $meta_key, $field_value);
            } else {
                delete_post_meta($post_id, $meta_key);
            }
        }

        //save meta
        foreach ($post_meta_key as $post_meta) {
            $field_value = $this->get_value_from_post($post_meta, '');
            $meta_key = Falang_Core::get_prefix($language) . $post_meta;
            if (strlen($field_value) > 0) {
                update_post_meta($post_id, $meta_key, $field_value);
            } else {
                delete_post_meta($post_id, $meta_key);
            }
        }
        //need to flush to be sure if the menu link to page not to have 404
        if ($need_flush){
            $this->model->update_option('need_flush', 1);
        }

        //save published status
        //TODO only if different
        $published = $this->get_value_from_post('published', '') == '1' ? '1' : '0';
        update_post_meta($post_id, Falang_Core::get_prefix($language) . 'published', $published);

        return;

    }


    public function save_translation_menu()
    {
        //save the title of the post
        $this->save_translation_post();
        //save the extra_cpt
        $this->save_extra_custom_post();
    }

    public function ajax_falang_menu_delete_translation()
    {
        $response = new stdClass();
        $response->success = $this->menu_delete_translation();
        if ($response->success) {
            $response->message = esc_html__('Menu translation deleted', 'falang');
        } else {
            $response->message = esc_html__('Menu translation not deleted', 'falang');
        }
        $this->return_json($response);
        exit();
    }

    public function menu_delete_translation()
    {
        $post_id = empty($_GET['post_id']) ? '' : intval($_GET['post_id']);
        $language_locale = empty($_GET['language']) ? '' : sanitize_html_class($_GET['language']);

        if (wp_verify_nonce($_GET['_wpnonce'], 'delete-menu-translation') &&
            !empty($post_id) &&
            !empty($language_locale)
        ) {

            //delete post information

            $post_type = get_post_type($post_id);
            //get translatable field
            $falang_post = new \Falang\Core\Post();
            //TODO get the list of all field not only the enabled
            $translated_post_metakeys = $falang_post->get_post_type_option($post_type, 'fields', $falang_post->fields);//TODO remove the $this->fields must be in option
            //add published to the list of $translated_post_metakeys fields
            $translated_post_metakeys[] = 'published';
            $translated_post_metakeys[] = 'falang_hide';
            $translated_post_metakeys[] = '_menu_item_url';

            foreach ($translated_post_metakeys as $field) {
                delete_post_meta($post_id, Falang_Core::get_prefix($language_locale) . $field);
            }

            return true;
        } else {
            return false;
        }
    }


    /**
     * Ajax route to fetch options
     *
     * @from 1.0
     */
    public function ajax_export_options()
    {
        global $wpdb;

        $option_name = empty($_GET['option_name']) ? '' : sanitize_text_field($_GET['option_name']);

        $options = $wpdb->get_results(
            $wpdb->prepare("SELECT option_name, option_value FROM $wpdb->options WHERE option_name = %s",
                $option_name)
        );

        $unserialized_options = array();

        foreach ($options as $option) {

            $unserialized_options[$option->option_name] = $this->unserialize_deep($option->option_value);

        }

        echo json_encode($unserialized_options);

        die();

    }

    /**
     * Unserialize options. Callback for array_reduce
     *
     * @from 2.3
     */
    public function unserialize_deep($value)
    {

        if ($value) {

            $value = maybe_unserialize($value);

            if (is_array($value)) {

                foreach ($value as $key => $child) {

                    $value[$key] = $this->unserialize_deep($child);

                }

            }

        }

        return $value;
    }

    /**
     * Get option translations for ajax
     *
     * @from 1.0
     */
    public function ajax_get_option_translations()
    {

        echo json_encode($this->get_option_translations());

        wp_die();

    }

    /**
     * get all options translations
     *
     * @from 1.0
     *
     * @return array
     */
    public function get_option_translations()
    {

        $translations = $this->model->get_option('translations', array());

        if (isset($translations['option'])) {

            return $translations['option'];

        }

        return array();

    }

    /**
     * Set option translation for ajax
     *
     * @from 1.5
     * @since 1.3.7 add update message on option translation
     */
    public function ajax_set_option_translation()
    {

        if (isset($_POST['falang_option_translation'])) {

            $option_tree = $this->map_deep($_POST['falang_option_translation'], array($this, 'format_option'));

            $this->update_option_translations($option_tree);

            $response = new stdClass();
            $response->success = 'option updated';
            $response->option = $option_tree;
            $this->return_json($response);

        }

        wp_die();

    }


    /**
     * Save translatable custom post type without admin UI
     *
     * @hook for "save_post_{$post->post_type}"
     * @from 1.0
     */
    public function save_extra_custom_post()
    {
        $post_id = $this->get_value_from_post('post_id', '');
        $post = get_post($post_id);
        $language = $this->get_value_from_post('target_language', '');
        $translate_prefix = Falang_Core::get_prefix($language);
        $falang_post = new \Falang\Core\Post();

        if ((!defined('DOING_AUTOSAVE') || !DOING_AUTOSAVE) && current_user_can('edit_post', $post_id)) {

            if (isset($_POST['falang_extra_cpt_nonce'], $_POST['falang_extra_cpt']) && wp_verify_nonce($_POST['falang_extra_cpt_nonce'], 'falang')) {

                foreach ($_POST['falang_extra_cpt'] as $key => $value) {
                    //save only supported option
                    if (in_array($key, $falang_post->get_post_type_metakeys($post->post_type))) {
                        update_post_meta($post_id, $translate_prefix . $key, $value);
                    }
                }

                if (isset($_POST['_menu_item_classes'])) {
                    update_post_meta($post_id, $translate_prefix . '_menu_item_classes', explode(' ', $_POST['_menu_item_classes']));
                }

            }

        }

    }

    /**
     * Save post-type/taxonomy option page
     *
     * @from 1.0
     * @since 1.3.24 add association // reload option in model after saving
     */
    public function save_settings()
    {
        if (current_user_can('manage_options')) {

            if (isset($_POST['falang_settings_option']) && wp_verify_nonce($_POST['falang_settings_option'], 'falang_action')) {

                $options = get_option($this->model->option_name);

                $falang_post = new \Falang\Core\Post();


                $post_type_options = $falang_post->get_post_types_options();
                $post_type_objs = get_post_types(array(), 'objects');

                foreach ($post_type_objs as $post_type_obj) {

                    if (isset($_POST['post_type']) && in_array($post_type_obj->name, $_POST['post_type'])) {

                        $post_type_options[$post_type_obj->name] = $falang_post->get_post_type_options($post_type_obj->name); // use filter to set default options
                        $post_type_options[$post_type_obj->name]['translatable'] = true;

                    } else if ($falang_post->is_post_type_translatable($post_type_obj->name)) {

                        $post_type_options[$post_type_obj->name]['translatable'] = false;

                    }

                }

                $falang_tax = new \Falang\Core\Taxonomy();

                $taxonomies_options = $falang_tax->get_taxonomies_options();
                $taxonomy_objs = get_taxonomies(array('show_ui' => true), 'objects');

                foreach ($taxonomy_objs as $taxonomy_obj) {

                    //in post taxo need to be use and not taxonomy //PHP Warning:  Illegal offset type in isset or empty in D:\Projet\falangw\www\wp-includes\taxonomy.php on line 289
                    if (isset($_POST['taxo']) && in_array($taxonomy_obj->name, $_POST['taxo'])) {

                        $taxonomies_options[$taxonomy_obj->name] = $falang_tax->get_taxonomy_options($taxonomy_obj->name); // use filter to set default options
                        $taxonomies_options[$taxonomy_obj->name]['translatable'] = true;

                    } else if ($falang_tax->is_taxonomy_translatable($taxonomy_obj->name)) {

                        $taxonomies_options[$taxonomy_obj->name]['translatable'] = false;

                    }

                }

                $options['post_type'] = $post_type_options;
                $options['taxonomy'] = $taxonomies_options;
                $options['show_slug'] = (isset($_POST['show_slug']) && $_POST['show_slug']) ? true : false;
                $options['autodetect'] = (isset($_POST['autodetect']) && $_POST['autodetect']) ? true : false;
                $options['need_flush'] = 1;

                $options['enable_service'] = (isset($_POST['enable_service']) && $_POST['enable_service']) ? true : false;
                $options['service_name'] = (isset($_POST['service_name']) && $_POST['service_name']) ? $_POST['service_name'] : '';
                $options['yandex_key'] = (isset($_POST['yandex_key']) && $_POST['yandex_key']) ? $_POST['yandex_key'] : '';
                $options['azure_key'] = (isset($_POST['azure_key']) && $_POST['azure_key']) ? $_POST['azure_key'] : '';
                $options['lingvanex_key'] = (isset($_POST['lingvanex_key']) && $_POST['lingvanex_key']) ? $_POST['lingvanex_key'] : '';
                $options['google_key'] = (isset($_POST['google_key']) && $_POST['google_key']) ? $_POST['google_key'] : '';

                $options['debug_admin'] = (isset($_POST['debug_admin']) && $_POST['debug_admin']) ? $_POST['debug_admin'] : '';
                $options['delete_trans_on_uninstall'] = (isset($_POST['delete_trans_on_uninstall']) && $_POST['delete_trans_on_uninstall']) ? $_POST['delete_trans_on_uninstall'] : '';

                $options['flag_width'] = (isset($_POST['flag_width']) && $_POST['flag_width']) ? intval($_POST['flag_width']) : intval('16');//default width 16
                $options['flag_height'] = (isset($_POST['flag_height']) && $_POST['flag_height']) ? intval($_POST['flag_height']) : intval('11');//default height 11

                $options['association'] = (isset($_POST['association']) && $_POST['association']) ? true : false;
                $options['downloadid'] = (isset($_POST['downloadid']) && $_POST['downloadid']) ? $_POST['downloadid'] : '';
                $options['frontend_ajax'] = (isset($_POST['frontend_ajax']) && $_POST['frontend_ajax']) ? true : false;

                $options['no_autop'] = (isset($_POST['no_autop']) && $_POST['no_autop']) ? true : false;

                update_option($this->model->option_name, $options);
                //reload in model the option
                $this->get_model()->reload_options();
                return true;
            }

        }

        return false;

    }

    public function save_settings_options()
    {
        if (current_user_can('manage_options')) {

            if (isset($_POST['falang_post_option'], $_POST['post_type']) && wp_verify_nonce($_POST['falang_post_option'], 'falang_action')) {

                $post_type = esc_attr($_POST['post_type']);

                //TODO use model or post or static
                $falang_post = new \Falang\Core\Post();

                if ($falang_post->is_post_type_translatable($post_type)) {

                    $translations = $this->model->get_option('translations', array());

                    // permalinks
                    if (isset($_POST['cpt'])) {

                        $cpt = isset($_POST['cpt']) ? array_map(array(
                            $this,
                            'sanitize_cpt_slug' //use sanitize_cpt_slug to allow /shop/%product_cat%
                        ), $_POST['cpt']) : array();

                        if (!isset($translations['post_type'][$post_type]) || $translations['post_type'][$post_type] !== $cpt) {
                            $translations['post_type'][$post_type] = $cpt;
                            $this->model->update_option('translations', $translations);
                            $this->model->update_option('need_flush', 1);
                        }

                    }

                    // custom post type archive
                    if (isset($_POST['cpt_archive'])) {

                        $cpt_archive = isset($_POST['cpt_archive']) ? array_map(array(
                            $this,
                            'sanitize_slug'
                        ), $_POST['cpt_archive']) : array();

                        if (!isset($translations['cpt_archive'][$post_type]) || $translations['cpt_archive'][$post_type] !== $cpt_archive) {
                            $translations['cpt_archive'][$post_type] = $cpt_archive;
                            $this->model->update_option('translations', $translations);
                            $this->model->update_option('need_flush', 1);
                        }

                    }

                    //Todo put this in options or model
                    $post_types_options = $falang_post->get_post_types_options();

                    // fields
                    $fields = isset($_POST['fields']) ? array_map('esc_attr', $_POST['fields']) : array();
                    $post_types_options[$post_type]['fields'] = $fields;

                    // meta
                    $meta_keys = isset($_POST['meta_keys']) ? array_map('esc_attr', $_POST['meta_keys']) : array();
                    $post_types_options[$post_type]['meta_keys'] = $meta_keys;

                    // advanced options
                    $exclude_untranslated = isset($_POST['exclude_untranslated']) && $_POST['exclude_untranslated'];
                    $post_types_options[$post_type]['exclude_untranslated'] = $exclude_untranslated;

                    // @from 1.0 Revision
                    if (isset($_POST['enable_revisions']) && $_POST['enable_revisions']) {
                        $post_types_options[$post_type]['enable_revisions'] = 1;
                    } else {
                        unset($post_types_options[$post_type]['enable_revisions']);
                    }

                    $this->model->update_option('post_type', $post_types_options);

                }

                return true;

            } else if (isset($_POST['falang_taxonomy_option'], $_POST['taxonomy']) && wp_verify_nonce($_POST['falang_taxonomy_option'], 'falang_action')) {

                $taxonomy = esc_attr($_POST['taxonomy']);
                $Taxonomy = new \Falang\Core\Taxonomy();

                if ($Taxonomy->is_taxonomy_translatable($taxonomy)) {

                    // permalinks
                    if (isset($_POST['tax'])) {

                        $translations = $this->model->get_option('translations', array());
                        $tax = isset($_POST['tax']) ? array_map(array(
                            $this,
                            'sanitize_slug'
                        ), $_POST['tax']) : array();

                        if (!isset($translations['taxonomy'][$taxonomy]) || $translations['taxonomy'][$taxonomy] !== $tax) {
                            $translations['taxonomy'][$taxonomy] = $tax;
                            $this->model->update_option('translations', $translations);
                            $this->model->update_option('need_flush', 1);
                        }

                        $this->model->update_option('translations', $translations);

                    }

                    $taxonomies_options = $Taxonomy->get_taxonomies_options();

                    // fields
                    $fields = isset($_POST['fields']) ? array_map('esc_attr', $_POST['fields']) : array();
                    $taxonomies_options[$taxonomy]['fields'] = $fields;

                    // meta
                    $meta_keys = isset($_POST['meta_keys']) ? array_map('esc_attr', $_POST['meta_keys']) : array();
                    $taxonomies_options[$taxonomy]['meta_keys'] = $meta_keys;

                    $this->model->update_option('taxonomy', $taxonomies_options);

                }

                return true;

            }
        }

        return false;
    }

    /**
     * Sanitize slug
     *
     * @from 1.0
     */
    public function sanitize_slug($slug)
    {

        return sanitize_title($slug);

    }

    /**
     * Sanitize cpt slug
     * for some cpt the slug need to be like /shop/%product_cat%
     *
     * @from 1.3.12 use 'sanitize_text_field' instead of 'sanitize_title'
     */
    public function sanitize_cpt_slug($slug)
    {

        return sanitize_text_field($slug);

    }

    /**
     * Sanitize slug
     *
     * since 1.2.4 : allow translation for non term set as translatable
     * @since 1.3.32 add meta term translation
     * @from 1.0
     */
    public function save_term_translation()
    {

        $taxonomy = empty($_POST['taxonomy']) ? '' : $_POST['taxonomy'];
        $falang_taxonomy = new \Falang\Core\Taxonomy();

        if (isset($_POST['falang_term_nonce'])
            && wp_verify_nonce($_POST['falang_term_nonce'], 'falang_action')
        ) {

            $context = empty($_POST['context']) ? '' : $_POST['context'];
            $term_id = empty($_POST['term_id']) ? '' : $_POST['term_id'];
            $language_locale = empty($_POST['target_language']) ? '' : $_POST['target_language'];
            $published = $this->get_value_from_post('published', '') == '1' ? '1' : '0';

            //get translatable field
            $taxonomy_fields = $falang_taxonomy->get_taxonomy_fields($taxonomy);

            //update published
            $this->update_term_translation($term_id, array('published' => $published), $language_locale);

            //translate field
            foreach ($taxonomy_fields as $field) {
                $this->update_term_translation($term_id, array($field => $_POST[$field]), $language_locale);
            }

            $taxonomy_meta_fields = $falang_taxonomy->get_taxonomy_metakeys($taxonomy);
            //translate meta fiedl
            foreach ($taxonomy_meta_fields as $meta_field) {
                $this->update_term_translation($term_id, array($meta_field => $_POST[$meta_field]), $language_locale);
            }


            //TODO delete non translatable field in case already in database
        }

        return true;

    }

    /**
     * Saves the strings translations in DB
     * Optionaly clean the DB
     *
     * @since 0.9
     */
    public function save_string_translation()
    {
        $row = empty($_POST['row']) ? '' : sanitize_text_field($_POST['row']);
        $translation = empty($_POST['translation']) ? '' : $_POST['translation'];
        $orginal_value = empty($_POST['fake_original_value']) ? '' : wp_unslash(trim($_POST['fake_original_value']));
        $language_locale = empty($_POST['target_language']) ? '' : sanitize_html_class($_POST['target_language']);
        $context = empty($_POST['context']) ? '' : sanitize_text_field($_POST['context']);

        $language = $this->model->get_language_by_locale($language_locale);

        $falang_mo = new Falang_Mo();
        $falang_mo->import_from_db($language);


        /**
         * Filter the string translation before it is saved in DB
         * Allows to sanitize strings registered with falang_register_string
         *
         * @param string $translation the string translation
         * @param string $name the name as defined in falang_register_string
         * @param string $context the context as defined in falang_register_string
         * @since 1.3.2
         *
         */

        $translation = apply_filters('falang_sanitize_string_translation', $translation, $orginal_value);
        $falang_mo->add_entry($falang_mo->make_entry($orginal_value, $translation));


        isset($new_mo) ? $new_mo->export_to_db($language) : $falang_mo->export_to_db($language);


        add_settings_error('general', 'falang_strings_translations_updated', __('Translations updated', 'falang'), 'updated');


        /**
         * Fires after the strings translations are saved in DB
         *
         * @since 1.2
         */
        do_action('falang_save_strings_translations');

        return true;
    }

    /**
     * Clean the strings translations in DB
     * Optionaly clean the DB
     *
     * @since 1.3.13
     */
    public function clean_translation_string()
    {
        // Clean database ( removes all strings which were registered some day but are no more )
        if (!empty($_POST['clean'])) {
            foreach ( $this->model->get_languages_list(array('hide_default' => true)) as $language ) {

                $falang_mo = new Falang_Mo();
                $falang_mo->import_from_db($language);

                $new_mo = new Falang_Mo();
                $strings = FString::get_strings();

                foreach ($strings as $string) {
                    $new_mo->add_entry($falang_mo->make_entry($string['string'], $falang_mo->translate($string['string'])));
                }
                isset($new_mo) ? $new_mo->export_to_db($language) : $falang_mo->export_to_db($language);
            }

        }
        return true;

    }

    public function save_option_translation()
    {
        $option_name = empty($_POST['name']) ? '' : sanitize_text_field($_POST['name']);;
        $transation = empty($_POST['translation']) ? '' : sanitize_textarea_field($_POST['translation']);;
        $language_locale = empty($_POST['target_language']) ? '' : sanitize_html_class($_POST['target_language']);

        //case multiple
        if (isset($_POST['falang_option_translation'])) {

            $option_tree = $this->map_deep($_POST['falang_option_translation'], array($this, 'format_option'));

            //simple
        } else {
            $option_tree = array($language_locale => array($option_name => $transation));

        }

        $this->update_option_translations($option_tree);

        return true;


    }

    /**
     * Delete option translations
     *
     * @from 1.3.13
     *
     * @return array
     */
    public function delete_option_translation(){
        $language_locale = empty($_GET['language']) ? '' : sanitize_html_class($_GET['language']);
        $option_name = empty($_GET['name']) ? '' : sanitize_html_class($_GET['name']);

        $option_tree = array($language_locale => array($option_name));

        $result = $this->delete_option_translations($option_tree);

        return $result;
    }



    /**
     * Update option translations
     *
     * @from 1.0
     *
     * @return array
     */
    private function update_option_translations($option_tree)
    {

        $translations = $this->model->get_option('translations', array());

        if (empty($translations['option'])) {

            $translations['option'] = array();

        }

        $translations['option'] = array_replace_recursive($translations['option'], $option_tree); // only PHP 5.3 !

        // clean array
        $translations['option'] = $this->clean_translations($translations['option']);

        $this->model->update_option('translations', $translations);

    }

    /**
     * delete option translations
     *
     * @from 1.3.13
     *
     * @return bool
     */
    private function delete_option_translations($option_tree)
    {
        $found = false;
        $translations = $this->model->get_option('translations', array());

        if (empty($translations['option'])) {

            $translations['option'] = array();

        }
        //$key is the language locale
        foreach ($option_tree as $key => $name){
            $key_name = $name[0];
            if (isset($translations['option'][$key]) && isset($translations['option'][$key][$key_name])) {
                unset($translations['option'][$key][$key_name]);
                $found = true;
            }
        }
        if ($found){
            // clean array
            $translations['option'] = $this->clean_translations($translations['option']);

            $this->model->update_option('translations', $translations);
        }

        return $found;
    }

    /**
     * Clean array deep. Callback for array_reduce
     *
     * @from 1.0
     */
    private function clean_translations($node)
    {

        if (is_array($node)) {

            $clean_node = array();

            foreach ($node as $key => $child) {

                $child = $this->clean_translations($child);

                if ($child !== '' && !(is_array($child) && !$child)) {

                    $clean_node[$key] = $child;

                }

            }

            return $clean_node;
        }

        return $node;
    }

    /**
     * Format option
     *
     * @from 1.5.3 add stripslashes
     * @from 1.5.2 remove default html escaping
     * @from 1.5
     */
    public function format_option($value)
    {

        $value = stripslashes(trim($value));

        switch ($value) {

            case 'false':
                return false;

            case 'true':
                return true;

        }

        return $value;
    }

    /**
     * Map deep. Copied from wp-includes/formatting.php
     *
     * @from 1.5
     */
    private function map_deep($value, $callback)
    {
        if (is_array($value) || is_object($value)) {
            foreach ($value as &$item) {
                $item = $this->map_deep($item, $callback);
            }
            return $value;
        } else {
            return call_user_func($callback, $value);
        }
    }


    public function ajax_falang_term_delete_translation()
    {

        $response = new stdClass();
        $response->success = true;
        $response->success = $this->term_delete_translation();
        if ($response->success) {
            $response->message = esc_html__('Term translation deleted', 'falang');
        } else {
            $response->message = esc_html__('Term translation not deleted', 'falang');
        }
        $this->return_json($response);
        exit();

    }

    /*
     * Delete term translation
     * @since 1.3.32 delete meta term translation
     * */
    public function term_delete_translation()
    {
        $taxonomy = empty($_GET['taxonomy']) ? '' : sanitize_key($_GET['taxonomy']);
        $term_id = empty($_GET['term_id']) ? '' : sanitize_key($_GET['term_id']);
        $language_locale = empty($_GET['language']) ? '' : sanitize_html_class($_GET['language']);

        if (wp_verify_nonce($_GET['_wpnonce'], 'delete-term-translation') &&
            !empty($taxonomy) &&
            !empty($term_id) &&
            !empty($language_locale)
        ) {

            //get translatable field
            $falang_taxonomy = new \Falang\Core\Taxonomy();
            //TODO get the list of all field not only the enabled
            $taxonomy_fields = $falang_taxonomy->get_taxonomy_fields($taxonomy);
            //add published to the list of $taxonomy fields
            $taxonomy_fields[] = 'published';
            foreach ($taxonomy_fields as $field) {
                delete_term_meta($term_id, Falang_Core::get_prefix($language_locale) . $field);
            }

            $taxonomy_meta_fields = $falang_taxonomy->get_taxonomy_metakeys($taxonomy);
            foreach ($taxonomy_meta_fields as $meta_field) {
                delete_term_meta($term_id, Falang_Core::get_prefix($language_locale) . $meta_field);
            }

            return true;
        } else {
            return false;
        }

    }

    /**
     * Update term translation
     *
     * @param int $term_id Term ID
     * @param array $data {
     *                        List of field to save.
     * @string $name Name
     * @string $slug Slug
     * @string $description Description
     * @string $custom_meta_key Post meta
     *                        }
     * @param object $locale Language.
     *
     * @from 1.0
     */
    public function update_term_translation($term_id, $data, $locale)
    {

//		if (empty($language)) {
//
//			$language = $this->get_language();
//
//		}

//		if ($this->is_sub($language)) {

        foreach ($data as $field => $value) {

            if ($field === 'slug') {

                $value = $this->sanitize_slug($value);

            }


            /**
             * Filter before a term translation field is updated.
             *
             * @param int $post_id . Original post id.
             * @param string $field . Field name.
             * @param string $value . Value.
             *
             * @from 2.0
             */
            update_term_meta($term_id, Falang_Core::get_prefix($locale) . $field, apply_filters('falang_admin_update_term', $value, $term_id, $field));


        }

//		}

    }

    /**
     * Display the ajax string translation popup
     */
    public function ajax_falang_string_translation()
    {
        //TODO throw error if no context
        $row = empty($_GET['row']) ? '' : sanitize_key($_GET['row']);
        $language = empty($_GET['language']) ? '' : sanitize_html_class($_GET['language']); //locale

        $aData = array(
            'form_action' => 'admin.php?page=falang-strings',
            'cancel_action' => 'admin.php?page=falang-strings',
            'row' => $row,
            'target_language_locale' => $language,
        );
        $this->display('falang_string_translation_page', $aData);
        wp_die();
    }

    /**
     * Delete ajax string translation
     */
    public function ajax_falang_string_delete_translation()
    {

        $response = new stdClass();
        $response->success = true;
        $response->success = $this->string_delete_translation();
        if ($response->success) {
            $response->message = esc_html__('String translation deleted', 'falang');
        } else {
            $response->message = esc_html__('String translation not deleted', 'falang');
        }
        $this->return_json($response);
        exit();

    }

    public function string_delete_translation()
    {
        $row = empty($_GET['row']) ? '' : sanitize_key($_GET['row']);
        $locale = empty($_GET['language']) ? '' : sanitize_html_class($_GET['language']); //locale

        if (wp_verify_nonce($_GET['_wpnonce']) &&
            !empty($row) &&
            !empty($locale)
        ) {
            $language = $this->model->get_language_by_locale($locale);

            $falang_mo = new Falang_Mo();
            $falang_mo->import_from_db($language);

            $new_mo = new Falang_Mo();

            $strings = FString::get_strings();

            foreach ($strings as $key => $string) {
                if ($row != $key) {
                    $new_mo->add_entry($falang_mo->make_entry($string['string'], $falang_mo->translate($string['string'])));
                }
            }

            $new_mo->export_to_db($language);

            return true;

        }
        return false;

    }

    /**
     * Display the ajax option translation popup
     */
    public function ajax_falang_option_translation()
    {
        $name = empty($_GET['name']) ? '' : sanitize_key($_GET['name']);
        $language = empty($_GET['language']) ? '' : sanitize_html_class($_GET['language']); //locale

        $aData = array(
            'form_action' => 'admin.php?page=falang-options',
            'cancel_action' => 'admin.php?page=falang-options',
            'name' => $name,
            'target_language_locale' => $language,
        );
        $this->display('falang_option_translation_page', $aData);
        wp_die();
    }


    public function display_edit_language_page($edit_lang_id = null)
    {
        $falangModel = new \Falang\Model\Falang_Model();

        $aData = array(
            'form_action' => 'admin.php?page=falang-language',
            'cancel_action' => 'admin.php?page=falang-language&action=cancel',
            'predefined_language_list' => $falangModel->get_predefined_languages(),
            'flag_list' => $falangModel->get_flags_list()
        );

        if (!empty($edit_lang_id)) {

            $language = $falangModel->get_language((int)$edit_lang_id);
            //add language to the data on edit
            $aData['language'] = $language;
            $aData['delete_action'] = 'admin.php?page=falang-language&action=delete&language=' . $edit_lang_id;
        }
        if (empty($edit_lang_id)){
            $max_order = sizeof($this->model->get_languages_list());
            $aData['next_order'] = $max_order+1;
        }

        $this->display('language_edit_page', $aData);
    }

    /*
	 * since 1.3.3 add $post_id and $local parameter
	 * */
    public function display_edit_post_page($post_id, $locale)
    {
//		$post_id                = intval($_GET['post_id']);
        $post = get_post($post_id);
//		$target_language_locale = sanitize_html_class($_GET['language']);//local in the url
        $falang_post = new \Falang\Core\Post($post_id);
        $translated_metakeys = $falang_post->get_post_type_metakeys($post->post_type);

        $page = 'falang-translation';
        if (isset($_REQUEST['paged'])) $page .= '&paged=' . falang_clean($_REQUEST['paged']);
        if (isset($_REQUEST['s'])) $page .= '&s=' . urlencode(falang_clean($_REQUEST['s']));
        if (isset($_REQUEST['pt-filter'])) $page .= '&pt-filter=' . falang_clean($_REQUEST['pt-filter']);

        $aData = array(
            'form_action' => 'admin.php?page=' . $page,
            'cancel_action' => 'admin.php?page=' . $page,
            'target_language_locale' => $locale,
            'original_post_id' => $post_id,
            'post' => $falang_post,
            'translated_metakeys' => $translated_metakeys
        );

        $this->display('edit_post_page', $aData);
    }

    public function display_edit_menu_page()
    {
        $post_id = intval($_GET['post_id']);
        $post = get_post($post_id);
        $target_language_locale = sanitize_html_class($_GET['language']);//local in the url
        $falang_post = new \Falang\Core\Post($post_id);
        $translated_metakeys = $falang_post->get_post_type_option($post->post_type, 'fields', $falang_post->fields);//TODO remove the $this->fields must be in option

        $page = 'falang-menus';
        if (isset($_REQUEST['paged'])) $page .= '&paged=' . falang_clean($_REQUEST['paged']);
        if (isset($_REQUEST['s'])) $page .= '&s=' . urlencode(falang_clean($_REQUEST['s']));

        $aData = array(
            'form_action' => 'admin.php?page=' . $page,
            'cancel_action' => 'admin.php?page=' . $page,
            'target_language_locale' => $target_language_locale,
            'original_post_id' => $post_id,
            'post' => $falang_post
        );

        $this->display('edit_menu_page', $aData);
    }


    public function display_settings_page()
    {
        $aData = array(
            'form_action' => 'admin.php?page=falang-settings',
            'version' => $this->get_version(),
        );
        $this->display('settings_page', $aData);
    }

    public function display_strings_page()
    {
        $aData = array(
            'form_action' => 'admin.php?page=falang-strings'
        );
        $this->display('strings_page', $aData);
    }

    public function display_options_page()
    {
        $aData = array(
            'form_action' => 'admin.php?page=falang-options'
        );
        $this->display('options_page', $aData);
    }

    // display view
    //TODO put in parent class
    public function display($insView, $inaData = array(), $echo = true)
    {
        $sFile = FALANG_ADMIN . '/views/' . $insView . '.php';
        if (!is_file($sFile)) {
            //display message
            return false;
        }

        if (count($inaData) > 0) {
            extract($inaData, EXTR_PREFIX_ALL, 'falang');
        }


        include_once $sFile;

//		ob_start();
//			include( $sFile );
//			$sContents = ob_get_contents();
//		ob_end_clean();
//
//		if ($echo) {
//			echo $sContents;
//			return true;
//		} else {
//			return $sContents;
//		}

    }

    /**
     * Re-register translatable custom post without admin UI
     *
     * @hook 'init'
     * @from 1.5
     */

//	//TODO not used yet
//	public function register_extra_post() {
//
//		$cpts = get_post_types( array(
//			'show_ui' => false
//		), 'objects' );
//
//		foreach ( $cpts as $cpt ) {
//
//			if ( $this->model->is_post_type_translatable( $cpt->name ) ) {
//			}
//		}
//	}

    //ajax show post settings options
    public function ajax_settings_post_options()
    {

        $falang_post = new \Falang\Core\Post();

        $post_type = empty($_GET['post_type']) ? 'post' : sanitize_key($_GET['post_type']);
        $post_type_obj = get_post_type_object($post_type);
        $meta_keys = $falang_post->query_post_type_metakeys($post_type);
        $registered_meta_keys = get_registered_meta_keys('posts');

        //if ( ! current_user_can('manage_falang_options') ) return;
        $aData = array(
            'form_action' => 'admin.php?page=falang-settings',
            'post_type' => $post_type,
            'post_type_obj' => $post_type_obj,
            'meta_keys' => $meta_keys,
            'registered_meta_keys' => $registered_meta_keys
        );
        $this->display('settings_post_option_page', $aData);
        exit();
    }

    public function ajax_settings_taxonmy_options()
    {
        if (isset($_GET['taxonomy'])) {
            $falang_taxonomy = new Falang\Core\Taxonomy();

            $taxonomy = sanitize_key($_GET['taxonomy']);
            $taxonomy_obj = get_taxonomy($taxonomy);
            $meta_keys = $falang_taxonomy->query_taxonomy_metakeys($taxonomy);
            $registered_meta_keys = get_registered_meta_keys('term');


            $aData = array(
                'form_action' => 'admin.php?page=falang-settings',
                'taxonomy' => $taxonomy,
                'taxonomy_obj' => $taxonomy_obj,
                'meta_keys' => $meta_keys,
                'registered_meta_keys' => $registered_meta_keys
            );
            $this->display('settings_taxonomy_option_page', $aData);
            exit();
        }

    }

    /**
     * Display the ajax term translation popup
     * @since 1.3.32 add metafields
     */
    public function ajax_falang_term_translation()
    {
        //TODO throw error if no context
        $context = empty($_GET['context']) ? '' : sanitize_key($_GET['context']);
        $taxonomy = empty($_GET['taxonomy']) ? '' : sanitize_key($_GET['taxonomy']);

        $id = empty($_GET['id']) ? '' : intval($_GET['id']);
        $language = empty($_GET['language']) ? '' : sanitize_html_class($_GET['language']); //locale
        $falang_taxonomy = new \Falang\Core\Taxonomy();

        $taxonomy_fields = $falang_taxonomy->get_taxonomy_fields($taxonomy);
        $taxonomy_meta_fields = $falang_taxonomy->get_taxonomy_metakeys($taxonomy);

        $aData = array(
            'form_action' => 'admin.php?page=falang-terms',
            'cancel_action' => 'admin.php?page=falang-terms',
            'context' => $context,
            'taxonomy' => $taxonomy,
            'id' => $id,
            'target_language_locale' => $language,
            'taxonomy_fields' => $taxonomy_fields,
            'taxonomy_meta_fields' => $taxonomy_meta_fields,
        );
        $this->display('falang_term_translation_page', $aData);
        wp_die();
    }

    //ajax update post options
    public function ajax_update_settings_post_options()
    {
        // build response
        $response = new stdClass();
        $response->success = $this->save_settings_options();
        $this->return_json($response);
        exit();

    }

    public function return_json($data)
    {
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function ajax_update_settings_taxonomy_options()
    {
        // build response
        $response = new stdClass();
        $response->success = $this->save_settings_options();
        $this->return_json($response);
        exit();
    }


    public function ajax_update_term_translation()
    {
        // build response
        $response = new stdClass();
        $response->success = $this->save_term_translation();
        $this->return_json($response);
        exit();
    }

    public function ajax_update_string_translation()
    {
        // build response
        $response = new stdClass();
        $response->success = $this->save_string_translation();
        $this->return_json($response);
        exit();
    }

    public function ajax_update_option_translation()
    {
        // build response
        $response = new stdClass();
        $response->success = $this->save_option_translation();
        $this->return_json($response);
        exit();
    }

    public function ajax_delete_option_translation()
    {
        $response = new stdClass();
        $response->success = $this->delete_option_translation();
        $this->return_json($response);
        exit();
    }

    /**
     * set post_type translatable by default
     *
     * @filter "falang_default-$post_type"
     * @from 1.0
     */
    public function set_post_type_translatable($defaults)
    {

        $defaults['translatable'] = true;

        return $defaults;
    }


    /**
     * Flush rewrite rules
     *
     * @hook 'wp_loaded'
     * @from 1.0
     */
    public function flush_rewrite_rules()
    {

        if ($this->model->get_option('need_flush')) {

            $this->disable_translate_home_url = true;

            flush_rewrite_rules();

            $this->disable_translate_home_url = false;

        }

    }


    /**
     * Remove 'need_flush' flag after flush
     *
     * @hook for 'generate_rewrite_rules'
     * @from 1.0
     */
    public function generate_rewrite_rules($wp_rewrite)
    {

        $this->model->update_option('need_flush', 0);

    }

    /**
     * Flush after creating a root page
     *
     * @hook for 'generate_rewrite_rules'
     * @from 1.2.1
     */
    public function save_page($post_ID, $post, $update)
    {

        if (!$update && $post->post_parent === 0) {

            $this->model->update_option('need_flush', 1);

        }

    }

    /**
     * Flush after editing a root page
     *
     * @hook for 'post_updated'
     * @from 1.2.1
     */
    public function update_page($post_ID, $post_after, $post_before)
    {

        if (($post_after->post_type === 'page' || $post_before->post_type === 'page') && $post_after->post_name !== $post_before->post_name && ($post_after->post_parent === 0 || $post_before->post_parent === 0) && ($post_after->post_status === 'publish' || $post_before->post_status === 'publish')) {

            $this->model->update_option('need_flush', 1);

        }

    }


    /**
     * set default nav_menu_item options
     *
     * @filter "falang_default-$post_type"
     * @from 1.0
     */
    public function nav_menu_item_default_options($defaults)
    {

        $defaults['meta_keys'] = array('falang_hide', '_menu_item_url');

        return $defaults;
    }


    /**
     * Force 'falang_hide' to appear in meta_keys list
     *
     * @filter "falang_post_type_metakeys"
     * @from 1.0
     */
    public function nav_menu_item_metakeys($value, $post_type)
    {

        if ($post_type === 'nav_menu_item' && empty($value['falang_hide'])) {

            $value['falang_hide'] = true;

        }

        return $value;
    }

    public function widgets_init()
    {

    }

    /**
     * Modifies the widgets forms to add our language dropdown list
     *
     * @param object $widget Widget instance
     * @param null $return Not used
     * @param array $instance Widget settings
     * @since 1.2
     *
     */
    public function in_widget_form($widget, $return, $instance)
    {
        $screen = get_current_screen();
        // Test the Widgets screen and the Customizer to avoid displaying the option in page builders
        // Saving the widget reloads the form. And curiously the action is in $_REQUEST but neither in $_POST, nor in $_GET.
        if ((isset($screen) && 'widgets' === $screen->base) || (isset($_REQUEST['action']) && 'save-widget' === $_REQUEST['action']) || isset($GLOBALS['wp_customize'])) { // phpcs:ignore WordPress.Security.NonceVerification
            $dropdown = new Walker_Dropdown();

            $dropdown_html = $dropdown->walk(
                array_merge(
                    array((object)array('locale' => 0, 'name' => __('All languages', 'falang'))),
                    $this->model->get_languages_list()
                ),
                -1,
                array(
                    'name' => $widget->id . '_lang_choice',
                    'class' => 'tags-input falang-lang-choice',
                    'selected' => empty($instance['falang_lang']) ? '' : $instance['falang_lang'],
                )
            );

            printf(
                '<p><label for="%1$s">%2$s %3$s</label></p>',
                esc_attr($widget->id . '_lang_choice'),
                esc_html__('The widget is displayed for:', 'falang'),
                $dropdown_html // phpcs:ignore WordPress.Security.EscapeOutput
            );

            //display language on widget top
            if (!empty($instance['falang_lang']) && isset($widget->widget_options['classname'])) {

            }
        }
    }

    /**
     * Called when widget options are saved
     * saves the language associated to the widget
     *
     * @param array $instance Widget options
     * @param array $new_instance Not used
     * @param array $old_instance Not used
     * @param object $widget WP_Widget object
     * @return array Widget options
     * @since 1.2
     *
     */
    public function widget_update_callback($instance, $new_instance, $old_instance, $widget)
    {
        $key = $widget->id . '_lang_choice';

        if (!empty($_POST[$key]) && $lang = $this->model->get_language_by_locale(sanitize_text_field($_POST[$key]))) { // phpcs:ignore WordPress.Security.NonceVerification
            $instance['falang_lang'] = $lang->locale;
        } else {
            unset($instance['falang_lang']);
        }

        return $instance;
    }

    /**
     * Plugin row meta.
     *
     * Adds row meta links to the plugin list table
     *
     * Fired by `plugin_row_meta` filter.
     *
     * @param array $plugin_meta An array of the plugin's metadata, including
     *                            the version, author, author URI, and plugin URI.
     * @param string $plugin_file Path to the plugin file, relative to the plugins
     *                            directory.
     *
     * @return array An array of plugin row meta links.
     * @since 1.2
     * @access public
     *
     */
    public function plugin_row_meta($plugin_meta, $plugin_file)
    {

        if (FALANG_BASENAME === $plugin_file) {
            $row_meta = [
                'docs' => '<a href="https://www.faboba.com/falangw/documentation/" aria-label="' . esc_attr(__('View Falang documentation', 'falang')) . '" target="_blank">' . __('Docs & FAQs', 'falang') . '</a>'
            ];

            $plugin_meta = array_merge($plugin_meta, $row_meta);
        }

        return $plugin_meta;
    }
    /*
	 * Get the list of the term to be translated
	 * $args taxonomies filter
	 * */
    //TODO not working yet.
    public function get_terms_to_translate($args = array())
    {
        $items = array();
        remove_filter('get_term', '');

        foreach ((array)get_taxonomies(array(), 'objects') as $taxonomy) {
            $tax_labels = get_taxonomy_labels($taxonomy);
            $terms = get_terms(array(
                'taxonomy' => $taxonomy->name,
                'orderby' => 'slug',
                'hide_empty' => false,
            ));

            foreach ((array)$terms as $term) {
                $name = sprintf('%s:%d', $taxonomy->name, $term->term_id);
                $items[] = array(
                    'id' => $term->term_id,
                    'name' => $name,
                    'original' => $term->name,
//					'translated' => bogo_translate( $name, $taxonomy->name,
//						$term->name ),
                    'context' => $tax_labels->name,
                    'taxonomy' => $term->taxonomy,
                );
            }
        }

        //add_filter( 'get_term', 'falang_get_term_filter', 10, 2 );

        //$items = apply_filters( 'bogo_terms_translation', $items, $locale );
        //TODO put this before with stdclass
        //convert array to object
        $items = json_decode(json_encode($items), false);

        return $items;

    }

    public function get_options_to_translate($filter = null)
    {
        global $wpdb;

        $sql_blacklist = "option_name NOT IN ('" . implode("', '", array_map('esc_sql', $this->get_options_blacklist())) . "')";

        //TODO not nice filter
        if (empty($filter)) {
            $options = $wpdb->get_results("
				SELECT option_name as name, option_value as value
				FROM $wpdb->options
				WHERE option_name NOT LIKE '_transient%' AND option_name NOT LIKE '_site_transient%' AND option_name NOT LIKE '_wp_session%' AND $sql_blacklist 
				ORDER BY option_name"
            );
        } else {
            $options = $wpdb->get_results("
			SELECT option_name as name, option_value as value
			FROM $wpdb->options
			WHERE option_name NOT LIKE '_transient%' AND option_name NOT LIKE '_site_transient%' AND option_name NOT LIKE '_wp_session%'  AND option_name like '%" . $filter . "%' AND  $sql_blacklist 
			ORDER BY option_name"
            );
        }
        return $options;

    }

    /*
	 * List of options that should not be translated
	 *
	 * @from 1.0
	 */
    private function get_options_blacklist()
    {

        return apply_filters('falang_options_blacklist', array(
            'falang',
            'active_plugins',
            'admin_email',
            'auto_core_update_notified',
            'avatar_default',
            'avatar_rating',
            'blacklist_keys',
            'blog_charset',
            'blog_public',
            'can_compress_scripts',
            'category_base',
            'close_comments_days_old',
            'close_comments_for_old_posts',
            'comment_max_links',
            'comment_moderation',
            'comment_order',
            'comment_registration',
            'comment_whitelist',
            'comments_notify',
            'comments_per_page',
            'cron',
            'db_upgraded',
            'db_version',
            'default_category',
            'default_comment_status',
            'default_comments_page',
            'default_email_category',
            'default_link_category',
            'default_ping_status',
            'default_pingback_flag',
            'default_post_format',
            'default_role',
            'finished_splitting_shared_terms',
            'gmt_offset',
            'hack_file',
            'home',
            'html_type',
            'image_default_align',
            'image_default_link_type',
            'image_default_size',
            'initial_db_version',
            'large_size_h',
            'large_size_w',
            'link_manager_enabled',
            'links_updated_date_format',
            'mailserver_login',
            'mailserver_pass',
            'mailserver_port',
            'mailserver_url',
            'medium_large_size_h',
            'medium_large_size_w',
            'medium_size_h',
            'medium_size_w',
            'moderation_keys',
            'moderation_notify',
            'nav_menu_options',
            'page_comments',
            //'page_for_posts', need to be translatable TODO via option
            //'page_on_front', need to be translatable TODO via option
            'permalink_structure',
            'ping_sites',
            'posts_per_page',
            'posts_per_rss',
            'recently_activated',
            'recently_edited',
            'require_name_email',
            'rewrite_rules',
            'rss_use_excerpt',
            'show_avatars',
            'show_on_front',
            'sidebars_widgets',
            'site_icon',
            'siteurl',
            'start_of_week',
            'sticky_posts',
            'stylesheet',
            'falang_options',
            'falang_translations',
            'tag_base',
            'template',
            'theme_mods_twentyfifteen',
            'thread_comments',
            'thread_comments_depth',
            'thumbnail_crop',
            'thumbnail_size_h',
            'thumbnail_size_w',
            'timezone_string',
            'uninstall_plugins',
            'upload_path',
            'upload_url_path',
            'uploads_use_yearmonth_folders',
            'use_balanceTags',
            'use_smilies',
            'use_trackback',
            'users_can_register',
            'wp_user_roles',
            'WPLANG'
        ));
    }

    /**
     * Setup filters for admin pages
     *
     * @since 1.2.1
     */
    public function add_filters()
    {
        $classes = array('Classic_Editor', 'Filters_Columns', 'Filters_WC_Columns', 'Nav_Menu', 'User_Profile', 'Attachment');

        foreach ($classes as $class) {
            $obj = strtolower($class);
            /**
             * Filter the class to instantiate when loading admin filters
             *
             * @param string $class class name
             * @since 1.2.1
             *
             */
            $class = apply_filters('falang_' . $obj, $class);
            $class = '\Falang\Filter\Admin\\' . $class;
            $this->$obj = new $class($this);
        }

        //WooCommerce Framework
        if (in_array('woocommerce/woocommerce.php',apply_filters( 'active_plugins', get_option( 'active_plugins' )))) {
            $this->woocommerce = new \Falang\Filter\Admin\WooCommerce();
        }


    }


    /* Posts UI
	----------------------------------------------- */

    /**
     * Fire filters on post.php
     *
     * Hook for 'load-post.php'
     *
     * @from 1.2.3
     */
    public function admin_post_page()
    {

        $current_screen = get_current_screen();
        $falang_post = new \Falang\Core\Post();

        if ($this->model->get_languages_list() && isset($current_screen->post_type) && $falang_post->is_post_type_translatable($current_screen->post_type)) {

            // allow translate home url
            add_filter('home_url', array($this, 'translate_home_url'), 10, 4);

        }

    }

    /**
     * Translate post slug
     * ex: translate %product-slug% in the permalink for woocommerce
     *
     * @filter 'get_sample_permalink'
     * @from 1.2.3
     * @fix 1.3.3 post_type translation for post set to a specific languge
     * @fix 1.3.24 add language to translate_post_field
     */
    public function translate_sample_permalink($permalink, $post_id, $title, $name, $post)
    {
        $falang_post = new \Falang\Core\Post($post_id);
        if ($falang_post->is_post_type_translatable($post->post_type)) {

            //post set to a specific language not "all language"
            $post_locale = $falang_post->get_post_locale();
            //todo have a method for == all to know a post is an oll language configuration
            $post_language = $post_locale == 'all' ? $this->model->get_default_language() : $this->model->get_language_by_locale($post_locale);

            $translation = $falang_post->translate_cpt($post->post_type, $post_language, $post->post_type);
            $permalink[0] = str_replace("%{$post->post_type}-slug%", $translation, $permalink[0]);

            if ($post_locale != 'all' && $post_locale != $this->model->get_default_locale()) {
//			if (!$this->is_default()) {

                // translate ancestors slugs
                $current = $post;
                while ($current->post_parent) {
                    $current = get_post($current->post_parent);
                    $original_name = $current->post_name;
                    $translated_name = $falang_post->translate_post_field($current, 'post_name', $post_language);
                    if ($original_name !== $translated_name) {
                        $permalink[0] = str_replace("/$original_name/", "/$translated_name/", $permalink[0]);
                    }
                }

                $permalink[1] = $name ? $name : $falang_post->translate_post_field($post, 'post_name',$post_language);

            }

        }

        return $permalink;
    }

    /**
     *    Rectify preview post link to add language slug
     *    Filter for 'preview_post_link'
     *
     * @from 1.2.3
     * @since 1.3.3 add language_query_var to url defined in post
     */
    public function translate_preview_post_link($url, $post)
    {

        //post preview has the language default slug (depends of show_slug)
        $default_slug = $this->model->get_default_language()->slug;
        if (get_option('permalink_structure')) {
            $url = str_replace('/' . $default_slug . '/', '/', $url);
        } else {
            $url = str_replace('&' . $this->language_query_var . '=' . $default_slug, '', $url);
        }


        $falang_post = new \Falang\Core\Post($post->ID);
        $post_locale = $falang_post->get_post_locale();
        $this->model->get_option('show_slug', 0);
        if ('all' != $post_locale) {
            //add language for all specific post language
            $post_language = $this->model->get_language_by_locale($post_locale);
            $query_args[$this->language_query_var] = $post_language->slug;
            $url = add_query_arg($query_args, $url);
        } else {
            if ($this->model->get_option('show_slug', 0)) {
                $post_language = $this->model->get_default_language();
                $query_args[$this->language_query_var] = $post_language->slug;
                $url = add_query_arg($query_args, $url);
            }
        }
        return $url;
    }


    /**
     * Display the ajax debug post popup
     * @from 1.2.3
     */
    public function ajax_falang_debug_display()
    {
        //TODO throw error if no context
        $post_id = empty($_GET['post_id']) ? '' : sanitize_key($_GET['post_id']);

        $aData = array(
            'post_id' => $post_id,
        );
        $this->display('falang_debug_display_page', $aData);
        wp_die();
    }


    /* Terms UI
	----------------------------------------------- */

    /**
     * fire filters on edit.php
     *
     * @hook 'load-edit-tags.php'
     * @from 1.2.4
     */
    public function admin_edit_tags()
    {

        $current_screen = get_current_screen();
        $taxonomy = new \Falang\Core\Taxonomy();

        if ($this->model->get_languages_list() && isset($current_screen->taxonomy) && $taxonomy->is_taxonomy_translatable($current_screen->taxonomy)) {

            add_action($current_screen->taxonomy . '_edit_form_fields', array($this, 'add_term_edit_form'), 12, 2);

        }

    }

    /**
     * Add translation box on terms edit form.
     *
     * @from 1.0
     */
    public function add_term_edit_form($tag, $taxonomy)
    {

        include plugin_dir_path(__FILE__) . 'views/terms-edit-form.php';

    }

    /**
     * Intercept update term and save term translation
     *
     * @hook "edit_term"
     * @from 1.0
     */
    public function save_admin_term_translation($term_id, $tt_id, $taxonomy)
    {

        if (isset($_POST['falang_term_nonce'], $_POST['falang_term'][$taxonomy])
            && wp_verify_nonce($_POST['falang_term_nonce'], 'falang')) {

            foreach ($_POST['falang_term'][$taxonomy] as $locale => $data) {

                if (!isset($data['published'])) {
                    $data['published'] = "0";
                }

                $language = $this->model->get_language_by_locale($locale);

                if (!$this->is_default($language)) {

                    $this->update_term_translation($term_id, $data, $locale);

                }

            }

        }

    }

    /**
     *    Append language slug to home url
     *    Filter for 'home_url'
     *  exist for front too
     *
     * @from 1.0
     */
    public function translate_home_url($url, $path, $orig_scheme, $blog_id)
    {
        $language = $this->get_current_language();

        //manage specific language on post/page
        if (isset($_REQUEST['post'])) {
            $post_id = $_REQUEST['post'];
        }
        if (isset($_REQUEST['action'])) {
            $action = $_REQUEST['action'];
        }

        if (isset($post_id) && (isset($action)) && ('edit' == $action || 'editpost' == $action)) {
            $falang_post = new \Falang\Core\Post($post_id);
            if ($falang_post->locale != 'all') {
                $language = $this->model->get_language_by_locale($falang_post->locale);
            }
        }
        //end only for backend

        if (!$this->disable_translate_home_url
            && $language
            && ($this->model->get_option('show_slug') || !$this->is_default())) {
            if (get_option('permalink_structure')) {

                $url = rtrim(substr($url, 0, strlen($url) - strlen($path)), '/') . '/' . $language->slug . '/' . ltrim($path, '/');

            } else {

                $url = add_query_arg(array('lang' => $language->slug), $url);

            }
        }

        return $url;
    }

    /**
     * add script to metabox in post edition
     * use when change post language is changed
     *
     * @from 1.3.3
     */
    public function metabox_post_enqueue_script()
    {

        // register JS for option translation page
        wp_register_script('falang-classic-meta', FALANG_ADMIN_URL . '/js/classic-meta.js', array('wp-blocks', 'wp-element'), Falang()->version, true);
        $language_list = Falang()->get_model()->get_languages_list();
        $language_switcher = new \Falang\Core\Language_Switcher();
        $languages = array();
        foreach ($language_list as $language) {
            $languages[$language->locale] = array('slug' => $language->slug, 'name' => $language->name, 'home_url' => $language_switcher->get_home_url($language));
        }

        $default_language = isset(Falang()->get_model()->options['default_language']) ? Falang()->get_model()->options['default_language'] : 'en_US';
        $data = ' var defaultLanguage = "' . $default_language . '";';
        $data .= 'var falang =  ' . json_encode($languages) . ';';
        wp_add_inline_script('falang-classic-meta', $data, 'before');

        wp_enqueue_script('falang-classic-meta');
    }

    /**
     * keep <p> tags in Falang & Classic editor
     *
     * @from 1.3.5
     * @update 1.3.20 keep nbsp and shy
     * @update 1.3.30 add no_autop parameter like Advanced Editor tool
     */
    function tags_tinymce_fix($init)
    {
        $init['remove_redundant_brs'] = false;// don't remove redundant BR
        if ($this->model->get_option('no_autop',false)){
            $init['wpautop'] = false;//keep paragraph checked
        } else {
            $init['wpautop'] = true;//keep paragraph unchecked or not set
        }

        $init['indent'] = true;
        $init['tadv_noautop'] = true;
        $init['forced_root_block'] = false;//no p tags around the whole block
        $init['entities'] .= ',160,nbsp,173,shy'; //keep nbsp and shy
        $init['entity_encoding'] = 'named';
        $init['remove_linebreaks'] = false;
        $init['convert_newlines_to_brs'] = false;// don't convert newline characters to br tags

        return $init;
    }

    /**
     * update post meta translation
     * Filter for "update_{$meta_type}_metadata"
     * use : in attachment translate the alt
     *
     * @from 1.3.8
     */
    public function update_translated_postmeta($null, $object_id, $meta_key, $meta_value, $prev_value)
    {

        $post = get_post($object_id);
        $falang_post = new \Falang\Core\Post();
        $language = $this->get_current_language();

        if ($post && !$this->is_default($language) && $falang_post->is_meta_key_translatable($post->post_type, $meta_key)) {

            update_post_meta($object_id, Falang_Core::get_prefix($language->locale) . $meta_key, $meta_value, $prev_value);

            return true; // -> exit;

        }

        return $null;

    }

    /**
     * update langauge order (position)
     * get an array of locale
     * @from 1.3.9
     */
    public function ajax_falang_language_ordering(){

        $locales = empty($_POST['order']) ? '' : $_POST['order'];

        $success = false;

        foreach ($locales as $index => $locale){
            $language = $this->model->get_language_by_locale($locale);
            //success are set to false only if the last update has an error.
            $success = $this->model->update_language_order($language,$index+1);
        }

        // build response
        $response = new stdClass();
        $response->success = $success;
        $this->return_json($response);
        exit();
    }

    /**
     * manage notice dismiss
     * @since 1.3.23
     *
     * notice_id: notice name like rate_us_feedback
     */
    public function ajax_set_admin_notice_viewed()
    {
        $notice_id = empty($_POST['notice_id']) ? '' : $_POST['notice_id'];
        $plugin_id = empty($_POST['plugin_id']) ? 'falang' : $_POST['plugin_id'];
        // build response
        $response = new stdClass();
        $response->success = Admin_Notices::dismiss($notice_id,$plugin_id);
        $this->return_json($response);
        exit();

    }

    /**
     * manage upgrade falang after the update
     * @since 1.3.23
     * @since 1.3.31 fix notice display
     *
     */
    public function upgrader_process_complete($upgrader_object, $options)
    {
        if ($options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] )) {
            foreach ($options['plugins'] as $plugin) {
                if ($plugin == 'falang/falang.php'){
                    $falang_options = get_option('falang');
                    $upgrade = new Falang_Upgrade($falang_options);
                    $upgrade->upgrade();
                }
            }//end foreach
        }
    }
}
