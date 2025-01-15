<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_auth_model extends Ci_Model
{
	public function validate($username, $password, &$output = array())
	{
		$this->db->where('username', $username);
		$this->db->where('password', sha1($password));
		$this->db->limit(1);
		
		$get = $this->db->get('admins');
		
		if ($output = $get->first_row('array'))
		{
			$output['is_admin'] = true;
			
			return true;
		}
		
		return false;
	}
}
