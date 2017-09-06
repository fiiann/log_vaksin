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
		
		$("#updatejenis").click(function(){
			var idjenis		= $("#idjenis").val();
			var nama		= $("#namajenis").val();
			var aksi = 'update';
			if (nama.length>0)
			{
				$.ajax({
						type    :"POST",
						url	    :"simpan_jenis.php",
						data    :"aksi="+aksi+"&id_jenis="+idjenis+"&nama_jenis="+nama,
						success : function(html){
							$("#confirm").show();
							$("#confirm").html(html);							
						}				
				});					
				
			}else{			
				alert("Nama Jenis Vaksin tidak boleh kosong");
			}		
		});	
	});

</script>

</head>
<body id="main_body" >
<?php
	include "../../conf/openconn.php";
	include "../../lib/functions-php.php";
 
    $idjenis = $_GET['id_jenis'];
    $get = "SELECT nama from jenis_vaksin where id_jenis='$idjenis'";
    $qry = mysql_query($get);
    while ($jv=mysql_fetch_array($qry)){
        $namav = $jv['nama'];
     
    }
?>	

	<div id="form_container">
	
		<h1><a>Input Jenis Vaksin</a></h1>
		<form id="form_899286" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>Edit Jenis Vaksin</h2>
			<p>masukan data jenis Vaksin dengan lengkap dan benar</p>
		</div>						
			<ul >
			
		<input id="idjenis" name="idjenis" class="element text small" type="hidden" maxlength="255" value="<?php echo $idjenis;?>">
		<label class="description" for="element_2">Jenis Vaksin * </label>
		<div>
			<input id="namajenis" name="namajenis" class="element text medium" type="text" maxlength="255" value="<?php echo $namav;?>"/> 
		</div> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="899286" />
			    
				<input id="updatejenis" class="button_text" type="button" name="simpanjenis" value="Simpan Data" />
		</li>
		<div id="confirm"></div>	
		</ul>
		</form>	
 
	</div>
 
	</body>
</html>