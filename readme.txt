=== Contact Form Manager ===
Contributors: f1logic
Donate link: http://xyzscripts.com/donate/

Tags: contact form, contact page, contact manager, contact form manager, multiple contact forms, contact form with recaptcha, contact form date picker, custom contact form, contact form with auto reply
Requires at least: 2.8
Tested up to: 3.3.1
Stable tag: 1.0.2

Create and manage custom contact forms for your website.  Choose from a wide range of form elements .

== Description ==

Create and manage multiple contact forms for your website. The contact form manager plugin supports a wide range of contact form elements such as text field, email field, textarea, dropdown list, radio button, checkbox, date picker, captcha, file uploader etc. Shortcodes are generated such that, you can modify form element properties without having to replace the shortcode everytime. 

= Features =

    Full control on Contact Form
    Multiple Contact Forms
    Support the form elements text, email, text area, dropdown, checkbox, radiobutton, date, captcha, file upload and submit button
    Auto save contact forms
    Multi language support
    Edit the contact form without modifying the short code
    Autoreply feature
    Redirection after submission feature
    Standard captcha and reCaptcha options
    Style class integration option with form elements
    Option to add * (star symbol) for mandatory fields
    Tiny MCE filter option
    Shortcodes for contact forms
    Visual HTML editor for beautiful contact forms



= About =

Contact Form  Manager is developed and maintained by [XYZScripts](http://xyzscripts.com/ "xyzscripts.com"). For any support, you may [contact us](http://xyzscripts.com/support/ "XYZScripts Support").

== Installation ==

1. Extract `contact-form-manager.zip` to your `/wp-content/plugins/` directory.
2. In the admin panel under plugins activate Contact Form Manager.
3. You can configure the basic settings from XYZ Contact menu.
4. Once settings are done, you may create contact forms and place the shortcodes of require pages
5. Please configure required keys if you plan to use recpatcha

If you need any further help, you may contact our [support desk](http://xyzscripts.com/support/ "XYZScripts Support").

== Frequently Asked Questions ==

= 1. The Contact Form Manager is not working properly. =

Please check the wordpress version you are using. Make sure it meets the minimum version recommended by us. Make sure all files of the `contact form manager` plugin uploaded to the folder `wp-content/plugins/`

= 2. Why are the emails are not being sent ? =

Please ensure that PHP mail() function is enabled in your server. Also some servers enforce a validation which requires that the sender email address must belong to same domain,ie, if your site is xyz.com, then the sender email must be someone@xyz.com 

= 3. How can I display the contact form in my website ? =

First you need to create a new contact form. Now in the XYZ Contact > Contact Forms page you can see the newly created contact for and its short code. Please copy this short code and paste in your contact page.


= 4. How can I add a field to my contact form ? =

To add a new field in the contact form, please click the edit contact form or add a new contact form link. Now you can see a section Form Elements and in this please select the Add Elements. No you can select the tag and create a new element or field.

= 5. Should I edit my contact page after editing the contact form element settings ? =

No. There is no need to edit the contact page after editing the contact form options. It will update automatically and saves you from the trouble of replacing the code everytime.


= 6. How should I get a mail with all the fields used in the form ? =

In the mail settings, please use all the codes of the fields you have used in the contact field. Please make sure that you have added all the tag codes (the code will be like [text-1], [email-2] etc.) in the email body. Custom fields like captcha and submit button cannot be used in mail.


= 7. Can I embed the contact form into my template file ? =


Yes, you can embed the contact form into your template file. You cannot directly add the shortcode in the template file but you will need to pass the code into do_shortcode() function and display its output like this:

<?php echo do_shortcode( '[xyz-cfm-form id=1]' ); ?>


= 8. I want to use contact form in my language, not in English. How can I do that ? =

Please check the first part of our user guide for changing language details.


= 9. CAPTCHA does not work =

We are using 2 types of captcha in the contact form

    Standard captcha

    reCaptcha

If you are using the standard captcha, you need GD and FreeType library installed on your server.

If you are using the reCaptcha, please make sure that you have configured the public key and private key.


= 10. Site Admin is not receiving any mail using the contact form =


In the contact form 'Mail to site admin' section, you need to add the 'from email' address. Since you want the message from your users email id, we are using the code of the user email here. The code is something like [email-2].

But in some server, they don't allow to send emails with from addresses that are outside the server domain. So in such conditions, you need to add your own email address with the same domain extension of your server in the 'from email' section.

More questions ? [Drop a mail](http://xyzscripts.com/members/support/ "XYZScripts Support") and we shall get back to you with the answers.


== Screenshots ==

1. This is the form configuration page.
2. This is a sample contact form.

== Changelog ==

= 1.0 =
* First official launch.

== Upgrade Notice ==

== More Information ==

= Troubleshooting =

Please read the FAQ first if you are having problems.

= Requirements =

    WordPress 2.8+
    PHP 5+ 

= Feedback =

We would like to receive your feedback and suggestions. You may submit them at our [support desk](http://xyzscripts.com/members/support/ "XYZScripts Support").
