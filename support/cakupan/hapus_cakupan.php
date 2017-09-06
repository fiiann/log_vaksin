<?php
    include "../../conf/openconn.php";
	
	if ($_POST['idx']!='')
	{
        
        $idx = $_POST['idx'];

        //get stok expired
		$idx      = $_POST['idx'];
		$delexp	  = "delete from data_cakupan where idx='".$idx."'";
		$qryexp	  = mysql_query($delexp);
			
		if (!$qryexp)	
		{
			echo '<div align="center">Data Cakupan GAGAL Dihapus</div>';		
		}else{
			echo '<div align="center">Data Cakupan BERHASIL Dihapus</div>';		
		}
	
        
    }	
?>	