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
    echo $_POST['dob'];
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
                                <label for="fullname">
                                    <i class="fas fa-id-card"></i> Họ Tên: </label>
                                <input type="text" class="form-control" name="fullname" placeholder="Nhập họ và tên" title="Họ tên từ 6 kí tự đến 100 kí tự">
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <label for="email">
                                    <i class="fas fa-at"></i> Email:</label>
                                <input type="email" name="email" class="form-control" placeholder="Nhập địa chỉ email của bạn">
                            </div>
                            <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div>
                                <label for="sex"><i class="fas fa-venus-mars"></i> Giới tính: </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex" value="m">
                                    <label class="form-check-label" for="sex"> Nam</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex" value="f">
                                    <label class="form-check-label" for="sex"> Nữ</label>
                                </div>
                            </div>

                            <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <label for="dob">
                                    <i class="fas fa-calendar-alt"></i> Ngày sinh:</label>
                                <input type="date" name="dob" class="form-control">
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