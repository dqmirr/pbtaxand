<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Table_users extends Ci_Model
{
    private $db_table;
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->db_table = $this->db->protect_identifiers('users', TRUE);
        $this->load->library('help');
    }

    public function get_by_sesi($sesi)
    {
        $sql = "SELECT id, username, fullname
            FROM {$this->db_table}
            WHERE 1
            AND sesi_code = ?";
        $escape = array($sesi);
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
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Menampilkan data users';
                $res['data'] = $kueri->result_array();
            }
        }
        return $res;
    }

    public function get_by_sesi_for_tags($sesi)
    {
        $sql = "SELECT id AS value, fullname, username
            FROM {$this->db_table}
            WHERE 1
            AND sesi_code = ?
            ORDER BY fullname ASC";
        $escape = array($sesi);
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
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Menampilkan data users';
                $res['data'] = $kueri->result_array();
            }
        }
        return $res;
    }

    public function get_all_for_tags()
    {
        $sql = "SELECT id AS value, fullname, username
            FROM {$this->db_table}
            WHERE 1
            AND sesi_code IS NULL
            ORDER BY fullname ASC";
        $kueri = $this->db->query($sql);
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

    public function edit_users($id, $data)
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

    public function get_for_reset($code)
    {
        $sql = "SELECT id FROM {$this->db_table}
            WHERE 1
            AND sesi_code = ?";
        $escape = array($code);
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

    public function reset_field_sesi($id_user)
    {
        $sql = "UPDATE {$this->db_table}
            SET sesi_code = NULL
            WHERE 1
            AND id = ?";
        $escape = array($id_user);
        $kueri = $this->db->query($sql, $escape);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $id_user;
        } else {
            $res['status'] = true;
            $res['message'] = 'Berhasil direset';
            $res['data'] = $id_user;
        }
        return $res;
    }

    public function get_actived()
    {
        $sql = "SELECT COUNT(id) AS jumlah
            FROM {$this->db_table}
            WHERE 1
            AND active = '1'";
        $kueri = $this->db->query($sql);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = null;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() == 1) {
                $res['message'] = 'Menampilkan jumlah user';
                $result = $kueri->result_array();
                $res['data'] = $result[0]['jumlah'];
            } else {
                $res['message'] = 'Tidak Ada Data';
                $res['data'] = '0';
            }
        }
        return $res;
    }

    public function get_byusername($username)
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
            (CASE
                WHEN users.tgl_lahir IS NULL THEN ''
                ELSE users.tgl_lahir
            END) AS tgl_lahir
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
            AND users.username = ?";
        $escape = array($username);
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
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Menampilkan data users';
                $res['data'] = $kueri->result_array();
            }
        }
        return $res;
    }
}
?>
