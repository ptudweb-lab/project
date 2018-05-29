<?php

/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/
define('_IN_FS', 1);
require_once('../system/core.php');
//$script = 'js/load.js';
require_once('../system/head.php');
if ($isAdmin) {

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
    
    echo '<div id="admin"><div class="row mt-3">';
    echo '<div class="col-sm-12 col-md-12 col-lg-3 col-xl-3"><div class="card">';
    echo '<div class="card-header"><span class="font-weight-bold"><i class="fas fa-cogs"></i> Cài đặt</span></div>';
    echo '<div class="card-body p-1"><div class="list-group">';
    foreach ($modules as $key => $value) {
        echo '<a href="index.php?mod=' . $key . '"  class="list-group-item list-group-item-action ' . ($module === $key ? 'active' : '') . '">';
        echo '<i class="fas ' . $icon_modules[$key] . '"></i> ' . $value . '</a>';
    }

    echo '</div></div>';
    echo '</div></div>';

    echo '<div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">';
    include 'modules/' . $module . '.php';
    echo '</div>';
    echo '</div></div>';
} else {
    echo functions::display_error('Khu vực này chỉ dành cho quản trị viên');
}
require_once('../system/foot.php');
?>