<script type="text/javascript">
	$(document).ready(function(){
		$('#ya').click(function(){
			location.reload();	
			$("#namauser").val('');
			$("#alamatuser").val('');
			$("#username").val('');
			$("#password").val('');
			$("#hak_akses").val('');
		});
	
		
		$('#Back').click(function(){			
			document.location.href='listview_user.php';
		});
		 
	});
</script>
<?php
	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php";
	
	if ($_POST['iduser']!='')
	{
		$id_user	= $_POST['iduser'];
		$nama		= $_POST['namauser'];
		$alamat		= $_POST['alamat'];
		$username	= $_POST['username'];
		$password	= base64_encode($_POST['password']);
		$akses		= $_POST['hakakses'];
		
		
		$sql = " UPDATE user SET
					iduser	 	='$id_user', 
					namauser 	='$nama', 
					alamatuser  ='$alamat', 
					username	='$username',  
					password    ='$password',
					idakses	    ='$akses' where iduser='".$id_user."'";
					
					
		mysql_query($sql, $koneksi) 
			  or die ("Update Data Gagal..".mysql_error());
	
		if (!$sql)
		{
			echo "<br>";
			echo "&nbsp;&nbsp;<font color='red'><b>Update Data User Error...</b></font>";
		}else{
			echo "<br>";
			echo "&nbsp;&nbsp;<font color='green'><b>Update Data User Berhasil...</b>&nbsp;<input type='button' id='Back' value='Back' onclick='javascript:history.back()'>";
	
		}
	}


 
?>
<div id="content"></div>