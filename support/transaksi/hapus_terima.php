<?php
    include "../../librari/inc.koneksi.php";
	
	if ($_POST['orderid']!='')
	{
		$order_id 		= $_POST['orderid'];
		$delorder		= "Delete from trxterima where idterima='".$order_id."'";
		$qrydel			= mysql_query($delorder);
		
		$delorder_d		= "Delete from trxterima_detil where idterima='".$order_id."'";
		$qrydel_d		= mysql_query($delorder_d);
		
		if ((!$qrydel) && (!$qrydel_d))	
		{
			echo '<div align="center">DATA ORDER GAGAL DIHAPUS</div>';		
		}else{
			echo '<div align="center">DATA ORDER BERHASIL DIHAPUS</div>';		
		}
	
	}else{	
		$idorder 	= $_POST['idorder'];
		$kodevaksin	= $_POST['kodevaksin'];
		$qstok		= $_POST['qstok'];		
		$qorder		= $_POST['qorder'];
		
		$delbrg_order	= "Delete from trxterima_detil where idterima='".$idorder."' AND kode_vaksin='".$kodevaksin."'";
		$qrybrg_del		= mysql_query($delbrg_order);
		
		
		//update stok master vaksin
		$getstok	= "select jml_stok from master_vaksin where kode_vaksin='".$kodevaksin."'";
		$qrystok	= mysql_query($getstok);
		while ($qs=mysql_fetch_array($qrystok))
		{
			$jmlstok = $qs['jml_stok'];
			$hsl=$jmlstok-$qorder;
			
			//update stok master vaksin
			$upstok = "update master_vaksin SET jml_stok='".$hsl."' where kode_vaksin='".$kodevaksin."'";
			$upqry = mysql_query($upstok);
		}
	
		if (!$qrybrg_del) {
			echo "&nbsp;&nbsp;Data Gagal Dihapus";
		}else{
			echo "&nbsp;&nbsp;Data Berhasil Dihapus";
		}
		
		//cek habis
		$sqlcek = "Select idterima from trxterima_detil where idterima='".$idorder."'";
		$qrycek	= mysql_query($sqlcek);
		$find	= mysql_num_rows($qrycek);
		if ($find!=0)
		{
			return false;
		}else{
			//del dari tabel trxobat
			$del	= "delete from trxterima where idterima='".$idorder."'";
			$qrydel = mysql_query($del);
			
			 
		}
		
		
	}
?>	