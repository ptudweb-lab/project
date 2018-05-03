<?php

/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/
define('_IN_FS', 1);
//require_once('system/core.php');
ini_set('display_errors', 1);
require_once('system/db.config.php');

$string = $dbconf['driver'] . ':';
$string .= 'host=' . $dbconf['host'] . ';';
$string .= 'dbname=' . $dbconf['dbname'] . ';';
$string .= 'charset=utf8mb4';

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    //PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $db = new PDO($string, $dbconf['username'], $dbconf['password'], $opt);
} catch (PDOException  $e) {
    die('Error: ' . $e->getMessage());
}
try {
    $db->query("UPDATE `settings` SET `value`='http://fss.gearhostpreview.com' WHERE `name`='siteurl'");
} catch (PDOException  $e) {
    die('Error: ' . $e->getMessage());
}
echo 'ok';