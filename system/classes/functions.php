<?php
/*
 * Name: FS
 * Author: github.com/ptudweb-lab/project
 * Version: VERSION.txt
 */

defined('_IN_FS') or die('Error: restricted access');

class functions
{

    public static function display_error($message)
    {
        return '<div class="alert alert-danger"><i class="fas fa-times-circle "></i> ' . $message . '</div>';
    }

    public static function display_error_tpl($message)
    {
        $out = [];
        foreach ($message as $key => $val) {
            $out[$key] = '<div class="text-danger"><i class="fas fa-times-circle "></i> ' . $val . '</div>';
        }
        return $out;
    }

    public static function checkout($str)
    {
        $str = nl2br($str);
        $str = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $str);
        $str = preg_replace('#<script(.*?)>#is', '', $str);
        return $str;
    }

    /**
     * Function display pagination in end page
     *
     * @param string $url
     * @param int $start
     * @param int $total
     * @param int $kmess
     *
     * @return string
     */
    public static function display_pagination($url, $start, $total, $kmess)
    {
        $neighbors = 2;
        $out = ['<nav aria-label="..."><ul class="pagination justify-content-end">'];
        if ($start >= $total) {
            $start = max(0, $total - (($total % $kmess) == 0 ? $kmess : ($total % $kmess)));
        } else {
            $start = max(0, (int) $start - ((int) $start % (int) $kmess));
        }

        $base_link = '<li class="page-item"><a class="page-link" href="' . strtr($url, array('%' => '%%')) . 'page=%d' . '">%s</a>';
        $out[] = $start == 0 ? '' : sprintf($base_link, $start / $kmess, 'Previous');
        if ($start > $kmess * $neighbors) {
            $out[] = sprintf($base_link, 1, '1');
        }

        if ($start > $kmess * ($neighbors + 1)) {
            $out[] = '<li class="page-item disabled"><span class="page-link">...</span>';
        }

        for ($nCont = $neighbors; $nCont >= 1; $nCont--) {
            if ($start >= $kmess * $nCont) {
                $tmpStart = $start - $kmess * $nCont;
                $out[] = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
            }
        }

        $out[] = '<li class="page-item active"><span class="page-link"><b>' . ($start / $kmess + 1) . '</b> <span class="sr-only">(current)</span></span>';
        $tmpMaxPages = (int) (($total - 1) / $kmess) * $kmess;
        for ($nCont = 1; $nCont <= $neighbors; $nCont++) {
            if ($start + $kmess * $nCont <= $tmpMaxPages) {
                $tmpStart = $start + $kmess * $nCont;
                $out[] = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
            }
        }

        if ($start + $kmess * ($neighbors + 1) < $tmpMaxPages) {
            $out[] = '<li class="page-item disabled"><span class="page-link">...</span>';
        }

        if ($start + $kmess * $neighbors < $tmpMaxPages) {
            $out[] = sprintf($base_link, $tmpMaxPages / $kmess + 1, $tmpMaxPages / $kmess + 1);
        }

        if ($start + $kmess < $total) {
            $display_page = ($start + $kmess) > $total ? $total : ($start / $kmess + 2);
            $out[] = sprintf($base_link, $display_page, 'Net');
        }

        $out[] = '</ul></nav>';
        return implode(' ', $out);
    }
}
