<?php
/**
* ReduxFramework Sample Config File
* For full documentation, please visit: http://docs.reduxframework.com/
*/

if ( ! class_exists( 'Redux' ) ) {
    return;
}


// This is your option name where all the Redux data is stored.
$opt_name = "pollen";

// This line is only for altering the demo. Can be easily removed.
$opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );

/*
*
* --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
*
*/

$sampleHTML = '';
if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
    Redux_Functions::initWpFilesystem();
    
    global $wp_filesystem;
    
    $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
}

// Background Patterns Reader
$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
$sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
$sample_patterns      = array();

if ( is_dir( $sample_patterns_path ) ) {
    
    if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
        $sample_patterns = array();
        
        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {
            
            if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                $name              = explode( '.', $sample_patterns_file );
                $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                $sample_patterns[] = array(
                    'alt' => $name,
                    'img' => $sample_patterns_url . $sample_patterns_file
                );
            }
        }
    }
}

/**
* ---> SET ARGUMENTS
* All the possible arguments for Redux.
* For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
* */

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'             => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name'         => 'Pollen Settings',
    // Name that appears at the top of your panel
    'display_version'      => POLLEN_VERSION,
    // Version that appears at the top of your panel
    'menu_type'            => 'submenu',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'       => true,
    // Show the sections below the admin menu item or not
    'menu_title'           => __( 'Settings', 'pollen' ),
    'page_title'           => __( 'Settings', 'pollen' ),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key'       => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography'     => false,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
    'admin_bar'            => false,
    // Show the panel pages on the admin bar
    'admin_bar_icon'       => 'dashicons-portfolio',
    // Choose an icon for the admin bar menu
    'admin_bar_priority'   => 50,
    // Choose an priority for the admin bar menu
    'global_variable'      => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode'             => false,
    // Show the time the page took to load, etc
    'update_notice'        => false,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer'           => false,
    // Enable basic customizer support
    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
    
    // OPTIONAL -> Give you extra features
    'page_priority'        => null,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'          => 'pollen.php',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions'     => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon'            => '',
    // Specify a custom URL to an icon
    'last_tab'             => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'            => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'            => 'pollen-settings',
    // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults'        => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'         => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'         => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'   => true,
    // Shows the Import/Export panel when not used as a field.
    
    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
    
    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'             => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn'              => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.
    
    // HINTS
    'hints'                => array(
        'icon'          => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color'    => 'lightgray',
        'icon_size'     => 'normal',
        'tip_style'     => array(
            'color'   => 'red',
            'shadow'  => true,
            'rounded' => false,
            'style'   => '',
        ),
        'tip_position'  => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect'    => array(
            'show' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'mouseover',
            ),
            'hide' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'click mouseleave',
            ),
        ),
        )
    );
    
    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => 'https://github.com/visualmodo',
        'title' => 'Visit us on GitHub',
        'icon'  => 'el el-github'
        //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/visualmodo/',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://twitter.com/visualmodo',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://pt.linkedin.com/company/visualmodo',
        'title' => 'Find us on LinkedIn',
        'icon'  => 'el el-linkedin'
    );
    
    Redux::setArgs( $opt_name, $args );
    
    /*
    * ---> END ARGUMENTS
    */
    
    
    /*
    *
    * ---> START SECTIONS
    *
    */
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Colors', 'pollen' ),
        'id'         => 'aaa',
        'desc'       => __( 'Control and configure the design options.', 'pollen' ),
        'icon'             => 'el el-tint',
        'fields'     => array(
            /*
            array(
                'id'       => 'pollen_dark_light_mode_elements',
                'type'     => 'button_set',
                'title'    => __( 'Elements Dark or Light', 'pollen' ),
                'subtitle'     => __( 'Select a color mode for elements.', 'pollen' ),
                'options'  => array(
                    '1' => 'Light Mode',
                    '2' => 'Dark Mode'
                ),
                'default'  => '1'
            ),
            array(
                'id'       => 'pollen_dark_light_mode_sections',
                'type'     => 'button_set',
                'title'    => __( 'Sections Dark or Light', 'pollen' ),
                'subtitle'     => __( 'Select a color mode for sections.', 'pollen' ),
                'options'  => array(
                    '1' => 'Light Mode',
                    '2' => 'Dark Mode'
                ),
                'default'  => '1'
            ),
            */
            array(
                'id'       => 'pollen_color_switch',
                'type'     => 'button_set',
                'title'    => __( 'Color Mode', 'pollen' ),
                'subtitle'     => __( 'Select a color mode.', 'pollen' ),
                'options'  => array(
                    '1' => 'Global Color',
                    '2' => 'Custom Color'
                ),
                'default'  => '1'
            ),
            array(
                'id'        => 'pollen_global_color',
                'type'      => 'color',
                'title'     => __('Global Color', 'pollen'),
                'output'    => array(
                    'color'            => '.pollen-global-color',
                    
                    'background-color' => '.pollen-global-background-color',
                    
                    'border-color' => '.pollen-global-border-color',
                ),
                'subtitle'  => __('Pick a global color for the elements.', 'pollen'),
                'default'   => '#3379fc',
                'transparent' => false,
                'validate'  => 'color',
                'required' => array( 'pollen_color_switch', '=', '1' ),
            ),
            array(
                'id'        => 'pollen_background_color',
                'type'      => 'color',
                'title'     => __('Background Color', 'pollen'),
                'output'    => array(
                    'background-color' => '.pollen-global-background-color',
                ),
                'subtitle'  => __('Pick a background color for the elements.', 'pollen'),
                'default'   => '#3379fc',
                'transparent' => false,
                'validate'  => 'color',
                'required' => array( 'pollen_color_switch', '=', '2' ),
            ),
            array(
                'id'        => 'pollen_border_color',
                'type'      => 'color',
                'title'     => __('Border Color', 'pollen'),
                'output'    => array(
                    'border-color' => '.pollen-global-border-color',
                ),
                'subtitle'  => __('Pick a border color for the elements.', 'pollen'),
                'default'   => '#3379fc',
                'transparent' => false,
                'validate'  => 'color',
                'required' => array( 'pollen_color_switch', '=', '2' ),
            ),
            array(
                'id'        => 'pollen_color',
                'type'      => 'color',
                'title'     => __('Color', 'pollen'),
                'output'    => array(
                    'color' => '.pollen-global-color',
                ),
                'subtitle'  => __('Pick a color for the elements.', 'pollen'),
                'default'   => '#3379fc',
                'transparent' => false,
                'validate'  => 'color',
                'required' => array( 'pollen_color_switch', '=', '2' ),
            ),
            array(
                'id'       => 'pollen_link_color',
                'type'     => 'link_color',
                'title'    => __( 'Link Color', 'pollen' ),
                'subtitle'     => __( 'Enter the color for link states.', 'pollen' ),
                'required' => array( 'pollen_color_switch', '=', '2' ),
                //'regular'   => false, // Disable Regular Color
                //'hover'     => false, // Disable Hover Color
                //'active'    => false, // Disable Active Color
                'visited'   => true,  // Enable Visited Color
                'default'  => array(
                    'regular' => '#3379fc',
                    'hover'   => '#3365c3',
                    'active'  => '#3365c3',
                    'visited' => '#34528a',
                ),
            ),
            )
            ) );
            
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Elements', 'pollen' ),
        'id'         => 'bbb',
        'desc'       => __( 'Control and configure the elements.', 'pollen' ),
        'icon'             => 'el el-asterisk',
        'fields'     => array(
            array(
                'id'       => 'pollen_element_alert',
                'type'     => 'switch', 
                'title'    => __('Alert', 'pollen'),
                'subtitle' => __('Enable or disable element.', 'pollen'),
                'default'  => true,
            ),
            array(
                'id'       => 'pollen_element_circular_progress_bar',
                'type'     => 'switch', 
                'title'    => __('Circular Progress Bar', 'pollen'),
                'subtitle' => __('Enable or disable element.', 'pollen'),
                'default'  => true,
            ),
            array(
                'id'       => 'pollen_element_counter',
                'type'     => 'switch', 
                'title'    => __('Counter', 'pollen'),
                'subtitle' => __('Enable or disable element.', 'pollen'),
                'default'  => true,
            ),
            array(
                'id'       => 'pollen_element_icon',
                'type'     => 'switch', 
                'title'    => __('Icon', 'pollen'),
                'subtitle' => __('Enable or disable element.', 'pollen'),
                'default'  => true,
            ),
            array(
                'id'       => 'pollen_element_icon_group',
                'type'     => 'switch', 
                'title'    => __('Icon Group', 'pollen'),
                'subtitle' => __('Enable or disable element.', 'pollen'),
                'default'  => true,
            ),
            array(
                'id'       => 'pollen_element_infobox',
                'type'     => 'switch', 
                'title'    => __('Infobox', 'pollen'),
                'subtitle' => __('Enable or disable element.', 'pollen'),
                'default'  => true,
            ),
            array(
                'id'       => 'pollen_element_list_group',
                'type'     => 'switch', 
                'title'    => __('List Group', 'pollen'),
                'subtitle' => __('Enable or disable element.', 'pollen'),
                'default'  => true,
            ),
            array(
                'id'       => 'pollen_element_modal',
                'type'     => 'switch', 
                'title'    => __('Modal', 'pollen'),
                'subtitle' => __('Enable or disable element.', 'pollen'),
                'default'  => true,
            ),
            array(
                'id'       => 'pollen_element_testimonial',
                'type'     => 'switch', 
                'title'    => __('Testimonial', 'pollen'),
                'subtitle' => __('Enable or disable element.', 'pollen'),
                'default'  => true,
            ),
            array(
                'id'       => 'pollen_element_pricing',
                'type'     => 'switch', 
                'title'    => __('Pricing', 'pollen'),
                'subtitle' => __('Enable or disable element.', 'pollen'),
                'default'  => true,
            ),
            array(
                'id'       => 'pollen_element_progress_bar',
                'type'     => 'switch', 
                'title'    => __('Progress Bar', 'pollen'),
                'subtitle' => __('Enable or disable element.', 'pollen'),
                'default'  => true,
            ),
            array(
                'id'       => 'pollen_element_semi_circular_progress_bar',
                'type'     => 'switch', 
                'title'    => __('Semi Circular Progress Bar', 'pollen'),
                'subtitle' => __('Enable or disable element.', 'pollen'),
                'default'  => true,
            ),
            array(
                'id'       => 'pollen_element_svg',
                'type'     => 'switch', 
                'title'    => __('SVG', 'pollen'),
                'subtitle' => __('Enable or disable element.', 'pollen'),
                'default'  => true,
            ),
            )
            ) );
                    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Custom Code', 'pollen' ),
        'id'         => 'ccc',
        'desc'       => __( 'Enter your custom codes.', 'pollen' ),
        'icon'             => 'el el-css',
        'fields'     => array(
            array(
                'id'        => 'pollen_custom_css',
                'type'      => 'ace_editor',
                'title'     => __('CSS Code', 'pollen'),
                'subtitle'  => __('Paste your CSS code here.', 'pollen'),
                'mode'      => 'css',
                'theme'     => 'monokai',
            ),
            array(
                'id'        => 'pollen_custom_javascript',
                'type'      => 'ace_editor',
                'title'     => __('JS Code', 'pollen'),
                'subtitle'  => __('Paste your JS code here.', 'pollen'),
                'mode'      => 'javascript',
                'theme'     => 'chrome',
            ),
            )
            ) );
            
            /*
            * <--- END SECTIONS
            */
                            
                            