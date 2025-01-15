<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Seed_quiz_cti extends CI_Migration {

	public function up()
	{
		$this->db->set('code', 'cti');
		$this->db->set('label', 'CTI');
		$this->db->set('seconds', 1200);
		$this->db->set('library_code', 'personal');
		$this->db->set('sub_library_code', 'cti');
		
		$this->db->insert('quiz');
	}
	
	public function down()
	{
		$this->db->where('code', 'cti');
		$this->db->delete('quiz');
	}
}
