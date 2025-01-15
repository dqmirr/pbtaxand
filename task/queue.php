<?php die();
// Ini untuk menyimpan semua jawaban dalam bentuk queue
require_once(__DIR__ . '/vendor/autoload.php');

$users_id = null;

if (isset($_COOKIE['ci_session']))
{
	$redisClient = new Redis();
	$redisClient->connect('redis', 6379 );

	$id = $_COOKIE['ci_session'];

	$data = $redisClient->get('ci_session:'.$id);
	$arr_part = explode(';',$data);

	foreach ($arr_part as $part)
	{
		$bag = explode('|', $part);
		
		if ($bag[0] == 'id')
		{
			$users_id = unserialize($bag[1].';');
			break;
		}
	}
	
	$redisClient->setTimeout('ci_session:'.$id, 10800);
	
	if ($users_id !== null)
	{
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

		# Create the queue if it does not already exist.
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

		$jobArray = array(
			'users_id' => $users_id,
			'key' => $_POST['key'],
			'answers' => isset($_POST['answers']) ? $_POST['answers'] : array(),
			'code' => $_POST['code'],
			'done' => $_POST['done'],
			'id' => isset($_POST['id']) ? $_POST['id'] : '',
			'library' => $_POST['library'],
		);

		$msg = new \PhpAmqpLib\Message\AMQPMessage(
			json_encode($jobArray, JSON_UNESCAPED_SLASHES),
			array('delivery_mode' => 2) # make message persistent
		);

		$channel->basic_publish($msg, '', RABBITMQ_QUEUE_NAME);

		$channel->close();
		$connection->close();

		echo '{"success": true}';
		return;
	}
}

echo '{"error": true, "msg": "Silahkan Login Kembali"}';
