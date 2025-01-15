<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Seed_sub_library_gti_img extends CI_Migration {

	public function up()
	{
		// 2D
		$this->db->set('library_code', 'gti');
		$this->db->set('code', 'gti_2d');
		
		$this->db->insert('sub_library');
		
		// 3D
		$this->db->set('library_code', 'gti');
		$this->db->set('code', 'gti_3d');
		
		$this->db->insert('sub_library');
	}
	
	public function down()
	{
		$this->db->where_in('code', array('gti_2d', 'gti_3d'));
		$this->db->delete('sub_library');
	}
}
