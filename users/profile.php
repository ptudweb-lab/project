<?php

/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/
define('_IN_FS', 1);
require_once('../system/core.php');

if (!$isUser) {
    die('Xin lỗi mục này chỉ dành cho người dùng đã đăng nhập');
}

$tpl->display('profile.html');