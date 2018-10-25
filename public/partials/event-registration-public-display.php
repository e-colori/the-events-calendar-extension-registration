<?php
/**
 * Frontend view of the form to register for an event.
 *
 *
 * @package    The Events Calendar Extension: Registration
 * @author     Tobias Fritz - http://wordpress.e-colori.com
 * @since      1.0.0
 * @link       http://wordpress.e-colori.com
 * @copyright  2015 e-colori.com
 * @subpackage /public/partials
 */

$posturl = get_permalink();

if ( ! isset( $_POST['wpecr']['participants'] ) ) {
	$_POST['wpecr']['participants'] = 1;
}

//print_r($_POST);

// get data from ADMIN options
$options = maybe_unserialize( get_option( $this->plugin_slug . 'options' ) );
//echo '<pre>' . print_r( $options, true ) . '</pre>';
// $before_txt = get_option( 'before_txt' ); 

$data .= '
<div class="wpecr_registration_form">
	<div id="wpecr_txt_before">
	' . wpautop( stripslashes( $options['before_txt'] ) ) . '
	</div>
	<form action="' . $posturl . '" method="post">
	' . wp_nonce_field( 'wpecr_form', '_wpnonce_order_form' ) . '
	<div id="wpecr_adr">
	<div id="wpecr_1_adr">
		<p id="wpecr_firstname">
			<label for="firstname">' . __( 'First Name', 'the-events-calendar-extension-registration' ) . '*</label>
			<input type="text" name="wpecr[firstname]" id="firstname" value="' . $this->post_empty( 'firstname' ) . '" required>
		</p>
		<p id="wpecr_lastname">
			<label for="lastname">' . __( 'Last Name', 'the-events-calendar-extension-registration' ) . '*</label>
			<input type="text" name="wpecr[lastname]" id="lastname" value="' . $this->post_empty( 'lastname' ) . '" required>
		</p>
		<p id="wpecr_company">
			<label for="company">' . __( 'Company', 'the-events-calendar-extension-registration' ) . '</label>
			<input type="text" name="wpecr[company]" id="company" value="' . $this->post_empty( 'company' ) . '">
		</p>		
		<p id="wpecr_email">
			<label for="email">' . __( 'Email', 'the-events-calendar-extension-registration' ) . '*</label>
			<input type="email" name="wpecr[email]" id="email" value="' . $this->post_empty( 'email' ) . '" required>
		</p>

	</div>
	<div id="wpecr_2_adr">
		<p id="wpecr_address">
			<label for="address">' . __( 'Address', 'the-events-calendar-extension-registration' ) . '</label>
			<input type="text" name="wpecr[address]" id="address" value="' . $this->post_empty( 'address' ) . '" >
		</p>
		<p id="wpecr_postcode">
			<label for="postcode">' . __( 'Postcode', 'the-events-calendar-extension-registration' ) . '</label>
			<input type="text" name="wpecr[postcode]" id="postcode" value="' . $this->post_empty( 'postcode' ) . '" >
		</p>
		<p id="wpecr_city">
			<label for="city">' . __( 'City', 'the-events-calendar-extension-registration' ) . '</label>
			<input type="text" name="wpecr[city]" id="city" value="' . $this->post_empty( 'city' ) . '" >
		</p>
		<p id="wpecr_phone">
			<label for="phone">' . __( 'Phone', 'the-events-calendar-extension-registration' ) . '</label>
			<input type="tel" name="wpecr[phone]" id="phone" value="' . $this->post_empty( 'phone' ) . '" >
		</p>
	</div>
	</div>
		<p id="wpecr_country">
			<label for="country">' . __( 'Country', 'the-events-calendar-extension-registration' ) . '</label>

			<select id="country" name="wpecr[country]" >';
//get the chosen language country code
//$langg = get_locale();
//echo 'LANG'.$langg;
$locale_lang = substr( get_locale(), 3, 2 );

