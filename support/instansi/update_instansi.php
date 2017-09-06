<script type="text/javascript">
	$(document).ready(function(){

		$('#Back').click(function(){			
			document.location.href='listview_instansi.php';
		});
		
	});
</script>
<?php
	include "../../conf/openconn.php";
	include "../../lib/functions-php.php";
	
	if ($_POST['kode']!='')
	{
		$kode			= $_POST['kode'];
		$nama			= $_POST['nama'];
		$alamat			= $_POST['alamat'];
		$kota			= $_POST['kota'];
		$kecamatan      = $_POST['kecamatan'];
		$no_telp		= $_POST['no_telp'];	
		$username		= base64_encode($_POST['username']);
		$password		= base64_encode($_POST['password']);
		
		$sql = " UPDATE instansi SET
					nama	 			='$nama', 
					alamat	 			='$alamat', 
					kota	    		='$kota',
					kecamatan           ='$kecamatan',
					no_telp				='$no_telp',
					username			='$username',
					password			='$password'
				where kode_instansi     ='".$kode."'";
					
					
		mysql_query($sql, $koneksi) 
			  or die ("Update Data Instansi Gagal..".mysql_error());
	
		if (!$sql)
		{
			echo "&nbsp;&nbsp;<font color='red'><b>Update Data Instansi Error...</b></font>";
		}else{
			echo "&nbsp;&nbsp;<font color='green'><b>Update Data Instansi Berhasil...</b></font>&nbsp;<input type='button' id='Back' value='Back'>";
	
		}
	}


 
?>
