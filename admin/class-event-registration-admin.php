<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    The Events Calendar Extension: Registration
 * @author     Tobias Fritz - http://wordpress.e-colori.com
 * @since      1.0.0
 * @link       http://wordpress.e-colori.com
 * @copyright  2015 e-colori.com
 * @subpackage /admin
 */

class Event_Registration_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	protected $plugin_slug = 'wpecr_';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */	
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( 'wpecr-admin-styles', plugin_dir_url( __FILE__ ) . 'css/event-registration-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Register the admin menu for this plugin into the WordPress menu below options.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		$page = add_menu_page( __( 'Event Registration', 'the-events-calendar-extension-registration' ), __( 'Event Registration', 'the-events-calendar-extension-registration' ), 'manage_options', 'wpecr_options');

		add_submenu_page( 'wpecr_options', __( 'Registrations', 'the-events-calendar-extension-registration' ), __( 'Registrations', 'the-events-calendar-extension-registration' ), 'manage_options', 'wpecr_options', array( $this, 'signupsheet_display' ) );

		add_submenu_page( 'wpecr_options', __( 'Settings', 'the-events-calendar-extension-registration' ), __( 'Settings', 'the-events-calendar-extension-registration' ), 'manage_options', 'wpecr_options_page', array( $this, 'wpecr_options_page' ) );

		do_action( 'wpecr_after_menu' );
		
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function wpecr_options_page() {
		$options = maybe_unserialize( get_option( $this->plugin_slug.'options' ) );
		//echo '<pre>' . print_r( $options, true ) . '</pre>';

		include_once( plugin_dir_path( __FILE__ ) . '/partials/event-registration-admin-display.php' );
	}

	/**
	 * save the settings for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function save_options() {
		if( empty( $_POST['options'] ) ) return false;
		$options = $_POST['options'];
		update_option( $this->plugin_slug.'options', maybe_serialize( $options ) );
		
		$url =  $_POST['_wp_http_referer'];
		wp_safe_redirect( $url );
    exit;
	}


	/**
	 * show registration page under settings
	 *
	 * @since    1.0.3
	 */	
	public function signupsheet_display() {
		include_once( plugin_dir_path( __FILE__ ) . '/partials/signupsheet-display.php' );
	}	


}
