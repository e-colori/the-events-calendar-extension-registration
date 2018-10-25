<?php
/**
 * @package   The Events Calendar Extension: Registration
 * @author    Tobias Fritz - http://wordpress.e-colori.com
 * @license   GPL-2.0+
 * @link      http://wordpress.e-colori.com
 * @copyright 2015 e-colori.com
 *
 * @wordpress-plugin
 * Plugin Name: The Events Calendar Extension: Registration
 * Plugin URI:  http://wordpress.e-colori.com
 * Description: Easy and simple extension for 'The Events Calendar' to get registrations via email using shortcodes [wpecr_registration_button] and [wpecr_registration] for the form page with the permalink '/registration'
 * Version:     1.6.0
 * Author:      Nico Graff, Tobias Fritz (c) e-colori.com
 * Author URI:  http://wordpress.e-colori.com
 * Text Domain: the-events-calendar-extension-registration
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-event-registration-activator.php
 */
function activate_event_registration() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-event-registration-activator.php';
	Event_Registration_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-event-registration-deactivator.php
 */
function deactivate_event_registration() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-event-registration-deactivator.php';
	Event_Registration_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_event_registration' );
register_deactivation_hook( __FILE__, 'deactivate_event_registration' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-event-registration.php';


/**
 * Add settings link on plugin page
 *
 * @since    1.0.0
 */

function plugin_settings_link( $links ) {
	$settings_link = '<a href="options-general.php?page=wpecr_options">' . __( 'Settings', 'the-events-calendar-extension-registration' ) . '</a>';
	array_unshift( $links, $settings_link );

	return $links;
}


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */


function run_event_registration() {

	$plugin = new Event_Registration();
	add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'plugin_settings_link' );
	$plugin->run();
}

run_event_registration();
