<script type="text/javascript">
	$(document).ready(function(){
		$('#ya').click(function(){
			location.reload();	
			$("#nama").val('');	
		});
	
		$('#tidak').click(function(){
			$("#confirm").hide();
		});
	});
</script>


<?php
	include "../../conf/openconn.php";
	
	if ($_POST['aksi']=='insert')
	{
		$nama		= $_POST['nama_satuan'];		
		$sqlkat = " INSERT INTO satuan SET
					nama      ='$nama'";										
		mysql_query($sqlkat, $koneksi) 
			  or die ("Simpan Data Satuan Vaksin Gagal..".mysql_error());

	  if (!$sqlkat)
		{
			echo "Simpan Error";	
		}else{
			echo "Simpan Data Satuan Vaksin Berhasil, Input Data Lagi? <input type='button' id='ya' value='Ya'> <input type='button' id='tidak' value='Tidak'>";
		}
	}else{
        $id     	= $_POST['id_satuan'];
		$nama		= $_POST['nama_satuan'];		
		$sqlupdate   = "UPDATE satuan SET
					   nama='$nama' WHERE id='$id'";

		mysql_query($sqlupdate, $koneksi) 
			  or die ("Update Data Satuan Vaksin Gagal..".mysql_error());
	 

		if ($sqlupdate){
			echo "Satuan Vaksin Telah terupdate";
		}else{
			echo "Update Error";
		}		  
	}
	
	
 
?>
