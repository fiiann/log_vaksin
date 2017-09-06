<style>
.atas,.keterangan {font-size:12px;text-align:left;} 
.row:hover{font-size:12px;background:#F5BC00}
.row{font-size:12px;}
.top {font-size:12px;font-weight:bold;color:white}
#text{font-weight:normal;color:black;padding-left:5px;}
</style>
<script type="text/javascript">
		$(document).ready(function() {
			$("#PDF").click(function(){
				var idpakai	  = $("#idpakai").val();
				var tglpakai  = $("#tglpakai").val();
				var kodein 	  = $("#kode_instansi").val();
		 
			    $.post("print_pdfpakai.php",{idpakai:idpakai, tglpakai:tglpakai, kodein:kodein},function(result)
				     {
						$("#boxpdf").dialog('open');
						$("#content").html(result);					 
					 });

			});
			
			$("#boxpdf").dialog({
					autoOpen:false,
					width:850,
					height:'auto',
					title:'Convert Prosesing to PDF', 
					position:'top',
					top:20, 
					modal:true, 
					buttons:{
						'Close' :function(){ 
							$(this).dialog('close');
						    }
						}
			});

			$("#approval").click(function(){
				var idp = $("#idpakai").val();
				$.ajax({
						type : 'post',
						url  : 'proses_approval.php',
						data : 'idpakai='+idp,
						success:function(html){
							$("#result_approval").html(html);
						}
				})
			})
			
		});
</script>

<?php
	include "../../conf/openconn.php";
	include "../../lib/functions-php.php"; 	
	
	
	if ($_POST['idpakai']!='')
	{
		$idpakai    	= $_POST['idpakai'];
		$kodein		    = $_POST['kode_instansi'];
		$tglpakai    	= tgl_indo($_POST['tglpakai']);
 
		//get nama poli 
		$sqlpoli = "select nama from instansi where kode_instansi='".$kodein."'";
		$qrypoli = mysql_query($sqlpoli) or die (mysql_error());
		while ($poli=mysql_fetch_array($qrypoli))
		{
			$namap = $poli['nama'];				
		}		

		$getdata = "select p.is_fix
					,p.is_approve 
					,d.id_pakai
					,d.id_jenis
					,d.jumlah
					,d.satuan
					,j.id_jenis
					,j.nama
					FROM pemakaian p
					INNER JOIN pemakaian_detil d 
						on p.id_pakai=d.id_pakai
					INNER JOIN jenis_vaksin j 
					    on d.id_jenis=j.id_jenis
					WHERE d.id_pakai='".$idpakai."' and p.is_fix=1 and p.is_approve=0";			
					
		$qrydata	= mysql_query($getdata);
		
		?>
		<table class="atas" width="100%" cellpadding="4" border="0">
		<tr>
			<td width="15%">&nbsp;<b>ID Laporan</b></td>
			<td width="35%">: <?php echo $idpakai;?><input type="hidden" id="idpakai" value="<?php echo $idpakai;?>"></td>	
			<td width="15%">&nbsp;<b>Nama Puskesmas</b></td>
			<td width="35%">: <?php echo $namap;?><input type="hidden" id="kode_instansi" value="<?php echo $kodein;?>"></td>				
		</tr>
		<tr>
			<td>&nbsp;<b>Tanggal Laporan</b></td>
			<td>: <?php echo $tglpakai;?><input type="hidden" id="tglpakai" value="<?php echo $tglpakai;?>"></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>				
		</tr>
		</table>
		
		<table class='list' width="100%">
			<tr class='atas'>
				<td width='75%'><span id="result_approval" style="font-weight:bold;color:maroon"></span></td>
				<td width='25%'><input type="button" class="btn" name="approval" id="approval" value="Approve"> <input type="button" class='btn' name="PDF" id="PDF" value="cetak PDF"></td>
			</tr>
		</table>	
		<table class='list' width="100%" cellspacing="2" cellpadding="2" style='padding-left:10px;'>
		<tr class='top' bgcolor="#80B302" width="60%">
			<td width="4%" align="center"><b>No.</b></td>
			<td width="40%" align="center"><b>Jenis Vaksin</b></td>			
			<td width="10%" align="center"><b>Jml Pakai</b></td>
			<td width="10%" align="center"><b>Satuan</b></td>				
		</tr>
	 
		
	<?php	
		while ($data = mysql_fetch_array($qrydata))
		{
			$no++;
			$vaksin       = $data['nama'];
			$satuan	      = $data['satuan'];
			$jmlpakai     = $data['jumlah'];
		 
			
			echo "<tr class='row' bgcolor='#D7ED9F'>";
			echo "<td align='right'>$no.</td>";
			echo "<td align='left'>&nbsp;
				   $vaksin
				  </td>";				  
			echo "<td align='right'>&nbsp;
					$jmlpakai			 
				 </td>";			 
			echo "<td align='left'>&nbsp;$satuan</td>";
			echo "</tr>";
		}	
		echo "</table>";
	 
	}
?>
<div id="boxpdf" style="float:center">
	<div id="content" ></div>
</div>