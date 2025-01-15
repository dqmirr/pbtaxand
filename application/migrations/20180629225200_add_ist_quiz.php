<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_ist_quiz extends CI_Migration {

	public function up()
	{		
		// Group
		$data = array(
			'code' => 'ist'
		);
		$this->db->insert('group_quiz', $data);
		
		// Quiz
		$data = array(
			array('label' => 'Subtest 6', 'code'=>'ist_zr', 'seconds' => 480, 'library_code' => 'ist', 'sub_library_code' => 'zr'),
			array('label' => 'Subtest 7', 'code'=>'ist_fa', 'seconds' => 480, 'library_code' => 'ist', 'sub_library_code' => 'fa'),
			array('label' => 'Subtest 8', 'code'=>'ist_wu', 'seconds' => 480, 'library_code' => 'ist', 'sub_library_code' => 'wu'),
		);
		$this->db->insert_batch('quiz', $data);
		
		// Group Items
		$data = array(
			array('group_quiz_code' => 'ist', 'quiz_code' => 'ist_zr'),
			array('group_quiz_code' => 'ist', 'quiz_code' => 'ist_fa'),
			array('group_quiz_code' => 'ist', 'quiz_code' => 'ist_wu'),
		);
		$this->db->insert_batch('group_quiz_items', $data);
		
		// Quiz (Group)
		$data = array(
			'label' => 'IST', 'code' => 'ist', 'seconds' => 0, 'group_quiz_code' => 'ist',
		);
		$this->db->insert('quiz', $data);
	}
	
	public function down()
	{
		$this->db->where('group_quiz_code', 'ist');
		$this->db->delete('group_quiz_items');
		
		$data = array(
			'ist',
			'ist_zr',
			'ist_fa',
			'ist_wu',
		);
		$this->db->where_in('code', $data);
		$this->db->delete('quiz');
		
		$this->db->where('code', 'ist');
		$this->db->delete('group_quiz');
	}

}
