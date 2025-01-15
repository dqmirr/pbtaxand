<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Seed_quiz_hexaco extends CI_Migration {

	public function up()
	{
		$this->db->set('code', 'hexaco');
		$this->db->set('label', 'Hexaco');
		$this->db->set('seconds', 1200);
		$this->db->set('library_code', 'personal');
		$this->db->set('sub_library_code', 'hexaco');
		
		$this->db->insert('quiz');
	}
	
	public function down()
	{
		$this->db->where('code', 'hexaco');
		$this->db->delete('quiz');
	}
}
