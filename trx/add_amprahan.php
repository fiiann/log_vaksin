<?php
  include_once "../conf/openconn.php";
  $id_proses= $_POST['id_proses'];
  $id_jenis = $_POST['id_jenis'];
  $jml      = $_POST['jumlah_vaksin'];

  $ins = "INSERT INTO amprahan_detil SET
          id_proses='$id_proses',
          id_jenis='$id_jenis',
          jumlah='$jml'";

  $qins = mysql_query($ins) or die (mysql_error());

  if (!$qins){
      echo "error..";
  }else{
      echo "update amprahan sukses";
  }
?>