<?php
require( dirname( __FILE__ ) . '../../../../../wp-load.php' );
if(!current_user_can('manage_options')){
	exit;
}
global $wpdb;

if($_POST){
	$_POST = stripslashes_deep($_POST);
	$_POST = xyz_trim_deep($_POST);
			
	$formId = $_POST['formId'];
	$elementId = $_POST['elementId'];

	$wpdb->query('DELETE FROM '.$wpdb->prefix.'xyz_cfm_form_elements where id="'.$elementId.'" AND form_id="'.$formId.'"');

}

?>