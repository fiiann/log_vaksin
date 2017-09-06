<?php
    include_once "../conf/openconn.php";
    $idj = $_POST['id_jenis'];

    $jenis = "SELECT id_jenis, nama FROM jenis_vaksin WHERE id_jenis != '".$idj."' GROUP by id_jenis";
    $query = mysql_query($jenis);
    while ($ot=mysql_fetch_array($query)){
      $idjen   = $ot['id_jenis'];
      $nama    = $ot['nama'];
      echo "<option value='$idjen'>$nama</option>";
     } 

   

  

?>