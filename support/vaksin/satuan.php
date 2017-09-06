<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Input Jenis Obat</title>
<link rel="stylesheet" type="text/css" href="../css/adminview.css" media="all">
<script type="text/javascript" src="../js/adminview.js"></script>
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet"/>
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#simpansatuan").click(function(){
			var nama		= $("#nama").val();
			var aksi  = 'insert';
			if (nama.length>0)
			{
				$.ajax({
						type    :"POST",
						url	    :"simpan_satuan.php",
						data    :"aksi="+aksi+"&nama_satuan="+nama,
						success : function(html){
							$("#confirm").show();
							$("#confirm").html(html);							
						}				
				});					
				
			}else{			
				alert("Nama Satuan tidak boleh kosong");
			}		
		});	
	});

</script>

</head>
<body id="main_body" >
<?php
	include "../../conf/openconn.php";
	include "../../lib/functions-php.php";
?>	

	<div id="form_container">
		<h1><a>Input Jenis Vaksin</a></h1>
		<form id="form_899286" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>Input Satuan Vaksin</h2>
			<p>masukan data Satuan dengan lengkap dan benar</p>
		</div>						
			<ul >
			
		<label class="description" for="element_2">Satuan Vaksin * </label>
		<div>
			<input id="nama" name="nama" class="element text medium" type="text" maxlength="255" value=""/> 
		</div> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="899286" />
			    
				<input id="simpansatuan" class="button_text" type="button" value="Simpan Data" />
		</li>
		<div id="confirm"></div>	
		</ul>
		</form>	
 
	</div>
 
	</body>
</html>