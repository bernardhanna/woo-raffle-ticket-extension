<?php
//LOOKING TO MAKE CHANGES???? SUGGEST YOU CHECK class-woo raffle ticket extension.php 
//LOCATED HERE: woo raffle ticket extension/includes/class-woo raffle ticket extension.php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.matrixinternet.ie/
 * @since             1.0.0
 * @package           Woo_Raffle_Ticket_Extension
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Raffle Ticket Extension
 * Plugin URI:        https://www.matrixinternet.ie/
 * Description:       This plugin extends WPRaffle, allowing a user to enter 2 draws with one ticket
 * Version:           1.0.0
 * Author:            Bernard Hanna
 * Author URI:        https://www.matrixinternet.ie/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo raffle ticket extension
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
define( 'WOO RAFFLE TICKET EXTENSION_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo raffle ticket extension-activator.php
 */
function activate_wooraffleticketextension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo raffle ticket extension-activator.php';
	Woo_Raffle_Ticket_Extension_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo raffle ticket extension-deactivator.php
 */
function deactivate_wooraffleticketextension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo raffle ticket extension-deactivator.php';
	Woo_Raffle_Ticket_Extension_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo raffle ticket extension' );
register_deactivation_hook( __FILE__, 'deactivate_woo raffle ticket extension' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo raffle ticket extension.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wooraffleticketextension() {

	$plugin = new Woo_Raffle_Ticket_Extension();
	$plugin->run();

}
run_wooraffleticketextension();
