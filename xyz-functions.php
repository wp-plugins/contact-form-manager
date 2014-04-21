<?php

/* new file name creation*/
if(!function_exists('xyz_insert_file')){
	function xyz_insert_file($path, $fileName, $i, $extension){
		$firstFileName=$fileName;
		if($i != 0){
			$fileName = $fileName.$i;
		}
		if (!file_exists($path."/".$fileName.".".$extension)) {
			return $fileName.".".$extension;
		} else {
			$j = $i + 1;
			return xyz_insert_file($path, $firstFileName, $j, $extension);
		}
	}

}
/* new file name creation*/


/* filter function for dropdown, radio button and checkbox*/
if(!function_exists('xyz_cfm_trimOptions')){
	function xyz_cfm_trimOptions($string){
		$explodeArray = explode(',',$string);
		$tempArray = array();
		$newArray = array();

		foreach ($explodeArray as $key => $value){
			if(trim($value) != ''){
				if(strpos($value, '=>')){
					$explodeArrowArray = explode('=>',$value);
					$tempArrayArrowKey = trim($explodeArrowArray[0]);
					$tempArrayArrowValue = trim($explodeArrowArray[1]);
					if(!array_key_exists($tempArrayArrowKey,$tempArray)){
						$tempArray[$tempArrayArrowKey] = $tempArrayArrowValue;
						$newArray[] = $tempArrayArrowKey.'=>'.$tempArrayArrowValue;
					}
				}else{
					$tempArrayKey = trim($value);
					if(!array_key_exists($tempArrayKey,$tempArray)){
						$tempArray[trim($value)] = trim($value);
						$newArray[] = trim($value);
					}
				}
			}
		}
		return implode(',', $newArray);
	}
}

/**/


if(!function_exists('xyz_trim_deep'))
{

function xyz_trim_deep($value) {
	if ( is_array($value) ) {
		$value = array_map('xyz_trim_deep', $value);
	} elseif ( is_object($value) ) {
		$vars = get_object_vars( $value );
		foreach ($vars as $key=>$data) {
			$value->{$key} = xyz_trim_deep( $data );
		}
	} else {
		$value = trim($value);
	}

	return $value;
}

}

if(!function_exists('esc_textarea'))
{
	function esc_textarea($text)
	{
		$safe_text = htmlspecialchars( $text, ENT_QUOTES );
		return $safe_text;
	}
}

if(!function_exists('xyz_cfm_plugin_get_version'))
{
	function xyz_cfm_plugin_get_version() 
	{
		if ( ! function_exists( 'get_plugins' ) )
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$plugin_folder = get_plugins( '/' . plugin_basename( dirname( XYZ_CFM_PLUGIN_FILE ) ) );
		// 		print_r($plugin_folder);
		return $plugin_folder['contact-form-manager.php']['Version'];
	}
}



if(!function_exists('xyz_cfm_links')){
function xyz_cfm_links($links, $file) {
	$base = plugin_basename(XYZ_CFM_PLUGIN_FILE);
	if ($file == $base) {

		$links[] = '<a href="http://kb.xyzscripts.com/wordpress-plugins/contact-form-manager/"  title="FAQ">FAQ</a>';
		$links[] = '<a href="http://docs.xyzscripts.com/wordpress-plugins/contact-form-manager/"  title="Read Me">README</a>';
		$links[] = '<a href="http://xyzscripts.com/donate/1" title="Donate">Donate</a>';
		$links[] = '<a href="http://xyzscripts.com/support/" class="xyz_support" title="Support"></a>';
		$links[] = '<a href="http://twitter.com/xyzscripts" class="xyz_twitt" title="Follow us on Twitter"></a>';
		$links[] = '<a href="https://www.facebook.com/xyzscripts" class="xyz_fbook" title="Like us on Facebook"></a>';
		$links[] = '<a href="https://plus.google.com/+Xyzscripts/" class="xyz_gplus" title="+1 us on Google+"></a>';
		$links[] = '<a href="http://www.linkedin.com/company/xyzscripts" class="xyz_linkedin" title="Follow us on LinkedIn"></a>';
	}
	return $links;
}
}
add_filter( 'plugin_row_meta','xyz_cfm_links',10,2);

?>