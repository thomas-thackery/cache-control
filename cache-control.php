<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/thomas-thackery/
 * @since             1.0.0
 * @package           Cache_Control
 *
 * @wordpress-plugin
 * Plugin Name:       Cache Control
 * Plugin URI:        https://github.com/thomas-thackery/cache-control
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Thomas
 * Author URI:        https://github.com/thomas-thackery/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cache-control
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cache-control-activator.php
 */
function activate_cache_control() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cache-control-activator.php';
	Cache_Control_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cache-control-deactivator.php
 */
function deactivate_cache_control() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cache-control-deactivator.php';
	Cache_Control_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cache_control' );
register_deactivation_hook( __FILE__, 'deactivate_cache_control' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cache-control.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

 function run_cache_control() {

	$plugin = new Cache_Control();
	$plugin->run();

	$regex_path_patterns = array(
		'#^/test/?#',
		'#^/about/?#',
	  );
	  
	  // Loop through the patterns.
	  foreach ($regex_path_patterns as $regex_path_pattern) {
		if (preg_match($regex_path_pattern, $_SERVER['REQUEST_URI'])) {
		  add_action( 'send_headers', 'add_header_nocache', 15 );
	  
		  // No need to continue the loop once there's a match.
		  break;
		}
	  }
	  function add_header_nocache() {
			header( 'Cache-Control: no-cache, must-revalidate, max-age=0' );
	  }

}
run_cache_control();
