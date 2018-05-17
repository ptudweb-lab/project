<?php
session_start();
include'sql.php';
$r_tongtien=mysql_fetch_assoc(mysql_query('select sum(p.p_gia) as tongtien from mua m join product p on m.p_id=p.p_id where m.c_id="'.$_SESSION['c_id'].'"'));
echo number_format($r_tongtien['tongtien'],0,'.','.');
?>