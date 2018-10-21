<?php
/**
 * Represents the view for the administration options page.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package    The Events Calendar Extension: Registration
 * @author     Tobias Fritz - http://wordpress.e-colori.com
 * @since      1.0.0
 * @link       http://wordpress.e-colori.com
 * @copyright  2015 e-colori.com
 * @subpackage /admin/partials
 */

$checked_showbank = !empty($options['showbank'] ) ? 'checked="checked"' : '';
$checked_showterms = !empty( $options['showterms'] ) ? 'checked="checked"' : '';
$checked_support =  !empty( $options['support'] ) ? 'checked="checked"' : '';
?>

<div class="wrap wpecr_wrapper">
<div class="column column-left">
	<h2><?php _e( 'Settings › \'The Events Calendar Extension: Registration\'', 'the-events-calendar-extension-registration' ); ?></h2>

	<form action="<?php echo admin_url( 'admin-post.php' ) ?>" method="POST">
		<input type="hidden" name="action" value="save_options">
		<?php wp_referer_field(1); ?>
		<hr>
		<h3 class="title"><?php _e( 'Email sender options', 'the-events-calendar-extension-registration' ) ?></h3>
		
		<table class="form-table">
			<tbody>
			<tr>
				<th scope="row">
					<label for="name"><?php _e( '"From" Name', 'the-events-calendar-extension-registration' ) ?></label>
				</th>
				<td>
					<input type="text" name="options[name]" id="name" class="regular-text" value="<?php echo $options['name']; ?>" >
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="email"><?php _e( '"From" Email Address', 'the-events-calendar-extension-registration' ) ?></label>
				</th>
				<td>
					<input type="text" name="options[email]"  id="email" class="regular-text" value="<?php echo $options['email'] ?>" >
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php _e( 'Text before form', 'the-events-calendar-extension-registration' ) ?>
				</th>
				<td>
					<label for="before_txt"><?php _e( 'Enter the text to be shown before the form', 'the-events-calendar-extension-registration' ) ?></label>
					<?php wp_editor( stripslashes( $options['before_txt'] ), 'before_txt', array( 'textarea_name' => 'options[before_txt]', 'media_buttons' => true, 'tinymce' => true, 'textarea_rows' => 5 ) ); ?>
				</td>
			</tr>
            <tr>
                <th scope="row">
					<?php _e( 'Text after form', 'the-events-calendar-extension-registration' ) ?>
                </th>
                <td>
                    <label for="after_txt"><?php _e( 'Enter the text to be shown after the form', 'the-events-calendar-extension-registration' ) ?></label>
					<?php wp_editor( stripslashes( $options['after_txt'] ), 'after_txt', array( 'textarea_name' => 'options[after_txt]', 'media_buttons' => true, 'tinymce' => true, 'textarea_rows' => 5 ) ); ?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="terms"><?php _e( 'Message box', 'the-events-calendar-extension-registration' ) ?></label>
                </th>
                <td>
                    <input type="text" name="options[before_message]" id="before_message" class="regular-text" value="<?php echo $options['before_message'] ?>" >
                    <span class="description"><?php _e( 'Text before the Message box.', 'the-events-calendar-extension-registration' ) ?></span>
                </td>
            </tr>
            <tr>
				<th scope="row">
					<label for="terms"><?php _e( 'Terms URL', 'the-events-calendar-extension-registration' ) ?></label>
				</th>
				<td>
					<input type="text" name="options[terms]" id="terms" class="regular-text" value="<?php echo $options['terms'] ?>" >
					<span class="description"><?php _e( 'Create a page with your terms and conditions and instert the URL here.', 'the-events-calendar-extension-registration' ) ?></span>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php _e( 'Visibility terms URL', 'the-events-calendar-extension-registration' ) ?>
				</th>
				<td>
				<fieldset>
					<label for="showterms">
					<input type="checkbox" name="options[showterms]" id="showterms" value="1" <?php echo $checked_showterms ?> >
					<?php _e( 'Show term link on registration page', 'the-events-calendar-extension-registration' ) ?>
					</label>
				</fieldset>
				</td>				
			</tr>			
			<tr>
				<th scope="row">
					<?php _e( 'Email Footer Text', 'the-events-calendar-extension-registration' ) ?>
				</th>
				<td>
					<label for="email_txt"><?php _e( 'Enter your text and contact details you want to show at the end of the registration email', 'the-events-calendar-extension-registration' ) ?></label>
					<?php wp_editor( stripslashes( $options['email_txt'] ), 'email_txt', array( 'textarea_name' => 'options[email_txt]', 'media_buttons' => true, 'tinymce' => true, 'textarea_rows' => 8 ) ); ?>
				</td>
			</tr>	
			</tbody>
		</table>
		<hr>
		<h3 class="title"><?php _e( 'Bank account details', 'the-events-calendar-extension-registration' ) ?></h3>

		<table class="form-table">
			<tbody>
			<tr>
				<th scope="row">
					<?php _e( 'Visibility bank details', 'the-events-calendar-extension-registration' ) ?>
				</th>
				<td>
					<label for="showbank">
					<input type="checkbox" name="options[showbank]" id="showbank" value="1" <?php echo $checked_showbank ?> >
					<?php _e( 'Show bank details in email', 'the-events-calendar-extension-registration' ) ?>
					</label>
				</td>				
			</tr>

			<tr>
				<th scope="row">
					<label for="currency"><?php _e( 'Currency', 'the-events-calendar-extension-registration' ) ?></label>
				</th>
				<td>
					<input type="text" name="options[currency]" id="currency" class="regular-text" value="<?php echo $options['currency'] ?>" >
				</td>
			</tr>
			
			<tr>
				<th scope="row">
					<?php _e( 'Paymet Text', 'the-events-calendar-extension-registration' ) ?>
				</th>
				<td>
					<label for="bank_txt"><?php _e( 'Enter here the text to explain how to pay before showing the bank details', 'the-events-calendar-extension-registration' ) ?></label>
					<?php wp_editor( stripslashes( $options['bank_txt'] ), 'bank_txt', array( 'textarea_name' => 'options[bank_txt]', 'media_buttons' => false, 'teeny' => true, 'textarea_rows' => 4 )); ?>		
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="bank"><?php _e( 'Bank name', 'the-events-calendar-extension-registration' ) ?></label>
				</th>
				<td>
					<input type="text" name="options[bank]" id="bank" class="regular-text" value="<?php echo $options['bank'] ?>" >
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="remittee"><?php _e( 'Remittee', 'the-events-calendar-extension-registration' ) ?></label>
				</th>
				<td>
					<input type="text" name="options[remittee]" id="remittee" class="regular-text" value="<?php echo $options['remittee'] ?>" >
				</td>
			</tr>	
			<tr>
				<th scope="row">
					<label for="iban"><?php _e( 'IBAN', 'the-events-calendar-extension-registration' ) ?></label>
				</th>
				<td>
					<input type="text" name="options[iban]" id="iban" class="regular-text" value="<?php echo $options['iban'] ?>" >
				</td>
			</tr>	
			<tr>
				<th scope="row">
					<label for="bic"><?php _e( 'Swift / BIC Code', 'the-events-calendar-extension-registration' ) ?></label>
				</th>
				<td>
					<input type="text" name="options[bic]" id="bic" class="regular-text" value="<?php echo $options['bic'] ?>" >
				</td>
			</tr>
			</tr>	
			</tbody>
		</table>
		<hr>
		<h3 class="title"><?php _e( 'Extra', 'the-events-calendar-extension-registration' ) ?></h3>
		<table class="form-table">
			<tbody>
			<tr>
				<th scope="row">
					<?php _e( 'Show some love?', 'the-events-calendar-extension-registration' ) ?>
				</th>
				<td>
				<fieldset>
					<label for="support">
					<input type="checkbox" name="options[support]" id="support" value="1" <?php echo $checked_support ?> >
					<?php _e( 'Yes! Hundreds of free hours have gone into making this free plugin, show your support and add a small link to our plugin website at the bottom of your form.', 'the-events-calendar-extension-registration' ) ?>
					</label>
				</fieldset>
				</td>	
			</tr>			
			</tbody>
		</table>

		<button type="submit" class="button button-primary button-large"><?php _e( 'Save', 'the-events-calendar-extension-registration' ) ?></button>

	</form>
	</div> <!-- end .column-left -->
	<div class="column column-right">
		<div class="wpecr_box">
			<img src="<?php echo plugins_url( 'img/e-colori-com_wordpress-plugins.png', dirname(__FILE__) ) ?>" alt="www.e-colori.com" width="290" height="168" class="wpecr_img" id="wpecr_e-colori" />
			<h2><?php _e( 'Need Help?', 'the-events-calendar-extension-registration', 'the-events-calendar-extension-registration' ) ?></h2>
			<strong><?php _e( 'Do you have any problems or questions?', 'the-events-calendar-extension-registration', 'the-events-calendar-extension-registration' ) ?></strong>			
			<p><?php _e( 'Please only use the official WordPress support forum, for questions', 'the-events-calendar-extension-registration' ) ?></p>
			<h3><a href="https://wordpress.org/support/plugin/the-events-calendar-extension-registration/">Support (@wordpress.org)</a></h3>
			<br/>
			<p><strong><?php _e( 'Do you like our plugin?', 'the-events-calendar-extension-registration' ) ?></strong><br/><?php _e( 'Thank you for your positive review on', 'the-events-calendar-extension-registration' ) ?></p>
			<h3><a href="https://wordpress.org/support/plugin/the-events-calendar-extension-registration/reviews/">Review (@wordpress.org)</a></h3>
			<br/>
			<h3>&raquo; <?php _e( 'You have questions or a feature request for the plugin?', 'the-events-calendar-extension-registration' ) ?></h3>
			<h3><a href="http://wordpress.e-colori.com"><?php _e( 'Go to the plugin page', 'the-events-calendar-extension-registration' ) ?> &raquo;</a></h3>
			<h3><a href="http://wordpress.e-colori.com/the-events-calendar-extension-registration-pro/"><?php _e( 'Check out the PRO plugin', 'the-events-calendar-extension-registration' ) ?> &raquo;</a></h3>
		</div>
	</div> <!-- end .column-right -->
</div>