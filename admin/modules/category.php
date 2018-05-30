<?php

/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/
defined('_IN_FS') or die('Error: restricted access');

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
        $error['token'] = 'Phiên chứng thực không hợp lệ';
    }

    if (count($error) < 1) {
        $pid = 0;
        try {
            $stmt = $db->prepare("INSERT INTO `product_cat` (name, parent_id) 
                                            VALUES(:name, :parent)");
            $stmt->execute(['name' => $name,
                            'parent' => $pid
                        ]);
        } catch (PDOException $e) {
            echo 'Exception -> ';
            var_dump($e->getMessage());
        }
        $tpl->assign('updated', true);
    } else {
        $tpl->assign('error', $error);
    }
}


if (isset($_SESSION['token'])) {
    unset($_SESSION['token']);
}
    
$_SESSION['token'] = auth::genToken(35);

$tpl->assign('token', $_SESSION['token']);

$stmt = $db->query("SELECT * FROM `product_cat`");

$list_item = '';
while($row = $stmt->fetch()) {
    $list_item .= '<a href="../product/cat.php?id=' . $row['id'] . '" class="list-group-item list-group-item-action">' . $row['name'] . '</a>';
}

$tpl->assign('items', $list_item);
?>

