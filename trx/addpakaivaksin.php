<?php 
include_once "../conf/openconn.php";

$idpakai = $_POST['idpakai'];
$idjenis = $_POST['idjenis'];
$jumlah  = $_POST['jumlah'];
$satuan  = $_POST['satuan'];
$sisa    = $_POST['sisa'];
$kode_instansi = $_POST['kode_instansi'];

  $in = "INSERT INTO pemakaian_detil SET
                id_pakai ='$idpakai',
                id_jenis ='$idjenis',
                jumlah   ='$jumlah',
                satuan   ='$satuan'";

   $qin = mysql_query($in) or die (mysql_error());


//update stok instansi
   $us = "UPDATE instansi_stok SET 
                   jumlah ='$sisa' 
                   WHERE kode_instansi='".$kode_instansi."' and id_jenis='".$idjenis."'";
            $qs = mysql_query($us) or die (mysql_error());

if (($qin) && ($qs)) {
    echo "Vaksin berhasil ditambahkan";
}else{
    echo "Error...gagal simpan";
}