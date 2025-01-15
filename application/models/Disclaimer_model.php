<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Disclaimer_model extends Ci_Model {

	public function get_gco_policy($users_id){
		$sql = $this->db->query("SELECT rp.id as value, rp.content as text, gp.is_checked as is_checked 
								FROM gco_policy gp
								LEFT JOIN ref_policy rp ON (gp.ref_policy_id = rp.id)
								LEFT JOIN users u ON (gp.users_id = u.id)
								WHERE u.id = ?", 
								array($users_id) );
		return $sql;
	}

	public function insert_gco_policy($users_id){
		$this->db->query("INSERT INTO gco_policy (users_id, ref_policy_id, is_checked)
						SELECT ?, rp.id, FALSE FROM ref_policy rp",
						array($users_id));
	}

	public function validate_gco_policy($user_id){
		$count_gco_policy = $this->db->query("SELECT COUNT(*) as total
						FROM gco_policy 
						WHERE is_checked = TRUE 
						AND users_id = ? ",
						array(
							$user_id
						)
					)->result()[0]->total;

		$count_ref_policy = $this->db->query("SELECT COUNT(*) as total
											FROM ref_policy")->result()[0]->total;
		return $count_ref_policy == $count_gco_policy;
	}

	public function set_checked_gco_policy($user_id, $list_policy){
		return $this->set_list_policy(true, intval($user_id), $list_policy);
	}

	public function set_unchecked_gco_policy($user_id, $list_policy){
		return $this->set_list_policy(false, intval($user_id), $list_policy);
	}

	public function set_list_policy($is_checked, $user_id, $list_policy){
		$this->db->trans_start();
		$this->db->query("UPDATE gco_policy 
							SET is_checked = FALSE
							WHERE users_id = ?",
							array($user_id));
		$this->db->query("UPDATE gco_policy 
							SET is_checked = ?
							WHERE users_id = ? and ref_policy_id in ?",
							array($is_checked, $user_id, $list_policy));
		$this->db->trans_complete();
	}

	public function show_unchecked_gco_policy($user_id){
		$sql = $this->db->query("SELECT rp.id as `value`, rp.content as `text` FROM gco_policy gp
								LEFT JOIN ref_policy rp ON (rp.id = gp.ref_policy_id)
								WHERE gp.users_id = ?", array($user_id));
		return $sql->result();
	}

}
