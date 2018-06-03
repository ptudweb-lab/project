<?php

/*
 * Name: FS
 * Author: github.com/ptudweb-lab/project
 * Version: VERSION.txt
 */
defined('_IN_FS') or die('Error: restricted access');

$post = [];
$post['sitename'] = isset($_POST['name']) ? trim($_POST['name']) : $set['sitename'];
$post['siteurl'] = isset($_POST['url']) ? trim($_POST['url']) : $set['siteurl'];
$post['meta_description'] = isset($_POST['desc']) ? trim($_POST['desc']) : $set['meta_description'];
$post['meta_keywords'] = isset($_POST['keywords']) ? trim($_POST['keywords']) : $set['meta_keywords'];
$token = isset($_POST['token']) ? trim($_POST['token']) : false;

if (isset($_POST['submit'])) {
    $error = []; //contain error messages
    if (!$post['sitename']) {
        $error['name'] = 'Trường tên trang web không được để trống';
    } else {
        if ((strlen($post['sitename']) < 2) || (strlen($post['sitename']) > 200)) {
            $error['name'] = 'Độ dài của tên trang web phải nằm trong khoảng 2 đến 200 kí tự';
        }
    }

    if (!$post['siteurl']) {
        $error['url'] = 'Trường đường dẫn trang web không được để trống';
    } else {
        if ((strlen($post['siteurl']) < 7) || (strlen($post['siteurl']) > 200)) {
            $error['url'] = 'Độ dài của đường dẫn trang web phải nằm trong khoảng 7 đến 200 kí tự';
        }
    }

    if (!$post['meta_description']) {
        $error['desc'] = 'Trường mô tả trang web không được để trống';
    } else {
        if ((strlen($post['meta_description']) < 2) || (strlen($post['meta_description']) > 200)) {
            $error['desc'] = 'Độ dài của mô tả trang web phải nằm trong khoảng 2 đến 200 kí tự';
        }
    }

    if (!$post['meta_keywords']) {
        $error['keywords'] = 'Trường từ khóa trang web không được để trống';
    } else {
        if ((strlen($post['meta_keywords']) < 2) || (strlen($post['meta_keywords']) > 200)) {
            $error['name'] = 'Độ dài của từ khóa trang web phải nằm trong khoảng 2 đến 200 kí tự';
        }
    }

    if (!$token || strcmp($token, $_SESSION['token']) != 0) {
        $error['token'] = 'Phiên chứng thực không hợp lệ';
    }

    if (count($error) < 1) {
        $content = [];
        $content[] = '<?php';
        $content[] = 'defined(\'_IN_FS\') or die(\'Error: restricted access\');';
        $content[] = ' ';
        $content[] = 'return [';
        $tmp = [];
        foreach ($post as $key => $val) {
            $tmp[] = '    \'' . $key . '\' => \'' . $val . '\'';
        }
        $content[] = implode(",\n", $tmp);
        $content[] ='];';
        $content[] = '?>';
        $file = fopen('../system/site.config.php', 'w') or die("Unable to open file!");
        fwrite($file, implode("\n", $content));
        fclose($file);
        $tpl->assign('updated', true);
    } else {
        $tpl->assign('error', functions::display_error_tpl($error));
    }
}

if (isset($_SESSION['token'])) {
    unset($_SESSION['token']);
}

$_SESSION['token'] = auth::genToken(35);

$tpl->assign('post', $post);
$tpl->assign('token', $_SESSION['token']);
