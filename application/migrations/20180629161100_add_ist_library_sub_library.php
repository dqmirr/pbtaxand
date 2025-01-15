<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_ist_library_sub_library extends CI_Migration {

	public function up()
	{
		$this->db->set('code', 'ist');
		$this->db->insert('library');
		
		$data = array(
			array('library_code'=>'ist', 'code' => 'zr'),
			array('library_code'=>'ist', 'code' => 'fa'),
			array('library_code'=>'ist', 'code' => 'wu'),
		);
		
		// Seed
		$this->db->insert_batch('sub_library', $data);
	}
	
	public function down()
	{
		$data = array(
			'zr',
			'fa',
			'wu',
		);
		$this->db->where_in('code', $data);
		$this->db->delete('sub_library');
		
		$this->db->where('code', 'ist');
		$this->db->delete('library');
	}

}
