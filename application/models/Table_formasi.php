<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Table_formasi extends Ci_Model 
{
    private $db_table;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->db_table = $this->db->protect_identifiers('formasi', TRUE);
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

    public function get_bycodesesi($code)
    {
        $sql = "SELECT id, code, sesi_code FROM {$this->db_table}
            WHERE 1
            AND sesi_code = ?";
        $escape = array($code);
        $kueri = $this->db->query($sql, $escape);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $err;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() > 0) {
                $res['message'] = 'Menampilkan data Formasi';
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Data tidak ditemukan';
                $res['data'] = null;
            }
        }
        return $res;
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
                $res['message'] = 'Menampilkan jumlah formasi';
                $result = $kueri->result_array();
                $res['data'] = $result[0]['jumlah'];
            } else {
                $res['message'] = 'Tidak Ada Data';
                $res['data'] = '0';
            }
        }
        return $res;
    }

    public function get_allwith_relation()
    {
        $sql = "SELECT formasi.id AS id_formasi,
            formasi.code AS code_formasi,
            formasi.label AS label_formasi,
            sesi.label AS label_sesi,
            sesi.time_from,
            sesi.time_to,
            posisi_jabatan.label AS divisi,
            posisi_level.label AS level
            FROM formasi
            LEFT JOIN sesi
            ON sesi.code = formasi.sesi_code
            LEFT JOIN posisi_jabatan
            ON posisi_jabatan.id = formasi.posisi
            LEFT JOIN posisi_level
            ON posisi_level.id = formasi.tingkatan";
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

    public function insert($data)
    {
        $set_insert = $this->help->set_insert_sql($data);
        $sql = "INSERT INTO {$this->db_table}
            SET $set_insert";
        $escape = $this->help->set_escape_sql($data);
        $kueri = $this->db->query($sql, $escape);
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

    public function edit($id, $data)
    {
        $set_edit = $this->help->set_edit_sql($data);
        $sql = "UPDATE {$this->db_table}
            SET $set_edit
            WHERE 1
            AND id = ?";
        $set_escape = $this->help->set_escape_sql($data);
        $escape = array_merge($set_escape, array($id));
        $kueri = $this->db->query($sql, $escape);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = null;
        } else {
            $res['status'] = true;
            $res['message'] = 'Berhasil disimpan';
            $res['data'] = $id;
        }
        return $res;
    }

    public function delete($code)
    {
        // $this->help->set_foreign_off();
        $sql = "DELETE FROM {$this->db_table}
			WHERE 1
			AND code = ?";
		$escape = array($code);
		$kueri = $this->db->query($sql, $escape);
		if(!$kueri) {
			$err = $this->db->error();
			$res['status'] = false;
			$res['message'] = $err['message'];
			$res['data'] = null;
		} else {
			$res['status'] = true;
			$res['message'] = 'Berhasil dihapus';
			$res['data'] = $id;
		}
        // $this->help->set_foreign_on();
		return $res;
    }
}
?>