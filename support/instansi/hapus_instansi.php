<?php
    include "../../conf/openconn.php";
	
	if ($_POST['kdp']!='')
	{
	
		$kdp 		= $_POST['kdp'];
		$delpus		= "delete from instansi where kode_instansi='".$kdp."'";
		$qrypus		= mysql_query($delpus);
			
		if (!$qrypus)	
		{
			echo '<div align="center">Data Instansi GAGAL Dihapus</div>';		
		}else{
			echo '<div align="center">Data Instansi BERHASIL Dihapus</div>';		
		}
	
	}	
?>	