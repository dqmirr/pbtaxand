<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Multiplechoice_model extends CI_Model {
	public function insert_multiplechoice_questions(){
		$tableName = 'multiplechoice_question';
		$this->db->insert($tableName,$data);
	}

	public function getLasInsertId(){
		$query = $this->db->query("SELECT MAX(mq.id) as id_max FROM multiplechoice_question mq;");
		$res = $query->result();
		return $res[0]->id_max;
	}

	public function simpan_soal_wpt($list_data){
		$this->db->trans_start();
		$count = 0;
		foreach($list_data as $data){

			$sql_mq = "INSERT INTO multiplechoice_question (id, jenis_soal, sulit, nomor, question, parent_nomor, multiplechoice_img_code, jawaban, post_question, multiplechoice_story_code, group_name, ref_kesulitan_id, multiplechoice_question_category_id ) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
			$this->db->query($sql_mq, array(
				$data->last_id,
				$data->jenis_soal,
				$data->sulit,
				$data->nomor,
				is_string($data->question)? $data->question : (string) $data->question,
				$data->parent_nomor,
				$data->multiplechoice_img_code,
				$data->jawaban,
				$data->post_question,
				$data->multiplechoice_story_code,
				$data->group_name,
				$data->ref_kesulitan_id,
				$data->multiplechoice_question_category_id,
			));


			foreach ($data->list_choice as $choice) {
				$sql_mc = "INSERT INTO multiplechoice_choices (multiplechoice_question_id, choice, label) VALUES(?, ?, ?);";
				$this->db->query($sql_mc, array(
					$choice->multiplechoice_question_id,  // multiplechoice_question_id, 
					$choice->choice, // choice, // label
					is_string($choice->label)? $choice->label : (string) $choice->label
				));
			}

			$count++;
		}
		$this->db->trans_complete();
	}

	public function getJawaban($users_id, $quiz_code) {
		$get = $this->db->query("
			SELECT
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
			ORDER BY
				#b.nomor ASC
				a.date_created ASC
			", array($quiz_code, $users_id));
		return $get->result();
	}

	public function get_jenis_soal(){
		$sql = "SELECT DISTINCT a.jenis_soal FROM multiplechoice_question a Group By a.jenis_soal";
		return $this->db->query($sql)->result('array');
	}

	public function get_story_all($page = 1, $per_page = 50){
		$tbl_name = $this->db->protect_identifiers('multiplechoice_story a', TRUE);

		$total = $this->db->count_all_results($tbl_name);
		$total_page = ceil(floatval($total)/floatval($per_page));
		$page_first = ($page - 1) * $per_page;

		if($page > $total_page){
			$page = $total_page;
		}

		if($page <= 0){
			$page = 1;
		}

		$meta = array(
			'total' => $total,
			'page' => $page,
			'per_page' => $per_page,
			'total_page'=> $total_page
		);


		$this->db->select('code, story');
		$multiplechoice_story = $this->db->get($tbl_name, $page_first,$per_page );

		return array(
			'data' => $multiplechoice_story->result_array(),
			'meta' => $meta
		);
	}

	public function gen_story_code($jenis){
		$sql_story = "SELECT a.multiplechoice_story_code FROM multiplechoice_question a WHERE a.jenis_soal = ? AND a.multiplechoice_story_code NOT IN (NULL,'')";
		$dt_story = $this->db->query($sql_story, array($jenis))->result_array();
		var_dump($dt_story);
		return "generate";
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
            $this->load->model('Users_quiz_log_model');
            $quiz = $this->Users_quiz_log_model;
            $questions = $quiz->get_questions($code, $users_id);
            $list_jenis_soal = array();
            $list_id_soal = array();

            foreach($questions->rows as $soal){
                $id_soal = $soal->id_soal;
                $no = $soal->no;
                $jenis_soal = $soal->jenis_soal;
                $result = $this->db->query($sql,array($jenis_soal, $users_id, $id_soal))->row();
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

		public function get_soal($options_where){

			$pagination = 5;
			$page = 1;
			$skip = 0;

			$this->db->select('*');

			if($options_where["jenis_soal"]){
				$this->db->where('jenis_soal', $options_where["jenis_soal"]);
			}

			if($options_where["jenis_soal"]){
				$this->db->where('jenis_soal', $options_where["jenis_soal"]);
			}

			if($options_where["soal"]){
				$this->db->like('soal', $options_where["soal"]);
			}

			if($options_where["pagination"]){
				$pagination = $options_where["pagination"];
			}

			if($options_where["page"]){
				$page = $options_where["page"];
			}

			$skip = ($page-1) * $pagination;

			$this->db->limit($pagination, $skip);
			
			$get = $this->db->get('multiplechoice_question');
			$result = $get->result_array();

			$counter = $this->db->query("SELECT count(*) as total from  multiplechoice_question")->row();
			
			return array(
				"list" => $get->result_array(),
				"total" => (integer) $counter->total
			);

		}
}

?>
