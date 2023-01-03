<?php
/*
 * Plugin Name: Falang for Elementor Lite
 * Description: Manage translation for Elementor with Falang
 * Author: Faboba
 * Author URI: https://www.faboba.com
 * Version: 1.8
 * Elementor tested up to: 3.8.1
 * Elementor Pro tested up to: 3.7.7
*/

use Elementor\Plugin;

class FalangElementor
{

    private static $elements = array(); //list of widgets translatable
    var $default_language; //default language (Falang or QTranslate)
    var $language_list; //list of active language (Falang or QTranslate)
    var $current_language; //list of active language (Falang or QTranslate)

    private $admin_notices;

    /**
     * @var static
     */
    protected static $instance;


    function __construct()
    {

        define('FALANG_ELEMENTOR_FILE', __FILE__); // plugin name as known by WP
        define('FALANG_ELEMENTOR_LITE_DIR', dirname(__FILE__)); // plugin name as known by WP
        define('FALANG_ELEMENTOR_LITE_PLUGIN_BASE', plugin_basename(FALANG_ELEMENTOR_FILE));

        //Falang must be active.
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        if (!is_plugin_active('falang/falang.php')) {
            add_action('admin_notices', array($this, 'falang_fail_load'));
            return;
        }

        //TODO use autoload
        require_once FALANG_ELEMENTOR_LITE_DIR . '/admin/admin-notices.php';

        //load all widgets
        add_action('plugins_loaded', array($this, 'init_widgets'));

        add_action('init', array($this, 'init'));
    }

    /**
     * Gets global falandivi.
     * @param null|mixed $cache
     *
     * @return static
     * @since 1.5
     *
     */
    public static function getInstance($cache = null)
    {
        return static::$instance ?: static::$instance = new static();
    }

    /**
     * @since 1.8 add falang_is_supported_builder
     */
    function init()
    {

        //init languages
        $this->default_language = $this->get_default_language();
        $this->language_list = $this->get_languages_list(array('hide_default' => true));
        $this->current_language = $this->get_current_language();

        //load admin notice
        $this->admin_notices = new Falang\Elementor\Admin\Admin_Notices();

        //backend
        //after section use for simple item
        add_action('elementor/element/after_section_end', array($this, 'after_section_end'), 10, 2);

        //frontend translation
        add_action('elementor/frontend/widget/before_render', array($this, 'frontend_widget_before_render'), 9, 1);

        //happy elementor wrapper link fix
        //lastudio fix wrapper link
        if ( is_plugin_active( 'happy-elementor-addons/plugin.php' ) ||
            is_plugin_active( 'lastudio/lastudio.php' ) ||
            is_plugin_active( 'lastudio-element-kit/lastudio-element-kit.php' ) ) {
            add_action('elementor/frontend/before_render', array($this, 'frontend_widget_before_render'), 1, 1);
        }

        //remove content translation for Elementor page
        add_filter( 'falang_is_supported_builder', array( $this, 'falang_is_supported_builder' ), 10, 2  );
    }

    function add_languages_module_tabs($tabs)
    {
        $tabs['falang'] = esc_html__('Falang', 'falang-elementor-lite');
        return $tabs;
    }

    /**
     * get current language from Falang
     * @since 1.3
     *
     */
    function get_current_language()
    {
        return Falang()->get_current_language();
    }

    function get_default_language()
    {
        return Falang()->get_model()->get_default_language();
    }

    function get_languages_list($args = array())
    {
        return Falang()->get_model()->get_languages_list($args);
    }

    function init_widgets()
    {
        $this->loadConfigElements(FALANG_ELEMENTOR_LITE_DIR . '/widgets/*.json');
    }

    /*
     * @since 1.5 need to be public for Falang for Elementor Pro
     * */
    public function loadConfigElements($path)
    {
        //load each element supported for translation
        $files = glob($path);

        foreach ($files as $file) {
            if (is_file($file)) {
                $element = $this->loadJsonFile($file);
                if (isset($element['widget_name'])) {
                    static::$elements[$element['widget_name']] = $element;
                }
            }
        }
    }

