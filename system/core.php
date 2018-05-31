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
ini_set('session.cookie_httponly', 1);
date_default_timezone_set('Asia/Ho_Chi_Minh'); //default time zone
mb_internal_encoding('UTF-8'); //default encoding

define('ROOTPATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

//Connect to database
require_once('db.config.php');

$dbInfo = $dbconf['driver'] . ':';
$dbInfo .= 'host=' . $dbconf['host'] . ';';
$dbInfo .= 'dbname=' . $dbconf['dbname'] . ';';
$dbInfo .= 'charset=utf8mb4';

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false
];

try {
    $db = new PDO($dbInfo, $dbconf['username'], $dbconf['password'], $opt);
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

require_once(ROOTPATH . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'Smarty.class.php');
$tpl = new Smarty;

//Template
$tpl->debugging = false;
$tpl->caching = false;
$tpl->cache_lifetime = 120;
$tpl->setTemplateDir('tpl');
$tpl->setCompileDir('tpl_c');

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

$homeurl = $set['siteurl'] ? $set['siteurl'] : 'http://' . $_SERVER['hostname'];

//User
$isUser = core::$isUser;
$user = core::$user;
$isAdmin = core::$isAdmin;

$tpl->assign('homeurl', $homeurl);
$tpl->assign('user', $user);
$tpl->assign('is_user', $isUser);
$tpl->assign('is_admin', $isAdmin);
$tpl->assign('title', (isset($title) ? $title : $set['sitename']));
$tpl->assign('meta_description', (isset($meta_description) ? $meta_description : $set['meta_description']));
$tpl->assign('meta_keywords', (isset($meta_keywords) ? $meta_keywords : $set['meta_keywords']));


if ((!isset($headmod) || $headmod != 'login') && !$isUser) {
    $_SESSION['token_login'] = auth::genToken(35);
    $tpl->assign('token_login', $_SESSION['token_login']);
}


//$script = isset($script) ? '<script language="javascript" src="' . $script . '"></script>' : '';
//load category for header
$show_cat = '';
$stmt = $db->query("SELECT * FROM `product_cat`;");
if ($stmt->rowCount()) {
    while ($row = $stmt->fetch()) {
        $show_cat .= '<a class="dropdown-item btn-primary" href="' . $row['id'] . '">' . $row['name'] . '</a>';
    }
} else {
    $show_cat = 'Danh mục rỗng';
}

$tpl->assign('show_cat', $show_cat);

$cart = new cart();
$tpl->assign('cart_length', $cart->length());
@ini_set('zlib.output_compression_level', 3);
//ob_start('ob_gzhandler');
ob_start();
