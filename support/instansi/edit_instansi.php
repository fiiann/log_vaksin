<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Input Data Puskesmas</title>
<link rel="stylesheet" type="text/css" href="../css/adminview.css" media="all">
<script type="text/javascript" src="../js/adminview.js"></script>
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet"/>
<script type="text/javascript">

	$(document).ready(function(){
	
	
	$("#password").keyup(function(){
		var len		=$(this).val();
		var awal	=$("#pswd_awal").val();	
		if (len.length>8) 
			{
				alert("Panjang Password maksimal 8 karakter");
				$("#password").val(awal);				
			}
	
	});
	
	
	$("#updatedata").click(function(){
	
		var kode		= $("#kode_instansi").val();
		var nama    	= $("#nama_instansi").val();
		var alamat		= $("#alamat").val();
		var kecamatan   = $("#kecamatan").val();
		var kota    	= $("#kota").val();
		var no_telp   	= $("#no_telp").val();
		var username	= $("#username").val();
		var password	= $("#password").val();
		 
			$.ajax({
				    type : "POST",
					url	 : "update_instansi.php",
					data : "kode="+kode+"&nama="+nama+"&alamat="+alamat+"&kecamatan="+kecamatan+"&kota="+kota+"&no_telp="+no_telp+"&password="+password+"&username="+username,
					success : function(html)
					{
						$("#confirm").html(html);					
					}
			
			});

	  });
	
	});


</script>



</head>
<body id="main_body" >
	<?php
	include "../../conf/openconn.php";
	include "../../lib/functions-php.php";
	
	$kode			= $_GET['kdp'];
	$datapus		= "select * from instansi where kode_instansi='".$kode."'";
	$qrypus			= mysql_query($datapus);
	while ($dpus=mysql_fetch_array($qrypus))
	{
		$kode		= $dpus['kode_instansi'];		
		$nama		= $dpus['nama'];
		$alamat		= $dpus['alamat'];
		$kota		= $dpus['kota'];
		$notelp		= $dpus['no_telp'];
		$kecamatan  = $dpus['kecamatan'];
		$username	= base64_decode($dpus['username']);
		$password	= base64_decode($dpus['password']);		
	}
 	
     ?>

	<div id="form_container">	
		<h1><a>Edit Data Instansi</a></h1>
		<form id="form_898777" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>Edit Data Instansi</h2>
		</div>						
			<ul >
			
		<!--li id="li_1" >
		<label class="description" for="element_2">Kode Puskesmas *</label>
		<div>
			<input id="kode_puskesmas" name="element_2" class="element text small" type="text" maxlength="255" value="<?php echo $kode;?>" disabled /> 
		</div> 
		</li-->
		<input id="kode_instansi" name="element_2" class="element text small" type="hidden" maxlength="255" value="<?php echo $kode;?>" disabled /> 
		
		<li id="li_2" >
		<label class="description" for="element_2">Nama Instansi *</label>
		<div>
			<input id="nama_instansi" name="element_2" class="element text medium" type="text" maxlength="255" value="<?php echo $nama;?>"/> 
		</div> 
		</li>		<li id="li_3" >
		<label class="description" for="element_3">Alamat *</label>
		<div>
			<input id="alamat" name="element_3" class="element text large" type="text" maxlength="255" value="<?php echo $alamat;?>"/> 
		</div> 
		</li>	
		<li id="li_4" >
		<label class="description" for="element_4">Kecamatan *</label>
		<div>
			<input id="kecamatan" name="element_4" class="element text medium" type="text" maxlength="255" value="<?php echo $kecamatan;?>"/> 
		</div> 
		</li>	 
		<li id="li_4" >
		<label class="description" for="element_4">Kota *</label>
		<div>
			<input id="kota" name="element_4" class="element text medium" type="text" maxlength="255" value="<?php echo $kota;?>"/> 
		</div> 
		</li>		<li id="li_5" >
		<label class="description" for="element_5">No. Telpon </label>
		<span>
			<input id="no_telp" name="element_5" class="element text large"  value="<?php echo $notelp;?>" type="text"> 
 
		</span>
		<li id="li_6" >
		<label class="description" for="element_6">Username </label>
		<div>
			<input id="username" name="element_6" class="element text small" type="text" maxlength="255" value="<?php echo $username;?>" /> 
		</div> 
		</li>
		<li id="li_6" >
		<label class="description" for="element_6">Password </label>
		<div>
			<input id="password" name="element_6" class="element text small" type="text" maxlength="255" value="<?php echo $password;?>" /> 
		</div> 
		</li>
					<li class="buttons">
			    <input type="hidden" name="form_id" value="898777" />
			    
				<input id="updatedata" class="button_text" type="button" name="updatedata" value="Update Data" />
		</li>
		<div id="confirm"></div>
			</ul>
		</form>	
	</div>
	</body>
</html>