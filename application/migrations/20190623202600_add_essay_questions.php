<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_essay_questions extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'auto_increment' => TRUE,
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				),
			'quiz_code' => array(
				'type' => 'varchar',
				'constraint' => 100,
			),
			'nomor' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'question' => array(
				'type' => 'varchar',
				'constraint' => 250
				),
			)
		);
		
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_field('FOREIGN KEY `fk_quiz_code_essay_q` (quiz_code) REFERENCES quiz (code) ON UPDATE CASCADE');
		$this->dbforge->add_field('UNIQUE KEY (`quiz_code`, `nomor`)');
		$this->dbforge->add_field('INDEX (`id`,`quiz_code`)');
		$this->dbforge->create_table('essay_questions');
		
		// Check library
		$this->db->select('code');
		$this->db->where('code', 'essay');
		$get = $this->db->get('library');
		
		if ($get->num_rows() == 0)
		{
			$this->db->set('code', 'essay');
			$this->db->insert('library');
		}
	}
	
	public function down()
	{
		$this->dbforge->drop_table('essay_questions');
	}
	
}
