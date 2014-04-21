<?php

function cfm_network_install($networkwide) {
	global $wpdb;

	if (function_exists('is_multisite') && is_multisite()) {
		// check if it is a network activation - if so, run the activation function for each blog id
		if ($networkwide) {
			$old_blog = $wpdb->blogid;
			// Get all blog ids
			$blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				cfm_install();
			}
			switch_to_blog($old_blog);
			return;
		}
	}
	cfm_install();
}


function cfm_install(){
	
	$pluginName = 'xyz-wp-contact-form/xyz-wp-contact-form.php';
	if (is_plugin_active($pluginName)) {
		wp_die( "The plugin Contact Form Manager cannot be activated because you are using the premium version of this plugin. Back to <a href='".admin_url()."plugins.php'>Plugin Installation</a>." );
	}
	
	global $wpdb;
	$wpdb->show_errors();
	global $current_user; get_currentuserinfo();
	
	add_option("xyz_cfm_paging_limit",20);
	add_option("xyz_cfm_tinymce_filter",1);
	add_option("xyz_cfm_mandatory_sign",1);
	add_option("xyz_cfm_DateFormat",2);
	
	add_option("xyz_cfm_hidepmAds",0);
	
// 	add_option("xyz_cfm_credit_link",0);
	
	if(get_option('xyz_credit_link') == ""){
		if(get_option('xyz_cfm_credit_link') == 1){
			add_option("xyz_credit_link",'cfm');
		}else{
			add_option("xyz_credit_link",0);
		}
	}
	
	add_option('xyz_cfm_sendViaSmtp',0);
	add_option('xyz_cfm_SmtpDebug',0);
	
	$xyz_cfm_form = $wpdb->get_results('SHOW TABLE STATUS WHERE name="xyz_cfm_form"');
	if(count($xyz_cfm_form) > 0){
		$wpdb->query("RENAME TABLE xyz_cfm_form TO ".$wpdb->prefix."xyz_cfm_form");
	}else{
	
		$xyz_cfm_formExist = $wpdb->get_results('SHOW TABLE STATUS WHERE name="'.$wpdb->prefix.'xyz_cfm_form"');
		if(count($xyz_cfm_formExist) == 0){
		
			$queryForm = "CREATE TABLE IF NOT EXISTS  ".$wpdb->prefix."xyz_cfm_form (
			  `id` int NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `status` int NOT NULL,
			  `form_content` longtext COLLATE utf8_unicode_ci NOT NULL,
			  `submit_mode` int NOT NULL,
			  `to_email` text COLLATE utf8_unicode_ci NOT NULL,
			  `from_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `sender_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `reply_sender_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `reply_sender_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `cc_email` text COLLATE utf8_unicode_ci NOT NULL,
			  `mail_type` int NOT NULL,
			  `mail_subject` text COLLATE utf8_unicode_ci NOT NULL,
			  `mail_body` longtext COLLATE utf8_unicode_ci NOT NULL,
			  `to_email_reply` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `reply_subject` text COLLATE utf8_unicode_ci NOT NULL,
			  `reply_body` longtext COLLATE utf8_unicode_ci NOT NULL,
			  `reply_mail_type` int NOT NULL,
			  `enable_reply` int NOT NULL,
			  `redirection_link` text COLLATE utf8_unicode_ci NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ";
			$wpdb->query($queryForm);
		}
	}
	$group_flag=0;
	$tblcolums = $wpdb->get_col("SHOW COLUMNS FROM  ".$wpdb->prefix."xyz_cfm_form");
	if(in_array("from_email_id", $tblcolums))
		$group_flag=1;
	
	
	if($group_flag==0)
	{
		$wpdb->query("ALTER TABLE ".$wpdb->prefix."xyz_cfm_form ADD (`from_email_id` int not null default '0' ,`reply_sender_email_id` int not null default '0')");
		
	}
	
	$group_flag=0;
	$tblcolums = $wpdb->get_col("SHOW COLUMNS FROM  ".$wpdb->prefix."xyz_cfm_form");
	if(in_array("redisplay_option", $tblcolums))
		$group_flag=1;
	if($group_flag==0)
	{
		$wpdb->query("ALTER TABLE ".$wpdb->prefix."xyz_cfm_form ADD (`redisplay_option` int not null default 2)");
		
		
	}
	
	$group_flag=0;
	$tblcolums = $wpdb->get_col("SHOW COLUMNS FROM  ".$wpdb->prefix."xyz_cfm_form");
	if(in_array("newsletter_email_shortcode", $tblcolums))
		$group_flag=1;
	
	
	if($group_flag==0)
	{
		$wpdb->query("ALTER TABLE ".$wpdb->prefix."xyz_cfm_form ADD
				(`newsletter_email_shortcode` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
				`newsletter_email_list` text COLLATE utf8_unicode_ci NOT NULL,
				`newsletter_custom_fields` text COLLATE utf8_unicode_ci NOT NULL,
				`newsletter_optin_mode` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
				`newsletter_subscription_status` int(11) NOT NULL )");
		
	}
	
	
	$group_flag=0;
	$tblcolums = $wpdb->get_col("SHOW COLUMNS FROM  ".$wpdb->prefix."xyz_cfm_form");
	if(in_array("bcc_email", $tblcolums))
		$group_flag=1;
	
	
	if($group_flag==0)
	{
		$wpdb->query("ALTER TABLE ".$wpdb->prefix."xyz_cfm_form ADD (`bcc_email` text COLLATE utf8_unicode_ci NOT NULL)");
		
	}
	
	
	/*for newsletter subscription*/
	
	
	
	$xyz_cfm_FormElements = $wpdb->get_results('SHOW TABLE STATUS WHERE name="xyz_cfm_form_elements"');
	if(count($xyz_cfm_FormElements) > 0){
		$wpdb->query("RENAME TABLE xyz_cfm_form_elements TO ".$wpdb->prefix."xyz_cfm_form_elements");
	}else{
	
		$xyz_cfm_FormElementsExist = $wpdb->get_results('SHOW TABLE STATUS WHERE name="'.$wpdb->prefix.'xyz_cfm_form_elements"');
		if(count($xyz_cfm_FormElementsExist) == 0){
	
			$queryFormElements = "CREATE TABLE IF NOT EXISTS  ".$wpdb->prefix."xyz_cfm_form_elements (
			  `id` int NOT NULL AUTO_INCREMENT,
			  `form_id` int NOT NULL,
			  `element_diplay_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `element_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `element_type` int NOT NULL,
			  `element_required` int NOT NULL,
			  `css_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `max_length` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
			  `default_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `cols` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
			  `rows` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
			  `options` longtext COLLATE utf8_unicode_ci NOT NULL,
			  `file_size` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
			  `file_type` text COLLATE utf8_unicode_ci NOT NULL,
			  `re_captcha` int NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 " ;
			$wpdb->query($queryFormElements);
			
		}
	}
	
	$group_flag=0;
	$tblcolums = $wpdb->get_col("SHOW COLUMNS FROM  ".$wpdb->prefix."xyz_cfm_form_elements");
	if(in_array("client_view_check_radio_line_break_count", $tblcolums))
		$group_flag=1;
	
	
	if($group_flag==0)
	{
		$wpdb->query("ALTER TABLE ".$wpdb->prefix."xyz_cfm_form_elements ADD (`client_view_check_radio_line_break_count` int not null default '0' ,`client_view_multi_select_drop_down` int not null default '0')");
		
	}
	
	
	
	$xyz_cfm_SenderEmailAddress = $wpdb->get_results('SHOW TABLE STATUS WHERE name="xyz_cfm_sender_email_address"');
	if(count($xyz_cfm_SenderEmailAddress) > 0){
		$wpdb->query("RENAME TABLE xyz_cfm_sender_email_address TO ".$wpdb->prefix."xyz_cfm_sender_email_address");
	}else{
	
		$xyz_cfm_SenderEmailAddressExist = $wpdb->get_results('SHOW TABLE STATUS WHERE name="'.$wpdb->prefix.'xyz_cfm_sender_email_address"');
		if(count($xyz_cfm_SenderEmailAddressExist) == 0){
	
			$querySenderEmailAddress = "CREATE TABLE IF NOT EXISTS  ".$wpdb->prefix."xyz_cfm_sender_email_address (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`authentication` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
			`host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			`user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			`password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			`port` int(11) NOT NULL,
			`security` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			`set_default` int(1) NOT NULL,
			`status` int(1) NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
			$wpdb->query($querySenderEmailAddress);
			
		}
	}
	
	$form_count = $wpdb->query( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form') ;
	if($form_count == 0){
		
		$xyz_cfm_to_email =  $current_user->user_email;
		
		
		$last_id= $wpdb->get_var("select max(id) from ".$wpdb->prefix."xyz_cfm_form");
		$last_id=($last_id=='')?1:$last_id+1;
		
		/*create default contact form*/
		$wpdb->insert($wpdb->prefix.'xyz_cfm_form', array(
				'name' => 'form'.$last_id, 
				'status'=>1,
				'form_content'=>'',
				'submit_mode'=>2,
				'to_email'=>'',
				'from_email'=>'',
				'sender_name'=>'',
				'reply_sender_name'=>'',
				'reply_sender_email'=>'',
				'cc_email'=>'',
				'mail_type'=>1,
				'mail_subject'=>'',
				'mail_body'=>'',
				'to_email_reply'=>'',
				'reply_subject'=>'',
				'reply_body'=>'',
				'reply_mail_type'=>1,
				'enable_reply'=>1,
				'redirection_link'=>'',
				'from_email_id'=>0,
				'reply_sender_email_id'=>0,
				'redisplay_option'=>2,
				'newsletter_email_shortcode'=>'',
				'newsletter_email_list'=>'',
				'newsletter_custom_fields'=>'',
				'newsletter_optin_mode'	=>	'',
				'newsletter_subscription_status'=>0,
				'bcc_email'=>''
				),
				array('%s','%d','%s','%d','%s','%s','%s','%s','%s','%s','%d','%s','%s','%s','%s','%s','%d','%d','%s','%d','%d','%d','%s','%s','%s','%s','%d','%s'));
		$lastid = $wpdb->insert_id;
		
		/*User name*/
$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
		'form_id'	=>	$lastid,
		'element_name'	=>	'yourName',
		'element_type'	=>	'1',
		'element_required'	=>	'1',
		'element_diplay_name'	=>	'',
		'css_class'	=>	'',
		'max_length'	=>	'',
		'default_value'	=>	'',
		'cols'	=>	'',
		'rows'	=>	'',
		'options'	=>	'',
		'file_size'	=>	'',
		'file_type'	=>	'',
		're_captcha'	=>	0,
		'client_view_check_radio_line_break_count'	=>	0,
		'client_view_multi_select_drop_down'	=>	0
),
		array(
				'%d','%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d'
		));
$yourNameId = $wpdb->insert_id;
$nameCode = "[text-".$yourNameId."]";

/*User email*/
$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
		'form_id'	=>	$lastid,
		'element_name'	=>	'yourEmail',
		'element_type'	=>	'2',
		'element_required'	=>	'1',
		'element_diplay_name'	=>	'',
		'css_class'	=>	'',
		'max_length'	=>	'',
		'default_value'	=>	'',
		'cols'	=>	'',
		'rows'	=>	'',
		'options'	=>	'',
		'file_size'	=>	'',
		'file_type'	=>	'',
		're_captcha'	=>	0,
		'client_view_check_radio_line_break_count'	=>	0,
		'client_view_multi_select_drop_down'	=>	0
),
		array(
				'%d','%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d'
		));
$yourEmailId = $wpdb->insert_id;
$emailCode = "[email-".$yourEmailId."]";

/*Subject*/
$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
		'form_id'	=>	$lastid,
		'element_name'	=>	'subject',
		'element_type'	=>	'1',
		'element_required'	=>	'1',
		'element_diplay_name'	=>	'',
		'css_class'	=>	'',
		'max_length'	=>	'',
		'default_value'	=>	'',
		'cols'	=>	'',
		'rows'	=>	'',
		'options'	=>	'',
		'file_size'	=>	'',
		'file_type'	=>	'',
		're_captcha'	=>	0,
		'client_view_check_radio_line_break_count'	=>	0,
		'client_view_multi_select_drop_down'	=>	0
),
		array(
				'%d','%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d'
		));
$xyz_cfm_subjectId = $wpdb->insert_id;
$xyz_cfm_subjectCode = "[text-".$xyz_cfm_subjectId."]";


/*Message*/
$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
		'form_id'	=>	$lastid,
		'element_name'	=>	'message',
		'element_type'	=>	'3',
		'element_required'	=>	'1',
		'element_diplay_name'	=>	'',
		'css_class'	=>	'',
		'max_length'	=>	'',
		'default_value'	=>	'',
		'cols'	=>	45,
		'rows'	=>	6,
		'options'	=>	'',
		'file_size'	=>	'',
		'file_type'	=>	'',
		're_captcha'	=>	0,
		'client_view_check_radio_line_break_count'	=>	0,
		'client_view_multi_select_drop_down'	=>	0
),
		array(
				'%d','%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d'
		));
$messageId = $wpdb->insert_id;
$messageCode = "[textarea-".$messageId."]";

/*Submit*/
$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
		'form_id'	=>	$lastid,
		'element_name'	=>	'submit',
		'element_type'	=>	'9',
		'element_required'	=>	'1',
		'element_diplay_name'	=>	'Send',
		'css_class'	=>	'',
		'max_length'	=>	'',
		'default_value'	=>	'',
		'cols'	=>	'',
		'rows'	=>	'',
		'options'	=>	'',
		'file_size'	=>	'',
		'file_type'	=>	'',
		're_captcha'	=>	0,
		'client_view_check_radio_line_break_count'	=>	0,
		'client_view_multi_select_drop_down'	=>	0
),
		array(
				'%d','%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d'
		));
$submitId = $wpdb->insert_id;
$submitCode = "[submit-".$submitId."]";

		
		
		$xyz_cfm_pageCodeDefault ='<table style="width:100%;">
			<tr>
				<td>Your Name</td><td>&nbsp;:&nbsp;</td><td>'.$nameCode.'</td>
			</tr>
			<tr>
			<td>Your Email</td><td>&nbsp;:&nbsp;</td><td>'.$emailCode.'</td>
			</tr>
			<tr>
			<td>Subject</td><td>&nbsp;:&nbsp;</td><td>'.$xyz_cfm_subjectCode.'</td>
			</tr>
			<tr>
			<td>Message Body</td><td>&nbsp;:&nbsp;</td><td>'.$messageCode.'</td>
			</tr>
			<tr>
			<td colspan="2"></td>
			<td>'.$submitCode.'</td>
			</tr>
		</table>';
		
		
		$xyz_cfm_mailBody='Hi,<p>You have a new contact request</p><p>From : '.$emailCode.'<br />Subject : '.$xyz_cfm_subjectCode.'<br />Message Body : '.$messageCode.'</p>Regards<br>'.get_bloginfo('name');
		
		
		$xyz_cfm_mailBodyReplay='<p>Hi '.$nameCode.',</p><p>Thank you for contacting us. Your mail has been received and shall be processed shortly.</p>Regards<br>'.get_bloginfo('name');
		
		$wpdb->update($wpdb->prefix.'xyz_cfm_form',
				array('form_content'=>$xyz_cfm_pageCodeDefault,
						'submit_mode'=>2,
						'to_email'=>$xyz_cfm_to_email,
						'from_email'=>$emailCode,
						'mail_type'=>1,
						'mail_subject'=>$xyz_cfm_subjectCode,
						'mail_body'=>$xyz_cfm_mailBody,
						'to_email_reply'=>$emailCode,
						'reply_subject'=>'Re:'.$xyz_cfm_subjectCode,
						'reply_body'=>$xyz_cfm_mailBodyReplay,
						'reply_mail_type'=>1,
						'enable_reply'=>1,
						'status'=>1
				),
				array('id'=>$lastid));
		
	}
	
}

register_activation_hook( XYZ_CFM_PLUGIN_FILE, 'cfm_network_install' );





