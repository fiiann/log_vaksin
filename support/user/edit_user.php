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
	 
		
		$("#updateuser").click(function(){
			
			var iduser 		= $("#iduser").val();
			var namauser	= $("#namauser").val();
			var alamat		= $("#alamatuser").val();
			var username	= $("#username").val();
			var password	= $("#password").val();
			var hakakses	= $("#hak_akses").val();
			
						
				$.ajax({
						 type : "POST",
						 url  : "update_user.php",
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
 
    $iduser = $_GET['iduser'];
	//get data user
	$getuser = "select * from user where iduser='".$iduser."'";
	$qryuser = mysql_query($getuser);
	while ($get=mysql_fetch_array($qryuser))
	{
		$iduser   = $get['iduser'];
		$nama	  = $get['namauser'];
		$alamat   = $get['alamatuser'];
		$username = $get['username'];
		$password = base64_decode($get['password']);
		$akses	  = $get['idakses'];	
			
		
	}
	
	
						
     
                     
?>
	<img id="top" src="../../images/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Edit User</a></h1>
		<form id="form_904329" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>Edit User</h2>
			<p>Edit data user Sisfo Pengelolaan Obat</p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">ID User </label>
		<div>
			<input id="iduser" name="iduser" class="element text small" type="text" maxlength="255" value="<?php echo $iduser;?>" disabled /> 
		</div> 
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Nama Pengguna </label>
		<div>
			<input id="namauser" name="namauser" class="element text medium" type="text" maxlength="255" value="<?php echo $nama;?>" /> 
		</div> 
		</li>		<li id="li_3" >
		<label class="description" for="element_3">Alamat </label>
		<div>
			<input id="alamatuser" name="alamatuser" class="element text medium" type="text" maxlength="255" value="<?php echo $alamat;?>"/> 
		</div> 
		</li>		<li id="li_4" >
		<label class="description" for="element_4">Username </label>
		<div>
			<input id="username" name="username" class="element text small" type="text" maxlength="255" value="<?php echo $username;?>"/> 
		</div> 
		</li>		<li id="li_5" >
		<label class="description" for="element_5">Password </label>
		<div>
			<input id="password" name="password" class="element text small" type="text" maxlength="255" value="<?php echo $password;?>"/> 
		</div> 
		</li>		<li id="li_6" >
		<label class="description" for="element_6">Hak Akses </label>
		<div>
		<select class="element select small" id="hak_akses" name="hak_akses"> 
		
		<?php 
		$getakses = "select idakses from user";
		$qryakses = mysql_query($getakses);
		while ($data=mysql_fetch_array($qryakses))
		{ ?>
			<option value="0" <?php echo ($data['idakses']=="0")?"selected":""; ?>>Administrator</option>
			<option value="1" <?php echo ($data['idakses']=="1")?"selected":""; ?>>Public User</option>
		<?php } ?>
		
		</select>
		</div> 
		</li>			
				<li class="buttons">
			    <input type="hidden" name="form_id" value="904329" />
			    
				<input id="updateuser" class="button_text" type="button" name="updateuser" value="Update User" />
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