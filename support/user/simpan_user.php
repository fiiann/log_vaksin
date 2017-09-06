<script type="text/javascript">
	$(document).ready(function(){
		$('#ya').click(function(){
			location.reload();	
			$("#namauser").val('');
			$("#alamatuser").val('');
			$("#username").val('');
			$("#password").val('');
			$("#hakakses").val('');
		});
	
		$('#tidak').click(function(){
			
		});
	});
</script>
<?php
	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php";
	
	if ($_POST['iduser']!='')
	{
		$iduser		= $_POST['iduser'];
		$namauser	= $_POST['namauser'];
		$alamat		= $_POST['alamat'];
		$username	= $_POST['username'];
		$password	= base64_encode($_POST['password']);
		$idakses	= $_POST['hakakses'];
		
		
		$sql = " INSERT INTO user SET
					iduser	   ='$iduser', 
					namauser   ='$namauser', 
					alamatuser ='$alamat', 
					username   ='$username',  
					password   ='$password',
					idakses    ='$idakses'";
					
					
		mysql_query($sql, $koneksi) 
			  or die ("Simpan Data User Gagal..".mysql_error());
	
		if (!$sql)
		{
			echo "Simpan Data User Error...";
		}else{
			echo " Simpan Data User Berhasil, Input Data Lagi? <input type='button' id='ya' value='Ya'> <input type='button' id='tidak' value='Tidak'>";
	
		}
	}


 
?>
