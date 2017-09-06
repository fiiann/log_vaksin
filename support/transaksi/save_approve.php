<?php
    date_default_timezone_set("Asia/Jakarta");
    include "../../conf/openconn.php";

    $idproses = $_POST['idproses'];
    $kode_ins = $_POST['kode_instansi'];
    $tanggal = date('Y-m-d');
    $xdate = explode("-",$tanggal);
    $tahun = $xdate[0];
    $bulan = $xdate[1];

    //get detil approve amprahan
    $get = "SELECT id_jenis, jumlah FROM amprah_approval_detil where id_proses='".$idproses."'";
    $qry = mysql_query($get);
    while ($data=mysql_fetch_array($qry)){
        $idjenis = $data['id_jenis'];
        $jumlah  = $data['jumlah'];


        //cek apakah sudah ada jenis vaksin yang sama
        $cek = "SELECT id_jenis from instansi_stok where kode_instansi='".$kode_ins."' and id_jenis='".$idjenis."'";
        $qcek= mysql_query($cek) or die (mysql_error());
        $ono = mysql_num_rows($qcek);
        if($ono!=0){
            //get stok akhir
            $stokakhir = "SELECT jumlah from instansi_stok where kode_instansi='".$kode_ins."' and id_jenis='".$idjenis."'
                          and bulan='".$bulan."' and tahun='".$tahun."'";
            $qstoka = mysql_query($stokakhir);
            while ($j=mysql_fetch_array($qstoka)){
                $jmlstok=$j['jumlah'];
                
            }   
             //update jumlah jika jenis vaksin sama pd bulan dan tahun serta kode instansi
             $totvk = $jmlstok+$jumlah;
             $upstok = "UPDATE instansi_stok SET 
                          jumlah='$totvk'
                        where kode_instansi='".$kode_ins."' and id_jenis='".$idjenis."'
                          and bulan='".$bulan."' and tahun='".$tahun."'";
             $qystok = mysql_query($upstok);                   
           
        }else{
               //insert ke tabel stok instansi
            $insert = "INSERT INTO instansi_stok SET
                        kode_instansi='$kode_ins',
                        id_jenis = '$idjenis',
                        bulan = '$bulan',
                        tahun = '$tahun',
                        jumlah ='$jumlah'";

            $qins = mysql_query($insert) or die (mysql_error());       
        }

            
    }

    //update tgl amprah approval
    $upd = "UPDATE amprah_approval SET tanggal='".$tanggal."', kode_instansi='".$kode_ins."' where id_proses='".$idproses."'";
    $qu = mysql_query($upd) or die (mysql_error());

    //update status amprahan dari instansi
    $up = "UPDATE amprahan SET status=1 where id_proses='".$idproses."'";
    $qp = mysql_query($up) or die (mysql_error());

    if ($qins) {
        echo "Sukses";
    }else{
        echo "Error";
    }
 ?>   