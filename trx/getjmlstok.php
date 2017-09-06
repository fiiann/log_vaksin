<?php

 
 include_once "../conf/openconn.php";
 include_once "../lib/functions-php.php";

 $kode_instansi = $_POST['kode_instansi'];
 $idjenis  = $_POST['idjenis'];


 $getstok = "SELECT SUM(jumlah) as total from instansi_stok where kode_instansi='".$kode_instansi."' and id_jenis='".$idjenis."'";
 $qtot  = mysql_query($getstok);

 while ($tot=mysql_fetch_array($qtot)){
    $data['stok'] = $tot['total'];
 }
 echo json_encode($data);

 ?>