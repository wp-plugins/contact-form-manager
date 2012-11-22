<?php
require_once ABSPATH . WPINC . '/class-phpmailer.php';
require_once ABSPATH . WPINC . '/class-smtp.php';

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

$pluginName = 'xyz-wp-contact-form/xyz-wp-contact-form.php';

if(!is_plugin_active('wp-recaptcha/wp-recaptcha.php') && (!is_plugin_active($pluginName))){
	require_once dirname(XYZ_CFM_PLUGIN_FILE)."/recaptcha/recaptchalib.php";
}
set_time_limit(0);

function display_form($id){
	global $wpdb;
	
	$folderName = md5(uniqid(microtime()) . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

	$msg_after_submit='';
	$elementType = '';
	$messageBody = '';
	$script = '';
	$scriptStart = '';
	$scriptClose = '';
	$scriptDate = '';
	$styleDate = '';
	$scriptInclude = '';
	$dateFlag = 0;
	$captchaFlag = 0;
	$errorFlagMandatory = 0;
	$errorFlagEmail = 0;
	$captchaFlagError = 0;
	$emailErrorElementIdArray = array();
	$uploadFileNameArray = array();
	$fileOptionsArray = array();
	$fileTypeErrorFlag = 0;
	$fileTypeSizeFlag = 0; 
	$acceptablefileTypes = '';
	$targetfolder = '';
	$xyz_cfm_senderEmail = '';
	$xyz_cfm_mailSentFlag = 0;
	
	$individualFormSubmitFlag = 0;
	
	$clearForm = '';
	
	
	$jQueryScriptStart = '<script>jQuery(document).ready(function(){';
	$jQueryScript = '';
	$jQueryScriptClose = '});</script>';
	
	if(is_array($id)){
		$formId = $id['id'];
		
		
		if(!isset($GLOBALS['xyz_cfm_'.$formId])){
			$GLOBALS['xyz_cfm_'.$formId] = 1;
			
		}else{
			$GLOBALS['xyz_cfm_'.$formId]++;
		}
		
		$xyz_cfm_form_counter = "_".$GLOBALS['xyz_cfm_'.$formId];
		
		$formAllData = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form WHERE id="'.$formId.'"' );
		$formAllData = $formAllData[0];
		
		if($_POST && isset($_POST['xyz_cfm_frmName'.$xyz_cfm_form_counter]) && $_POST['xyz_cfm_frmName'.$xyz_cfm_form_counter] == $formAllData->name) {	
			$_POST = stripslashes_deep($_POST);
			$_POST = xyz_trim_deep($_POST);
		}	

		$messageBody = $formAllData->form_content;
		
		//Contact email settings
		$toEmail = $formAllData->to_email;
		$email_to = array();
		$email_to_list = explode(',', $toEmail);
		foreach ($email_to_list as $keyToemail => $valueToemail){
				if(is_email($valueToemail)){
					$email_to[] = $valueToemail;
				}
		}
		$emailCC = 	$formAllData->cc_email;
		$email_cc = array();
		$email_cc_list = explode(',', $emailCC);
		foreach ($email_cc_list as $keyCCemail => $valueCCemail){
				if(is_email($valueCCemail)){
					$email_cc[] = $valueCCemail;
				}
		}
		$xyz_cfm_senderEmail = $formAllData->from_email; // if php mail() is used 
		$email_senderName = $formAllData->sender_name;
		$mailSubject = $formAllData->mail_subject;
		$mailBody = $formAllData->mail_body;

		//Reply email settings
		$email_replySenderEmail = $formAllData->reply_sender_email;// if php mail() is used
		$email_senderReplyName = $formAllData->reply_sender_name;
		$mailReplayToEmail = $formAllData->to_email_reply;
		$mailReplaySubject = $formAllData->reply_subject;
		$mailReplayBody = $formAllData->reply_body;
		$mailRedirectionLink = $formAllData->redirection_link;

		

				
		$res = preg_match_all("/\[(email|text|date|submit|textarea|dropdown|checkbox|radiobutton|file|captcha)[-][0-9]{1,11}\]/",$formAllData->form_content,$match);
		if($res){ 
			
				if($_POST && isset($_POST['xyz_cfm_frmName'.$xyz_cfm_form_counter]) && $_POST['xyz_cfm_frmName'.$xyz_cfm_form_counter] == $formAllData->name) {
					$individualFormSubmitFlag = 1; // to handle scenarios where same element names are present in multiple forms in same page

					foreach ($match[0] as $key => $value){ // replacement logic begins 
						
						$elementId =  strstr($value, '-');
						$elementId = substr($elementId,1,-1);
						$elementName = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE id="'.$elementId.'"' );
						$elementName = $elementName[0];
						
						if(($elementName->element_type != 8)&&($elementName->element_type != 9)&&($elementName->element_type != 10)){
							// not file, submit button & captcha
							
							//replacing fields other than form body,email subjects & bodies
							$xyz_cfm_alt = '';
							if(isset($_POST[$elementName->element_name])){
							$xyz_cfm_alt = $_POST[$elementName->element_name];
							}
							if($elementName->client_view_multi_select_drop_down == 1){ // hidden form field is passsed only for multiselect dropdown
								if(isset($_POST['hidden_'.$elementName->element_name])){
									$xyz_cfm_alt = substr($_POST['hidden_'.$elementName->element_name],0,-1);
								}
							}elseif($elementName->element_type == 6){ // checkbox comes as array
								$xyz_cfm_alt = implode(",",$xyz_cfm_alt);
							}
							
							
							if(stristr($toEmail,$value)!==false){ // !== is needed for comparison; also stristr is used to match multiple shortcodes 
								$email_to_explode = explode(',',$xyz_cfm_alt);
								foreach ($email_to_explode as $keyToEmail => $valueToEmail){
									if(is_email($valueToEmail)){
										if(!in_array($valueToEmail, $email_to)){
											$email_to[] = $valueToEmail;
										}
									}
								}
							}
							
							
							if(stristr($emailCC,$value)!==false){  // !== is needed for comparison; also stristr is used to match multiple shortcodes
								$cc_email_to_explode = explode(',',$xyz_cfm_alt);
								foreach ($cc_email_to_explode as $keyCCEmail => $valueCCEmail){
									if(is_email($valueCCEmail)){
										if(!in_array($valueCCEmail, $email_cc)){
											$email_cc[] = $valueCCEmail;
										}
									}
								}
							}
							
							
							$xyz_cfm_senderEmail = str_replace($value,$xyz_cfm_alt,$xyz_cfm_senderEmail);
							$email_senderName = str_replace($value,$xyz_cfm_alt,$email_senderName);
							
							$email_replySenderEmail = str_replace($value,$xyz_cfm_alt,$email_replySenderEmail);
							$email_senderReplyName = str_replace($value,$xyz_cfm_alt,$email_senderReplyName);
							$mailReplayToEmail = str_replace($value,$xyz_cfm_alt,$mailReplayToEmail);
							
							$mailRedirectionLink = str_replace($value,urlencode($xyz_cfm_alt),$mailRedirectionLink);
							
							//replacing subjects and bodies

							$replace=$xyz_cfm_alt;
							
							if($elementName->element_type == 4 || $elementName->element_type == 6 || $elementName->element_type == 7){ 
								//dropdown || checkbox  || radiobutton
								
								$postedArray = explode(",",$xyz_cfm_alt);
								
								$optionsList=array();
								if($elementName->options != ""){
									$optionsList = explode(",",$elementName->options);
									if(substr($elementName->options,-1) == ","){
										array_pop($optionsList);
									}
								}
								
								$replaceArray = array();
								foreach ($optionsList as $optkey=>$optvalue){
									$keyValueExplode = explode('=>', $optvalue);
									if(in_array($keyValueExplode[0], $postedArray)){
										$replaceArray[] = $optvalue;
									}
								}
								
								$replace=implode(",",$replaceArray);// in case of radio button the array will have one element
							
							}
							
							$mailBody = str_replace($value,$replace,$mailBody);
							$mailReplayBody = str_replace($value,$replace,$mailReplayBody);
							
							$mailSubject = str_replace($value,$replace,$mailSubject);
							$mailReplaySubject = str_replace($value,$replace,$mailReplaySubject);
							
							$mailRedirectionLink = str_replace($value,urlencode($replace),$mailRedirectionLink);
							
						}
					}

					
// 	echo '<pre>';
// 	print_r($email_senderReplyName);die;	


			foreach ($match[0] as $key => $value){ // server side validations
				
				/*filter element type*/
				$tempElementType =  str_replace('[', '', $value);
				$tempElementType =  str_replace(']', '', $tempElementType);
				$explodeElementType = explode('-', $tempElementType);
				$finalElementType = $explodeElementType[0]."_";
				/*filter element type*/

				/*filter element id*/
				$elementId =  strstr($value, '-');
				$elementId = substr($elementId,1,-1);
				/*filter element id*/

				$elementName = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE id="'.$elementId.'"' );
				$elementName = $elementName[0];
				
				$xyz_cfm_altVariable = '';
				if(isset($_POST[$elementName->element_name])){
					$xyz_cfm_altVariable = $_POST[$elementName->element_name];
				}
				if($elementName->client_view_multi_select_drop_down == 1){ // hidden form field is passsed only for multiselect dropdown
					if(isset($_POST['hidden_'.$elementName->element_name])){
						$xyz_cfm_altVariable = substr($_POST['hidden_'.$elementName->element_name],0,-1);
					}
				}elseif($elementName->element_type == 6){ // checkbox comes as array
					$xyz_cfm_altVariable = implode(",",$xyz_cfm_altVariable);
				}
				

				if($elementName->element_type == 10){
					if($_POST['xyz_cfm_hiddenReCaptcha'] ==1){
						$privatekey = get_option('xyz_cfm_recaptcha_private_key');
						$resp = recaptcha_check_answer ($privatekey,
								$_SERVER["REMOTE_ADDR"],
								$_POST["recaptcha_challenge_field"],
								$_POST["recaptcha_response_field"]);
						if (!$resp->is_valid) {
							$captchaFlagError = 1;
							$captchaErrorDivId = "#".$finalElementType.$elementName->element_name."_".$elementName->id.$xyz_cfm_form_counter;
						}
					}else{
						if(isset($_COOKIE['image_random_value_'.$formAllData->name])){
							$captchaStringEncr = $_COOKIE['image_random_value_'.$formAllData->name];
							if($captchaStringEncr != md5(strtoupper($xyz_cfm_altVariable))){
								$captchaFlagError = 1;
								$captchaErrorDivId = "#".$finalElementType.$elementName->element_name."_".$elementName->id.$xyz_cfm_form_counter;
							}
						}
					}
					if($captchaFlagError == 1){
						$jQueryScript = $jQueryScript.'jQuery("div'.$captchaErrorDivId.'").html("'. __("Image content not matched", "contact-form-manager").'");
						return false;
						';
					}
					
				}
				elseif($elementName->element_type == 8){ //file
					if($elementName->element_required == 1){
						if($_FILES[$elementName->element_name]['name'] == ""){
							$errorFlagMandatory = 1;
							
							$jQueryScript = $jQueryScript.'jQuery("div#'.$finalElementType.$elementName->element_name."_".$elementName->id.$xyz_cfm_form_counter.'").html("'.__("Upload a file", "contact-form-manager").'");
							return false;
							';
							
						}
					}
					
					if($_FILES[$elementName->element_name]['name'] != ""){

					$extension = strtolower(pathinfo($_FILES[$elementName->element_name]['name'], PATHINFO_EXTENSION));
						
					$acceptablefileTypes = strtolower($elementName->file_type);
					$fileSizeLimit = $elementName->file_size." bytes";

					$fileOptionsArray = xyz_trim_deep(explode(",", $acceptablefileTypes));
						
					if(((count($fileOptionsArray) > 0) && (in_array($extension, $fileOptionsArray))) || ($acceptablefileTypes == "") ){
						
						if($elementName->file_size != '' && $_FILES[$elementName->element_name]['size'] > $elementName->file_size){
							$fileTypeSizeFlag = 1;
							$jQueryScript = $jQueryScript.'jQuery("div#'.$finalElementType.$elementName->element_name."_".$elementName->id.$xyz_cfm_form_counter.'").html("'.sprintf(__("File size too large, maximum filesize : %s", "contact-form-manager"),$fileSizeLimit).'");
							return false;
							';
						}else{	
							$uploadFileNameArray[] = $elementName->element_name."_".$_FILES[$elementName->element_name]['name'];
							$targetfolder = realpath(dirname(__FILE__) . '/../../')."/uploads";
							if (!is_file($targetfolder) && !is_dir($targetfolder)) {
								mkdir($targetfolder) or die("Could not create directory " . $targetfolder);
								chmod($targetfolder, 0777); //make it writable
							}
							$targetfolder = realpath(dirname(__FILE__) . '/../../')."/uploads/xyz_cfm_attachment_".$folderName."_".$formId;
							if (!is_file($targetfolder) && !is_dir($targetfolder)) {
								mkdir($targetfolder) or die("Could not create directory " . $targetfolder);
								chmod($targetfolder, 0777); //make it writable
							}
							move_uploaded_file($_FILES[$elementName->element_name]["tmp_name"],$targetfolder."/".$elementName->element_name."_".$_FILES[$elementName->element_name]['name']);
						}
					}else{
						$fileTypeErrorFlag = 1;
						
						$jQueryScript = $jQueryScript.'jQuery("div#'.$finalElementType.$elementName->element_name."_".$elementName->id.$xyz_cfm_form_counter.'").html("'. sprintf(__("File format not accepted, allowed formats are : %s", "contact-form-manager"),$acceptablefileTypes).'");
						return false;
						';
					}
				}
				}
				elseif($elementName->element_required == 1){
					if($xyz_cfm_altVariable == ""){
						$errorFlagMandatory = 1;
						if($elementName->element_type == 1){
							
							$jQueryScript = $jQueryScript.'jQuery("div#'.$finalElementType.$elementName->element_name."_".$elementName->id.$xyz_cfm_form_counter.'").html("'.__("Fill text field", "contact-form-manager").'");
							return false;
							';
							
						}elseif($elementName->element_type == 2 ){
							
							$jQueryScript = $jQueryScript.'jQuery("div#'.$finalElementType.$elementName->element_name."_".$elementName->id.$xyz_cfm_form_counter.'").html("'.__("Fill email field", "contact-form-manager").'");
							return false;
							';
							
						}elseif($elementName->element_type == 3 ){
							
							$jQueryScript = $jQueryScript.'jQuery("div#'.$finalElementType.$elementName->element_name."_".$elementName->id.$xyz_cfm_form_counter.'").html("'.__("Fill textarea field", "contact-form-manager").'");
							return false;
							';
							
						}elseif($elementName->element_type == 4 ){
							
							$jQueryScript = $jQueryScript.'jQuery("div#'.$finalElementType.$elementName->element_name."_".$elementName->id.$xyz_cfm_form_counter.'").html("'.__("Select dropdown field", "contact-form-manager").'");
							return false;
							';
							
						}elseif($elementName->element_type == 5){
							
							$jQueryScript = $jQueryScript.'jQuery("div#'.$finalElementType.$elementName->element_name."_".$elementName->id.$xyz_cfm_form_counter.'").html("'.__("Fill date field", "contact-form-manager").'");
							return false;
							';
							
						}elseif($elementName->element_type == 6){
							
							$jQueryScript = $jQueryScript.'jQuery("div#'.$finalElementType.$elementName->element_name."_".$elementName->id.$xyz_cfm_form_counter.'").html("'.__("Select atleast one checkbox", "contact-form-manager").'");
							return false;
							';
						
						}elseif($elementName->element_type == 7){
							
							$jQueryScript = $jQueryScript.'jQuery("div#'.$finalElementType.$elementName->element_name."_".$elementName->id.$xyz_cfm_form_counter.'").html("'.__("Select atleast one radio button", "contact-form-manager").'");
							return false;
							';
						}
					}
				}
				
				if($elementName->element_type == 2){
					if($xyz_cfm_altVariable != ""){
						$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
						if (!preg_match($regex, $xyz_cfm_altVariable)) {
							$errorFlagEmail = 1;
							$emailErrorElementIdArray[] = $elementName->element_name.'_'.$elementName->id;
							
							$jQueryScript = $jQueryScript.'jQuery("div#'.$finalElementType.$elementName->element_name."_".$elementName->id.$xyz_cfm_form_counter.'").html("'. __("Enter a valid email address", "contact-form-manager").'");
							return false;
							';
						}
					}
				}
			}//server side validation for loop
		 }// if data posted from form
	}// preg match
	

	
		if(isset($_POST['xyz_cfm_frmName'.$xyz_cfm_form_counter]) && $_POST['xyz_cfm_frmName'.$xyz_cfm_form_counter] == $formAllData->name 
			&& ($fileTypeErrorFlag != 1) && ($fileTypeSizeFlag != 1) && ($errorFlagMandatory != 1) && ($errorFlagEmail != 1) && ($captchaFlagError != 1) ){  
			
			$phpmailer = new PHPMailer();
			$phpmailer->CharSet=get_option('blog_charset');
			
			if(get_option('xyz_cfm_sendViaSmtp') == 1){

				if($formAllData->from_email_id == 0){
					$xyz_cfm_SmtpDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_sender_email_address WHERE set_default ="1"') ;
				}else{
					$xyz_cfm_SmtpDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_sender_email_address WHERE id="'.$formAllData->from_email_id.'"' ) ;
				}
				$xyz_cfm_SmtpDetails = $xyz_cfm_SmtpDetails[0];
				
				$phpmailer->IsSMTP();
				$phpmailer->Host = $xyz_cfm_SmtpDetails->host;
				$phpmailer->SMTPDebug = get_option('xyz_cfm_SmtpDebug');
				$phpmailer->SMTPAuth = $xyz_cfm_SmtpDetails->authentication;
				$phpmailer->SMTPSecure = $xyz_cfm_SmtpDetails->security;
				$phpmailer->Port = $xyz_cfm_SmtpDetails->port;
				$phpmailer->Username = $xyz_cfm_SmtpDetails->user;
				$phpmailer->Password = $xyz_cfm_SmtpDetails->password;
				
				$phpmailer->From     = $xyz_cfm_SmtpDetails->user;
				$phpmailer->FromName = $email_senderName;
				//$phpmailerReply->SetFrom($formAllData->reply_sender_email,$formAllData->reply_sender_name);
				$phpmailer->AddReplyTo($xyz_cfm_SmtpDetails->user,$formAllData->sender_name);
				
			}else{
				$phpmailer->IsMail();
				$phpmailer->From     = $xyz_cfm_senderEmail;
				$phpmailer->FromName = $email_senderName;
				$phpmailer->AddReplyTo($xyz_cfm_senderEmail,$email_senderName);
				
			}
			$xyz_cfm_targetfolder = realpath(dirname(__FILE__) . '/../../')."/uploads/xyz_cfm_attachment_".$folderName."_".$formId."/";
			foreach ($uploadFileNameArray as $id => $idValue){
				$phpmailer->AddAttachment($xyz_cfm_targetfolder.$idValue);
			}
				

			$phpmailer->Subject = $mailSubject;
			if($formAllData->mail_type == 1){
				$phpmailer->MsgHTML($mailBody);
			}
			if($formAllData->mail_type == 2){
				$phpmailer->Body = $mailBody;
			}

			if($formAllData->cc_email != ""){
				foreach ($email_cc as $ccemailKey =>$ccemailValue)
				{
					$phpmailer->AddCC(trim($ccemailValue));
				}
			}
			foreach ($email_to as $key => $value){
				$phpmailer->AddAddress(trim($value));
			}

			$sent = $phpmailer->Send();
			
			//$sent = TRUE;
				
			if($sent == FALSE) {
				
				$msg_after_submit='<div style="background: #FC8B91; border: 1px solid red; text-align: center; -moz-border-radius: 15px; border-radius: 15px; margin-bottom: 20px;">'.
				__("Mail not sent, try again", "contact-form-manager").'</div>';
				//echo  "Mailer Error Mail: " .$phpmailer->ErrorInfo;

			}else{
				
				$xyz_cfm_mailSentFlag = 1;
				
				if($formAllData->enable_reply == 2 ) {
					$phpmailerReply = new PHPMailer();
					$phpmailerReply->CharSet=get_option('blog_charset');
					
					if(get_option('xyz_cfm_sendViaSmtp') == 1){
						if($formAllData->reply_sender_email_id == 0){
							$xyz_cfm_SmtpDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_sender_email_address WHERE set_default ="1"') ;
						}else{
							$xyz_cfm_SmtpDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_sender_email_address WHERE id="'.$formAllData->reply_sender_email_id.'"' ) ;
						}
						$xyz_cfm_SmtpDetails = $xyz_cfm_SmtpDetails[0];
						
						$phpmailerReply->IsSMTP();
						$phpmailerReply->Host = $xyz_cfm_SmtpDetails->host;
						$phpmailerReply->SMTPDebug = get_option('xyz_cfm_SmtpDebug');
						$phpmailerReply->SMTPAuth = $xyz_cfm_SmtpDetails->authentication;
						$phpmailerReply->SMTPSecure = $xyz_cfm_SmtpDetails->security;
						$phpmailerReply->Port = $xyz_cfm_SmtpDetails->port;
						$phpmailerReply->Username = $xyz_cfm_SmtpDetails->user;
						$phpmailerReply->Password = $xyz_cfm_SmtpDetails->password;
						
						$phpmailerReply->From     = $xyz_cfm_SmtpDetails->user;
						$phpmailerReply->FromName = $email_senderReplyName;
						
						$phpmailerReply->AddReplyTo($xyz_cfm_SmtpDetails->user,$email_senderReplyName);
						
					}else{
					
						$phpmailerReply->IsMail();
						
						$phpmailerReply->FromName = $email_senderReplyName;
						if($formAllData->reply_sender_email != ""){
							$phpmailerReply->From     = $email_replySenderEmail;
						}else{
							$phpmailerReply->From     = $email_to[0];//take first value from "Email To" array
						}
						$phpmailerReply->AddReplyTo($phpmailerReply->From,$email_senderReplyName);
						
					}
						
					$phpmailerReply->Subject = $mailReplaySubject;
						
					if($formAllData->mail_type == 1){
						$phpmailerReply->MsgHTML($mailReplayBody);
					}
					if($formAllData->mail_type == 2){
						$phpmailerReply->Body = $mailReplayBody;
					}
					
					$phpmailerReply->AddAddress($mailReplayToEmail);
					$sentReply = $phpmailerReply->Send();
					if($sentReply == FALSE) {
						//echo  "Mailer Error Reply: " .$phpmailer->ErrorInfo;
							
					}
				}
			}
				
					
			if(count($uploadFileNameArray)>0 && $_POST){
					
				$xyz_cfm_dir = "uploads/xyz_cfm_attachment_".$folderName."_".$formId."/";
				$xyz_cfm_targetfolder = realpath(dirname(__FILE__) . '/../../')."/".$xyz_cfm_dir;
				foreach ($uploadFileNameArray as $id => $idValue){
					unlink($xyz_cfm_targetfolder.$idValue);
				}
				rmdir($xyz_cfm_targetfolder);
			}
				
			if($sent == TRUE){
				if($mailRedirectionLink != ""){
					header("Location:".$mailRedirectionLink);
					die;
				}else{

					$pageURL = 'http';
					if ($_SERVER["HTTPS"] == "on") { //TODO
						//$pageURL .= "s";
					}
					$pageURL .= "://";
					if ($_SERVER["SERVER_PORT"] != "80") {
						$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
					} else {
						$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
					}
					//echo  $pageURL;
					
					if(strpos($pageURL,"?") !=''){
						$pageURL .= '&sent=1&form='.$formAllData->name.$xyz_cfm_form_counter;
						wp_redirect($pageURL);
					}else{
						$pageURL .= '?sent=1&form='.$formAllData->name.$xyz_cfm_form_counter;
						wp_redirect($pageURL);
					}	
					die;
				}
			}
		}
			
			
		if($_GET['sent'] == 1){
			$xyz_cfm_current_form = $_GET['form'];
			$xyz_cfm_current_form = 'xyz_cfm_'.$xyz_cfm_current_form.'_success';
			
			$firstWord = explode('_', $_GET['form']);
		
			if($firstWord[0] == $formAllData->name){
				if($formAllData->redisplay_option == 2){ // do not show form again
					return '<div style="background: #C8FCBB; text-align: center; -moz-border-radius: 15px; border-radius: 15px; margin-bottom: 20px;">'.__("Mail successfully sent", "contact-form-manager").'</div>';
				}else{
					
					$jQueryScript = $jQueryScript.'jQuery("#'.$xyz_cfm_current_form.'").
					html("'. __("Mail successfully sent", "contact-form-manager").'");
					return false;
					';
				}	
			}
		}
			
		if($xyz_cfm_mailSentFlag == 0){ // form display logic	
			
			$messageBody = $formAllData->form_content;
			$scriptStart = '<script type="text/javascript"> ';
			
			if(get_option('xyz_cfm_DateFormat')=="1"){
				$scriptStart.='var xyz_cfm_date_format = "d/m/Y"';
			}elseif(get_option('xyz_cfm_DateFormat')=="2"){
				$scriptStart.='var xyz_cfm_date_format = "m/d/Y"';
			}
			
			$scriptStart.=';function xyz_cfm_'.$formId.$xyz_cfm_form_counter.'_check(){'; // js validation checking main function
			$scriptClose = '}</script>';
			$res = preg_match_all("/\[(email|text|date|submit|textarea|dropdown|checkbox|radiobutton|file|captcha)[-][0-9]{1,11}\]/",$formAllData->form_content,$matches);
			if($res){
				foreach ($matches[0] as $key => $value){
					$elementId =  strstr($value, '-');
					$elementId = substr($elementId,1,-1);
					$formElementDetails = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE form_id="'.$formId.'" AND id="'.$elementId.'"' );
					$formElementDetail = $formElementDetails[0];
					
					$xyz_cfm_elementName = esc_html($formElementDetail->element_name);
					$xyz_cfm_elementId = $formElementDetail->id;

					$cssClass = esc_html($formElementDetail->css_class);

					$maxlength = abs(intval($formElementDetail->max_length));
					if($maxlength == "0"){
						$maxlength = '';
					}

					$defaultValue = "";
					$defaultValueArray= array();
					if($formElementDetail->default_value != ""){
						if(($formElementDetail->element_type == 4) || ($formElementDetail->element_type == 6)){
							//dropdown, checkbox
							$defaultValueTempArray=explode(',', $formElementDetail->default_value);
							if(substr($formElementDetail->default_value,-1) == ","){
								array_pop($defaultValueTempArray);
							}
							foreach ($defaultValueTempArray as $keyDefault=>$valueDefault){
								$defaultExplode = explode('=>', $valueDefault);
								if($defaultExplode[1]==''){
									$defaultExplode[1]=$defaultExplode[0];
								}
								$defaultValueArray[$defaultExplode[0]]=$defaultExplode[1];
							}
							
						}else{
							$defaultValue = esc_html($formElementDetail->default_value);
						}
					}
					
					$cols = abs(intval($formElementDetail->cols));
					$rows = abs(intval($formElementDetail->rows));
					
					$optionsList = array();
					if($formElementDetail->options != ""){ //dropdown, checkbox, radio
						$optionsTempList = explode(",",$formElementDetail->options);
						if(substr($formElementDetail->options,-1) == ","){
							array_pop($optionsTempList);
						}
						
						foreach ($optionsTempList as $keyOption=>$valueOption){
							$optionExplode = explode('=>', $valueOption);
							if($optionExplode[1]==''){
								$optionExplode[1]=$optionExplode[0];
							}
							$optionsList[$optionExplode[0]]=$optionExplode[1];
						}
					}
					
					$fileSize = "";
					if($formElementDetail->file_size != "0" || $formElementDetail->file_size != ""){
						$fileSize = abs(intval($formElementDetail->file_size));
					}
					$fileType = "";
					if($formElementDetail->file_type != ""){
						$fileType = esc_html($formElementDetail->file_type);
					}
					
					if($formElementDetail->element_type == 1){
					
						$elementType = "text";
						$replace = '';
						if($formElementDetail->element_required == 1){
							$script = $script.'var xyz_cfm_name_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.' = document.getElementById("'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'").value;
							if(xyz_cfm_name_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'.trim() == ""){
							document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "'.sprintf(__("Fill text field", "contact-form-manager")).'";
							return false;
							}else{
							document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "";
							}';
						}
					
						if(isset($_POST[$xyz_cfm_elementName]) && $individualFormSubmitFlag==1){
							$replace = $replace.'<input  class="'.$cssClass.'"  type="text" id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'" name="'.$xyz_cfm_elementName.'"  value="'.esc_html($_POST[$xyz_cfm_elementName]).'" maxlength="'.$maxlength.'">';
						}else{
							$replace = $replace.'<input  class="'.$cssClass.'"  type="text" id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'" name="'.$xyz_cfm_elementName.'"  value="'.esc_html($defaultValue).'" maxlength="'.$maxlength.'">';
						}
						if((get_option('xyz_cfm_mandatory_sign')=="1") && ($formElementDetail->element_required == 1)){
							$replace = $replace.'<font color="red">*</font>';
						}
						$replace = $replace.'<div style="font-weight: normal;color:red;" id="'.$elementType.'_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'"></div>	';
						$messageBody = str_replace("[".$elementType."-".$elementId."]",$replace,$messageBody);
					}
					
					
					if($formElementDetail->element_type == 2){
						$elementType = "email";
						$replace = '';
						$script .='var xyz_cfm_email_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.' = jQuery.trim(document.getElementById("'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'").value);
						if(xyz_cfm_email_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.' != ""){
							var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
							if(reg.test(xyz_cfm_email_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.') == false) {
							document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "'.sprintf(__("Please provide a valid email address", "contact-form-manager")).'";
							return false;
							}else{
							document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "";
							}
						}';
						if($formElementDetail->element_required == 1){
							$script = $script.'if(xyz_cfm_email_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'.trim() == ""){
							document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "'.sprintf(__("Fill email field", "contact-form-manager")).'";
							return false;
							}else{
							document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "";
							}';
						}
					
						if(isset($_POST[$xyz_cfm_elementName]) && $individualFormSubmitFlag==1){
							$replace = $replace.'<input  class="'.$cssClass.'"  type="text" id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'" name="'.$xyz_cfm_elementName.'"  value="'.esc_html($_POST[$xyz_cfm_elementName]).'" maxlength="'.$maxlength.'" >';
						}else{
							$replace = $replace.'<input  class="'.$cssClass.'"  type="text" id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'" name="'.$xyz_cfm_elementName.'"  value="'.$defaultValue.'" maxlength="'.$maxlength.'" >';
						}
						if((get_option('xyz_cfm_mandatory_sign')=="1") && ($formElementDetail->element_required == 1)){
							$replace = $replace.'<font color="red">*</font>';
						}
						$replace = $replace.'<div style="font-weight: normal;color:red;" id="'.$elementType.'_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'"></div>	';
						$messageBody = str_replace("[".$elementType."-".$elementId."]",$replace,$messageBody);
					}

					
					if($formElementDetail->element_type == 3){
						$elementType = "textarea";
						$replace = '';
						if($formElementDetail->element_required == 1){
							$script = $script.'var xyz_cfm_textArea_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.' = document.getElementById("'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'").value;
							if(xyz_cfm_textArea_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'.trim() == ""){
							document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "'.sprintf(__("Fill textarea field", "contact-form-manager")).'";
							return false;
							}else{
							document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "";
							}';
						}
					
						if(isset($_POST[$xyz_cfm_elementName]) && $individualFormSubmitFlag==1){
							$replace = $replace.'<textarea    class="textAreaStyle  '.$cssClass.'"  id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'" name="'.$xyz_cfm_elementName.'"   rows="'.$rows.'" cols="'.$cols.'">'.esc_textarea($_POST[$xyz_cfm_elementName]).'</textarea>';
						}else{
							$replace = $replace.'<textarea   class="textAreaStyle  '.$cssClass.'"  id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'" name="'.$xyz_cfm_elementName.'"   rows="'.$rows.'" cols="'.$cols.'">'.esc_textarea($defaultValue).'</textarea>';
						}
						if((get_option('xyz_cfm_mandatory_sign')=="1") && ($formElementDetail->element_required == 1)){
							$replace = $replace.'<font color="red" >*</font>';
						}
						$replace = $replace.'<div style="font-weight: normal;color:red;" id="'.$elementType.'_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'"></div>	';
						$messageBody = str_replace("[".$elementType."-".$elementId."]",$replace,$messageBody);
					}
					
					if($formElementDetail->element_type == 4){
						$elementType = "dropdown";
						$replace = '';
						if($formElementDetail->element_required == 1){
							if($formElementDetail->client_view_multi_select_drop_down != 1){
								$script = $script.'var name_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.' = document.getElementById("'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'").value;
								if(name_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.' == ""){
								document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "'.sprintf(__("Select dropdown field", "contact-form-manager")).'";
								return false;
								}else{
								document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "";
								}';
							}else{
								$script = $script.'var dropdownoptions = document.xyz_cfm_'.$formId.$xyz_cfm_form_counter.'.'.$xyz_cfm_elementName.'.options;
								var count = 0;
								for(var i=dropdownoptions.length-1;i>=0;i--)
								{
								if(dropdownoptions[i].selected)
								{
								count = count + 1;
								}
								}
								if(count == 0){
								document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "'.sprintf(__("Select dropdown field", "contact-form-manager")).'";
								return false;
								}else{
								document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "";
								}';
							}
						}
						if($formElementDetail->client_view_multi_select_drop_down == 1){
							$script = $script.'document.getElementById("hidden_'.$xyz_cfm_elementName.$xyz_cfm_form_counter.'").value="";
							var dropdownoptions = document.xyz_cfm_'.$formId.$xyz_cfm_form_counter.'.'.$xyz_cfm_elementName.'.options;
							for(var i=dropdownoptions.length-1;i>=0;i--)
							{
							if(dropdownoptions[i].selected)
							{
							document.getElementById("hidden_'.$xyz_cfm_elementName.$xyz_cfm_form_counter.'").value+=document.xyz_cfm_'.$formId.$xyz_cfm_form_counter.'.'.$xyz_cfm_elementName.'.options[i].value+",";
							}
							}';
							$replace = $replace.'<input type="hidden" name="hidden_'.$xyz_cfm_elementName.'" id="hidden_'.$xyz_cfm_elementName.$xyz_cfm_form_counter.'">';
						}
						$replace = $replace.'<select id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'" name="'.$xyz_cfm_elementName.'" class="'.$cssClass.'" ';
						if($formElementDetail->client_view_multi_select_drop_down == 1){
							$replace = $replace.'multiple="multiple"';
						}
						$replace = $replace.'>';
						if($formElementDetail->client_view_multi_select_drop_down != 1){
							$replace = $replace.'<option value="">Select</option>';
						}
						foreach ($optionsList as $key=>$value){
							if($_POST && $individualFormSubmitFlag==1){
								if($formElementDetail->client_view_multi_select_drop_down == 1){
									$postedDropDownValues = $_POST['hidden_'.$xyz_cfm_elementName];
								}else{
									$postedDropDownValues = $_POST[$xyz_cfm_elementName];
								}
								$explodePostDropDownArray = explode(',', $postedDropDownValues);
								if(in_array($key, $explodePostDropDownArray)){
									$replace = $replace.'<option selected="selected" value="'.$key.'">'.$value.'</option>';
								}else{
									$replace = $replace.'<option value="'.$key.'">'.$value.'</option>';
								}
							}else{
									if(array_key_exists($key, $defaultValueArray)){
										$replace = $replace.'<option selected="selected" value="'.$key.'">'.$value.'</option>';
									}else{
										$replace = $replace.'<option value="'.$key.'">'.$value.'</option>';
									}
							}
						}
						$replace = $replace.'</select>';
						if((get_option('xyz_cfm_mandatory_sign')=="1") && ($formElementDetail->element_required == 1)){
							$replace = $replace.'<font color="red">*</font>';
						}
						$replace = $replace.'<div style="font-weight: normal;color:red; " id="'.$elementType.'_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'"></div>';
						$messageBody = str_replace("[".$elementType."-".$elementId."]",$replace,$messageBody);
					}
					
					if($formElementDetail->element_type == 5){
						$elementType = "date";
						$replace = '';
						if($formElementDetail->element_required == 1){
							$script = $script.'
							var xyz_cfm_date_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.' = document.getElementById("'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'").value;
							if(xyz_cfm_date_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'.trim() == ""){
							document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "'.sprintf(__("Fill date field", "contact-form-manager")).'";
							return false;
							}else{
							document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "";
							}';
						}
						$dateFlag = 1;
						$scriptInclude = '<script type="text/javascript" src="'.plugins_url("contact-form-manager/js/epoch_classes.js") .'"></script>';
						$scriptDate .= '<script type="text/javascript">
						var dp_cal_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.';
						jQuery(document).ready(function() {
						jQuery("#'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'").click(function() {
						if(!window.dp_cal_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'){
						dp_cal_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'  = new Epoch("epoch_popup","popup",document.getElementById("'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'"));
						}
						dp_cal_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'.show();
						});
						});
						</script>';
						$styleDate = '<style>
						table.calendar {
						font-family: Helvetica, Arial, sans-serif;
						font-size: 0.8em;
						border-collapse: collapse;
						background-color: white;
						border: solid #999999 1px;
						background-color: white;
						width: 205px;
						text-align: center;
						-moz-user-select: none;
						}
						table.calendar input,table.calendar select {
						font-size: 10px;
						}
						table.calendar td {
						border: 0;
						font-size: 10px;
						text-align: center;
						}
						div.mainheading {
						margin: 2px;
						}
						table.caldayheading {
						border-collapse: collapse;
						cursor: pointer;
						empty-cells: show;
						margin: 0 6px 0 6px;
						}
						table.caldayheading td {
						border: solid #CCCCCC 1px;
						text-align: left;
						color: #0054E3;
						font-weight: bold;
						width: 22px;
						}
						table.caldayheading td.wkhead {
						border-right: double #CCCCCC 3px;
						}
						table.calcells {
						border-collapse: collapse;
						cursor: pointer;
						margin: 0 6px 0 6px;
						}
						table.calcells td {
						border: solid #CCCCCC 1px;
						vertical-align: top;
						text-align: left;
						font-weight: bold;
						width: 22px;
						height: 20px;
						}
						table.calcells td div {
						padding: 1px;
						margin: 0;
						}
						table.calcells td.wkhead {
						background-color: white;
						text-align: center;
						border-right: double #CCCCCC 3px;
						color: #0054E3;
						}
						table.calcells td.wkday {
						background-color: #7E7777;
						}
						table.calcells td.wkend {
						background-color: #7E7777;
						}
						table.calcells td.curdate {
						}
						table.calcells td.cell_selected {
						background-color: #99CCFF;
						color: black;
						}
						table.calcells td.notmnth {
						background-color: #FFFFFF;
						color: #CCCCCC;
						}
						table.calcells td.notallowed {
						background-color: white;
						color: #EEEEEE;
						font-style: italic;
						}
						table.calcells td.hover {
						background-color: #999999;
						}
						</style>';
					
						if(isset($_POST[$xyz_cfm_elementName]) && $individualFormSubmitFlag==1){
							$replace = $replace.'<input class="'.$cssClass.'"  type="text" id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'" name="'.$xyz_cfm_elementName.'"  value="'.esc_html($_POST[$xyz_cfm_elementName]).'" maxlength="'.$maxlength.'">';
						}else{
							$replace = $replace.'<input class="'.$cssClass.'"  type="text" id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'" name="'.$xyz_cfm_elementName.'"  value="'.$defaultValue.'" maxlength="'.$maxlength.'">';
						}
						if((get_option('xyz_cfm_mandatory_sign')=="1") && ($formElementDetail->element_required == 1)){
							$replace = $replace.'<font color="red">*</font>';
						}
						$replace = $replace.'<div style="font-weight: normal;color:red;" id="'.$elementType.'_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'"></div>';
						$messageBody = str_replace("[".$elementType."-".$elementId."]",$replace,$messageBody);
					}
					
					if($formElementDetail->element_type == 6){
						$elementType = "checkbox";
						$replace = '';
						if($formElementDetail->element_required == 1){
							$script = $script.'
							var objCheckBoxes = document.forms["xyz_cfm_'.$formId.$xyz_cfm_form_counter.'"].elements["'.$xyz_cfm_elementName.'"];
							if(objCheckBoxes==null)
							objCheckBoxes = document.forms["xyz_cfm_'.$formId.$xyz_cfm_form_counter.'"].elements["'.$xyz_cfm_elementName.'[]"];
							var countCheckBoxes = objCheckBoxes.length;
							var total = 0;
							if(countCheckBoxes){
							for(var i = 0; i < countCheckBoxes; i++)
							if(objCheckBoxes[i].checked == true){
							total = total+1;
							}
							}else{
							if(objCheckBoxes.checked == true){
							total = total+1;
							}
							}
							if(total == 0){
							document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "'.sprintf(__("Select atleast one checkbox", "contact-form-manager")).'";
							return false;
							}else{
							document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "";
							}';
						}
						$j=0;
						$replace = $replace.'<div style ="border:1px solid #FFFFFF;float:left;">';
						foreach ($optionsList as $key=>$value){
					
							$lineBreakCount = $formElementDetail->client_view_check_radio_line_break_count;
					
							if($_POST && $individualFormSubmitFlag==1){
								$checkArray=$_POST[$xyz_cfm_elementName];
								if (in_array($key, $checkArray)) {
									$replace = $replace.'<input class="'.$cssClass.'" checked="checked" type="checkbox" id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.'" name="'.$xyz_cfm_elementName.'[]" value="'.$key.'" />'.$value;
								}else{
									$replace = $replace.'<input class="'.$cssClass.'" type="checkbox" id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.'" name="'.$xyz_cfm_elementName.'[]" value="'.$key.'" />'.$value;
								}
							}else{
								if (array_key_exists($key, $defaultValueArray)) {
									$replace = $replace.'<input class="'.$cssClass.'" checked="checked" type="checkbox" id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.'" name="'.$xyz_cfm_elementName.'[]" value="'.$key.'" />'.$value;
								}else{
									$replace = $replace.'<input class="'.$cssClass.'" type="checkbox" id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.'" name="'.$xyz_cfm_elementName.'[]" value="'.$key.'" />'.$value;
								}
								
							}
							if($lineBreakCount != 0){
								if($j==$lineBreakCount-1){
									$replace.='<br>';
									$j=0;
								}else{
									$j = $j+1;
								}
							}
						}
						$replace = $replace.'</div>';
						if((get_option('xyz_cfm_mandatory_sign')=="1") && ($formElementDetail->element_required == 1)){
							$replace = $replace.'<font color="red" id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'">*</font>';
						}
						$replace = $replace.'<div style="font-weight: normal;color:red;" id="'.$elementType.'_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'"></div>';
						$messageBody = str_replace("[".$elementType."-".$elementId."]",$replace,$messageBody);
					}
					
					if($formElementDetail->element_type == 7){
						$elementType = "radiobutton";
						$replace = '';
						if($formElementDetail->element_required == 1){
							$script = $script.'
							var objRadio = document.forms["xyz_cfm_'.$formId.$xyz_cfm_form_counter.'"].elements["'.$xyz_cfm_elementName.'"];
							if(objRadio==null)
							objRadio = document.forms["xyz_cfm_'.$formId.$xyz_cfm_form_counter.'"].elements["'.$xyz_cfm_elementName.'[]"];
							var countRadio = objRadio.length;
							var total = 0;
							if(countRadio){
							for(var i = 0; i < countRadio; i++)
							if(objRadio[i].checked == true){
							total = total+1;
							}
							}else{
							if(objRadio.checked == true){
							total = total+1;
							}
							}
							if(total == 0){
							document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "'.sprintf(__("Select atleast one radio button", "contact-form-manager")).'";
							return false;
							}else{
							document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "";
							}';
						}
						$j = 0;
						$replace = $replace.'<div style ="border:1px solid #FFFFFF;float:left;">';
						$defaultValue=explode("=>", $defaultValue);
						foreach ($optionsList as $key=>$value){
					
							$lineBreakCount = $formElementDetail->client_view_check_radio_line_break_count;
					
							if(isset($_POST[$xyz_cfm_elementName])  && $individualFormSubmitFlag==1){
								if($_POST[$xyz_cfm_elementName] == $key){
									$replace = $replace.'<input class="'.$cssClass.'" checked="checked" type="radio" name="'.$xyz_cfm_elementName.'"  value="'.$key.'" />'. $value;
								}else{
									$replace = $replace.'<input class="'.$cssClass.'" type="radio" name="'.$xyz_cfm_elementName.'"  value="'.$key.'" />'. $value;
								}
							}else{
								if($defaultValue[0] == $key){
									$replace = $replace.'<input class="'.$cssClass.'" checked="checked" type="radio" name="'.$xyz_cfm_elementName.'"  value="'.$key.'" />'.$value;
								}else{
									$replace = $replace.'<input class="'.$cssClass.'" type="radio" name="'.$xyz_cfm_elementName.'"  value="'.$key.'" />'. $value;
								}
							}
							if($lineBreakCount != 0){
								if($j==$lineBreakCount-1){
									$replace.='<br>';
									$j=0;
								}else{
									$j = $j+1;
								}
							}
						}
						$replace = $replace.'</div>';
						if((get_option('xyz_cfm_mandatory_sign')=="1") && ($formElementDetail->element_required == 1)){
							$replace = $replace.'<font color="red" id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'">*</font>';
						}
						$replace = $replace.'<div style="font-weight: normal;color:red;" id="'.$elementType.'_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'"></div>';
						$messageBody = str_replace("[".$elementType."-".$elementId."]",$replace,$messageBody);
					}
					
					if($formElementDetail->element_type == 8){
						$elementType = "file";
						$replace = '';
						if($formElementDetail->element_required == 1){
							$script .= 'var xyz_cfm_file_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.' = document.getElementById("'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'").value;
							if(xyz_cfm_file_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'.trim() == ""){
							document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "'.sprintf(__("Upload a file", "contact-form-manager")).'";
							return false;
							}else{
							document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "";
							}';
						}
						//$replace = $replace.'<div style="width:355px;">';
						$replace = $replace.'<input class="'.$cssClass.'" type="file" name="'.$xyz_cfm_elementName.'" id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'" accept="'.$fileType.'"  >';
						if((get_option('xyz_cfm_mandatory_sign')=="1") && ($formElementDetail->element_required == 1)){
							$replace = $replace.'<font color="red">*</font>';
						}
					if(($formElementDetail->file_size != '') || ($formElementDetail->file_type != '')){
						
							$scriptInclude = $scriptInclude.'<script>
							function fileToolTipShow'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'(id)
							{
							document.getElementById(id).style.display="";
							}
							function fileToolTipHide'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'(id)
							{
							document.getElementById(id).style.display="none";
							}
							</script>';
							
							$styleDate = $styleDate.'<style>
							.informationdiv{
							z-index:1200;
							position:absolute;
							float: left;
							background: none repeat scroll 0 0 #9FDAEE;
							border: 1px solid #209BD4;
							border-radius: 5px 5px 5px 5px;
							box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.1);
							padding: 10px;
							}
							</style>';
							
							$idDiv = "div_".$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter;
							$replace = $replace.'<img style="height:20px; cursor:pointer;" src="'.plugins_url("contact-form-manager/images/help.png").'" 
							 onmouseover="fileToolTipShow'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'('."'".$idDiv."'".')" onmouseout="fileToolTipHide'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'('."'".$idDiv."'".')"/>
							<div  id="'.$idDiv.'" class="informationdiv" style="display:none;">';
							if($formElementDetail->file_size != '' ){
								$replace = $replace.sprintf(__("Maximum upload file size : %d bytes", "contact-form-manager"),$formElementDetail->file_size);
							}
							if($formElementDetail->file_type != '' ){
								if($formElementDetail->file_size != '' ){
									$replace = $replace.'<br/>';
								}
								$replace = $replace.sprintf(__("Acceptable file types : %s", "contact-form-manager"),$formElementDetail->file_type);
							}
							$replace = $replace.'</div>';
						}
						//$replace = $replace.'</div>';
						$replace = $replace.'<div style="font-weight: normal;color:red;" id="'.$elementType.'_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'"></div>';
						$messageBody = str_replace("[".$elementType."-".$elementId."]",$replace,$messageBody);
					}
					
					if($formElementDetail->element_type == 9){
						$elementType = "submit";
						$replace = '';
						$replace = $replace.'<input class=" submit  '.$cssClass.'"  type="submit" name="'.$xyz_cfm_elementName.'" id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'" value="'.esc_html($formElementDetail->element_diplay_name).'"  >';
						$messageBody = str_replace("[".$elementType."-".$elementId."]",$replace,$messageBody);
					}
					
					if($formElementDetail->element_type == 10){
						$captchaFlag = 1;
						$elementType = "captcha";
						$replace = '';
						if($formElementDetail->re_captcha == 1){
							$publickey = get_option('xyz_cfm_recaptcha_public_key');
							if($publickey != ''){
								//$replace = $replace.recaptcha_get_html($publickey); for php
								$replace = $replace.'<div id="reCaptchaDiv_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'"></div><font color="red">*</font><script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
								<script type="text/javascript">
								Recaptcha.create("'.$publickey.'","reCaptchaDiv_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'", {theme: "'.$cssClass.'",callback: Recaptcha.focus_response_field});
								</script><input type="hidden" name="xyz_cfm_hiddenReCaptcha" value="1" id="xyz_cfm_reCaptcha_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'">';
								$replace = $replace.'<div style="font-weight: normal;color:red;" id="'.$elementType.'_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'">';
							}else{
								$replace = $replace.'<font color="red">Configure recaptcha public & private keys</font>';
							}
							$messageBody = str_replace("[".$elementType."-".$elementId."]",$replace,$messageBody);
						}else{
							if($formElementDetail->element_required == 1){
								$script = $script.'
								var xyz_cfm_captcha_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.' = document.getElementById("'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'").value;
								if(xyz_cfm_captcha_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'.trim() == ""){
								document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "'.sprintf(__("Fill captcha field", "contact-form-manager")).'";
								return false;
								}else{
								document.getElementById("'.$elementType."_".$xyz_cfm_elementName."_".$xyz_cfm_elementId.$xyz_cfm_form_counter.'").innerHTML = "";
								}';
								$scriptCaptcha = '<script type="text/javascript">
								function xyz_cfm_'.$formId.$xyz_cfm_form_counter.'_showcaptcha()
								{
								document.getElementById("captcha_div_'.$formId.$xyz_cfm_form_counter.'").innerHTML="<br/><iframe   src='.plugins_url("contact-form-manager/captcha/random.php?formName=$formAllData->name&formId=$xyz_cfm_form_counter").' marginheight=0 width=120 marginwidth=0 height=35 align=middle frameborder=0 scrolling=no  ></iframe>";
								}
								</script>';
							}
														
							
							$replace = $replace.'<input style="margin-bottom:5px;"   class="'.$cssClass.'"  type="text" id="'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'" name="'.$xyz_cfm_elementName.'">';
							$replace = $replace.'<font  color="red">*</font>';
							$replace = $replace.'<span id="captcha_div_'.$formId.$xyz_cfm_form_counter.'"></br>
							<iframe frameborder="0" align="middle" width="120" height="35" scrolling="no" marginwidth="0" marginheight="0" src="'.plugins_url("contact-form-manager/captcha/random.php?formName=$formAllData->name&formId=$xyz_cfm_form_counter").'" ></iframe>
							</span>
							<a href="javascript:void(0);" onClick="xyz_cfm_'.$formId.$xyz_cfm_form_counter.'_showcaptcha();" >
							<img  src="'.plugins_url("contact-form-manager/images/arrow-refresh.png").'" title="New Captcha Image" >
							</a>';
							$replace = $replace.'<div style="font-weight: normal;color:red;" id="'.$elementType.'_'.$xyz_cfm_elementName.'_'.$xyz_cfm_elementId.$xyz_cfm_form_counter.'"></div>';
							
							$messageBody = str_replace("[".$elementType."-".$elementId."]",$replace,$messageBody);
						}
					}
				}
				if($captchaFlag ==1){
					$scriptStart = $scriptCaptcha.$scriptStart;
				}
				if($dateFlag = 1){
					$scriptStart = $scriptInclude.$scriptDate.$styleDate.$scriptStart;
				}
				
				$contactForm = $msg_after_submit.'<style>
				.submit{
				background:#25A6E1;
				background:-moz-linear-gradient(top,#25A6E1 0%,#188BC0 100%);
				background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#25A6E1),color-stop(100%,#188BC0));
				background:-webkit-linear-gradient(top,#25A6E1 0%,#188BC0 100%);
				background:-o-linear-gradient(top,#25A6E1 0%,#188BC0 100%);
				background:-ms-linear-gradient(top,#25A6E1 0%,#188BC0 100%);
				background:linear-gradient(top,#25A6E1 0%,#188BC0 100%);
				filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#25A6E1",endColorstr="#188BC0",GradientType=0);
				padding:1px 13px;
				color:#fff;
				font-family:"Helvetica Neue",sans-serif;
				font-size:15px;
				border-radius:4px;
				-moz-border-radius:4px;
				-webkit-border-radius:4px;
				border:1px solid #1A87B9;
				cursor:pointer;
				}
				.textAreaStyle{
					width:350px;
				}				
				.tableBorder {
					padding:20px 0px 20px 20px;
					border:1px solid #DDDDDD;
					border-radius:8px;
				}
				.tableBorder td {
					border:none;
				}
				</style>'.$jQueryScriptStart.$jQueryScript.$jQueryScriptClose.$scriptStart.$script.$scriptClose.'
				<div id="xyz_cfm_'.$formAllData->name.$xyz_cfm_form_counter.'_success" style="background: #C8FCBB;  text-align: center; -moz-border-radius: 15px; border-radius: 15px; margin-bottom: 20px;"></div>
				<form name="xyz_cfm_'.$formId.$xyz_cfm_form_counter.'" method="POST" id="xyz_cfm_'.$formId.$xyz_cfm_form_counter.'" enctype="multipart/form-data" onSubmit="return xyz_cfm_'.$formId.$xyz_cfm_form_counter.'_check();">
				'.$messageBody.'
				<input type ="hidden" name="xyz_cfm_frmName'.$xyz_cfm_form_counter.'" id="xyz_cfm_frmName'.$xyz_cfm_form_counter.'" value="'.$formAllData->name.'" >
				</form>';
			
			return do_shortcode( $contactForm );
			}
		}
	}
}

