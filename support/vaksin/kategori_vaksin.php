<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Input Kategori Obat</title>
<link rel="stylesheet" type="text/css" href="../../css/view.css" media="all">
<script type="text/javascript" src="../../js/view.js"></script>
<script type="text/javascript" src="../../js/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../../js/jquery/jquery/jquery-ui-1.8.18.custom.min.js"></script>
<link type="text/css" href="../../css/jquery/jquery-ui-1.8.18.custom.css" rel="stylesheet"/>
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#simpankategori").click(function(){
			var idkategori	= $("#idkategori").val();
			var nama		= $("#namakategori").val();
			
			if (nama.length>0)
			{
				$.ajax({
						type    :"POST",
						url	    :"simpan_kategori.php",
						data    :"idkategori="+idkategori+"&nama="+nama,
						success : function(html){
							$("#confirm").html(html);							
						}				
				});					
				
			}else{			
				alert("Nama Kategori tidak boleh kosong");
			}		
		});	
	});

</script>

</head>
<body id="main_body" >	
<?
	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php"; 	
?>

	<img id="top" src="../../images/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Input Kategori Obat</a></h1>
		<form id="form_898777" class="appnitro"  method="post" action="">
		<div class="form_description">
			<h2>Input Kategori Obat</h2>
			<p>isi data kategori obat dengan lengkap dan benar</p>
		</div>						
			<ul>			
					<li id="li_1" >
		<label class="description" for="element_1">ID Kategori </label>
		<div>
			<input id="idkategori" name="idkategori" class="element text small" type="text" maxlength="255" value="<?php echo kdauto('kategoriobat','KO-');?>" readonly/> 
		</div> 
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Nama Kategori *</label>
		<div>
			<input id="namakategori" name="namakategori" class="element text medium" type="text" maxlength="255" value=""/> 
		</div> 
		</li>			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="898777" />			    
				<input id="simpankategori" class="button_text" type="button" name="simpankategori" value="Simpan Kategori" />
		</li>
			<br>
			&nbsp;<div id="confirm"></div>			
		</ul>
		</form>	
		<div id="footer">
			Sisfo Pengelolaan Obat<a href="">2014</a>
		</div>
	</div>
	<img id="bottom" src="../../images/bottom.png" alt="">
	</body>
</html>