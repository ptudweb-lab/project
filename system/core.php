<?php

/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/
defined('_IN_FS') or die('Error: restricted access');

ini_set('session.use_trans_sid', '0');
ini_set('arg_separator.output', '&amp;');
ini_set('display_errors', 'On');
date_default_timezone_set('Asia/Ho_Chi_Minh'); //default time zone
mb_internal_encoding('UTF-8'); //default encoding

define('ROOTPATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

//Connect to database
require_once('db.config.php');

$string = $dbconf['driver'] . ':';
$string .= 'host=' . $dbconf['host'] . ';';
$string .= 'dbname=' . $dbconf['dbname'] . ';';
$string .= 'charset=utf8mb4';

try {
    $db = new PDO($string, $dbconf['username'], $dbconf['password']);
} catch (PDOException  $e) {
    die('Error: ' . $e->getMessage());
}

//auto load
spl_autoload_register('autoload');
function autoload($name)
{
    $file = ROOTPATH . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $name . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
}

new core();

//get IP of client
$ip = core::$ip;
//get IP via proxy of client
$ipViaProxy = core::$ipViaProxy;
//get User Agent
$userAgent = core::$userAgent;


$id = isset($_REQUEST['id']) ? abs(intval($_REQUEST['id'])) : false;
$page = isset($_REQUEST['page']) && $_REQUEST['page'] > 0 ? intval($_REQUEST['page']) : 1;

//set to setting variable
$set = [];
$stmt = $db->query('SELECT * FROM `settings`');
while (($row = $stmt->fetch()) !== false) {
    $set[$row['name']] = $row['value'];
}

//User
$isUser = core::$isUser;
$user = core::$user;
$isAdmin = core::$isAdmin;

@ini_set('zlib.output_compression_level', 3);
//ob_start('ob_gzhandler');
ob_start();
