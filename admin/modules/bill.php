<?php

/*
 * Name: FS
 * Author: github.com/ptudweb-lab/project
 * Version: VERSION.txt
 */
defined('_IN_FS') or die('Error: restricted access');
$act = isset($_GET['act']) ? trim($_GET['act']) : false;
switch ($act) {
    case 'active':
        if ($id) {
            $stmt = $db->query("SELECT `id`, `status` FROM `bill` WHERE `id` = " . $db->quote($id) . ";");
            if ($stmt->rowCount()) {
                $product = $stmt->fetch();
                if ($product['status'] == 1) {
                    die('Bạn đã duyệt sản phẩm này');
                } else {
                    $token = isset($_GET['token']) ? trim($_GET['token']) : false;
                    if ($token && $token === $_SESSION['token']) {
                        $ref = isset($_SERVER['HTTP_REFERER']) ? trim($_SERVER['HTTP_REFERER']) : false;
                        if ($ref && (($ref == $homeurl . '/admin/index.php?mod=bill')
                            || ($ref == $homeurl . '/admin/index.php?mod=bill&status=0')
                            || ($ref == $homeurl . '/admin/index.php?mod=bill&status=2')
                            || ($ref == $homeurl . '/admin/index.php?mod=bill&id=' . $id))) {
                            $db->query("UPDATE `bill` SET `status` = 1 WHERE `id` = " . $db->quote($id) . ";");
                            header("Location: $ref");
                        } else {
                            die($ref);
                        }
                    } else {
                        die('Phiên không hợp lệ');
                    }
                }
            }
        }
        break;
    case 'delete':
        if ($id) {
            $stmt = $db->query("SELECT `id`, `status` FROM `bill` WHERE `id` = " . $db->quote($id) . ";");
            if ($stmt->rowCount()) {
                $product = $stmt->fetch();
                if ($product['status'] == 2) {
                    die('Bạn đã hủy sản phẩm này');
                } else {
                    $token = isset($_GET['token']) ? trim($_GET['token']) : false;
                    if ($token && $token === $_SESSION['token']) {
                        $ref = isset($_SERVER['HTTP_REFERER']) ? trim($_SERVER['HTTP_REFERER']) : false;
                        if ($ref && (($ref == $homeurl . '/admin/index.php?mod=bill')
                            || ($ref == $homeurl . '/admin/index.php?mod=bill&status=0')
                            || ($ref == $homeurl . '/admin/index.php?mod=bill&status=1')
                            || ($ref == $homeurl . '/admin/index.php?mod=bill&id=' . $id))) {
                            $db->query("UPDATE `bill` SET `status` = 2 WHERE `id` = " . $db->quote($id) . ";");
                            header("Location: $ref");
                        } else {
                            die($ref);
                        }
                    } else {
                        die('Phiên không hợp lệ');
                    }
                }
            }
        }
        break;
    case 'clean':
    default:
        $list_status = [
            [
                'code' => 0,
                'name' => 'Đơn hàng chưa duyệt',
            ],
            [
                'code' => 1,
                'name' => 'Đơn hàng đã duyệt',
            ],
            [
                'code' => 2,
                'name' => 'Đơn hàng bị hủy',
            ],
        ];

        foreach ($list_status as $i => $item) {
            $num_of_item = $db->query("SELECT COUNT(*) FROM `bill` WHERE `status` = " . $db->quote($item['code']) . ";")->fetchColumn();
            $list_status[$i]['total'] = $num_of_item;
        }
        $tpl->assign('list_status', $list_status);
        $_SESSION['token'] = base64_encode(auth::genToken(35));
        $tpl->assign('token', $_SESSION['token']);
        if ($id) {
            $tpl->assign('id', $id);
            $stmt = $db->query("SELECT * FROM `bill` WHERE `id` = " . $db->quote($id) . ";");
            if ($stmt->rowCount()) {
                $row = $stmt->fetch();
                $row['total_price'] = functions::money_format($row['total_price']);
                $cart->import($row['list_product']);
                $tpl->assign('is_bill', true);
                $tpl->assign('cart', $cart->load());
                $tpl->assign('total_price', $row['total_price']);
                $tpl->assign('bill', $row);
            }
        } else {
            $status = isset($_GET['status']) ? abs(intval($_GET['status'])) : 0;
            $tpl->assign('status', $status);

            $stmt = $db->query("SELECT `id`, `customer_name`, `customer_phone`, `customer_address`, `total_price`, `time`, `status`
                                FROM `bill` WHERE `status` = " . $db->quote($status) . "
                                ORDER BY `time` DESC;");

            if ($stmt->rowCount()) {
                $items = [];
                while ($row = $stmt->fetch()) {
                    $row['total_price'] = functions::money_format($row['total_price']);
                    $row['time'] = date('H:m:s d-m-y', $row['time']);
                    $items[] = $row;
                }
                $tpl->assign('bills', $items);
            }
        }
        break;
}
