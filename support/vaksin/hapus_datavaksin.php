<?php
    include "../../conf/openconn.php";
	
	if ($_POST['kode_batch']!='')
	{
	
		$kode_batch	= $_POST['kode_batch'];
		$delvaksin		= "delete from master_vaksin where kode_batch='".$kode_batch."'";
		$qryvaksin		= mysql_query($delvaksin);
			
		if (!$qryvaksin)	
		{
			echo '<div align="center">Data Vaksin GAGAL Dihapus</div>';		
		}else{
			echo '<div align="center">Data Vaksin BERHASIL Dihapus</div>';		
		}
	
	}	
?>	