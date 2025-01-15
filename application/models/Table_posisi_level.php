<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Table_posisi_level extends Ci_Model 
{
    private $db_table;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->db_table = $this->db->protect_identifiers('posisi_level', TRUE);
        $this->load->library('help');
	}

    public function get_all()
    {
        $sql = "SELECT * FROM {$this->db_table}";
        $kueri = $this->db->query($sql);
        if(!$kueri) {
            $err = $this->db->error();
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

    public function get_bycode($code) 
    {
        $sql = "SELECT * FROM {$this->db_table}
            WHERE 1
            AND code = ?";
        $escape = array($code);
        $kueri = $this->db->query($sql, $escape);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $err;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() == 1) {
                $res['message'] = 'Menampilkan data sesi';
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Data tidak sesuai';
                $res['data'] = $kueri->result_array();
            }
        }
        return $res;
    }

    public function get_byid($id) 
    {
        $sql = "SELECT * FROM {$this->db_table}
            WHERE 1
            AND id = ?";
        $escape = array($code);
        $kueri = $this->db->query($sql, $escape);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $err;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() == 1) {
                $res['message'] = 'Menampilkan data sesi';
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Data tidak sesuai';
                $res['data'] = $kueri->result_array();
            }
        }
        return $res;
    }
}
?>