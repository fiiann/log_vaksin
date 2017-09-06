<?php
    include "../../librari/inc.koneksi.php";
	
	if ($_POST['orderid']!='')
	{
		$order_id 		= $_POST['orderid'];
		$delorder		= "Delete from trxprov where idorder='".$order_id."'";
		$qrydel			= mysql_query($delorder);
		
		$delorder_d		= "Delete from trxprov_detil where idorder='".$order_id."'";
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
		
		$delbrg_order	= "Delete from trxprov_detil where idorder='".$idorder."' AND kode_vaksin='".$kodevaksin."'";
		$qrybrg_del		= mysql_query($delbrg_order);
	
		if (!$qrybrg_del) {
			echo "&nbsp;&nbsp;Data Gagal Dihapus";
		}else{
			echo "&nbsp;&nbsp;Data Berhasil Dihapus";
		}
		
		//cek habis
		$sqlcek = "Select idorder from trxprov_detil where idorder='".$idorder."'";
		$qrycek	= mysql_query($sqlcek);
		$find	= mysql_num_rows($qrycek);
		if ($find!=0)
		{
			return false;
		}else{
			//del dari tabel trxobat
			$del	= "delete from trxprov where idorder='".$idorder."'";
			$qrydel = mysql_query($del);
			
			 
		}
		
		
	}
?>	