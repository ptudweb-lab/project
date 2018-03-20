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
    }

    $email = isset($_POST['email']) ? trim($_POST['email']) : false;
    if (!$email || empty($email)) {
        $error['email'] = 'Email không được bỏ trống';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error['email'] = 'Địa chỉ email không hợp lệ';
        } else {
            $stmt = $db->prepare('SELECT * FROM `users` WHERE `email`=:email');
            $stmt->execute(['email' => $email]);
            if ($stmt->fetchColumn() >= 1) {
                $error['email'] = 'Địa chỉ email này đã đăng ký tài khoản, vui lòng đăng nhập hoặc chọn email khác.';
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

    $dob = isset($_POST['dob']) ? trim($_POST['dob']) : false;
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
    }
}

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
                                <label for="fullname"><i class="fas fa-id-card"></i> Họ Tên: </label>
                                <input type="text" class="form-control" name="fullname" placeholder="Nhập họ và tên" title="Họ tên từ 6 kí tự đến 100 kí tự" value="<?= isset($fullname) ? $fullname : '' ?>">
                                <?= isset($error['fullname']) ? functions::display_error($error['fullname']) : '' ?>
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <label for="email">
                                    <i class="fas fa-at"></i> Email:</label>
                                <input type="email" name="email" class="form-control" placeholder="Nhập địa chỉ email của bạn" value="<?= isset($email) ? $email : '' ?>">
                                <?= isset($error['email']) ? functions::display_error($error['email']) : '' ?>
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div>
                                <label for="sex"><i class="fas fa-venus-mars"></i> Giới tính: </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex" value="m" <?= isset($sex) && ($sex == 'm') ?  'checked' : '' ?>>
                                    <label class="form-check-label" for="sex"> Nam</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex" value="f" <?= isset($sex) && ($sex == 'f') ?  'checked' : '' ?>>
                                    <label class="form-check-label" for="sex"> Nữ</label>
                                </div>
                                <?= isset($error['sex']) ? functions::display_error($error['sex']) : '' ?>
                            </div>

                            <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <label for="dob">
                                    <i class="fas fa-calendar-alt"></i> Ngày sinh:</label>
                                <input type="date" name="dob" class="form-control" value="<?= isset($dob) ? date('Y-m-d', $dob) : '' ?>">
                                <?= isset($error['dob']) ? functions::display_error($error['dob']) : '' ?>
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <label for="passwd">
                                    <i class="fas fa-key"></i> Mật khẩu:</label>
                                <input type="password" name="passwd" class="form-control">
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <label for="repasswd">
                                    <i class="fas fa-key"></i> Nhập lại mật khẩu:</label>
                                <input type="password" name="repasswd" class="form-control">
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <label for="phone">
                                    <i class="fas fa-address-book"></i> Số điện thoại:</label>
                                <input type="text" name="phone" class="form-control" placeholder="Nhập vào số điện thoại cá nhân của bạn">
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <label for="address">
                                    <i class="fas fa-map-marker-alt"></i> Địa chỉ:</label>
                                <input type="text" name="address" class="form-control" placeholder="Nhập vào địa chỉ nhà hoặc cơ quan của bạn">
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-success">Đăng ký</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
require_once('../system/foot.php');
?>