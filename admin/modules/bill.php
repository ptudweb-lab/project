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

        break;
    case 'delete':

        break;
    default:
        $status = isset($_GET['status']) ? abs(intval($_GET['status'])) : 0;
        if ($id) {
            $tpl->assign('id', $id);
            $stmt = $db->query("SELECT * FROM `bill` WHERE `id` = " . $db->quote($id) . ";");
            if ($stmt->rowCount()) {
                $row = $stmt->fetch();
                $row['total_price'] = functions::money_format($row['total_price']); 
                $cart->import($row['list_product']);
                $tpl->assign('cart', $cart->load());
                $tpl->assign('total_price', $row['total_price']);
                $tpl->assign('bill', $row);
            }
        } else {
            $stmt = $db->query("SELECT `id`, `customer_name`, `customer_phone`, `customer_address`, `total_price`
                                FROM `bill` WHERE `status` = " . $db->quote($status) . ";");
            if ($stmt->rowCount()) {
                $items = [];
                $i = 0;
                while ($row = $stmt->fetch()) {
                    $row['i'] = $i;
                    $row['total_price'] = functions::money_format($row['total_price']);
                    $items[] = $row;
                }
                $tpl->assign('bills', $items);
            }
        }
        break;
}
