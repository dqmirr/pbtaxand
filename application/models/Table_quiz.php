<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Table_quiz extends Ci_Model 
{
    private $db_table;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->db_table = $this->db->protect_identifiers('quiz', TRUE);
		$this->load->library('help');
	}

    function get_all()
	{
		$arg_list = func_get_args();
		if(count($arg_list)){
			$options = $arg_list[0];

			if($options['library']){
				$this->db->where('library_code', $options['library']);
			}
		}

        // $sql = "SELECT * FROM {$this->db_table}
		// 	ORDER BY id ASC";
		$this->db->order_by('id','ASC');
		$kueri = $this->db->get($this->db_table);
		if($options['library']){
			$count = $this->db->select('count(*) as total')->where('library_code', $options['library'])->get($this->db_table)->row_array();
		}else{
			$count = $this->db->select('count(*) as total')->get($this->db_table)->row_array();
		}
		$total = $count['total'];
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
        } else {
            $res['status'] = true;
            if($kueri->num_rows() > 0) {
                $res['data'] = $kueri->result_array();
				$res['meta'] = array(
					'total' => $total,
					'total_page' => ceil($total/$pagination),
					'current_page' => $page
				);
            } else {
                $res['message'] = 'Tidak Ada Data';
            }
        }
        return $res;
	}

	// function get_all($options){
	// 	var_dump($options);
	// 	if($options['page']){

	// 	}

	// 	if($options['pagination']){
	// 	}
	// 	return [];
	// }

	function get($id)
	{	
		$sql = "SELECT * FROM {$this->db_table}
			WHERE 1
			AND id = ?";
		$escape = array($id);
		$kueri = $this->db->query($sql, $escape);
		if($kueri->num_rows() == 1) {
			$res['status'] = true;
			$res['data'] = $kueri->result_array()[0];
		} else {
			$res['status'] = false;
			$res['message'] = 'Terjadi kesalahan';
		}
		return $res;
		// return $sql;
	}

	function update($id, $data){
		$res = array();
		
		if(!$id){
			$res['status'] = false;
			$res['message'] = 'id must be defined';
			return $res;
		}

		$check = $this->check_byid($id);

		if($check['status'] == false) {
			return $check;
		}

		$this->db->set('code', $data['code']);
		$this->db->set('label', $data['label']);
		$this->db->set('description', $data['description']);
		

		if($data['library_code']){
			$this->db->set('library_code', $data['library_code']);
		}else{
			$this->db->set('library_code', null);
		}

		if($data['group_quiz_code']){
			// $res = $this->validate_group_quiz($data["group_quiz_code"]);
			// if(!$res["status"]){
			// 	return $res;
			// }
			$this->db->set('group_quiz_code', $data['group_quiz_code']);
		}else{
			$this->db->set('group_quiz_code', null);
		}

		$this->db->set('active', (string) $data['active']);
		$this->db->set('is_show', (string) $data['is_show']);
		$this->db->set('seconds', $data['seconds']);
		$this->db->set('allow_restart', $data['allow_restart']);
		$this->db->set('sub_library_code', $data['sub_library_code']);

		$this->db->where('id', $id);
		$update = $this->db->update($this->db_table);
		if(!$update){
			$err = $this->db->error();
			$res['status'] = false;
			$res['message'] = $err['message'];
		} else {
			$res['status'] = true;
			$res['message'] = 'quiz updated successfully';
		}
		return $res;
	}

	function insert($data)
	{
		if($data["code"]){
			$res = $this->validate_quiz_code($data["code"]);
			if(!$res["status"]){
				return $res;
			}
		}
		
		if(isset($data["group_quiz_code"])){
			$res = $this->validate_group_quiz($data["group_quiz_code"]);
			if(!$res["status"]){
				return $res;
			}
		}

		if(empty($data["group_quiz_code"]) && empty($data["library_code"])){
			return [
				'status' => false,
				'message' => 'Salah satu harus diisi. Kolom Library Code atau Group Quiz Code'
			];
		}


		$set_insert = $this->help->set_insert_sql($data, 'library_code');

        $sql = "INSERT INTO {$this->db_table}
            SET $set_insert,
            library_code = (
                SELECT code
                FROM library
                WHERE 1
                AND code = ?)";
		$set_escape = $this->help->set_escape_sql($data, 'library_code');
        $escape = array_merge($set_escape, array($data['library_code']));
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

	function check_byid($id)
	{
		$sql = "SELECT * FROM {$this->db_table}
			WHERE 1
			AND id = ?";
		$escape = array($id);
		$kueri = $this->db->query($sql, $escape);
		if($kueri->num_rows() == 1) {
			$res['status'] = true;
			$res['data'] = $kueri->result_array()[0];
		} else {
			$err = $this->db->error();
			$res['status'] = false;
			$res['message'] = $err['message'];
		}
		return $res;
	}

	function get_jenis_soal()
	{
		$sql = "SELECT DISTINCT(code) 
			FROM quiz 
			WHERE 1
			AND library_code = 'multiplechoice'
			ORDER BY code ASC";
		$kueri = $this->db->query($sql);
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

	function delete($id)
	{
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
		return $res;
	}

	public function jumlah_quiz()
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
                $res['message'] = 'Menampilkan jumlah quiz';
                $result = $kueri->result_array();
                $res['data'] = $result[0]['jumlah'];
            } else {
                $res['message'] = 'Tidak Ada Data';
                $res['data'] = '0';
            }
        }
        return $res;
	}

	private function validate_group_quiz($group_quiz_code){
		$found_group_quiz = $this->db->select("*")
										->where("group_quiz_code", $group_quiz_code)
										->get($this->db_table)->num_rows();
	
		if($found_group_quiz > 0){
			return [
				'status' => false,
				'message' => 'Group Quiz Hanya Bisa Di Terapkan di Satu Quiz Saja. Group Quiz Sudah Tersimpan'
			];
		}

		return [
			'status' => true,
			'message' => ''
		];
	}

	private function validate_quiz_code($code){
		$found_group_quiz = $this->db->select("*")
										->where("code", $code)
										->get($this->db_table)->num_rows();
	
		if($found_group_quiz > 0){
			return [
				'status' => false,
				'message' => 'Tidak Bisa Menambahkan Code '.$code.'. Karena Sudah Ditambahkan Sebelumnya'
			];
		}

		return [
			'status' => true,
			'message' => ''
		];
	}

}
?>
