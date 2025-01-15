<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Psycogram_mdl extends Ci_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('help');
    }

    public function get_userbysesi($sesi, $users_id)
    {
        $sql = "SELECT users.id, username, fullname,
            sesi.label AS sesi_label,
            users.sesi_code,
            (CASE
                WHEN formasi.label IS NULL THEN '-'
                ELSE CONCAT('Formasi ', formasi.label)
            END) AS formasi_label,
            formasi.code AS formasi_code,
            (CASE
                WHEN posisi_jabatan.label IS NULL THEN '-'
                ELSE posisi_jabatan.label
            END) AS jabatan,
            (CASE
                WHEN posisi_level.label IS NULL THEN '-'
                ELSE posisi_level.label
            END) AS tingkatan,
            users.tgl_lahir
            FROM users
            LEFT JOIN formasi
            ON users.formasi_code = formasi.code
            LEFT JOIN sesi
            ON formasi.sesi_code = sesi.code
            LEFT JOIN posisi_jabatan
            ON posisi_jabatan.id = formasi.posisi
            LEFT JOIN posisi_level
            ON posisi_level.id = formasi.tingkatan
            WHERE 1
            AND users.sesi_code = ?";
		if(isset($users_id) && count($users_id) > 0){
			$sql = $sql." AND users.id = ?";
			$escape = array($sesi, $users_id);
			$kueri = $this->db->query($sql, $escape);
		} else {
			$escape = array($sesi);
			$kueri = $this->db->query($sql, $escape);
		}
		
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $code;
        } else {
            $res['status'] = true;
            $res['message'] = 'Menampilkan data users';
            $res['data'] = $kueri->result_array();
        }
        return $res;
    }
    
    public function get_detail_quiz($id_user)
    {
        $sql = "SELECT quiz.id,
            quiz.code,
            quiz.label,
            (CASE
                WHEN users_quiz_log.seconds_used = 0 THEN 'Belum'
                WHEN users_quiz_log.seconds_used > 0 THEN 'Progres'
                WHEN users_quiz_log.seconds_used = users_quiz_log.seconds
                THEN 'Selesai'
                   ELSE 'Belum'
            END) AS status,

            (CASE
                WHEN users_quiz_log.seconds_used = 0 THEN 'budge-danger'
                WHEN users_quiz_log.seconds_used > 0 THEN 'badge-warning'
                WHEN users_quiz_log.seconds_used = users_quiz_log.seconds
                THEN 'badge-success'
                   ELSE 'badge-danger'
            END) AS badge

            FROM users_quiz
            LEFT JOIN quiz
            ON users_quiz.quiz_id = quiz.id
            LEFT JOIN users_quiz_log
            ON (users_quiz_log.quiz_code = quiz.code
                AND users_quiz_log.users_id = users_quiz.users_id)
            WHERE 1
            AND users_quiz.active = '1'
            AND users_quiz.users_id = ?";
        $escape = array($id_user);
        $kueri = $this->db->query($sql, $escape);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $code;
        } else {
            $res['status'] = true;
            $res['message'] = 'Menampilkan data quiz';
            $res['data'] = $kueri->result_array();
        }
        return $res;
    }

    public function for_status($sesi)
    {
        $sql = "SELECT
            SUM(quiz.seconds) AS original,
            SUM(users_quiz_log.seconds_used) AS used
            FROM users_quiz
            LEFT JOIN quiz
            ON quiz.id = users_quiz.quiz_id
            LEFT JOIN users_quiz_log
            ON (users_quiz_log.quiz_code = quiz.code
                AND users_quiz_log.users_id = users_quiz.users_id)
            LEFT JOIN users
            ON users.id = users_quiz.users_id
            WHERE 1
            AND users_quiz.active = '1'
            AND users.sesi_code = ?";
        $escape = array($sesi);
        $kueri = $this->db->query($sql, $escape);
        $result = $kueri->result_array();
        return $result[0];
    }

    public function get_nilai_hexaco($user, $trait)
    {
        $sql = "SELECT jawaban, trait, reversed_score
            FROM personal_jawaban
            LEFT JOIN personal_questions
            ON personal_questions.id = personal_jawaban.personal_questions_id
            WHERE 1
            AND personal_jawaban.quiz_code = 'hexaco'
            AND personal_jawaban.users_id = ?
            AND personal_questions.trait = ?";
        $escape = array($user, $trait);
        $kueri = $this->db->query($sql, $escape);
        $result = $kueri->result_array();
        return $result;
    }

    public function get_header_trait()
    {
        $sql = "SELECT *
            FROM hexaco_group
            WHERE 1";
        $kueri = $this->db->query($sql);
        $result = $kueri->result_array();
        return $result;
    }

    public function get_infohexaco()
    {
        $sql = "SELECT *
            FROM hexaco_info
            WHERE 1";
        $kueri = $this->db->query($sql);
        $result = $kueri->result_array();
        return $result;
    }

    public function get_sdhexaco()
    {
        $sql = "SELECT *
            FROM hexaco_info
            WHERE 1
            AND CHAR_LENGTH(code) = 1";
        $kueri = $this->db->query($sql);
        $result = $kueri->result_array();
        return $result;
    }

    public function get_bysesi($sesi, $users_id)
    {
        $sql = "SELECT users.id AS id, username, fullname,
            formasi.label AS formasi_label,
            sesi.label AS sesi_label
            FROM users
            LEFT JOIN sesi
            ON sesi.code = users.sesi_code
            LEFT JOIN formasi
            ON formasi.code = users.formasi_code
            WHERE 1
            AND users.sesi_code = ?";
		
		if(isset($users_id) && count($users_id) > 0){
			$sql = $sql." AND users.id = ?";
			$escape = array($sesi, $users_id);
			$kueri = $this->db->query($sql, $escape);
		} else {
			$escape = array($sesi);
			$kueri = $this->db->query($sql, $escape);
		}
		
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = null;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() == 0) {
                $res['message'] = 'Tidak ada data';
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Menampilkan data users';
                $res['data'] = $kueri->result_array();
            }
        }
        return $res;
    }


    public function cek($user)
    {
        $sql = "SELECT DISTINCT jawaban_most as most, count(*) as total FROM disc_jawaban WHERE users_id = '$user' AND quiz_code = '$code' GROUP BY jawaban_most";


        $result_jawaban_most = $this->db->query($sql_jawaban_most, array(intval($users_id), strval($quiz_code)))->result();
        return $sql_jawaban_most;
    }
    
    public function get_psyco_aspect($where = NULL)
    {
        $db = $this->db;

        $db->select("*");
        if(count($where) > 0){
            $db->where($where);
        }

        $kueri = $db->get("psyco_aspect");
        if(!$kueri) {
            $err = $db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $err;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() > 0) {
                $res['message'] = 'Menampilkan data formasi';
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Tidak Ada Data';
                $res['data'] = null;
            }
        }
        return $res;
    }

    public function get_psyco_aspect_child($aspect)
    {
        $sql = "SELECT child
            FROM psyco_aspect_child
            WHERE 1
            AND aspect_id = '$aspect'";
        $kueri = $this->ci->db->query($sql);
        if(!$kueri) {
            $err = $this->ci->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $err;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() > 0) {
                $res['message'] = 'Menampilkan data formasi';
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Tidak Ada Data';
                $res['data'] = null;
            }
        }
        return $res;
    }

    
}
?>
