<?php

/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/
define('_IN_FS', 1);
$headmod = 'login';
require_once('../system/core.php');
require_once('../system/head.php');
if ($isUser) {
    echo functions::display_error('Bạn đã đăng nhập, để đăng nhập tài khoản khác, vui lòng <a href="logout.php">đăng xuất</a> tài khoản hiện tại và thực hiện đăng nhập lại');
    require_once('../system/foot.php');
    exit();
}

if (isset($_POST['submit'])) {
    $error = []; //contain error messages

    $token = isset($_POST['token']) ? trim($_POST['token']) : false;
    if (!$token || strcmp($token, $_SESSION['token']) != 0) {
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
                        setcookie('cuid', base64_encode($row['id']), $timeCookieExpired); 
                        setcookie('cussid', $ssid, $timeCookieExpired);
                    }

                    $urlRedirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $homeurl;
                    echo '<div class="alert alert-success">Chúc mừng bạn đã đăng nhập thành công tài khoản!</div>';
                    header('Location: ' . $urlRedirect);
                    require_once('../system/foot.php');
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
            require_once('../system/foot.php');
            exit();
        }
    }
}
if (isset($_SESSION['token'])) {
    unset($_SESSION['token']);
}

$_SESSION['token'] = auth::genToken(35);
?>
<div class="row m-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <span class="font-weight-bold">
                    <i class="fas fa-user-plus"></i> Đăng ký tài khoản</span>
            </div>
            <div class="card-body">
                <form action="#" method="post">
                    <div class="form-row">
                        <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="email">
                                <i class="fas fa-at"></i> Email:</label>
                            <input type="email" name="email" class="form-control" required placeholder="Nhập địa chỉ email của bạn" value="<?= isset($email) ? $email : '' ?>">
                            <?= isset($error['email']) ? functions::display_error($error['email']) : '' ?>
                        </div>
                       
                        <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="passwd">
                                <i class="fas fa-key"></i> Mật khẩu:</label>
                            <input type="password" name="passwd" id="passwd" class="form-control" required value="<?= isset($passwd) ? $passwd : '' ?>">
                            <?= isset($error['passwd']) ? functions::display_error($error['passwd']) : '' ?>
                        </div>
                        <div class="form-group col-12">
                            <div class="form-check">
                                <input type="checkbox" name="rem" class="form-check-input"> <label for="rem">Ghi nhớ tôi</label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                    <?= isset($error['token']) ? functions::display_error($error['token']) : '' ?>
                    <button type="submit" name="submit" class="btn btn-success">Đăng nhập</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once('../system/foot.php');
?>