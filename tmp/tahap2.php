<?php
if (php_sapi_name() !== "cli")
	die('tidak bisa diakses');

define('BASEPATH', __DIR__ . '..');
define('ENVIRONMENT', 'production');

// ini untuk mengubah sesi secara otomatis menjadi tahap 2
include __DIR__ . DIRECTORY_SEPARATOR . '../application/config/database.php';

$mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']) or die('connection error');

// Ganti jadi Tahap 2
$mysqli->query("UPDATE `settings` SET `value` = 'Tahap 2' WHERE `name` = 'exam_part'");

// Ganti Greeting ke app_greeting2
$mysqli->query("INSERT INTO `settings` (`name`,`value`) VALUES ('exam_greeting','app_greeting2') ON DUPLICATE KEY UPDATE `value`='app_greeting2'");

// Set Inactive Quiz Ini:
$mysqli->query("UPDATE `quiz` SET active=0 WHERE `code` in ('gti','pauli')");

// Set Active Quiz Ini:
$mysqli->query("UPDATE `quiz` SET active=1 WHERE `code` in ('hexaco','d3ad','cti','toeic')");

// Hapus semua key yg active di Redis agar tidak ada user yg login
$redisClient = new Redis();
$redisClient->connect('redis', 6379 );

$redisClient->delete($redisClient->keys('ci_session:*'));
