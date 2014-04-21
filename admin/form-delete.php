<?php
global $wpdb;
$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);

$xyz_cfm_formId = $_GET['id'];
$xyz_cf_pageno = absint($_GET['pageno']);
if($xyz_cfm_formId=="" || !is_numeric($xyz_cfm_formId)){
	header("Location:".admin_url('admin.php?page=contact-form-manager-manage'));
	exit();

}
$formCount = $wpdb->query( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."xyz_cfm_form WHERE id= %d LIMIT %d,%d",$xyz_cfm_formId,0,1) ) ;

if($formCount==0){
	header("Location:".admin_url('admin.php?page=contact-form-manager-manage'));
	exit();
}else{
	$wpdb->query( $wpdb->prepare( "DELETE FROM ".$wpdb->prefix."xyz_cfm_form_elements WHERE form_id= %d",$xyz_cfm_formId) ) ;
	$wpdb->query( $wpdb->prepare( "DELETE FROM ".$wpdb->prefix."xyz_cfm_form WHERE id= %d",$xyz_cfm_formId) ) ;

	header("Location:".admin_url('admin.php?page=contact-form-manager-managecontactforms&msg=1&pagenum='.$xyz_cf_pageno));
	exit();

}
?>