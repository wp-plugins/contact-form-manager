=== Contact Form Manager ===
Contributors: f1logic
Donate link: http://xyzscripts.com/donate/
Tags: contact, contact form, contact forms, contact form plugin,  contact form manager, contact page,  multiple contact forms, custom contact form, contact form with auto reply, contact form with recaptcha, contact form builder, contact us,  contact manager, wordpress contact
Requires at least: 2.8
Tested up to: 3.9
Stable tag: 1.4.1
License: GPLv2 or later

Create contact forms for your website.  Choose from a wide range of form elements .

== Description ==

A quick look into Contact Form Manager :

	★ HTML editor to design contact form content
	★ Customize contact form fields without replacing shortcode everytime
	★ Supports text field,textarea,email field,dropdown,radiobutton,checkbox,date picker & file uploader
	★ Recpatcha/image verification for spam control
	★ Multiple custom contact forms with shortcode support
	★ Auto-reply, redirection options on submit
	★ Customizable mail body
	★ SMTP mail settings


= Contact Form Manager Features in Detail =

The Contact Form Manager lets you create and manage multiple customized contact forms for your website. It supports a wide range of contact form elements such as text field, email field, textarea, dropdown list, radio button, checkbox, date picker, captcha, file uploader etc. Shortcodes are generated such that, you can modify contact form element properties without having to replace the shortcode everytime. The contact form manager also supports auto responder and  flexible redirection options on form submission.

The prominent features of  the contact form manager plugin are highlighted below.

= Supported Contact Form Elements =

