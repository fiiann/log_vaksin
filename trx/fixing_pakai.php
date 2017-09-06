<?php
include_once "../conf/openconn.php";
$idpakai = $_POST['idpakai'];

$fix = "UPDATE pemakaian SET is_fix=1 where id_pakai='$idpakai'";
$qfx = mysql_query($fix) or die (mysql_error());

if ($qfx) {
    echo "Laporan Pemakaian telah fix..";
}else{
    echo "error..";
}
?>