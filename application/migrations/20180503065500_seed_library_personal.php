<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Seed_library_personal extends CI_Migration {

	public function up()
	{
		$this->db->set('code', 'personal');		
		$this->db->insert('library');
	}
	
	public function down()
	{
		$this->db->where('code', 'personal');
		$this->db->delete('library');
	}
}
