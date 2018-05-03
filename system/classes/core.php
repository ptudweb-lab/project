<?php
/*
* Name: FS
* Author: github.com/ptudweb-lab/project
* Version: VERSION.txt
*/

defined('_IN_FS') or die('Error: restricted access');

class core
{
    public static $ip;
    public static $ipViaProxy;
    public static $userAgent;
    public static $isUser = false;
    public static $user = [];
    public static $isAdmin = false;

    public function __construct()
    {
        $ip = ip2long($_SERVER['REMOTE_ADDR']) or die('Invalid IP');
        self::$ip = sprintf("%u", $ip); //ip of client

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $vars)) {
            foreach ($vars[0] as $var) {
                $ip_via_proxy = ip2long($var);
                if ($ip_via_proxy && $ip_via_proxy != $ip && !preg_match('#^(10|172\.16|192\.168)\.#', $var)) {
                    self::$ipViaProxy = sprintf("%u", $ip_via_proxy);
                }
            }
        }

        if (isset($_SERVER["HTTP_X_OPERAMINI_PHONE_UA"]) && strlen(trim($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])) > 5) {
            self::$userAgent = 'Opera Mini: ' . htmlspecialchars(substr(trim($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']), 0, 150));
        } elseif (isset($_SERVER['HTTP_USER_AGENT'])) {
            self::$userAgent = htmlspecialchars(substr(trim($_SERVER['HTTP_USER_AGENT']), 0, 150));
        } else {
            self::$userAgent = 'Not Recognised';
        }
        $this->sessionStart();
        $this->authorize();
    }

    private function authorize()
    {
        global $db;
        $user_id = false;
        $user_ssid = false;
        
        if (isset($_SESSION['uid']) && isset($_SESSION['ussid'])) {
            $user_id = abs(intval($_SESSION['uid']));
            $user_ssid = $_SESSION['ussid'];
        } elseif (isset($_COOKIE['cuid']) && isset($_COOKIE['cussid'])) {
            $user_id = abs(intval(base64_decode(trim($_COOKIE['cuid']))));
            $_SESSION['uid'] = $user_id;
            $user_ssid = trim($_COOKIE['cussid']);
            $_SESSION['ussid'] = $user_ssid;
        }
        if ($user_id && $user_ssid) {
            try {
                $stmt = $db->prepare('SELECT * FROM `users` WHERE `failed_login` <= 3 AND `id` = :id');
                $stmt->execute(['id' => $user_id]);
                $user = $stmt->fetch();
                
                if ($user) {
                    if (auth::passwordVerify($user_ssid, $user['session_id'])) {
                        self::$user = $user;
                        self::$isUser = true;
                        
                        if ($user['level'] == 1) {
                            self::$isAdmin = true;
                        }
                    } else {
                        $this->unsetUser();
                    }
                } else {
                    $this->unsetUser();
                }
            } catch (PDOException $e) {
                echo 'Exception -> ';
                var_dump($e->getMessage());
                exit();
            }
            
        }
    }

    private function unsetUser()
    {
        unset($_SESSION['uid']);
        unset($_SESSION['ussid']);
        setcookie('cuid', '');
        setcookie('cussid', '');
    }

    private function sessionStart() {
        session_start();
    }
}
