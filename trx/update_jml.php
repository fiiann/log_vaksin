<?php
  include_once "../conf/openconn.php";

  $idproses = $_POST['idproses'];
  $idvaksin = $_POST['idvaksin'];
  $jml      = $_POST['jumlah_vaksin'];

  $upd = "UPDATE amprahan_detil SET
            jumlah='$jml' 
          where id_proses='$idproses' and id_jenis='$idvaksin'";

  $qry = mysql_query($upd) or die (mysql_error());

  ?>        
