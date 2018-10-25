<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @package    The Events Calendar Extension: Registration
 * @author     Tobias Fritz - http://wordpress.e-colori.com
 * @since      1.0.0
 * @link       http://wordpress.e-colori.com
 * @copyright  2015 e-colori.com
 * @subpackage /includes
 */


class Event_Registration_i18n {

	/**
	 * The domain specified for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $domain The domain identifier for this plugin.
	 */
	private $domain = 'the-events-calendar-extension-registration'; //was 'wpecr' until Version: 1.4

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'the-events-calendar-extension-registration',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
		//echo dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/';
	}

	/**
	 * Set the domain equal to that of the specified domain.
	 *
	 * @since    1.0.0
	 *
	 * @param    string $domain The domain that represents the locale of this plugin.
	 */
	public function set_domain( $domain ) {
		$this->domain = $domain;
	}

}
