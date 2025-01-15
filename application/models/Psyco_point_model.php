
<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Psyco_point_model extends Ci_Model
{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get_point($quiz_code, $value){
        $this->db->where('quiz_code', $quiz_code);
        $this->db->where('min <=', $value);
        $this->db->where('max >=', $value);
        $get = $this->db->get('psyco_point');
        return $get->row_array();
    }

    public function get_min_point($quiz_code){
        $this->db->select('MIN(`point`) as point');
        $this->db->where('quiz_code', $quiz_code);
        $get = $this->db->get('psyco_point');
        return $get->row_array();
    }

    public function get_by($options){
        foreach($options as $key => $value){
            $this->db->where($key, $value);
        }
        return $this->db->get('psyco_point')->result_array();
    }
}
