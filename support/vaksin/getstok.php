<?php
	include "../../conf/openconn.php";
    $idjenis = $_POST['idjenis'];
    $get = "SELECT stok_tersedia from master_stok where id_jenis='".$idjenis."'";
    $qry = mysql_query($get);
    $ono = mysql_num_rows($qry);
    if ($ono!=0){
        while ($s=mysql_fetch_array($qry)){
            $data['stok'] = $s['stok_tersedia'];
        }
    }else{
        $data['stok']='null';
    }

   echo json_encode($data);

?>    