<?php
/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/

defined('_IN_FS') or die('Error: restricted access');

class functions
{
    

    public static function display_error($message) {
        return '<div class="alert alert-danger"><i class="fas fa-times-circle "></i> ' . $message . '</div>';
    }

    public static function display_error_tpl($message) {
        $out = [];
        foreach ($message as $key => $val) {
            $out[$key] = '<div class="alert alert-danger"><i class="fas fa-times-circle "></i> ' . $val . '</div>';
        }
        return $out;
    }
}