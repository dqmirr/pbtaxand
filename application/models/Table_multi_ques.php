<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Table_multi_ques extends Ci_Model 
{
    private $db_table;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->db_table = $this->db->protect_identifiers('multiplechoice_question', TRUE);
        $this->load->library('help');
	}

    function add($data)
    {
        $set_insert = $this->help->set_edit_sql($data);
        $sql = "INSERT INTO {$this->db_table}
            SET $set_insert";
		$set_escape = $this->help->set_escape_sql($data);
        $kueri = $this->db->query($sql, $set_escape);
		if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = null;
        } else {
            $res['status'] = true;
            $res['message'] = 'Berhasil disimpan';
            $res['data'] = $data;
        }
        return $res;
        
    }

	function delete($id)
	{
        $sql = "DELETE FROM {$this->db_table}
            WHERE 1
            AND id = ?";
        $escape = array($id);
        $kueri = $this->db->query($sql, $escape);
        if(!$kueri) {
            return false;
        } else {
            return true;
        }
	}

    public function get_jumlah()
    {
        $sql = "SELECT COUNT(id) AS jumlah 
            FROM {$this->db_table}";
        $kueri = $this->db->query($sql);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = null;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() == 1) {
                $res['message'] = 'Menampilkan jumlah multiple question';
                $result = $kueri->result_array();
                $res['data'] = $result[0]['jumlah'];
            } else {
                $res['message'] = 'Tidak Ada Data';
                $res['data'] = '0';
            }
        }
        return $res;
    }

}
?>
