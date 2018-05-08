<?php
/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/

defined('_IN_FS') or die('Error: restricted access');

class auth
{
    public static function passwordHash($text)
    {
        $options = [
            'cost' => 10,
            //'salt' => random_bytes(22),
        ];
        return password_hash($text, PASSWORD_BCRYPT, $options);
    }

    public static function passwordVerify($text, $hash)
    {
        return password_verify($text, $hash);
    }

    public static function genToken($lenToken)
    {
        $alph = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@$-+=/,.*%^#!()[]';
        $lenAlph = strlen($alph);
        $token = '';
        for ($i = 0; $i < $lenToken; $i++) {
            $token .= $alph[rand(0, $lenAlph - 1)];
        }
        return $token;
    }
}
