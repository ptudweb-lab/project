<?php

/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/
define('_IN_FS', 1);
require_once('../system/core.php');

if ($isUser) {
    die('Bạn đã đăng nhập, để đăng ký tài khoản khác, vui lòng <a href="logout.php">đăng xuất</a> tài khoản hiện tại và thực hiện đăng nhập lại');
}

$fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : false;
$email = isset($_POST['email']) ? trim($_POST['email']) : false;
$token = isset($_POST['token']) ? trim($_POST['token']) : false;
$sex = isset($_POST['sex']) ? trim($_POST['sex']) : false;
$passwd = isset($_POST['passwd']) ? trim($_POST['passwd']) : false;
$repasswd = isset($_POST['repasswd']) ? trim($_POST['repasswd']) : false;
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : false;
$address = isset($_POST['address']) ? trim($_POST['address']) : false;

if (isset($_POST['submit'])) {
    $error = []; //contain error messages

    if (!$fullname) {
        $error['fullname'] = 'Trường họ tên không được để trống';
    } else {
        if ((strlen($fullname) < 6) || (strlen($fullname) > 100)) {
            $error['fullname'] = 'Độ dài của Họ Tên phải nằm trong khoảng 6 đến 100 kí tự';
        }
        if (!preg_match('#\ #', $fullname)) {
            $error['fullname'] = 'Vui lòng nhập đầy đủ họ tên';
        }
    }

    if (!$token || strcmp($token, $_SESSION['token']) != 0) {
        $error['token'] = 'Phiên đăng ký không hợp lệ';
    }
    
    if (!$email || empty($email)) {
        $error['email'] = 'Email không được bỏ trống';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error['email'] = 'Địa chỉ email không hợp lệ';
        } else {
            if (!isset($error['token'])) {
                $stmt = $db->prepare('SELECT * FROM `users` WHERE `email`=:email');
                $stmt->execute(['email' => $email]);
                if ($stmt->fetchColumn() >= 1) {
                    $error['email'] = 'Địa chỉ email này đã đăng ký tài khoản, vui lòng đăng nhập hoặc chọn email khác.';
                }
            }
        }
    }
   
    
    if (!$sex) {
        $error['sex'] = 'Vui lòng chọn giới tính Nam hoặc Nữ';
    } else {
        if (strcmp($sex, 'm') == 0) {
            $sex = 'm';
        } else if (strcmp($sex, 'f') == 0) {
            $sex = 'f';
        } else {
            $error['sex'] = 'Tùy chọn không hợp lệ';
        }
    }

    if (!$passwd) {
        $error['passwd'] = 'Không được để trống mật khẩu';
        if ($repasswd) {
            $error['repasswd'] = 'Vui lòng điền vào mật khẩu';
        }
    } else {
        if (!preg_match("#.*^(?=.{8,30})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $passwd)) {
            $error['passwd'] = 'Độ dài mật khẩu từ 8-30 kí tự, chứa các chữ cái, các số 0-9 và một chữ cái in hoa';
        }
        if ($repasswd) {
            if (strcmp($passwd, $repasswd) !== 0) {
                $error['repasswd'] = 'Mật khẩu nhập lại không khớp nhau';
            }
        } else {
            $error['repasswd'] = 'Vui lòng nhập lại mật khẩu';
        }
    }

    if (!$phone) {
        $error['phone'] = 'SĐT không được để trống';
    } else {
        if (strlen($phone) < 10 || strlen($phone) > 12) {
            $error['phone'] = 'Độ dài SĐT không hợp lệ';
        }
        if (!preg_match('/^\d+$/', $phone)) {
            $error['phone'] = 'Vui lòng nhập đúng định dạng số';
        }
    }

    if (!$address) {
        $error['address'] = 'Không được để trống phần địa chỉ';
    } else {
        if (strlen($address) < 15 || strlen($address) > 200) {
            $error['address'] = 'Độ dài của địa chỉ không hợp lệ';
        }
    }

    
    if (count($error) < 1) {
        $passwd = auth::passwordHash($passwd);
        try {
            $stmt = $db->prepare("INSERT INTO `users` (email, fullname, phone, sex, address, password, created_time, browser, ip, ip_via_proxy) 
                                            VALUES(:email, :fullname, :phone, :sex, :addr, :passwd, :crea_t, :browser, :ip, :ip_proxy)");
            $stmt->execute(['email' => $email, 
                            'fullname' => $fullname,
                            'phone' => $phone,
                            'sex' => $sex,
                            'addr' => $address,
                            'passwd' => $passwd,
                            'crea_t' => time(),
                            'browser' => $userAgent,
                            'ip' => $ip,
                            'ip_proxy' => $ipViaProxy
                        ]);
        }
        catch (PDOException $e) {
            echo 'Exception -> ';
            var_dump($e->getMessage());
            exit();
        }
        $tpl->assign('registered', true);
    } else {
        $tpl->assign('error', $error);
    }
}
if (isset($_SESSION['token'])) {
    unset($_SESSION['token']);
}

$_SESSION['token'] = auth::genToken(35);

$tpl->assign('token', $_SESSION['token']);
$tpl->assign('email', ($email ? $email : ''));
$tpl->assign('fullname', ($fullname ? $fullname : ''));
$tpl->assign('phone', ($phone ? $phone : ''));
$tpl->assign('address', ($address ? $address : ''));
$tpl->assign('sex', ($sex ? $sex : ''));
$tpl->assign('passwd', ($passwd ? $passwd : ''));
$tpl->assign('repasswd', ($repasswd ? $repasswd : ''));

$tpl->display('registration.html');
?>