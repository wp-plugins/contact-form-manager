<?php 
global $wpdb;


$last_id= $wpdb->get_var("select max(id) from xyz_cfm_form");
$last_id=($last_id=='')?1:$last_id+1;

$wpdb->insert('xyz_cfm_form', array('name' => 'form'.$last_id,'status'=>0),array('%s'));
$lastid = $wpdb->insert_id;

$wpdb->insert('xyz_cfm_form_elements', array('form_id' =>$lastid,'element_name'=>'yourName',
		'element_type'=>'1','element_required'=>'1'),
		array('%d','%s','%s','%d','%d'));
$yourNameId = $wpdb->insert_id;
$nameCode = "[text-".$yourNameId."]";

$wpdb->insert('xyz_cfm_form_elements', array('form_id' =>$lastid,'element_name'=>'yourEmail',
		'element_type'=>'2','element_required'=>'1'),
		array('%d','%s','%s','%d','%d'));
$yourEmailId = $wpdb->insert_id;
$emailCode = "[email-".$yourEmailId."]";

$wpdb->insert('xyz_cfm_form_elements', array('form_id' =>$lastid,'element_name'=>'subject',
		'element_type'=>'1','element_required'=>'1'),
		array('%d','%s','%s','%d','%d'));
$xyz_cfm_subjectId = $wpdb->insert_id;
$xyz_cfm_subjectCode = "[text-".$xyz_cfm_subjectId."]";


$wpdb->insert('xyz_cfm_form_elements', array('form_id' =>$lastid,'element_name'=>'message',
		'element_type'=>'3','element_required'=>'1'),
		array('%d','%s','%s','%d','%d'));
$messageId = $wpdb->insert_id;
$messageCode = "[textarea-".$messageId."]";

$wpdb->insert('xyz_cfm_form_elements', array('form_id' =>$lastid,'element_diplay_name'=>'Send','element_name'=>'submit',
		'element_type'=>'9'),
		array('%d','%s','%s','%d'));
$submitId = $wpdb->insert_id;
$submitCode = "[submit-".$submitId."]";


$xyz_cfm_pageCodeDefault = '<p>Your Name<br />'.$nameCode.'</p>
<p>Your Email<br />'.$emailCode.'</p>
<p> Subject<br />'.$xyz_cfm_subjectCode.'</p>
<p>Message Body<br />'.$messageCode.'</p>
<p>'.$submitCode.'</p>';


$xyz_cfm_mailBody='<p>From : '.$emailCode.'<br />Subject : '.$xyz_cfm_subjectCode.'<br />Message Body : '.$messageCode.'</p>';

$xyz_cfm_mailBodyReplay='<p>Hai '.$nameCode.',<br />Thank you for contacting us.Your mail has been received and shall be processed shortly.</p>';

$wpdb->update('xyz_cfm_form',
		array('form_content'=>$xyz_cfm_pageCodeDefault,
				'submit_mode'=>2,
				'from_email'=>$emailCode,
				'mail_type'=>1, //html
				'mail_subject'=>$xyz_cfm_subjectCode,
				'mail_body'=>$xyz_cfm_mailBody,
				'to_email_reply'=>$emailCode,
				'reply_subject'=>'Re:'.$xyz_cfm_subjectCode,
				'reply_body'=>$xyz_cfm_mailBodyReplay,
				'reply_mail_type'=>$xyz_cfm_mailTypeReplay,
				'enable_reply'=>1 //disable
		),
		array('id'=>$lastid));


						header("Location:".admin_url('admin.php?page=contact-form-manager-managecontactforms&action=form-edit&formId='.$lastid));
						


?>