<?php
  include_once "../conf/openconn.php";
  
  
  if($_POST['aksi']=="update"){
        $jenis_vaksin  = $_POST['jenis_vaksin'];
        $jumlah        = $_POST['jumlah'];
        $satuan        = $_POST['satuan'];
        $idpakai       = $_POST['idpakai'];

        $xj = explode(',',$jenis_vaksin);
        $xm = explode(',',$jumlah);
        $sa = explode(',',$satuan);

        $count = count($xj);
        for ($i=0;$i<$count;$i++){
            $jns = $xj[$i];
            $jml = $xm[$i];
            $sat = $sa[$i];

            $in = "INSERT INTO pemakaian_detil SET
                id_pakai ='$idpakai',
                id_jenis ='$jns',
                jumlah   ='$jml',
                satuan   ='$sat'";

            $qin = mysql_query($in) or die (mysql_error());

        }

        if ($qin){
            echo 'Pemakaian berhasil disimpan';
        }else{
            echo 'Proses Gagal/error..';
        }

  }else if($_POST['aksi']=="insert"){
        $kode_instansi = $_POST['kode_instansi'];
        $bulan         = $_POST['bulan'];
        $tahun         = $_POST['tahun'];
        $jenis_vaksin  = $_POST['jenis_vaksin'];
        $jumlah        = $_POST['jumlah'];
        $satuan        = $_POST['satuan'];
        $tanggal       = date('Y-m-d');
        $idpakai       = $_POST['idpakai'];
        $stok          = $_POST['sisa'];

        $xj = explode(',',$jenis_vaksin);
        $xm = explode(',',$jumlah);
        $sa = explode(',',$satuan);
        $ss = explode(",",$stok);

        $count = count($xj);


        //insert ke tabel pemakaian
        $sim = "INSERT INTO pemakaian SET
                id_pakai = '$idpakai',
                kode_instansi = '$kode_instansi',
                tanggal = '$tanggal',
                bulan='$bulan',
                tahun='$tahun'";

        $qsim = mysql_query($sim) or die (mysql.error());

        //insert ke tabel pemakaian detil
        for ($i=0;$i<$count;$i++){
            $jns = $xj[$i];
            $jml = $xm[$i];
            $sat = $sa[$i];
            $sis = $ss[$i];

            $in = "INSERT INTO pemakaian_detil SET
                id_pakai ='$idpakai',
                id_jenis ='$jns',
                jumlah   ='$jml',
                satuan   ='$sat'";

            $qin = mysql_query($in) or die (mysql_error());

            //update stok instansi setelah pemakaian
            $us = "UPDATE instansi_stok SET 
                   jumlah ='$sis' 
                   WHERE kode_instansi='".$kode_instansi."' and id_jenis='".$jns."'";
            $qs = mysql_query($us) or die (mysql_error());
               
        }

        if (($qsim) && ($qin)){
            echo 'Pemakaian berhasil disimpan';
        }else{
            echo 'Proses Gagal/error..';
        }

 
  }
  ?>
