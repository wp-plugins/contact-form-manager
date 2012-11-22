<?php 
global $wpdb;

$totalDetails = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."xyz_cfm_form WHERE status='1'" );
if(count($totalDetails)>0){
	foreach ($totalDetails as $total){
		add_shortcode('xyz-cfm-form','display_form');		
	}
}

