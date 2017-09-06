<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Input Data instansi</title>
<link rel="stylesheet" type="text/css" href="../css/adminview.css" media="all">
<script type="text/javascript" src="../js/adminview.js"></script>
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet"/>
<script type="text/javascript">

	$(document).ready(function(){
	
	$("#simpanpus").click(function(){
	
		var kode	 = $("#kode_instansi").val();
		var nama     = $("#nama_instansi").val();
		var alamat	 = $("#alamat").val();
		var kota     = $("#kota").val();
		var no_tlp   = $("#no_telp").val();
		var kecamatan= $("#kecamatan").val();
		
		if ((nama.length>0) && (alamat.length>0) && (kota.length>0))
		{
			$.ajax({
				    type : "POST",
					url	 : "simpan_instansi.php",
					data : "kode="+kode+"&nama="+nama+"&alamat="+alamat+"&kecamatan="+kecamatan+"&kota="+kota+"&no_telp="+no_tlp,
					success : function(html)
					{
							$("#confirm").html(html);					
					}
			
			});
		
		}else{
				alert("Kolom dengan Tanda (*) Mohon Isikan Data Dengan Lengkap dan Benar");			
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
		<h1><a>Input Data instansi</a></h1>
		<form id="form_898777" class="appnitro"  method="post" action="">
		<div class="form_description">
			<h2>Input Data instansi</h2>
			<p>isi data instansi dengan lengkap dan benar, <font color="red">(*) Wajib Diisi</font></p>
		</div>						
			<ul >
			
		<!--li id="li_2" >
		<label class="description" for="element_2">Kode instansi *</label>
		<div>
			<input id="kode_instansi" name="element_2" class="element text small" type="text" maxlength="255" value="<?php echo autonumb('instansi','kode_instansi','3','INT');?>"  readonly /> 
		</div> 
		</li-->
		<input id="kode_instansi" name="element_2" class="element text small" type="hidden" maxlength="255" value="<?php echo autonumb('instansi','kode_instansi',2,'IN');?>"/> 
		
		<li id="li_2" >
		<label class="description" for="element_2">Nama instansi *</label>
		<div>
			<input id="nama_instansi" name="element_2" class="element text medium" type="text" maxlength="255" value=""/> 
		</div> 
		</li>		<li id="li_3" >
		<label class="description" for="element_3">Alamat *</label>
		<div>
			<input id="alamat" name="element_3" class="element text large" type="text" maxlength="255" value=""/> 
		</div> 
		</li>		<li id="li_7" >
		<label class="description" for="element_4">Kecamatan *</label>
		<div>
			<input id="kecamatan" name="element_4" class="element text medium" type="text" maxlength="255" value=""/> 
		</div> 
		</li>
		<li id="li_7" >
		<label class="description" for="element_4">Kota *</label>
		<div>
			<input id="kota" name="element_3" class="element text medium" type="text" maxlength="255" value=""/> 
		</div> 
		</li>		<li id="li_5" >
		<label class="description" for="element_5">No. Telpon </label>
		<div>
			<input id="no_telp" name="element_6" class="element text small" type="text" maxlength="255" value=""/> 
		</div>
		</li>		
		<li class="buttons">
			    <input type="hidden" name="form_id" value="898777" />
			    
				<input id="simpanpus" class="button_text" type="button" name="simpanpus" value="Simpan instansi" />
		</li>
		<div id="confirm"></div>
			</ul>
		</form>	
	</div>
	</body>
</html>