<?php
    include "../../librari/inc.koneksi.php";

	if ($_POST['idorder']!='')
	{	
		$tglorder		= $_POST['tglorder'];
		$ketorder		= $_POST['ketorder'];
		$idorder		= $_POST['idorder'];			
		
		$order_simpan ="update trxterima SET tgl_terima='".$tglorder."',keterangan='".$ketorder."' Where idterima='".$idorder."'"; 
		$result_simpan=mysql_query($order_simpan);	
	
		if (!$result_simpan)
		{
			echo "&nbsp;&nbsp;Simpan Order Gagal..!";		
		}else{
			echo "&nbsp;&nbsp;Simpan Order Berhasil...";
		}
	
	}
	 
?>