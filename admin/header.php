<style type="text/css">
#xyz-wp-contactform-premium {
	border: 1px solid #FCC328;
	margin-bottom: 20px;
	margin-top: 20px;
	background-color: #FFF6D6;
	height: 50px;
	padding: 5px;
	width: 98%
}
</style>
<?php
if(!get_option(xyz_cfm_hidepmAds))
{ 
?>
<div id="xyz-wp-contactform-premium">

	<div style="float: left; padding: 0 5px">
		<h2 style="vertical-align: middle;">
			<a target="_blank"
				href="http://xyzscripts.com/wordpress-plugins/xyz-wp-contact-form/features">Fully
				Featured XYZ WP Contact Form Premium Plugin</a> - Just 19 USD
		</h2>
	</div>
	<div style="float: left; margin-top: 3px">
		<a target="_blank"
			href="http://xyzscripts.com/members/product/purchase/XYZWPCFM"><img class="hoverImages"
			src="<?php  echo plugins_url("contact-form-manager/images/orange_buynow.png"); ?>">
		</a>
	</div>
	<div style="float: left; padding: 0 5px">
	<h2 style="vertical-align: middle;text-shadow: 1px 1px 1px #686868">
			( <a 	href="<?php echo admin_url('admin.php?page=contact-form-manager-about');?>">Compare Features</a> ) 
	</h2>		
	</div>
</div>
<?php 
}
?>

<style>
	a.xyz_cfm_link:hover{text-decoration:underline;} 
	.xyz_cfm_link{text-decoration:none;font-weight: bold;} 
</style>

<?php 

if(get_option('xyz_credit_link')=="0"){
	?>
<div style="float:left;background-color: #FFECB3;border-radius:5px;padding: 0px 5px;margin-top: 10px;border: 1px solid #E0AB1B" id="xyz_backlink_div">
	
	Please do a favour by enabling backlink to our site. <a id="xyz_cfm_backlink" style="cursor: pointer;" >Okay, Enable</a>.
<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#xyz_cfm_backlink').click(function() {

		var dataString = { 
				action: 'ajax_backlink', 
				enable: 1 
			};

		jQuery.post(ajaxurl, dataString, function(response) {
			jQuery("#xyz_backlink_div").html('Thank you for enabling backlink !');
			jQuery("#xyz_backlink_div").css('background-color', '#D8E8DA');
			jQuery("#xyz_backlink_div").css('border', '1px solid #0F801C');
		});
	});
});
</script>
</div>
	<?php 
}
?>

<style>
#text {margin:50px auto; width:500px}
.hotspot {color:#900; padding-bottom:1px; border-bottom:1px dotted #900; cursor:pointer}

#tt {position:absolute; display:block; }
#tttop {display:block; height:5px; margin-left:5px;}
#ttcont {display:block; padding:2px 10px 3px 7px;  margin-left:-400px; background:#666; color:#FFF}
#ttbot {display:block; height:5px; margin-left:5px; }
</style>

<div style="margin-top: 10px">
<table style="float:right; ">
<tr>
<td  style="float:right;" >
	<a onmouseover="tooltip.show('Please help us to keep this plugin free forever by donating a dollar');" onmouseout="tooltip.hide();" class="xyz_cfm_link" style="margin-left:8px;margin-right:12px;"   target="_blank" href="http://xyzscripts.com/donate/1">Donate</a>
</td>
<td style="float:right;">
	<a class="xyz_cfm_link" style="margin-left:8px;" target="_blank" href="http://kb.xyzscripts.com/wordpress-plugins/contact-form-manager/">FAQ</a> |
</td>
<td style="float:right;">
	<a class="xyz_cfm_link" style="margin-left:8px;" target="_blank" href="http://docs.xyzscripts.com/wordpress-plugins/contact-form-manager/">README</a> |
</td>
<td style="float:right;">
	<a class="xyz_cfm_link" style="margin-left:8px;" target="_blank" href="http://xyzscripts.com/wordpress-plugins/contact-form-manager/details">About</a> |
</td>
<td style="float:right;">
	<a class="xyz_cfm_link" target="_blank" href="http://xyzscripts.com">XYZScripts</a> |
</td>

</tr>
</table>
</div>

<div style="clear: both"></div>