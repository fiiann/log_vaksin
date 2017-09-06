<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Report Stok Obat</title>
<link rel="stylesheet" type="text/css" href="../css/adminview.css" media="all">
<script type="text/javascript" src="../js/adminview.js"></script>
<script type="text/javascript" src="../../js/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../../js/jquery/jquery-ui-1.9.2.custom.min.js"></script>
<link type="text/css" href="../../css/jquery-ui.css" rel="stylesheet"/>
<script type="text/javascript">
	$(document).ready(function() {
		 	
		$(function() {	
		$("#from_tgl").datepicker();	 
		$("#from_tgl").change(function() {
             $("#from_tgl").datepicker("option", "dateFormat","yy-mm-dd");
			}); 
		});
	
		$(function() {	
		$("#to_tgl").datepicker();	 
		$("#to_tgl").change(function() {
             $("#to_tgl").datepicker("option", "dateFormat","yy-mm-dd");
			}); 
		});	
		
		$(function() {	
		$("#fromtgl").datepicker();	 
		$("#fromtgl").change(function() {
             $("#fromtgl").datepicker("option", "dateFormat","yy-mm-dd");
			}); 
		});
	
		$(function() {	
		$("#totgl").datepicker();	 
		$("#totgl").change(function() {
             $("#totgl").datepicker("option", "dateFormat","yy-mm-dd");
			}); 
		});	
		
			
		$("#boxreport").dialog({
					autoOpen:false,
					width:850,
					height:600,
					title:'View Report Data Obat Masuk', 
					top:20, 
					modal:true, 
					buttons:{
						'Close' :function(){ 
							$(this).dialog('close');
						    }
						}
		});
		 
		 
		 $("#view1").click(function(){
				var jenisobat = $("#jenisobat").val();
				var fromtgl	  = $("#from_tgl").val();
				var totgl	  = $("#to_tgl").val();
				
				if ((jenisobat.length>0) && (fromtgl.length>0) && (totgl.length>0))
				{	
					$.ajax({
						type:"POST",
						 url :"viewreport_in.php",
						 cache:false,
						 data :"jenis="+jenisobat+"&fromtgl="+fromtgl+"&totgl="+totgl,
						 success : function(html){
								$("#boxreport").dialog('open');
								$("#result").html(html);
						 }				
				});	
				}else{
					alert("Anda Belum menentukan pilihan atau Tanggal Periode");
				}	
		 });
		 
		$("#view2").click(function(){
				var jenis_obat = $("#jenis_obat").val();
				var from_tgl  = $("#fromtgl").val();
				var to_tgl	  = $("#totgl").val();
				
				if ((jenis_obat.length>0) && (from_tgl.length>0) && (to_tgl.length>0))
				{	
					$.ajax({
						type:"POST",
						 url :"viewreport_out.php",
						 cache:false,
						 data :"jenis_obat="+jenis_obat+"&from_tgl="+from_tgl+"&to_tgl="+to_tgl,
						 success : function(html){
								$("#boxreport").dialog('open');
								$("#result").html(html);
						 }				
				});	
				}else{
					alert("Anda Belum menentukan pilihan atau Tanggal Periode");
				}	
		 });
		 
		 
		  $("#view3").click(function(){
			var jenis_o 	= $("#jenis_o").val();
			var satuan		= $("#satuanobat").val();
			
			if ((jenis_o.length>0) && (satuan.length>0))	
				{
					$.ajax({
						 type:"POST",
						 url :"viewreport_stok.php",
						 cache:false,
						 data :"jenis="+jenis_o+"&satuan="+satuan,
						 success : function(html){
								$("#boxreport").dialog('open');
								$("#result").html(html);
						 }				
					});	
				}else{
					alert("Tentukan Jenis Obat dan Satuan");
				}
		 });
		 
		 
	 });
</script>

</head>
<body id="main_body" >
<?php
	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php"; 	
	
	 
