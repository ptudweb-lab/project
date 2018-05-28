<?php

/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/
define('_IN_FS', 1);
require_once('../../system/core.php');
if ($isAdmin) {
    
    if (!isset($_SERVER['HTTP_REFERER']) || ($_SERVER['HTTP_REFERER'] != $homeurl . '/admin/')) {
        die ('Not regconize');
    }

    
    $post = [];
    $post['sitename'] = isset($_POST['name']) ? trim($_POST['name']) : $set['sitename'];
    $post['siteurl'] = isset($_POST['url']) ? trim($_POST['url']) : $set['siteurl'];
    $post['meta_description'] = isset($_POST['desc']) ? trim($_POST['desc']) : $set['meta_description'];
    $post['meta_keywords'] = isset($_POST['keywords']) ? trim($_POST['keywords']) : $set['meta_keywords'];
    $token = isset($_POST['token']) ? trim($_POST['token']) : false;

    if (isset($_POST['submit'])) {
        $error = []; //contain error messages
        if (!$post['sitename']) {
            $error['name'] = 'Trường tên trang web không được để trống';
        } else {
            if ((strlen($post['sitename']) < 2) || (strlen($post['sitename']) > 200)) {
                $error['name'] = 'Độ dài của tên trang web phải nằm trong khoảng 2 đến 200 kí tự';
            }
        }

        if (!$post['siteurl']) {
            $error['url'] = 'Trường đường dẫn trang web không được để trống';
        } else {
            if ((strlen($post['siteurl']) < 7) || (strlen($post['siteurl']) > 200)) {
                $error['url'] = 'Độ dài của đường dẫn trang web phải nằm trong khoảng 7 đến 200 kí tự';
            }
        }
    
        if (!$post['meta_description']) {
            $error['desc'] = 'Trường mô tả trang web không được để trống';
        } else {
            if ((strlen($post['meta_description']) < 2) || (strlen($post['meta_description']) > 200)) {
                $error['desc'] = 'Độ dài của mô tả trang web phải nằm trong khoảng 2 đến 200 kí tự';
            }
        }

        if (!$post['meta_keywords']) {
            $error['keywords'] = 'Trường từ khóa trang web không được để trống';
        } else {
            if ((strlen($post['meta_keywords']) < 2) || (strlen($post['meta_keywords']) > 200)) {
                $error['name'] = 'Độ dài của từ khóa trang web phải nằm trong khoảng 2 đến 200 kí tự';
            }
        }

        if (!$token || strcmp($token, $_SESSION['token']) != 0) {
            $error['token'] = 'Phiên chứng thực không hợp lệ';
        }

        if (count($error) < 1) {
            $pid = 0;
            try {
                foreach ($post as $name => $value) {
                    $stmt = $db->query("UPDATE `settings` SET `value` = " . $db->quote($value) . " WHERE `name` = " . $db->quote($name) . ";");
                }  
            }
            catch (PDOException $e) {
                echo 'Exception -> ';
                var_dump($e->getMessage());
            }
            header('Location: ' . $_SERVER['HTTP_REFERER'] . '#general');
            echo '<div class="alert alert-success">Đã cập nhật thông tin thành công</div>';    
        }
    }


    if (isset($_SESSION['token'])) {
        unset($_SESSION['token']);
    }
    
    $_SESSION['token'] = auth::genToken(35);
    ?>

<div class="card">
    <div class="card-header">
        <span class="font-weight-bold">Thiết lập chung</span>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form action="modules/general.php" method="post">
                    <div class="form-row">
                        <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="name">Tên trang web:</label>
                            <input type="text" name="name" class="form-control" value="<?= $post['sitename'] ?>">
                            <?= isset($error['name']) ? functions::display_error($error['name']) : '' ?>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="url">URL trang chủ:</label>
                            <input type="text" name="url" class="form-control" value="<?= $post['siteurl'] ?>">
                            <?= isset($error['url']) ? functions::display_error($error['url']) : '' ?>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="desc">Mô tả trang web:</label>
                            <input type="text" name="desc" class="form-control" value="<?= $post['meta_description'] ?>">
                            <?= isset($error['desc']) ? functions::display_error($error['desc']) : '' ?>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label for="keywords">Từ khóa trang web:</label>
                            <input type="text" name="keywords" class="form-control" value="<?= $post['meta_keywords'] ?>">
                            <?= isset($error['keywords']) ? functions::display_error($error['keywords']) : '' ?>
                        </div>
                        <div class="form-group col-12">
                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                        <?= isset($error['token']) ? functions::display_error($error['token']) : '' ?>
                            <button type="submit" name="submit" class="btn btn-success">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">

        </div>
    </div>
</div>
<?php
} else {
    echo functions::display_error('Khu vực này chỉ dành cho quản trị viên');
}
?>
