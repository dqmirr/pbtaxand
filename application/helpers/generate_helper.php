<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('generate_id_group'))
{
	function generate_id_group($text){
		$texts = expolode("_", $text);
		return $texts;
	}
}

if(!function_exists('generate_gti_info')) {
	function generate_gti_info($config_gti, $value){
		$ketwarna = $config_gti["keterangan_warna"];
		if(is_array($ketwarna)){
			$result = array();
			foreach($ketwarna as $val){
				if(intval($value) >= intval($val->value)){
					array_push($result,$val->label);
				}
			}
			return $result[0];
		} else {
			foreach($ketwarna as $val){
				if($val->id == 0){
					$result = $val->label;
				}
			}
			return $result;
		}
	}
}
?>
