<?php

/*
 * Name: FS
 * Author: github.com/ptudweb-lab/project
 * Version: VERSION.txt
 */
defined('_IN_FS') or die('Error: restricted access');

$name = isset($_POST['name']) ? trim($_POST['name']) : false;
$description = isset($_POST['description']) ? trim($_POST['description']) : false;
$short_description = isset($_POST['short_description']) ? trim($_POST['short_description']) : false;
$fprice = isset($_POST['fprice']) ? intval(abs(trim($_POST['fprice']))) : false;
$lprice = isset($_POST['lprice']) ? intval(abs(trim($_POST['lprice']))) : false;
$cat_id = isset($_POST['cat_id']) ? intval(abs(trim($_POST['cat_id']))) : false;
$token = isset($_POST['token']) ? trim($_POST['token']) : false;

if (isset($_POST['submit'])) {
    $error = []; //contain error messages
    if (!$name) {
        $error['name'] = 'Trường tên sản phẩm không được để trống';
    } else {
        if ((strlen($name) < 2) || (strlen($name) > 100)) {
            $error['name'] = 'Độ dài của tên sản phẩm phải nằm trong khoảng 2 đến 100 kí tự';
        }
    }

    if (!isset($_FILES['image'])) {
        $error['image'] = 'Trường ảnh sản phẩm không được để trống';
    }

    $stmt = $db->query("SELECT `id` FROM `product_cat` WHERE `id` = " . $db->quote($cat_id) . ";");
    if (!$stmt->rowCount()) {
        $error['cat_id'] = 'Danh mục sản phẩm không tồn tại';
    }

    if (!$description) {
        $error['description'] = 'Trường mô tả sản phẩm không được để trống';
    } else {
        if (strlen($description) < 10) {
            $error['description'] = 'Trường mô tả sản phẩm có độ dài tối thiểu 10 kí tự';
        }
    }

    if (!$fprice) {
        $error['fprice'] = 'Trường giá kinh doanh không được để trống';
    }

    if (!$lprice) {
        $error['lprice'] = 'Trường giá thị trường không được để trống';
    }

    if ($short_description) {
        if (strlen($short_description) > 500) {
            $error['short_description'] = 'Trường mô tả ngắn gọn sản phẩm có độ dài tối đa 500 kí tự';
        }
    }

    if (!$token || strcmp($token, $_SESSION['token']) != 0) {
        $error['token'] = 'Phiên chứng thực không hợp lệ';
    }

    if (count($error) < 1) {

        $target_dir = '../uploads/';
        if (!file_exists($target_dir)) {
            @mkdir($target_dir, 0777);
        }

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $target_file = $target_dir;
        $target_file_name = '';
        do {
            $target_file_name = md5(time()) . '.' . $ext;
        } while (file_exists($target_file . $target_file_name));

        $target_file .= $target_file_name;
        $validUpload = true;

        if (getimagesize($_FILES['image']['tmp_name']) == false) {
            $validUpload = false;
            $error['upload'] = 'Vui lòng up file ảnh';
        }

        if ($_FILES['image']['size'] > (5 * 1024 * 1024)) {
            $validUpload = false;
            $error['upload'] = 'Kích thước file ảnh quá 5MB';
        }

        $type = $_FILES['image']['type'];
        $extensions_allow = ['image/jpg', 'image/jpe', 'image/jpeg', 'image/jfif', 'image/png', 'image/bmp', 'image/dib', 'image/gif'];
        if (!in_array($type, $extensions_allow)) {
            $validUpload = false;
            $error['upload'] = 'Vui lòng up file ảnh';
        }

        if ($validUpload == true) {
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $error['upload'] = 'Không thể upload file lên hệ thống, vui lòng kiểm tra lại!';
            } else {
                $pid = 0;
                try {
                    $stmt = $db->prepare("INSERT INTO `product` SET
                                `name` = :name,
                                `cat_id` = :catid,
                                `description`= :description,
                                `short_desc` = :short_description,
                                `price_first` = :fprice,
                                `price_last` = :lprice,
                                `image` = :image,
                                `time` = :time
                                ");
                    $stmt->execute(['name' => $name,
                        'catid' => $cat_id,
                        'description' => $description,
                        'short_description' => $short_description,
                        'fprice' => $fprice,
                        'lprice' => $lprice,
                        'image' => $target_file_name,
                        'time' => time()
                    ]);
                    $tpl->assign('updated', true);
                } catch (PDOException $e) {
                    echo 'Exception -> ';
                    var_dump($e->getMessage());
                }
                
            }
        }
    } else {
        $tpl->assign('error', functions::display_error_tpl($error));
    }
}

if (isset($_SESSION['token'])) {
    unset($_SESSION['token']);
}

$_SESSION['token'] = auth::genToken(35);

$tpl->assign('token', $_SESSION['token']);

$stmt = $db->query("SELECT * FROM `product_cat`");

$list_item = '';
while ($row = $stmt->fetch()) {
    $list_item .= '<option value="' . $row['id'] . '" ' . ($cat_id == $row['id'] ? 'selected' : '') . '>' . $row['name'] . '</option>';
}

$tpl->assign('cats', $list_item);
$tpl->assign('name', ($name ? $name : ''));
$tpl->assign('lprice', ($lprice ? $lprice : ''));
$tpl->assign('fprice', ($fprice ? $fprice : ''));
$tpl->assign('description', ($description ? $description : ''));
$tpl->assign('short_description', ($short_description ? $short_description : ''));
//$tpl->assign('image', $_FILES['image']['tmp_name']);