The various form elements supported in contact form manager are listed below. If you need more fields, do checkout the [premium version](http://xyzscripts.com/wordpress-plugins/xyz-wp-contact-form/details "XYZ WP Contact Form") of this plugin. 

    Text field
    Email field
    Textarea
    Dropdown List
    Checkbox
    Radiobutton
    Date picker
    Captcha
    File Uploader
    Submit Button

= Contact Form Content =

    Full control on contact form content
    Support for shortcode from other plugins in contact form content
    Visual HTML editor for beautiful contact forms
    Style class integration option with contact form elements
    Option to add * (star symbol) for mandatory contact form fields
    Auto-save contact form elements on creation
    Multi language support for contact form messages
    Multiple Contact Forms

= Spam Control =

    Simple image verification
    Recaptcha support
    SMTP Email Settings

= Contact Form Display =	

    Shortcodes for displaying contact forms
    Modify contact form element options without replacing shortcode

= Contact Form Submission =

    Autoreply on contact form submission
    Redirection after contact form submission 


= About =

Contact Form  Manager is developed and maintained by [XYZScripts](http://xyzscripts.com/ "xyzscripts.com"). For any support, you may [contact us](http://xyzscripts.com/support/ "XYZScripts Support").

★ [Contact Form Manager User Guide](http://docs.xyzscripts.com/wordpress-plugins/contact-form-manager/ "Contact Form Manager User Guide")
★ [Contact Form Manager FAQ](http://kb.xyzscripts.com/wordpress-plugins/contact-form-manager/ "Contact Form Manager FAQ")

== Installation ==

★ [Contact Form Manager User Guide](http://docs.xyzscripts.com/wordpress-plugins/contact-form-manager/ "Contact Form Manager User Guide")
★ [Contact Form Manager FAQ](http://kb.xyzscripts.com/wordpress-plugins/contact-form-manager/ "Contact Form Manager FAQ")

1. Extract `contact-form-manager.zip` to your `/wp-content/plugins/` directory.
2. In the admin panel under plugins activate Contact Form Manager.
3. You can configure the basic settings from XYZ Contact menu.
4. Once settings are done, you may create contact forms and place the shortcodes on required pages
5. Please configure required keys if you plan to use recpatcha

If you need any further help, you may contact our [support desk](http://xyzscripts.com/support/ "XYZScripts Support").

== Frequently Asked Questions ==

★ [Contact Form Manager User Guide](http://docs.xyzscripts.com/wordpress-plugins/contact-form-manager/ "Contact Form Manager User Guide")
★ [Contact Form Manager FAQ](http://kb.xyzscripts.com/wordpress-plugins/contact-form-manager/ "Contact Form Manager FAQ")

= ★ I can't see my  contact forms after I upgraded to latest version ! ★ =

Please deactivate and reactivate the plugin. All your contact  forms should come back. If they don't, please contact our  [support desk](http://xyzscripts.com/support/ "XYZScripts Support").


= 1. The Contact Form Manager is not working properly. =

Please check the wordpress version you are using. Make sure it meets the minimum version recommended by us. Make sure all files of the `contact-form-manager` plugin are uploaded to the folder `wp-content/plugins/`


= 2. How can I display the contact form in my website ? =

First you need to create a new contact form. Now in the XYZ Contact > Contact Forms page you can see the newly created contact form and its short code. After making any necessary changes to the contact form save the contact form. Please copy the short code and paste in your contact page.


= 3. How can I add a field to my contact-form ? =

To add a new field in the contact form, please click the edit contact form or add a new contact form link. Now you can see a section Form Elements and from here please select the Add Elements. Now you can select and create a new element or field. Once the new  form field is created, copy the shortcode of the field to contact form content.

= 4. Should I replace my contact form shortcode after editing the contact form element settings ? =

No. There is no need to replace the contact form shortcode after editing the contact form elements. It will update automatically and saves you from the trouble of replacing the code everytime.


= 5. How can I get a mail with user submitted values of all fields used in the contact-form ? =

In the mail content, please use all the shortcodes corresponding to the fields you have used in the contact form. Please make sure that you have added all the form field shortcodes (the code will be like [text-1], [email-2] etc.) in the email body. Custom fields like captcha and submit button cannot be used in mail.


= 6. Can I embed the contact-form into my template file ? =


Yes, you can embed the contact form into your template file. You cannot directly add the shortcode of the contact form in the template file but you will need to pass the code into do_shortcode() function and display its output like this:

<?php echo do_shortcode( '[xyz-cfm-form id=1]' ); ?>


= 7. I want to use contact-form in my language, not in English. How can I do that ? =

For changing language of contact form, please check the [how-to-change-the-language-in-contact-form-manager](http://docs.xyzscripts.com/contact-form-manager/how-to-change-the-language-in-contact-form-manager/ "Contact Form Manager Documentation - Changing Language") section in our docs.


= 8. Why is not CAPTCHA working in my contact-form ? =

We are using 2 types of captcha in the contact form plugin.

    Simple image verification

    Recaptcha

If you are using the standard captcha, you need GD and FreeType library installed on your server.

If you are using the recaptcha, please make sure that you have configured the public key and private key.


= 9. Why is site admin not receiving any mail from the contact-form ? =


While editing the 'Mail to site admin' section of a contact form, you need to specify the 'from email' address. Since you want the message from your visitor's email id, we are using the shortcode of the user email field here. The code is something like [email-2].

But in some servers, the host does not allow to send emails with from addresses that are outside the server domain. So in such conditions, you need to add an email address of your own  domain in the 'from email' section.

= 10. Does the contact-form plugin save the contact requests in database so that admin can view it from admin panel ? =

Yes, you need to purchase the premium version of contact form manager plugin to have this feature.

= 11. Is it possible to duplicate a contact-form with its current settings ? =

Yes, we have this feature in the premium  version of contact form plugin.

= 12. Where can i get the premium version of contact-form-manager ? =

The premium version of contact form manager can be purchased from our site [xyzscripts.com](http://xyzscripts.com/wordpress-plugins/xyz-wp-contact-form/ "XYZ WP Contact Form").

More questions ? [Drop a mail](http://xyzscripts.com/members/support/ "XYZScripts Support") and we shall get back to you with the answers.


== Screenshots ==

1. This is the contact-form configuration page.
2. This is a sample contact-form.

== Changelog ==

= Contact Form Manager 1.4.1 =
* Added compatibility with wordpress 3.9

= Contact Form Manager 1.4 =
* Epoch calendar replaced with jquery calendar
* Auto focus to first error element upon form submit
* Option to disable premium version ads
* A few bug fixes

= Contact Form Manager 1.3.2 =
* Fix for newsletter subscription related bug
* Fix for form redisplay related bug

= Contact Form Manager 1.3.1 =
* Option for bcc email with mulitiple emailid support
* A few bug fixes 

= Contact Form Manager 1.3 =
* Support for subscribing contact to XYZ Newsletter Manager plugin
* Option to specify separate sender email in case of SMTP sending
* Consolidated client side error messages on form submit instead of individual error messages
* A few bug fixes 

= Contact Form Manager 1.2.1 =
* A few bug fixes 

= Contact Form Manager 1.2 =
* Support for Wordpress table prefix 
* Support for shortcode from other plugins in form content.
* Option to delete form elements
* Support for multiple css classnames for form fields  
* Support for default selection  in dropdown,checkbox,radiobutton
* Support for multi-select in dropdown
* Support for multi-line view in checkbox,radiobutton
* Support for key=>value format for comma separated values in checkbox, radiobutton and dropdown
* Allow html tag in checkbox, radiobutton, dropdown text thereby providing support for images and style classes
* Option to specify date format for date field
* Support for multiple "to" && "cc"  email by separating with commas
* Option to specify  user submitted  values as "To Email"  and "CC" in email to admin
* Option to specify  user submitted  values as "Sender Email"  and "Reply Sender Name" in auto reply to user
* Option to specify  user submitted  values  in redirection url
* Option to re-display empty form after submission
* Fix for resubmission of on pressing F5  


= Contact Form Manager 1.1 =
* Support for SMTP mailing
* Support for multiple contact forms in same page
* 9 preloaded language files  
* Fix for char encoding in emails
* A few other bug fixes

  
= Contact Form Manager 1.0 =
* First official launch.

== Upgrade Notice ==

= Contact Form Manager 1.3.1 =
Some bugs have been fixed and  "bcc" option with multiple email support has been added.

== More Information ==

★ [Contact Form Manager User Guide](http://docs.xyzscripts.com/wordpress-plugins/contact-form-manager/ "Contact Form Manager User Guide")
★ [Contact Form Manager FAQ](http://kb.xyzscripts.com/wordpress-plugins/contact-form-manager/ "Contact Form Manager FAQ")

= Troubleshooting =

Please read the FAQ first if you are having problems.

= Requirements =

    WordPress 3.0+
    PHP 5+ 

= Feedback =

We would like to receive your feedback and suggestions about Contact Form Manager plugin. You may submit them at our [support desk](http://xyzscripts.com/members/support/ "XYZScripts Support").
