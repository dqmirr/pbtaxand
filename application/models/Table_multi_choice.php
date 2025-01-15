<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Table_multi_choice extends Ci_Model 
{
    private $db_table;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->db_table = $this->db->protect_identifiers('multiplechoice_choices', TRUE);
        $this->load->library('help');
	}

	function delete($id)
	{
        $sql = "DELETE FROM {$this->db_table}
            WHERE 1
            AND multiplechoice_question_id = ?";
        $escape = array($id);
        $kueri = $this->db->query($sql, $escape);
        if(!$kueri) {
            return false;
        } else {
            return true;
        }
	}

	function choice_by_multiplechoices_ids($ids){
		$this->db->select('*');

		if(!is_array($ids)){
			return array(
				'status' => 'error',
				'message' => 'ids must be array'
			);
		}

		$this->db->where_in($ids);
		$get = $this->db->get($this->db_table);

		$counter = $this->db->query("SELECT count(*) as total FROM {$this->db_table}");
		return array(
			'status' => 'success', 
			'list' => $get->array_result(),
			'total' => $counter->total
		);
	}

	function choice_by_multiplechoices_id($id){
		$this->db->select('*');

		$this->db->where('multiplechoice_question_id', $id);
		$get = $this->db->get('multiplechoice_choices');

		return array(
			'status' => 'success', 
			'list' => $get->result_array()
		);
	}

}
?>
