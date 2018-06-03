<?php

/*
 * Name: FS
 * Author: github.com/ptudweb-lab/project
 * Version: VERSION.txt
 */
define('_IN_FS', 1);
require_once '../system/core.php';

$stmt = $db->query("SELECT `name` FROM `product_cat` WHERE `id` = " . $db->quote($id) . ";");
if ($stmt->rowCount()) {
    $category_name = $stmt->fetchColumn();
    $tpl->assign('category_name', $category_name);
    $total = $db->query("SELECT COUNT(*) FROM `product` WHERE `cat_id` = " . $db->quote($id) . ";")->fetchColumn();
    if ($total > 0) {
        $stmt = $db->query("SELECT `id`, `name`, `price_first`, `price_last`, `image` FROM `product` WHERE `cat_id` = " . $db->quote($id) . " ORDER BY `time` DESC, `name` ASC LIMIT $start, $kmess");
        $products = [];
        while (($list = $stmt->fetch())) {
            $list['price_first'] = number_format($list['price_first'], 0, '', '.');
            $list['price_last'] = number_format($list['price_last'], 0, '', '.');
            $list['discount'] = '(-';
            $list['discount'] .= number_format(100 - (intval($list['price_last']) / (floatval($list['price_first']))) * 100, 2);
            $list['discount'] .= '%)';
            if (isset($carts[$list['id']])) {
                $list['added'] = true;
            }
            $products[] = $list;
        }
        $tpl->assign('total', $total);
        $tpl->assign('products', $products);
        if ($total > $kmess) {
            $tpl->assign('pagination', functions::display_pagination('cat.php?id=' . $id . '&amp;', $start, $total, $kmess));
        }

    }
}

$tpl->display('cat.html');
