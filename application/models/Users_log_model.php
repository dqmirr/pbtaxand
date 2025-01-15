<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_log_model extends Ci_Model {

	public function log($action)
	{
		$dbsave = $this->load->database('save', TRUE);
		
		// Insert ke Log sebagai activity
		$dbsave->set('time', 'NOW()', false);
		$dbsave->set('action', $action);
		$dbsave->set('users_id', $this->session->userdata('id'));
		
		$dbsave->insert('users_log');
		
		// Update ke users agar tau kapan terakhir update
		$dbsave->set('last_update', 'NOW()', false);
		$dbsave->where('id', $this->session->userdata('id'));
		
		$dbsave->update('users');
	}
}
