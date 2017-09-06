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
		
		$("#updatesatuan").click(function(){
            var idsat = $("#id_satuan").val();
			var nama  = $("#nama").val();
			var aksi  = 'update';
			if (nama.length>0)
			{
				$.ajax({
						type    :"POST",
						url	    :"simpan_satuan.php",
						data    :"aksi="+aksi+"&id_satuan="+idsat+"&nama_satuan="+nama,
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

    $id = $_GET['id'];
    $getsat = "SELECT nama from satuan where id='$id'";
    $qrysat = mysql_query($getsat) or die (mysql_error());
    while($out=mysql_fetch_array($qrysat)){
        $nama = $out['nama'];
    }
?>	

	<div id="form_container">
		<h1><a>Input Jenis Vaksin</a></h1>
		<form id="form_899286" class="appnitro"  method="post" action="">
			<div class="form_description">
			 <h2>Edit Satuan Vaksin</h2>
			 <p>masukan data Satuan dengan lengkap dan benar</p>
	     	</div>						
			<ul >
			
		<label class="description" for="element_2">Satuan Vaksin * </label>
		<div>
            <input type="hidden" id="id_satuan" value="<?php echo $id;?>">
			<input id="nama" name="nama" class="element text medium" type="text" maxlength="255" value="<?php echo $nama;?>" /> 
		</div> 
		</li>
	    <li class="buttons">   
				<input id="updatesatuan" class="button_text" type="button" value="Update Data" />
		</li>
		<div id="confirm"></div>	
		</ul>
		</form>	
 
	</div>
 
	</body>
</html>