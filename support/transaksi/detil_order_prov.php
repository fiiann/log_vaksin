<style>
.head,.keterangan {font-size:12px;text-align:left;} 
.row:hover{font-size:12px;background:#F5BC00}
.row{font-size:12px;}
.top {font-size:12px;font-weight:bold;color:white}
#text{font-weight:normal;color:black;padding-left:5px;}
</style>
<script type="text/javascript">
		$(document).ready(function() {
			$("#TbPDF").click(function(){
				var idorder	 = $("#idorder").val();
				var tglorder = $("#tglorder").val();
				var idpus	 = $("#idpuskesmas").val();
			
			$.post("../transaksi/print_pdforder.php",{idorder:idorder, tglorder:tglorder, idpuskesmas:idpus},function(result)
				{
					$("#boxpdf").dialog('open');
					$("#content").html(result);					 
					});
			});
			
				 
		 
			
			
		
			
		});
</script>

<?php
	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php"; 	
	
	
	if ($_POST['idorder']!='')
	{
		$idorder	= $_POST['idorder'];
		$tglorder	= $_POST['tglorder'];
				
		$tglorder   = tgl_indo ($_POST['tglorder']);
		
		?>
			
		<table class="head" width="100%" cellpadding="4" border="0">
		<tr>
			<td width="12%">&nbsp;<b>ID Order</b></td>
			<td width="35%">: <?php echo $idorder;?><input type="hidden" id="idorder" value="<?php echo $idorder;?>"></td>	
			<td width="12%">&nbsp;</td>
			<td width="35%"></td>				
		</tr>
		<tr>
			<td>&nbsp;<b>Tanggal Order</b></td>
			<td>: <?php echo $tglorder;?><input type="hidden" id="tglorder" value="<?php echo $tglorder;?>"></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>				
		</tr>
		</table>	
<?php		
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
					FROM trxprov t
					INNER JOIN trxprov_detil d
						on t.idorder=d.idorder
					INNER JOIN master_vaksin m
						on d.kode_vaksin=m.kode_vaksin
					INNER JOIN jenis_vaksin j	
						on m.id_jenis=j.id_jenis
					WHERE t.idorder='".$idorder."'";			
					
		$qrydata	= mysql_query($getdata);
		
		?>
		
		
		<table class='list' width="100%" cellspacing="2" cellpadding="2" style='padding-left:10px;'>
		<tr class='top' bgcolor="#80B302" width="60%">
			<td width="4%" align="center"><b>No.</b></td>
			<td width="10%" align="center"><b>Kode Vaksin</b></td>
			<td width="30%" align="center"><b>Nama Vaksin</b></td>
			<td width="10%" align="center"><b>Jenis Vaksin</b></td>
			<td width="10%" align="center"><b>Jml Order</b></td>
			<td width="10%" align="center"><b>Satuan</b></td>				
		</tr>
		
	<?php	
		while ($data = mysql_fetch_array($qrydata))
		{
			$no++;
			$kodevaksin  = $data['kode_vaksin'];
			$namavaksin  = $data['nama_vaksin'];
			$qtyorder  	 = $data['jml_order'];
			$jenisvaksin = $data['nama_jenis'];
			$satuan	     = $data['satuan'];
			$ketorder    = $data['ket_order'];
			
			echo "<tr class='row' bgcolor='#D7ED9F'>";
			echo "<td align='right'>$no.</td>";
			echo "<td>
				   $kodevaksin
				 </td>";
			echo "<td align='left'>&nbsp;
				   $namavaksin
				  </td>";
			echo "<td>&nbsp;$jenisvaksin</td>";			
			echo "<td align='right'>&nbsp;
					$qtyorder
				 
				 </td>";	
			echo "<td align='left'>&nbsp;$satuan</td>";
			echo "</tr>";
		}	
		echo "</table>";
		echo "<table class='keterangan' width='100%' style='padding-left:10px;'>";
		echo "<tr>";
		echo "<td width='20%'><b>Keterangan Order :</b></td>";
		echo "<td width='35%' align='left'>&nbsp;</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td colspan='2' valign='top'>";
				$ket_order = explode(", ",$ketorder);
				$count = count($ket_order);
				for ($i=0;$i<$count;$i++)
				{
					echo "+&nbsp;".$ket_order[$i]."<br>";				
				}
				
		echo "</td>";
		echo "</tr>";		
		echo "</table>";
	}
?>
