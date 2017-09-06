<?php
  include_once "../conf/openconn.php";
  include_once "../lib/functions-php.php";

  $kode_instansi = $_POST['kode_instansi'];
  $tanggal       = $_POST['tanggal'];
  $jenis_vaksin  = $_POST['jenis_vaksin'];
  $jumlah        = $_POST['jumlah'];
  $bulan         = $_POST['bulan'];
  $tahun         = $_POST['tahun'];


  $xj = explode(',',$jenis_vaksin);
  $xm = explode(',',$jumlah);

  $count = count($xj);

  $id_proses = kdauto('amprahan','trx-');  

//insert ke tabel amprahan
  $sim = "INSERT INTO amprahan SET
          id_proses = '$id_proses',
          kode_instansi = '$kode_instansi',
          tanggal = '$tanggal'";
  $qsim = mysql_query($sim) or die (mysql_error());

//insert ke tabel amprahan detil
for ($i=0;$i<$count;$i++){
    $jns = $xj[$i];
    $jml = $xm[$i];

    $in = "INSERT INTO amprahan_detil SET
           id_proses='$id_proses',
           id_jenis ='$jns',
           jumlah   ='$jml'";

    $qin = mysql_query($in) or die (mysql_error());

}

if (($qsim) && ($qin)){
    echo 'Amprahan berhasil';
}else{
    echo 'Amprahan Gagal/error..';
}