?>	
	<div id="form_container">
	
		<h1><a>Laporan Obat</a></h1>
		<div class="form_description">
			<h2>&nbsp;&nbsp;Laporan Obat</h2>
		</div>		
		<table width="100%" style='padding-left:12px' border="0">
		<tr>
			<td><b>Laporan Data Obat Masuk</b></td>
		</tr>
		<tr> 
			<td>Jenis Obat : <select name="jenisobat" id="jenisobat">
				<option value="" selected="selected">Pilih Satu</option>
				<option value='All'>Semua Jenis</option>
			<?php
				$sqljenis = "Select * from jenisobat order by idjenis";
				$query		 = mysql_query($sqljenis);
				while ($outj=mysql_fetch_array($query))
					{
						$id			 =$outj['idjenis'];
						$namajenis   =$outj['namajenis'];
						
						echo "<option value='$id'>$namajenis</option>";
						}	
			?>
				</select> 
				
				&nbsp;&nbsp;&nbsp; Dari Tanggal : <input type="text" name="from_tgl" id="from_tgl" size="12">
				&nbsp;&nbsp; s/d : <input type="text" name="to_tgl" id="to_tgl" size="12">
				<br><br>
				<span style='padding-left:70px;'><input type="button" name="view1" id="view1" value="Tampilkan Laporan"></span>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>		
		<tr>
			<td><hr size="1" width="100%"></td>
		</tr>	
		<tr>
			<td><b>Laporan Data Obat Keluar</b></td>
		</tr>
		<tr> 
			<td>Jenis Obat : <select name="jenis_obat" id="jenis_obat">
				<option value="" selected="selected">Pilih Satu</option>
				<option value='All'>Semua Jenis</option>
			<?php
				$sqljenis = "Select * from jenisobat order by idjenis";
				$query		 = mysql_query($sqljenis);
				while ($outj=mysql_fetch_array($query))
					{
						$id			 =$outj['idjenis'];
						$namajenis   =$outj['namajenis'];
						
						echo "<option value='$id'>$namajenis</option>";
						}	
			?>
				</select> 
				
				&nbsp;&nbsp;&nbsp; Dari Tanggal : <input type="text" name="fromtgl" id="fromtgl" size="12">
				&nbsp;&nbsp; s/d : <input type="text" name="totgl" id="totgl" size="12">
				<br><br>
				<span style='padding-left:70px;'><input type="button" name="view2" id="view2" value="Tampilkan Laporan"></span>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><hr size="1" width="100%"></td>
		</tr>
		<tr>
			<td><b>Laporan Stok Obat Berdasarkan Jenis Obat dan Satuan</b></td>
		</tr>
		<tr> 
			<td>Jenis Obat : <select name="jenis_o" id="jenis_o">
				<option value="" selected="selected">Pilih Satu</option>
			<?php
				$sqljenis = "Select * from jenisobat order by idjenis";
				$query		 = mysql_query($sqljenis);
				while ($outj=mysql_fetch_array($query))
					{
						$id			 =$outj['idjenis'];
						$namajenis   =$outj['namajenis'];
						
						echo "<option value='$id'>$namajenis</option>";
						}	
			?>
				</select>&nbsp;&nbsp;&nbsp;
				Satuan : <select name="satuanobat" id="satuanobat">
				<option value="" selected="selected">Pilih Satu</option>
				<?php
					$sqlsat 	= "Select Distinct(satuan) from master_obat order by kodeobat";
					$querysat	= mysql_query($sqlsat);
					while ($outs=mysql_fetch_array($querysat))
						{
							$nama	   =$outs['satuan'];						
							echo "<option value='$nama'>$nama</option>";
						}	
				?>
				</select>
				&nbsp;&nbsp;&nbsp;<input type="button" name="view3" id="view3" value="Tampilkan Laporan">
			</td>
		</tr>		
		</table>
		<div id="boxreport">
			<div id="result"></div>
		</div>
		<div id="hasil"></div>
		<br><br><br><br>
	 
	</div>
	 
	</body>
</html>