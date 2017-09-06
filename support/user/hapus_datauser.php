<?php
    include "../../librari/inc.koneksi.php";
	
	if ($_POST['iduser']!='')
	{
		$user_id = $_POST['iduser'];
		$deluser		= "delete from user where iduser='".$user_id."'";
		$qryuser		= mysql_query($deluser);
			
		if (!$qryuser)	
		{
			echo '<div align="center">Data User GAGAL Dihapus</div>';		
		}else{
			echo '<div align="center">Data User BERHASIL Dihapus</div>';		
		}	
	}	
?>	