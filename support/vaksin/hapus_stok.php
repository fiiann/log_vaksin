<?php
    include "../../conf/openconn.php";
	
	if ($_POST['id_jenis']!='')
	{
	
		$id_jenis       = $_POST['id_jenis'];
		$delvaksin		= "delete from master_stok where id_jenis='".$id_jenis."'";
		$qryvaksin		= mysql_query($delvaksin);


		//hapus dari tabel master_stok_detil 
		$hapus = "delete from master_stok_detil where id_jenis='".$id_jenis."'";
		$qdel  = mysql_query($hapus) or die (mysql_error());

		if (!$qryvaksin)	
		{
			echo '<div align="center">Data Vaksin GAGAL Dihapus</div>';		
		}else{
			echo '<div align="center">Data Vaksin BERHASIL Dihapus</div>';		
		}
	
	}	
?>	