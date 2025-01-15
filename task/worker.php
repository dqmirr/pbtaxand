<?php
if (php_sapi_name() !== "cli")
	die('tidak bisa diakses');

$system_path = '../system/';
define('APP_FOLDER', '../application');
define('BASEPATH', $system_path);
define('ENVIRONMENT', 'development');
define('APPPATH', __DIR__ . DIRECTORY_SEPARATOR . APP_FOLDER . DIRECTORY_SEPARATOR);
define('FROM_CLI', true);
define('VIEWPATH', __DIR__ .'/../application/views/');

require_once __DIR__ . '/vendor/autoload.php';

define("RABBITMQ_HOST", "rabbitmq");
define("RABBITMQ_PORT", 5672);
define("RABBITMQ_USERNAME", "exam");
define("RABBITMQ_PASSWORD", "exam");
define("RABBITMQ_QUEUE_NAME", "task_queue");

$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(
    RABBITMQ_HOST, 
    RABBITMQ_PORT, 
    RABBITMQ_USERNAME, 
    RABBITMQ_PASSWORD
);

$channel = $connection->channel();

# Create the queue if it doesnt already exist.
$channel->queue_declare(
    $queue = RABBITMQ_QUEUE_NAME,
    $passive = false,
    $durable = true,
    $exclusive = false,
    $auto_delete = false,
    $nowait = false,
    $arguments = null,
    $ticket = null
);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function($msg){
		
	echo " [x] Received ", $msg->body, "\n";
	$job = json_decode($msg->body, $assocForm=true);
	
	$library = $job['library'];
	$code = $job['code'];
	$key = $job['key'];
	$jawaban = $job['answers'];
	$id = $job['id'];
	$done = $job['done'];
	$users_id = isset($job['users_id']) ? $job['users_id'] : 0;
	
	$path = __DIR__ . DIRECTORY_SEPARATOR . APP_FOLDER . DIRECTORY_SEPARATOR . 'libraries/Exam_' . $library . '.php';
	
	if (file_exists($path))
	{
		require_once __DIR__ . DIRECTORY_SEPARATOR . BASEPATH . 'core/CodeIgniter.php';
		require_once $path;
		
		$ci =& get_instance();
		$ci->load->database();
		
		// periksa dulu apakah code ini ada. kalau tidak ada maka reject
		$sql = 'SELECT code FROM quiz WHERE code = ?';
		$get = $ci->db->query($sql, array($code));
		
		if ($get->num_rows() == 0)
		{
			echo " [x] Quiz Code Not Found", "\n";
			$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
		}
		else
		{
			$classname = 'Exam_' . $library;
			$quiz = new $classname;
		
			if (gettype($quiz) == 'object' && ($key != null or $users_id > 0))
			{
				// Kalau users_id tidak ada maka cari dulu ke table users berdasarkan key yang dikirim
				if ($users_id == 0)
				{
					// Ambil users_id berdasarkan key
					$hashed = explode('_', $key);
					$hashed_username = $hashed[0];
					$hashed_id = $hashed[1];
					
					$sql = 'SELECT id FROM users WHERE sha1(username) = ? AND sha1(id) = ?';
					$get = $ci->db->query($sql, array($hashed_username, $hashed_id));		
					
					if ($row = $get->first_row())
					{
						$users_id = $row->id;
					}
				}
					
				if ($users_id > 0)
				{
					if ($done == 1)
					{
						// Load model
						$ci->load->model('users_quiz_model');
						
						if (count($jawaban) > 0)
							$quiz->save_answers($users_id, $code, $jawaban);
						
						$stat = $ci->users_quiz_model->done($users_id, $code);
					}
					else
					{
						$stat = $quiz->save_answers($users_id, $code, $jawaban);
					}
					
					if ($stat) 
					{
						echo " [x] Done", "\n";
						$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
					}
					else
					{
						echo " [x] Error During Save Answer Job", "\n";
						$msg->delivery_info['channel']->basic_nack($msg->delivery_info['delivery_tag']);
					}
				}
				else
				{
					echo " [x] User Not Found", "\n";
					$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
				}
			}
			else if ($key == null)
			{
				echo " [x] No Key Found", "\n";
				$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
			}
		}
	}
	else
	{
		echo "[x] Library Not Found", "\n";
		$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
	}
	
	//sleep($job['sleep_period']);
};

$channel->basic_qos(null, 1, null);

$channel->basic_consume(
    $queue = RABBITMQ_QUEUE_NAME,
    $consumer_tag = '',
    $no_local = false,
    $no_ack = false,
    $exclusive = false,
    $nowait = false,
    $callback
);

while (count($channel->callbacks)) 
{
    $channel->wait();
}

$channel->close();
$connection->close();
