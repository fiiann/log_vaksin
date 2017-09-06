<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Transaksi Vaksin</title>
<script type="text/javascript" src="../../js/view.js"></script>
<link rel="stylesheet" type="text/css" href="../../css/view.css" media="all"> 
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet"/>

<style>
#navcontainer ul
{
margin: 0;
width:420px;
padding: 10px 5px 10px;
list-style-type: none;
text-align: center;

}

#navcontainer ul li { display: inline; }

#navcontainer ul li a
{
text-decoration: none;
padding: .2em 1em;
color: #000;
background-color: #c0c0c0;
}

#navcontainer ul li a:hover
{
color: #fff;
background-color: #378503;
}

.ui-widget-overlay.custom-overlay
{
    background-color: black;
    background-image: none;
    opacity: 0.9;
    z-index: 1040;    
}
</style>

<script type="text/javascript">
	 $(function() {
	
		$("#tgl_order").datepicker();
		 
		$("#tgl_order").change(function() {
             $("#tgl_order").datepicker("option", "dateFormat","yy-mm-dd");
			}); 
		});
		
		
	$(document).ready(function() {
	
		
		$("#ketorder").attr('disabled',false);
		$("input[type='button']").attr('disabled',false);
		
		var tombol		= $('<br><span id="space">&nbsp;&nbsp;</span><input type="button" name="TbSimpan" id="TbSimpan" value="Simpan Data">&nbsp;');

	    var tabel_trx   = $('<span id="space">&nbsp;&nbsp;</span><b>DATA VAKSIN :</b><br><table id="add_barang" align="center" bgcolor="#F2F2F2" width="98%" cellpadding="1" style="border:0.5px;"><tr bgcolor="#CFCEC8"><td width="10%">&nbsp;<b>Kode Obat</b></td><td>&nbsp;<b>Nama Vaksin</b></td><td align="center"><b>Jenis Vaksin</b></td><td align="center"><b>Stok Obat</b></td><td align="center"><b>Jml Order</b></td><td align="center"><b>Satuan</b></td><td align="center"><b>Hapus</b></td></tr></table>');
		 
		$("#tabelorder").html(tabel_trx);
		$("#tombolorder").html(tombol);
		$("#tabelorder").hide();
		$("#tombolorder").hide();
	
		$("#cetakorder").attr('disabled',true);

		$("#TbSimpan").click(function(){
			var idorder		= $("#newid").val();
			var tglorder	= $("#tgl_order").val();
			var ketorder	= $("#ketorder").val();
			
			if (tglorder.length>0)			
			{			
				$.ajax({
						type :"POST",
						url	 :"simpantrm_vaksin.php",
						cache:false,
						data :"idorder="+idorder+"&tglorder="+tglorder+"&ketorder="+ketorder,
						success : function(html){
							$("#confirmsave").html(html);	
							$("input[type='button']").attr('disabled',true);
							$("input[type='text']").attr('disabled',true);
							$("#ketorder").attr('disabled',true);
							$("#cetakorder").attr('disabled',false);	
						}
				
				});
		
			}else{
				alert("Kolom Tanggal Order tidak boleh kosong..!");			
			}
		});
		
		function addlistvaksin()
		{
			var idtrx  		   = $("#newid").val();
			
			var kodevaksin = [];
			var namavaksin = [];
			var jenis	 = [];
			var stok	 = [];
			var satuan   = [];
			var jmlorder = [];
		 
	
			$("input[name='kodevaksin[]']:checked").each(function(){
				kodevaksin.push($(this).val());			
			});
			
			$("input[name='namavaksin[]']:checked").each(function(){
				namavaksin.push($(this).val());			
			});
						
			$("input[name='jenis[]']:checked").each(function(){
				jenis.push($(this).val());			
			});
			
			$("input[name='jmlstok[]']:checked").each(function(){
				stok.push($(this).val());			
			});
			
			$("input[name='satuan[]']:checked").each(function(){
				satuan.push($(this).val());			
			});
			
			$("input[name='qtyordercek[]']:checked").each(function(){
				jmlorder.push($(this).val());				
			});
			
			
			
			var is_order = 0;
			var jmlbarang = kodevaksin.length;
			if (jmlbarang!=0)
			{
				for (j=0;j<jmlbarang;j++)
				{
					$('#add_barang').append('<tr bgcolor="#ffffff" class="listorder" id="listobat_'+kodevaksin[j]+'"><td width="10%">'+ kodevaksin[j] +'</td><td width="25%">'+namavaksin[j]+'</td><td>'+jenis[j]+'</td><td align="right"><input type="hidden" name="qtystock[]" id="qtystok_'+kodevaksin[j]+'" value="'+stok[j]+'">'+stok[j]+'</td><td align="center"><input type="text" name="qtyorder[]" id="qtyorder_'+kodevaksin[j]+'" value='+jmlorder[j]+' size="4" disabled style="text-align:right"></td><td>'+satuan[j]+'</td><td align="center"><input type="button" class="del" id='+kodevaksin[j]+' value="X"></td></tr>');		
								
					$("#tabelorder").show();
					$("#tombolorder").show();
					
				}
					//auto simpan  pada tabel transaksi obat
					   $.ajax({
						type 	: "POST",
						url  	: "savetrm_temp.php",
						cache	: false,
						data 	: "idorder="+idtrx+"&kodevaksin="+kodevaksin+"&is_order="+is_order+"&jmlstok="+stok+"&jmlorder="+jmlorder+"&satuan="+satuan,
						success : function(html){
								$("#confirm").html(html);								
							}
		  
						});
						
				
			}else{
					
			}			
		}		


		
			$("#dialog").dialog({
					autoOpen:false,
					width:900,
					height:550,
					title:'Data Vaksin', 
					top:100, 
					modal:true, 
					buttons:{
						'Pilih Vaksin' : function(){
							addlistvaksin();
							$(this).dialog('close');
						},
						'Close' :function(){ 
							$(this).dialog('close');
						    }
						}
			});
	
	
			$(".del").live('click',function(){
				var kodevaksin 	= $(this).attr('id');
				var idorder		= $("#newid").val(); 
				var qorder		= $("#qtyorder_"+kodevaksin).val();
		 	
				var jmlrow=0;
				var hitcount=0;
			
				//hapus dari database sesuai kodeobat			
				$.ajax({
						type 	: "POST",
						url  	: "hapus_terima.php",
						cache	: false,
						data 	: "idorder="+idorder+"&kodevaksin="+kodevaksin+"&qorder="+qorder,
						success : function(html){
								$("#confirm").html(html);								
								$("#confirm").fadeOut(2500);						
							}
			
				});	
				
			
			var jmlrow = $(".listorder").length;
			hitcount+=1	;
			
			$("#listobat_"+kodevaksin).remove();	
			if (hitcount==jmlrow)
			{
				 $("#tabelorder").hide();
				 $("#tombolorder").hide();
			}
			 
			 	
		});
		
	function load_data_vaksin()
		{
			var puskesmas 	 = $("#puskesmas").val();
			var idpuskesmas  = $("#kode_puskesmas").val();
			
			$.ajax({
					type 	: "POST",
					url	 	: "data_vaksin_terima.php",
					data 	: "puskesmas="+puskesmas+"&idpuskesmas="+idpuskesmas,
					success	: function(html){			
					
							$("#dialog").dialog("open");
							$("#daftarobat").html(html);
									
					}	
			});			
			
		}	
		 
	$("#addvaksin").click(function(){
			$("#dialog").dialog('open');
			load_data_vaksin();
		})	
		
		$(function() {
				$( "input[type=button]")
				.button()
				.click(function( event ) {
				event.preventDefault();
				});
			});	
	  
		$(function() {
			$( "#tabs" ).tabs({
			collapsible: true
			});
		});
	
	});

