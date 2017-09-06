<?php
include_once "../../conf/openconn.php";

$idpakai = $_POST['idpakai'];
$kodeins = $_POST['kode_instansi'];

$app = "UPDATE pemakaian SET is_approve=1 where id_pakai='$idpakai'";
$qap = mysql_query($app) or die (mysql_error());

if ($qap){
    echo "Approval Sukses..";
}else{
    echo "Error..";
}