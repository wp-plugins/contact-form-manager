
<?php
require( dirname( __FILE__ ) . '../../../../../wp-load.php' );
if(!current_user_can('manage_options')){
	exit;
}
global $wpdb;
// echo '<pre>';
// print_r($_POST);
// die;

if($_REQUEST['id']){
	$_POST = stripslashes_deep($_POST);

	$id=$_REQUEST['id'];
	$elementId = $_REQUEST['elementId'];
	$formId = $_REQUEST['formId'];
	if($id == 1){

		$required = $_POST['required'];

		$elementName = str_replace(' ','',str_replace('%2b','+',urldecode($_POST['elementName'])));
		$elementNameTest = str_replace('_','',$elementName);

		if(ctype_alnum($elementNameTest) && ctype_alpha($elementNameTest[0])){
			$className = str_replace('%2b','+',urldecode($_POST['className']));
			$maxlength = intval(str_replace('%2b','+',urldecode($_POST['maxlength'])));
			if($maxlength == 0){
				$maxlength = '';
			}
			$defaultValue = str_replace('%2b','+',urldecode($_POST['defaultValue']));


			$elementType = 1;
			$element_count = $wpdb->query( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'" AND id!="'.$elementId.'"  LIMIT 0,1' ) ;
			if($element_count == 0){
				$wpdb->update($wpdb->prefix.'xyz_cfm_form_elements', array('element_required'=>$required,'element_name'=>$elementName,'css_class'=>$className,'max_length'=>$maxlength,'default_value'=>$defaultValue), array('id'=>$elementId));
				echo "<font color=green>Element successfully updated.</font>";
			}else{
					
				echo "<font color=red>Element name already exists.</font>";
			}
		}else{
			echo "<font color=red>Form element name must start with alphabet and must be alphanumeric .</font>";
		}

	}

	if($id == 2){

		$required = $_POST['required'];

		$elementName = str_replace(' ','',str_replace('%2b','+',urldecode($_POST['elementName'])));
		$elementNameTest = str_replace('_','',$elementName);

		if(ctype_alnum($elementNameTest) && ctype_alpha($elementNameTest[0])){
			$className = str_replace('%2b','+',urldecode($_POST['className']));
			$maxlength = intval(str_replace('%2b','+',urldecode($_POST['maxlength'])));
			if($maxlength == 0){
				$maxlength = '';
			}
			$defaultValue = str_replace('%2b','+',urldecode($_POST['defaultValue']));
			$elementType = 2;

			$element_count = $wpdb->query( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'" AND id!="'.$elementId.'" LIMIT 0,1' ) ;
			if($element_count == 0){
				$wpdb->update($wpdb->prefix.'xyz_cfm_form_elements', array('element_required'=>$required,'element_name'=>$elementName,'css_class'=>$className,'max_length'=>$maxlength,'default_value'=>$defaultValue), array('id'=>$elementId));
				echo "<font color=green>Element successfully updated.</font>";
			}else{
				echo "<font color=red>Element name already exists.</font>";
			}
		}else{
			echo "<font color=red>Form element name must start with alphabet and must be alphanumeric .</font>";
		}

	}

	if($id == 3){

		$required = $_POST['required'];

		$elementName = str_replace(' ','',str_replace('%2b','+',urldecode($_POST['elementName'])));
		$elementNameTest = str_replace('_','',$elementName);

		if(ctype_alnum($elementNameTest) && ctype_alpha($elementNameTest[0])){
			$className = str_replace('%2b','+',urldecode($_POST['className']));
			$collength = intval(str_replace('%2b','+',urldecode($_POST['collength'])));
			if($collength == 0){
				$collength = '';
			}
			$rowlength = intval(str_replace('%2b','+',urldecode($_POST['rowlength'])));
			if($rowlength == 0){
				$rowlength = '';
			}
			$defaultValue = str_replace('%2b','+',urldecode($_POST['defaultValue']));
			$elementType = 3;

			$element_count = $wpdb->query( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'" AND id!="'.$elementId.'" LIMIT 0,1' ) ;
			if($element_count == 0){
				$wpdb->update($wpdb->prefix.'xyz_cfm_form_elements', array('element_required'=>$required,'element_name'=>$elementName,'css_class'=>$className,'cols'=>$collength,'rows'=>$rowlength,'default_value'=>$defaultValue), array('id'=>$elementId));
				echo "<font color=green>Element successfully updated.</font>";
			}else{
				echo "<font color=red>Element name already exists.</font>";
			}
		}else{
			echo "<font color=red>Form element name must start with alphabet and must be alphanumeric .</font>";
		}

	}

	if($id == 4){

		$required = $_POST['required'];

		$elementName = str_replace(' ','',str_replace('%2b','+',urldecode($_POST['elementName'])));
		$elementNameTest = str_replace('_','',$elementName);

		if(ctype_alnum($elementNameTest) && ctype_alpha($elementNameTest[0])){
			$className = str_replace('%2b','+',urldecode($_POST['className']));
			$options = str_replace('%2b','+',urldecode($_POST['options']));
			$defaultValue = str_replace('%2b','+',urldecode($_POST['defaultValue']));
			$multipleSelect = $_POST['multipleSelect'];
			$elementType = 4;

				
			$element_count = $wpdb->query( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'" AND id!="'.$elementId.'" LIMIT 0,1' ) ;
			if($element_count == 0){
				$wpdb->update($wpdb->prefix.'xyz_cfm_form_elements', array('element_required'=>$required,'element_name'=>$elementName,'css_class'=>$className,'options'=>$options,'default_value'=>$defaultValue,'client_view_multi_select_drop_down'=>$multipleSelect), array('id'=>$elementId));
				echo "<font color=green>Element successfully updated.</font>";
			}else{
				echo "<font color=red>Element name already exists.</font>";
			}
		}else{
			echo "<font color=red>Form element name must start with alphabet and must be alphanumeric .</font>";
		}
	}

	if($id == 5){

		$required = $_POST['required'];

		$elementName = str_replace(' ','',str_replace('%2b','+',urldecode($_POST['elementName'])));
		$elementNameTest = str_replace('_','',$elementName);

		if(ctype_alnum($elementNameTest) && ctype_alpha($elementNameTest[0])){
			$className = str_replace('%2b','+',urldecode($_POST['className']));
			$elementType = 5;


			$element_count = $wpdb->query( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'" AND id!="'.$elementId.'" LIMIT 0,1' ) ;
			if($element_count == 0){
				$wpdb->update($wpdb->prefix.'xyz_cfm_form_elements', array('element_required'=>$required,'element_name'=>$elementName,'css_class'=>$className), array('id'=>$elementId));
				echo "<font color=green>Element successfully updated.</font>";
			}else{
				echo "<font color=red>Element name already exists.</font>";
			}
		}else{
			echo "<font color=red>Form element name must start with alphabet and must be alphanumeric .</font>";
		}
	}

	if($id == 6){

		$required = $_POST['required'];

		$elementName = str_replace(' ','',str_replace('%2b','+',urldecode($_POST['elementName'])));
		$elementNameTest = str_replace('_','',$elementName);

		if(ctype_alnum($elementNameTest) && ctype_alpha($elementNameTest[0])){
			$className = str_replace('%2b','+',urldecode($_POST['className']));
			$options = str_replace('%2b','+',urldecode($_POST['options']));
			$defaultValue = str_replace('%2b','+',urldecode($_POST['defaultValue']));
			$singleLineView = $_POST['singleLineView'];
			$elementType = 6;

			$element_count = $wpdb->query( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'" AND id!="'.$elementId.'" LIMIT 0,1' ) ;
			if($element_count == 0){
				$wpdb->update($wpdb->prefix.'xyz_cfm_form_elements', array('element_required'=>$required,'element_name'=>$elementName,'css_class'=>$className,'options'=>$options,'client_view_check_radio_line_break_count'=>$singleLineView,'default_value'=>$defaultValue), array('id'=>$elementId));
				echo "<font color=green>Element successfully updated.</font>";
			}else{
				echo "<font color=red>Element name already exists.</font>";
			}
		}else{
			echo "<font color=red>Form element name must start with alphabet and must be alphanumeric .</font>";
		}
	}

	if($id == 7){

		$required = $_POST['required'];

		$elementName = str_replace(' ','',str_replace('%2b','+',urldecode($_POST['elementName'])));
		$elementNameTest = str_replace('_','',$elementName);

		if(ctype_alnum($elementNameTest) && ctype_alpha($elementNameTest[0])){
			$className = str_replace('%2b','+',urldecode($_POST['className']));
			$options = str_replace('%2b','+',urldecode($_POST['options']));
			$defaultValue = str_replace('%2b','+',urldecode($_POST['defaultValue']));
			$singleLineView = $_POST['singleLineView'];
			$elementType = 7;

			$element_count = $wpdb->query( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'" AND id!="'.$elementId.'" LIMIT 0,1' ) ;
			if($element_count == 0){
				$wpdb->update($wpdb->prefix.'xyz_cfm_form_elements', array('element_required'=>$required,'element_name'=>$elementName,'css_class'=>$className,'options'=>$options,'client_view_check_radio_line_break_count'=>$singleLineView,'default_value'=>$defaultValue), array('id'=>$elementId));
					
				echo "<font color=green>Element successfully updated.</font>";
			}else{
				echo "<font color=red>Element name already exists.</font>";
			}
		}else{
			echo "<font color=red>Form element name must start with alphabet and must be alphanumeric .</font>";
		}
	}

	if($id == 8){

		$required = $_POST['required'];

		$elementName = str_replace(' ','',str_replace('%2b','+',urldecode($_POST['elementName'])));
		$elementNameTest = str_replace('_','',$elementName);

		if(ctype_alnum($elementNameTest) && ctype_alpha($elementNameTest[0])){
			$className = str_replace('%2b','+',urldecode($_POST['className']));
			$fileSize = intval(str_replace('%2b','+',urldecode($_POST['fileSize'])));
			if($fileSize == 0){
				$fileSize = '';
			}
			$fileType = str_replace('%2b','+',urldecode($_POST['fileType']));

			$elementType = 8;


			$element_count = $wpdb->query( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'" AND id!="'.$elementId.'" LIMIT 0,1' ) ;
			if($element_count == 0){
					
				$wpdb->update($wpdb->prefix.'xyz_cfm_form_elements', array('element_required'=>$required, 'element_name'=>$elementName,'css_class'=>$className,'file_size'=>$fileSize,'file_type'=>$fileType), array('id'=>$elementId));
					
				echo "<font color=green>Element successfully updated.</font>";
			}else{
				echo "<font color=red>Element name already exists.</font>";
			}
		}else{
			echo "<font color=red>Form element name must start with alphabet and must be alphanumeric .</font>";
		}
	}

	if($id == 9){

		$displayName = str_replace('%2b','+',urldecode($_POST['displayName']));
		$elementName = str_replace(' ','',str_replace('%2b','+',urldecode($_POST['elementName'])));
		$elementNameTest = str_replace('_','',$elementName);

		if(ctype_alnum($elementNameTest) && ctype_alpha($elementNameTest[0])){
			$className = str_replace('%2b','+',urldecode($_POST['className']));
			$elementType = 9;

			$element_count = $wpdb->query( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'" AND id!="'.$elementId.'" LIMIT 0,1' ) ;
			//$element_count = $wpdb->query( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_type="9" AND form_id="'.$formId.'" AND id!="'.$elementId.'" LIMIT 0,1' ) ;
			if($element_count == 0){
					
				$wpdb->update($wpdb->prefix.'xyz_cfm_form_elements', array('element_diplay_name'=>$displayName, 'element_name'=>$elementName,'css_class'=>$className), array('id'=>$elementId));
					
				echo "<font color=green>Element successfully updated.</font>";
			}else{
				echo "<font color=red>Element already exists.</font>";
			}
		}else{
			echo "<font color=red>Form element name must start with alphabet and must be alphanumeric .</font>";
		}
	}

	if($id == 10){
		
		$required = 1;
		$elementName = str_replace(' ','',str_replace('%2b','+',urldecode($_REQUEST['elementName'])));
		$elementNameTest = str_replace('_','',$elementName);
			
		if(ctype_alnum($elementNameTest) && ctype_alpha($elementNameTest[0])){
			$className = str_replace('%2b','+',urldecode($_REQUEST['className']));
			$elementType = 10;
			$reCaptcha  = $_REQUEST['reCaptcha'];
			$element_count = $wpdb->query( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'" AND id!="'.$elementId.'" LIMIT 0,1' ) ;
			if($element_count == 0){
					
				$wpdb->update($wpdb->prefix.'xyz_cfm_form_elements', array('element_required'=>$required,'element_name'=>$elementName,'element_type'=>$elementType,'css_class'=>$className,'re_captcha'=>$reCaptcha), array('id'=>$elementId));
					
				echo "<font color=green>Element successfully updated.</font>";
			}else{
				echo "<font color=red>Element name already exists.</font>";
			}
		}else{
			echo "<font color=red>Form element name must start with alphabet and must be alphanumeric .</font>";
		}
	}
}
