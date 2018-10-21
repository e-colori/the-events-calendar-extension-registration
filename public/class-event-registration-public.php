<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @package    The Events Calendar Extension: Registration
 * @author     Tobias Fritz - http://wordpress.e-colori.com
 * @since      1.0.0
 * @link       http://wordpress.e-colori.com
 * @copyright  2015 e-colori.com
 * @subpackage /public
 */


/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */
class Event_Registration_Public {

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
	 * @param    string    $plugin_name       The name of this plugin.
	 * @param    string    $version    The version of this plugin.
	 */
	protected $plugin_slug = 'wpecr_';


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    $plugin_name       The name of the plugin.
	 * @param    string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/event-registration-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/event-registration-public.js', array( 'jquery' ), $this->version, false );

	}

		/**
	 * NOTE:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *        WordPress Actions: http://codex.wordpress.org/Plugin_API#Actions
	 *        Action Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */
	public function add_shortcodes() {
		add_shortcode( 'wpecr_registration_button', array( $this, 'wpecr_registration_button' ) );
		add_shortcode( 'wpecr_registration', array( $this, 'wpecr_registration' ) );
	
	}	

	/**
	 * url for registration button
	 *
	 * @since    1.0.0
	 */
	public function registration_button_url() {
		//$posturl = 'http://' . $_SERVER['SERVER_NAME'];
		$posturl = home_url();
		/*
		$url_search = "/.nl/";
		if ( preg_match( $url_search, $posturl ) ) {
			$posturl = $posturl.'/registration-nl';
		}else{
			$posturl = $posturl.'/registration';
		}
		*/
		return $posturl = $posturl.'/registration';
  }

  /**
	 * new email name for sending
	 *
	 * @since    1.0.0
	 */
	public function wp_email_from_name() {
		// get data from ADMIN options
		$options = maybe_unserialize( get_option( $this->plugin_slug.'options' ) );
		
		$name = ( ( $options['name'] ) ? $options['name'] : get_bloginfo( 'name' ) );
		$name = esc_attr( $name );
		return $name;
	}

	/**
	 * new email for sending 
	 *
	 * @since    1.0.0
	 */
	public function wp_email_from() {
		// get data from ADMIN options
		$options = maybe_unserialize( get_option( $this->plugin_slug.'options' ) );
		
		$email = ( ( $options['email'] ) ? $options['email'] : get_bloginfo( 'admin_email' ) );
		$email = is_email( $email );
		return $email;
	}	

	/**
	 * composing an email with attachments
	 * 
	 * @since     1.0.0
	 */ 
	public function send_email( $to, $to_email, $from, $from_email, $subject, $message, $attachments='', $to_owner=true ){

		// get data from ADMIN options
		$options = maybe_unserialize( get_option( $this->plugin_slug.'options' ) );
		
		$name = ( ( $options['name'] ) ? $options['name'] : get_bloginfo( 'name' ) );
		$name = esc_attr( $name );
		$email = ( ( $options['email'] ) ? $options['email'] : get_bloginfo( 'admin_email' ) );

		$from = empty( $from )? $name : $from ; 
		$from_email = empty( $from_email )? $email : $from_email; 


		//ZZZ depreceated get from ADMIN options
		$email_footer = '<br/><hr/>';
		$email_footer .= $name.'<br/>';
		$email_footer .= $from_email.'<br/>';
		$email_footer .= $_SERVER['SERVER_NAME'];
		//$message .= $email_footer;

	//Composing the Email confirmation
		
		/* recipient CLIENT */
		$to1 = $to.' <'.$to_email.'>';
		/* header information */
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-Type: text/html; charset="UTF-8"';
		$headers[] = 'From: '.$from.' <'.$from_email.'>';

		/* 2nd recipient OWNER */
		$to2 = $from.' <'.$from_email.'>'; //ZZZ change to user@example.com, anotheruser@example.com
		/* header information */
		$headers2[] = 'MIME-Version: 1.0';
		$headers2[] = 'Content-Type: text/html; charset="UTF-8"'; //charset=' . get_option( 'blog_charset' );
		$headers2[] = 'From: '.$from.' <'.$from_email.'>';
		$headers2[] = 'Reply-To: '.$to.' <'.$to_email.'>';
		
		//action for PRO to save data in DB table
		do_action( 'wpecr_after_registration_send' );

		//send to owner
		if ( $to_owner ){
			wp_mail( $to2, $subject, $message, $headers2, $attachments );
			//echo ('From: '.$from.' '.$from_email.'');
		}
		//send to client
		return wp_mail( $to1, $subject, $message, $headers, $attachments );

	}

	/**
	 * check if post is not empty
	 *
	 * @since     1.0.0
	 */
    public function post_empty( $data, $id='' ) {

    	if( isset( $_POST['wpecr'][$data] ) && !empty( $data ) ) {
    		return $_POST['wpecr'][$data];
    	} else {
    		return false;
    	}

    }

	/**
	 * shortcode: Show registration button
	 *
	 * @since     1.0.0
	 */
    public function wpecr_registration_button( $atts ) {

    	//get event infos from The Events Calender plugin
		$event = tribe_events_get_event();
		//$cost = tribe_get_cost();
		//echo 'event <pre>' . print_r( $event, true ) . '</pre>';


		$event_id = $event->ID;
		$event_title = $event->post_title;
		$event_date  = $event->EventStartDate; //ZZZ has timezone problems
		$event_date_new = tribe_get_start_date();
		$event_price = tribe_get_cost();

		$data = 
			'<form action="' .$this->registration_button_url(). '" method="post" class="wpecr_registration">
				<input type="hidden" name="wpecr[event_id]" value="'. $event_id .'">
				<input type="hidden" name="wpecr[event]" value="'. $event_title .'">
				<input type="hidden" name="wpecr[date]" value="'. $event_date .'">
				<input type="hidden" name="wpecr[date_new]" value="'. $event_date_new .'">
				<input type="hidden" name="wpecr[price]" value="'. $event_price .'">
				<button type="submit" name="submit" class="wpecr_button">'.__( 'Register now', 'the-events-calendar-extension-registration' ).'</button>
			</form>';

		return $data;
    }

	/**
	 * shortcode: Show registration form
	 *
	 * @since     1.0.0
	 */
    public function wpecr_registration( $atts ) {

    	$data ='';
    	$options = maybe_unserialize( get_option( $this->plugin_slug.'options' ) );
    	$terms_url = ( ( $options['terms'] ) ? $options['terms'] : home_url( '/terms' ) );

    	extract( shortcode_atts( array(
			'' => '',
		), $atts, 'wpecr_registration' ) );

    	if( isset( $_POST['action'] ) && $_POST['action'] =='order_send' ) {
				if ( !wp_verify_nonce( $_POST['_wpnonce_order_form'],'wpecr_form' ) ) return false;

				if ( $page_message= $this->wpecr_registration_send() ) {					
					//YES email
					$data ='<p><strong>'. $page_message .'</strong></p>';
					$data .='<p>'. __( 'We sent you an email with your registration details.', 'the-events-calendar-extension-registration' ) .'</p>';
					$data .='<a href=" '. home_url() .'">'. __( 'Return to Home', 'the-events-calendar-extension-registration' ) .'</a>';					
				}else{
					//NO email
					$data ='<p class="wpecr_error">'. __( 'Sorry, your registration was not sent. Please get in contact with us.', 'the-events-calendar-extension-registration' ) .'</p>';
				}

    	}else{
    		include_once( plugin_dir_path( __FILE__ ) . '/partials/event-registration-public-display.php' );
    	}

		return $data;
    }    

	/**
	 * send registration email confirmation
	 *
	 * @since     1.0.0
	 */
	
    public function wpecr_registration_send() {

    	// send registration-email 
		$to = $_POST['wpecr']['firstname'].' '.$_POST['wpecr']['lastname'];
		$to_email = $_POST['wpecr']['email'];
		$subject = sprintf( __( 'Registration: %1$s', 'the-events-calendar-extension-registration' ), $_POST['wpecr']['event'] ).' '.$_POST['wpecr']['date_new'].' ';
		$subject .= __( '(automatic reply)', 'the-events-calendar-extension-registration' );

		$message = $page_message = sprintf( __( 'Thank you %1$s, <br/><br/> your registration was successful.', 'the-events-calendar-extension-registration' ), $to );

		$message .= '<br/><br/>'. $to ;
	    if ( ! empty ( $_POST['wpecr']['company'] ) ) {
		    $message .= '<br/>' . $_POST['wpecr']['company'];
	    }
		$message .= '<br/>'. $_POST['wpecr']['address'];
		$message .= '<br/>'. $_POST['wpecr']['country'].' '.$_POST['wpecr']['postcode'].' '.$_POST['wpecr']['city'];
		$message .= '<br/><br/>'. $_POST['wpecr']['phone'];
		$message .= '<br/>'. $_POST['wpecr']['email'];
		
		$message .= '<br/><br/>'. $_POST['wpecr']['event'].' | '.$_POST['wpecr']['date_new'].' | '.$_POST['wpecr']['price'];
		$message .= '<br/><br/>'.__( 'Number of participants', 'the-events-calendar-extension-registration' ).': '. $_POST['wpecr']['participants'];
		$message .= '<br/><br/>'. $_POST['wpecr']['message'];

		// get data from ADMIN options
		$options = maybe_unserialize( get_option( $this->plugin_slug.'options' ) );
		//echo '<pre>' . print_r( $options, true ) . '</pre>';

		if ( !empty( $options['showbank'] ) ) {
			$message .= '<br/><br/>'.$options['bank_txt'];
		    $message .= '<br/><br/>'.__( 'Please transfer the invoice total to:', 'the-events-calendar-extension-registration' );
			$message .= '<br/> '.$options['bank'];
			$message .= '<br/>'.__( 'Remittee', 'the-events-calendar-extension-registration' ).' '.$options['remittee']; 
			$message .= '<br/>'.__( 'IBAN', 'the-events-calendar-extension-registration' ).' '.$options['iban']; 
			$message .= '<br/>'.__( 'Swift / BIC Code', 'the-events-calendar-extension-registration' ).' '.$options['bic'];  
			$message .= '<br/>'.__( 'Reason for payment', 'the-events-calendar-extension-registration' ).' '.$_POST['wpecr']['event'];	
			$message .= '<br/>'.__( 'Amount', 'the-events-calendar-extension-registration' ).' '.$_POST['wpecr']['price'];	
			$message .= '<br/><br/>'.__( 'Thank you!', 'the-events-calendar-extension-registration' );
		}
		// footer from ADMIN options
		$message .= '<br/><br/>';
		//echo 'MAIL:'.
		$message .= wpautop( stripslashes( $options['email_txt'] ) ); 


		//echo $message;
		$mail_status = $this->send_email( $to, $to_email, '', '', $subject, $message );
		
		if ( $mail_status ){
			return $page_message;
		}

		return false;
    }

	/**
	 * function to create countries array in different languages with iso codes
	 *
	 * @since     1.0.0
	 */
	public function all_countries( $sort_abc = false, $meta_box = false, $language='' ){
		$all_countries_array = array();

			$all_countries_array_i18n = array();
			
			$all_countries_array_i18n['en']= array ( 'AF' => 'Afghanistan', 'AL' => 'Albania', 'DZ' => 'Algeria', 'AS' => 'American Samoa', 'AD' => 'Andorra', 'AO' => 'Angola', 'AQ' => 'Antarctica', 'AG' => 'Antigua and Barbuda', 'AR' => 'Argentina', 'AM' => 'Armenia', 'AW' => 'Aruba', 'AU' => 'Australia', 'AT' => 'Austria', 'AZ' => 'Azerbaijan', 'BS' => 'Bahamas', 'BH' => 'Bahrain', 'BD' => 'Bangladesh', 'BB' => 'Barbados', 'BY' => 'Belarus', 'BE' => 'Belgium', 'BZ' => 'Belize', 'BM' => 'Bermuda', 'BJ' => 'Benin', 'BT' => 'Bhutan', 'BO' => 'Bolivia', 'BA' => 'Bosnia and Herzegovina', 'BW' => 'Botswana', 'BR' => 'Brazil', 'VG' => 'British Virgin Islands', 'BN' => 'Brunei', 'BG' => 'Bulgaria', 'BF' => 'Burkina Faso', 'BI' => 'Burundi', 'CI' => 'C&ocirc;te D\'Ivoire', 'KH' => 'Cambodia', 'CM' => 'Cameroon', 'CA' => 'Canada', 'CV' => 'Cape Verde', 'KY'=>'Cayman Islands', 'CF' => 'Central African Republic', 'TD' => 'Chad', 'CL' => 'Chile', 'CN' => 'China', 'CO' => 'Colombia', 'KM' => 'Comoros', 'CR' => 'Costa Rica', 'HR' => 'Croatia', 'CU' => 'Cuba', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic', 'KP' => 'Democratic People\'s Republic of Korea', 'CD' => 'Democratic Republic of the Congo', 'DK' => 'Denmark', 'DJ' => 'Djibouti', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'XE' => 'England', 'GQ' => 'Equatorial Guinea', 'ER' => 'Eritrea', 'EE' => 'Estonia', 'ET' => 'Ethiopia', 'FJ' => 'Fiji', 'FI' => 'Finland', 'FR' => 'France', 'PF' => 'French Polynesia', 'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Germany', 'GH' => 'Ghana', 'GR' => 'Greece', 'GL' => 'Greenland', 'GD' => 'Grenada', 'GP' =>'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala', 'GN' => 'Guinea', 'GW' => 'Guinea Bissau', 'GY' => 'Guyana', 'HT' => 'Haiti', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hungary', 'IS' => 'Iceland', 'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Iran', 'IQ' => 'Iraq', 'IE' => 'Ireland', 'IL' => 'Israel', 'IT' => 'Italy', 'JE'=>'Jersey', 'JM' => 'Jamaica', 'JP' => 'Japan', 'JO' => 'Jordan', 'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati', 'KV' => 'Kosovo', 'KW' => 'Kuwait', 'KG' => 'Kyrgyzstan', 'LA' => 'Laos', 'LV' => 'Latvia', 'LB' => 'Lebanon', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' => 'Libyan Arab Jamahiriya', 'LI' => 'Liechtenstein', 'LT' => 'Lithuania', 'LU' => 'Luxembourg', 'MO' => 'Macao', 'MK' => 'Macedonia', 'MG' => 'Madagascar', 'MW' => 'Malawi', 'MY' => 'Malaysia', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Marshall Islands', 'MQ' => 'Mauritania', 'MU' => 'Mauritius', 'MR' => 'Mauritania', 'MX' => 'Mexico', 'FM' => 'Micronesia', 'MD' => 'Moldova', 'MC' => 'Monaco', 'MN' => 'Mongolia', 'ME' => 'Montenegro', 'MA' => 'Morocco', 'MZ' => 'Mozambique', 'MM' => 'Myanmar(Burma)', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Netherlands', 'AN' => 'Netherlands Antilles', 'NC' => 'New Caledonia', 'NZ' => 'New Zealand', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'XI' => 'Northern Ireland', 'MP' => 'Northern Mariana Islands', 'NO' => 'Norway', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PS' => 'Palestine', 'PA' => 'Panama', 'PG' => 'Papua New Guinea', 'PY' => 'Paraguay', 'PE' => 'Peru', 'PH' => 'Philippines', 'PL' => 'Poland', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'CG' => 'Republic of the Congo', 'RN' => 'Réunion', 'RO' => 'Romania', 'RU' => 'Russia', 'RW' => 'Rwanda', 'ST' => 'S&agrave;o Tom&eacute; And Pr&iacute;ncipe', 'KN' => 'Saint Kitts and Nevis', 'LC' => 'Saint Lucia', 'VC' => 'Saint Vincent and the Grenadines', 'WS' => 'Samoa', 'SM' => 'San Marino', 'SA' => 'Saudi Arabia', 'XS' => 'Scotland', 'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapore', 'SK' => 'Slovakia', 'SI' => 'Slovenia', 'SB' => 'Solomon Islands', 'SO' => 'Somalia', 'ZA' => 'South Africa', 'KR' => 'South Korea', 'ES' => 'Spain', 'LK' => 'Sri Lanka', 'SD' => 'Sudan', 'SR' => 'Suriname', 'SZ' => 'Swaziland', 'SE' => 'Sweden', 'CH' => 'Switzerland', 'SY' => 'Syria', 'TW' => 'Taiwan', 'TJ' => 'Tajikistan', 'TZ' => 'Tanzania', 'TH' => 'Thailand', 'TL' => 'Timor-Leste', 'TG' => 'Togo', 'TO' => 'Tonga', 'TT' => 'Trinidad and Tobago', 'TN' => 'Tunisia', 'TR' => 'Turkey', 'TM' => 'Turkmenistan', 'TV' => 'Tuvalu', 'VI' => 'US Virgin Islands', 'UG' => 'Uganda', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates', 'GB' => 'United Kingdom', 'US' => 'United States', 'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu', 'VA' => 'Vatican', 'VE' => 'Venezuela', 'VN' => 'Vietnam', 'XW' => 'Wales', 'YE' => 'Yemen', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe' );
			
			$all_countries_array_i18n['de']= array ( 'AF' => 'Afghanistan', 'AL' => 'Albanien', 'DZ' => 'Algerien', 'AS' => 'Amerikanisch-Samoa', 'AD' => 'Andorra', 'AO' => 'Angola', 'AQ' => 'Antarktis',   'AG' => 'Antigua und Barbuda', 'AR' => 'Argentinien', 'AM' => 'Armenien',     'AW' => 'Aruba', 'AU' => 'Australien', 'AT' => 'Österreich', 'AZ' => 'Aserbaidschan', 'BS' => 'Bahamas', 'BH' => 'Bahrain', 'BD' => 'Bangladesch', 'BB' => 'Barbados', 'BY' => 'Belarus',      'BE' => 'Belgien',  'BZ' => 'Belize', 'BM' => 'Bermuda', 'BJ' => 'Benin', 'BT' => 'Bhutan',  'BO' => 'Bolivien', 'BA' => 'Bosnien und Herzegowina', 'BW' => 'Botsuana', 'BR' => 'Brasilien', 'VG' => 'Britische Jungferninseln',    'BN' => 'Brunei Darussalam', 'BG' => 'Bulgarien',  'BF' => 'Burkina Faso',  'BI' => 'Burundi', 'CI' => 'C&ocirc;te D\'Ivoire',              'KH' => 'Kambodscha', 'CM' => 'Kamerun',  'CA' => 'Kanada', 'CV' => 'Kap Verde',           'KY'=>'Kaimaninseln',       'CF' => 'Zentralafrikanische Republik',      'TD' => 'Tschad', 'CL' => 'Chile', 'CN' => 'China', 'CO' => 'Kolumbien', 'KM' => 'Komoren',         'CR' => 'Costa Rica', 'HR' => 'Kroatien',     'CU' => 'Kuba', 'CY' => 'Zypern', 'CZ' => 'Tschechische Republik', 'KP' => 'Demokratische Volksrepublik Korea',    'CD' => 'Demokratische Republik Kongo', 'DK' => 'Dänemark', 'DJ' => 'Dschibuti', 'DM' => 'Dominica', 'DO' => 'Dominikanische Republik', 'EC' => 'Ecuador', 'EG' => 'Ägypten', 'SV' => 'El Salvador', 'XE' => 'England', 'GQ' => 'Äquatorialguinea', 'ER' => 'Eritrea', 'EE' => 'Estland', 'ET' => 'Äthiopien', 'FJ' => 'Fidschi', 'FI' => 'Finnland', 'FR' => 'Frankreich', 'PF' => 'Französisch-Polynesien', 'GA' => 'Gabun', 'GM' => 'Gambia', 'GE' => 'Georgien', 'DE' => 'Deutschland', 'GH' => 'Ghana', 'GR' => 'Griechenland', 'GL' => 'Grönland', 'GD' => 'Grenada', 'GP' =>'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala', 'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana', 'HT' => 'Haiti', 'HN' => 'Honduras', 'HK' => 'HongKong', 'HU' => 'Ungarn', 'IS' => 'Island', 'IN' => 'Indien', 'ID' => 'Indonesien', 'IR' => 'Iran', 'IQ' => 'Irak', 'IE' => 'Irland', 'IL' => 'Israel', 'IT' => 'Italien', 'JE'=>'Jersey', 'JM' => 'Jamaika', 'JP' => 'Japan', 'JO' => 'Jordanien', 'KZ' => 'Kasachstan', 'KE' => 'Kenia', 'KI' => 'Kiribati', 'KV' => 'Kosovo', 'KW' => 'Kuwait', 'KG' => 'Kirgisistan', 'LA' => 'Laos', 'LV' => 'Lettland', 'LB' => 'Libanon', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' => 'Libyen', 'LI' => 'Liechtenstein', 'LT' => 'Litauen', 'LU' => 'Luxemburg', 'MO' => 'Macau', 'MK' => 'Mazedonien', 'MG' => 'Madagaskar', 'MW' => 'Malawi', 'MY' => 'Malaysia', 'MV' => 'Malediven', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Marshallinseln', 'MQ' => 'Martinique', 'MU' => 'Mauritius', 'MR' => 'Mauretanien', 'MX' => 'Mexiko', 'FM' => 'Mikronesien', 'MD' => 'Republik Moldau', 'MC' => 'Monaco', 'MN' => 'Mongolei', 'ME' => 'Montenegro', 'MA' => 'Marokko', 'MZ' => 'Mosambik', 'MM' => 'Myanmar(Burma)', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Niederlande', 'AN' => 'Niederländische Antillen', 'NC' => 'Neukaledonien', 'NZ' => 'Neuseeland', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'XI' => 'Northern Ireland', 'MP' => 'Nördliche Marianen', 'NO' => 'Norwegen', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PS' => 'Palestine', 'PA' => 'Panama', 'PG' => 'Papua-Neuguinea', 'PY' => 'Paraguay', 'PE' => 'Peru', 'PH' => 'Philippinen', 'PL' => 'Polen', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Katar', 'CG' => 'Kongo', 'RN' => 'Réunion', 'RO' => 'Rumänien', 'RU' => 'Russische Föderation', 'RW' => 'Ruanda', 'ST' => 'São Tomé und Príncipe', 'KN' => 'St. Kitts und Nevis', 'LC' => 'St. Lucia', 'VC' => 'St. Vincent und die Grenadinen', 'WS' => 'Samoa', 'SM' => 'San Marino', 'SA' => 'Saudi-Arabien', 'XS' => 'Scotland', 'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seychellen', 'SL' => 'Sierra Leone', 'SG' => 'Singapur', 'SK' => 'Slowakei', 'SI' => 'Slowenien', 'SB' => 'Salomonen', 'SO' => 'Somalia', 'ZA' => 'Südafrika', 'KR' => 'Republik Korea', 'ES' => 'Spanien', 'LK' => 'Sri Lanka', 'SD' => 'Sudan', 'SR' => 'Suriname', 'SZ' => 'Swasiland', 'SE' => 'Schweden', 'CH' => 'Schweiz', 'SY' => 'Syrien', 'TW' => 'Taiwan', 'TJ' => 'Tadschikistan', 'TZ' => 'Tansania', 'TH' => 'Thailand', 'TL' => 'Osttimor', 'TG' => 'Togo', 'TO' => 'Tonga', 'TT' => 'Trinidad und Tobago', 'TN' => 'Tunesien', 'TR' => 'Türkei', 'TM' => 'Turkmenistan', 'TV' => 'Tuvalu', 'VI' => 'Amerikanische Jungferninseln', 'UG' => 'Uganda', 'UA' => 'Ukraine', 'AE' => 'Vereinigte Arabische Emirate', 'GB' => 'Vereinigtes Königreich', 'US' => 'Vereinigte Staaten', 'UY' => 'Uruguay', 'UZ' => 'Usbekistan', 'VU' => 'Vanuatu', 'VA' => 'Vatikanstadt', 'VE' => 'Venezuela', 'VN' => 'Vietnam', 'XW' => 'Wales', 'YE' => 'Jemen', 'ZM' => 'Sambia', 'ZW' => 'Simbabwe' );
			
			$all_countries_array_i18n['es']= array ( 'AF' => 'Afganistán',  'AL' => 'Albania',  'DZ' => 'Argelia',  'AS' => 'Samoa Americana',    'AD' => 'Andorra', 'AO' => 'Angola', 'AQ' => 'Antártida',   'AG' => 'Antigua y Barbuda',   'AR' => 'Argentina',   'AM' => 'Armenia',      'AW' => 'Aruba', 'AU' => 'Australia',  'AT' => 'Austria',    'AZ' => 'Azerbaiyán',    'BS' => 'Bahamas', 'BH' => 'Bahráin', 'BD' => 'Bangladesh',  'BB' => 'Barbados', 'BY' => 'Bielorrusia',  'BE' => 'Bélgica',  'BZ' => 'Belice', 'BM' => 'Bermuda', 'BJ' => 'Benin', 'BT' => 'Bután',   'BO' => 'Bolivia',  'BA' => 'Bosnia y Hercegovina',    'BW' => 'Botsuana', 'BR' => 'Brasil',    'VG' => 'Islas Vírgenes Británicas',   'BN' => 'Brunéi',            'BG' => 'Bulgaria',   'BF' => 'Burkina Faso',  'BI' => 'Burundi', 'CI' => 'Costa de Marfil',                   'KH' => 'Camboya',    'CM' => 'Camerún',  'CA' => 'Canadá', 'CV' => 'Cabo Verde',          'KY'=>'Islas Caimán',       'CF' => 'República Centroafricana',          'TD' => 'Chad',   'CL' => 'Chile', 'CN' => 'China', 'CO' => 'Colombia',  'KM' => 'Comoras',         'CR' => 'Costa Rica', 'HR' => 'Croacia',      'CU' => 'Cuba', 'CY' => 'Chipre', 'CZ' => 'República Checa',       'KP' => 'Corea del Norte',                      'CD' => 'República Democrática del Congo', 'DK' => 'Dinamarca', 'DJ' => 'Yibuti', 'DM' => 'Dominica', 'DO' => 'República Dominicana', 'EC' => 'Ecuador', 'EG' => 'Egipto', 'SV' => 'El Salvador', 'XE' => 'England', 'GQ' => 'Guinea Ecuatorial', 'ER' => 'Eritrea', 'EE' => 'Estonia', 'ET' => 'Etiopía', 'FJ' => 'Fiyi', 'FI' => 'Finlandia', 'FR' => 'Francia', 'PF' => 'Polinesia Francesa', 'GA' => 'Gabón', 'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Alemania', 'GH' => 'Ghana', 'GR' => 'Grecia', 'GL' => 'Groenlandia', 'GD' => 'Granada', 'GP' =>'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala', 'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana', 'HT' => 'Haití', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hungría', 'IS' => 'Islandia', 'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Irán', 'IQ' => 'Iraq', 'IE' => 'Irlanda', 'IL' => 'Israel', 'IT' => 'Italia', 'JE'=>'Jersey', 'JM' => 'Jamaica', 'JP' => 'Japón', 'JO' => 'Jordania', 'KZ' => 'Kazajistán', 'KE' => 'Kenia', 'KI' => 'Kiribati', 'KV' => 'Kosovo', 'KW' => 'Kuwait', 'KG' => 'Kirguizistán', 'LA' => 'Laos', 'LV' => 'Letonia', 'LB' => 'Líbano', 'LS' => 'Lesoto', 'LR' => 'Liberia', 'LY' => 'Libia', 'LI' => 'Liechtenstein', 'LT' => 'Lituania', 'LU' => 'Luxemburgo', 'MO' => 'Macao', 'MK' => 'Macedonia', 'MG' => 'Madagascar', 'MW' => 'Malaui', 'MY' => 'Malasia', 'MV' => 'Maldivas', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Islas Marshall', 'MQ' => 'Martinica', 'MU' => 'Mauricio', 'MR' => 'Mauritania', 'MX' => 'México', 'FM' => 'Micronesia', 'MD' => 'Moldavia', 'MC' => 'Mónaco', 'MN' => 'Mongolia', 'ME' => 'Montenegro', 'MA' => 'Marruecos', 'MZ' => 'Mozambique', 'MM' => 'Myanmar(Burma)', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Países Bajos', 'AN' => 'Antillas Neerlandesas', 'NC' => 'Nueva Caledonia', 'NZ' => 'Nueva Zelanda', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'XI' => 'Northern Ireland', 'MP' => 'Islas Marianas del Norte', 'NO' => 'Noruega', 'OM' => 'Omán', 'PK' => 'Pakistán', 'PW' => 'Palaos', 'PS' => 'Palestine', 'PA' => 'Panamá', 'PG' => 'Papúa-Nueva Guinea', 'PY' => 'Paraguay', 'PE' => 'Perú', 'PH' => 'Filipinas', 'PL' => 'Polonia', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'CG' => 'Republic of the Congo', 'RN' => 'Réunion', 'RO' => 'Rumania', 'RU' => 'Russia', 'RW' => 'Ruanda', 'ST' => 'Santo Tomé y Príncipe', 'KN' => 'San Cristóbal y Nieves', 'LC' => 'Santa Lucía', 'VC' => 'San Vicente y las Granadinas', 'WS' => 'Samoa', 'SM' => 'San Marino', 'SA' => 'Arabia Saudí', 'XS' => 'Scotland', 'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seychelles', 'SL' => 'Sierra Leona', 'SG' => 'Singapur', 'SK' => 'Eslovaquia', 'SI' => 'Eslovenia', 'SB' => 'Islas Salomón', 'SO' => 'Somalia', 'ZA' => 'Sudáfrica', 'KR' => 'Corea del Sur', 'ES' => 'España', 'LK' => 'Sri Lanka', 'SD' => 'Sudán', 'SR' => 'Surinam', 'SZ' => 'Suazilandia', 'SE' => 'Suecia', 'CH' => 'Suiza', 'SY' => 'Siria', 'TW' => 'Taiwán', 'TJ' => 'Tayikistán', 'TZ' => 'Tanzania', 'TH' => 'Tailandia', 'TL' => 'Timor Oriental', 'TG' => 'Togo', 'TO' => 'Tonga', 'TT' => 'Trinidad y Tobago', 'TN' => 'Túnez', 'TR' => 'Turquía', 'TM' => 'Turkmenistán', 'TV' => 'Tuvalu', 'VI' => 'Islas Vírgenes Americanas', 'UG' => 'Uganda', 'UA' => 'Ucrania', 'AE' => 'Emiratos Árabes Unidos', 'GB' => 'Reino Unido', 'US' => 'Estados Unidos', 'UY' => 'Uruguay', 'UZ' => 'Uzbekistán', 'VU' => 'Vanuatu', 'VA' => 'El Vaticano', 'VE' => 'Venezuela', 'VN' => 'Vietnam', 'XW' => 'Wales', 'YE' => 'Yemen', 'ZM' => 'Zambia', 'ZW' => 'Zimbabue' );
			
			$all_countries_array_i18n['pt']= array ( 'AF' => 'Afeganistão', 'AL' => 'Albânia',  'DZ' => 'Argélia',  'AS' => 'Samoa Americana',    'AD' => 'Andorra', 'AO' => 'Angola', 'AQ' => 'Antárctida',  'AG' => 'Antígua e Barbuda',   'AR' => 'Argentina',   'AM' => 'Arménia',      'AW' => 'Aruba', 'AU' => 'Austrália',  'AT' => 'Áustria',    'AZ' => 'Azerbaijão',    'BS' => 'Baamas',  'BH' => 'Barém',   'BD' => 'Bangladeche', 'BB' => 'Barbados', 'BY' => 'Bielorrússia', 'BE' => 'Bélgica',  'BZ' => 'Belize', 'BM' => 'Bermuda', 'BJ' => 'Benim', 'BT' => 'Butão',   'BO' => 'Bolívia',  'BA' => 'Bósnia e Herzegovina',    'BW' => 'Botsuana', 'BR' => 'Brasil',    'VG' => 'Ilhas Virgens Britânicas',    'BN' => 'Brunei',            'BG' => 'Bulgária',   'BF' => 'Burquina Faso', 'BI' => 'Burúndi', 'CI' => 'Costa do Marfim',                   'KH' => 'Camboja',    'CM' => 'Camarões', 'CA' => 'Canadá', 'CV' => 'Cabo Verde',          'KY'=>'Ilhas Caimão',       'CF' => 'República Centro-Africana',         'TD' => 'Chade',  'CL' => 'Chile', 'CN' => 'China', 'CO' => 'Colômbia',  'KM' => 'Comores',         'CR' => 'Costa Rica', 'HR' => 'Croácia',      'CU' => 'Cuba', 'CY' => 'Chipre', 'CZ' => 'República Checa',       'KP' => 'Coreia do Norte', 'CD' => 'Congo-Kinshasa', 'DK' => 'Dinamarca', 'DJ' => 'Jibuti', 'DM' => 'Domínica', 'DO' => 'República Dominicana', 'EC' => 'Equador', 'EG' => 'Egipto', 'SV' => 'Salvador', 'XE' => 'England', 'GQ' => 'Guiné Equatorial', 'ER' => 'Eritreia', 'EE' => 'Estónia', 'ET' => 'Etiópia', 'FJ' => 'Fiji', 'FI' => 'Finlândia', 'FR' => 'França', 'PF' => 'Polinésia Francesa', 'GA' => 'Gabão', 'GM' => 'Gambia', 'GE' => 'Geórgia', 'DE' => 'Alemanha', 'GH' => 'Gana', 'GR' => 'Grécia', 'GL' => 'Gronelândia', 'GD' => 'Granada', 'GP' =>'Guadeloupe', 'GU' => 'Guame', 'GT' => 'Guatemala', 'GN' => 'Guiné', 'GW' => 'Guiné-Bissau', 'GY' => 'Guiana', 'HT' => 'Haiti', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hungria', 'IS' => 'Islândia', 'IN' => 'Índia', 'ID' => 'Indonésia', 'IR' => 'Irão', 'IQ' => 'Iraque', 'IE' => 'Irlanda', 'IL' => 'Israel', 'IT' => 'Itália', 'JE'=>'Jersey', 'JM' => 'Jamaica', 'JP' => 'Japão', 'JO' => 'Jordânia', 'KZ' => 'Cazaquistão', 'KE' => 'Quénia', 'KI' => 'Quiribáti', 'KV' => 'Kosovo', 'KW' => 'Kuwait', 'KG' => 'Quirguizistão', 'LA' => 'Laos', 'LV' => 'Letónia', 'LB' => 'Líbano', 'LS' => 'Lesoto', 'LR' => 'Libéria', 'LY' => 'Líbia', 'LI' => 'Listenstaine', 'LT' => 'Lituânia', 'LU' => 'Luxemburgo', 'MO' => 'Macau', 'MK' => 'Macedónia', 'MG' => 'Madagáscar', 'MW' => 'Malávi', 'MY' => 'Malásia', 'MV' => 'Maldivas', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Ilhas Marshall', 'MQ' => 'Martinica', 'MU' => 'Maurícia', 'MR' => 'Mauritânia', 'MX' => 'México', 'FM' => 'Micronésia', 'MD' => 'Moldávia', 'MC' => 'Mónaco', 'MN' => 'Mongólia', 'ME' => 'Montenegro', 'MA' => 'Marrocos', 'MZ' => 'Moçambique', 'MM' => 'Birmânia', 'NA' => 'Namíbia', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Países Baixos', 'AN' => 'Antilhas Neerlandesas', 'NC' => 'Nova Caledónia', 'NZ' => 'Nova Zelândia', 'NI' => 'Nicarágua', 'NE' => 'Níger', 'NG' => 'Nigéria', 'XI' => 'Northern Ireland', 'MP' => 'Marianas do Norte', 'NO' => 'Noruega', 'OM' => 'Omã', 'PK' => 'Paquistão', 'PW' => 'Palau', 'PS' => 'Palestine', 'PA' => 'Panamá', 'PG' => 'Papua-Nova Guiné', 'PY' => 'Paraguai', 'PE' => 'Peru', 'PH' => 'Filipinas', 'PL' => 'Polónia', 'PT' => 'Portugal', 'PR' => 'Porto Rico', 'QA' => 'Catar', 'CG' => 'Republic of the Congo', 'RN' => 'Réunion', 'RO' => 'Roménia', 'RU' => 'Rússia', 'RW' => 'Ruanda', 'ST' => 'São Tomé e Príncipe', 'KN' => 'São Cristóvão e Neves', 'LC' => 'Santa Lúcia', 'VC' => 'São Vicente e Granadinas', 'WS' => 'Samoa', 'SM' => 'São Marinho', 'SA' => 'Arábia Saudita', 'XS' => 'Scotland', 'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seicheles', 'SL' => 'Serra Leoa', 'SG' => 'Singapura', 'SK' => 'Eslováquia', 'SI' => 'Eslovénia', 'SB' => 'Ilhas Salomão', 'SO' => 'Somália', 'ZA' => 'África do Sul', 'KR' => 'Coreia do Sul', 'ES' => 'Espanha', 'LK' => 'Sri Lanca', 'SD' => 'Sudão', 'SR' => 'Suriname', 'SZ' => 'Suazilândia', 'SE' => 'Suécia', 'CH' => 'Suíça', 'SY' => 'Síria', 'TW' => 'Taiwan', 'TJ' => 'Tajiquistão', 'TZ' => 'Tanzânia', 'TH' => 'Tailândia', 'TL' => 'Timor-Leste', 'TG' => 'Togo', 'TO' => 'Tonga', 'TT' => 'Trindade e Tobago', 'TN' => 'Tunísia', 'TR' => 'Turquia', 'TM' => 'Turquemenistão', 'TV' => 'Tuvalu', 'VI' => 'Ilhas Virgens Americanas', 'UG' => 'Uganda', 'UA' => 'Ucrânia', 'AE' => 'Emiratos Árabes Unidos', 'GB' => 'Reino Unido', 'US' => 'Estados Unidos', 'UY' => 'Uruguai', 'UZ' => 'Usbequistão', 'VU' => 'Vanuatu', 'VA' => 'Vaticano', 'VE' => 'Venezuela', 'VN' => 'Vietname', 'XW' => 'Wales', 'YE' => 'Iémen', 'ZM' => 'Zâmbia', 'ZW' => 'Zimbabué' );
			
			$all_countries_array_i18n['fr']= array ( 'AF' => 'Afghanistan', 'AL' => 'Albanie',  'DZ' => 'Algérie',  'AS' => 'Samoa américaines',  'AD' => 'Andorre', 'AO' => 'Angola', 'AQ' => 'Antarctique', 'AG' => 'Antigua-et-Barbuda',  'AR' => 'Argentine',   'AM' => 'Arménie',      'AW' => 'Aruba', 'AU' => 'Australie',  'AT' => 'Autriche',   'AZ' => 'Azerbaïdjan',   'BS' => 'Bahamas', 'BH' => 'Bahreïn', 'BD' => 'Bangladesh',  'BB' => 'Barbade',  'BY' => 'Biélorussie',  'BE' => 'Belgique', 'BZ' => 'Belize', 'BM' => 'Bermuda', 'BJ' => 'Bénin', 'BT' => 'Bhoutan', 'BO' => 'Bolivie',  'BA' => 'Bosnie-Herzégovine',      'BW' => 'Botswana', 'BR' => 'Brésil',    'VG' => 'Iles Vierges britanniques',   'BN' => 'Brunei',            'BG' => 'Bulgarie',   'BF' => 'Burkina Faso',  'BI' => 'Burundi', 'CI' => 'C&ocirc;te D\'Ivoire',              'KH' => 'Cambodge',   'CM' => 'Cameroun', 'CA' => 'Canada', 'CV' => 'Cap-Vert',            'KY'=>'Iles Cayman',        'CF' => 'République centrafricaine',         'TD' => 'Tchad',  'CL' => 'Chili', 'CN' => 'Chine', 'CO' => 'Colombie',  'KM' => 'Comores',         'CR' => 'Costa Rica', 'HR' => 'Croatie',      'CU' => 'Cuba', 'CY' => 'Chypre', 'CZ' => 'République tchèque',    'KP' => 'Corée du Nord',                        'CD' => 'République démocratique du Congo', 'DK' => 'Danemark', 'DJ' => 'Djibouti', 'DM' => 'Dominique', 'DO' => 'République dominicaine', 'EC' => 'Équateur', 'EG' => 'Égypte', 'SV' => 'Salvador', 'XE' => 'England', 'GQ' => 'Guinée équatoriale', 'ER' => 'Érythrée', 'EE' => 'Estonie', 'ET' => 'Éthiopie', 'FJ' => 'Iles Fidji', 'FI' => 'Finlande', 'FR' => 'France', 'PF' => 'Polynésie française', 'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' => 'Géorgie', 'DE' => 'Allemagne', 'GH' => 'Ghana', 'GR' => 'Grèce', 'GL' => 'Groenland', 'GD' => 'Grenade', 'GP' =>'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala', 'GN' => 'Guinée', 'GW' => 'Guinée-Bissao', 'GY' => 'Guyana', 'HT' => 'Haïti', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hongrie', 'IS' => 'Islande', 'IN' => 'Inde', 'ID' => 'Indonésie', 'IR' => 'Iran', 'IQ' => 'Iraq', 'IE' => 'Irlande', 'IL' => 'Israël', 'IT' => 'Italie', 'JE'=>'Jersey', 'JM' => 'Jamaïque', 'JP' => 'Japon', 'JO' => 'Jordanie', 'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati', 'KV' => 'Kosovo', 'KW' => 'Koweït', 'KG' => 'Kirghizistan', 'LA' => 'Laos', 'LV' => 'Lettonie', 'LB' => 'Liban', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' => 'Libye', 'LI' => 'Liechtenstein', 'LT' => 'Lituanie', 'LU' => 'Luxembourg', 'MO' => 'Macao', 'MK' => 'Macédoine', 'MG' => 'Madagascar', 'MW' => 'Malawi', 'MY' => 'Malaisie', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' => 'Malte', 'MH' => 'Iles Marshall', 'MQ' => 'Martinique', 'MU' => 'Maurice', 'MR' => 'Mauritanie', 'MX' => 'Mexique', 'FM' => 'Micronésie', 'MD' => 'Moldavie', 'MC' => 'Monaco', 'MN' => 'Mongolie', 'ME' => 'Montenegro', 'MA' => 'Maroc', 'MZ' => 'Mozambique', 'MM' => 'le Myanmar', 'NA' => 'Namibie', 'NR' => 'Nauru', 'NP' => 'Népal', 'NL' => 'Pays-Bas', 'AN' => 'Antilles néerlandaises', 'NC' => 'Nouvelle-Calédonie', 'NZ' => 'Nouvelle-Zélande', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'XI' => 'Northern Ireland', 'MP' => 'Mariannes du Nord', 'NO' => 'Norvège', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PS' => 'Palestine', 'PA' => 'Panama', 'PG' => 'Papouasie-Nouvelle-Guinée', 'PY' => 'Paraguay', 'PE' => 'Pérou', 'PH' => 'Philippines', 'PL' => 'Pologne', 'PT' => 'Portugal', 'PR' => 'Porto Rico', 'QA' => 'Qatar', 'CG' => 'Republic of the Congo', 'RN' => 'Réunion', 'RO' => 'Roumanie', 'RU' => 'Russie', 'RW' => 'Rwanda', 'ST' => 'Sao Tomé-et-Principe', 'KN' => 'Saint-Christophe-et-Niévès', 'LC' => 'Sainte-Lucie', 'VC' => 'Saint-Vincent-et-les-Grenadines', 'WS' => 'Samoa', 'SM' => 'Saint-Marin', 'SA' => 'Arabie saoudite', 'XS' => 'Scotland', 'SN' => 'Sénégal', 'RS' => 'Serbia', 'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapour', 'SK' => 'Slovaquie', 'SI' => 'Slovénie', 'SB' => 'Iles Salomon', 'SO' => 'Somalie', 'ZA' => 'Afrique du Sud', 'KR' => 'Corée du Sud', 'ES' => 'Espagne', 'LK' => 'Sri Lanka', 'SD' => 'Soudan', 'SR' => 'Suriname', 'SZ' => 'Swaziland', 'SE' => 'Suède', 'CH' => 'Suisse', 'SY' => 'Syrie', 'TW' => 'Taïwan', 'TJ' => 'Tadjikistan', 'TZ' => 'Tanzanie', 'TH' => 'Thaïlande', 'TL' => 'Timor Oriental', 'TG' => 'Togo', 'TO' => 'Tonga', 'TT' => 'Trinité-et-Tobago', 'TN' => 'Tunisie', 'TR' => 'Turquie', 'TM' => 'Turkménistan', 'TV' => 'Tuvalu', 'VI' => 'Iles Vierges américaines', 'UG' => 'Ouganda', 'UA' => 'Ukraine', 'AE' => 'Émirats arabes unis', 'GB' => 'Royaume-Uni', 'US' => 'États-Unis', 'UY' => 'Uruguay', 'UZ' => 'Ouzbékistan', 'VU' => 'Vanuatu', 'VA' => 'Saint-Siège', 'VE' => 'Venezuela', 'VN' => 'Viêt Nam', 'XW' => 'Wales', 'YE' => 'Yémen', 'ZM' => 'Zambie', 'ZW' => 'Zimbabwe' );
			
			$all_countries_array_i18n['it']= array ( 'AF' => 'Afghanistan', 'AL' => 'Albania',  'DZ' => 'Algeria',  'AS' => 'Samoa americane',    'AD' => 'Andorra', 'AO' => 'Angola', 'AQ' => 'Antartide',   'AG' => 'Antigua e Barbuda',   'AR' => 'Argentina',   'AM' => 'Armenia',      'AW' => 'Aruba', 'AU' => 'Australia',  'AT' => 'Austria',    'AZ' => 'Azerbaigian',   'BS' => 'Bahamas', 'BH' => 'Bahrein', 'BD' => 'Bangladesh',  'BB' => 'Barbados', 'BY' => 'Bielorussia',  'BE' => 'Belgio',   'BZ' => 'Belize', 'BM' => 'Bermuda', 'BJ' => 'Benin', 'BT' => 'Bhutan',  'BO' => 'Bolivia',  'BA' => 'Bosnia-Erzegovina',       'BW' => 'Botswana', 'BR' => 'Brasile',   'VG' => 'Isole Vergini britanniche',   'BN' => 'Brunei',            'BG' => 'Bulgaria',   'BF' => 'Burkina Faso',  'BI' => 'Burundi', 'CI' => 'Costa d\'Avorio',                   'KH' => 'Cambogia',   'CM' => 'Camerun',  'CA' => 'Canada', 'CV' => 'Capo Verde',          'KY'=>'Isole Cayman',       'CF' => 'Repubblica Centrafricana',          'TD' => 'Ciad',   'CL' => 'Cile',  'CN' => 'Cina',  'CO' => 'Colombia',  'KM' => 'Comore',          'CR' => 'Costa Rica', 'HR' => 'Croazia',      'CU' => 'Cuba', 'CY' => 'Cipro',  'CZ' => 'Repubblica ceca',       'KP' => 'Corea del Nord', 'CD' => 'Congo', 'DK' => 'Danimarca', 'DJ' => 'Gibuti', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'EC' => 'Ecuador', 'EG' => 'Egitto', 'SV' => 'El Salvador', 'XE' => 'England', 'GQ' => 'Guinea Equatoriale', 'ER' => 'Eritrea', 'EE' => 'Estonia', 'ET' => 'Etiopia', 'FJ' => 'Figi', 'FI' => 'Finlandia', 'FR' => 'Francia', 'PF' => 'Polinesia francese', 'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Germania', 'GH' => 'Ghana', 'GR' => 'Grecia', 'GL' => 'Groenlandia', 'GD' => 'Grenada', 'GP' =>'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala', 'GN' => 'Guinea', 'GW' => 'Guinea Bissau', 'GY' => 'Guyana', 'HT' => 'Haiti', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Ungheria', 'IS' => 'Islanda', 'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Iran', 'IQ' => 'Iraq', 'IE' => 'Irlanda', 'IL' => 'Israele', 'IT' => 'Italia', 'JE'=>'Jersey', 'JM' => 'Giamaica', 'JP' => 'Giappone', 'JO' => 'Giordania', 'KZ' => 'Kazakistan', 'KE' => 'Kenya', 'KI' => 'Kiribati', 'KV' => 'Kosovo', 'KW' => 'Kuwait', 'KG' => 'Kirghizistan', 'LA' => 'Laos', 'LV' => 'Lettonia', 'LB' => 'Libano', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' => 'Libia', 'LI' => 'Liechtenstein', 'LT' => 'Lituania', 'LU' => 'Lussemburgo', 'MO' => 'Macao', 'MK' => 'Macedonia', 'MG' => 'Madagascar', 'MW' => 'Malawi', 'MY' => 'Malesia', 'MV' => 'Maldive', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Isole Marshall', 'MQ' => 'Martinica', 'MU' => 'Maurizio', 'MR' => 'Mauritania', 'MX' => 'Messico', 'FM' => 'Micronesia', 'MD' => 'Moldavia', 'MC' => 'Monaco', 'MN' => 'Mongolia', 'ME' => 'Montenegro', 'MA' => 'Marocco', 'MZ' => 'Mozambico', 'MM' => 'Myanmar(Birmania)', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Paesi Bassi', 'AN' => 'Antille olandesi', 'NC' => 'Nuova Caledonia', 'NZ' => 'Nuova Zelanda', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'XI' => 'Northern Ireland', 'MP' => 'Marianne settentrionali', 'NO' => 'Norvegia', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PS' => 'Palestine', 'PA' => 'Panama', 'PG' => 'Papua Nuova Guinea', 'PY' => 'Paraguay', 'PE' => 'Perù', 'PH' => 'Filippine', 'PL' => 'Polonia', 'PT' => 'Portogallo', 'PR' => 'Portorico', 'QA' => 'Qatar', 'CG' => 'Republic of the Congo', 'RN' => 'Réunion', 'RO' => 'Romania', 'RU' => 'Russia', 'RW' => 'Ruanda', 'ST' => 'São Tomé e Príncipe', 'KN' => 'Saint Christopher e Nevis', 'LC' => 'Saint Lucia', 'VC' => 'Saint Vincent e Grenadine', 'WS' => 'Samoa', 'SM' => 'San Marino', 'SA' => 'Arabia Saudita', 'XS' => 'Scotland', 'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seicelle', 'SL' => 'Sierra Leone', 'SG' => 'Singapore', 'SK' => 'Slovacchia', 'SI' => 'Slovenia', 'SB' => 'Isole Salomone', 'SO' => 'Somalia', 'ZA' => 'Sudafrica', 'KR' => 'Corea del Sud', 'ES' => 'Spagna', 'LK' => 'Sri Lanka', 'SD' => 'Sudan', 'SR' => 'Suriname', 'SZ' => 'Swaziland', 'SE' => 'Svezia', 'CH' => 'Svizzera', 'SY' => 'Siria', 'TW' => 'Taiwan', 'TJ' => 'Tagikistan', 'TZ' => 'Tanzania', 'TH' => 'Thailandia', 'TL' => 'Timor-Leste', 'TG' => 'Togo', 'TO' => 'Tonga', 'TT' => 'Trinidad e Tobago', 'TN' => 'Tunisia', 'TR' => 'Turchia', 'TM' => 'Turkmenistan', 'TV' => 'Tuvalu', 'VI' => 'Isole Vergini americane', 'UG' => 'Uganda', 'UA' => 'Ucraina', 'AE' => 'Emirati arabi uniti', 'GB' => 'Regno Unito', 'US' => 'Stati Uniti', 'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu', 'VA' => 'Vaticano', 'VE' => 'Venezuela', 'VN' => 'Vietnam', 'XW' => 'Wales', 'YE' => 'Yemen', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe' );

			$all_countries_array_i18n['nl']= array ( 'AF' => 'Afghanistan', 'AL' => 'Albanië',  'DZ' => 'Algerije', 'AS' => 'Amerikaans-Samoa',   'AD' => 'Andorra', 'AO' => 'Angola', 'AQ' => 'Antarctica',  'AG' => 'Antigua en Barbuda',  'AR' => 'Argentinië',  'AM' => 'Armenië',      'AW' => 'Aruba', 'AU' => 'Australië',  'AT' => 'Oostenrijk', 'AZ' => 'Azerbeidzjan',  'BS' => 'Bahamas', 'BH' => 'Bahrein', 'BD' => 'Bangladesh',  'BB' => 'Barbados', 'BY' => 'Belarus',      'BE' => 'België',   'BZ' => 'Belize', 'BM' => 'Bermuda', 'BJ' => 'Benin', 'BT' => 'Bhutan',  'BO' => 'Bolivia',  'BA' => 'Bosnië en Herzegovina',   'BW' => 'Botswana', 'BR' => 'Brazilië',  'VG' => 'Britse Maagdeneilanden',      'BN' => 'Brunei',            'BG' => 'Bulgarije',  'BF' => 'Burkina Faso',  'BI' => 'Burundi', 'CI' => 'Ivoorkust',                         'KH' => 'Cambodja',   'CM' => 'Kameroen', 'CA' => 'Canada', 'CV' => 'Kaapverdië',          'KY'=>'Caymaneilanden',     'CF' => 'Centraal-Afrikaanse Republiek',     'TD' => 'Tsjaad', 'CL' => 'Chili', 'CN' => 'China', 'CO' => 'Colombia',  'KM' => 'Comoren',         'CR' => 'Costa Rica', 'HR' => 'Kroatië',      'CU' => 'Cuba', 'CY' => 'Cyprus', 'CZ' => 'Tsjechië',              'KP' => 'Noord-Korea', 'CD' => 'Democratische Republiek Congo', 'DK' => 'Denemarken', 'DJ' => 'Djibouti', 'DM' => 'Dominica', 'DO' => 'Dominicaanse Republiek', 'EC' => 'Ecuador', 'EG' => 'Egypte', 'SV' => 'El Salvador', 'XE' => 'England', 'GQ' => 'Equatoriaal-Guinea', 'ER' => 'Eritrea', 'EE' => 'Estland', 'ET' => 'Ethiopië', 'FJ' => 'Fiji', 'FI' => 'Finland', 'FR' => 'Frankrijk', 'PF' => 'Frans-Polynesië', 'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' => 'Georgië', 'DE' => 'Duitsland', 'GH' => 'Ghana', 'GR' => 'Griekenland', 'GL' => 'Groenland', 'GD' => 'Grenada', 'GP' =>'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala', 'GN' => 'Guinee', 'GW' => 'Guinee-Bissau', 'GY' => 'Guyana', 'HT' => 'Haïti', 'HN' => 'Honduras', 'HK' => 'HongKong', 'HU' => 'Hongarije', 'IS' => 'IJsland', 'IN' => 'India', 'ID' => 'Indonesië', 'IR' => 'Iran', 'IQ' => 'Irak', 'IE' => 'Ierland', 'IL' => 'Israël', 'IT' => 'Italië', 'JE'=>'Jersey', 'JM' => 'Jamaica', 'JP' => 'Japan', 'JO' => 'Jordanië', 'KZ' => 'Kazachstan', 'KE' => 'Kenia', 'KI' => 'Kiribati', 'KV' => 'Kosovo', 'KW' => 'Koeweit', 'KG' => 'Kirgizië', 'LA' => 'Laos', 'LV' => 'Letland', 'LB' => 'Libanon', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' => 'Libië', 'LI' => 'Liechtenstein', 'LT' => 'Litouwen', 'LU' => 'Luxemburg', 'MO' => 'Macau', 'MK' => 'Macedonië', 'MG' => 'Madagaskar', 'MW' => 'Malawi', 'MY' => 'Maleisië', 'MV' => 'Maldiven', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Marshalleilanden', 'MQ' => 'Martinique', 'MU' => 'Mauritius', 'MR' => 'Mauritanië', 'MX' => 'Mexico', 'FM' => 'Micronesia', 'MD' => 'Moldavië', 'MC' => 'Monaco', 'MN' => 'Mongolië', 'ME' => 'Montenegro', 'MA' => 'Marokko', 'MZ' => 'Mozambique', 'MM' => 'Myanmar(Burma)', 'NA' => 'Namibië', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Nederland', 'AN' => 'Nederlandse Antillen', 'NC' => 'Nieuw-Caledonië', 'NZ' => 'Nieuw-Zeeland', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'XI' => 'Northern Ireland', 'MP' => 'Noordelijke Marianen', 'NO' => 'Noorwegen', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PS' => 'Palestine', 'PA' => 'Panama', 'PG' => 'Papoea-Nieuw-Guinea', 'PY' => 'Paraguay', 'PE' => 'Peru', 'PH' => 'Filipijnen', 'PL' => 'Polen', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'CG' => 'Republic of the Congo', 'RN' => 'Réunion', 'RO' => 'Roemenië', 'RU' => 'Rusland', 'RW' => 'Rwanda', 'ST' => 'Sao Tomé en Principe', 'KN' => 'Saint Kitts en Nevis', 'LC' => 'Saint Lucia', 'VC' => 'Saint Vincent en de Grenadines', 'WS' => 'Samoa', 'SM' => 'San Marino', 'SA' => 'Saudi-Arabië', 'XS' => 'Scotland', 'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seychellen', 'SL' => 'Sierra Leone', 'SG' => 'Singapore', 'SK' => 'Slowakije', 'SI' => 'Slovenië', 'SB' => 'Salomonseilanden', 'SO' => 'Somalië', 'ZA' => 'Zuid-Afrika', 'KR' => 'Zuid-Korea', 'ES' => 'Spanje', 'LK' => 'Sri Lanka', 'SD' => 'Sudan', 'SR' => 'Suriname', 'SZ' => 'Swaziland', 'SE' => 'Zweden', 'CH' => 'Zwitserland', 'SY' => 'Syrië', 'TW' => 'Taiwan', 'TJ' => 'Tadzjikistan', 'TZ' => 'Tanzania', 'TH' => 'Thailand', 'TL' => 'Timor-Leste', 'TG' => 'Togo', 'TO' => 'Tonga', 'TT' => 'Trinidad en Tobago', 'TN' => 'Tunesië', 'TR' => 'Turkije', 'TM' => 'Turkmenistan', 'TV' => 'Tuvalu', 'VI' => 'Amerikaanse Maagdeneilanden', 'UG' => 'Uganda', 'UA' => 'Oekraïne', 'AE' => 'Verenigde Arabische Emiraten', 'GB' => 'Verenigd Koninkrijk', 'US' => 'Verenigde Staten', 'UY' => 'Uruguay', 'UZ' => 'Oezbekistan', 'VU' => 'Vanuatu', 'VA' => 'Vaticaanstad', 'VE' => 'Venezuela', 'VN' => 'Vietnam', 'XW' => 'Wales', 'YE' => 'Jemen', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe' );

			//get local language default=en
			$locale_lang = ( $language=='' ) ? substr( get_locale(), 0, 2 ) : $language ;
			if( array_key_exists( $locale_lang, $all_countries_array_i18n ) ){
				$all_countries_array = $all_countries_array_i18n[$locale_lang];
			}else{
				$all_countries_array = $all_countries_array_i18n['en'];
			}
		
		//ZZZ sort countries AÄBC
		if( $sort_abc ){
			//http://sgehrig.wordpress.com/2008/09/24/on-how-to-sort-an-array-of-utf-8-strings/
			//Does NOT work on windows systems
			
			//$oldlocale=setlocale(LC_COLLATE, "0");
			//setlocale(LC_COLLATE, get_locale().'utf8');
			//usort( $all_countries_array, 'strcoll' );
			//setlocale (LC_COLLATE, $oldlocale);
			//print_r(system('locale -a'));
			 
			setlocale (LC_COLLATE, get_locale());
			
			asort( $all_countries_array, SORT_LOCALE_STRING ); //DOES not work with German-UMLAUTE 
		}
	if($meta_box){
		$all_countries_array = $this->format_array( $all_countries_array, 2 );
	}
	return apply_filters( 'all_countries', $all_countries_array );
	}//END function

	/**
	 * format array for dropdown with Please select
	 *
	 * @since    1.0.0
	 */
    public function format_array( $related_post, $mode = 1 ) {

        $var_array = array(
        		array( 'name' => __( 'Please select', 'the-events-calendar-extension-registration' ), 'value' => -1 )
        	);

        if( $mode == 1 ) {
	        foreach( $related_post as $value ) {
	            $var_array[] = array( 'name' => $value['post_title'], 'value' => $value['id'] );
	        }
        } else {
        	 foreach( $related_post as $key => $value ) {
	            $var_array[] = array( 'name' => $value, 'value' => $key );
	        }
        }
        return $var_array;
    }

    /**
	 * function to round currency formats
	 *
	 * @since     1.0.0
	 */
	public function currency_format( $money = 0.00, $currency = '&euro;' ){
		//get curreny symbol from Admin Options
		$options = maybe_unserialize( get_option( $this->plugin_slug.'options' ) );
		$currency = $options['currency'];

		$money = sanitize_text_field( $money );
		$money = round( $money, 2 );
		if ( $options['currency'] =='$'){
			$money = number_format( $money, 2, ".", "," ); 
			$money = preg_replace( '/.00/','.-', $money );
			$out = $currency." ".$money; 
		}else{
			$money = number_format( $money, 2, ",", "." ); 
			$money = preg_replace( '/,00/',',-', $money );
			$out = $money." ".$currency; 
		}		

	return $out;	
	}

}
