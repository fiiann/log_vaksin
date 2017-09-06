<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Edit Data Obat</title>
<link rel="stylesheet" type="text/css" href="../css/adminview.css" media="all">
<script type="text/javascript" src="../js/adminview.js"></script>
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet"/>
 
<script type="text/javascript">
	  $(function() {
		$("#exp").datepicker();	 
		$("#exp").change(function() {
             $("#exp").datepicker("option","dateFormat","dd-mm-yy");
		   }); 	
		});
		
	$(function() {
		$("#tgl_diterima").datepicker();	 
		$("#tgl_diterima").change(function() {
             $("#tgl_diterima").datepicker("option","dateFormat","dd-mm-yy");
		   }); 	
		});
	
	$(document).ready(function(){
				
		$("#updatedata").click(function(){
			var kode_batch	= $("#kode_batch").val();
			var nama_vaksin	= $("#nama_vaksin").val();
			var jenis		= $("#jenis_vaksin").val();
			var tgl_diterima= $("#tgl_diterima").val();
			var vvm         = $("#vvm").val();
			var expdate		= $("#exp").val();
			var stok        = $("#jml_stok").val();
			var satuan      = $("#satuan").val();

			if (kode_batch.length>0) 
			{
				
				$.ajax({
						type 	: "POST",
						url	 	: "update_vaksin.php",
						data 	: "kode_batch="+kode_batch+"&nama_vaksin="+nama_vaksin+"&jenis_vaksin="+jenis+"&expdate="+expdate+"&tgl_diterima="+tgl_diterima+'&vvm='+vvm+'&jml_stok='+stok+'&satuan='+satuan,
						success	: function(html)
						{
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
	include "../../lib/functions-php.php";
	
	$kode_batch = $_GET['kode_batch'];
	
	$sqlupdate = "select * from master_vaksin where kode_batch='".$kode_batch."'";
	$qryupdate = mysql_query($sqlupdate);
	while ($hsl = mysql_fetch_array($qryupdate))
	{
		$kode_batch      = $hsl['kode_batch'];
		$nama_vaksin 	 = $hsl['nama'];
		$jenis	  		 = $hsl['id_jenis'];
		$vvm             = $hsl['vvm'];
		$expdate  		 = tgl_eng_to_ind($hsl['tgl_expired']);	
		$tglterima  	 = tgl_eng_to_ind($hsl['tgl_terima']);
		$jmlstok         = $hsl['stok'];
		$satuan          = $hsl['id_satuan'];
	}
 	
?>


<body id="main_body" >
	
	<img id="top" src="../../images/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Edit Data Vaksin</a></h1>
		<form id="form_898777" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>Edit Data Vaksin</h2>
			<p>isi data Vaksin dengan lengkap dan benar, <font color="red">(*)Field Harus Diisi</font></p>
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">Kode Batch * </label>
		<div>
			<input id="kode_batch" name="kode_batch" class="element text small" type="text" maxlength="255" value="<?php echo $kode_batch;?>" readonly /> 
		</div> 
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Nama Vaksin *</label>
		<div>
			<input id="nama_vaksin" name="nama_vaksin" class="element text medium" type="text" maxlength="255" value="<?php echo $nama_vaksin;?>"/> 
		</div> 
		</li>		
		<li id="li_7" >
		<label class="description" for="element_7">Jenis Vaksin *</label>
		<div>
		<select class="element select small" id="jenis_vaksin" name="jenis_vaksin"> 
			<?php
				$sqljenis = "Select * from jenis_vaksin order by id_jenis";
				$query		 = mysql_query($sqljenis);
				while ($outj=mysql_fetch_array($query))
					{
						$idj		 =$outj['id_jenis'];
						$namajenis   =$outj['nama'];
						
					//	echo "<option value='$id'>$namajenis</option>";
						echo $jenis;
						?>
						
						<option value='<?php echo $idj?>' <?php echo ($outj['id_jenis']==$jenis)?"selected":""; ?>><?php echo $namajenis?></option>
						
						
						<?php
						}	
			?>
		</select>
		</div> 
		</li>		
		<li id="li_7" >
		<label class="description" for="element_7">VVM *</label>
		<div>
		<select class="element select small" id="vvm" name="vvm"> 
						 
			<option value="A" <?php echo ($vvm=="A")?"selected":""; ?>>A</option>
			<option value="B" <?php echo ($vvm=="B")?"selected":""; ?>>B</option>
            <option value="C" <?php echo ($vvm=="C")?"selected":""; ?>>C</option>
			<option value="D" <?php echo ($vvm=="D")?"selected":""; ?>>D</option>							 			 
		</select>
		</div> 
		</li>
	 
		<li id="li_6" >
		<label class="description" for="element_6">Tgl diterima *</label>
		<div>
			<input id="tgl_diterima" name="tgl_diterima" class="element text small" type="text" maxlength="255" value="<?php echo $tglterima; ?>"/> 
		</div> 
		</li>			
		<li id="li_6" >
		<label class="description" for="element_6">Tgl Expired *</label>
		<div>
			<input id="exp" name="exp" class="element text small" type="text" maxlength="255" value="<?php echo $expdate; ?>"/> 
		</div> 
		</li>	
		<li id="li_6" >
		<label class="description" for="element_6">Jumlah Stok *</label>
		<div>
			<input id="jml_stok" name="jml_stok" class="element text small" type="text" maxlength="255" value="<?php echo $jmlstok; ?>"/> 
		</div> 
		</li>
		<li id="li_6" >
		<label class="description" for="element_6">Jumlah Stok *</label>
		<div>
		<select class="element select small" id="satuan" name="satuan"> 
		<?php
		    $sat = "SELECT id, nama from satuan ORDER by id ASC";
			$qst = mysql_query($sat) or die (mysql_error());
			while($st=mysql_fetch_array($qst)){
				$idsat = $st['id'];
				$nmsat = $st['nama'];

				if ($idsat==$satuan){
					$sel = 'selected';
				}else{
					$sel = '';
				}
				echo "<option $sel value>$nmsat</option>";
			}?>
					     
		</select>
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
	<img id="bottom" src="../../images/bottom.png" alt="">
	</body>
</html>