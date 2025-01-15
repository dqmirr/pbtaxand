<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends Ci_Model {

	public function get_by_username($username)
	{
		$this->db->where('username', $username);
		$get = $this->db->get('users');
		
		return $get->first_row();
	}
	
	public function list_all()
	{
		$get = $this->db->get('users');
		
		return $get->result();
	}
	
	public function insert($data, &$id=null)
	{
		$this->db->insert('users', $data);
		
		$id = $this->db->insert_id();
	}
	
	public function update($username, $data)
	{
		unset($data['username'], $data['id']);
		
		$this->db->where('username', $username);
		return $this->db->update('users', $data);
	}
	
	public function valid_username_id($username, $id)
	{
		$this->db->select('1', false);
		$this->db->where('username', $username);
		$this->db->where('id', $id);
		
		$get = $this->db->get('users');
		
		if ($get->num_rows() == 1)
			return true;
			
		return false;
	}

	public function get_by($field, $value)
	{
		if(is_string($field)){
			$this->db->where($field,$value);
		}
		$get = $this->db->get('users');
		return $get->result_array();
	}
}
