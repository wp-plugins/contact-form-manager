<?php
add_action('wp_ajax_ajax_insert_element', 'xyz_cfm_ajax_insert_element');

function xyz_cfm_ajax_insert_element() {
	

global $wpdb;
// echo '<pre>';
// print_r($_POST);die;

if($_POST){
	$_POST = stripslashes_deep($_POST);
	$_POST = xyz_trim_deep($_POST);


	$id=$_REQUEST['id'];
	if($id == 1){

		$required = $_POST['required'];

		$elementName = str_replace(' ','',str_replace('%2b','+',urldecode($_POST['elementName'])));
		$elementNameTest = str_replace('_','',$elementName);

		if(ctype_alnum($elementNameTest) && ctype_alpha($elementNameTest[0])){

			$className = str_replace('%2b','+',urldecode($_POST['className']));
			$maxlength = abs(intval(str_replace('%2b','+',urldecode($_POST['maxlength']))));
			if($maxlength == 0){
				$maxlength = '';
			}
			$defaultValue = str_replace('%2b','+',urldecode($_POST['defaultValue']));
			$formId = $_POST['formId'];
			$elementType = 1;


			$element_count = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'"  LIMIT 0,1' ) ;
			if(count($element_count) == 0){

				$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
						'form_id'	=>	$formId,
						'element_diplay_name'	=>	'',
						'element_name'	=>	$elementName,
						'element_type'	=>	$elementType,
						'element_required'	=>	$required,
						'css_class'	=>	$className,
						'max_length'	=>	$maxlength,
						'default_value'	=>	$defaultValue,
						'cols'	=>	'',
						'rows'	=>	'',
						'options'	=>	'',
						'file_size'	=>	'',
						'file_type'	=>	'',
						're_captcha'	=>	0,
						'client_view_check_radio_line_break_count'	=>	0,
						'client_view_multi_select_drop_down'	=>	0
						),
						array('%d','%s','%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d'));
				$lastElementId = $wpdb->insert_id;
				echo "Copy this code and paste it into the form left.<br/>Code is [text-".$lastElementId."]";
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
			$maxlength = abs(intval(str_replace('%2b','+',urldecode($_POST['maxlength']))));
			if($maxlength == 0){
				$maxlength = '';
			}
			$defaultValue = str_replace('%2b','+',urldecode($_POST['defaultValue']));
			$formId = $_POST['formId'];
			$elementType = 2;

			$element_count = $wpdb->get_results( 'SELECT * FROM xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'" LIMIT 0,1' ) ;
			if(count($element_count) == 0){

				$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
						'form_id'	=>	$formId,
						'element_diplay_name'	=>	'',
						'element_name'	=>	$elementName,
						'element_type'	=>	$elementType,
						'element_required'	=>	$required,
						'css_class'	=>	$className,
						'max_length'	=>	$maxlength,
						'default_value'	=>	$defaultValue,
						'cols'	=>	'',
						'rows'	=>	'',
						'options'	=>	'',
						'file_size'	=>	'',
						'file_type'	=>	'',
						're_captcha'	=>	0,
						'client_view_check_radio_line_break_count'	=>	0,
						'client_view_multi_select_drop_down'	=>	0
						
						),
						array('%d','%s','%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d'));
				$lastElementId = $wpdb->insert_id;
				echo "Copy this code and paste it into the form left.<br/>Code is [email-".$lastElementId."]";
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
			$collength = abs(intval(str_replace('%2b','+',urldecode($_POST['collength']))));
			if($collength == 0){
				$collength = '';
			}
			$rowlength = abs(intval(str_replace('%2b','+',urldecode($_POST['rowlength']))));
			if($rowlength == 0){
				$rowlength = '';
			}
			$defaultValue = str_replace('%2b','+',urldecode($_POST['defaultValue']));
			$formId = $_POST['formId'];
			$elementType = 3;

			$element_count = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'" LIMIT 0,1' ) ;
			if(count($element_count) == 0){


				$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
						'form_id'	=>	$formId,
						'element_diplay_name'	=>	'',
						'element_name'	=>	$elementName,
						'element_type'	=>	$elementType,
						'element_required'	=>	$required,
						'css_class'	=>	$className,
						'cols'	=>	$collength,
						'rows'	=>	$rowlength,
						'default_value'	=>	$defaultValue,
						'max_length'	=>	'',
						'options'	=>	'',
						'file_size'	=>	'',
						'file_type'	=>	'',
						're_captcha'	=>	0,
						'client_view_check_radio_line_break_count'	=>	0,
						'client_view_multi_select_drop_down'	=>	0			
						),
						array('%d','%s','%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d'));
				$lastElementId = $wpdb->insert_id;
				echo "Copy this code and paste it into the form left.<br/>Code is [textarea-".$lastElementId."]";
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
			
			
			$options = xyz_cfm_trimOptions(str_replace('%2b','+',urldecode($_POST['options'])));
			$defaultValue = xyz_cfm_trimOptions(str_replace('%2b','+',urldecode($_POST['defaultValue'])));
			$multipleSelect = $_POST['multipleSelect'];
			$formId = $_POST['formId'];
			$elementType = 4;

				
			$element_count = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'" LIMIT 0,1' ) ;
			if(count($element_count) == 0){

				$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
						'form_id'	=>	$formId,
						'element_diplay_name'	=>	'',
						'element_name'	=>	$elementName,
						'element_type'	=>	$elementType,
						'element_required'	=>	$required,
						'css_class'	=>	$className,
						'options'	=>	$options,
						'default_value'	=>	$defaultValue,
						'client_view_multi_select_drop_down'	=>	$multipleSelect,
						'max_length'	=>	'',
						'cols'	=>	'',
						'rows'	=>	'',
						'file_size'	=>	'',
						'file_type'	=>	'',
						're_captcha'	=>	0,
						'client_view_check_radio_line_break_count'	=>	0,
						),
						array('%d','%s','%s','%d','%d','%s','%s','%s','%d','%s','%s','%s','%s','%s','%d','%d'));
				$lastElementId = $wpdb->insert_id;
				echo "Copy this code and paste it into the form left.<br/>Code is [dropdown-".$lastElementId."]";
			}else{
				echo "<font color=red>Element name already exists.</font> ";
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
			$formId = $_POST['formId'];
			$elementType = 5;


			$element_count = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'" LIMIT 0,1' ) ;
			if(count($element_count) == 0){

				$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
						'form_id'	=>	$formId,
						'element_diplay_name'	=>	'',
						'element_name'	=>	$elementName,
						'element_type'	=>	$elementType,
						'element_required'	=>	$required,
						'css_class'	=>	$className,
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
						array('%d','%s','%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d'));
				$lastElementId = $wpdb->insert_id;
				echo "Copy this code and paste it into the form left.<br/>Code is [date-".$lastElementId."]";
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
			$options = xyz_cfm_trimOptions(str_replace('%2b','+',urldecode($_POST['options'])));
			$defaultValue = xyz_cfm_trimOptions(str_replace('%2b','+',urldecode($_POST['defaultValue'])));
			$formId = $_POST['formId'];
			$singleLineView = $_POST['singleLineView'];
			$elementType = 6;


			$element_count = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'" LIMIT 0,1' ) ;
			if(count($element_count) == 0){

				$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
						'form_id'	=>	$formId,
						'element_diplay_name'	=>	'',
						'element_name'	=>	$elementName,
						'element_type'	=>	$elementType,
						'element_required'	=>	$required,
						'css_class'	=>	$className,
						'options'	=>	$options,
						'client_view_check_radio_line_break_count'	=>	$singleLineView,
						'default_value'	=>	$defaultValue,
						'max_length'	=>	'',
						'cols'	=>	'',
						'rows'	=>	'',
						'file_size'	=>	'',
						'file_type'	=>	'',
						're_captcha'	=>	0,
						'client_view_multi_select_drop_down'	=>	0
						),
						array('%d','%s','%s','%d','%d','%s','%s','%d','%s','%s','%s','%s','%s','%s','%d','%d'));
				$lastElementId = $wpdb->insert_id;
				echo "Copy this code and paste it into the form left.<br/>Code is [checkbox-".$lastElementId."]";
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
			$options = xyz_cfm_trimOptions(str_replace('%2b','+',urldecode($_POST['options'])));
			$defaultValue = xyz_cfm_trimOptions(str_replace('%2b','+',urldecode($_POST['defaultValue'])));
			$formId = $_POST['formId'];
			$singleLineView = $_POST['singleLineView'];
			$elementType = 7;


			$element_count = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'" LIMIT 0,1' ) ;
			if(count($element_count) == 0){

				$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
						'form_id'	=>	$formId,
						'element_diplay_name'	=>	'',
						'element_name'	=>	$elementName,
						'element_type'	=>	$elementType,
						'element_required'	=>	$required,
						'css_class'	=>	$className,
						'options'	=>	$options,
						'client_view_check_radio_line_break_count'	=>	$singleLineView,
						'default_value'	=>	$defaultValue,
						'max_length'	=>	'',
						'cols'	=>	'',
						'rows'	=>	'',
						'file_size'	=>	'',
						'file_type'	=>	'',
						're_captcha'	=>	0,
						'client_view_multi_select_drop_down'	=>	0
						),
						array('%d','%s','%s','%d','%d','%s','%s','%d','%s','%s','%s','%s','%s','%s','%d','%d'));
				$lastElementId = $wpdb->insert_id;
				echo "Copy this code and paste it into the form left.<br/>Code is [radiobutton-".$lastElementId."]";
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
			$fileSize = abs(intval(str_replace('%2b','+',urldecode($_POST['fileSize']))));
			if($fileSize == 0 ) {
				$fileSize = '';
			}
			$fileType = str_replace('%2b','+',urldecode($_POST['fileType']));
			$formId = $_POST['formId'];
			$elementType = 8;


			$element_count = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_name="'.$elementName.'" AND form_id="'.$formId.'" LIMIT 0,1' ) ;
			if(count($element_count) == 0){

				$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
						'form_id'	=>	$formId,
						'element_diplay_name'	=>	'',
						'element_name'	=>	$elementName,
						'element_type'	=>	$elementType,
						'element_required'	=>	$required,
						'css_class'	=>	$className,
						'file_size'	=>	$fileSize,
						'file_type'	=>	$fileType,
						'max_length'	=>	'',
						'default_value'	=>	'',
						'cols'	=>	'',
						'rows'	=>	'',
						'options'	=>	'',
						're_captcha'	=>	0,
						'client_view_check_radio_line_break_count'	=>	0,
						'client_view_multi_select_drop_down'	=>	0
						),
						array('%d','%s','%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d'));
				$lastElementId = $wpdb->insert_id;
				echo "Copy this code and paste it into the form left.<br/>Code is [file-".$lastElementId."]";
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
			$formId = $_POST['formId'];
			$elementType = 9;


			$element_count = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_type="9" AND form_id="'.$formId.'" LIMIT 0,1' ) ;
			if(count($element_count) == 0){

				$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
						'form_id' =>$formId,
						'element_diplay_name'=>$displayName,
						'element_name'=>$elementName,
						'element_type'=>$elementType,
						'css_class'=>$className,
						'element_required'	=>	'1',
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
						array('%d','%s','%s','%s','%d','%s','%d','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d'));
				$lastElementId = $wpdb->insert_id;
				echo "Copy this code and paste it into the form left.<br/>Code is [submit-".$lastElementId."]";
			}else{
				echo "<font color=red>Element already exists.</font>";
			}

		}else{
			echo "<font color=red>Form element name must start with alphabet and must be alphanumeric .</font>";
		}
	}

	if($id == 10){

		$required = 1;
		$reCaptcha  = $_REQUEST['reCaptcha'];

		$elementName = str_replace(' ','',str_replace('%2b','+',urldecode($_REQUEST['elementName'])));
		$elementNameTest = str_replace('_','',$elementName);

		if(ctype_alnum($elementNameTest) && ctype_alpha($elementNameTest[0])){
				
			$className = str_replace('%2b','+',urldecode($_REQUEST['className']));
			$formId = $_REQUEST['formId'];
			$elementType = 10;

			$element_count = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE element_type="10" AND form_id="'.$formId.'" LIMIT 0,1' ) ;
			if(count($element_count) == 0){
					
				$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
						'form_id'	=>	$formId,
						'element_required'	=>	$required,
						'element_name'	=>	$elementName,
						'element_type'	=>	$elementType,
						'css_class'	=>	$className,
						're_captcha'	=>	$reCaptcha,
						'element_diplay_name'	=>	'',
						'max_length'	=>	'',
						'default_value'	=>	'',
						'cols'	=>	'',
						'rows'	=>	'',
						'options'	=>	'',
						'file_size'	=>	'',
						'file_type'	=>	'',
						'client_view_check_radio_line_break_count'	=>	0,
						'client_view_multi_select_drop_down'	=>	0
						),
						array('%d','%d','%s','%d','%s','%d','%s','%s','%s','%s','%s','%s','%s','%d','%d'));
					
					
				$lastElementId = $wpdb->insert_id;
				echo "Copy this code and paste it into the form left.<br/>Code is [captcha-".$lastElementId."]";
			}else{
				echo "<font color=red>Element already exists.</font>";
			}

		}else{
			echo "<font color=red>Form element name must start with alphabet and must be alphanumeric .</font>";
		}
	}

}
die();
}
?>