<?php 

function cfm_network_uninstall($networkwide) {
	global $wpdb;

	if (function_exists('is_multisite') && is_multisite()) {
		// check if it is a network activation - if so, run the activation function for each blog id
		if ($networkwide) {
			$old_blog = $wpdb->blogid;
			// Get all blog ids
			$blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				cfm_uninstall();
			}
			switch_to_blog($old_blog);
			return;
		}
	}
	cfm_uninstall();
}

function cfm_uninstall(){

global $wpdb;

$pluginName = 'xyz-wp-contact-form/xyz-wp-contact-form.php';
if (is_plugin_active($pluginName)) {
    return;
}

/* table delete*/


$wpdb->query("DROP TABLE ".$wpdb->prefix."xyz_cfm_form");

$wpdb->query("DROP TABLE ".$wpdb->prefix."xyz_cfm_form_elements");

$wpdb->query("DROP TABLE ".$wpdb->prefix."xyz_cfm_sender_email_address");


/* delete options*/

delete_option("xyz_cfm_paging_limit");
delete_option("xyz_cfm_tinymce_filter");
delete_option("xyz_cfm_mandatory_sign");
if(get_option('xyz_credit_link') == "cfm"){
	update_option('xyz_credit_link', 0);
}

delete_option('xyz_cfm_recaptcha_private_key');
delete_option('xyz_cfm_recaptcha_public_key');

delete_option('xyz_cfm_sendViaSmtp');
delete_option('xyz_cfm_SmtpDebug');
delete_option('xyz_cfm_DateFormat');

}


	register_uninstall_hook( XYZ_CFM_PLUGIN_FILE, 'cfm_network_uninstall' );

?>