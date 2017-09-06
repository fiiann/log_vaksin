<link rel="stylesheet" type="text/css" href="../css/adminview.css" media="all">
<script type="text/javascript">
		$(document).ready(function() {
		    $(".ui-dialog-buttonpane button:contains('Simpan Purchasing')").button("disable");
			
			
			$(".pilihobat").click(function()
			{
				var id=$(this).attr('id');	
				 		
			}).change(function(){				
				var id=$(this).attr('id');
			if ($("#cekobat_"+id).is(":checked"))
			{
				$(".ui-dialog-buttonpane button:contains('Simpan Purchasing')").button("enable");
				
				if ($("#qty_acc_"+id).val()>0)
				{
					$("#idorder_"+id).attr("checked","checked");
					$("#kodeobat_"+id).attr("checked","checked");					
					$("#qtyorder_"+id).attr("checked","checked");
					$("#qty_acc_"+id).attr("checked","checked");
					$("#satobat_"+id).attr("checked","checked");
					
				}else{
					$("#cekobat_"+id).attr("checked",false);
					$("#idorder_"+id).attr("checked",false);
					$("#kodeobat_"+id).attr("checked",false);					
					$("#qtyorder_"+id).attr("checked",false);
					$("#qty_acc_"+id).attr("checked",false);
					$("#satobat_"+id).attr("checked",false);
					
					alert("Pastikan Jumlah Disetujui bukan 0");
					$(".ui-dialog-buttonpane button:contains('Simpan Purchasing')").button("disable");							
				}
			}
			else if (!$("#cekobat_"+id).is(":checked"))
			{
					$(".ui-dialog-buttonpane button:contains('Simpan Purchasing')").button("disable");					
					$("#idorder_"+id).attr("checked",false);
					$("#kodeobat_"+id).attr("checked",false);										
					$("#qtyorder_"+id).attr("checked",false);
					$("#qty_acc_"+id).attr("checked",false);
					$("#satobat_"+id).attr("checked",false);
			}		
		
		});
			
			
			
			$("#boxpdf").dialog({
					autoOpen:false,
					width:850,
					height:'auto',
					title:'Convert Order to PDF', 
					position:'top',
					top:20, 
					modal:true, 
					buttons:{
						'Close' :function(){ 
							$(this).dialog('close');
						    }
						}
			});
			
			$(".jmlacc").click(function(){
				var id = $(this).attr('id');
			}).keyup(function(){
				var id 		= $(this).attr('id');
				var qtacc	= $("#qtyacc_"+id).val();
				$("#qty_acc_"+id).val(qtacc);
			});
			
		});
</script>

<?php
	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php"; 	
	
	
	if ($_POST['idorder']!='')
	{
		$idorder		= $_POST['idorder'];
		$idpuskesmas	= $_POST['idpuskesmas'];
		$tglorder		= $_POST['tglorder'];
		
		//get nama poli 
		$sqlpoli = "select nama_puskesmas from puskesmas where kode_puskesmas='".$idpuskesmas."'";
		$qrypoli = mysql_query($sqlpoli);
		while ($poli=mysql_fetch_array($qrypoli))
		{
			$namap = $poli['nama_puskesmas'];				
		}
		
		
		$tglorder   = tgl_indo ($_POST['tglorder']);
		
		$getdata = "select t.idorder
					,t.ket_order
					,d.idorder
					,d.kode_vaksin
					,d.jml_order
					,m.kode_vaksin
					,m.nama_vaksin
					,m.jml_stok
					,m.id_jenis
					,m.satuan
					,j.id_jenis
					,j.nama_jenis
					FROM trxvaksin t
					INNER JOIN trxvaksin_detil d
						on t.idorder=d.idorder
					INNER JOIN master_vaksin m
						on d.kode_vaksin=m.kode_vaksin
					INNER JOIN jenis_vaksin j	
						on m.id_jenis=j.id_jenis
					WHERE t.idorder='".$idorder."'";			
					
		$qrydata	= mysql_query($getdata);
		
		?>	
		<table class='list' width="100%" cellspacing="1" cellpadding="1" style='padding-left:10px;padding-right:10px;'>
		<tr class='top' bgcolor="#80B302" width="60%">
			<td rowspan="2" width="3%" align="center"><b>No.</b></td>
			<td rowspan="2" width="7%" align="center"><b>Kode Vaksin</b></td>
			<td rowspan="2" width="15%" align="center"><b>Nama Vaksin</b></td>
			<td rowspan="2" width="8%" align="center"><b>Jenis Vaksin</b></td>
			<td colspan="2" width="8%" align="center"><b>Qty</b></td>
			<td rowspan="2" width="8%" align="center"><b>Satuan</b></td>	
			<td rowspan="2" width="5%" align="center"><b>Pilih</b></td>	
		</tr>
		<tr class='top' bgcolor="#80B302" width="60%">
			<td width="3%" align="center">Order</td>
			<td width="3%" align="center">Dipenuhi</td>			
		</tr>
	<?php	
		while ($data = mysql_fetch_array($qrydata))
		{
			$no++;
			$kodeobat  = $data['kode_vaksin'];
			$namaobat  = $data['nama_vaksin'];
			$qtyorder  = $data['jml_order'];
			$jenisobat = $data['nama_jenis'];
			$satuan	   = $data['satuan'];
			$ketorder  = $data['ket_order'];
			
			echo "<tr class='row' bgcolor='#D7ED9F'>";
			echo "<td align='right'>$no.
				  <input type='checkbox' name='idorder[]' id='idorder_$kodeobat' value=$idorder style='display:none'>	
				  </td>";
			echo "<td>
				   $kodeobat
				   <input type='checkbox' name='kodeobat[]' id='kodeobat_$kodeobat' value=$kodeobat style='display:none'>				
				 </td>";
			echo "<td align='left'>&nbsp;
				   $namaobat
				  </td>";
			echo "<td>&nbsp;$jenisobat</td>";			
			echo "<td align='right'>
					$qtyorder				 
					&nbsp;
					<input type='checkbox' name='qtyorder[]' id='qtyorder_$kodeobat' value=$qtyorder style='display:none'>
				  </td>";
			echo "<td align='center' class='jmlacc' id='$kodeobat'>
				  <input type='text' name='qtyacc[]' id='qtyacc_$kodeobat' size='5' value=$qtyorder style='text-align:right'>
				  <input type='checkbox' name='qty_acc[]' id='qty_acc_$kodeobat' value=$qtyorder style='display:none'>				  
				  </td>";		
			echo "<td align='left'>&nbsp;
				  $satuan
				  <input type='checkbox' name='satuanobat[]' id='satobat_$kodeobat' value=$satuan style='display:none'>				  				  
				  </td>";
			echo "<td align='center' class='pilihobat' id='$kodeobat'><input type='checkbox' name='cekobat[]' id='cekobat_$kodeobat' value=$kodeobat></td>";
			echo "</tr>";
		}	
		echo "</table>";
	}
?>
<div id="boxpdf" style="float:center">
	<div id="content" ></div>
</div>