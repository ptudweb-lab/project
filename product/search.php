<?php

/*
 * Name: FS
 * Author: github.com/ptudweb-lab/project
 * Version: VERSION.txt
 */
define('_IN_FS', 1);
require_once '../system/core.php';

$search = isset($_GET['k']) ? trim($_GET['k']) : false;

if ($search) {
    $tpl->assign('keyword', $search);
    //$total = $db->query("SELECT COUNT(*) FROM `product` 
    //                    WHERE MATCH(`name`, `short_description`, `description`) AGAINST ( " . $db-quote($search) . " IN BOOLEAN MODE);")->fetchColumn();
    $stmt = $db->prepare("SELECT `id`, `name`, `price_first`, `price_last`, `image` FROM `product` 
                WHERE MATCH(`name`) AGAINST (:search IN BOOLEAN MODE)
                ORDER BY `time` DESC, `name` ASC LIMIT :start, :kmess");
    $stmt->execute([
        'search' => $search,
        'start' => $start,
        'kmess' => $kmess
    ]);
    $total = $stmt->rowCount();
    if ($total > 0) {
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

$tpl->display('search.html');
