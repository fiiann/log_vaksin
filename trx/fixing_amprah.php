<?php
include_once "../conf/openconn.php";
$idproses = $_POST['id_proses'];

$fix = "UPDATE amprahan SET is_fix=1 where id_proses='$idproses'";
$qfx = mysql_query($fix) or die (mysql_error());

if ($qfx) {
    echo "Form Amprahan telah fix..";
}else{
    echo "error..";
}
?>