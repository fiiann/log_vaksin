<?php
  include_once "../conf/openconn.php";

  $idjenis  = $_POST['id_jenis'];
  $jml      = $_POST['jml_pakai'];
  $idpakai  = $_POST['id_pakai'];
  $sisa     = $_POST['stok_sisa'];
  $bulan    = $_POST['bulan'];
  $tahun    = $_POST['tahun'];
  $kode_ins = $_POST['kode_instansi'];

  $upd = "UPDATE pemakaian_detil SET
            jumlah='$jml' 
          where id_pakai='$idpakai' and id_jenis='$idjenis'";

  $qry = mysql_query($upd) or die (mysql_error());


  //update sisa stok tabel instansi_stok
  $sis = "UPDATE instansi_stok SET jumlah='$sisa' 
          where kode_instansi='$kode_ins' and id_jenis='$idjenis' and bulan='$bulan' and tahun='$tahun'";

  $qsis = mysql_query($sis) or die (mysql_error());

  if (($qsis) && ($qry)) {
    echo "sukses";
  }else{
    echo "error";
  }
  ?>        