<?php
    include "../../conf/openconn.php";
	
	if ($_POST['idx']!='')
	{
        
        $jml_stok = $_POST['jml_stok'];

        //get stok expired
        $stok = "SELECT id_jenis, stok_expired FROM expired where idx='".$idx."'";
        $qstok = mysql_query($stok);
        while ($exp=mysql_fetch_array($qstok))
        {   
            $idjenis  = $exp['id_jenis'];
            $stok_exp = $exp['stok_expired'];
        }

		$idx      = $_POST['idx'];
		$delexp	  = "delete from expired_stok where idx='".$idx."'";
		$qryexp	  = mysql_query($delexp);
			
		if (!$qryexp)	
		{
			echo '<div align="center">Data Stok Expired GAGAL Dihapus</div>';		
		}else{
			echo '<div align="center">Data Stok Expired BERHASIL Dihapus</div>';		
		}
	
        //kembalikan jumlah stok ke master stok
        $totstok = $jml_stok + $stok_exp;
        $upd = "UPDATE master_stok SET 
                stok_tersedia='$totstok' where id_jenis='".$idjenis."'";
        $qup = mysql_query($upd) or die (mysql_error());        
    }	
?>	