<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Seed_quiz_gti_img extends CI_Migration {

	public function up()
	{
		// 2D
		$this->db->set('code', 'gti_2d');
		$this->db->set('label', 'Subtest 6');
		$this->db->set('seconds', 300);
		$this->db->set('library_code', 'gti');
		$this->db->set('sub_library_code', 'gti_2d');
		
		$this->db->insert('quiz');
		
		// 3D
		$this->db->set('code', 'gti_3d');
		$this->db->set('label', 'Subtest 7');
		$this->db->set('seconds', 300);
		$this->db->set('library_code', 'gti');
		$this->db->set('sub_library_code', 'gti_3d');
		
		$this->db->insert('quiz');
	}
	
	public function down()
	{
		$this->db->where_in('code', array('gti_2d', 'gti_3d'));
		$this->db->delete('quiz');
	}
}
