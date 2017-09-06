<?php

	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php"; 

	
		$jenis = $_POST['jenis'];
		
		
		//cek tabel untuk dikosongkan
			$cek 	= "select * from table_view";
			$qrycek	= mysql_query($cek);
			$ada	= mysql_num_rows($qrycek);
			if ($ada!=0)
			{
				//hapus semua data
				$del	= "delete from table_view";
				$qrydel	= mysql_query($del);			
			}
	
		//get data master obat
		$getdataobat = "Select * from master_vaksin where id_jenis='".$jenis."' ORDER BY kode_vaksin";
		$qrydataobat = mysql_query($getdataobat);
		while ($print=mysql_fetch_array($qrydataobat))
		{ 
			$kodevaksin =$print['kode_vaksin'];
			$namavaksin =$print['nama_vaksin'];
			$jenis	    =$print['id_jenis'];
			$stok	    =$print['jml_stok'];
			$satuan	    =$print['satuan'];
			$expired    =$print['expired_date'];
			$exp	    =tgl_eng_to_ind($print['expired_date']);
			
			//ambil selisih tanggal sekarang dengan tanggal expired pada database
			//--tgl exp dari database--//
			$tgl_exp  = $print['expired_date'];
			$pecah_exp = explode("-",$tgl_exp);
			$tgl_exp   = $pecah_exp[2];
			$bln_exp   = $pecah_exp[1];
			$thn_exp   = $pecah_exp[0];
			
			//--tgl skr--//
			$datenow   = date("Y-m-d");
			$pecah_skr = explode("-",$datenow);
			$tgl_skr   = $pecah_skr[2];
			$bln_skr   = $pecah_skr[1];
			$thn_skr   = $pecah_skr[0];
			
			//hitung selisih
			$jd1 = GregorianToJD($bln_exp, $tgl_exp, $thn_exp);
			$jd2 = GregorianToJD($bln_skr, $tgl_skr, $thn_skr);
			$selisih = $jd1 - $jd2;
			
			if ($selisih>=30)
			{
				$tahun  = floor($selisih/365);
				$bulan  = floor(($selisih%365)/30);	
				$hari   = floor($selisih - ($tahun*365) - ($bulan*30));
				$hasil  = $bulan." Bln ".$hari;
			}else{
				$hasil = $selisih;
				
			}
			
		 
		
			//insert ke tabel view
			$sql = " INSERT INTO table_view SET
					kode_vaksin 	='$kodevaksin', 
					nama_vaksin 	='$namavaksin', 
					jml_stok	    ='$stok',
					id_jenis	    ='$jenis',  
					satuan	    	='$satuan',
					expdate			='$expired',
					sisa			='$selisih'";
							
			mysql_query($sql, $koneksi) 
			  or die ("Simpan Data Gagal..".mysql_error());
					
		}	