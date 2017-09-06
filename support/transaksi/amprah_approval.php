<?php
    date_default_timezone_set("Asia/Jakarta");
    include "../../conf/openconn.php";
    $tgl = date('Y-m-d');

    
	if ($_POST['kode_batch']!='')
	{	
        $idproses       = $_POST['id_proses'];
		$kode_batch		= $_POST['kode_batch'];
		$jmlapproval	= $_POST['jml_approval'];
        $idjenis        = $_POST['id_jenis'];
        $stokvaksin     = $_POST['stok_vaksin'];


        //get stok vaksin terakhir
		/*	 $get  = "SELECT stok_tersedia FROM master_stok where id_jenis='".$idjenis."'";
			 $qry  = mysql_query($get) or die (mysql_error());
			 while ($s=mysql_fetch_array($qry)){
				 $stok_akhir = $s['stok_tersedia'];
			 }
        */     

        //cek tabel amprah_approval dengan id proses yang sama
        $cek  = "SELECT id_proses FROM amprah_approval where id_proses='".$idproses."'";
        $qcek = mysql_query($cek);
        $ada  = mysql_num_rows($qcek);
        if ($ada!=0){

        }else{
            $insert = "INSERT INTO amprah_approval SET 
                       id_proses='$idproses'";
            $query  = mysql_query($insert) or die (mysql_error());           
        }		
		
        $xkb = explode(",",$kode_batch);
        $xja = explode(",",$jmlapproval);
        $xst = explode(",",$stokvaksin);

        $count = count($xkb);

        $totpakai=0;

        for ($a=0;$a<$count;$a++){
            $kode_b = $xkb[$a];
            $jumlah = $xja[$a];
            $stokvk = $xst[$a];
            
            

            $simpan ="INSERT into amprah_approval_detil SET 
                         id_proses='$idproses',
                         kode_batch='$kode_b',
                         id_jenis = '$idjenis',
                         jumlah ='$jumlah'";

            $result=mysql_query($simpan) or die (mysql_error());

            //$totpakai = $totpakai+$jumlah;
            
             //simpan ke tabel pakai stok
            
             $sisa = $stokvk - $jumlah; 

             $pakai = "INSERT INTO pakai_stok SET 
                       id_jenis='$idjenis',
                       jumlah='$jumlah',
                       tanggal='$tgl'";

             $qpakai = mysql_query($pakai) or die (mysql_error());


             $upd = "UPDATE master_vaksin SET 
			         stok='$sisa' where kode_batch='$kode_b'";
			 $qup = mysql_query($upd);
        	
        }
            //pengurangan stok
             

            //update stok terakhir
			
             

         

	
		if (!$result)
		{
			echo "Simpan Proses Approval Gagal..!";		
		}else{
			echo "Simpan Proses Approval Berhasil...";
		}
	
	}
	 
?>