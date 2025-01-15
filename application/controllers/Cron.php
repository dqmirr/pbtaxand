<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if (php_sapi_name() !== 'cli')
		{
			redirect('/'); return;
		}
	}
	
	public function execute()
	{
		$this->load->database();
		
		// Configurasi saat dieksekusi
		$date = date('Y-m-d');
		$time = date('H:i:00');
		
		// Dapatkan semua data yang date dan time_from/time_to sama dengan saat cron ini jalan.
		$get = $this->db->query('
		SELECT 
			`users_id`, `quiz_id`, `time_from`, `time_to`
		FROM 
			users_quiz_schedule
		WHERE 
			`date` = ? AND (`time_from` = ? OR `time_to` = ?)
			AND
			`active` = 1
		', array($date, $time, $time));
		
		// Jika ketemu, eksekusi. Dengan rincian berikut:
		$total_executed = 0;
		
		foreach ($get->result() as $row)
		{
			switch ($time)
			{	
				// Jika yang sama adalah time_from, maka active = 1
				case $row->time_from:
					$active = 1;
				break;
				
				// Jika yang sama adalah time_to, maka active = 0
				case $row->time_to:
					$active = 0;
				break;
				
				default: continue;
			}
			
			// Ubah status active users_quiz
			$this->db->set('active', $active);
			$this->db->where('users_id', $row->users_id);
			$this->db->where('quiz_id', $row->quiz_id);
			$this->db->update('users_quiz');
			
			$total_executed += 1;
		}
		
		$output = "Date: {$date}, Time: {$time}, Total Executed: {$total_executed}\n";

		// tidak perlu menggunakan log_message codeigniter. hanya catat yang berhasil dieksekusi
		if ($total_executed > 0)
		{
			$logfile_dir = 'application/logs/';
			$logfile = $logfile_dir.'cron.log';
						
			if (is_writable($logfile_dir))
			{
				$fp = fopen($logfile, 'a');
				fwrite($fp, $output);
				fclose($fp);
			}
		}
		
		echo $output;
	}
}
