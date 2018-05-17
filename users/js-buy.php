<?php
session_start();
include'sql.php';
if(isset($_GET['b'])&&preg_match('/\d/',$_GET['b'])){
    mysql_query('insert into mua value("","'.$_SESSION['c_id'].'","'.$_GET['b'].'")');
}
$r_count=mysql_fetch_assoc(mysql_query('select count(*) as dem from mua where c_id="'.$_SESSION['c_id'].'"'));
echo $r_count['dem']; 
?>