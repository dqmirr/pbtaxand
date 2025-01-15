<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formasi_model extends Ci_Model {
	
	public function dropdown_all($where = array())
	{
		$list = array('' => 'Belum Pilih Formasi');
		
		$this->db->select('code, label');
		$this->db->where($where);
		$get = $this->db->get('formasi');
		
		foreach ($get->result() as $row)
		{
			$list[$row->code] = $row->label;
		}
		
		return $list;
	}
}
