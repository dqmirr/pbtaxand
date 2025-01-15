<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Table_sesi extends Ci_Model 
{
    private $db_table;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->db_table = $this->db->protect_identifiers('sesi', TRUE);
        $this->load->library('help');
	}

	function get_all_without_limit(){
		// $sql = "SELECT * FROM {$this->db_table}
        //     ORDER BY time_to DESC, time_from DESC";
        // $kueri = $this->db->query($sql);
        // $sql = "SELECT * FROM {$this->db_table}
        //     ORDER BY time_to DESC, time_from DESC";
		$this->db->select('*');
		$this->db->order_by("time_to DESC");

        $kueri = $this->db->get($this->db_table);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $err;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() > 0) {
                $res['message'] = 'Menampilkan data sesi';
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Tidak Ada Data';
                $res['data'] = null;
            }
        }
        return $res;
	}

    function get_all($page = 1)
    {
		$perpage = 8;
		$offset = ($page - 1) * $perpage;
        // $sql = "SELECT * FROM {$this->db_table}
        //     ORDER BY time_to DESC, time_from DESC";
        // $kueri = $this->db->query($sql);
        // $sql = "SELECT * FROM {$this->db_table}
        //     ORDER BY time_to DESC, time_from DESC";
		$this->db->select('*');
		$total_rows = $this->db->count_all_results($this->db_table);

		$res['pagination'] = [
			'page' => $page,
			'perpage' => $perpage,
			'total_rows' => $total_rows,
			'total_page'=> ceil($total_rows/$perpage)
		];
		
		$this->db->limit($perpage, $offset);
		$this->db->order_by("time_to DESC");
        $kueri = $this->db->get($this->db_table);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $err;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() > 0) {
                $res['message'] = 'Menampilkan data sesi';
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Tidak Ada Data';
                $res['data'] = null;
            }
        }
        return $res;
    }

    function get($id)
	{	
		$sql = "SELECT * FROM {$this->db_table}
			WHERE 1
			AND id = ?";
        $escape = array($id);
		$kueri = $this->db->query($sql, $escape);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = null;
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

    public function delete($id)
    {
        $this->help->set_foreign_off();
        $sql = "DELETE FROM {$this->db_table}
			WHERE 1
			AND id = ?";
		$escape = array($id);
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
        $this->help->set_foreign_on();
		return $res;
    }

    public function get_field($id, $field) // Get sesuai kebutuhan kolom
    {
        $set_field = $this->help->set_field_sql($field);
        $sql = "SELECT $set_field
            FROM {$this->db_table}
            WHERE 1
            AND id = ?";
        $escape = array($id);
		$kueri = $this->db->query($sql, $escape);
		if(!$kueri) {
			$err = $this->db->error();
			$res['status'] = false;
			$res['message'] = $err['message'];
			$res['data'] = null;
		} else {
			$res['status'] = true;
			$res['message'] = 'Berhasil dihapus';
			$res['data'] = $kueri->result_array()[0];
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
            $res['data'] = null;
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

    public function get_byfromto($to)
    {
        $sql = "SELECT * FROM {$this->db_table}
			WHERE 1
			AND time_to LIKE ?
            OR time_from LIKE ?
            ORDER BY time_to DESC";
        $per = $to.'%';
        $escape = array($per, $per);
		$kueri = $this->db->query($sql, $escape);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = null;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() > 0) {
                $res['message'] = 'Menampilkan data sesi';
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Tidak Ada Data';
                $res['data'] = null;
            }
        }
        return $res;
    }

    public function get_actived()
    {
        $date = date('Y-m');
        $sql = "SELECT COUNT(id) AS jumlah
            FROM sesi
            WHERE 1
            AND time_to LIKE ?
            OR time_from LIKE ?";
        $per = $to.'%';
        $escape = array($per, $per);
        $kueri = $this->db->query($sql, $escape);
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

    public function get_forchart($to)
    {
        $sql = "SELECT code
            FROM {$this->db_table}
			WHERE 1
			AND time_to LIKE ?
            OR time_from LIKE ?
            ORDER BY time_to DESC";
        $per = $to.'%';
        $escape = array($per, $per);
		$kueri = $this->db->query($sql, $escape);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = null;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() > 0) {
                $res['message'] = 'Menampilkan data sesi';
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Tidak Ada Data';
                $res['data'] = null;
            }
        }
        return $res;
    }

    public function get_jumlahall()
    {
        $sql = "SELECT COUNT(*) AS jumlah 
            FROM {$this->db_table}";
        $kueri = $this->db->query($sql);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $err;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() > 0) {
                $res['message'] = 'Menampilkan jumlah sesi';
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