</script>
</head>
<body>
<br>
<?php
	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php"; 		 
 ?>		

		<div id="listview_container">			 	
				<div class="form_description" style="padding:0 20px">		 
				<img src="../../images/order-med.png" style="padding:5px"><span id="head" style="font-family:trebuchet ms;font-size:25px;font-weight:bold">Penerimaan Vaksin dari Provinsi</span><div id="navcontainer">
 
		</div>
		<br>
		</div>
		<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Form Order</a></li> 
		</ul>
		<div id="tabs-1">		
	    <table width="100%" cellpadding="4" border="0">
		<tr>
			<td><b>&nbsp;ID Penerimaan</b></td>
			<td>:  
				  <input type="text" name="newid" id="newid" class="element text small"  value="<?php echo kdauto('trxterima','TRM-')?>" readonly style="border:1px solid">
			</td>						
			<td>&nbsp;</td>
			<td></td>				
		</tr>
		<tr>
			<td>&nbsp;<b>Tanggal Penerimaan</b></td>
			<td>: <input type="text" name="tgl_order" id="tgl_order" class="element text small" size="12" style="border:1px solid"></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>				
		</tr>
		<tr>
			<td>&nbsp;<b>Keterangan</b></td>
			<td colspan="3">: <textarea name="ketorder" id="ketorder" cols="69" rows="1" style="border:1px solid"></textarea></td>
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;&nbsp;<input type="button" name="addvaksin" id="addvaksin" value="Pilih Vaksin"></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>				
		</tr>		
		</table>	
		<br><br>
		<div id="tabelorder"></div>
		<div id="tombolorder"></div>
		<div id="dialog">
			<div id="daftarobat"></div>
		</div>
		<div id="confirm"></div>
		<br><br>
		<div id="confirmsave" style='font-weight:bold;color:green'></div>
		<p><p><p><p>
		<br><br><br><br><br><br>
		<br><br>
		<div id="delconfirm"></div>	 
		</div>
</div>	
	</body>
</html>