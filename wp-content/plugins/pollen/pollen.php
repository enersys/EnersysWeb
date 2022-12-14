<?php
/*
Plugin Name: Pollen
Plugin URI: https://visualmodo.com/pollen
Description: Get beautiful & free elements built exclusively for WPBakery Page Builder.
Version: 1.0.8
Author: Visualmodo
Author URI: https://visualmodo.com
License: GPLv3 or later
Text Domain: pollen
Domain Path: /languages
*/

// don't load directly
if (!defined('ABSPATH')) die('-1');

if ( ! defined( 'POLLEN_VERSION' ) ) define( 'POLLEN_VERSION', '1.0.8' );

// Pollen Base
$dir = dirname( __FILE__ );
$inc = dirname(__FILE__) . "/includes";

//require_once( $inc . "/paramns/icon-manager/icon-manager.php");
//require_once( $inc . "/options/init.php");
require_once( $inc . "/svg/svg.php");


/*-----------------------------------------------------------------------------------*/
/*  *.  Redux Framework Improvements
/*-----------------------------------------------------------------------------------*/

/** remove redux menu under the tools **/
add_action( 'admin_menu', 'remove_redux_menu',12 );
function remove_redux_menu() {
remove_submenu_page('tools.php','redux-about');
}


/*-----------------------------------------------------------------------------------*/
/*  *.  Pollen Dashboard
/*-----------------------------------------------------------------------------------*/

add_action( 'admin_menu', 'pollen_admin_menu' );

function pollen_admin_menu() {
    add_menu_page( 'Pollen', 'Pollen', 'manage_options', 'pollen.php', 'pollen_home', plugin_dir_url(__FILE__) . "/assets/img/pollen.svg", 99  );
}

function pollen_home(){ ?>
    <div class="wrap pollen-page-welcome about-wrap">
    <h1><?php echo sprintf( __( 'Welcome to Pollen %s', 'pollen' ), isset( $matches[0] ) ? $matches[0] : POLLEN_VERSION ) ?></h1>
    
    <div class="about-text">
    <?php _e( 'Thank you for trusting our products. Pollen will be replaced by <b>Borderless</b>. Download <b>Borderless</b> for new features.', 'pollen' ) ?>
    </div>
    <div class="wp-badge pollen-page-logo">
    <?php echo sprintf( __( 'Version %s', 'pollen' ), POLLEN_VERSION ) ?>
    </div>
    <p class="pollen-page-actions">
    <a href="https://wordpress.org/plugins/borderless/"
    class="button button-primary pollen-button-settings"><?php _e( 'Download Borderless', 'pollen' ) ?></a>
    </p>
    </div>
    <?php
}


class PollenExtendAddonClass {
    function __construct() {
        // We safely integrate with VC with this hook
        add_action( 'init', array( $this, 'integrateWithVC' ) );

        // WPBakery Custom Params
        require_once( dirname(__FILE__) . "/includes/paramns/icon-manager/includes/icon-manager-param.php" );
        
        add_action('admin_enqueue_scripts',array($this,'ipm_scripts'));
        
        // Register CSS and JS
        add_action( 'wp_enqueue_scripts', array( $this, 'ipm_css_js' ) );
    }
    
    function ipm_scripts($hook) {
        wp_enqueue_style('pollen_backend_extend_style', plugins_url('assets/css/backend.css', __FILE__) );
        
        // enqueue css files on backend
        if($hook == "post.php" || $hook == "post-new.php" || $hook == 'visual-composer_page_vc-roles'){
            if((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || is_ssl()) {
                $scheme = 'https';
            }
            else {
                $scheme = 'http';
            }
            $this->paths = wp_upload_dir();
            $this->paths['fonts']   = 'pollen_ip';
            $this->paths['fonturl'] = set_url_scheme($this->paths['baseurl'].'/'.$this->paths['fonts'], $scheme);
            $fonts = get_option('pollen_ip');
            if(is_array($fonts))
            {
                foreach($fonts as $font => $info)
                {
                    if(strpos($info['style'], 'http://' ) !== false) {
                        wp_enqueue_style('pollen-'.$font,$info['style']);
                    } else {
                        wp_enqueue_style('pollen-'.$font,trailingslashit($this->paths['fonturl']).$info['style']);
                    }
                }
            }
        }
    }
    
    public function integrateWithVC() {
        // Check if Visual Composer is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Visual Compser is required
            add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
            return;
        }

        require_once( dirname(__FILE__) . "/includes/elements/lean-map.php");        
    }
    
    // Load plugin css and javascript files which you may need on front end of your site
    public function ipm_css_js() {
        wp_register_style( 'pollen_frontend_style', plugins_url('assets/css/pollen.min.css', __FILE__), array(), POLLEN_VERSION );
        wp_enqueue_style( 'pollen_frontend_style' );
        
        // If you need any javascript files on front end, here is how you can load them.
        wp_enqueue_script( 'pollen_frontend_script', plugins_url('assets/js/pollen.js', __FILE__), array(), POLLEN_VERSION, true );
    }
    
    // Show notice if your plugin is activated but Visual Composer is not
    public function showVcVersionNotice() {
        $plugin_data = get_plugin_data(__FILE__);
        echo '
        <div class="updated">
        <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'pollen'), $plugin_data['Name']).'</p>
        </div>';
    }
}
// Finally initialize code
new PollenExtendAddonClass();