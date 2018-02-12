<?php
/*
* Name: FES (Fast Ecommerce Safety)
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/

defined('_IN_FES') or die('Error: restricted access');

class Core {
    public $ip;
    public $ipViaProxy;
    public $userAgent;


    function __construct() {
        $ip = ip2long($_SERVER['REMOTE_ADDR']) or die('Invalid IP');
        $this->ip = sprintf("%u", $ip); //ip of client

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $vars)) {
            foreach ($vars[0] AS $var) {
                $ip_via_proxy = ip2long($var);
                if ($ip_via_proxy && $ip_via_proxy != $ip && !preg_match('#^(10|172\.16|192\.168)\.#', $var)) {
                    $this->ipViaProxy = sprintf("%u", $ip_via_proxy);
                }
            }
        }

        if (isset($_SERVER["HTTP_X_OPERAMINI_PHONE_UA"]) && strlen(trim($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])) > 5) {
            $this->userAgent = 'Opera Mini: ' . htmlspecialchars(substr(trim($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']), 0, 150));
        } elseif (isset($_SERVER['HTTP_USER_AGENT'])) {
            $this->userAgent = htmlspecialchars(substr(trim($_SERVER['HTTP_USER_AGENT']), 0, 150));
        } else {
            $this->userAgent = 'Not Recognised';
        }

        
    }

    
}