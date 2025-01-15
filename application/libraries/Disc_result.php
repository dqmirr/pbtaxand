<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Disc_result {

	private $users_id;
	private $quiz_code;
	private $db;

	public function __construct(){
		$this->ci =& get_instance();
		// $this->db = $this->ci->db;
	}

	public function result($users_id, $quiz_code){

		$sql_jawaban_most = "SELECT DISTINCT jawaban_most as most, count(*) as total FROM disc_jawaban WHERE users_id = ? AND quiz_code = ? GROUP BY jawaban_most";
		$sql_jawaban_least = "SELECT DISTINCT jawaban_least as least, count(*) as total FROM disc_jawaban WHERE users_id = ? AND quiz_code = ? GROUP BY jawaban_least";

		$result_jawaban_most = $this->ci->db->query($sql_jawaban_most, array(intval($users_id), strval($quiz_code)))->result();
		$result_jawaban_least = $this->ci->db->query($sql_jawaban_least, array(intval($users_id), strval($quiz_code)))->result();
	
		$disc_result = array(
			'D' => array(
				"keterangan" => 'D',
				"most_total" => 0,
				"least_total" => 0,
				"change_total" =>  0
			),
			'I' => array(
				"keterangan" => 'I',
				"most_total" => 0,
				"least_total" => 0,
				"change_total" =>  0
			),
			'S' => array(
				"keterangan" => 'S',
				"most_total" => 0,
				"least_total" => 0,
				"change_total" =>  0
			),
			'C' => array(
				"keterangan" => 'C',
				"most_total" => 0,
				"least_total" => 0,
				"change_total" =>  0
			),
			'B' => array(
				"keterangan" => 'B',
				"most_total" => 0,
				"least_total" => 0,
				"change_total" =>  0
			),
		);
		$raw = array();

		$most_list = array(
			'D'=>0,
			'I'=>0,
			'S'=>0,
			'C'=>0
		);
		$least_list = array(
			'D'=>0,
			'I'=>0,
			'S'=>0,
			'C'=>0,
		);
		$change_list = array(
			'D'=>0,
			'I'=>0,
			'S'=>0,
			'C'=>0,
		);
		/**
		 * expected
		 * 
		 * [{ 
		 * 		no: 0,
		 * 		keterangan: 'A',
		 * 		most_total: 0,
		 * 		least_total: 0;
		 * 		change_total: 0
		 * }]
		 * 
		 * 
		 */
		foreach($result_jawaban_most as $r_most){
			$m_ket = $r_most->most;
			$m_total = $r_most->total;
			if(!isset($raw[$m_ket])){
				$raw[$m_ket] = array();
			}
			$raw[$m_ket]["keterangan"] = $m_ket;
			$raw[$m_ket]["most_total"] = $m_total;
		}
		foreach($result_jawaban_least as $r_least){
			$l_ket = $r_least->least;
			$l_total = $r_least->total;

			if(!isset($raw[$l_ket])){
				$raw[$l_ket] = array();
			}
			$raw[$l_ket]["keterangan"] = $l_ket;
			$raw[$l_ket]["least_total"] = $l_total;
			
		}

		$nomor = 1;
		foreach($raw as $value)
		{
			$most_total = intval($value["most_total"]);
			$least_total = intval($value["least_total"]);
			switch($value["keterangan"]){
				case 'B':
					$change_total = $most_total + $least_total;
					break;
				default:
					$change_total = $most_total - $least_total;
					$most_list[$value["keterangan"]] = $most_total;
					$least_list[$value["keterangan"]] = $least_total;
					$change_list[$value["keterangan"]] = $change_total;
					break;
			}

			$disc_result[$value["keterangan"]] = array(
				"nomor"=> $nomor,
				"keterangan" => $value["keterangan"],
				"most_total" => $most_total,
				"least_total" => $least_total,
				"change_total" =>  $change_total
			);

			$nomor++;
		}

		$m_disc = $this->search_disc_range('most', $most_list);
		$l_disc = $this->search_disc_range('least', $least_list);
		$c_disc = $this->search_disc_range('change', $change_list);
		
		$result_obj = (object) array(
			'disc_result' => $disc_result,
			'm_disc' => $m_disc,
			'l_disc' => $l_disc,
			'c_disc' => $c_disc,
		);
        return $result_obj;
	} 

	public function result_v2($users_id, $quiz_code) 
	{
		$this->ci->db->select("*");
		$this->ci->db->from("disc_jawaban");
		$this->ci->db->where("users_id", $users_id);
		$this->ci->db->where("quiz_code", $quiz_code);
		$jawaban_disc = $this->ci->db->get()->num_rows();

		if($jawaban_disc == 0){
			return array(
				'disc_result' => null,
				'm_disc' => null,
				'l_disc' => null,
				'c_disc' => null,
			);
		}

		$sql_jawaban_most = "SELECT DISTINCT jawaban_most as most, count(*) as total FROM disc_jawaban WHERE users_id = ? AND quiz_code = ? GROUP BY jawaban_most";
		$sql_jawaban_least = "SELECT DISTINCT jawaban_least as least, count(*) as total FROM disc_jawaban WHERE users_id = ? AND quiz_code = ? GROUP BY jawaban_least";

		$result_jawaban_most = $this->ci->db->query($sql_jawaban_most, array(intval($users_id), strval($quiz_code)))->result();
		$result_jawaban_least = $this->ci->db->query($sql_jawaban_least, array(intval($users_id), strval($quiz_code)))->result();
	
		$disc_result = array(
			'D' => array(
				"keterangan" => 'D',
				"most_total" => 0,
				"least_total" => 0,
				"change_total" =>  0
			),
			'I' => array(
				"keterangan" => 'I',
				"most_total" => 0,
				"least_total" => 0,
				"change_total" =>  0
			),
			'S' => array(
				"keterangan" => 'S',
				"most_total" => 0,
				"least_total" => 0,
				"change_total" =>  0
			),
			'C' => array(
				"keterangan" => 'C',
				"most_total" => 0,
				"least_total" => 0,
				"change_total" =>  0
			),
			'B' => array(
				"keterangan" => 'B',
				"most_total" => 0,
				"least_total" => 0,
				"change_total" =>  0
			),
		);
		$raw = array();

		$most_list = array(
			'D'=>0,
			'I'=>0,
			'S'=>0,
			'C'=>0
		);
		$least_list = array(
			'D'=>0,
			'I'=>0,
			'S'=>0,
			'C'=>0,
		);
		$change_list = array(
			'D'=>0,
			'I'=>0,
			'S'=>0,
			'C'=>0,
		);
		/**
		 * expected
		 * 
		 * [{ 
		 * 		no: 0,
		 * 		keterangan: 'A',
		 * 		most_total: 0,
		 * 		least_total: 0;
		 * 		change_total: 0
		 * }]
		 * 
		 * 
		 */
		foreach($result_jawaban_most as $r_most){
			$m_ket = $r_most->most;
			$m_total = $r_most->total;
			if(!isset($raw[$m_ket])){
				$raw[$m_ket] = array();
			}
			$raw[$m_ket]["keterangan"] = $m_ket;
			$raw[$m_ket]["most_total"] = $m_total;
		}
		foreach($result_jawaban_least as $r_least){
			$l_ket = $r_least->least;
			$l_total = $r_least->total;

			if(!isset($raw[$l_ket])){
				$raw[$l_ket] = array();
			}
			$raw[$l_ket]["keterangan"] = $l_ket;
			$raw[$l_ket]["least_total"] = $l_total;
			
		}

		$nomor = 1;
		foreach($raw as $value)
		{
			$most_total = intval($value["most_total"]);
			$least_total = intval($value["least_total"]);
			switch($value["keterangan"]){
				case 'B':
					$change_total = $most_total + $least_total;
					break;
				default:
					$change_total = $most_total - $least_total;
					$most_list[$value["keterangan"]] = $most_total;
					$least_list[$value["keterangan"]] = $least_total;
					$change_list[$value["keterangan"]] = $change_total;
					break;
			}

			$disc_result[$value["keterangan"]] = array(
				"nomor"=> $nomor,
				"keterangan" => $value["keterangan"],
				"most_total" => $most_total,
				"least_total" => $least_total,
				"change_total" =>  $change_total
			);

			$nomor++;
		}

		$m_disc = $this->search_disc_range('most', $most_list);
		$l_disc = $this->search_disc_range('least', $least_list);
		$c_disc = $this->search_disc_range('change', $change_list);

        $result = array(
			'disc_result' => $disc_result,
			'm_disc' => $m_disc,
			'l_disc' => $l_disc,
			'c_disc' => $c_disc,
		);

		return $result;
	}

	public function search_disc_range($graph = '', $values = array())
	{
		switch($graph){
			case 'most':
				$get = $this->ci->db->query('SELECT * FROM (
					SELECT a.seg_code, a.seg_16_code, a.number, a.code FROM disc_range a WHERE a.code = "D" AND a.ref_disc_graph_id = 1 AND a.number = ?
					UNION
					SELECT b.seg_code, b.seg_16_code, b.number, b.code FROM disc_range b WHERE b.code = "I" AND b.ref_disc_graph_id = 1 AND b.number = ?
					UNION
					SELECT c.seg_code, c.seg_16_code, c.number, c.code FROM disc_range c WHERE c.code = "S" AND c.ref_disc_graph_id = 1 AND c.number = ?
					UNION
					SELECT d.seg_code, d.seg_16_code, d.number, d.code FROM disc_range d WHERE d.code = "C" AND d.ref_disc_graph_id = 1 AND d.number = ?
					) as row_data
				', array($values['D'],$values['I'],$values['S'],$values['C']));
				$data = $get->result('array');
				break;
			case 'least':
				$get = $this->ci->db->query('SELECT * FROM (
					SELECT a.seg_code, a.seg_16_code, a.number, a.code FROM disc_range a WHERE a.code = "D" AND a.ref_disc_graph_id = 2 AND a.number = ?
					UNION
					SELECT b.seg_code, b.seg_16_code, b.number, b.code FROM disc_range b WHERE b.code = "I" AND b.ref_disc_graph_id = 2 AND b.number = ?
					UNION
					SELECT c.seg_code, c.seg_16_code, c.number, c.code FROM disc_range c WHERE c.code = "S" AND c.ref_disc_graph_id = 2 AND c.number = ?
					UNION
					SELECT d.seg_code, d.seg_16_code, d.number, d.code FROM disc_range d WHERE d.code = "C" AND d.ref_disc_graph_id = 2 AND d.number = ?
					) as row_data
				', array($values['D'],$values['I'],$values['S'],$values['C']));
				$data = $get->result('array');
				break;
			case 'change':
				$get = $this->ci->db->query('SELECT * FROM (
					SELECT a.seg_code, a.seg_16_code, a.number, a.code FROM disc_range a WHERE a.code = "D" AND a.ref_disc_graph_id = 3 AND a.number = ?
					UNION
					SELECT b.seg_code, b.seg_16_code, b.number, b.code FROM disc_range b WHERE b.code = "I" AND b.ref_disc_graph_id = 3 AND b.number = ?
					UNION
					SELECT c.seg_code, c.seg_16_code, c.number, c.code FROM disc_range c WHERE c.code = "S" AND c.ref_disc_graph_id = 3 AND c.number = ?
					UNION
					SELECT d.seg_code, d.seg_16_code, d.number, d.code FROM disc_range d WHERE d.code = "C" AND d.ref_disc_graph_id = 3 AND d.number = ?
					) as row_data
				', array($values['D'],$values['I'],$values['S'],$values['C']));
				$data = $get->result('array');
				break;
			default:
				$data = [];
				break;

		}

		usort($data,function($a, $b){
			return $a['seg_16_code'] < $b['seg_16_code'];
		});
		$segment_16_list = array();

		foreach($data as $item){
			if($item['seg_16_code'] > 8){
				$profile .= $item["code"];
			}
			$segment_16_list[$item["code"]] = intval($item['seg_16_code']) - 8;
		}

		if(strlen($profile)>=4){
			$profile = 'UPPERSHIFT';
		}else if(strlen($profile)<=0){
			$profile = 'UNDERSHIFT';
		}

		$result = array(
			'profile' => $profile,
			'segment_16_list' => $segment_16_list
		);

		return $result;
	}

	public function is_profile_can_descip($profile){
		return !($profile == 'UNDERSHIFT' && $profile == 'UPPERSHIFT');
	}

}

?>
