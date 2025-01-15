<?php
// namespace Trait;
// defined('BASEPATH') OR exit('No direct script access allowed');
// var_dump("multiplechoice");

trait Multiplechoice_story{
	public function field_m_story_code($value, $primary_key, $obj){
		$admin_url = $this->admin_url;
		$edit_url = $admin_url.'/story/multiplechoice/index/edit/'.$value;
		$add_url = $admin_url.'/story/multiplechoice/index/add';
		if($value){
			return '<a class="btn btn-primary" href="'.base_url($edit_url).'">Edit Story</a>';
		} else {
			return '<a class="btn btn-primary" href="'.base_url($add_url).'">Add Story</a>';
		}
	}
}
?>
