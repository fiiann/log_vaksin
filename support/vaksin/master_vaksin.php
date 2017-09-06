<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Input Master vaksin</title>
<link rel="stylesheet" type="text/css" href="../css/adminview.css" media="all">
<script type="text/javascript" src="../js/adminview.js"></script>
<script src="../js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet"/>
 
<script type="text/javascript">
	  $(function() {
		$("#tgl_expired").datepicker();	 
		$("#tgl_expired").change(function() {
             $("#tgl_expired").datepicker("option","dateFormat","dd-mm-yy");
		   }); 	
		});
	
	$(function() {
		$("#tgl_diterima").datepicker();	 
		$("#tgl_diterima").change(function() {
             $("#tgl_diterima").datepicker("option","dateFormat","dd-mm-yy");
		   }); 	
		});
	
	
	$(document).ready(function(){
			
		$("#simpandata").click(function(){
			var batch	    = $("#kodebatch").val();
			var nama   	    = $("#namavaksin").val();
			var jenis		= $("#jenisvaksin").val();
			var expired		= $("#tgl_expired").val();
			var diterima	= $("#tgl_diterima").val();
			var vvm         = $("#vvm").val();
			var stok        = $("#jml_stok").val();
			var satuan      = $("#satuan").val();

			if ((batch.length>0) && (nama.length>0) && (expired.length>0) && (diterima.length>0))
			{
				$.ajax({
						type 	: "POST",
						url	 	: "simpan_vaksin.php",
						data 	: "batch="+batch+"&nama="+nama+"&jenis="+jenis+"&tgl_expired="+expired+"&tgl_diterima="+diterima+'&vvm='+vvm+'&jml_stok='+stok+'&satuan='+satuan,
						beforeSend:function(){
							$(".loading").show();
						},
						success	: function(html)
						{
							$(".loading").hide();
							$("#confirm").html(html);						
						}
				
				});
			
			}else{
				alert("Isikan Data Dengan Lengkap dan Benar");
			
			}
			

		});
	
	});
</script>
</head>
<?php
	include "../../conf/openconn.php";
 	
?>
<body>
<br><br> 
 <div class="loader"></div>
		<div id="form_container">	
		<h1>header</h1>
		<form id="form_898777" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>Data Vaksin</h2>
			<span>semua field mohon di isi</span>
		</div>						
		<ul >			
		<li id="li_1" >
		<label class="description" for="element_1">Kode Batch Vaksin * </label>
		<div>
			<input id="kodebatch" name="kodebatch" class="element text medium" type="text" maxlength="255" /> 
		</div> 
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Nama Vaksin *</label>
		<div>
			<input id="namavaksin" name="namavaksin" class="element text medium" type="text" maxlength="255" value=""/> 
		</div> 
		</li>		 		
		<li id="li_7" >
		<label class="description" for="element_7">Jenis Vaksin *</label>
		<div>
		<select class="element select small" id="jenisvaksin" name="jenisvaksin"> 
			<option value="" selected="selected">Pilih Satu</option>
			<?php
				$sqljenis = "Select id_jenis, nama from jenis_vaksin order by id_jenis ASC";
				$query		 = mysql_query($sqljenis);
				while ($outj=mysql_fetch_array($query))
					{
						$id			 =$outj['id_jenis'];
						$namajenis   =$outj['nama'];
						
						echo "<option value='$id'>$namajenis</option>";
						}	
			?>
		</select>
		</div> 
		</li>
		<li id="li_7" >
		<label class="description" for="element_7">VVM *</label>
		<div>
		<select class="element select small" id="vvm" name="vvm"> 
			<option value="A">A</option>
		    <option value="B">B</option>
			<option value="C">C</option>
			<option value="D">D</option>
		</select>
		</div> 
		</li>				
		<li id="li_6" >
		<label class="description" for="element_6">Tgl Diterima *</label>
		<div>
			<input id="tgl_diterima" name="tgl_diterima" class="element text medium" type="text" maxlength="255" value=""/> 
		</div> 
		</li>
		<li id="li_6" >
		<label class="description" for="element_6">Tgl Expired *</label>
		<div>
			<input id="tgl_expired" name="tgl_expired" class="element text medium" type="text" maxlength="255" value=""/> 
		</div> 
		</li>
		<li id="li_6" >
		<label class="description" for="element_6">Stok</label>
		<div>
			<input id="jml_stok" name="jml_stok" class="element text medium" type="text" maxlength="255" value=""/> 
		</div> 
		</li>
		<li id="li_7" >
		<label class="description" for="element_7">Satuan *</label>
		<div>
		<select class="element select small" id="satuan" name="vvm"> 
		<?php
		    $sat = "SELECT id, nama from satuan ORDER by id ASC";
			$qst = mysql_query($sat) or die (mysql_error());
			while($st=mysql_fetch_array($qst)){
				$id = $st['id'];
				$nm = $st['nama'];
				echo "<option value='$id'>$nm</option>";
			}?>
					     
		</select>
		</div> 
		</li>
			<li class="buttons">
			 <input type="hidden" name="form_id" value="898777" />
			    
		     <input id="simpandata" class="button_text" type="button" name="simpandata" value="Simpan Vaksin" />
		</li>
		
		<div id="confirm"></div>
			</ul>
		</form>	
	</div>
	</body>
</html>