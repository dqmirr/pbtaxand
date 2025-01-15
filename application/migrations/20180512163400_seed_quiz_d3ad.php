<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Seed_quiz_d3ad extends CI_Migration {

	public function up()
	{
		$this->db->set('code', 'd3ad');
		$this->db->set('label', 'D3AD');
		$this->db->set('seconds', 1200);
		$this->db->set('library_code', 'personal');
		$this->db->set('sub_library_code', 'd3ad');
		
		$this->db->insert('quiz');
	}
	
	public function down()
	{
		$this->db->where('code', 'd3ad');
		$this->db->delete('quiz');
	}
}
