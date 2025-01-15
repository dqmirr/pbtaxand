<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('render_stylesheets'))
{
	function render_stylesheets($stylesheets)
	{
		foreach($stylesheets as $stylesheet){
			$results .= '<link rel="stylesheet" href="'.$stylesheet['link'].'"/>';
		}
		return $results;
	}
}

if (!function_exists('render_javascripts'))
{
	function render_javascripts($javascripts)
	{
		foreach($javascripts as $javascript){
			$results .= '<script src="'.$javascript['src'].'"></script>';
		}
		return $results;
	}
}

?>
