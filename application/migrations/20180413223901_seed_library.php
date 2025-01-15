<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Seed_library extends CI_Migration {

	public function up()
	{
		// Seed
		$this->db->insert('library', 
			array(
				'code' => 'multiplechoice'
			)
		);
	}

}
