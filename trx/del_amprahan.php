<?php
  include_once "../conf/openconn.php";
  $id_proses= $_POST['id_proses'];
  $id_jenis = $_POST['id_jenis'];

  $del= "DELETE FROM amprahan_detil WHERE id_proses='".$id_proses."' and id_jenis='".$id_jenis."'";
  $qdel = mysql_query($del) or die (mysql_error());

  if (!$qdel){
      echo "error..";
  }else{
      echo "amprahan sukses dihapus..";
  }
?>