<?php

/*
 * Name: FS
 * Author: github.com/ptudweb-lab/project
 * Version: VERSION.txt
 */
define('_IN_FS', 1);
require_once '../system/core.php';

$stmt = $db->query("SELECT * FROM `product` WHERE `id` = " . $db->quote($id) . ";");

if ($stmt->rowCount()) {
    $product = $stmt->fetch();
    $product['price_first'] = number_format($product['price_first'], 0, '', '.');
    $product['price_last'] = number_format($product['price_last'], 0, '', '.');

    $short_desc = explode("\n", $product['short_desc']);
    $tmp = '<ul>';
    foreach ($short_desc as $short) {
        $tmp .= '<li>' . $short . '</li>';
    }
    $tmp .= '</ul>';
    $product['short_desc'] = $tmp;

    $product['description'] = functions::checkout($product['description']);

    $product['discount'] = '(-';
    $product['discount'] .= number_format(100 - (intval($product['price_last']) / (floatval($product['price_first']))) * 100, 2);
    $product['discount'] .= '%)';

    //other product in same category
    $stmt = $db->query("SELECT `id`, `name`, `price_last`, `image` FROM `product` WHERE `id` != " . $db->quote($id) . " AND `cat_id` = " . $db->quote($product['cat_id']) . " ORDER BY `time` DESC LIMIT 3;");

    if ($stmt->rowCount()) {
        $list = [];
        while($tmp = $stmt->fetch()) {
            $tmp['price_last'] = number_format($tmp['price_last'], 0, '', '.');
            $list[] = $tmp;
        }
        $tpl->assign('list', $list);
    }
    $tpl->assign('product', $product);
    $tpl->display('index.html');
} else {
    header('Location: ../404.html');
}
