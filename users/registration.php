<?php

/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/
define('_IN_FS', 1);
require_once('../system/core.php');
require_once('../system/head.php');
if (isset($_POST['submit'])) {
    $error = []; //contain error messages

    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : false;
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

    $token = isset($_POST['token']) ? trim($_POST['token']) : false;
    if (!$token || strcmp($token, $_SESSION['token']) != 0) {
        $error['token'] = 'Phiên đăng ký không hợp lệ';
    }

    $email = isset($_POST['email']) ? trim($_POST['email']) : false;
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
   
    $sex = isset($_POST['sex']) ? trim($_POST['sex']) : false;
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

    /* $dob = isset($_POST['dob']) ? trim($_POST['dob']) : false;
    if (!$dob) {
        $error['dob'] = 'Vui lòng chọn ngày sinh của bạn';
    } else {
        $dob = explode('-', $dob);
        $yearOfBirth = intval($dob[0]);
        $yearOld = intval(date('Y')) - $yearOfBirth;
        if ($yearOld >= 200 || $yearOld < 16) {
            $error['dob'] = 'Số tuổi không hợp lệ';
        }
        $monthOfBirth = intval($dob[1]);
        if ($monthOfBirth < 1 || $monthOfBirth > 12) {
            $error['dob'] = 'Tháng không hợp lệ';
        }
        $dayOfBirth = intval($dob[2]);
        $feb = 28;
        if (((($yearOfBirth % 4) == 0) && (($yearOfBirth % 100) != 0))
            || ((($yearOfBirth % 100) == 0) && (($yearOfBirth % 400) == 0))) {
                $feb = 29;
            }
        define('MAX_DAY_OF_MONTH', array(31, $feb, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31));
        if ($dayOfBirth < 1 || $dayOfBirth > MAX_DAY_OF_MONTH[$monthOfBirth]) {
            $error['dob'] = 'Ngày không hợp lệ';
        }

        if (!isset($error['dob'])) {
            $dob = mktime(0, 0, 0, $monthOfBirth, $dayOfBirth, $yearOfBirth);
        }
    } */

    $passwd = isset($_POST['passwd']) ? trim($_POST['passwd']) : false;
    $repasswd = isset($_POST['repasswd']) ? trim($_POST['repasswd']) : false;
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

    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : false;
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

    $address = isset($_POST['address']) ? trim($_POST['address']) : false;
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
            //functions::display_error($e->getMessage());
            require_once('../system/foot.php');
            exit();
        }
        
        echo '<div class="alert alert-success">Chúc mừng bạn đã đăng ký thành công tài khoản, vui lòng <a href="login.php">Đăng nhập</a> với tài khoản bạn vừa đăng ký</div>';
        require_once('../system/foot.php');
        exit();
    }
}
if (isset($_SESSION['token'])) {
    unset($_SESSION['token']);
}

$_SESSION['token'] = auth::genToken(35);
?>
<script src="js/script.js"></script>
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
                        <div class="form-group col-sm-12 col-md-12 col-lg-5 col-xl-5">
                            <label for="fullname">
                                <i class="fas fa-id-card"></i> Họ Tên: </label>
                            <input type="text" class="form-control" name="fullname" required placeholder="Nhập họ và tên" title="Họ tên từ 6 kí tự đến 100 kí tự"
                                value="<?= isset($fullname) ? $fullname : '' ?>">
                            <small class="form-text text-muted">Ví dụ: Lê Văn A</small>
                            <?= isset($error['fullname']) ? functions::display_error($error['fullname']) : '' ?>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 col-lg-5 col-xl-5">
                            <label for="email">
                                <i class="fas fa-at"></i> Email:</label>
                            <input type="email" name="email" class="form-control" required placeholder="Nhập địa chỉ email của bạn" value="<?= isset($email) ? $email : '' ?>">
                            <small class="form-text text-muted">Ví dụ: arituan@gmail.com</small>
                            <?= isset($error['email']) ? functions::display_error($error['email']) : '' ?>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <div>
                                <label for="sex">
                                    <i class="fas fa-venus-mars"></i> Giới tính: </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sex" value="m" <?= isset($sex) && ($sex=='m') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="sex"> Nam</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="sex" value="f" <?= isset($sex) && ($sex=='f') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="sex"> Nữ</label>
                            </div>
                            <?= isset($error['sex']) ? functions::display_error($error['sex']) : '' ?>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="passwd">
                                <i class="fas fa-key"></i> Mật khẩu:</label>
                            <input type="password" name="passwd" id="passwd" class="form-control" required value="<?= isset($passwd) ? $passwd : '' ?>">
                            <small class="form-text text-muted">Mật khẩu phải có độ dài từ 8-30 kí tự, chứa số, các chữ cái và chữ cái in hoa</small>
                            <div id="passwd_strength" class="progress"></div>
                            <?= isset($error['passwd']) ? functions::display_error($error['passwd']) : '' ?>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="repasswd">
                                <i class="fas fa-key"></i> Nhập lại mật khẩu:</label>
                            <input type="password" name="repasswd" class="form-control" required>
                            <?= isset($error['repasswd']) ? functions::display_error($error['repasswd']) : '' ?>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="phone">
                                <i class="fas fa-address-book"></i> Số điện thoại:</label>
                            <input type="text" name="phone" class="form-control" required placeholder="Nhập vào số điện thoại cá nhân của bạn" value="<?= isset($phone) ? $phone : '' ?>">
                            <small class="form-text text-muted">Ví dụ: 01234567890</small>
                            <?= isset($error['phone']) ? functions::display_error($error['phone']) : '' ?>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="address">
                                <i class="fas fa-map-marker-alt"></i> Địa chỉ:</label>
                            <input type="text" name="address" class="form-control" required placeholder="Nhập vào địa chỉ nhà hoặc cơ quan của bạn" value="<?= isset($address) ? $address : '' ?>">
                            <small class="form-text text-muted">Ví dụ: km20 Xa lộ Hà nội, Khu phố 6, phường Linh Trung, quận Thủ Đức,Tp.HCM</small>
                        </div>
                    </div>
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                    <?= isset($error['token']) ? functions::display_error($error['token']) : '' ?>
                    <button type="submit" name="submit" class="btn btn-success">Đăng ký</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once('../system/foot.php');
?>