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

if (!$isUser) {
    echo functions::display_error('Bạn chưa đăng nhập bất cứ tài khoản nào, vui lòng <a href="login.php">đăng nhập</a> tài khoản của bạn');
    require_once('../system/foot.php');
    exit();
}

if (isset($_POST['submit'])) {
    $error = []; //contain error messages

    $token = isset($_POST['token']) ? trim($_POST['token']) : false;
    if (!$token || strcmp($token, $_SESSION['token']) != 0) {
        $error['token'] = 'Phiên đăng nhập không hợp lệ';
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
            //die($urlRedirect .'<br>' . $_SERVER['HTTP_REFERER'] . '<br>' . $homeurl . '/' . $_SERVER['REQUEST_URI']);
            echo '<div class="alert alert-success">Chúc mừng bạn đã đăng xuất thành công tài khoản!</div>';
            header('Location: ' . $urlRedirect);
            require_once('../system/foot.php');
            exit();                   
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
                    <i class="fas fa-user-plus"></i> Đăng xuất tài khoản</span>
            </div>
            <div class="card-body">
                <form action="#" method="post">
                    <div class="form-row">
                        <div class="form-group">
                            Bạn có muốn đăng xuất không?
                        </div>
                    </div>
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                    <?= isset($error['token']) ? functions::display_error($error['token']) : '' ?>
                    <button type="submit" name="submit" class="btn btn-success">Có</button> <button type="submit" class="btn btn-success" formtarget="<?= $homeurl ?>">Không</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once('../system/foot.php');
?>