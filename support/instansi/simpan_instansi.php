<script type="text/javascript">
	$(document).ready(function(){
		$('#ya').click(function(){
			location.reload();			 
			$("#nama_instansi").val('');
			$("#alamat").val('');
			$("#kota").val('');			
			$("#kecamatan").val('');
			$("#no_telp").val('');	
		});
	
		$('#tidak').click(function(){
			$("#confirm").hide();
		});
	});
</script>
<?php
	include "../../conf/openconn.php";
	include "../../lib/functions-php.php";
	
	if ($_POST['kode']!='')
	{
		$kode		= $_POST['kode'];
		$nama		= $_POST['nama'];
		$alamat		= $_POST['alamat'];
		$kota		= $_POST['kota'];
		$telp		= $_POST['no_telp'];
		$kecamatan  = $_POST['kecamatan'];

		$code = substr($kode,5,2);
		$txt  = "admin".$code;
		$username	= base64_encode($txt);
		$password	= base64_encode('123oke');		
				
		$sql = " INSERT INTO instansi SET
					kode_instansi	  ='$kode',
					nama   			  ='$nama',
					alamat			  ='$alamat',
					kecamatan         ='$kecamatan',
					kota			  ='$kota',  
					no_telp	    	  ='$telp',
					username		  ='$username',
					password		  ='$password'";
					
										
		mysql_query($sql, $koneksi) 
			  or die ("Simpan Data Gagal..".mysql_error());
	
		if (!$sql)
		{
			echo "Simpan Data Instansi Error...";
		}else{
			echo " Simpan Data Instansi Berhasil, Input Data Lagi? <input type='button' id='ya' value='Ya'> <input type='button' id='tidak' value='Tidak'>";
	
		}
	}


 
?>
