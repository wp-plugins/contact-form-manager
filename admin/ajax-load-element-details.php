<?php
add_action('wp_ajax_ajax_load_element_details', 'xyz_cfm_ajax_load_element_details');

function xyz_cfm_ajax_load_element_details() {
	

global $wpdb;

$_POST = stripslashes_deep($_POST);

$elementId = $_POST['elementId'];

$element_result = $wpdb->get_results($wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."xyz_cfm_form_elements WHERE id=  %d ", $elementId)) ;
$element_result = $element_result[0];

if(count($element_result) == 0 ){
	echo "<font color = 'red'>No record found</font>";
}else{

?>

<script>
jQuery(document).ready(function() {

	jQuery("#progressSelectImage").hide();
	jQuery("#progressEditImage").hide();

	jQuery('.xyz_cfm_NoEnterSubmit').keypress(function(e){
		
		if ( e.which == 13 ) return false;
	});

	jQuery("#reCaptchaUpdate").bind('change', function () {
		 if (jQuery(this).is(':checked')){
			jQuery("#reCaptchaStyleUpdate").show();
			jQuery("#reCaptchaElementName").show();
			jQuery("#captchaStyleUpdate").hide();
			jQuery("#captchaElementName").hide();
			
		 }else{
			jQuery("#reCaptchaStyleUpdate").hide();
			jQuery("#reCaptchaElementName").hide();
			jQuery("#captchaStyleUpdate").show();
			jQuery("#captchaElementName").show();
		 }

	});

	
	jQuery('#closeUpdate1').click(function() {
		jQuery("#textFieldUpdate").hide();
	});
	jQuery('#closeUpdate2').click(function() {
		jQuery("#emailFieldUpdate").hide();
	});
	jQuery('#closeUpdate3').click(function() {
		jQuery("#textAreaUpdate").hide();
	});
	jQuery('#closeUpdate4').click(function() {
		jQuery("#dropDownMenuUpdate").hide();
	});
	jQuery('#closeUpdate5').click(function() {
		jQuery("#dateFieldUpdate").hide();
	});
	jQuery('#closeUpdate6').click(function() {
		jQuery("#checkBoxesUpdate").hide();
	});
	jQuery('#closeUpdate7').click(function() {
		jQuery("#radioButtonsUpdate").hide();
	});
	jQuery('#closeUpdate8').click(function() {
		jQuery("#fileUploadUpdate").hide();
	});
	jQuery('#closeUpdate9').click(function() {
		jQuery("#submitButtonUpdate").hide();
	});			
	jQuery('#closeUpdate10').click(function() {
		jQuery("#captchaUpdate").hide();
	});	
var selectId = <?php echo $element_result->element_type;?>;

if(selectId == 1){
	jQuery("#textFieldUpdate").show();
}else{
	jQuery("#textFieldUpdate").hide();
}
if(selectId == 2){
	jQuery("#emailFieldUpdate").show();
}else{
	jQuery("#emailFieldUpdate").hide();
}
if(selectId == 3){
	jQuery("#textAreaUpdate").show();
}else{
	jQuery("#textAreaUpdate").hide();
}
if(selectId == 4){
	jQuery("#dropDownMenuUpdate").show();
}else{
	jQuery("#dropDownMenuUpdate").hide();
}
if(selectId == 5){
	jQuery("#dateFieldUpdate").show();
}else{
	jQuery("#dateFieldUpdate").hide();
}
if(selectId == 6){
	jQuery("#checkBoxesUpdate").show();
}else{
	jQuery("#checkBoxesUpdate").hide();
}
if(selectId == 7){
	jQuery("#radioButtonsUpdate").show();
}else{
	jQuery("#radioButtonsUpdate").hide();
}
if(selectId == 8){
	jQuery("#fileUploadUpdate").show();
}else{
	jQuery("#fileUploadUpdate").hide();
}
if(selectId == 9){
	jQuery("#submitButtonUpdate").show();
}else{
	jQuery("#submitButtonUpdate").hide();
}
if(selectId == 10){
	jQuery("#captchaUpdate").show();
}else{
	jQuery("#captchaUpdate").hide();
}


function updateElementDetails(){

	var formId = jQuery("#formId").val();
	var dataString = { 
			action: 'ajax_load_elements', 
			formId: formId 
		};
	jQuery.post(ajaxurl, dataString, function(response) {
		jQuery("#progressEditImage").hide();
		jQuery("#elementSettingResult").html(response);
	});
	
return true;
}

jQuery('#textFieldButtonUpdate1').click(function() {
	var selectId = 1;
	var required ='';
	
	if(jQuery('#requiredUpdate1').attr('checked')){
		required = 1;
	}else{
		required = 0;
	}

	var elementName = jQuery.trim(jQuery("#elementNameUpdate1").val());
	var className = jQuery("#classNameUpdate1").val();
	var maxlength = jQuery("#maxlengthUpdate1").val();
	var defaultValue = jQuery("#defaultValueUpdate1").val();
	var formId = jQuery("#formId").val();
	
	if(elementName != ""){
	jQuery("#progressEditImage").show();

	var dataString = { 
			action: 'ajax_update_element', 
			id: selectId, 
			elementId: <?php echo $elementId;?>,
			required: required, 
			elementName: elementName, 
			className: className, 
			maxlength: maxlength,
			defaultValue: defaultValue, 
			formId: formId 
		};
	
	jQuery.post(ajaxurl, dataString, function(response) {
		jQuery("#cfm_text").html(response);
		updateElementDetails();
		document.getElementById('editDiv').scrollTop=0;
	});

	}else{
		alert("Please fill all mandatory fields.");
		return false;
	}
	
});


jQuery('#textFieldButtonUpdate2').click(function() {
	var selectId = 2;
	var required ='';
	
	if(jQuery('#requiredUpdate2').attr('checked')){
		required = 1;
	}else{
		required = 0;
	}

	var elementName = jQuery.trim(jQuery("#elementNameUpdate2").val());
	var className = jQuery("#classNameUpdate2").val();
	var maxlength = jQuery("#maxlengthUpdate2").val();
	var defaultValue = jQuery("#defaultValueUpdate2").val();
	var formId = jQuery("#formId").val();

	if(elementName != ""){
	jQuery("#progressEditImage").show();
	var dataString = { 
			action: 'ajax_update_element', 
			id: selectId, 
			elementId: <?php echo $elementId;?>,
			required: required, 
			elementName: elementName, 
			className: className, 
			maxlength: maxlength,
			defaultValue: defaultValue, 
			formId:formId 
		};

	jQuery.post(ajaxurl, dataString, function(response) {
		jQuery("#cfm_email").html(response);
		updateElementDetails();
		document.getElementById('editDiv').scrollTop=0;
	});
		
	}else{
		alert("Please fill all mandatory fields.");
		return false;
	}
	
});

jQuery('#textFieldButtonUpdate3').click(function() {
	var selectId = 3;
	var required ='';
	
	if(jQuery('#requiredUpdate3').attr('checked')){
		required = 1;
	}else{
		required = 0;
	}

	var elementName = jQuery.trim(jQuery("#elementNameUpdate3").val());
	var className = jQuery("#classNameUpdate3").val();
	var collength = jQuery("#colLengthUpdate3").val();
	var rowlength = jQuery("#rowLengthUpdate3").val();
	var defaultValue = jQuery("#defaultValueUpdate3").val();
	var formId = jQuery("#formId").val();

	if(elementName != ""){
	jQuery("#progressEditImage").show();
	var dataString = { 
			action: 'ajax_update_element', 
			id: selectId, 
			elementId: <?php echo $elementId;?>,
			required: required, 
			elementName: elementName, 
			className: className, 
			collength: collength,
			rowlength: rowlength, 
			defaultValue: defaultValue, 
			formId: formId 
		};

	jQuery.post(ajaxurl, dataString, function(response) {
		jQuery("#cfm_textarea").html(response);
		updateElementDetails();
		document.getElementById('editDiv').scrollTop=0;
	});
	
	}else{
		alert("Please fill all mandatory fields.");
		return false;
	}
	
});


jQuery('#textFieldButtonUpdate4').click(function() {
	var selectId = 4;
	var required ='';
	var multipleSelect = '';
	
	if(jQuery('#requiredUpdate4').attr('checked')){
		required = 1;
	}else{
		required = 0;
	}
	if(jQuery('#viewMultipleSelectDropDownUpdate').attr('checked')){
		multipleSelect = 1;
	}else{
		multipleSelect = 0;
	}
	var elementName = jQuery.trim(jQuery("#elementNameUpdate4").val());
	var className = jQuery("#classNameUpdate4").val();
	var options = jQuery.trim(jQuery("#dropDownOptionsUpdate4").val());
	var defaultValue = jQuery("#dropDownOptionsUpdate4DefaultValue").val();
	var formId = jQuery("#formId").val();

	if(elementName != "" && options != ""){
	jQuery("#progressEditImage").show();
	var dataString = { 
			action: 'ajax_update_element', 
			id: selectId, 
			elementId: <?php echo $elementId;?>,
			required: required, 
			elementName: elementName, 
			className: className, 
			options: options, 
			defaultValue: defaultValue, 
			multipleSelect: multipleSelect, 
			formId: formId 
		};

	jQuery.post(ajaxurl, dataString, function(response) {
		jQuery("#cfm_dropdown").html(response);
		updateElementDetails();
		document.getElementById('editDiv').scrollTop=0;
	});
	
	}else{
		alert("Please fill all mandatory fields.");
		return false;
	}
	
});


jQuery('#textFieldButtonUpdate5').click(function() {
	var selectId = 5;
	var required ='';
	
	if(jQuery('#requiredUpdate5').attr('checked')){
		required = 1;
	}else{
		required = 0;
	}

	var elementName = jQuery.trim(jQuery("#elementNameUpdate5").val());
	var className = jQuery("#classNameUpdate5").val();
	var formId = jQuery("#formId").val();

	if(elementName != "" ){
	jQuery("#progressEditImage").show();
	var dataString = { 
			action: 'ajax_update_element', 
			id: selectId, 
			elementId: <?php echo $elementId;?>,
			required: required, 
			elementName: elementName, 
			className: className, 
			formId: formId 
		};

	jQuery.post(ajaxurl, dataString, function(response) {
		jQuery("#cfm_date").html(response);
		updateElementDetails();
		document.getElementById('editDiv').scrollTop=0;
	});
		
	}else{
		alert("Please fill all mandatory fields.");
		return false;
	}
	
});



jQuery('#textFieldButtonUpdate6').click(function() {
	var selectId = 6;
	var required ='';
	var singleLineView = '';
	
	if(jQuery('#requiredUpdate6').attr('checked')){
		required = 1;
	}else{
		required = 0;
	}
	if(jQuery('#viewCheckboxOptions').attr('checked')){
		singleLineView = 1;
	}else{
		singleLineView = 0;
	}

	var elementName = jQuery.trim(jQuery("#elementNameUpdate6").val());
	var className = jQuery("#classNameUpdate6").val();
	var options = jQuery.trim(jQuery("#checkBoxOptionsUpdate6").val());
	var defaultValue = jQuery("#checkBoxOptionsUpdate6DefaultValue").val();
	var formId = jQuery("#formId").val();

	if(elementName != "" && options != ""){
	jQuery("#progressEditImage").show();
	var dataString = { 
			action: 'ajax_update_element', 
			id: selectId, 
			elementId: <?php echo $elementId;?>,
			required: required, 
			singleLineView: singleLineView, 
			elementName: elementName, 
			className: className,
			options: options, 
			defaultValue: defaultValue, 
			formId: formId 
		};

	jQuery.post(ajaxurl, dataString, function(response) {
		jQuery("#cfm_checkbox").html(response);
		updateElementDetails();
		document.getElementById('editDiv').scrollTop=0;
	});
	
	}else{
		alert("Please fill all mandatory fields.");
		return false;
	}
	
});	

jQuery('#textFieldButtonUpdate7').click(function() {
	var selectId = 7;
	var required ='';
	var singleLineView = '';
	
	if(jQuery('#requiredUpdate7').attr('checked')){
		required = 1;
	}else{
		required = 0;
	}
	if(jQuery('#viewRadiobuttonOptions').attr('checked')){
		singleLineView = 1;
	}else{
		singleLineView = 0;
	}

	var elementName = jQuery.trim(jQuery("#elementNameUpdate7").val());
	var className = jQuery("#classNameUpdate7").val();
	var options = jQuery.trim(jQuery("#radioOptionsUpdate7").val());
	var defaultValue = jQuery("#radioOptionsUpdate7DefaultValue").val();
	var formId = jQuery("#formId").val();

	if(elementName != "" && options != ""){
	jQuery("#progressEditImage").show();
	var dataString = { 
			action: 'ajax_update_element', 
			id: selectId, 
			elementId: <?php echo $elementId;?>,
			required: required, 
			singleLineView: singleLineView, 
			elementName: elementName, 
			className: className,
			options: options, 
			defaultValue: defaultValue, 
			formId: formId 
		};

	jQuery.post(ajaxurl, dataString, function(response) {
		jQuery("#cfm_radiobutton").html(response);
		updateElementDetails();
		document.getElementById('editDiv').scrollTop=0;
	});
	
	}else{
		alert("Please fill all mandatory fields.");
		return false;
	}
	
});


jQuery('#textFieldButtonUpdate8').click(function() {
	var selectId = 8;
	var required ='';
	
	if(jQuery('#requiredUpdate8').attr('checked')){
		required = 1;
	}else{
		required = 0;
	}

	var elementName = jQuery.trim(jQuery("#elementNameUpdate8").val());
	var className = jQuery("#classNameUpdate8").val();
	var fileSize = jQuery("#fileSizeUpdate8").val();
	var fileType = jQuery("#fileTypeUpdate8").val();
	var formId = jQuery("#formId").val();

	if(elementName != ""){
	jQuery("#progressEditImage").show();
	var dataString = { 
			action: 'ajax_update_element', 
			id: selectId, 
			elementId: <?php echo $elementId;?>,
			required: required, 
			elementName: elementName, 
			className: className, 
			fileSize: fileSize, 
			fileType:fileType,
			formId: formId 
		};

	jQuery.post(ajaxurl, dataString, function(response) {
		jQuery("#cfm_file").html(response);
		updateElementDetails();
		document.getElementById('editDiv').scrollTop=0;
	});
	
	}else{
		alert("Please fill all mandatory fields.");
		return false;
	}
	
});


jQuery('#textFieldButtonUpdate9').click(function() {
	var selectId = 9;

	var displayName = jQuery.trim(jQuery("#displayNameUpdate9").val());
	var elementName = jQuery("#elementNameUpdate9").val();
	var className = jQuery("#classNameUpdate9").val();
	var formId = jQuery("#formId").val();

	if(displayName != "" && elementName != ""){
	jQuery("#progressEditImage").show();
	var dataString = { 
			action: 'ajax_update_element', 
			id: selectId, 
			elementId: <?php echo $elementId;?>,
			displayName: displayName, 
			elementName: elementName, 
			className: className, 
			formId:formId 
		};

	jQuery.post(ajaxurl, dataString, function(response) {
		jQuery("#cfm_submit").html(response);
		updateElementDetails();
		document.getElementById('editDiv').scrollTop=0;
	});
	
	}else{
		alert("Please fill all mandatory fields.");
		return false;
	}
	
});				


jQuery('#textFieldButtonUpdate10').click(function() {
	
	
		var selectId = 10;

		var elementName = '';
		
		var formId = jQuery("#formId").val();


	if(jQuery('#reCaptchaUpdate').attr('checked')){

		elementName = jQuery.trim(jQuery("#reCaptchaElementNameUpdate10").val());		
		if(elementName != ""){
			jQuery("#progressEditImage").show();
			
			var className = jQuery("#reCaptchaStyleOptionUpdate").val();
			
			var dataString = { 
					action: 'ajax_update_element', 
					id: selectId, 
					elementId: <?php echo $elementId;?>,
					elementName: elementName, 
					className: className, 
					formId: formId, 
					reCaptcha: 1 
				};
			
			jQuery.post(ajaxurl, dataString, function(response) {
				jQuery("#cfm_captcha").html(response);
				updateElementDetails();
				document.getElementById('editDiv').scrollTop=0;
			});
			
		}else{
			alert("Please fill all mandatory fields.");
			return false;
		}
	
	}else{
		
		elementName = jQuery.trim(jQuery("#captchaElementNameUpdate10").val());		
		if(elementName != ""){
			jQuery("#progressEditImage").show();

			var className = jQuery("#classNameUpdate10").val();
			
			var dataString = { 
					action: 'ajax_update_element', 
					id: selectId, 
					elementId: <?php echo $elementId;?>,
					elementName: elementName, 
					className: className, 
					formId: formId, 
					reCaptcha: 0 
				};
			
			jQuery.post(ajaxurl, dataString, function(response) {
				jQuery("#cfm_captcha").html(response);
				updateElementDetails();
				document.getElementById('editDiv').scrollTop=0;
			});
			
		}else{
			alert("Please fill all mandatory fields.");
			return false;
		}
	}
	
});				


});

</script>



<?php 
if($element_result->element_type = 1){
	$type1 = "text-";
	?>

<div id="textFieldUpdate">

<script>
jQuery(document).ready(function() {
	jQuery("#elementNameUpdate1").focus();
});
</script>

	<input type="hidden" id="elementIdUpdate1" name="elementIdUpdate1"
		value="<?php echo $elementId;?>">
	<div id="cfm_text"></div>
	<table class="tableStyle">
		<tr>
			<td colspan="2" style="padding-left:15px;">Short Code &nbsp;:&nbsp;<?php echo '['.$type1.$elementId.']';?>
			<div style="float: right;margin-bottom:2px;">
					<span id="closeUpdate1" style="margin-right: 20px; cursor: pointer;" title="close"><b>X</b></span>
				</div>
			</td>
		</tr>
		<tr>
			<td style="border: none;padding-left:15px;" colspan="2">
				<div  style="margin-left:10px;"  id="textFieldResultUpdate1"></div>
			</td>

		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" id="requiredUpdate1"
				name="requiredUpdate1"
				<?php if(isset($_POST['requiredUpdate1'])){?>checked="checked"<?php }elseif($element_result->element_required == 1){?>
				checked="checked" <?php }?>>&nbsp;Required field?</td>
		</tr>
		<tr>

			<td>Form Element Name</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="elementNameUpdate1" id="elementNameUpdate1"
				value = "<?php if(isset($_POST['elementNameUpdate1'])){ echo esc_attr($_POST['elementNameUpdate1']);}else{ echo esc_attr($element_result->element_name); }?>">
				<span style="color:red;">*</span>
			</td>

		</tr>

		<tr>

			<td>Style Class Name (optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="classNameUpdate1" id="classNameUpdate1"
				value = "<?php if(isset($_POST['classNameUpdate1'])){ echo esc_attr($_POST['classNameUpdate1']);}else{ echo esc_attr($element_result->css_class); }?>">
			</td>
			</tr>
		<tr>
			<td >Maxlength(optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="maxlengthUpdate1" id="maxlengthUpdate1"
				value = "<?php if(isset($_POST['maxlengthUpdate1'])){ echo esc_attr($_POST['maxlengthUpdate1']);}else{ if(abs(intval($element_result->max_length)) == 0){echo "";}else{if(abs(intval($element_result->max_length)) == 0){echo "";}else{echo abs(intval($element_result->max_length));}} }?>">
			</td>
		</tr>


		<tr>
			<td >Default value (optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="defaultValueUpdate1" id="defaultValueUpdate1"
				value = "<?php if(isset($_POST['defaultValueUpdate1'])){ echo esc_attr($_POST['defaultValueUpdate1']);}else{ echo esc_attr($element_result->default_value); }?>">
			</td>

		</tr>
		<tr>
			<td id="bottomBorderNone" colspan="2">
			<input class="button-primary cfm_bottonWidth" id="textFieldButtonUpdate1"
				style="cursor: pointer;" type="button" name="textFieldButtonUpdate1"
				value="Update">
			</td>

		</tr>

	</table>

</div>


<?php 
}

if($element_result->element_type = 2){
	$type2 = "email-";
	?>
<div id="emailFieldUpdate">
<script>
jQuery(document).ready(function() {
	jQuery("#elementNameUpdate2").focus();
});
</script>	
	<div id="cfm_email"></div>
	<table class="tableStyle">
		<tr>
			<td colspan="2" style="padding-left:15px;">Short Code &nbsp;:&nbsp;<?php echo '['.$type2.$elementId.']';?>
				<div style="float: right;margin-bottom:2px;">
					<span id="closeUpdate2" style="margin-right: 20px; cursor: pointer;" title="close"><b>X</b></span>
				</div>
			</td>
		</tr>
		<tr>
			<td style="border: none;padding-left:15px;" colspan="2">
				<div style="margin-left:10px;" id="emailFieldResultUpdate2"></div>
			</td>

		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" name="requiredUpdate2"
				id="requiredUpdate2"
				<?php if(isset($_POST['requiredUpdate2'])){?>checked="checked"<?php }elseif($element_result->element_required == 1){?>
				checked="checked" <?php }?>>&nbsp;Required field?</td>
		</tr>
		<tr>

			<td>Form Element Name</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="elementNameUpdate2" id="elementNameUpdate2"
				value = "<?php if(isset($_POST['elementNameUpdate2'])){ echo esc_attr($_POST['elementNameUpdate2']);}else{ echo esc_attr($element_result->element_name); }?>">
				<span style="color:red;">*</span>
			</td>

		</tr>

		<tr>

			<td>Style Class Name (optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="classNameUpdate2" id="classNameUpdate2"
				value = "<?php if(isset($_POST['classNameUpdate2'])){ echo esc_attr($_POST['classNameUpdate2']);}else{ echo esc_attr($element_result->css_class); }?>">
			</td>
			</tr>
		<tr>
			<td >Maxlength(optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="maxlengthUpdate2" id="maxlengthUpdate2"
				value = "<?php if(isset($_POST['maxlengthUpdate2'])){ echo esc_attr($_POST['maxlengthUpdate2']);}else{if(abs(intval($element_result->max_length))==0){echo "";}else{echo abs(intval($element_result->max_length));} }?>">
			</td>
		</tr>


		<tr>
			<td >Default value (optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="defaultValueUpdate2" id="defaultValueUpdate2"
				value = "<?php if(isset($_POST['defaultValueUpdate2'])){ echo esc_attr($_POST['defaultValueUpdate2']);}else{ echo esc_attr($element_result->default_value); }?>">
			</td>

		</tr>
		<tr>
			<td id="bottomBorderNone" colspan="2"><input class="button-primary cfm_bottonWidth" id="textFieldButtonUpdate2"
				style="cursor: pointer;" type="button" name="textFieldButtonUpdate2"
				value="Update">
				
			</td>
		</tr>
		
	</table>

</div>
<?php 
}

if($element_result->element_type = 3){
	$type3 = "textarea-";
	?>
<div id="textAreaUpdate">
<script>
jQuery(document).ready(function() {
	jQuery("#elementNameUpdate3").focus();
});
</script>
	<div id="cfm_textarea"></div>
	<table class="tableStyle">
		<tr>
			<td colspan="2" style="padding-left:15px;">Short Code &nbsp;:&nbsp;<?php echo '['.$type3.$elementId.']';?>
				<div style="float: right;margin-bottom:2px;">
					<span id="closeUpdate3" style="margin-right: 20px; cursor: pointer;" title="close"><b>X</b></span>
				</div>
			</td>
		</tr>
		<tr>
			<td style="border: none;padding-left:15px;" colspan="2">
				<div style="margin-left:10px;" id="textAreaResultUpdate3"></div>
			</td>

		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" name="requiredUpdate3"
				id="requiredUpdate3"
				<?php if(isset($_POST['requiredUpdate3'])){?>checked="checked"<?php }elseif($element_result->element_required == 1){?>
				checked="checked" <?php }?>>&nbsp;Required field?</td>
		</tr>
		<tr>

			<td>Form Element Name</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="elementNameUpdate3" id="elementNameUpdate3"
				value = "<?php if(isset($_POST['elementNameUpdate3'])){ echo esc_attr($_POST['elementNameUpdate3']);}else{ echo esc_attr($element_result->element_name); }?>">
				<span style="color:red;">*</span>
			</td>

		</tr>

		<tr>


			<td>Style Class Name (optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="classNameUpdate3" id="classNameUpdate3"
				value = "<?php if(isset($_POST['classNameUpdate3'])){ echo esc_attr($_POST['classNameUpdate3']);}else{ echo esc_attr($element_result->css_class); }?>">
			</td>
			</tr>
		<tr>
			<td >Default value (optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="defaultValueUpdate3" id="defaultValueUpdate3"
				value = "<?php if(isset($_POST['defaultValueUpdate3'])){ echo esc_attr($_POST['defaultValueUpdate3']);}else{ echo esc_attr($element_result->default_value); }?>">
			</td>
		</tr>

		<tr>
			<td>Cols (optional)</td><td><input type="text" name="colLengthUpdate3" class="xyz_cfm_NoEnterSubmit"
				id="colLengthUpdate3" 
				value = "<?php if(isset($_POST['colLengthUpdate3'])){ echo esc_attr($_POST['colLengthUpdate3']);}else{ echo abs(intval($element_result->cols)); }?>">
			</td>
			</tr>
		<tr>
			<td>Rows (optional)</td><td><input type="text" name="rowLengthUpdate3" class="xyz_cfm_NoEnterSubmit"
				id="rowLengthUpdate3" 
				value = "<?php if(isset($_POST['rowLengthUpdate3'])){ echo esc_attr($_POST['rowLengthUpdate3']);}else{ echo abs(intval($element_result->rows)); }?>">
			</td>
		</tr>

		<tr>
			<td id="bottomBorderNone" colspan="2"><input class="button-primary cfm_bottonWidth" id="textFieldButtonUpdate3"
				style="cursor: pointer;" type="button" name="textFieldButtonUpdate3"
				value="Update">
			</td>
		</tr>
		
	</table>

</div>

<?php 
}

if($element_result->element_type = 4){
	$type4 = "dropdown-";
	?>
<div id="dropDownMenuUpdate">
<script>
jQuery(document).ready(function() {
	jQuery("#elementNameUpdate4").focus();
});
</script>
	<div id="cfm_dropdown"></div>
	<table class="tableStyle">
		<tr>
			<td colspan="2" style="padding-left:15px;">Short Code &nbsp;:&nbsp;<?php echo '['.$type4.$elementId.']';?>
				<div style="float: right;margin-bottom:2px;">
					<span id="closeUpdate4" style="margin-right: 20px; cursor: pointer;" title="close"><b>X</b></span>
				</div>
			</td>
		</tr>
		<tr>
			<td style="border: none;padding-left:15px;" colspan="2">
				<div style="margin-left:10px;" id="dropDownMenuResultUpdate4"></div>
			</td>

		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" name="requiredUpdate4"
				id="requiredUpdate4"
				<?php if(isset($_POST['requiredUpdate4'])){?>checked="checked"<?php }elseif($element_result->element_required == 1){?>
				checked="checked" <?php }?>>&nbsp;Required field?</td>
		</tr>
		<tr>

			<td>Form Element Name</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="elementNameUpdate4" id="elementNameUpdate4"
				value = "<?php if(isset($_POST['elementNameUpdate4'])){ echo esc_attr($_POST['elementNameUpdate4']);}else{ echo esc_attr($element_result->element_name); }?>">
				<span style="color:red;">*</span>
			</td>
		</tr>
		<tr>
			<td>Options</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="dropDownOptionsUpdate4" id="dropDownOptionsUpdate4" value="<?php if(isset($_POST['dropDownOptionsUpdate4'])){ echo esc_attr($_POST['dropDownOptionsUpdate4']);}else{ echo esc_attr($element_result->options); }?>">
				<span style="color:red;">*</span>
				<br /><b>Example 1</b> : a,b,c,d
				<br /><b>Example 2</b> : a=>1,b=>2,c=>3,d=>4
			</td>
		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" name="viewMultipleSelectDropDownUpdate"
				id="viewMultipleSelectDropDownUpdate"
				<?php if(isset($_POST['viewMultipleSelectDropDownUpdate'])){?>checked="checked"<?php }elseif($element_result->client_view_multi_select_drop_down == 1){?>
				checked="checked" <?php }?>	>&nbsp;Allow multi-select</td>
		</tr>
		<tr>
			<td>Default Drop down value (optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
					name="dropDownOptionsUpdate4DefaultValue" id="dropDownOptionsUpdate4DefaultValue" 
					value="<?php if(isset($_POST['dropDownOptionsUpdate4DefaultValue'])){ echo esc_attr($_POST['dropDownOptionsUpdate4DefaultValue']);}else{ echo esc_attr($element_result->default_value); }?>">
				</td>
		</tr>
		<tr>
			<td>Style Class Name (optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="classNameUpdate4" id="classNameUpdate4"
				value = "<?php if(isset($_POST['classNameUpdate4'])){ echo esc_attr($_POST['classNameUpdate4']);}else{ echo esc_attr($element_result->css_class); }?>">
			</td>
		</tr>
		<tr>
			<td id="bottomBorderNone" colspan="2"><input class="button-primary cfm_bottonWidth" id="textFieldButtonUpdate4"
				style="cursor: pointer;" type="button" name="textFieldButtonUpdate4"
				value="Update">
			</td>
		</tr>
		
	</table>

</div>

<?php 
}

if($element_result->element_type = 5){
	$type5 = "date-";
	?>
<div id="dateFieldUpdate">
<script>
jQuery(document).ready(function() {
	jQuery("#elementNameUpdate5").focus();
});
</script>
	<div id="cfm_date"></div>
	<table class="tableStyle">
		<tr>
			<td colspan="2" style="padding-left:15px;">Short Code &nbsp;:&nbsp;<?php echo '['.$type5.$elementId.']';?>
				<div style="float: right;margin-bottom:2px;">
					<span id="closeUpdate5" style="margin-right: 20px; cursor: pointer;" title="close"><b>X</b></span>
				</div>
			</td>
		</tr>
		<tr>
			<td style="border: none;padding-left:15px;" colspan="2">
				<div style="margin-left:10px;" id="dateFieldResultUpdate5"></div>
			</td>

		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" name="requiredUpdate5"
				id="requiredUpdate5"
				<?php if(isset($_POST['requiredUpdate5'])){?>checked="checked"<?php }elseif($element_result->element_required == 1){?>
				checked="checked" <?php }?>>&nbsp;Required field?</td>
		</tr>
		<tr>

			<td>Form Element Name</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="elementNameUpdate5" id="elementNameUpdate5"
				value = "<?php if(isset($_POST['elementNameUpdate5'])){ echo esc_attr($_POST['elementNameUpdate5']);}else{ echo esc_attr($element_result->element_name); }?>">
				<span style="color:red;">*</span>
			</td>
			</tr>
		<tr>
			<td >Style Class Name (optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="classNameUpdate5" id="classNameUpdate5"
				value = "<?php if(isset($_POST['classNameUpdate5'])){ echo esc_attr($_POST['classNameUpdate5']);}else{ echo esc_attr($element_result->css_class); }?>">
			</td>
		</tr>
		<tr>
			<td id="bottomBorderNone" colspan="2"><input class="button-primary cfm_bottonWidth"
				id="textFieldButtonUpdate5" style="cursor: pointer;" type="button"
				name="textFieldButtonUpdate5" value="Update">
			</td>
		</tr>
		
	</table>

</div>

<?php 
}

if($element_result->element_type = 6){
	$type6 = "checkbox-";
	?>
<div id="checkBoxesUpdate">
<script>
jQuery(document).ready(function() {
	jQuery("#checkBoxesResultUpdate6").focus();
});
</script>
	<div id="cfm_checkbox"></div>
	<table class="tableStyle">
		<tr>
			<td colspan="2" style="padding-left:15px;">Short Code &nbsp;:&nbsp;<?php echo '['.$type6.$elementId.']';?>
				<div style="float: right;margin-bottom:2px;">
					<span id="closeUpdate6" style="margin-right: 20px; cursor: pointer;" title="close"><b>X</b></span>
				</div>
			</td>
		</tr>
		<tr>
			<td style="border: none;padding-left:15px;" colspan="2">
				<div style="margin-left:10px;" id="checkBoxesResultUpdate6"></div>
			</td>

		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" name="requiredUpdate6"
				id="requiredUpdate6"
				<?php if(isset($_POST['requiredUpdate6'])){?>checked="checked"<?php }elseif($element_result->element_required == 1){?>
				checked="checked" <?php }?>>&nbsp;Required field?</td>
		</tr>
		<tr>

			<td>Form Element Name</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="elementNameUpdate6" id="elementNameUpdate6"
				value = "<?php if(isset($_POST['elementNameUpdate6'])){ echo esc_attr($_POST['elementNameUpdate6']);}else{ echo esc_attr($element_result->element_name); }?>">
				<span style="color:red;">*</span>
			</td>
		</tr>


		<tr>
			<td>Options</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="checkBoxOptionsUpdate6" id="checkBoxOptionsUpdate6" value="<?php if(isset($_POST['checkBoxOptionsUpdate6'])){ echo esc_attr($_POST['checkBoxOptionsUpdate6']);}else{ echo esc_attr($element_result->options); }?>">
				<span style="color:red;">*</span>
				<br /><b>Example 1</b> : a,b,c,d
				<br /><b>Example 2</b> : a=>1,b=>2,c=>3,d=>4
			</td>
		</tr>
		<tr>
			<td>Default Check Box value(s) (optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="checkBoxOptionsUpdate6DefaultValue" id="checkBoxOptionsUpdate6DefaultValue" 
				value = "<?php if(isset($_POST['checkBoxOptionsUpdate6DefaultValue'])){ echo esc_attr($_POST['checkBoxOptionsUpdate6DefaultValue']);}else{ echo esc_attr($element_result->default_value); }?>">
				<br /> Please use comma(,) to separate default option values.
			</td>
		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" name="viewCheckboxOptions"
				id="viewCheckboxOptions" 
				<?php if(isset($_POST['viewCheckboxOptions'])){?>checked="checked"<?php }elseif($element_result->client_view_check_radio_line_break_count == 1){?>
				checked="checked" <?php }?>	>&nbsp;Display each option in new line</td>
		</tr>
		<tr>
			<td>Style Class Name (optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="classNameUpdate6" id="classNameUpdate6"
				value = "<?php if(isset($_POST['classNameUpdate6'])){ echo esc_attr($_POST['classNameUpdate6']);}else{ echo esc_attr($element_result->css_class); }?>">
			</td>
		</tr>
		<tr>
			<td id="bottomBorderNone" colspan="2"><input class="button-primary cfm_bottonWidth" id="textFieldButtonUpdate6"
				style="cursor: pointer;" type="button" name="textFieldButtonUpdate6"
				value="Update">
			</td>
		</tr>
		
	</table>

</div>

<?php 
}

if($element_result->element_type = 7){
	$type7 = "radiobutton-";
	?>
<div id="radioButtonsUpdate">
<script>
jQuery(document).ready(function() {
	jQuery("#elementNameUpdate7").focus();
});
</script>
	<div id="cfm_radiobutton"></div>
	<table class="tableStyle">
		<tr>
			<td colspan="2" style="padding-left:15px;">Short Code &nbsp;:&nbsp;<?php echo '['.$type7.$elementId.']';?>
				<div style="float: right;margin-bottom:2px;">
					<span id="closeUpdate7" style="margin-right: 20px; cursor: pointer;" title="close"><b>X</b></span>
				</div>
			</td>
		</tr>
		<tr>
			<td style="border: none;padding-left:15px;" colspan="2">
				<div style="margin-left:10px;" id="radioButtonsResultUpdate7"></div>
			</td>

		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" name="requiredUpdate7"
				id="requiredUpdate7"
				<?php if(isset($_POST['requiredUpdate7'])){?>checked="checked"<?php }elseif($element_result->element_required == 1){?>
				checked="checked" <?php }?>>&nbsp;Required field?</td>
		</tr>
		<tr>

			<td>Form Element Name</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="elementNameUpdate7" id="elementNameUpdate7"
				value = "<?php if(isset($_POST['elementNameUpdate7'])){ echo esc_attr($_POST['elementNameUpdate7']);}else{ echo esc_attr($element_result->element_name); }?>">
				<span style="color:red;">*</span>
			</td>

		</tr>
		<tr>
			<td>Options</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="radioOptionsUpdate7" id="radioOptionsUpdate7" value="<?php if(isset($_POST['radioOptionsUpdate7'])){ echo esc_attr($_POST['radioOptionsUpdate7']);}else{ echo esc_attr($element_result->options); }?>">
				<span style="color:red;">*</span>
				<br /><b>Example 1</b> : a,b,c,d
				<br /><b>Example 2</b> : a=>1,b=>2,c=>3,d=>4
			</td>
		</tr>
		<tr>
			<td>Default Radio button value (optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
					name="radioOptionsUpdate7DefaultValue" id="radioOptionsUpdate7DefaultValue" 
					value = "<?php if(isset($_POST['radioOptionsUpdate7DefaultValue'])){ echo esc_attr($_POST['radioOptionsUpdate7DefaultValue']);}else{ echo esc_attr($element_result->default_value); }?>">
			</td>
		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" name="viewRadiobuttonOptions"
				id="viewRadiobuttonOptions" 
				<?php if(isset($_POST['viewRadiobuttonOptions'])){?>checked="checked"<?php }elseif($element_result->client_view_check_radio_line_break_count == 1){?>
				checked="checked" <?php }?>	>&nbsp;Display each option in new line</td>
		</tr>
		<tr>
			<td>Style Class Name (optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="classNameUpdate7" id="classNameUpdate7"
				value = "<?php if(isset($_POST['classNameUpdate7'])){ echo esc_attr($_POST['classNameUpdate7']);}else{ echo esc_attr($element_result->css_class); }?>">
			</td>
		</tr>
		<tr>
			<td id="bottomBorderNone" colspan="2"><input class="button-primary cfm_bottonWidth" id="textFieldButtonUpdate7"
				style="cursor: pointer;" type="button" name="textFieldButtonUpdate7"
				value="Update">
			</td>
		</tr>
		
	</table>

</div>

<?php 
}

if($element_result->element_type = 8){
	$type8 = "file-";
	?>
<div id="fileUploadUpdate">
<script>
jQuery(document).ready(function() {
	jQuery("#elementNameUpdate8").focus();
});
</script>
	<div id="cfm_file"></div>
	<table class="tableStyle">
		<tr>
			<td colspan="2" style="padding-left:15px;">Short Code &nbsp;:&nbsp;<?php echo '['.$type8.$elementId.']';?>
				<div style="float: right;margin-bottom:2px;">
					<span id="closeUpdate8" style="margin-right: 20px; cursor: pointer;" title="close"><b>X</b></span>
				</div>
			</td>
		</tr>
		<tr>
			<td style="border: none;padding-left:15px;" colspan="2">
				<div style="margin-left:10px;" id="fileUploadResultUpdate8"></div>
			</td>

		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" name="requiredUpdate8"
				id="requiredUpdate8"
				<?php if(isset($_POST['requiredUpdate8'])){?>checked="checked"<?php }elseif($element_result->element_required == 1){?>
				checked="checked" <?php }?>>&nbsp;Required field?</td>
		</tr>
		<tr>

			<td>Form Element Name</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="elementNameUpdate8" id="elementNameUpdate8"
				value = "<?php if(isset($_POST['elementNameUpdate8'])){ echo esc_html($_POST['elementNameUpdate8']);}else{ echo esc_html($element_result->element_name); }?>">
				<span style="color:red;">*</span>
			</td>
		</tr>

		<tr>
			<td>File size limit (bytes) (optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="fileSizeUpdate8" id="fileSizeUpdate8"
				value = "<?php if(isset($_POST['fileSizeUpdate8'])){ echo abs(intval($_POST['fileSizeUpdate8']));}else{ echo abs(intval($element_result->file_size)); }?>">
			</td>
			</tr>
		<tr>
			<td >Style Class Name (optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="classNameUpdate8" id="classNameUpdate8"
				value = "<?php if(isset($_POST['classNameUpdate8'])){ echo esc_html($_POST['classNameUpdate8']);}else{ echo esc_html($element_result->css_class); }?>">
			</td>
			

		</tr>
		<tr>

		<td >Acceptable file types (optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="fileTypeUpdate8" id="fileTypeUpdate8"
				value = "<?php if(isset($_POST['fileTypeUpdate8'])){ echo esc_html($_POST['fileTypeUpdate8']);}else{ echo esc_html($element_result->file_type); }?>">
				<br /> Please use comma(,) to separate file types. Do not use .(dot) in file types.
				<br /> Example : jpeg,jpg,png
			</td>
			
		</tr>

		<tr>
			<td id="bottomBorderNone" colspan="2"><input class="button-primary cfm_bottonWidth" id="textFieldButtonUpdate8"
				style="cursor: pointer;" type="button" name="textFieldButtonUpdate8"
				value="Update">
			</td>
		</tr>
		
	</table>

</div>

<?php 
}

if($element_result->element_type = 9){
	$type9 = "submit-";
	?>
<div id="submitButtonUpdate">
<script>
jQuery(document).ready(function() {
	jQuery("#elementNameUpdate9").focus();
});
</script>
	<div id="cfm_submit"></div>
	<table class="tableStyle">
		<tr>
			<td colspan="2" style="padding-left:15px;">Short Code &nbsp;:&nbsp;<?php echo '['.$type9.$elementId.']';?>
				<div style="float: right;margin-bottom:2px;">
					<span id="closeUpdate9" style="margin-right: 20px; cursor: pointer;" title="close"><b>X</b></span>
				</div>
			</td>
		</tr>
		<tr>
			<td style="border: none;padding-left:15px;" colspan="2">
				<div style="margin-left:10px;" id="submitButtonResultUpdate9"></div>
			</td>

		</tr>
		<tr>
			<td>Form Element Name</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="elementNameUpdate9" id="elementNameUpdate9"
				value = "<?php if(isset($_POST['elementNameUpdate9'])){ echo esc_html($_POST['elementNameUpdate9']);}else{ echo esc_html($element_result->element_name); }?>">
				<span style="color:red;">*</span>
			</td>
			</tr>
		<tr>
			<td>Display Name</td><td><input type="text" name="displayNameUpdate9" id="displayNameUpdate9" class="xyz_cfm_NoEnterSubmit"
				value = "<?php if(isset($_POST['displayNameUpdate9'])){ echo esc_html($_POST['displayNameUpdate9']);}else{ echo esc_html($element_result->element_diplay_name); }?>">
				<span style="color:red;">*</span>
			</td>
		</tr>

		<tr>


			<td >Style Class Name (optional)</td><td><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="classNameUpdate9" id="classNameUpdate9"
				value = "<?php if(isset($_POST['classNameUpdate9'])){ echo esc_html($_POST['classNameUpdate9']);}else{ echo esc_html($element_result->css_class); }?>">
			</td>
		</tr>
		<tr>
			<td id="bottomBorderNone" colspan="2"><input class="button-primary cfm_bottonWidth" id="textFieldButtonUpdate9"
				style="cursor: pointer;" type="button" name="values" value="Update">
			</td>
		</tr>
		
	</table>
</div>

<?php 
}

if($element_result->element_type = 10){
	$type10 = "captcha-";
	?>
<div id="captchaUpdate">

	<div id="cfm_captcha"></div>
	<table class="tableStyle">
		<tr>
			<td colspan="2" style="padding-left:15px;">Short Code &nbsp;:&nbsp;<?php echo '['.$type10.$elementId.']';?>
				<div style="float: right;margin-bottom:2px;">
					<span id="closeUpdate10" style="margin-right: 20px; cursor: pointer;" title="close"><b>X</b></span>
				</div>
			</td>
		</tr>
		<tr>
			<td style="border: none;padding-left:15px;" colspan="2">
				<div style="margin-left:10px;" id="captchaResultUpdate10"></div>
			</td>

		</tr>
		<?php //echo "HHHH:".$element_result->re_captcha;die;?>
		<tr>
			<td colspan="2"><input type="checkbox" name="reCaptchaUpdate"
				id="reCaptchaUpdate"
				<?php if(isset($_POST['reCaptchaUpdate'])){?>checked="checked"<?php }elseif($element_result->re_captcha == 1){?>
				checked="checked" <?php }?>>&nbsp;ReCaptcha ?</td>
		</tr>
		<tr>
			<td>Form Element Name</td><td>
				<span id="captchaElementName">
				<script>
					jQuery(document).ready(function() {
						jQuery("#captchaElementNameUpdate10").focus();
					});
				</script>
				<input type="text" class="xyz_cfm_NoEnterSubmit"
					name="captchaElementNameUpdate10" id="captchaElementNameUpdate10"
					value = "<?php if(isset($_POST['captchaElementNameUpdate10'])){ echo esc_html($_POST['captchaElementNameUpdate10']);}else{ echo esc_html($element_result->element_name); }?>">
				</span>
				<span id="reCaptchaElementName">
				<script>
					jQuery(document).ready(function() {
						jQuery("#reCaptchaElementNameUpdate10").focus();
					});
				</script>
				<input type="text" class="xyz_cfm_NoEnterSubmit"
					name="reCaptchaElementNameUpdate10" id="reCaptchaElementNameUpdate10"
					value = "<?php if(isset($_POST['reCaptchaElementNameUpdate10'])){ echo esc_html($_POST['reCaptchaElementNameUpdate10']);}else{ echo esc_html($element_result->element_name); }?>">
				</span>
				<span style="color:red;">*</span>
			</td>
		</tr>
		<tr>
			<td>Style Class Name (optional)</td>
			<td><div id="captchaStyleUpdate"><input type="text" class="xyz_cfm_NoEnterSubmit"
				name="classNameUpdate10" id="classNameUpdate10"
				value = "<?php if(isset($_POST['classNameUpdate10'])){ echo esc_html($_POST['classNameUpdate10']);}else{ echo esc_html($element_result->css_class); }?>">
				</div>
				<div id="reCaptchaStyleUpdate">
				<select name="reCaptchaStyleOptionUpdate" id="reCaptchaStyleOptionUpdate" class="xyz_cfm_NoEnterSubmit">
				<option value="red" <?php if(isset($_POST['reCaptchaStyleOptionUpdate']) && $_POST['reCaptchaStyleOptionUpdate']=="red"){echo "selected";}elseif($element_result->css_class == "red" ){echo "selected";}?>>Red</option>
				<option value="white" <?php if(isset($_POST['reCaptchaStyleOptionUpdate']) && $_POST['reCaptchaStyleOptionUpdate']=="white"){echo "selected";}elseif($element_result->css_class == "white" ){echo "selected";}?>>White</option>
				<option value="blackglass" <?php if(isset($_POST['reCaptchaStyleOptionUpdate']) && $_POST['reCaptchaStyleOptionUpdate']=="blackglass"){echo "selected";}elseif($element_result->css_class == "blackglass" ){echo "selected";}?>>Blackglass</option>
				<option value="clean" <?php if(isset($_POST['reCaptchaStyleOptionUpdate']) && $_POST['reCaptchaStyleOptionUpdate']=="clean"){echo "selected";}elseif($element_result->css_class == "clean" ){echo "selected";}?>>Clean</option>
				</select>
				</div>
			</td>
		</tr>
		
		
		<tr>
			<td id="bottomBorderNone" colspan="2"><input class="button-primary cfm_bottonWidth" id="textFieldButtonUpdate10"
				style="cursor: pointer;" type="button" name="values" value="Update">
			</td>
		</tr>
		
	</table>
</div>

<?php
}
}
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	if(jQuery('#reCaptchaUpdate').attr('checked')){
		jQuery("#reCaptchaStyleUpdate").show();
		jQuery("#reCaptchaElementName").show();
		jQuery("#captchaStyleUpdate").hide();
		jQuery("#captchaElementName").hide();
	}else{
		jQuery("#captchaStyleUpdate").show();
		jQuery("#captchaElementName").show();
		jQuery("#reCaptchaStyleUpdate").hide();
		jQuery("#reCaptchaElementName").hide();
	}
});
</script>
<?php 
die();
}
?>
