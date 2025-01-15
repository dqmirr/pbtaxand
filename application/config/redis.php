<?php  
if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * Date: 2017/2/9
 * Time: 13:32
 */
$config['redis_default']['socket_type'] = 'tcp';
$config['redis_default']['socket'] = '/var/run/redis.sock';
$config['redis_default']['host'] = 'localhost';
$config['redis_default']['port'] = '6379';
$config['redis_default']['password'] = NULL;
$config['redis_default']['timeout'] = 0;


$config['redis_slave']['host'] = 'localhost';
$config['redis_slave']['port'] = '6379';
$config['redis_slave']['password'] = '';
?>