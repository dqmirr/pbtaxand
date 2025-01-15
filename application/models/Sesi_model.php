<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sesi_model extends Ci_Model {
	
	public function dropdown_all($where = array())
	{
		$list = array('' => 'Sesuai Formasi');
		
		$this->db->select('code, label, time_from, time_to');
		$this->db->where($where);
		$get = $this->db->get('sesi');
		
		foreach ($get->result() as $row)
		{
			$list[$row->code] = $row->label.' ('. $row->time_from .' - ' . $row->time_to .')';
		}
		
		return $list;
	}
}
