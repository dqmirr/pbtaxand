<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Setting_model extends Ci_Model {
	function find_settings_by_name($name){
		$this->db->where("name",$name);
		$get = $this->db->get('settings');
		
		return $get->result();
	}

	function find_by_name($name){
		$this->db->where("name",$name);
		$get = $this->db->get('settings');
		
		return $get->result();
	}

	function get_quiz_setting(){
		$this->db->where_in("name",[
			'is_show_quiz_label'
		]);
		$settings = $this->db->get('settings')->result();

		if(count($settings) > 0){
			foreach ($settings as $setting){
				
				if($setting->name == 'is_show_quiz_label'){
					$is_show_quiz_label = (bool) $setting->value;
				}

				if($setting->name != 'is_show_quiz_label'){
					$this->db->insert('settings', [
						'name' => 'is_show_quiz_label',
						'value' => 1
					]);
					$is_show_quiz_label = 1;
				}

			}

		} else {
			$this->db->insert('settings', [
				'name' => 'is_show_quiz_label',
				'value' => 1
			]);
			$is_show_quiz_label = 1;
		}

		return [
			'is_show_quiz_label' =>	$is_show_quiz_label
		];
	}
}
?>
