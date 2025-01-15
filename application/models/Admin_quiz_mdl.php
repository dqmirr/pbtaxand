<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Admin_quiz_mdl extends Ci_Model 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('help');
    }

    public function quiz_soal_multiple($id)
    {
        // get quiz soal
        $sql = "SELECT multiplechoice_question.* 
            FROM quiz 
            LEFT JOIN multiplechoice_question 
            ON label = jenis_soal
            WHERE 1
            AND library_code = ?
            AND quiz.id = ?
            AND multiplechoice_question.id IS NOT NULL";
        $escape = array('multiplechoice', $id);
        $kueri = $this->db->query($sql, $escape);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
        } else {
            $res['status'] = true;
            if($kueri->num_rows() > 0) {
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Tidak Ada Data';
            }
        }
        return $res;
    }

    public function get_pilihan_jawaban($id_multi)
    {
        $sql = "SELECT *
            FROM multiplechoice_choices
            WHERE 1
            AND multiplechoice_question_id = ?";
        $escape = array($id_multi);
        $kueri = $this->db->query($sql, $escape);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
        } else {
            $res['status'] = true;
            if($kueri->num_rows() > 0) {
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Tidak Ada Data';
            }
        }
        return $res;
    }

    public function edit_soal($id, $data) 
    {
        $this->db_table = $this->db->protect_identifiers('multiplechoice_question', true);
        $set_edit = $this->help->set_edit_sql($data);
        $sql = "UPDATE {$this->db_table}
            SET $set_edit
            WHERE 1
            AND id = ?";
        $set_escape = $this->help->set_escape_sql($data);
        $escape = array_merge($set_escape, array($id));
        $kueri = $this->db->query($sql, $escape);
		if(!$kueri) {
            // $err = $this->db->error();
            // $res['status'] = false;
            // $res['message'] = $err['message'];
            return false;
		} else {
            // $res['status'] = true;
            // $res['data'] = $sql;
            return true;
		}
        // return $res;
    }

    public function submit_pilihan($id, $data)
    {
        $this->db_table = $this->db->protect_identifiers('multiplechoice_choices', true);
        $set_insert = $this->help->set_insert_sql($data);
        $sql = "INSERT INTO {$this->db_table}
            SET $set_insert,
            multiplechoice_question_id = (
                SELECT id
                FROM multiplechoice_question
                WHERE 1
                AND id = ?)";
        
        $set_escape = $this->help->set_escape_sql($data);
        $escape = array_merge($set_escape, array($id));
        $kueri = $this->db->query($sql, $escape);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
        } else {
            $res['status'] = true;
            $res['data'] = $data;
        }
        return $res;
    }

    public function reset_pilihan($id)
    {
        $this->db_table = $this->db->protect_identifiers('multiplechoice_choices', true);
        // $this->db->trans_begin();
        $sql = "DELETE FROM {$this->db_table}
            WHERE 1
            AND multiplechoice_question_id = ?";
        $escape = array($id);
        $kueri = $this->db->query($sql, $escape);
        if(!$kueri) {
            // $this->db->trans_rollback();
            return false;
        } else {
            // $this->db->trans_commit();
            return true;
        }

        // if($this->db->trans_status() === FALSE) { 
        //     $this->db->trans_rollback();
        // } else {
        //     $this->db->trans_commit();
        // }
    }

    

}
?>
