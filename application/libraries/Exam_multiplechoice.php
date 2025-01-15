<?php defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'libraries/Class_Exam.php');

class Exam_multiplechoice extends Class_Exam {
	
	var $ci;
	var $img_dir;
	
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->img_dir = 'assets/images/';
	}
	
	protected function generate_question($code, $is_tutorial = 0)
	{
		$return = array();
		$result = array();
		$rows = array();
		$answers = (object) array();
		$nomor = 1;
		
		$config_group = array(
			'Incomplete Sentence' => array(
				'jumlah_soal' => 20
			),
			'Reading Comprehension - Single Passage' => array(
				'jumlah_soal' => 20,
				'group_title' => 'Reading Comprehension',
				'always_show_story' => true,
			),
			'Reading Comprehension - Double Passage' => array(
				'jumlah_soal' => 10,
				'group_title' => 'Reading Comprehension',
				'always_show_story' => true,
			),
			'Reading' => array(
				'jumlah_soal' => 105,
				'group_title' => 'Reading Comprehension',
				'always_show_story' => true,
			),
			'Grammar' => array(
				'jumlah_soal' => 231,
				'group_title' => 'Grammar',
			),
			'Written' => array(
				'jumlah_soal' => 94,
				'group_title' => 'Written',
			),
			'Structure' => array(
				'jumlah_soal' => 90,
				'group_title' => 'Structure',
				'always_show_story' => true
			),
		);
		
		/*
		// kalau sudah selesai test ini dicomment lagi
		$config_group['Incomplete Sentence']['jumlah_soal'] = 90;
		$config_group['Reading Comprehension - Single Passage']['jumlah_soal'] = 66;
		$config_group['Reading Comprehension - Double Passage']['jumlah_soal'] = 32;
		*/
		
		// Timer
		$this->ci->db->select('seconds');
		$this->ci->db->where('code', $code);
		$get = $this->ci->db->get('quiz');
		$row = $get->first_row();

		$seconds = $row->seconds;
		$return['seconds'] = $seconds;
		
		// Check apakah punya group_name atau tidak
		// Jika ada maka bedakan perlakuannya
		$sql = "SELECT count(group_name) as total FROM multiplechoice_question WHERE jenis_soal = ? AND group_name IS NOT NULL";
		$get = $this->ci->db->query($sql, array($code));
		
		$total_group_name = 0;
		
		if ($row = $get->first_row())
			$total_group_name = $row->total;
		
		// SOAL BIASA
		if ($total_group_name == 0)
		{
			$sql = "
				SELECT
					a.*,
					b.img_path
				FROM
				(
					SELECT 
						a.id as id_soal,
						b.id as id_jawaban,
						a.nomor,
						a.question as soal,
						a.parent_nomor,
						a.multiplechoice_img_code,
						b.choice,
						b.label
					FROM 
						multiplechoice_question a
						JOIN multiplechoice_choices b on (a.id = b.multiplechoice_question_id)
					WHERE 
						jenis_soal = ?
					ORDER BY
						b.multiplechoice_question_id asc,
						b.choice asc
				) a
				LEFT JOIN multiplechoice_img b ON (a.multiplechoice_img_code = b.code)
			";
			
			$get = $this->ci->db->query($sql, array($code));

			$rs = $get->result_array();

			$arr_id_soal = array();
			$arr_parent_nomor_by_id_soal_lookup = array();
			$arr_id_soal_by_nomor_lookup = array();
			$arr_id_soal_index_lookup = array();
			
			foreach ($rs as $row)
			{
				$id_soal = $row['id_soal'];
				
				if (! isset($push[$id_soal]))
				{
					$push[$id_soal] = array(
						'id_soal' => $id_soal,
						'soal' => $row['soal'],
						'jawaban' => array(),
						'show_next' => 0,
						'img_path' => $row['img_path'] != null ? base_url($this->img_dir.$row['img_path']) : $row['img_path'],
					);
					
					$arr_id_soal[] = $id_soal;
					$arr_id_soal_by_nomor_lookup[$row['nomor']] = $id_soal;
					
					// Kalau ada parent, rekam parentnya agar saat dishuffle bisa disusun lagi.
					if ($row['parent_nomor'] != null)
					{
						$arr_parent_nomor_by_id_soal_lookup[$id_soal] = $row['parent_nomor'];
					}
				}
				
				$push[$id_soal]['jawaban'][] = array(
					'choice' => strtolower($row['choice']),
					'label'	=> $row['label'],
					'id' => $row['id_jawaban'],
				);
			}
			
			shuffle($arr_id_soal);
			
			function get_index($find_id_soal, $arr_id_soal)
			{
				foreach ($arr_id_soal as $index => $id_soal)
				{
					if ($find_id_soal == $id_soal)
					{
						return $index;
					}
				}
			}
			
			// Susun soal agar yg punya parent selalu di bawah parentnya
			foreach ($arr_parent_nomor_by_id_soal_lookup as $id_soal => $no)
			{
				$parent_id_soal = $arr_id_soal_by_nomor_lookup[$no];
				$parent_index = get_index($parent_id_soal, $arr_id_soal);
				$index = get_index($id_soal, $arr_id_soal);
				
				// nilai di index yg lama dijadikan 0, jadi nanti bisa kita hapus
				$arr_id_soal[$index] = 0;
				
				// increment show_next parent
				$push[$parent_id_soal]['show_next']++;
				
				// pindahkan index ke bawah parent_index
				array_splice($arr_id_soal, ($parent_index + 1), 0, $id_soal);
				
				// re-index
				$arr_id_soal = array_values($arr_id_soal);
			}
			
			// Hapus index yang id_soal = 0
			foreach ($arr_id_soal as $index => $id_soal)
			{
				if ($id_soal == 0) unset($arr_id_soal[$index]);
			}
			
			// re-index
			$arr_id_soal = array_values($arr_id_soal);
			
			foreach ($arr_id_soal as $id_soal)
			{	
				$row = $push[$id_soal];
				
				// Kalau ada parent_nomor, check question-nya, apakah di sana ada {[0-9]*}, kalau ada maka ganti dengan nomor dari parent-nya
				if (isset($arr_parent_nomor_by_id_soal_lookup[$id_soal]))
				{
					$no = $arr_parent_nomor_by_id_soal_lookup[$id_soal];
					$parent_id_soal = $arr_id_soal_by_nomor_lookup[$no];
					$parent_index = get_index($parent_id_soal, $arr_id_soal);
					$parent_new_nomor = $parent_index + 1;
					
					$row['soal'] = preg_replace("/({[0-9]*})/", $parent_new_nomor, $row['soal']);
				}
				
				$row['no'] = $nomor;
				$rows[1000+$nomor] = $row;
				$nomor++;
			}
		}
		// SOAL DENGAN GROUP
		else
		{
			// Pisahkan berdasakan group
			$sql = 'select group_name as name from multiplechoice_question WHERE jenis_soal = ? group by group_name';
			$get_group = $this->ci->db->query($sql, array($code));
			
			$arr_story = array();
			$arr_story_index = 0;
			$arr_story_nomor = array();
			
			foreach ($get_group->result() as $group)
			{
				$jumlah_soal = $config_group[$group->name]['jumlah_soal'];
				$arr_id_soal = array();
				$arr_soal_by_id_soal_lookup = array();
				
				$arr_story_group = array();
				$arr_story_group_lookup = array();
				
				$this->ci->db->where('jenis_soal', $code);
				$this->ci->db->where('group_name', $group->name);
				
				$get = $this->ci->db->get('multiplechoice_question');
				$question_result = $get->result('array');
				
				foreach ($question_result as $row)
				{
					// Kalau tidak punya multiplechoice_story_code 
					if (! $row['multiplechoice_story_code'])
					{
						$arr_id_soal[] = $row['id'];
						$arr_soal_by_id_soal_lookup[$row['id']] = $row;
					}
					// Kalau ada story_code
					else
					{
						$arr_story_group[] = $row['multiplechoice_story_code'];
						$arr_story_group_lookup[$row['multiplechoice_story_code']][] = $row;
					}
				}
				
				if (count($arr_id_soal) > 0)
				{
					shuffle($arr_id_soal);
					$arr_id_soal = array_values($arr_id_soal);
				}
				
				// Punya Story
				if (count($arr_story_group) > 0)
				{
					$arr_story_group = array_unique($arr_story_group);

					shuffle($arr_story_group);
					$arr_story_group = array_values($arr_story_group);
					
					foreach ($arr_story_group as $index => $story_code)
					{
						$story_group_top_id = 0;
						$this_story_index = null;
						$story_group = $arr_story_group_lookup[$story_code];
						$always_show_story = isset($config_group[$group->name]['always_show_story']) ? $config_group[$group->name]['always_show_story'] : false;
						
						foreach ($story_group as $row)
						{
							if ($story_group_top_id == 0)
							{
								// Get Story
								$this->ci->db->where('code', $story_code);
								$get_story = $this->ci->db->get('multiplechoice_story');
								$story = $get_story->first_row('array');
								
								// Di dalamnya bisa jadi ada image, maka convert dulu
								$text = preg_replace_callback('/{assets:(.*)}/', function($matches){
									return base_url('assets/'.$matches[1]);
								}, $story['story']);
								
								$arr_story[$arr_story_index] = $text;
								$story_group_top_id = $row['id'];
								$this_story_index = $arr_story_index;
								
								// Jika $always_show_story === false, maka hanya tampilkan soal yg pertama 
								if (false === $always_show_story)
								{
									$row['story_index'] = $this_story_index;
								}
								
								$arr_story_index += 1;
							}
							
							$row['group_name'] = isset($config_group[$group->name]['group_title']) ? $config_group[$group->name]['group_title'] : $group->name;
							
							if (true === $always_show_story)
							{
								$row['story_index'] = $this_story_index;
							}
							
							$arr_id_soal[] = $row['id'];
							$arr_soal_by_id_soal_lookup[$row['id']] = $row;
						}
					}
				}
				
				foreach ($arr_id_soal as $index => $id_soal)
				{
					if ($index <= ($jumlah_soal - 1))
					{
						$soal = $arr_soal_by_id_soal_lookup[$id_soal];
						$row = array(
							'id_soal' => $id_soal,
							'soal' => $soal['question'],
							'jawaban' => array(),
							'show_next' => 0,
							'post_soal' => isset($soal['post_question']) ? $soal['post_question'] : null,
							'no' => $nomor,
						);

						if (isset($soal['group_name']))
						{
							$row['group_name'] = $soal['group_name'];
						}
							
						if (isset($soal['story_index']))
						{
							$row['story_index'] = $soal['story_index'];
						
							// Ada kemungkinan storynya mengandung {angka}, maka cari kalau ada sesuai nomor maka soalnya direplace
							
							$pattern = '/(\{'.$soal['nomor'].'\})/';
							$replacement = '<strong class="text-primary"><u>&nbsp;&nbsp;'.$nomor.'&nbsp;&nbsp;</u></strong>';
							
							$arr_story[$soal['story_index']] = preg_replace($pattern, $replacement, $arr_story[$soal['story_index']]);
							
							// Ada kemungkinan juga imagenya mengandung gambar
							$pattern_img = '/\[IMG:(.*)\]/';
							$replacement_img = '<img src="'.base_url($this->img_dir).'$1">';
							
							$arr_story[$soal['story_index']] = preg_replace($pattern_img, $replacement_img, $arr_story[$soal['story_index']]);
							
							$arr_story_nomor[$soal['story_index']][] = $nomor;
						}
						
						// Ambil jawaban untuk soal ini
						$this->ci->db->where('multiplechoice_question_id', $id_soal);
						$this->ci->db->order_by('choice ASC');
						$get_choices = $this->ci->db->get('multiplechoice_choices');
						
						$order_jawaban = 0;
						
						foreach ($get_choices->result('array') as $choice)
						{
							$row['jawaban'][$order_jawaban] = array(
								'choice' => strtolower($choice['choice']),
								'label'	=> $choice['label'],
								'id' => $choice['id'],
							);
							
							$order_jawaban++;
						}
						$rows[1000+$nomor] = $row;
						$nomor++;
					}
				}
			}
			
			// tambahkan petunjuk soal mana saja yg menggunakan soal ini berdasarkan $arr_story_nomor
			foreach ($arr_story_nomor as $story_index => $arr_nomor)
			{
				$arr_story[$story_index] = '<strong><em>Questions '.min($arr_nomor).'-'.max($arr_nomor).'</em></strong><hr />' . $arr_story[$story_index];
			}
			
			$result['arr_story'] = $arr_story;
			//$result['total'] = $total_group_name;
			$result['rows'] = array();
		}
		
		$result['total'] = count($rows);
		$result['rows'] = $rows;
		$result['answers'] = $answers;
		// Untuk ditampilkan ke user
		if (isset($arr_story))
			$return['arr_story'] = $arr_story;
		
		$return['rows'] = $rows;
		$return['total'] = count($rows);
		$return['answers'] = $answers;
		

		// Untuk disimpan (override)
		$rows = json_encode($result);
		
		$dbsave = $this->ci->load->database('save', TRUE);
		
		// Simpan Paket Soal
        $dbsave->set('rows', $rows);
        $dbsave->set('quiz_code', $code);
        $dbsave->set('is_tutorial', $is_tutorial);
        $dbsave->insert('quiz_paket_soal');
		
		return $dbsave->insert_id();
	}
    
	public function generate_questions($quiz_code)
	{
			$this->exam_generate_questions($quiz_code, 'multiplechoice_question');
	}

	public function get_questions_without_gen($code, $is_tutorial){

		// get waktu selesai quiz perdetik
		$this->ci->db->select('seconds');
		$this->ci->db->where('code', $code);
		$get = $this->ci->db->get('quiz');
		$row = $get->first_row();

		$return = $this->get_plain_questions($code);
		$seconds = $row->seconds;
		$return['seconds'] = $seconds;

		// get settings
		$this->ci->db->select('value');
		$this->ci->db->where('name', $code.'_seconds_extra');
		$get_settings = $this->ci->db->get('settings');

		if ($row_settings = $get_settings->first_row())
		{
			$return['seconds_extra'] = $row_settings->value;
		}

		// Simpan ke users_quiz_log
		$dbsave = $this->ci->load->database('save', TRUE);
                    
		$query = '
		INSERT INTO users_quiz_log (`rows`, `quiz_paket_soal_id`, seconds, time_start, quiz_code, users_id) VALUES (?,?,?,?,?,?)
		ON DUPLICATE KEY UPDATE `rows` = ?, seconds = ?, time_start = ?';

		$time_start = date('Y-m-d H:i:s');
		
		$return['validation'] = md5($time_start);

		$dbsave->query(
				$query,
				array(
						'[]',
						NULL,
						$seconds,
						$time_start,
						$code,
						$this->ci->session->userdata('id'),
						'[]',
						$seconds,
						$time_start,
				)
		);

		/**
		 * restun array type
		 * return = array[]
		 * return have :
		 * 	- seconds -> type integer
		 *  - seconds_extra -> type integer (optional)
		 *  - validation -> type string
		 *  - rows -> type json
		 * 
		 */
		return $return;
	}
	
	public function get_plain_questions($code){
		
		$sql_question = "SELECT a.id, a.nomor, a.multiplechoice_story_code, a.question, a.post_question, a.group_name, b.keterangan as category FROM multiplechoice_question a 
										LEFT JOIN multiplechoice_question_category b ON (b.id = a.multiplechoice_question_category_id) WHERE a.jenis_soal = ? ORDER BY nomor";
		$get = $this->ci->db->query($sql_question, array($code));
		$question_result = $get->result('array');

		$jumlah_soal = count($question_result);
		$arr_id_soal = array();
		$arr_soal_by_id_soal_lookup = array();

		$arr_story_group = array();
		$arr_story_group_lookup = array();
		$nomor = 1;
		$arr_story_index = 1;

		$return = array();

		// pemisahan question yang memiliki story atau tidak
		foreach($question_result as $row){
			if (! $row['multiplechoice_story_code'])
			{
				$arr_id_soal[] = $row['id'];
				$arr_soal_by_id_soal_lookup[$row['id']] = $row;
			}
			// Kalau ada story_code
			else
			{
				$arr_story_group[$row['multiplechoice_story_code']] = $row['multiplechoice_story_code'];
				$arr_story_group_lookup[$row['multiplechoice_story_code']][] = $row;
			}
		}

		
		if(count($arr_story_group) > 0)
		{
			$arr_story_group = array_values($arr_story_group);
			$this_story_index = 1;
			$story_group_top_id = 0;
			foreach($arr_story_group as $index => $story_code)
			{
				$story_group = $arr_story_group_lookup[$story_code];
				
				foreach ($story_group as $row)
				{
					if ($story_group_top_id == 0)
					{
						// Get Story
						$this->ci->db->where('code', $story_code);
						$get_story = $this->ci->db->get('multiplechoice_story');
						$story = $get_story->first_row('array');
						
						// Di dalamnya bisa jadi ada image, maka convert dulu
						$text = preg_replace_callback('/{assets:(.*)}/', function($matches){
							return base_url('assets/'.$matches[1]);
						}, $story['story']);
						
						$arr_story[$arr_story_index] = $text;
						$story_group_top_id = $row['id'];
						$this_story_index = $arr_story_index;
						
						$row['story_index'] = $this_story_index;

						$arr_id_soal[] = $row['id'];
						$arr_soal_by_id_soal_lookup[$row['id']] = $row;
					}
					$story_group_top_id = 0;
					$arr_story_index += 1;
				}
			}
		}

		foreach ($arr_id_soal as $index => $id_soal)
		{
			if ($index <= ($jumlah_soal - 1))
			{
				$soal = $arr_soal_by_id_soal_lookup[$id_soal];
				$nomor = $soal["nomor"];
				$row = array(
					'id_soal' => $id_soal,
					'soal' => $soal['question'],
					'jawaban' => array(),
					'show_next' => 0,
					'post_soal' => isset($soal['post_question']) ? $soal['post_question'] : null,
					'no' => $nomor,
				);
				
				if(isset($soal['category']))
				{
					$row['group_name'] = $soal['category'];
				}elseif (isset($soal['group_name']))
				{
					$row['group_name'] = $soal['group_name'];
				}
				
				
				if (isset($soal['story_index']))
				{
					$row['story_index'] = $soal['story_index'];
					
					// Ada kemungkinan storynya mengandung {angka}, maka cari kalau ada sesuai nomor maka soalnya direplace
					
					$pattern = '/(\{'.$soal['nomor'].'\})/';
					$replacement = '<strong class="text-primary"><u>&nbsp;&nbsp;'.$nomor.'&nbsp;&nbsp;</u></strong>';
					
					$arr_story[$soal['story_index']] = preg_replace($pattern, $replacement, $arr_story[$soal['story_index']]);
					
					// Ada kemungkinan juga imagenya mengandung gambar
					$pattern_img = '/\[IMG:(.*)\]/';
					$replacement_img = '<img src="'.base_url($this->img_dir).'$1">';
					
					$arr_story[$soal['story_index']] = preg_replace($pattern_img, $replacement_img, $arr_story[$soal['story_index']]);
					
					$arr_story_nomor[$soal['story_index']][] = $nomor;
				}
				
				// Ambil jawaban untuk soal ini
				$this->ci->db->where('multiplechoice_question_id', $id_soal);
				$this->ci->db->order_by('choice ASC');
				$get_choices = $this->ci->db->get('multiplechoice_choices');
				
				$order_jawaban = 0;
				
				foreach ($get_choices->result('array') as $choice)
				{
					$row['jawaban'][$order_jawaban] = array(
						'choice' => strtolower($choice['choice']),
						'label'	=> $choice['label'],
						'id' => $choice['id'],
					);
					
					$order_jawaban++;
				}
				$rows[1000+$nomor] = $row;
				$nomor++;
			}
		}

		// tambahkan petunjuk soal mana saja yg menggunakan soal ini berdasarkan $arr_story_nomor
		foreach ($arr_story_nomor as $story_index => $arr_nomor)
		{
			$arr_story[$story_index] = '<strong><em>Questions '.min($arr_nomor).'-'.max($arr_nomor).'</em></strong><hr />' . $arr_story[$story_index];
		}
		
		// $result['arr_story'] = $arr_story;
		//$result['total'] = $total_group_name;
		// $result['rows'] = array();

		// $result['total'] = count($rows);
		// $result['rows'] = $rows;
		// $result['answers'] = $answers;
		// Untuk ditampilkan ke user
		if (isset($arr_story))
			$return['arr_story'] = $arr_story;
		
		$return['rows'] = $rows;
		$return['total'] = count($rows);
		$return['answers'] = $answers;

		return $return;
	}


	public function restart($users_id, $code)
	{
		return $this->ci->db->delete('multiplechoice_jawaban', array('users_id'=>$users_id, 'jenis_soal'=>$code ));
	}
	
	public function save_answers($users_id, $code, $jawaban, $seconds_used = 0, $index = null)
	{        
		// Sebelum simpan, pastikan time_end belum terisi, kalau sudah terisi maka jangan dilanjutkan.

		// $this->ci->db->select('time_end');
		// $this->ci->db->where('quiz_code', $code);
		// $this->ci->db->where('users_id', $users_id);
		// $this->ci->db->where('time_end !=', null);
		
		// $get = $this->ci->db->get('users_quiz_log');
		// if ($get->num_rows() > 0)
		// return true;
		
		$this->ci->db->trans_start();
		
		$dbsave = $this->ci->load->database('save', TRUE);
		
		foreach($jawaban as $id_soal => $id_jawaban)
		{			
			$sql = "INSERT INTO multiplechoice_jawaban
				(`users_id`, `multiplechoice_question_id`, `multiplechoice_choices_id`, `jenis_soal`)
				VALUES
				(?, ?, ?, ?)
				ON DUPLICATE KEY UPDATE multiplechoice_choices_id = ?
			";

			$dbsave->query($sql, array(intval($users_id), intval($id_soal), intval($id_jawaban), $code, intval($id_jawaban)));
		}
	
		// Update users_quiz
		$dbsave->set('last_update', date('Y-m-d H:i:s'));
		$dbsave->set('seconds_used', $seconds_used);
		$dbsave->where('quiz_code', $code);
		$dbsave->where('users_id', $users_id);
		
		if ($index !== null)
		{
			$dbsave->set('index', $index);
		}
		$dbsave->update('users_quiz_log');
		
		
		$this->ci->db->trans_complete();
		return $this->ci->db->trans_status();
	}

	public function save_answers_group($users_id, $code, $jawaban, $seconds_used = 0, $index = null)
	{
		$this->ci->load->model('Users_quiz_log_model');
		$quiz = $this->ci->Users_quiz_log_model;
		$questions = $quiz->get_questions($code, $users_id);
		$jenis_soal = $questions->rows->{$index}->jenis_soal;

		$this->ci->db->set('last_update', date('Y-m-d H:i:s'));
		$this->ci->db->set('seconds_used', $seconds_used);
		$this->ci->db->where('quiz_code', $code);
		$this->ci->db->where('users_id', $users_id);
		
		if ($index !== null)
		{
			$this->ci->db->set('index', $index);
		}
		$this->ci->db->update('users_quiz_log');
		
		return $this->save_answers($users_id,$jenis_soal, $jawaban, $seconds_used, $index);
	}

	public function get_jawaban_group_quiz_code($code, $users_id){
		$results = array();
		$sql = "SELECT
								b.nomor, c.choice as jawaban, b.jawaban as jawaban_benar
							FROM
								multiplechoice_jawaban a,
								multiplechoice_question b,
								multiplechoice_choices c
							WHERE
								a.jenis_soal = b.jenis_soal
								AND
								a.multiplechoice_question_id = b.id
								AND
								a.multiplechoice_choices_id = c.id
								AND
								b.id = c.multiplechoice_question_id
								AND
								a.jenis_soal = ?
								AND
								a.users_id = ?
								AND
								a.multiplechoice_question_id = ?
							ORDER BY
								#b.nomor ASC
							a.date_created ASC";
		$this->ci->load->model('Users_quiz_log_model');
		$quiz = $this->ci->Users_quiz_log_model;
		$questions = $quiz->get_questions($code, $users_id);
		$list_jenis_soal = array();
		$list_id_soal = array();

		foreach($questions->rows as $soal){
			$id_soal = $soal->id_soal;
			$no = $soal->no;
			$jenis_soal = $soal->jenis_soal;
			$result = $this->ci->db->query($sql,array($jenis_soal, $users_id, $id_soal))->row();
			array_push(
				$results,
				(object) array(
					'nomor' => $no,
					'jawaban' => $result->jawaban,
					'jawaban_benar' => $result->jawaban_benar
				)
			);

		}
		return $results;
	}
    
    public function get_report($quiz_code, $users_id){
            $this->ci->load->model('Generate_exam_mdl');
            $this->ci->load->model('Multiplechoice_model');
            $this->ci->load->model('Users_quiz_log_model');
            $this->ci->load->model('Psyco_point_model');
            $this->ci->load->model('Psyco_bobot_model');

            if($this->ci->Generate_exam_mdl->has_group_quiz_code($quiz_code)){
                $list_jawaban = $this->ci->Multiplechoice_model->get_jawaban_group_quiz_code($quiz_code, $users_id);
            }else{
                $list_jawaban = $this->ci->Multiplechoice_model->getJawaban($users_id, $quiz_code);
            }
        
            

            $status = $this->ci->Users_quiz_log_model->get_status_quiz($users_id, $quiz_code);
            $bobot = $this->ci->Psyco_bobot_model->get_bobot($quiz_code);
            
            $total_benar = 0;
            $total_salah = 0;
            $total_point = 0;
            foreach($list_jawaban as $key => $value){
                $jawaban = $value->jawaban;
                $jawaban_benar = $value->jawaban_benar;
                if(!empty($jawaban) && !empty($jawaban_benar)){
                    if(strtoupper($jawaban) == strtoupper($jawaban_benar)){
                        $total_benar+=1;
                    } else {
                        $total_salah+=1;
                    }
                }
            }
            
            if($bobot)
            {
                $total_point = $total_benar * $bobot['bobot'];
            }else{
                $total_point = $total_benar;
            };
            
            $range_point = $this->ci->Psyco_point_model->get_point($quiz_code, $total_point);
            $point = 0;
            if(!empty($range_point)){
                $point = $range_point['point'];
            }

            return array(
                'users_id' => $users_id,
                'code' => $quiz_code,
                'status' => $status,
                'point' => $point,
                'detail' => array(
                    'benar' => $total_benar,
                    'salah' => $total_salah,
                    'total_bobot' => $total_point,
                    'bobot_per_soal' => $bobot['bobot'],
                ),
            );
        }

        public function get_psyco_point($users_id){
            
            $accounting_junior = $this->get_report('accounting_staf_level_junior', $users_id);
            
            $accounting_senior = $this->get_report('accounting_staf_level_senior', $users_id);
            
            
        
            $english_university = $this->get_report('english_university', $users_id);
//            return $english_university;
//            die;
            $english_diploma = $this->get_report('english_diploma', $users_id);

            if($accounting_senior['point'] == 0){
                $accounting = $accounting_junior['point'];
				$accounting_detail = $accounting_junior;
            }else{
                $accounting = $accounting_senior['point'];
				$accounting_detail = $accounting_senior;
            }

            if($english_university['point'] <= 0){
                $english = $english_diploma['point'];
				$english_detail = $english_diploma;
            } else {
                $english = $english_university['point'];
				$english_detail = $english_university;
            }


            return array(
                'ACCOUNTING' => ceil($accounting),
				'ACCOUNTING_DETAIL' => $accounting_detail,
                'ENGLISH' => ceil($english),
                'ENGLISH_DETAIL' => $english_detail
            );
        }

}
