<script type="text/javascript">
	$(document).ready(function(){
		 
	});
</script>
<?php
	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php";
	
	if ($_POST['idpurchasing']!='')
	{
		$idpurchasing  = $_POST['idpurchasing'];
		$idpuskesmas   = $_POST['idpuskesmas'];
		$tglpurchasing = $_POST['tglpurchasing'];
		$idorder	   = $_POST['idorder'];		
		$kodeobat	   = $_POST['kodeobat'];
		$qtyor		   = $_POST['qtyorder'];
		$qtyac		   = $_POST['qtyacc'];
		$satuan		   = $_POST['satuan'];

		$idor 		= explode(",",$idorder);
		$k_obat		= explode(",",$kodeobat);
		$qo			= explode(",",$qtyor);
		$qa			= explode(",",$qtyac);
		$sat		= explode(",",$satuan);
		$jmlobat	= count($idor);
		
		
		//insert ke tabel purchasing
		$ins	= "insert into purchasing SET
					 idpurchasing	='$idpurchasing',
					 tglpurchasing 	='$tglpurchasing',
					 kode_puskesmas	='$idpuskesmas',
					 keterangan		='$keterangan'";
					 
			mysql_query($ins, $koneksi) 
				or die ("Simpan Data Gagal..".mysql_error());			 
					 
		
			//cek apakah sudah ada kode pkm yang sama
			$cekpkm	= "Select kode_puskesmas from vaksin_pkm where kode_puskesmas";
			$qrypkm = mysql_query($cekpkm);
			$ada	= mysql_num_rows($qrypkm);
			if ($ada!=0){
				
			}else{
				$inspkm	= "insert into vaksin_pkm SET
					  kode_puskesmas ='$idpuskesmas'";
					
				mysql_query($inspkm, $koneksi) 
					or die ("Simpan Data Stok PKM Gagal..".mysql_error());
			}
			
			
		for ($i=0;$i<$jmlobat;$i++)
		{
			$id_order = $idor[$i];
			$kd_obat  = $k_obat[$i];
			$qt_a	  = $qa[$i];
			$qt_o	  = $qo[$i];
			$sat_ob	  = $sat[$i];
			
			$sql = " INSERT INTO purchasing_detil SET
					idpurchasing='$idpurchasing',
					idorder 	='$id_order', 
					kode_vaksin ='$kd_obat', 
					jml_order   ='$qt_o',
					jml_acc	    ='$qt_a',
					satuan		='$sat_ob'";  
										
			mysql_query($sql, $koneksi) 
				or die ("Simpan Data Gagal..".mysql_error());
		
		
			//update status is_order
			$update = "update trxvaksin_detil SET is_order=1 where kode_vaksin='".$kd_obat."'";
			$qryup  = mysql_query($update);
			
			
			/*
			//cek di tabel apakah ada kode vaksin yang sama 
			$cekvak	= "select kode_vaksin from vaksinpkm_detil where kode_vaksin='".$kd_obat."'";
			$qryvak	= mysql_query($cekvak);
			$ketemu	= mysql_num_rows($qryvak);
			if ($ketemu!=0){
				//ambil jml stok awal
				$stokawal	= "select jml_stok from vaksinpkm_detil where kode_vaksin='".$kd_obat."'";
				$qrystok	= mysql_query($stokawal);
				while ($pstok=mysql_fetch_array($qrystok)){
					$stok_awal	= $pstok['jml_stok'];
					$jmlstok	= $stok_awal+$qt_a;
					
					//update stok nya
					$upvaksin	= "update vaksinpkm_detil SET jml_stok='".$jmlstok."' where kode_vaksin='".$kd_obat."'";
					$qryup		=  mysql_query($upvaksin);
					
				}
			
			}else{
				//insert data vaksin baru ke stok pkm detil
				$stokpkm	= "insert into vaksinpkm_detil SET
							   kode_puskesmas = '$idpuskesmas',
							   kode_vaksin	  = '$kd_obat',
							   jml_stok		  = '$qt_a',
							   satuan		  = '$sat_ob'";
							   
				mysql_query($stokpkm, $koneksi) 
				or die ("Simpan Data STOK PKM Gagal..".mysql_error());			   
	
			}
			
		}
		*/
	
		if (!$sql)
		{
			 echo "&nbsp;&nbsp;<b>Purchasing Data Obat Error...</b>";
		}else{
			 echo "&nbsp;&nbsp;<b>Purchasing Data Obat Berhasil...</b>";
	
		}
	}
}
?>
