<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Dashboard_mdl extends Ci_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('help');
	}

    public function getjumlah_quiz($id_user)
    {
        $sql = "SELECT quiz_id  
            FROM users_quiz 
            WHERE 1 
            AND active = '1'
            AND users_id = ?";
        $escape = array($id_user);
        $kueri = $this->db->query($sql, $escape);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = null;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() == 0) {
                $res['message'] = 'Tidak ada data';
                $res['data'] = $kueri->num_rows();
            } else {
                $res['message'] = 'Menampilkan data';
                $res['data'] = $kueri->num_rows();
            }
        }
        return $res;
    }

    public function get_userbysesi($sesi)
    {
        $sql = "SELECT users.id, username, fullname, 
            (CASE
            	WHEN formasi.label IS NULL THEN '-'
                ELSE CONCAT('Formasi ', formasi.label)
            END) AS formasi,
            formasi.code AS code
            FROM users
            LEFT JOIN formasi
            ON users.formasi_code = formasi.code
            WHERE 1
            AND users.sesi_code = ?";
        $escape = array($sesi);
        $kueri = $this->db->query($sql, $escape);
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
            	WHEN users_quiz_log.seconds_used = 0 THEN 'badge-danger'
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

    public function get_userquiz($sesi)
    {
        $sql = "SELECT users.id, username, fullname, 
            formasi.label AS formasi, 
            formasi.code AS quiz,
            agree_code AS status,
            
            quiz.id,
            quiz.code,
            quiz.label
            
            FROM users
            LEFT JOIN formasi
            ON users.formasi_code = formasi.code
            LEFT JOIN users_quiz
            ON users_quiz.users_id = users.id
            LEFT JOIN quiz
            ON quiz.id = users_quiz.quiz_id
            WHERE 1
            AND users_quiz.active = '1'
            AND users.sesi_code = ?";
        $escape = array($sesi);
        $kueri = $this->db->query($sql, $escape);
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

    public function cekstatus($user)
    {
        $sql = "SELECT *
            FROM users_quiz
            LEFT JOIN quiz
            ON quiz.id = users_quiz.quiz_id
            LEFT JOIN users_quiz_log
            ON (users_quiz_log.quiz_code = quiz.code
                AND users_quiz_log.users_id = users_quiz.users_id)
            WHERE 1
            AND users_quiz.active = '1'
            AND users_quiz.users_id = ?";
        $escape = array($user);
        $kueri = $this->db->query($sql, $escape);
        return $kueri->result_array();
    }

    public function for_status($user)
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
            WHERE 1
            AND users_quiz.active = '1'
            AND users_quiz.users_id = ?";
        $escape = array($user);
        $kueri = $this->db->query($sql, $escape);
        $result = $kueri->result_array();
        return $result[0];
    }

    public function get_belumchart($quiz_code)
    {
        $sql = "SELECT COUNT(DISTINCT(users.id)) AS jml
            FROM users
            LEFT JOIN users_quiz
            ON users_quiz.users_id = users.id
            WHERE 1
            AND sesi_code = ?
            AND users_quiz.active = '1'
            AND ((SELECT SUM(seconds_used)
                FROM users_quiz_log
                WHERE 1
                AND users_quiz_log.users_id = users.id) IS NULL 
            OR (SELECT SUM(seconds_used)
                FROM users_quiz_log
                WHERE 1
                AND users_quiz_log.users_id = users.id) = 0)";
        $escape = array($quiz_code);
        $kueri = $this->db->query($sql, $escape);
        $result = $kueri->result_array();
        return $result[0]['jml'];
    }

    public function get_progreschart($quiz_code)
    {
        $sql = "SELECT COUNT(DISTINCT(users.id)) AS jml
            FROM users
            LEFT JOIN users_quiz
            ON users_quiz.users_id = users.id
            WHERE 1
            AND sesi_code = ?
            AND users_quiz.active = '1'
            AND (SELECT SUM(seconds_used)
                FROM users_quiz_log
                WHERE 1
                AND users_quiz_log.users_id = users.id) > 0";
        $escape = array($quiz_code);
        $kueri = $this->db->query($sql, $escape);
        $result = $kueri->result_array();
        return $result[0]['jml'];
    }

    public function get_selesaichart($quiz_code)
    {
        $sql = "SELECT COUNT(DISTINCT(users.id)) AS jml
            FROM users
            LEFT JOIN users_quiz
            ON users_quiz.users_id = users.id
            WHERE 1
            AND sesi_code = ?
            AND users_quiz.active = '1'
            AND (SELECT SUM(seconds_used) 
                FROM users_quiz_log
                WHERE 1
                AND users_quiz_log.users_id = users.id) = 
                (SELECT SUM(seconds) 
                FROM users_quiz_log
                WHERE 1
                AND users_quiz_log.users_id = users.id)";
        $escape = array($quiz_code);
        $kueri = $this->db->query($sql, $escape);
        $result = $kueri->result_array();
        return $result[0]['jml'];
    }
}
?>
