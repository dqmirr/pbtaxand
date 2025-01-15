<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_multiplechoice_tables extends CI_Migration {

	public function up()
	{
		// Tidak usah pake dbforge, pake db query biasa biar cepat

		$sql_multiplechoice_img = "
			create table if not exists multiplechoice_img (
				`code` varchar(50) primary key not null,
				`img_path` text null
			) engine=ndbcluster;
		";
		
		$sql_multiplechoice_question = "
			create table if not exists multiplechoice_question (
				id int not null primary key auto_increment,
				jenis_soal varchar(100) not null default '',
				sulit decimal(3,2) not null default 0.00,
				nomor int not null default 0,
				question text not null,
				parent_nomor int null,
				multiplechoice_img_code varchar(50) null,
				jawaban varchar(10) not null default '',
				
				foreign key (multiplechoice_img_code) references multiplechoice_img (code)
			) engine=ndbcluster;
		";
		
		$sql_multiplechoice_choices = "
		create table if not exists multiplechoice_choices (
			id int not null primary key auto_increment,
			multiplechoice_question_id int,
			choice char(1) not null default '' comment 'A,B,C,D',
			label varchar(256) not null default '',
			
			foreign key (multiplechoice_question_id) references multiplechoice_question (id)
		) engine=ndbcluster;
		";
		
		$sql_multiplechoice_jawaban = "
		create table if not exists multiplechoice_jawaban (
			users_id int unsigned,
			multiplechoice_question_id int,
			multiplechoice_choices_id int,
			date_created TIMESTAMP not null default CURRENT_TIMESTAMP,
			jenis_soal varchar(100) not null default '',
			
			primary key (users_id, multiplechoice_question_id),
			foreign key (users_id) references `users` (id),
			foreign key (multiplechoice_question_id) references multiplechoice_question (id),
			foreign key (multiplechoice_choices_id) references multiplechoice_choices (id)
		) engine=ndbcluster;
		";
		
		$this->db->query($sql_multiplechoice_img);
		$this->db->query($sql_multiplechoice_question);
		$this->db->query($sql_multiplechoice_choices);
		$this->db->query($sql_multiplechoice_jawaban);
	}

	public function down()
	{
		$this->dbforge->drop_table('multiplechoice_jawaban', true);
		$this->dbforge->drop_table('multiplechoice_choices', true);
		$this->dbforge->drop_table('multiplechoice_question', true);
		$this->dbforge->drop_table('multiplechoice_img', true);
	}
	
}
