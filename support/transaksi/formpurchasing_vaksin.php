<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Form Purchasing</title>
<link rel="stylesheet" type="text/css" href="../css/adminview.css" media="all">
<script type="text/javascript" src="../js/adminview.js"></script>
<script type="text/javascript">	
	 $(function() {	
		$("#tglpurchasing").datepicker();	 
		$("#tglpurchasing").change(function() {
             $("#tglpurchasing").datepicker("option", "dateFormat","yy-mm-dd");
			}); 
		});

	$(document).ready(function() {	
		function load_detilorder()
		{
			var idorder 	= $("#idorder").val();
			var idpusk	 	= $("#idpuskesmas").val();
			var tglorder	= $("#tglorder").val();
 			$.ajax({
					type  :"POST",
					url   :"loadorder.php",
					cache : false,
					data  : "idorder="+idorder+"&tglorder="+tglorder+"&idpuskesmas="+idpuskesmas,
					success : function(html){
						$("#detil").html(html);					
					}

			});	
		}
		
		load_detilorder();		
		
		$(".del").live('click',function(){
			var kodeobat 	= $(this).attr('id');
			var idorder		= $("#newid").val(); 
			var qorder		= $("#qtyorder_"+kodeobat).val();
		 	
			var jmlrow=0;
			var hitcount=0;
			
			//hapus dari database sesuai kodeobat			
			$.ajax({
						type 	: "POST",
						url  	: "hapustrx.php",
						cache	: false,
						data 	: "idorder="+idorder+"&kodeobat="+kodeobat+"&qorder="+qorder,
						success : function(html){
								$("#confirm").html(html);								
								$("#confirm").fadeOut(2500);																
							}			
				});	
				
			
			var jmlrow = $(".listorder").length;
			hitcount+=1	;
			
			$("#listobat_"+kodeobat).remove();	
			if (hitcount==jmlrow)
			{
				 $("#tabelorder").hide();
				 $("#tombolorder").hide();
			}
			//$(this).parent().parent().remove();	
			 	
		});
		
		
		$("#dialog").dialog({
					autoOpen:false,
					width:900,
					height:550,
					title:'Silahkan Pilih Obat dari Daftar Obat Berikut ini', 
					top:100, 
					modal:true, 
					buttons:{
						'Add Obat' : function(){
							addlistobat();
							$(this).dialog('close');
						},
						'Close' :function(){ 
							$(this).dialog('close');
						    }
						}
		});
	
	
		$("#addobat").click(function(){
			$("#dialog").dialog('open');
			load_data_obat();
		});
		
	});

</script>
</head>
<body bgcolor="white">
<?php
	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php"; 	
	
	$kode	 = $_POST['idpuskesmas'];
	$idp	 = date("ymd");
	$getp 	 = "select kode_puskesmas, nama_puskesmas from puskesmas where kode_puskesmas='".$kode."'";
	$qryp 	 = mysql_query($getp);
	while ($nm=mysql_fetch_array($qryp))
	{
		$namap  = $nm['nama_puskesmas'];	
		$idps   = $nm['kode_puskesmas'];
	}
 ?>		 		
		<table class='form' width="100%" cellpadding="4" border="0" style='text-align:left'>
		<tr>
			<td>&nbsp;ID Proses</td>
			<td>: <input type="text" name="idpurchasing" id="idpurchasing" class="element text medium" size="15" value="<?php echo kdauto('purchasing','P'.$idp)?>" disabled>
			</td>	
					
			<td>&nbsp;Nama Puskesmas</td>
			<td>: <input type="text" name="nmpuskesmas" id="nmpuskesmas" class="element text" size="15" value="<?php echo $namap;?>" disabled>
				  <input type="hidden" name="idpuskesmas" id="idpuskesmas" size="10" value="<?php echo $idps;?>">
			</td>				
		</tr>
		<tr>
			<td>&nbsp;Tanggal Proses</td>
			<td>: <input type="text" name="tglpurchasing" id="tglpurchasing" class="element text medium" size="15"></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>				
		</tr>
		<tr>
			<td>&nbsp;Keterangan</td>
			<td colspan="3">: <textarea name="ketorder" id="ketorder" cols="75" rows="1"></textarea></td>
		</tr>	
		</table>	
		<div id="detil"></div>
		<div id="confirm"></div>
		<br><br>
		<div id="confirmsave" style='font-weight:bold;color:green'></div>
		<p><p><p><p>		
		<div id="delconfirm"></div>
	</body>
</html>