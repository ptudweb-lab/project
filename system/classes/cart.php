<?php
/*
 * Name: FS
 * Author: github.com/ptudweb-lab/project
 * Version: VERSION.txt
 */

defined('_IN_FS') or die('Error: restricted access');

class cart
{
    private $data;
    private $timeExpired = 3600 * 24 * 3;

    public function __construct()
    {
        if (isset($_COOKIE['cart'])) {
            $this->data = json_decode(base64_decode($_COOKIE['cart']), true);
        } else {
            $this->data = null;
        }
        
    }

    public function add($id, $num = 1)
    {
        if (isset($this->data)) {
            if (isset($this->data[$id])) {
                $this->data[$id]++;
            } else {
                $this->data[$id] = $num;
            }
        } else {
            $this->data = [$id => $num];
        }

        $this->save();
    }

    public function delete($id)
    {
        if (!isset($this->data)) {
            return false;
        }

        $tmp = $this->data;
        $this->data = [];
        $status = false;
        foreach ($tmp as $_id => $_num) {
            if ($_id != $id) {
                $this->data[$_id] = $_num;
            } else {
                $status = true;
            }
        }
        if ($status == true) {
            $this->save();
        }
        return $status;
    }

    public function changeNum($id, $increase = true)
    {
        if (!isset($this->data)) {
            return false;
        }

        $status = false;
        for ($i = 0; $i < count($this->data); $i++) {
            if ($this->data[$i]['id'] == $id) {
                $status = true;
                if ($increase == true) {
                    $this->data[$i]['num']++;
                } else {
                    $this->data[$i]['num']--;
                }
            }
        }

        if ($status == true) {
            $this->save();
        }
        return $status;
    }

    public function length() {
        if (isset($this->data)) {
            return count($this->data);
        } else {
            return 0;
        }
    }
    public function load()
    {
        return $this->data;
    }

    private function save()
    {
        setcookie('cart', base64_encode(json_encode($this->data)), time() + 3 * 24 * 3600, '/', null, null, true);
    }
}
