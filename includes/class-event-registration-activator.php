<?php

/**
 * Fired during plugin activation
 *
 * @package    The Events Calendar Extension: Registration
 * @author     Tobias Fritz - http://wordpress.e-colori.com
 * @since      1.0.0
 * @link       http://wordpress.e-colori.com
 * @copyright  2015 e-colori.com
 * @subpackage /includes
 */

class Event_Registration_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		$options = array( 'name' => get_bloginfo( 'name' ), 'email' => get_bloginfo( 'admin_email' ), 'terms' => esc_url( home_url( '/terms' ) ), 'showterms' => '1',
					'email_txt' => __( 'If you withdraw from a training until 4 weeks before the start we have to charge a processing fee of 50,- €. After this period, the full course fee is payable plus the costs for accommodation, or you have to provide a replacement participant.', 'the-events-calendar-extension-registration' ) . ' ' . __( 'Enter your contact details here. Name, address, phone, email, url, etc.', 'the-events-calendar-extension-registration' ),
					'before_txt' => __( 'Please complete the fields below, accept our terms and conditions and press Register. You will receive an automatic registration confirmation from us by e-mail.', 'the-events-calendar-extension-registration' ),
					'after_txt' => __( 'I hereby register for the event.', 'the-events-calendar-extension-registration' ),
					'before_message' => __( 'Your message', 'the-events-calendar-extension-registration' ),
					'currency' => '€', 'showbank' => '', 
					'bank_txt' => __( 'Your registration for a seminar or training is not mandatory until the seminar fee has been paid into our bank account (free seminars excluded).', 'the-events-calendar-extension-registration' ), 
					'bank' => '', 'remittee' => '', 'iban' => '', 'bic' => '', 'support' => '0');

		//update_option( 'wpecr_options', maybe_serialize( $options ) );
		if ( FALSE === get_option( 'wpecr_options' ) && FALSE === update_option( 'wpecr_options', FALSE ) ) add_option('wpecr_options', maybe_serialize( $options ) );
	}

}