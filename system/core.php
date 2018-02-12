<?php

/*
* Name: FES (Fast Ecommerce Safety)
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/
defined('_IN_FES') or die('Error: restricted access');

ini_set('session.use_trans_sid', '0');
ini_set('arg_separator.output', '&amp;');
ini_set('display_errors', 'Off');
date_default_timezone_set('Asia/Ho_Chi_Minh'); //default time zone
mb_internal_encoding('UTF-8'); //default encoding

define('ROOTPATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

//auto load
spl_autoload_register('autoload');
function autoload($name)
{
    $file = ROOTPATH . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $name . '.php';
    if (file_exists($file))
        require_once($file);
}

$core = new Core();

//get IP of client
$ip = $core->$ip;
//get IP via proxy of client
$ipViaProxy = $core->$ipViaProxy;
//get User Agent
$userAgent = $core->$userAgent;


$id = isset($_REQUEST['id']) ? abs(intval($_REQUEST['id'])) : false;
$page = isset($_REQUEST['page']) && $_REQUEST['page'] > 0 ? intval($_REQUEST['page']) : 1;

@ini_set('zlib.output_compression_level', 3);
ob_start('ob_gzhandler');
