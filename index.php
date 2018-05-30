<?php

/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/
define('_IN_FS', 1);
require_once('system/core.php');

$stmt = $db->query("SELECT `id`, `name`, `price_first`, `price_last`, `image` FROM `product` ORDER BY `time` DESC LIMIT 12");
$new_list_product = [];
while(($list = $stmt->fetch())) {
    $list['price_first'] = number_format($list['price_first'], 0, '', '.');
    $list['price_last'] = number_format($list['price_last'], 0, '', '.');
    $new_list_product[] = $list;
}
if (count($new_list_product) > 0) {
    $tpl->assign('new_list_product', $new_list_product);
}

$stmt = $db->query("SELECT `id`, `name`, `price_first`, `price_last`, `image` FROM `product` ORDER BY `buy_count` DESC, `name` ASC LIMIT 12");
$top_list_product = [];
while(($list = $stmt->fetch())) {
    $list['price_first'] = number_format($list['price_first'], 0, '', '.');
    $list['price_last'] = number_format($list['price_last'], 0, '', '.');
    $top_list_product[] = $list;
}
if (count($new_list_product) > 0) {
    $tpl->assign('top_list_product', $top_list_product);
}

$tpl->display('mainpage.html');

?>