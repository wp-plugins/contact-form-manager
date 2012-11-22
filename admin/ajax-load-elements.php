<?php
require( dirname( __FILE__ ) . '../../../../../wp-load.php' );
if(!current_user_can('manage_options')){
	exit;
}
global $wpdb;
$_POST = stripslashes_deep($_POST);
$formId = $_POST['formId'];

$element_result = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form_elements WHERE form_id="'.$formId.'"') ;
//$element_result = $element_result[0];
// echo '<pre>';
// print_r($element_result);
// die;

?>
<script>
jQuery(document).ready(function() {
	

	jQuery("#progressSelectImage").hide();
	jQuery("#progressEditImage").hide();


	jQuery("a").click(function(event) {
        //alert(event.target.id);
        if((event.target.id).substr(0,1).toLowerCase() == 'e'){

        	//alert((event.target.id).substring(1));
        	jQuery("#progressEditImage").show();
        	var elementId = (event.target.id).substring(1);

        	var formId = <?php echo $formId;?>;
        	var dataString = 'elementId='+elementId;

        	document.getElementById('editDiv').scrollTop=0;
        	
        	jQuery.ajax
        	({
        	type: "POST",
        	url: "<?php echo plugins_url('contact-form-manager/admin/ajax-load-element-details.php') ?>",
        	data: dataString,
        	cache: false,
        	success: function(html)
        	{	
        		jQuery("#progressEditImage").hide();
        		jQuery("#elementSettingResultqwerty").html(html);
        	}
        	});
                	
			
        }
        if((event.target.id).substr(0,1).toLowerCase() == 'd'){
        	//alert((event.target.id).substring(1));
	        if (confirm('Please click \'OK\' to confirm ')) {
	
	        	var dataString = 'elementId='+(event.target.id).substring(1);
	        	var formId = jQuery("#formId").val();
	        	
	        	jQuery("#progressEditImage").show();
	        	
	        	dataString = dataString + '&formId='+formId;
	        	//alert(dataString);
	        	jQuery.ajax
	        	({
	        	type: "POST",
	        	url: "<?php echo plugins_url('contact-form-manager/admin/ajax-delete-element.php') ?>",
	        	data: dataString,
	        	cache: false,
	        	success: function(html)
	        	{	
	        		var formId = jQuery("#formId").val();
	        		var dataString = '&formId='+formId;
	        		//alert(dataString);
	        		jQuery.ajax
	        		({
	        		type: "POST",
	        		url: "<?php echo plugins_url('contact-form-manager/admin/ajax-load-elements.php') ?>",
	        		data: dataString,
	        		cache: false,
	        		success: function(html)
	        		{	
	        			jQuery("#progressEditImage").hide();
	        			jQuery("#elementSettingResult").html(html);
	        		}
	        		});
	        	}
	        	});
	
	        }
        }
            
    });
});

</script>
<div style="padding: 10px;">
<img style=" width:20px;height: 20px;margin-bottom:-6px;" id="progressEditImage"  src="<?php echo plugins_url('contact-form-manager/images/progressEdit.gif')?>"/>
</div>
<table class="widefat">
<thead>
<tr>
	<th><b>Field Name</b></th>
	<th><b>Field Type</b></th>
	<th><b>Shortcode</b></th>
	<th colspan="2" style="text-align: center;"><b>Action</b></th>
</tr>
</thead>
<tbody>

<?php 
if( count($element_result)>0 ) {
	$count=1;
	$class = '';
	foreach ($element_result as $elementDetail){
		$class = ( $count % 2 == 0 ) ? ' class="alternate"' : '';
?>
<tr <?php echo $class; ?>>
	<td><?php echo $elementDetail->element_name;?></td>
	<td><?php
		if($elementDetail->element_type == 1){
			echo "Text Field";
		}elseif($elementDetail->element_type == 2){
			echo "Email Field";
		}elseif($elementDetail->element_type == 3){
			echo "Text Area";
		}elseif($elementDetail->element_type == 4){
			echo "Drop-down Menu";
		}elseif($elementDetail->element_type == 5){
			echo "Date";
		}elseif($elementDetail->element_type == 6){
			echo "Check boxes";
		}elseif($elementDetail->element_type == 7){
			echo "Radio button";
		}elseif($elementDetail->element_type == 8){
			echo "File upload";
		}elseif($elementDetail->element_type == 9){
			echo "Submit button";
		}elseif($elementDetail->element_type == 10){
			echo "Captcha";
		}
	?></td>
	
	<td style="text-align: left;">
		<?php
		if($elementDetail->element_type == 1){
			echo "[text-".$elementDetail->id."]";
		}elseif($elementDetail->element_type == 2){
			echo "[email-".$elementDetail->id."]";
		}elseif($elementDetail->element_type == 3){
			echo "[textarea-".$elementDetail->id."]";
		}elseif($elementDetail->element_type == 4){
			echo "[dropdown-".$elementDetail->id."]";
		}elseif($elementDetail->element_type == 5){
			echo "[date-".$elementDetail->id."]";
		}elseif($elementDetail->element_type == 6){
			echo "[checkbox-".$elementDetail->id."]";
		}elseif($elementDetail->element_type == 7){
			echo "[radiobutton-".$elementDetail->id."]";
		}elseif($elementDetail->element_type == 8){
			echo "[file-".$elementDetail->id."]";
		}elseif($elementDetail->element_type == 9){
			echo "[submit-".$elementDetail->id."]";
		}elseif($elementDetail->element_type == 10){
			echo "[captcha-".$elementDetail->id."]";
		}
	?>
	</td>
	
	<td style="text-align: center;"><a href='#'>
		<img id="e<?php echo $elementDetail->id;?>" class="img" title="Edit Element"
		src="<?php echo plugins_url('contact-form-manager/images/edit.png')?>"></a>
	</td>
	<td style="text-align: center;" ><a href='#' >
		<img id="d<?php echo $elementDetail->id;?>" class="img" title="Delete Element"
		src="<?php echo plugins_url('contact-form-manager/images/delete.png')?>"></a>
	</td>
</tr>
<?php
$count++;
	}
} else { ?>
<tr>
	<td colspan="5" id="bottomBorderNone">Elements not found</td>
</tr>
<?php } ?>
	</tbody>
</table>

