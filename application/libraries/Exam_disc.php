<?php defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'libraries/Class_Exam.php');

class Exam_disc extends Class_Exam {
    
    var $ci;
    var $disc_category = array();
    var $disc_list = array();
    var $disc_test = array();
	var $questions = array();

    public function __construct()
    {
        $this->ci =& get_instance();
    }

	public function restart($users_id, $code)
	{
		return $this->ci->db->delete('disc_jawaban', array('users_id'=>$users_id, 'jenis_soal'=>$code ));
	}

    public function load_json()
    {
        $filename = 'disc.json';
        $path = APPPATH.'/libraries/file_storage';
        $file = file_get_contents($path."/".$filename);
        $data = json_decode(strval($file));
        $this->disc_category = $data->disc_category;
        $this->disc_list = $data->disc_list;
        $this->disc_test = $data->disc_test;
    }

    public function get_disc_category()
    {
        return $this->disc_category;
    }

    public function get_disc_list()
    {
        return $this->disc_list;
    }

    public function get_disc_test()
    {
        return $this->disc_test;
    }

    public function disc_category_find_by_id($value)
    {
        $categories = $this->disc_category;
        $key = array_search($value,array_column($categories, 'id'));
        return $categories[$key];
    }

    public function disc_list_find_by_id($value) 
    {
        $key = array_search($value,array_column($this->disc_list, 'id'));
        return $this->disc_list[$key];
    }

	protected function generate_question($code,$is_tutorial = 0)
	{

    $sql_select_disc = "SELECT id, jenis_soal, no_soal, nilai_most, nilai_least, soal FROM disc_questions WHERE jenis_soal = ?";

    $data_disc = $this->ci->db->query($sql_select_disc,array($code))->result_array();
		
		$return = array();
    $result = array();
		$rows = array();
        $push = array();
        foreach($data_disc as $item)
        {
            $no = $item["no_soal"];

            if(!isset($push[$no])){
                $push[$no] = array(
                    "id" => $item["id"],
                    "no" => $item["no_soal"],
										"soal" => array(),
								);
						}

            $push[$no]["soal"][] = array(
                "M" => $item["nilai_most"],
                "L" => $item["nilai_least"],
                "question" => $item["soal"]
            );
        }

		foreach($push as $key => $value)
		{
			$soal = array();
			if(is_array($value["soal"]))
			{
				foreach($value["soal"] as $item)
				{
					array_push(
						$soal,
						(object) array(
							"M" => $item["M"],
							"L" => $item["L"],
							"question" => $item["question"]
						)
					);
				}
			}

			array_push(
				$rows,
				(object) array(
					"id" => $value["id"],
					"no" => $value["no"],
					"soal" => $soal
				)
			);
		}


		$return['rows'] = $rows;
		$return['total'] = count($rows);

		$dbsave = $this->ci->load->database('save', TRUE);
		
		// Simpan Paket Soal
        $dbsave->set('rows', json_encode($return));
        $dbsave->set('quiz_code', $code);
        $dbsave->set('is_tutorial', $is_tutorial);
        $dbsave->insert('quiz_paket_soal');

		return $dbsave->insert_id();
		exit;
    }

    public function save_answers($user_id, $code, $jawaban, $seconds_used = 0, $index = null)
    {
        $dbsave = $this->ci->load->database('save', TRUE);

		$data = array();

		foreach($jawaban as $no_soal => $value){
			$data["no_soal"] = $no_soal;
			$data["result_m"] = $value["result_m"];
			$data["result_l"] = $value["result_l"];
		}

		$sql_search = "SELECT disc_questions_no_soal FROM disc_jawaban WHERE users_id = ? AND quiz_code = ? AND disc_questions_no_soal = ?";
			
		$dt_jawaban = $this->ci->db->query($sql_search, array( intval($user_id), strval($code), intval($data["no_soal"]) ))->result();

		if(!$dt_jawaban) {
			$sql = "INSERT INTO disc_jawaban
				(
					`users_id`, 
					`quiz_code`, 
					`disc_questions_no_soal`, 
					`jawaban_most`, 
					`jawaban_least`
				)
				VALUES
				(
					?,
					?,
					?,
					?, 
					?
				)
			";

			$dbsave->query($sql, array(
				intval($user_id),
				strval($code),
				intval($data["no_soal"]),
				strval($data["result_m"]),
				strval($data["result_l"])
			));
		} else {
			$sql_update = "UPDATE disc_jawaban 
							SET jawaban_most = ?, jawaban_least = ? 
							WHERE users_id = ? 
							AND quiz_code = ? 
							AND disc_questions_no_soal = ?";
			$dbsave->query($sql_update, array(
				strval($data["result_m"]),
				strval($data["result_l"]),
				intval($user_id),
				strval($code),
				intval($data["no_soal"])
			));
		}

		// Update users_quiz
        $dbsave->set('last_update', date('Y-m-d H:i:s'));
        $dbsave->set('seconds_used', $seconds_used);
        $dbsave->where('quiz_code', $code);
        $dbsave->where('users_id', $user_id);
        
        if ($index !== null)
        {
            $dbsave->set('index', $index);
        }
        
        return $dbsave->update('users_quiz_log');
    }

	public function generate_questions($quiz_code)
    {
        $this->exam_generate_questions($quiz_code, 'disc_question');
    }
}
?>