//get the countries by chosen language
foreach ( $this->all_countries( true, true ) as $country ) :

	if ( $country['value'] == $locale_lang && ! isset( $_POST['wpecr']['country'] ) ) {
		$data .= '<option value="' . $country['value'] . '" selected="selected">' . $country['name'] . '</option>';
	} else if ( isset( $_POST['wpecr']['country'] ) && $country['value'] == $_POST['wpecr']['country'] ) {
		$data .= '<option value="' . $country['value'] . '" selected="selected">' . $country['name'] . '</option>';
	} else {
		$data .= '<option value="' . $country['value'] . '">' . $country['name'] . '</option>';
	}

endforeach;
$data .= '	</select>
		</p>	
		<br/>
		<div id="wpecr_txt_after">
		' . wpautop( stripslashes( $options['after_txt'] ) ) . '
		</div>		
		<p id="wpecr_seminar">
			' . __( 'Event    ', 'the-events-calendar-extension-registration' ) . ': <strong>' . $this->post_empty( 'event' ) . '</strong> | ' . $this->post_empty( 'date_new' ) . ' | ' . $this->currency_format( $this->post_empty( 'price' ) ) . '
		</p>
		<p id="wpecr_participants">
			<label for="participants">' . __( 'Number of participants', 'the-events-calendar-extension-registration' ) . '</label>
			<input type="number" min="1" max="100" name="wpecr[participants]" id="participants" value="' . $this->post_empty( 'participants' ) . '" >
		</p>
		<div id="wpecr_message">
			<p>' . wpautop( stripslashes( $options['before_message'] ) ) . '</p>
			<textarea name="wpecr[message]" id="message" rows="10" cols="40">' . $this->post_empty( 'message' ) . '</textarea>
		<div/>';
if ( ! empty( $options['showterms'] ) ) {
	$data .= '
		<p id="wpecr_conditions">
			<input type="checkbox" name="wpecr[conditions]" id="conditions" value="' . $this->post_empty( 'conditions' ) . '" required>
			<label for="conditions" class="label_checkbox">' . __( 'I accept the', 'the-events-calendar-extension-registration' ) . ' <a href="' . $terms_url . '" target="_blank"> ' . __( 'terms and conditions', 'the-events-calendar-extension-registration' ) . '</a>*</label>	
		</p>';
}

//get the chosen language
$language   = substr( get_locale(), 0, 2 );
$order_date = time(); //date( 'Y-m-d H:i:s', $order_date );
//date_i18n( get_option( 'date_format' ), strtotime( '11/15-1976' ) );

$data .= '<input type="hidden" name="wpecr[language]" id="language" value="' . $language . '">
		  <input type="hidden" name="wpecr[event_id]" id="event_id" value="' . $this->post_empty( 'event_id' ) . '">
		  <input type="hidden" name="wpecr[event]" id="event" value="' . $this->post_empty( 'event' ) . '">
		  <input type="hidden" name="wpecr[date]" id="date" value="' . $this->post_empty( 'date' ) . '">
		  <input type="hidden" name="wpecr[date_new]" id="date" value="' . $this->post_empty( 'date_new' ) . '">
		  <input type="hidden" name="wpecr[price]" id="price" value="' . $this->currency_format( $this->post_empty( 'price' ) ) . '">
		  <input type="hidden" name="wpecr[order_date]" id="order_date" value="' . $order_date . '">
		<br/>
		<button type="submit" name="action" value="order_send" class="wpecr_button">' . __( 'Register', 'the-events-calendar-extension-registration' ) . '</button>
	</form>';

if ( ! empty( $options['support'] ) ) {
	$data .= '<p id="wpecr_support"><a href="http://wordpress.e-colori.com" target="_blank" title="Plugin: The Events Calendar Extension: Registration">Registration made by wordpress.e-colori.com</a></p>';
}

$data .= '
</div><!-- end .wpecr_registration_form -->';
?>