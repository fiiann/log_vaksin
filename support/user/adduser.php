<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Add User</title>
<link rel="stylesheet" type="text/css" href="../../css/view.css" media="all">
<script type="text/javascript" src="../../js/view.js"></script>
<script type="text/javascript" src="../../js/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../../js/jquery/jquery/jquery-ui-1.8.18.custom.min.js"></script>
<link type="text/css" href="../../css/jquery/jquery-ui-1.8.18.custom.css" rel="stylesheet"/>
<script type="text/javascript">
	$(document).ready(function() {
	 
		
		$("#saveuser").click(function(){
			
			var iduser 		= $("#iduser").val();
			var namauser	= $("#namauser").val();
			var alamat		= $("#alamatuser").val();
			var username	= $("#username").val();
			var password	= $("#password").val();
			var hakakses	= $("#hak_akses").val();
			
						
				$.ajax({
						 type : "POST",
						 url  : "simpan_user.php",
						 data : "iduser="+iduser+"&namauser="+namauser+"&alamat="+alamat+"&username="+username+"&password="+password+"&hakakses="+hakakses,
						 success : function(html){
								$("#confirm").html(html);
						 }
				});			
		
		});		
		
		
	}); 
</script>


</head>
<body id="main_body" >
	<?php
	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php";
 	
?>
	<img id="top" src="../../images/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Add User</a></h1>
		<form id="form_904329" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>Add User</h2>
			<p>isikan data user dengan lengkap dan benar</p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">ID User </label>
		<div>
			<input id="iduser" name="iduser" class="element text small" type="text" maxlength="255" value="<?php echo kdauto('user','UR-');?>" disabled /> 
		</div> 
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Nama Pengguna </label>
		<div>
			<input id="namauser" name="namauser" class="element text medium" type="text" maxlength="255" value="" /> 
		</div> 
		</li>		<li id="li_3" >
		<label class="description" for="element_3">Alamat </label>
		<div>
			<input id="alamatuser" name="alamatuser" class="element text medium" type="text" maxlength="255" value=""/> 
		</div> 
		</li>		<li id="li_4" >
		<label class="description" for="element_4">Username </label>
		<div>
			<input id="username" name="username" class="element text small" type="text" maxlength="255" value=""/> 
		</div> 
		</li>		<li id="li_5" >
		<label class="description" for="element_5">Password </label>
		<div>
			<input id="password" name="password" class="element text small" type="password" maxlength="255" value=""/> 
		</div> 
		</li>		<li id="li_6" >
		<label class="description" for="element_6">Hak Akses </label>
		<div>
		<select class="element select small" id="hakakses" name="hakakses"> 
			<option value="" selected="selected"></option>
			<option value="1">Administrator</option>
			<option value="2">User Publik</option>
		</select>
		</div> 
		</li>			
				<li class="buttons">
			    <input type="hidden" name="form_id" value="904329" />
			    
				<input id="saveuser" class="button_text" type="button" name="saveuser" value="Simpan User" />
		</li>
		<div id="confirm"></div>
			</ul>
		</form>	
		<div id="footer">
		  Sisfo Pengelolaan Obat <a href="">2014</a>
		</div>
	</div>
	<img id="bottom" src="../../images/bottom.png" alt="">
	</body>
</html>