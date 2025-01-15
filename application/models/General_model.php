<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General_model extends Ci_Model {
		
	public function getHasilJawaban($library, $users_id, $quiz_code)
	{
		$get = $this->db->query("
			SELECT
				b.nomor, a.jawaban, b.jawaban as jawaban_benar
			FROM
				{$library}_jawaban a,
				{$library}_questions b
			WHERE
				a.quiz_code = b.quiz_code
				AND
				a.{$library}_questions_id = b.id
				AND
				a.quiz_code = ?
				AND
				a.users_id = ?
			ORDER BY
				#b.nomor ASC
				a.created ASC
			", array($quiz_code, $users_id));

		return $get->result();
	}
}
