<?php

/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/
define('_IN_FS', 1);
$headmod = 'admin_panel';
$title = 'Quản lí';
require_once('../system/core.php');

if (!$isAdmin) {
    die('Khu vực này chỉ dành cho quản trị viên! Đi ra điiiii...');
}

    $modules = [
                'general' => 'Thiết lập chung',
                'category' => 'Danh mục sản phẩm',
                'product' => 'Quản lí sản phẩm'
                ];
    $icon_modules = ['general' => 'fa-cog',
                    'category' => 'fa-th-list',
                    'product' => 'fa-shopping-basket'
                ];
    $module = isset($_GET['mod']) ? trim($_GET['mod']) : 'general';
    if (!array_key_exists($module, $modules)) {
        die('404 not found!');
    }
    $module = str_replace('.', '', $module);
    $module = str_replace('/', '', $module);
    $module = str_replace('\\', '', $module);
    
    $left_panel_content = '';
    foreach ($modules as $key => $value) {
        $left_panel_content .= '<a href="index.php?mod=' . $key . '"  class="list-group-item list-group-item-action ' . ($module === $key ? 'active' : '') . '">' .
                                 '<i class="fas ' . $icon_modules[$key] . '"></i> ' . $value . '</a>';
    }

    include 'modules/' .$module . '.php';

    $tpl->assign('left_panel_content', $left_panel_content);
    $tpl->assign('file_module', $module . '.html');

    $tpl->display('index.html');
    
