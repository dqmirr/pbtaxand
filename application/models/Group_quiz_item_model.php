<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Group_quiz_item_model extends Ci_Model {
	public function __construct()
	{
		parent::__construct();
        $this->load->database();
	}

	public function get_quiz_code_by_group($code){
		$this->db->select("quiz_code");
		$this->db->where("group_quiz_code", $code);
		$get = $this->db->get("group_quiz_items");
		return $get->result_array();
	}
}