    /**
     * Loads a bootstrap config.
     *
     * @param string $file
     * @param array $parameters
     *
     * @return array
     */
    protected function loadJsonFile($file)
    {
        if (!$content = @file_get_contents($file)) {
            throw new RuntimeException("Unable to load file '{$file}'");
        }

        if (!is_array($value = @json_decode($content, true))) {
            throw new RuntimeException("Invalid JSON format in '{$file}'");
        }

        return $value;
    }

    public function getElements()
    {
        return static::$elements;
    }

    /**
     * @param $name
     * @param $language
     *
     * @return string
     */
    private function getTranslatedFieldName($name, $language)
    {
        return $name . '_' . strtolower($language->locale);
    }

    /*
     * backend method use to add translated field after the original section
     * @since 1.4 - use arrays of sections in json
     *            - add display of label before flag for section
     * */
    function after_section_end($section, $section_id)
    {
        $widget_name = $section->get_name();
        $elts = $this->getElements();

        if (!isset($elts[$widget_name]['sections'])) {
            return;
        }

        $sections = $elts[$widget_name]['sections'];

        foreach ($sections as $falang_section) {

            //need to have a section_name
            if (!isset($falang_section['section_name'])) {
                continue;
            }
            //can start with 'section_' due to extra widget like xtempos
            $section_name = $falang_section['section_name'];

            if ($section_name === $section_id) {

                //try override only on supported module
                //module are all in lowercase
                if (!array_key_exists($widget_name, $elts)) {
                    return;
                }

                $section_label = $section->get_controls($section_name);

                #Start Custom Settings Section
                foreach ($this->language_list as $language) {
                    $language_slug = sanitize_key('_' . $language->locale);
                    $flag = $language->get_flag();
                    $section_name_locale = $section_name . '<span>' . $flag . '</span>';

                    //single item


                    //add simple item (need to add a section)
                    if (isset($falang_section['control']) && !empty($falang_section['control'])) {

                        //add section
                        $section->start_controls_section(
                            $section_name_locale,
                            [
                                //'label' => __( $section_label['label'].' '.$language->locale, 'falang' ),
                                'label' => '<span style="font-weight: 400;">'.$section_label['label'].' '.$flag.'</span>',
                                'tab' => $section_label['tab'],
                            ]
                        );

                        foreach ($falang_section['control'] as $key) {
                            $control = $section->get_controls($key);
                            $control_title = $control['name'] . $language_slug;
                            $section->add_control(
                                $control_title,
                                [
                                    'label' => __($control['label'] . ' ' . $language->locale, 'falang-elementor'),
                                    'type' => $control['type'],
                                    'placeholder' => isset($control['placeholder']) ? $control['placeholder'] : '',
                                    'label_block' => isset($control['label_block']) ? $control['label_block'] : true,
                                ]
                            );
                        }

                        #End Custom Settings Section
                        $section->end_controls_section();
                    }

                    //add repeatable item no section added all are aded in sub item.
                    if (isset($falang_section['repeatable']) && !empty($falang_section['repeatable'])) {
                        $repeatable_name = array_keys($falang_section['repeatable'][0])[0];

                        // Get existing control
                        $control = $section->get_controls($repeatable_name);

                        if (is_wp_error($control)) {
                            return;
                        }

                        foreach ($falang_section['repeatable'][0][$repeatable_name] as $key) {
                            //construct elt to add
                            $elt =
                                [
                                    'name' => $control['fields'][$key]['name'] . $language_slug,
                                    'label' => $control['fields'][$key]['label'] . '&nbsp;<span>' . $flag . '</span>',
                                    'type' => $control['fields'][$key]['type'],
                                    'placeholder' => isset($control['fields'][$key]['placeholder']) ? $control['fields'][$key]['placeholder'] : '',
                                    'label_block' => isset($control['fields'][$key]['label_block']) ? $control['fields'][$key]['label_block'] : true,
                                ];
                            $control['fields'][$this->getTranslatedFieldName($key, $language)] = $elt;
                        }

                        $section->update_control($repeatable_name, $control);

                    }//end repeatable
                    //add


                }//end languages
            }
        } //end foreach

    }

