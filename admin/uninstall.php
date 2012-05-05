<?php 

function cfm_uninstall(){

global $wpdb;

/* table delete*/


$wpdb->query("DROP TABLE xyz_cfm_form");

$wpdb->query("DROP TABLE xyz_cfm_form_elements");


/* delete options*/

delete_option("xyz_cfm_paging_limit");
delete_option("xyz_cfm_tinymce_filter");
delete_option("xyz_cfm_mandatory_sign");
delete_option("xyz_cfm_credit_link");

delete_option('xyz_cfm_recaptcha_private_key');
delete_option('xyz_cfm_recaptcha_public_key');

}
?>