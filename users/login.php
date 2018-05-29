<?php

/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/
define('_IN_FS', 1);
$headmod = 'login';
$title = 'Đăng nhập';
require_once('../system/core.php');

if ($isUser) {
    die('Bạn đã đăng nhập, để đăng nhập tài khoản khác, vui lòng <a href="logout.php">đăng xuất</a> tài khoản hiện tại và thực hiện đăng nhập lại');
}

if (isset($_POST['submit'])) {
    $error = []; //contain error messages

    $token = isset($_POST['token']) ? trim($_POST['token']) : false;
    if (!$token || !isset($_SESSION['token_login']) || strcmp($token, $_SESSION['token_login']) != 0) {
        $error['token'] = 'Phiên đăng nhập không hợp lệ';
    }

    $email = isset($_POST['email']) ? trim($_POST['email']) : false;
    if (!$email || empty($email)) {
        $error['email'] = 'Email không được bỏ trống';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error['email'] = 'Địa chỉ email không hợp lệ';
        }
    }
   
    
    $passwd = isset($_POST['passwd']) ? trim($_POST['passwd']) : false;
   if (!$passwd) {
        $error['passwd'] = 'Không được để trống mật khẩu';
    }
    
    if (count($error) < 1) {
        try {
            $stmt = $db->prepare("SELECT `id`, `password` FROM `users` WHERE `email`=:email");
            $stmt->execute(['email' => $email]);
            $row = $stmt->fetch();
            if ($row) {
                if (auth::passwordVerify($passwd, $row['password'])) {
                    $ssid = auth::genToken(512);
                    $_SESSION['uid'] = $row['id'];
                    $_SESSION['ussid'] = $ssid;
                    //die(var_dump($_SESSION));
                    $db->query("UPDATE `users` SET `session_id`='" . auth::passwordHash($ssid) . "', `last_login`='" . time() . "' WHERE `id`=" . $row['id']);
                    
                    if (isset($_POST['rem'])) {
                        $timeCookieExpired = time() + 3600*24*30*6; //saved cookie expired after 6 months
                        setcookie('cuid', base64_encode($row['id']), $timeCookieExpired, '/', null, null, true); 
                        setcookie('cussid', $ssid, $timeCookieExpired, '/', null, null, true);
                        //die(var_dump($_COOKIE));
                    }

                    $urlRedirect = $homeurl;
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        if (strcmp($_SERVER['HTTP_REFERER'], $homeurl . $_SERVER['REQUEST_URI']) != 0) {
                            $urlRedirect = $_SERVER['HTTP_REFERER'];
                        }
                    }
                    header('Location: ' . $urlRedirect);
                    exit();
                } else {
                    $error['passwd'] = 'Mật khẩu nhập vào không đúng';
                }
            } else {
                $error['email'] = 'Tài khoản không tồn tại';
            }
        }
        catch (PDOException $e) {
            echo 'Exception -> ';
            var_dump($e->getMessage());
            exit();
        }
    }

    $tpl->assign('error', functions::display_error_tpl($error));
}
if (isset($_SESSION['token_login'])) {
    unset($_SESSION['token_login']);
}

$_SESSION['token_login'] = auth::genToken(35);

$tpl->assign('token_login', $_SESSION['token_login']);
$tpl->assign('email', (isset($email) ? $email : ''));
$tpl->assign('passwd', (isset($passwd) ? $passwd : ''));

$tpl->display('login.html');
?>