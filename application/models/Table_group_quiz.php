<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Table_group_quiz extends Ci_Model 
{
    private $db_table;
	function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->db_table = $this->db->protect_identifiers('group_quiz', TRUE);
        $this->load->library('help');
    }

    function get_all()
    {
        $sql = "SELECT * FROM {$this->db_table}
            ORDER BY code ASC";
        $kueri = $this->db->query($sql);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $err;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() > 0) {
                $res['message'] = 'Menamplikan data group quiz';
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
