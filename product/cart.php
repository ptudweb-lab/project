<?php

/*
 * Name: FS
 * Author: github.com/ptudweb-lab/project
 * Version: VERSION.txt
 */
define('_IN_FS', 1);
require_once '../system/core.php';

$num = isset($_GET['num']) ? abs(intval($_GET['num'])) : 1;
$act = isset($_GET['act']) ? trim($_GET['act']) : '';

switch ($act) {
    case 'load':
        if (null != $cart->load()) {
            echo 'Load';
        } else {
            echo 'Giỏ hàng hiện đang trống';
        }
        break;
    case 'add':
        if ($id) {
            $stmt = $db->query("SELECT `id` FROM `product` WHERE `id`=" . $db->quote($id) . ";");
            if ($stmt->rowCount()) {
                $cart->add($id, $num);
                echo 'Bạn đã thêm sản phẩm vào giỏ hàng thành công';
            } else {
                echo 'Sản phẩm không tồn tại';
            }
        }
        break;
    default:
        break;
}
