<?php

/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/
define('_IN_FS', 1);
$headmod = 'logout';
$title = 'Đăng xuất tài khoản';
require_once('../system/core.php');


if (!$isUser) {
    die('Bạn chưa đăng nhập bất cứ tài khoản nào, vui lòng <a href="login.php">đăng nhập</a> tài khoản của bạn');
}

if (isset($_POST['submit'])) {
    $error = []; //contain error messages

    $token = isset($_POST['token']) ? trim($_POST['token']) : false;
    if (!$token || strcmp($token, $_SESSION['token']) != 0) {
        $error['token'] = 'Phiên không hợp lệ';
    }

    if (count($error) < 1) {
        try {
            core::unsetUser();
            
            $db->query("UPDATE `users` SET `session_id`='' WHERE `id`=" . $user['id']);
            $urlRedirect = $homeurl;
            if (isset($_SERVER['HTTP_REFERER'])) {
                if (strcmp($_SERVER['HTTP_REFERER'], $homeurl . $_SERVER['REQUEST_URI']) != 0) {
                        $urlRedirect = $_SERVER['HTTP_REFERER'];
                }
            }
            header('Location: ' . $urlRedirect);
            exit();                   
        }
        catch (PDOException $e) {
            echo 'Exception -> ';
            var_dump($e->getMessage());
            exit();
        }
    }
    else {
        $tpl->assign('error', functions::display_error_tpl($error));
    }
}
if (isset($_SESSION['token'])) {
    unset($_SESSION['token']);
}

$_SESSION['token'] = auth::genToken(35);
$tpl->assign('token', $_SESSION['token']);

$tpl->display('logout.html');

?>
