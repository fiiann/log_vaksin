<style>
.atas,.keterangan {text-align:left;} 
.row:hover{background:#ccc}
.top {font-weight:bold;color:white}
#text{font-weight:normal;color:black;padding-left:5px;}
hr.style-three { border: 0; border-bottom: 0.8px dashed #ccc; background: #999; }
</style>
<script type="text/javascript">
		$(document).ready(function() {
			$("#TbPDF").click(function(){
				var idorder	 = $("#idorder").val();
				var tglorder = $("#tgl_terima").val();
			
			$.post("../transaksi/print_pdfterima.php",{idterima:idorder, tglterima:tglorder},function(result)
				{
					$("#boxpdf").dialog('open');
					$("#content").html(result);					 
					});
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
			
		});
</script>

<?php
	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php"; 	
	
	
	if ($_POST['idterima']!='')
	{
		$idterima	= $_POST['idterima'];
		$tglterima	= $_POST['tglterima'];
		
		//get nama poli 
				
		$tglorder   = tgl_indo ($_POST['tglterima']);
		
		$getdata = "select t.idterima
					,t.keterangan
					,d.idterima
					,d.kode_vaksin
					,d.jml_order
					,m.kode_vaksin
					,m.nama_vaksin
					,m.jml_stok
					,m.id_jenis
					,m.satuan
					,j.id_jenis
					,j.nama_jenis
					FROM trxterima t
					INNER JOIN trxterima_detil d
						on t.idterima=d.idterima
					INNER JOIN master_vaksin m
						on d.kode_vaksin=m.kode_vaksin
					INNER JOIN jenis_vaksin j	
						on m.id_jenis=j.id_jenis
					WHERE t.idterima='".$idterima."'";			
					
		$qrydata	= mysql_query($getdata);
		
		?>
		<table class="atas" width="100%" cellpadding="4" border="0">
		<tr>
			<td width="25%">&nbsp;<b>ID Terima</b></td>
			<td width="35%">: <?php echo $idterima;?><input type="hidden" id="idorder" value="<?php echo $idterima;?>"></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>				
		</tr>
		<tr>
			<td width="25%">&nbsp;<b>Tanggal Terima</b></td>
			<td width="35%">: <?php echo $tglterima;?><input type="hidden" id="tgl_terima" value="<?php echo $tglterima;?>"></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>				
		</tr>
		</table>
		<br>
		<table class='top' width="100%" cellspacing="2" cellpadding="2" border="0">
		<tr>
			<td id='text' width="25%" align='left'>&nbsp;DETIL PENERIMAAN :</td>
			<td width="50%">&nbsp;</td>
			<td width="20%" align='right'><input type="button" name="TbPDF" id="TbPDF" value="Cetak PDF"></td>
		</tr>
		</table>	
		<table class='list' width="100%" cellspacing="2" cellpadding="2" style='padding-left:10px'>
		<tr class='top' bgcolor="#473D0F" width="60%">
			<td width="4%" align="center"><b>No.</b></td>
			<td width="15%" align="center"><b>Kode Vaksin</b></td>
			<td width="30%" align="center"><b>Nama Vaksin</b></td>
			<td width="15%" align="center"><b>Jenis Vaksin</b></td>
			<td width="10%" align="center"><b>Jml Terima</b></td>
			<td width="10%" align="center"><b>Satuan</b></td>	
			
		</tr>
		
		
	<?php	
		while ($data = mysql_fetch_array($qrydata))
		{
			$no++;
			$kodevaksin  = $data['kode_vaksin'];
			$namavaksin  = $data['nama_vaksin'];
			$qtyorder  = $data['jml_order'];
			$jenisvaksin = $data['nama_jenis'];
			$satuan	   = $data['satuan'];
			$ketorder  = $data['ketorder'];
			
			echo "<tr class='row' bgcolor='#B8B193'>";
			echo "<td align='right'>$no.</td>";
			echo "<td>$kodevaksin</td>";
			echo "<td align='left'>&nbsp;$namavaksin</td>";
			echo "<td>&nbsp;$jenisvaksin</td>";			
			echo "<td align='right'>&nbsp;$qtyorder</td>";			
			echo "<td align='left'>&nbsp;$satuan</td>";
			echo "</tr>";
		}	
		echo "</table>";
		echo "<table class='keterangan' width='100%' style='padding-left:10px;'>";
		echo "<tr>";
		echo "<td width='20%'><b>Keterangan :</b></td>";
		echo "<td width='75%' align='left'>&nbsp;</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td colspan='2'>";
				$ket_order = explode(", ",$ketorder);
				$count = count($ket_order);
				for ($i=0;$i<$count;$i++)
				{
					echo "*&nbsp;".$ket_order[$i]."<br>";				
				}
				
		echo "</td>";
		echo "</tr>";		
		echo "</table>";
	}
?>
<div id="boxpdf" style="float:center">
	<div id="content" ></div>
</div>