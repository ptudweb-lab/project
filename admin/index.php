<?php

/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/
define('_IN_FS', 1);
require_once('../system/core.php');
$script = 'js/load.js';
require_once('../system/head.php');
if ($isAdmin) {
?>
    <div id="admin">
        <div class="row mt-3">
            <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <div class="card">
                    <div class="card-header">
                        <span class="font-weight-bold">
                            <i class="fas fa-cogs"></i> Cài đặt</span>
                    </div>
                    <div class="card-body p-1">
                        <div class="list-group">
                            <a href="#general" onclick="load('general');"  class="list-group-item list-group-item-action">
                                <i class="fas fa-cog"></i> Thiết lập chung</a>
                            <a href="#category" onclick="load('category');" class="list-group-item list-group-item-action">
                                <i class="fas fa-th-list"></i> Danh mục sản phẩm</a>
                            <a href="#product" onclick="load('product');" class="list-group-item list-group-item-action">
                                <i class="fas fa-shopping-basket"></i> Sản phẩm</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
                <div id="result"></div>
                <div id="error"></div>
            </div>
        </div>
    </div>

<?php
} else {
    echo functions::display_error('Khu vực này chỉ dành cho quản trị viên');
}
require_once('../system/foot.php');
?>