<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.matrixinternet.ie/
 * @since      1.0.0
 *
 * @package    Woo_Raffle_Ticket_Extension
 * @subpackage Woo_Raffle_Ticket_Extension/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woo_Raffle_Ticket_Extension
 * @subpackage Woo_Raffle_Ticket_Extension/includes
 * @author     Bernard Hanna <bernard@matrixinternet.ie>
 */
class Woo_Raffle_Ticket_Extension_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woo raffle ticket extension',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
