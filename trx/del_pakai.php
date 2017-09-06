<?php
  include_once "../conf/openconn.php";
  if ($_POST['tipe']=='all'){
        $id_pakai = $_POST['idpakai'];
        $kodeins  = $_POST['kode_instansi'];
        $id_jenis = $_POST['id_jenis'];
        $pakai_aw = $_POST['pakai_awal'];
        $sisastok = $_POST['stoksisa'];
        $bulan    = $_POST['bulan'];
        $tahun    = $_POST['tahun'];


        $idx = explode(",",$id_jenis);
        $pkx = explode(",",$pakai_aw);
        $ssx = explode(",",$sisastok);

        $jmx = count($idx);
        for ($x=0;$x<$jmx;$x++){
            $id_jn = $idx[$x];
            $pk_aw = $pkx[$x];
            $ss_st = $ssx[$x];

            $tot_stok = $pk_aw + $ss_st;
            
            //update stok instansi ke stok sebelum pemakaian
            $updstok = "UPDATE instansi_stok SET 
                        jumlah='$tot_stok' WHERE kode_instansi='$kodeins' and id_jenis='$id_jn' and bulan='$bulan' and tahun='$tahun'";
            $qstok   = mysql_query($updstok) or die (mysql_error());
        }   
            //hapus data detil pemakaian vaksin
            $del     = "DELETE FROM pemakaian_detil WHERE id_pakai='$id_pakai'";
            $qhap    = mysql_query($del) or die (mysql_error()); 

            $rem  = "DELETE FROM pemakaian WHERE id_pakai='$id_pakai'";
            $qrem = mysql_query($rem) or die (mysql_error());


            if (($qhap) && ($qstok)){
                echo "Data Berhasil dihapus...!";
            }else{
                echo "Error..";
            }
        
  }else{
        $id_pakai = $_POST['idpakai'];
        $id_jenis = $_POST['idjenis'];
        $kodeins  = $_POST['kode_instansi'];
        $retur    = $_POST['stok_retur'];

        $del= "DELETE FROM pemakaian_detil WHERE id_pakai='".$id_pakai."' and id_jenis='".$id_jenis."'";
        $qdel = mysql_query($del) or die (mysql_error());

        //cek record terakhir
        $cek = "SELECT id_pakai from pemakaian_detil where id_pakai='".$id_pakai."'";
        $qc  = mysql_query($cek) or die (mysql_error());
        $ono = mysql_num_rows($qc);
        if ($ono!=0){

        }else{
            //del tabel pemakaian
            $delp = "DELETE FROM pemakaian where id_pakai='".$id_pakai."'";
            $qdlp = mysql_query($delp) or die (mysql_error());
        }

        //kembalikan stok instansi ke awal sebelum pemakaian
        $us = "UPDATE instansi_stok SET 
                        jumlah ='$retur' 
                        WHERE kode_instansi='".$kodeins."' and id_jenis='".$id_jenis."'";
        $qs = mysql_query($us) or die (mysql_error());

        if (!$qdel){
            echo "error..";
        }else{
            echo "data pemakaian dihapus..";
        }
  }    
?> 