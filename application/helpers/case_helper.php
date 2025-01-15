<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('title'))
{
	function title($text)
	{
		return ucwords(str_replace("_"," ",$text));
	}
}
?>
