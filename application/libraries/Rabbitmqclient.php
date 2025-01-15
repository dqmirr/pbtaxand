<?php
// Ini untuk menyimpan semua jawaban dalam bentuk queue
require_once(__DIR__ . '/vendor/autoload.php');

class rabbitmqclient {
	
	public function __construct()
	{
		define("RABBITMQ_HOST", "rabbitmq");
		define("RABBITMQ_PORT", 5672);
		define("RABBITMQ_USERNAME", "exam");
		define("RABBITMQ_PASSWORD", "exam");
		define("RABBITMQ_QUEUE_NAME", "task_queue");
	}
	
	public function send($data)
	{
		$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(
			RABBITMQ_HOST, 
			RABBITMQ_PORT, 
			RABBITMQ_USERNAME, 
			RABBITMQ_PASSWORD,
			'/'
		);

		$channel = $connection->channel();
		
		$jobArray = array(
			'users_id' => $data['users_id'],
			'key' => $data['key'],
			'answers' => isset($data['answers']) ? $data['answers'] : array(),
			'code' => $data['code'],
			'done' => $data['done'],
			'id' => isset($data['id']) ? $data['id'] : '',
			'library' => $data['library'],
		);

		$msg = new \PhpAmqpLib\Message\AMQPMessage(
			json_encode($jobArray, JSON_UNESCAPED_SLASHES),
			array('delivery_mode' => 2) # make message persistent
		);

		$channel->basic_publish($msg, '', RABBITMQ_QUEUE_NAME);

		$channel->close();
		$connection->close();
		
		return true;
	}
}
