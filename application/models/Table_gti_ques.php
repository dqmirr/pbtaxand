<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Table_gti_ques extends Ci_Model 
{
    private $db_table;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->db_table = $this->db->protect_identifiers('gti_questions', TRUE);
		$this->load->library('help');
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
                $res['message'] = 'Menampilkan jumlah gti question';
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
