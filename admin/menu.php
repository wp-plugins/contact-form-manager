<?php

if ( is_admin() ){

	add_action('admin_menu', 'cfm_menu');
}

function cfm_menu(){
	
	add_menu_page('contact-form-manager', 'XYZ Contact', 'manage_options', 'contact-form-manager-manage','cfm_settings',plugins_url('contact-form-manager/images/contact.png'));
	
	add_submenu_page('contact-form-manager-manage','Settings', 'Settings', 'manage_options', 'contact-form-manager-manage','cfm_settings');
	
	//add_submenu_page('contact-form-manager-manage', 'Add SMTP Account', 'Add SMTP Account', 'manage_options', 'contact-form-manager-add-smtp' ,'cfm_add_smtp');
	
	add_submenu_page('contact-form-manager-manage', 'SMTP Settings', 'SMTP Settings', 'manage_options', 'contact-form-manager-manage-smtp' ,'cfm_manage_smtp');
	
	add_submenu_page('contact-form-manager-manage', 'Manage Contact Forms', 'Contact Forms', 'manage_options', 'contact-form-manager-managecontactforms' ,'cfm_manageforms');
	
	//add_submenu_page('contact-form-manager-manage', 'Add Contact Form', 'Add Contact Form', 'manage_options', 'contact-form-manager-addcontactform' ,'cfm_addcontactform');
	
	add_submenu_page('contact-form-manager-manage', 'About', 'About', 'manage_options', 'contact-form-manager-about' ,'cfm_about');
	
}
function cfm_settings(){
	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/setting.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}



function cfm_manage_smtp(){
	require( dirname( __FILE__ ) . '/header.php' );

	$smtpflag=0;
	if(isset($_GET['action']) && ($_GET['action']=='smtp-block' || $_GET['action']=='smtp-activate')){
		include(dirname( __FILE__ ) . '/smtp_status.php');
		$smtpflag=1;
	}
	
	if(isset($_GET['action']) && $_GET['action']=='add-smtp' ){
		include( dirname( __FILE__ ) . '/add_smtp.php' );
		$smtpflag=1;
	}

	if(isset($_GET['action']) && $_GET['action']=='smtp-edit' ){
		include(dirname( __FILE__ ) . '/smtp_edit.php');
		$smtpflag=1;
	}

	if(isset($_GET['action']) && $_GET['action']=='smtp-delete' ){
		include(dirname( __FILE__ ) . '/smtp_delete.php');
		$smtpflag=1;
	}

	if($smtpflag==0){
		require( dirname( __FILE__ ) . '/manage_smtp.php' );
	}
	require( dirname( __FILE__ ) . '/footer.php' );
}

function cfm_manageforms(){
	$formflag = 0;
	if(isset($_GET['action']) && $_GET['action']=='form-delete' )
	{
		include(dirname( __FILE__ ) . '/form-delete.php');
		$formflag=1;
	}
	if(isset($_GET['action']) && $_GET['action']=='form-edit' )
	{
		require( dirname( __FILE__ ) . '/header.php' );
		include(dirname( __FILE__ ) . '/form-edit.php');
		require( dirname( __FILE__ ) . '/footer.php' );
		$formflag=1;
	}
	if(isset($_GET['action']) && $_GET['action']=='form-add' )
	{
		require( dirname( __FILE__ ) . '/header.php' );
		require( dirname( __FILE__ ) . '/add-contact-form.php' );
		require( dirname( __FILE__ ) . '/footer.php' );
		$formflag=1;
	}
	if($formflag == 0){
		require( dirname( __FILE__ ) . '/header.php' );
		require( dirname( __FILE__ ) . '/manage-contact-forms.php' );
		require( dirname( __FILE__ ) . '/footer.php' );
	}
}

function cfm_about(){
	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/about.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}


wp_enqueue_script('jquery');

if(is_admin()){

	function xyz_cfm_add_style_script(){
		
		wp_register_script( 'xyz_notice_script', plugins_url('contact-form-manager/js/notice.js') );
		wp_enqueue_script( 'xyz_notice_script' );
		
		wp_register_script( 'xyz_tooltip_script', plugins_url('contact-form-manager/js/tooltip.js') );
		wp_enqueue_script( 'xyz_tooltip_script' );
		
		// Register stylesheets
		wp_register_style('xyz_cfm_style', plugins_url('contact-form-manager/css/xyz_cfm_styles.css'));
		wp_enqueue_style('xyz_cfm_style');
	}
	add_action('admin_enqueue_scripts', 'xyz_cfm_add_style_script');

}



function xyz_cfm_shortcode_style(){
	// Register stylesheets
	wp_register_style('xyz_cfm_short_code_style', plugins_url('contact-form-manager/css/xyz_cfm_shortcode_style.css'));
	wp_enqueue_style('xyz_cfm_short_code_style');
	
	if (stripos(get_option('siteurl'), 'https://') === 0)
		$css_cfm_url = 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css';
	else
		$css_cfm_url = 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css';
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('jquery-style', $css_cfm_url);
}
add_action('init', 'xyz_cfm_shortcode_style');




?>