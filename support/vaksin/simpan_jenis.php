<script type="text/javascript">
	$(document).ready(function(){
		$('#ya').click(function(){
			location.reload();	
			$("#namajenis").val('');	
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
		$idjenis	= $_POST['id_jenis'];
		$nama		= $_POST['nama_jenis'];		
		$sqlkat = " INSERT INTO jenis_vaksin SET
					id_jenis  ='$idjenis', 
					nama      ='$nama'";										
		mysql_query($sqlkat, $koneksi) 
			  or die ("Simpan Data Jenis Vaksin Gagal..".mysql_error());

	  if (!$sqlkat)
		{
			echo "Simpan Error";	
		}else{
			echo "Simpan Data Jenis Vaksin Berhasil, Input Data Lagi? <input type='button' id='ya' value='Ya'> <input type='button' id='tidak' value='Tidak'>";
		}
	}else{
        $idjenis	= $_POST['id_jenis'];
		$nama		= $_POST['nama_jenis'];		
		$sqlupdate   = "UPDATE jenis_vaksin SET
					   nama='$nama' WHERE id_jenis='$idjenis'";

		mysql_query($sqlupdate, $koneksi) 
			  or die ("Update Data Jenis Vaksin Gagal..".mysql_error());
	 

		if ($sqlupdate){
			echo "Jenis Vaksin Telah terupdate";
		}else{
			echo "Update Error";
		}		  
	}
	
	
 
?>
