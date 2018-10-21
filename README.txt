=== The Events Calendar Extension: Registration ===

Contributors: e-colori, nicogee
Donate link: http://wordpress.e-colori.com/
Tags: events, signup, registration, the events calendar, extension, event registration, workshop registration
Requires at least: 4.2
Tested up to: 4.9.4
Stable tag: 1.6.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Registration (sign up) extension for 'The Events Calendar'. Let visitors sign up and send an automatic confirmation email.

== Description ==

This plugin is an extension for 'The Events Calendar' to receive registrations for events as email.

You can use a shortcode [wpecr_registration_button] to insert a registration (order) button for each event. If clients click the registration button, they get to a registration form (shortcode [wpecr_registration] for the form page with the permalin 'www.your-website.com/registration'), where they can insert their personal data. After the registration is completed, the client and yourself receive a confirmation email for the event registration with payment details.

The confirmation email text for the event registration can be customized on the plugins settings page in the wordpress admin.

Requirements: 'The Events Calendar' plugin (https://wordpress.org/plugins/the-events-calendar/) is already installed and activated.

== Installation ==

How to install the plugin 'The Events Calendar Extension: Registration' and get it working?

1. Upload the folder 'wp-event-registration' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Enter your personal details and options on the settings page of the plugin
4. Insert the shortcode [wpecr_registration_button] on the event page of 'The Events Calendar' you want to allow customers to registrate.
5. Create a page for the registration form with the slug "/registration/" and insert the shortcode [wpecr_registration]. The button will redirect to this page.
6. Test if you receive the registration emails and everything is shown correctly in the email.
7. Enjoy the plugin! Support the future development of the plugin with feature requests, translations and donations.

== Frequently Asked Questions ==

= 1. How do I show the registration button? =

Insert the shortcode [wpecr_registration_button] on the event page (of 'The Events Calendar')

= 2. Why do I get a 404 page after clicking the registration button? =

You forgot to create a page for the registration form with the permalink "/registration/" and insert the shortcode [wpecr_registration].

= 3. I'm interested in a PRO version, a new feature for the plugin or I have another questions, how can I get in contact? =

Just write us an email wordpress@e-colori.com or leave a comment on the plugins page.

= Support Us =
Support the future development of the plugin with feature requests, translations and donations.
go to: http://wordpress.e-colori.com/

== Screenshots ==

1. The registration button
2. The registration form, after clicking on the button
3. Admin area for confirmation email
4. That's how you insert the registration button
5. That's how you insert the registration form

== Changelog ==

= 1.6 =
* added more settings options
* added more flexibiliy to edit the text of the form
* added css grid to display form in two columns
* minor text changes and translations

= 1.5.2 =
* added settings options
* added participants input field
* added new_date variable for event

= 1.5.1 =
* fixed textdomain problem for the repository to get translations from the community

= 1.5 =
* fixed typos
* changed textdomain from "wpecr" to "the-events-calendar-extension-registration" so it can be translated in the repository (has to be the same)
* fixed header email information for Owner without "\r\n" (thanks to Leonardo Gaiero)
* More help links and links to the support forum, review on wordpress.org

= 1.4 =
* fixed sidebar bug
* more css ids in form
* added more languages now: German, Spanish, French, Russian, Dutch

= 1.3 =
* added new admin menu entry
* added signups menu entry
* added pro teaser
* typo fixes

= 1.2 =
* fixed sidebar bug
* added thumbnail
* minor fixes

= 1.1 =
version change

= 1.0.1 =
* changed description
* added screenshots
* minor bugfixes

= 1.0.0 =
* Initial Commit