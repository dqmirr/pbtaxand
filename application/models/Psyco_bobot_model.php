
<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Psyco_bobot_model extends Ci_Model
{
    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get_bobot($quiz_code)
    {
        $this->db->where('quiz_code', $quiz_code);
        $get = $this->db->get('psyco_bobot');
        return $get->row_array();
    }
}