    /*
     * Translate the content on front-end
     * @since 1.4 support array of sections
     * */
    function frontend_widget_before_render(\Elementor\Element_Base $element)
    {
        $widget_name = $element->get_name();
        $elts = $this->getElements();

        if (!isset($elts[$widget_name]['sections'])) {
            return;
        }

        $sections = $elts[$widget_name]['sections'];

        foreach ($sections as $falang_section){
            //try override only on supported module
            //module are all in lowercase
            if (array_key_exists($widget_name, $elts)) {
                $current_language = Falang()->get_current_language();
                //manage sinple widget
                if (isset($falang_section['control']) && !empty($falang_section['control'])) {
                    if ($current_language->locale != $this->get_default_language()->locale) {
                        foreach ($falang_section['control'] as $key) {
                            $settings_key = $this->getTranslatedFieldName($key, $current_language);
                            if ($element->get_settings($settings_key)) {
                                $element->set_settings($key, $element->get_settings($settings_key));
                            }
                        }
                    }
                }

                //manage repeatable item
                if (isset($falang_section['repeatable']) && !empty($falang_section['repeatable'])) {
                    $repeatable_name = array_keys($falang_section['repeatable'][0])[0];
                    $repeatable = $element->get_settings($repeatable_name);

                    foreach ($falang_section['repeatable'][0][$repeatable_name] as $key) {
                        foreach ($repeatable as $index => $repeat) {
                            $settings_key = $this->getTranslatedFieldName($key, $current_language);
                            if (isset($repeat[$settings_key]) && !empty($repeat[$settings_key])) {
                                $repeatable[$index][$key] = $repeat[$settings_key];
                            }
                        }
                    }
                    //override repeatable item with translation
                    $element->set_settings($repeatable_name, $repeatable);
                }

            }
        }
    }

    /**
     * Show in WP Dashboard notice about the plugin Falang is not activated.
     *
     * @return void
     * @since 1.3
     *
     */
    public function falang_fail_load()
    {
        $screen = get_current_screen();
        if (isset($screen->parent_file) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id) {
            return;
        }

        $plugin = 'falang/falang.php';

        if ($this->is_falang_installed()) {
            if (!current_user_can('activate_plugins')) {
                return;
            }

            $activation_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin);

            $message = '<p>' . __('Falang for Elementor is not working because you need to activate the Falang plugin.', 'falang-for-elementor-lite') . '</p>';
            $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $activation_url, __('Activate Falang Now', 'falang-for-elementor-lite')) . '</p>';
        } else {
            if (!current_user_can('install_plugins')) {
                return;
            }

            $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=falang'), 'falang-for-elementor-lite');

            $message = '<p>' . __('Falang for Elementor Lite is not working because you need to install the Falang plugin.', 'falang-for-elementor-lite') . '</p>';
            $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $install_url, __('Install Falang Now', 'falang-for-elementor-lite')) . '</p>';
        }

        echo '<div class="error"><p>' . $message . '</p></div>';
    }

    private function is_falang_installed()
    {
        $file_path = 'falang/falang.php';
        $installed_plugins = get_plugins();

        return isset($installed_plugins[$file_path]);
    }

    /**
     * @since 1.8 add builder name use to
     * @return false if not supported , Elementor if supported (use for display)
     */
    public function falang_is_supported_builder($return,$post){
			if (in_array('elementor/elementor.php',apply_filters( 'active_plugins', get_option( 'active_plugins' )))) {
				if (Plugin::$instance->documents->get( $post->ID )->is_built_with_elementor()) {
                    $return = 'Elementor';
				}
			}
        return $return;
    }

}

$FalangElementor = FalangElementor::getInstance();