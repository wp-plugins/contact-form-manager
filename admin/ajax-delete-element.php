<?php
add_action('wp_ajax_ajax_delete_element', 'xyz_cfm_ajax_delete_element');

function xyz_cfm_ajax_delete_element() {
	

global $wpdb;

if($_POST){
	$_POST = stripslashes_deep($_POST);
	$_POST = xyz_trim_deep($_POST);
			
	$formId = $_POST['formId'];
	$elementId = $_POST['elementId'];
	
	
	$wpdb->query($wpdb->prepare( "DELETE FROM ".$wpdb->prefix."xyz_cfm_form_elements WHERE id= %d AND form_id= %d", $elementId,$formId));

}
die();
}
?>