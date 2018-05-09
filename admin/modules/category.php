<?php

/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/
define('_IN_FS', 1);
require_once('../../system/core.php');
if ($isAdmin) {
    $name = isset($_POST['name']) ? trim($_POST['name']) : false;
    $token = isset($_POST['token']) ? trim($_POST['token']) : false;
    if (isset($_POST['submit'])) {
        $error = []; //contain error messages
        if (!$name) {
            $error['name'] = 'Trường tên danh mục không được để trống';
        } else {
            if ((strlen($name) < 2) || (strlen($name) > 100)) {
                $error['name'] = 'Độ dài của Họ Tên phải nằm trong khoảng 2 đến 100 kí tự';
            }
        }
    
        if (!$token || strcmp($token, $_SESSION['token']) != 0) {
            $error['token'] = 'Phiên đăng ký không hợp lệ';
        }

        if (count($error) < 1) {
            $pid = 0;
            try {
                $stmt = $db->prepare("INSERT INTO `product_cat` (name, parent_id) 
                                                VALUES(:name, :parent)");
                $stmt->execute(['name' => $name,
                                'parent' => $pid
                            ]);
            }
            catch (PDOException $e) {
                echo 'Exception -> ';
                var_dump($e->getMessage());
            }
            
            echo '<div class="alert alert-success">Đã thêm danh mục thành công</div>';    
        }
    }


    if (isset($_SESSION['token'])) {
        unset($_SESSION['token']);
    }
    
    $_SESSION['token'] = auth::genToken(35);
    ?>

<div class="card">
    <div class="card-header">
        <span class="font-weight-bold">Thiết lập danh mục sản phẩm</span>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form action="modules/category.php" method="post">
                    <div class="form-row">
                        <div class="form-group col-sm-12 col-md-12 col-lg-5 col-xl-5">
                            <input type="text" name="name" class="form-control" placeholder="Nhập tên danh mục">
                            <?= isset($error['name']) ? functions::display_error($error['name']) : '' ?>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 col-lg-5 col-xl-5">
                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                        <?= isset($error['token']) ? functions::display_error($error['token']) : '' ?>
                            <button type="submit" name="submit" class="btn btn-success">Thêm</button>
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
