<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Gti_model  extends Ci_Model  {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
        // $this->load->library('help');
	}

	public function get_report($users_id){
		$group_quiz_code = "gti";
		$res = array();
		$valid_result = array();

		$list_gti_kelebihan = array();
		$this->load->model("Users_model");
		$sql_quiz = "SELECT q.id, q.code, q.label FROM quiz q WHERE q.code = ?";
		$sql_gti_group = "SELECT a.quiz_code FROM group_quiz_items a WHERE a.group_quiz_code IN (
			SELECT b.group_quiz_code FROM quiz b WHERE b.id = ?
		)";

		$sql_gti_group = "SELECT a.quiz_code FROM group_quiz_items a WHERE a.group_quiz_code = ?";
			
		$sql_gti_jawaban = "SELECT * FROM gti_jawaban c WHERE c.users_id = ? AND c.quiz_code = ? ORDER BY c.created";
		$sql_gti_question = "SELECT * FROM gti_questions d WHERE d.id = ?";
		$sql_gti_rumus_by_adj = "SELECT e.adj, e.perc, e.gtq FROM gti_rumus e WHERE e.code = ? AND e.adj = ? LIMIT 0,1 ";
		$quiz = $this->get_peserta_by_users2($users_id);
		// $quiz["data"][0]["quiz_id"] = 47;
		// $data_gti_group = $this->db->query($sql_gti_group,array($quiz["data"][0]["quiz_id"]))->result('array');
		$data_gti_group = $this->db->query($sql_gti_group,array($group_quiz_code))->result('array');
		$config_soal = array(
			"Subtest 1" => array(
				"total_soal" => 60
			),
			"Subtest 2" => array(
				"total_soal" => 50
			),
			"Subtest 3" => array(
				"total_soal" => 72
			),
			"Subtest 4" => array(
				"total_soal" => 60
			),
			"Subtest 5" => array(
				"total_soal" => 60
			),
		);


		foreach($data_gti_group as $gti_group){
			if($gti_group["quiz_code"]){
				$data_gti_jawaban = $this->db->query($sql_gti_jawaban, array($users_id,$gti_group["quiz_code"]))->result('array');
				if($data_gti_jawaban){
					foreach($data_gti_jawaban as $gti_jawaban){
						$quiz = $this->db->query($sql_quiz,array($gti_jawaban["quiz_code"]))->row_array();
						$gti_question= $this->db->query($sql_gti_question,array($gti_jawaban["gti_questions_id"]))->row_array();
						$jawaban_resp = strval($gti_jawaban["jawaban"]);
						$jawaban_benar = strval($gti_question["jawaban"]);
						$nomor = $gti_question['nomor'];
						
						if(empty($gti_jawaban["jawaban"]) == true){
							$koreksi = 'K';
						}
						
						if(($jawaban_resp == $jawaban_benar) == true){
							$koreksi = 'B';
						}
						
						if(($jawaban_resp == $jawaban_benar) == false){
							$koreksi = 'S';
						}
						
						switch($quiz["label"]){
							case "Subtest 1":
								$res[$quiz["label"]]["j_resp"][$nomor] = $gti_jawaban["jawaban"];
								$res[$quiz["label"]]['koreksi'][$nomor] = $koreksi;
								break;
							case "Subtest 2":
								$res[$quiz["label"]]["j_resp"][$nomor] = $gti_jawaban["jawaban"];
								$res[$quiz["label"]]['koreksi'][$nomor] = $koreksi;
								break;
							case "Subtest 3":
								$res[$quiz["label"]]["j_resp"][$nomor] = $gti_jawaban["jawaban"];
								$res[$quiz["label"]]['koreksi'][$nomor] = $koreksi;
								break;
							case "Subtest 4":
								$res[$quiz["label"]]["j_resp"][$nomor] = $gti_jawaban["jawaban"];
								$res[$quiz["label"]]['koreksi'][$nomor] = $koreksi;
								break;
							case "Subtest 5":
								$res[$quiz["label"]]["j_resp"][$nomor] = $gti_jawaban["jawaban"];
								$res[$quiz["label"]]['koreksi'][$nomor] = $koreksi;
								break;
						}
					}
				}
			}
		}

		$total_gtq = 0;
		$jumlah_gtq = 0;
		foreach($config_soal as $key=>$val){
			$current = $res[$key];

			$current['count'] = array_count_values($current["koreksi"]);
			$done = $current["count"]["B"] + $current["count"]["S"];
			$j_resp = ksort($current["j_resp"]);
			$koreksi = ksort($current["koreksi"]);
		
			switch($key){
				case "Subtest 1":
					$rumus_code = "letter_checking";
					$adj = round($current["count"]["B"] - ($current["count"]["S"] / 4), 0);
					// $gti_rumus = $this->db->query($sql_gti_rumus_by_adj, array($rumus_code, $adj))->row_array();
					$gti_rumus = $this->get_nilai($rumus_code, $adj);
					$perc = $gti_rumus["perc"];
					$gtq = $gti_rumus["gtq"];
					array_push(
						$list_gti_kelebihan,
						array(
							"order" => 5,
							"gtq" => intval($gtq),
							"code" => "LC"
						)
					);
					break;
				case "Subtest 2":
					$rumus_code = "reasoning";
					$adj = round($current["count"]["B"] - ($current["count"]["S"] / 2), 0);
					// $gti_rumus = $this->db->query($sql_gti_rumus_by_adj, array($rumus_code, $adj))->row_array();
					$gti_rumus = $this->get_nilai($rumus_code, $adj);
					$perc = $gti_rumus["perc"];
					$gtq = $gti_rumus["gtq"];
					array_push(
						$list_gti_kelebihan,
						array(
							"order" => 4,
							"gtq" => intval($gtq),
							"code" => "RE"
						)
					);
					break;
				case "Subtest 3":
					$rumus_code = "letter_distance";
					$adj = round($current["count"]["B"] - ($current["count"]["S"] / 1), 0);
					// $gti_rumus = $this->db->query($sql_gti_rumus_by_adj, array($rumus_code, $adj))->row_array();
					$gti_rumus = $this->get_nilai($rumus_code, $adj);
					$perc = $gti_rumus["perc"];
					$gtq = $gti_rumus["gtq"];
					array_push(
						$list_gti_kelebihan,
						array(
							"order" => 3,
							"gtq" => intval($gtq),
							"code" => "LD"
						)
					);
					break;
				case "Subtest 4":
					$rumus_code = "number_distance";
					$adj = round($current["count"]["B"] - ($current["count"]["S"] / 2), 0);
					// $gti_rumus = $this->db->query($sql_gti_rumus_by_adj, array($rumus_code, $adj))->row_array();
					$gti_rumus = $this->get_nilai($rumus_code, $adj);
					$perc = $gti_rumus["perc"];
					$gtq = $gti_rumus["gtq"];
					array_push(
						$list_gti_kelebihan,
						array(
							"order" => 2,
							"gtq" => intval($gtq),
							"code" => "ND"
						)
					);
					break;
				case "Subtest 5":
					$rumus_code = "spatial_oriantation";
					$adj = round($current["count"]["B"] - ($current["count"]["S"] / 3), 0);
					// $gti_rumus = $this->db->query($sql_gti_rumus_by_adj, array($rumus_code, $adj))->row_array();
					$gti_rumus = $this->get_nilai($rumus_code, $adj);
					$perc = $gti_rumus["perc"];
					$gtq = $gti_rumus["gtq"];
					array_push(
						$list_gti_kelebihan,
						array(
							"order" => 1,
							"gtq" => intval($gtq),
							"code" => "SO"
						)
					);
					break;
				default:
					$adj = 0;
					$perc = null;
					$gtq = null;
					break;
			}
			if(!isset($current['count']['B'])){
				$current['count']['B'] = 0;
			}
			if(!isset($current['count']['S'])){
				$current['count']['S'] = 0;
			}
			$current['count']["K"] = $val["total_soal"] - $done;
			$current['count']["DONE"] = $done;
			$current['count']["ADJ"] = $adj;
			$current['count']["PERC"] = $perc;
			$current['count']["GTQ"] = $gtq;

			$total_gtq += $gtq;
			$jumlah_gtq += 1;


			$valid_result[$key] = $current['count'];
		}
		
		$kelebihan = $this->create_kelebihan($list_gti_kelebihan);
		$kelemahan = $this->create_kelemahan($list_gti_kelebihan);
		
		$users_res = $this->Users_model->get_by('id', $users_id);

		
		$valid_result['total_gtq'] = $total_gtq;
		$valid_result['jumlah_gtq'] = $jumlah_gtq;
		return array(
			'name' => $users_res[0]["fullname"],
			'result' => $valid_result,
			'gtq' => array(
				'value' => $total_gtq / $jumlah_gtq,
				'keterangan' => 'High Average'
			),
			'kelebihan' => $kelebihan,
			'kelemahan' => $kelemahan
		);
	}

	public function create_kelebihan($list){
		$result = array();

		$f_zero = array_filter($list, function($data){
			if($data['gtq'] == 0){
				return $data;
			}
		});

		$c_zero = count($f_zero);
		if($c_zero >= 5){
			return $result;
		}

		usort(
			$list,
			function($a, $b){
				if($a['gtq'] < $b['gtq']){
					return 1;
				}

				if($a['gtq'] > $b['gtq']){
					return -1;
				}

				return 0;
			}
		);

		for($i=0; $i<2; $i++){
			$number = rand(1,3);
			$code = $list[$i]["code"];
			$kelebihan = $this->get_gti_kelebihan($code, $number);
			array_push(
				$result,
				$kelebihan["keterangan"]
			);
		}

		return $result;
	}

	public function create_kelemahan($list){
		$result = array();

		$f_zero = array_filter($list, function($data){
			if($data['gtq'] == 0){
				return $data;
			}
		});

		$c_zero = count($f_zero);
		if($c_zero >= 5){
			return $result;
		}

		// sorting dari terkecil hingga terbesar
		usort(
			$list,
			function($a, $b){
				if($a['gtq'] < $b['gtq']){
					return -1;
				}

				if($a['gtq'] > $b['gtq']){
					return 1;
				}

				return 0;
			}
		);

		// ambil 2 nomor terbawah untuk di jadikan kelemahan
		for($i=0; $i<2; $i++){
			$number = rand(1,3); 
			$code = $list[$i]["code"];
			$kelemahan = $this->get_gti_kelebihan($code, $number);
			
			array_push(
				$result,
				$kelemahan["keterangan"]
			);
		}

		return $result;
	}

	public function get_userbysesi(){
		$this->db->select("sesi_code, count(*) as jumlah_peserta");
		$this->db->group_by('sesi_code');
		$query = $this->db->get("users_gti");
		return $query->result_array();
	}

	public function get_countbysesi(){
		$res = array();

		$this->db->distinct();
		$this->db->select('c.sesi_code, count(*) jumlah_peserta');
		$this->db->join('quiz b', 'b.id = a.quiz_id', 'left');
		$this->db->join('users c', 'c.id = a.users_id', 'left');
		$this->db->where('a.active', 1);
		$this->db->where('b.code', 'gti_group');
		$this->db->group_by('c.sesi_code');

		$query = $this->db->get("users_quiz a");
		if(!$query) {
			$err = $this->db->error();
			$res['status'] = false;
			$res['message'] = $err['message'];
			$res['data'] = $err;
		} else {
			$res['status'] = true;
			if($query->num_rows() > 0) {
				$res['message'] = 'Menamplikan data group quiz';
				$res['data'] = $query->result_array();
			} else {
				$res['message'] = 'Tidak Ada Data';
				$res['data'] = null;
			}
		}

		return $res;
	}

	public function get_peserta_by_sesi($sesi_code){
		$res = array();

		// $this->db->select("uq.users_id, uq.quiz_id, u.fullname, q.label, q.group_quiz_code");
		// $this->db->join('quiz q', 'q.id = uq.quiz_id', 'left');
		// $this->db->join('users u', 'u.id = uq.users_id', 'left');
		// // $this->db->where('uq.active', 1);
		// $this->db->where('u.sesi_code', $sesi_code);
		// $this->db->where('q.code', 'gti_group');
		// $query = $this->db->get('users_quiz uq');
		// $query = $this->db->get('users_quiz uq');
		$query = $this->db->query("
		SELECT uq.users_id,
		uq.quiz_id,
		u.fullname,
		u.sesi_code,
		q.label,
		q2.library_code 
		FROM users_quiz uq 
		LEFT JOIN quiz q ON (q.id = uq.quiz_id)
		LEFT JOIN users u ON (u.id = uq.users_id)
		LEFT JOIN group_quiz_items gqi ON (gqi.group_quiz_code = q.group_quiz_code)
		LEFT JOIN quiz q2 ON (q2.code  = gqi.quiz_code)
		WHERE u.sesi_code = ? AND q2.library_code = 'gti' GROUP BY uq.users_id
		", array($sesi_code));
		$res['data'] = $query->result_array();

		if(!$query) {
			$err = $this->db->error();
			$res['status'] = false;
			$res['message'] = $err['message'];
			$res['data'] = $err;
		} else {
			$res['status'] = true;
			if($query->num_rows() > 0) {
				$res['message'] = 'Menamplikan data group quiz';
				$res['data'] = $query->result_array();
			} else {
				$res['message'] = 'Tidak Ada Data';
				$res['data'] = null;
			}
		}
		return $res;
	}

	public function get_group_items($users_id, $sesi_code){
		$res = array();
		// $this->db->select("uq.users_id, uq.quiz_id, u.fullname, q.label, q.group_quiz_code");
		// $this->db->join('quiz q', 'q.id = uq.quiz_id', 'left');
		// $this->db->join('users u', 'u.id = uq.users_id', 'left');
		// // $this->db->where('uq.active', 1);
		// $this->db->where('u.sesi_code', $sesi_code);
		// $this->db->where('q.code', 'gti_group');
		// $query = $this->db->get('users_quiz uq');
		// $query = $this->db->get('users_quiz uq');
		$query = $this->db->query("
		SELECT uq.users_id,
		u.fullname,
		u.sesi_code,
		q.label,
		q2.library_code 
		FROM users_quiz uq 
		LEFT JOIN quiz q ON (q.id = uq.quiz_id)
		LEFT JOIN users u ON (u.id = uq.users_id)
		LEFT JOIN group_quiz_items gqi ON (gqi.group_quiz_code = q.group_quiz_code)
		LEFT JOIN quiz q2 ON (q2.code  = gqi.quiz_code)
		WHERE u.sesi_code = ? AND q2.library_code = 'gti' GROUP BY uq.users_id
		", array($sesi_code));

		if(!$query) {
			$err = $this->db->error();
			$res['status'] = false;
			$res['message'] = $err['message'];
			$res['data'] = $err;
		} else {
			$res['status'] = true;
			if($query->num_rows() > 0) {
				$res['message'] = 'Menamplikan data group quiz';
				$res['data'] = $query->result_array();
			} else {
				$res['message'] = 'Tidak Ada Data';
				$res['data'] = null;
			}
		}
		return $res;
	}

	public function get_peserta_by_users($users_id)
	{
		$res = array();

		$this->db->select("uq.users_id, uq.quiz_id, u.fullname, q.label, q.group_quiz_code");
		$this->db->join('quiz q', 'q.id = uq.quiz_id', 'left');
		$this->db->join('users u', 'u.id = uq.users_id', 'left');
		$this->db->where('uq.active', 1);
		$this->db->where('uq.users_id', $users_id);
		$this->db->like('q.code', 'gti');
		$query = $this->db->get('users_quiz uq');

		if(!$query) {
			$err = $this->db->error();
			$res['status'] = false;
			$res['message'] = $err['message'];
			$res['data'] = $err;
		} else {
			$res['status'] = true;
			if($query->num_rows() > 0) {
				$res['message'] = 'Menamplikan data group quiz';
				$res['data'] = $query->result_array();
			} else {
				$res['message'] = 'Tidak Ada Data';
				$res['data'] = null;
			}
		}
		return $res;
	}

	public function get_peserta_by_users2($users_id)
	{
		$res = array();

		$query = $this->db->query("
		SELECT uq.users_id,
			q2.code,
			u.fullname,
			u.sesi_code,
			q.label,
			q2.library_code 
		FROM users_quiz uq 
			LEFT JOIN quiz q ON (q.id = uq.quiz_id)
			LEFT JOIN users u ON (u.id = uq.users_id)
			LEFT JOIN group_quiz_items gqi ON (gqi.group_quiz_code = q.group_quiz_code)
			LEFT JOIN quiz q2 ON (q2.code  = gqi.quiz_code)
		WHERE q2.library_code = 'gti' AND uq.users_id = ?
		", array($users_id));

		if(!$query) {
			$err = $this->db->error();
			$res['status'] = false;
			$res['message'] = $err['message'];
			$res['data'] = $err;
		} else {
			$res['status'] = true;
			if($query->num_rows() > 0) {
				$res['message'] = 'Menamplikan data group quiz';
				$res['data'] = $query->result_array();
			} else {
				$res['message'] = 'Tidak Ada Data';
				$res['data'] = null;
			}
		}
		return $res;
	}

	public function get_nilai($code, $adj){
		$this->db->select('adj, perc, gtq');
		$this->db->where('a.code', $code);
		$this->db->where('a.adj <=', $adj);
		$this->db->order_by('a.adj', 'DESC');
		$get = $this->db->get('gti_rumus a');
		$data = $get->row_array();

		if(empty($data)){
			$data = $this->get_nilai_min_gtq($code);
		}

		// set minimum gtq
		if($code == 'letter_checking' && $adj < 15){
			$data['gtq'] = 74;
		}

		if($code == 'reasoning' && $adj < 7) {
			$data['gtq'] = 69;
		}

		if($code == 'letter_distance' && $adj < 7) {
			$data['gtq'] = 69;
		}

		if($code == 'number_distance' && $adj < 4) {
			$data['gtq'] = 69;
		}

		if($code == 'spatial_oriantation' && $adj < 3) {
			$data['gtq'] = 69;
		}

		return $data;
	}

	public function get_nilai_min_gtq($code)
	{
		$get = $this->db->select('adj, perc, gtq')->order_by('gtq', 'ASC')->get('gti_rumus')->row_array();
		return $get;
	}

	public function get_gti_kelebihan($gti_code, $number){
		$this->db->select('keterangan');
		$this->db->where('gti_category_code', $gti_code);
		$this->db->where('number', $number);
		$this->db->limit(1);
		$get = $this->db->get("gti_kelebihan");
		return $get->row_array();
	}
}
?>
