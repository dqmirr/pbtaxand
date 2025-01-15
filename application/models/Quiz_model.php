<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_model extends Ci_Model {
	
	public function list_all($where = array())
	{
		$this->db->where($where);
		$get = $this->db->get('quiz');
		
		return $get->result();
	}

	public function get_group_items($group_quiz_code){
		$res = array();

		$this->db->select('gqi.group_quiz_code, gqi.quiz_code, q.label');
		$this->db->where('gqi.group_quiz_code', $group_quiz_code);
		$this->db->join('quiz q','gqi.quiz_code = q.code', 'left');
		$this->db->order_by("gqi.ordering", "ASC");
		$query = $this->db->get('group_quiz_items gqi')->result_array();
		$res["data"] = $query;
		return $res;
	}

}
