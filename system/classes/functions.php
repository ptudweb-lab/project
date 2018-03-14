<?php
/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/

defined('_IN_FS') or die('Error: restricted access');

class functions
{
    public static function passwordHash($text) {
        $options = [
            'cost' => 10,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        return password_hash($text, PASSWORD_BCRYPT, $options);
    }

    public static function passwordVerify($text, $hash) {
        return password_verify($text, $hash);
    }


}