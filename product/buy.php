<?php

/*
 * Name: FS
 * Author: github.com/ptudweb-lab/project
 * Version: VERSION.txt
 */
define('_IN_FS', 1);
require_once '../system/core.php';

$carts = $cart->load();
$sum = 0;
$list = [];

if ($carts != null) {
    $pattern = [];
    foreach ($carts as $id => $num) {
        $pattern[] = abs(intval($id));
    }
    $pattern = implode(', ', $pattern);
    $stmt = $db->query("SELECT `id`, `name`, `price_last` FROM `product` WHERE `id` IN (" . $pattern . ");");
    if ($stmt->rowCount()) {
        $i = 1;
        while ($row = $stmt->fetch()) {
            $row['i'] = $i;
            $row['num'] = intval($carts[$row['id']]);
            $row['price_last'] *= $row['num'];
            $sum += $row['price_last'];
            $row['price_last'] = number_format($row['price_last'], 0, '', '.');
            $list[] = $row;
            $i++;
        }
        $tpl->assign('cart', $list);
        $tpl->assign('total_price', number_format($sum, 0, '', '.'));
    }
}

$post = [];
$token = isset($_POST['token']) ? trim($_POST['token']) : false;

if ($isUser && !isset($_POST['submit'])) {
    $post['user'] = $user['id'];
    $post['fullname'] = $user['fullname'];
    $post['email'] = $user['email'];
    $post['phone'] = $user['phone'];
    $post['addr'] = $user['address'];
} else {
    $post['user'] = 0;
    $post['fullname'] = isset($_POST['fullname']) ? trim($_POST['fullname']) : false;
    $post['email'] = isset($_POST['email']) ? trim($_POST['email']) : '';
    $post['phone'] = isset($_POST['phone']) ? trim($_POST['phone']) : false;
    $post['addr'] = isset($_POST['addr']) ? trim($_POST['addr']) : false; 
}

$post['price'] = abs(intval($sum));
$post['time'] = time();
$post['browser'] = $userAgent;
$post['ip'] = $ip;
$post['cmt'] = isset($_POST['cmt']) ? trim($_POST['cmt']) : false;
$post['ship_type'] = isset($_POST['ship_type']) ? ($_POST['ship_type'] === '1' ? 1 : 2) : false;
$post['list_product'] = base64_encode(json_encode($list));

if (isset($_POST['submit'])) {

    $error = []; //contain error messages

    if (!$post['fullname']) {
        $error['fullname'] = 'Trường họ tên không được để trống';
    } else {
        if ((strlen($post['fullname']) < 6) || (strlen($post['fullname']) > 100)) {
            $error['fullname'] = 'Độ dài của Họ Tên phải nằm trong khoảng 6 đến 100 kí tự';
        }
        if (!preg_match('#\ #', $post['fullname'])) {
            $error['fullname'] = 'Vui lòng nhập đầy đủ họ tên';
        }
    }

    if (!$token || strcmp($token, $_SESSION['token']) != 0) {
        $error['token'] = 'Phiên không hợp lệ';
    }

    if (!$post['ship_type']) {
        $error['ship_type'] = 'Vui lòng chọn phương thức giao hàng';
    } else {
        if ($post['ship_type'] == 1) {
            $post['price'] += 10000;
        }
    }

    if ($post['email'] && !empty($post['email'])) {
        if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $error['email'] = 'Địa chỉ email không hợp lệ';
        }
    }

    if ($post['cmt']) {
        if ((strlen($post['cmt']) < 10) || (strlen($post['cmt']) > 500)) {
            $error['cmt'] = 'Độ dài của Họ Tên phải nằm trong khoảng 10 đến 500 kí tự';
        }
    }
   
    if (!$post['phone']) {
        $error['phone'] = 'SĐT không được để trống';
    } else {
        if (strlen($post['phone']) < 10 || strlen($post['phone']) > 12) {
            $error['phone'] = 'Độ dài SĐT không hợp lệ';
        }
        if (!preg_match('/^\d+$/', $post['phone'])) {
            $error['phone'] = 'Vui lòng nhập đúng định dạng số';
        }
    }

    if (!$post['addr']) {
        $error['addr'] = 'Không được để trống phần địa chỉ';
    } else {
        if (strlen($post['addr']) < 15 || strlen($post['addr']) > 200) {
            $error['addr'] = 'Độ dài của địa chỉ không hợp lệ';
        }
    }
    //die(var_dump($error));
    if (count($error) < 1) {    
        try {
            $stmt = $db->prepare("INSERT INTO `bill` SET
                                    `user_id` = :user,
                                    `list_product` = :list_product,
                                    `customer_email` = :email,
                                    `customer_phone` = :phone,
                                    `customer_address` = :addr,
                                    `customer_name` = :fullname,
                                    `total_price` = :price,
                                    `comment` = :cmt,
                                    `ship_type` = :ship_type,
                                    `browser` = :browser,
                                    `ip` = :ip,
                                    `time` = :time");
            $stmt->execute($post);
        } catch (PDOException $e) {
            echo 'Exception -> ';
            var_dump($e->getMessage());
            exit();
        }
        $tpl->assign('success', $db->lastInsertId());
        $cart->unset();
    } else {
        $tpl->assign('error', $error);
    }
}
if (isset($_SESSION['token'])) {
    unset($_SESSION['token']);
}

$_SESSION['token'] = auth::genToken(35);

$tpl->assign('token', $_SESSION['token']);
$tpl->assign('post', $post);
$tpl->assign('cost', number_format($post['price'], 0, '', '.'));
$tpl->display('buy.html');
