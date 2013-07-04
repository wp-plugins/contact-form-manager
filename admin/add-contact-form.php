<?php 
global $wpdb;


$last_id= $wpdb->get_var('select max(id) from '.$wpdb->prefix.'xyz_cfm_form');
$last_id=($last_id=='')?1:$last_id+1;

/*create default contact form*/
$wpdb->insert($wpdb->prefix.'xyz_cfm_form', array(
		'name'	=>	'form'.$last_id,
		'status'	=>	2,
		'form_content'	=>	'',
		'submit_mode'	=>	2,
		'to_email'	=>	'',
		'from_email'	=>	'',
		'sender_name'	=>	'',
		'reply_sender_name'	=>	'',
		'reply_sender_email'	=>	'',
		'cc_email'	=>	'',
		'mail_type'	=>	1,
		'mail_subject'	=>	'',
		'mail_body'	=>	'',
		'to_email_reply'	=>	'',
		'reply_subject'	=>	'',
		'reply_body'	=>	'',
		'reply_mail_type'	=>	1,
		'enable_reply'	=>	1,
		'redirection_link'	=>	'',
		'from_email_id'	=>	0,
		'reply_sender_email_id'	=>	0,
		'redisplay_option'	=>	2,
		'newsletter_email_shortcode'	=>	'',
		'newsletter_email_list'	=>	'',
		'newsletter_custom_fields'	=>	'',
		'newsletter_optin_mode'	=>	'',
		'newsletter_subscription_status'	=>	0,
		'bcc_email'	=>	''
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

$wpdb->update($wpdb->prefix.'xyz_cfm_form',array(
		'form_content'	=>	$xyz_cfm_pageCodeDefault,
		'submit_mode'	=>	2,
		'from_email'	=>	$emailCode,
		'mail_type'	=>	1, //html
		'mail_subject'	=>	$xyz_cfm_subjectCode,
		'mail_body'	=>	$xyz_cfm_mailBody,
		'to_email_reply'	=>	$emailCode,
		'reply_subject'	=>	'Re:'.$xyz_cfm_subjectCode,
		'reply_body'	=>	$xyz_cfm_mailBodyReplay,
		'reply_mail_type'	=>	1,
		'enable_reply'	=>	1 //disable
),
		array('id'=>$lastid));

header("Location:".admin_url('admin.php?page=contact-form-manager-managecontactforms&action=form-edit&id='.$lastid));



?>