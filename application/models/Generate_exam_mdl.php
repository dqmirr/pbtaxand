<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Generate_exam_mdl extends Ci_Model {
	public function __construct()
	{
		parent::__construct();
        $this->load->database();
	}

	public function get_list_jenis_soal()
	{
		// $sql = "SELECT DISTINCT a.jenis_soal FROM multiplechoice_question a";
		$this->db->select('code as jenis_soal');
		$this->db->where('library_code', 'multiplechoice');
		$query = $this->db->get('quiz');
		return $query->result_array();
	}

	public function has_group_quiz_code($code){
		$this->db->select('code');
		$this->db->where('code', $code);
		$this->db->where('group_quiz_code !=', '');
		$this->db->where('group_quiz_code is NOT NULL', NULL, FALSE);
		$get = $this->db->get('quiz');
		$result = $get->result_array();
		if(count($result) > 0){
			return true;
		} else {
			return false;
		}
	}

	public function get_list_count_category($jenis_soal)
	{
		$sql = "
		SELECT mq.multiplechoice_question_category_id as id, mqc.keterangan as category_name, count(*) as category_total FROM multiplechoice_question mq 
		LEFT JOIN multiplechoice_choices mc ON (mc.multiplechoice_question_id = mq.id)
		LEFT JOIN multiplechoice_question_category mqc ON (mq.multiplechoice_question_category_id = mqc.id)
		WHERE mq.jenis_soal = ? GROUP BY id
		";

		$query = $this->db->query($sql, array(
			$jenis_soal
		));
		return $query->result_array();
	}

	public function get_list_data($jenis_soal){
		$result = array();
		$has_group_quiz = $this->has_group_quiz_code($jenis_soal);
		$setting_generate = $this->get_setting_generate($jenis_soal);
		$config = $setting_generate['data']['config'];
		if($has_group_quiz){
			$this->db->select('quiz_code');
			$this->db->where('group_quiz_code', $jenis_soal);
			$this->db->order_by('ordering ASC');
			$list_group_item = $this->db->get('group_quiz_items')->result_array();
			foreach($list_group_item as $item){
				$categories = $this->get_list_count_category($item['quiz_code']);
				foreach($categories as $category){
					$category_name = $category['category_name'];
					$category_total = $category['category_total'];
					$category_id = $category['id'];
					
					$difficulties = $this->get_list_count_difficulty($item['quiz_code'], $category_id);
					foreach($difficulties as $difficulty){

						$count = 1;
						$key_config = $difficulty['difficulty_id'].'_'.$category_id;
						if($config[$key_config]){
							$count = $config[$key_config];
						}
						array_push($result,array(
							'jenis_soal' => $item['quiz_code'],
							'group_quiz_code' => $jenis_soal,
							'category_id' => $category_id,
							'difficulty_id' => $difficulty['difficulty_id'],
							'category_name' => $category_name,
							'category_total' => $category_total,
							'count' => $count,
							'difficulty_name' => $difficulty['difficulty'],
							'difficulty_total' => $difficulty['total'],
							'link' => $item['quiz_code'].'#'.$category_id.'#'.$difficulty['difficulty_id'].'#'.$jenis_soal
						));
					}
				}
			}
		} else {
			$categories = $this->get_list_count_category($jenis_soal);
			foreach($categories as $category){
				$category_name = $category['category_name'];
				$category_total = $category['category_total'];
				$category_id = $category['id'];
				
				$difficulties = $this->get_list_count_difficulty($jenis_soal, $category_id);
				foreach($difficulties as $difficulty){
					$count = 1;
					$key_config = $difficulty['difficulty_id'].'_'.$category_id;
					if($config[$key_config]){
						$count = $config[$key_config];
					}
					array_push($result,array(
						'jenis_soal' => $jenis_soal,
						'group_quiz_code' => null,
						'category_id' => $category_id,
						'difficulty_id' => $difficulty['difficulty_id'],
						'category_name' => $category_name,
						'category_total' => $category_total,
						'count' => $count,
						'difficulty_name' => $difficulty['difficulty'],
						'difficulty_total' => $difficulty['total'],
						'link' => $jenis_soal.'#'.$category_id.'#'.$difficulty['difficulty_id']
					));
				}
			}
		}
		return $result;
	}

	public function get_list_count_difficulty($jenis_soal,$category_id)
	{
		$sql = "
			SELECT DISTINCT rk.keterangan as difficulty,mqc.keterangan as category, rk.id as difficulty_id, count(*) as total FROM multiplechoice_question mq 
			LEFT JOIN multiplechoice_question_category mqc ON (mq.multiplechoice_question_category_id = mqc.id)
			LEFT JOIN ref_kesulitan rk ON (rk.id = mq.ref_kesulitan_id)
			WHERE mq.jenis_soal = ? AND mq.multiplechoice_question_category_id = ? GROUP BY rk.id, mqc.id
		";
		$query = $this->db->query($sql,array(
			$jenis_soal,
			$category_id
		));
		return $query->result_array();
	}

	public function update_all_generated_soal($opt, $quiz_code){
		$list_quiz_paket = $this->db->select('id')->where('quiz_code', $quiz_code)->get('quiz_paket_soal')->result_array();

		$result = array();
		foreach($list_quiz_paket as $quiz_paket){
			$data = $this->algorithm_generate_soal($opt);
			$json = $data['json'];
			$group_quiz_code = $data['group_quiz_code'];
			$jenis_soal = $data['jenis_soal'];
			
			$update = $this->update_generated_soal($json,$quiz_paket['id'],0);
			
			if($json){
				array_push($result, array(
					'quiz_paket_id' => $quiz_paket['id'],
					'update' => $update
				));
			}			
		}

		return $result;

	}

	public function save_generate($opt){
		$setting_generate = array();
		$status = 'ok';
		$message = 'Save Generate Successfully';
		if($opt['jenis_soal']){
			$setting_generate['jenis_soal'] = $opt['jenis_soal'];
		} else {
			$status = 'failed';
			$message = 'jenis_soal is required';
		}

		if($opt['config']){
			$setting_generate['config'] = json_encode($opt['config']);
		} else {
			$status = 'failed';
			$message = 'config is required';
		}
		
		if($status == 'ok'){
			$count = $this->db->where('jenis_soal', $setting_generate['jenis_soal'])->count_all_results('setting_generate');
			if($count == 0){
				$data = $this->db->insert('setting_generate', $setting_generate);
			} else {
				$data = $this->db
						->set('config', $setting_generate['config'])
						->where('jenis_soal', $opt['jenis_soal'])
						->update('setting_generate');
			}
			if(!$data){
			 $status = 'failed';
			 $message = 'Save Generate Failed';
			}
		}

		return array(
			'status'=> $status,
			'data'=> null,
			'message'=> $message
		);
	}

	public function get_setting_generate($jenis_soal){
		$setting_generate = $this->db
							->select('jenis_soal, config')
							->where('jenis_soal', $jenis_soal)
							->get('setting_generate')
							->row_array();
	
		if($setting_generate){
			$status = 'ok';
			foreach($setting_generate as $key => $val){
				if($key == 'config'){
					$setting_generate['config'] = json_decode($val, JSON_OBJECT_AS_ARRAY);
				}
			}
			$data = $setting_generate;
			$message = 'Data result';
		} else {
			$status = 'failed';
			$data = null;
			$message = 'Faield data result';
		}
		
		return array(
			'status'=> $status,
			'data'=> $data,
			'message'=> $message
		);
	}

	public function algorithm_generate_soal($options){
		$length = count($options);

		$group_quiz_code = null;
		foreach($options as $key=>$value)
		{
			$jenis_soal = $this->db->escape_str($value[0]);
			$category_id = $this->db->escape_str($value[1]);
			$ref_kesulitan_id = $this->db->escape_str($value[2]);
			$limit_soal = $this->db->escape_str($value[3]);
			if(count($value) == 5){
				$group_quiz_code = $this->db->escape_str($value[4]);
			}else{
				$group_quiz_code = null;
			}
			
			$alias_table = strval($jenis_soal)."_".strval($key);
			if($key >= 1 && $key <= $length-1){
				$sql .= "UNION\n";
			}
			$sql .= "SELECT * FROM (SELECT id FROM multiplechoice_question 
						WHERE jenis_soal = '".$jenis_soal."'";
			if(!$category_id == ''){
				$sql .= " AND multiplechoice_question_category_id = ".$category_id;
			}
			if(!$ref_kesulitan_id == '')
			{
				$sql .= " AND ref_kesulitan_id = ".$ref_kesulitan_id;
			} else {
				$sql .= " AND ref_kesulitan_id is NULL OR ref_kesulitan_id = ''";
			}
			$sql .= " ORDER BY RAND()
			LIMIT ".$limit_soal.") as ".$alias_table."\n";
		}
		$sql1 = "SELECT sql_union.id FROM ($sql) as sql_union";

		$sql2 = "
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
						a.group_name,
						a.multiplechoice_img_code,
						a.multiplechoice_story_code,
						b.choice,
						b.label
					FROM 
						multiplechoice_question a
						JOIN multiplechoice_choices b on (a.id = b.multiplechoice_question_id)
					WHERE 
						a.id IN (".$sql1.")
					ORDER BY
						b.multiplechoice_question_id asc,
						b.choice asc
				) a
				LEFT JOIN multiplechoice_img b ON (a.multiplechoice_img_code = b.code)
			";

		$sql3 = "SELECT
				mq.jenis_soal,
				mq.id as id_soal,
				mc.id as id_jawaban,
				mq.nomor,
				mq.question as soal,
				mq.parent_nomor,
				mq.group_name,
				mq.multiplechoice_img_code,
				mq.multiplechoice_story_code,
				msc.story as story,
				rk.keterangan as tingkat_kesulitan,
				mqc.keterangan as category,
				mqc.id as category_id,
				mc.choice,
				mc.label,
				mi.img_path FROM multiplechoice_question mq 
			JOIN multiplechoice_choices mc ON (mc.multiplechoice_question_id = mq.id)
			LEFT JOIN multiplechoice_img mi ON (mi.code = mq.multiplechoice_img_code)
			LEFT JOIN ref_kesulitan rk ON (rk.id = mq.ref_kesulitan_id)
			LEFT JOIN multiplechoice_question_category mqc ON (mqc.id = mq.multiplechoice_question_category_id)
			LEFT JOIN multiplechoice_story msc ON (msc.code = mq.multiplechoice_story_code )
			WHERE mq.id IN (".$sql1.")";

		$query = $this->db->query($sql3);
		$rs = $query->result_array();

		$return = array();
		$result = array();
		$rows = array();
		$answers = (object) array();
		$nomor = 1;

		$arr_id_soal = array();
		$arr_parent_nomor_by_id_soal_lookup = array();
		$arr_id_soal_by_nomor_lookup = array();
		$arr_id_soal_index_lookup = array();
		
		$arr_story_group = array();
		$arr_story_group_lookup = array();

		$arr_story_index = 0;
		$arr_story = array();

		
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
					'post_soal' => isset($row['post_question']) ? $row['post_question'] : null
				);
				
				$arr_id_soal[] = $id_soal;
				$arr_id_soal_by_nomor_lookup[$row['nomor']] = $id_soal;

				if(isset($row["tingkat_kesulitan"])){
					$push[$id_soal]['tingkat_kesulitan'] = $row["tingkat_kesulitan"];
				}

				if(!is_null($row['group_name']))
				{
					$push[$id_soal]['group_name'] = $row['group_name'];
				}
				else if(is_null($row['group_name']) && !is_null($row['category']))
				{
					$push[$id_soal]['group_name'] = $row['category'];
					$push[$id_soal]['group_name_code'] = $row['category_id'];
				}

				if(!empty($group_quiz_code)){
					$push[$id_soal]['jenis_soal'] = $row['jenis_soal'];
				};
				
				// Kalau ada parent, rekam parentnya agar saat dishuffle bisa disusun lagi.
				if ($row['parent_nomor'] != null)
				{
					$arr_parent_nomor_by_id_soal_lookup[$id_soal] = $row['parent_nomor'];
				}

				if ($row['multiplechoice_story_code'])
				{
					$arr_story_group[] = $row['multiplechoice_story_code'];
					$arr_story_group_lookup[$row['multiplechoice_story_code']][] = $row;

					// Di dalamnya bisa jadi ada image, maka convert dulu
					$text = preg_replace_callback('/{assets:(.*)}/', function($matches){
						return base_url('assets/'.$matches[1]);
					}, $story['story']);

					$arr_story[$arr_story_index] = $row['story'];

					// menambahkan field story_index pada soal yang memiliki story
					$push[$id_soal]['story_index'] = $arr_story_index;

					// // Ada kemungkinan storynya mengandung {angka}, maka cari kalau ada sesuai nomor maka soalnya direplace
					$pattern = '/(\{'.$soal['nomor'].'\})/';
					$replacement = '<strong class="text-primary"><u>&nbsp;&nbsp;'.$nomor.'&nbsp;&nbsp;</u></strong>';
					
					$arr_story[$arr_story_index] = preg_replace($pattern, $replacement, $arr_story[$arr_story_index]);
					$arr_story_index +=1;
				}
			}
			
			$push[$id_soal]['jawaban'][] = array(
				'choice' => strtolower($row['choice']),
				'label'	=> $row['label'],
				'id' => $row['id_jawaban'],
			);

		}

		if($jenis_soal == 'wpt_taxand'){
			$push = $this->random_for_wpt($push);
		}


		// membuat nomor soal
		foreach($push as $key => $value){
			$value['no'] = $nomor;
			$rows[1000+$nomor] = $value;
			$nomor++;
		}

		$return['total'] = count($rows);
		// Tampilkan list story jika ada soal story
		if (isset($arr_story) && count($arr_story)>0)
		{
			$return['arr_story'] = $arr_story;
		}

		$return['rows'] = $rows;
		$return['answers'] = $answers;
		$json = json_encode($return);

		return array(
			'json' => $json,
			'group_quiz_code' => $group_quiz_code,
			'jenis_soal' => $jenis_soal
		);
	}

	private function random_for_wpt_v2($list){
		$count_soal = count($list);
		
		$list_keys = array_keys($list);
		shuffle($list_keys);

		$new_list = array();
		foreach($list_keys as $key){
			array_push($new_list, $list[$key]);
		}


		usort($new_list, function($a, $b){
			$num_a = gettype($a["group_name_code"]) == "string" ? intval($a["group_name_code"]) : $a["group_name_code"];
			$num_b = gettype($b["group_name_code"]) == "string" ? intval($b["group_name_code"]) : $b["group_name_code"];
			if($a["group_name_code"] == $b["group_name_code"]){
				return 0;
			}
			return ($a["group_name_code"] > $b["group_name_code"]) ? 1 : -1;
		});

		return $new_list;
	}

	private function random_for_wpt($list){
		$count_soal = count($list);
		
		$group_cat = [];
		$new_list = array();
		foreach($list as $key => $value){
			$group_cat[$value['group_name_code']][] = $key;
		}
		$num_randoms = count($group_cat);

		// membuat metrix
		$group_cat_arr = array_values($group_cat);

		foreach($group_cat_arr as $key_cat => $category){
			foreach($category as $key_val => $value){
				// berlaku untuk jumlah soal 50
				// menyamaratakan jumlah isi dalam group dengan jumlah group nya
				if($key_val < $num_randoms){
					$num_soal = $group_cat_arr[$key_val][$key_cat];
				} else {
					$num_soal = $value;
				}

				if($num_soal){
					array_push($new_list, $list[$num_soal]);
				}
			}
		}
		return $new_list;
	}


	public function list_generated_soal($options)
	{
		$data = $this->algorithm_generate_soal($options);
		$json = $data['json'];
		$group_quiz_code = $data['group_quiz_code'];
		$jenis_soal = $data['jenis_soal'];

		if(!empty($group_quiz_code)){
			$this->save_generated_soal($json,$group_quiz_code,0);
		}else{
			$this->save_generated_soal($json,$jenis_soal,0);
		}

		return $json;
	}

	public function save_generated_soal($rows, $code, $is_tutorial)
	{
    	$this->db->insert('quiz_paket_soal',array(
			'rows' => $rows,
			'quiz_code' => $code,
			'is_tutorial' => $is_tutorial
		));
		
		return $this->db->insert_id();
	}

	public function update_generated_soal($rows, $id, $is_tutorial)
	{
    	$update = $this->db
				  ->set('rows', $rows)
				  ->set('is_tutorial', $is_tutorial)
				  ->where('id', $id) 
				  ->update('quiz_paket_soal');
		
		return $update;
	}

	public function query_multiplechoice_question_find_one($id)
	{
		$sql = "SELECT * FROM multiplechoice_question 
				WHERE id = ?";
		return $this->db->query($sql, array($id));
	}

	public function old_generate_soal($code)
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

	}
}
?>
