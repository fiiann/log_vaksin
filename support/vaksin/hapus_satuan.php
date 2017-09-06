<?php
    include "../../conf/openconn.php";
	
	if ($_POST['id_satuan']!='')
	{
	
		$id_satuan  = $_POST['id_satuan'];
		$delsat		= "DELETE FROM satuan where id='".$id_satuan."'";
		$qrysat		= mysql_query($delsat);


		if (!$qrysat)	
		{
			echo '<div align="center">Data Satuan Vaksin GAGAL Dihapus</div>';		
		}else{
			echo '<div align="center">Data Satuan Vaksin BERHASIL Dihapus</div>';		
		}
	
	}	
?>	