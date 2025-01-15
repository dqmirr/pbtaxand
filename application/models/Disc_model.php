<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Disc_model extends Ci_Model
{
	public function getHasilJawaban($users_id, $quiz_code){
		$sql_jawaban_most = "SELECT DISTINCT jawaban_most as most, count(*) as total FROM disc_jawaban WHERE users_id = ? AND quiz_code = ? GROUP BY jawaban_most";
		$sql_jawaban_least = "SELECT DISTINCT jawaban_least as least, count(*) as total FROM disc_jawaban WHERE users_id = ? AND quiz_code = ? GROUP BY jawaban_least";

		$result_jawaban_most = $this->db->query($sql_jawaban_most, array(intval($users_id), strval($quiz_code)))->result();
		$result_jawaban_least = $this->db->query($sql_jawaban_least, array(intval($users_id), strval($quiz_code)))->result();
	
		$result = array();
		$raw = array();
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

		foreach($raw as $value)
		{
			$change_total = intval($value["most_total"]) - intval($value["least_total"]);
			array_push(
				$result,
				(object) array(
					"keterangan" => $value["keterangan"],
					"most_total" => $value["most_total"],
					"least_total" => $value["least_total"],
					"change_total" => $change_total
				)
			);
		}

		return $result;
	}
}

?>
