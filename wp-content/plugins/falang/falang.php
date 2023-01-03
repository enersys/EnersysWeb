<?php
/**
 * @link              www.faboba.com
 * @since             1.0
 * @package           Falang
 *
 * @wordpress-plugin
 * Plugin Name:       Falang multilanguage for WordPress
 * Plugin URI:        www.faboba.com/falangw/
 * Description:       Adds multilingual capability to WordPress
 * Version:           1.3.32
 * Author:            Faboba
 * Author URI:        www.faboba.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       falang
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );

/**
 * Currently plugin version.
 */
define( 'FALANG_VERSION', '1.3.32' );
define( 'FALANG_MIN_WP_VERSION', '4.7' );
define( 'FALANG_FILE', __FILE__ ); // this file
define( 'FALANG_BASENAME', plugin_basename( FALANG_FILE ) ); // plugin name as known by WP
define( 'FALANG_DIR', dirname( FALANG_FILE ) ); // our directory
define( 'FALANG_ADMIN', FALANG_DIR . '/admin');
define( 'FALANG_INC', FALANG_DIR . '/includes');
define( 'FALANG_EXT', FALANG_DIR . '/ext');
define ('FALANG_ADMIN_URL', plugins_url('falang/admin'));


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-falang-activator.php
 */
function activate_falang() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-falang-activator.php';
	Falang_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-falang-deactivator.php
 */
function deactivate_falang() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-falang-deactivator.php';
	Falang_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_falang' );
register_deactivation_hook( __FILE__, 'deactivate_falang' );


require_once ABSPATH . 'wp-admin/includes/plugin.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-falang.php';

/**
 *  The api class
 */
require plugin_dir_path( __FILE__ ) . 'includes/api.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0
 */

//theme_editor don't like falang with home slug - disable falang for theme editor check
if (isset($_REQUEST['wp_scrape_key'])){return;}

function run_falang() {
	$plugin = new Falang();
	$plugin->run();
}
run_falang();

