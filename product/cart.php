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

$carts = $cart->load();

switch ($act) {
    case 'load':
        if ($carts != null) {
            $pattern = [];
            foreach ($carts as $id => $num) {
                $pattern[] = abs(intval($id));
            }
            $pattern = implode(', ', $pattern);
            $stmt = $db->query("SELECT `id`, `name`, `price_last` FROM `product` WHERE `id` IN (" . $pattern . ");");
            if ($stmt->rowCount()) {
                $list = [];
                $i = 1;
                $sum = 0;
                while ($row = $stmt->fetch()) {
                    $row['i'] = $i;
                    $row['num'] = intval($carts[$row['id']]);
                    $row['price_last'] *= $row['num'];
                    $sum += $row['price_last'];
                    $row['price_last'] = number_format($row['price_last'], 0, '', '.');
                    $list[] = $row;
                    $i++;
                }
                $sum = number_format($sum, 0, '', '.');
                $tpl->assign('cart', $list);
                $tpl->assign('total_price', $sum);
            }
        }
        $tpl->display('load_cart.html');
        break;
    case 'add':
        if ($id) {
            $success = false;
            $stmt = $db->query("SELECT `id` FROM `product` WHERE `id`=" . $db->quote($id) . ";");
            if ($stmt->rowCount()) {
                $cart->add($id, $num);
                $success = true;
            }
            $tpl->assign('success', $success);
            $tpl->display('add_cart.html');
        }
        break;
    default:
        if ($carts != null) {
            $pattern = [];
            foreach ($carts as $id => $num) {
                $pattern[] = abs(intval($id));
            }
            $pattern = implode(', ', $pattern);
            $stmt = $db->query("SELECT `id`, `name`, `price_last` FROM `product` WHERE `id` IN (" . $pattern . ");");
            if ($stmt->rowCount()) {
                $list = [];
                $i = 1;
                $sum = 0;
                while ($row = $stmt->fetch()) {
                    $row['i'] = $i;
                    $row['num'] = intval($carts[$row['id']]);
                    $row['price_last'] *= $row['num'];
                    $sum += $row['price_last'];
                    $row['price_last'] = number_format($row['price_last'], 0, '', '.');
                    $list[] = $row;
                    $i++;
                }
                $sum = number_format($sum, 0, '', '.');
                $tpl->assign('cart', $list);
                $tpl->assign('total_price', $sum);
            }
        }
        $tpl->display('show_cart.html');
        break;
}
