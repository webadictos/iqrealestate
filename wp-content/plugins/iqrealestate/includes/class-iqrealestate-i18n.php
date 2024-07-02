<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://dmedina.cloud
 * @since      1.0.0
 *
 * @package    Iqrealestate
 * @subpackage Iqrealestate/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Iqrealestate
 * @subpackage Iqrealestate/includes
 * @author     Daniel Medina <dmedina83@gmail.com>
 */
class Iqrealestate_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'iqrealestate',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
