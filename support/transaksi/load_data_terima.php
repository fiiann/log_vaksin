<style>
.row:hover{background:#F7E188}
.header {font-weight:bold;color:#fff}
</style>
<script>
</script>
<?php
	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php"; 	
	
	
	if ($_POST['bulanterima']!='')
	{
		$timeorder	= $_POST['bulanterima'];
		 
		$extime	= explode(",",$timeorder);
		$bln	= $extime[0];
		$thn	= $extime[1];
		
		$getdata = "select t.idterima
					,t.tgl_terima
					FROM trxterima t
					WHERE month(t.tgl_terima)='".$bln."' AND year(t.tgl_terima)='".$thn."'";				
		$qrydata	= mysql_query($getdata);
		
		?>
		
		<table class='list' width="75%" cellspacing="2" cellpadding="2" style='padding-left:10px'>
		<tr class='header' bgcolor="#4F4E33" width="60%">
			<td width="4%" align="center"><b>No.</b></td>
			<td width="10%" align="center"><b>ID Penerimaan</b></td>
			<td width="20%" align="center"><b>Tanggal Terima</b></td>
			<td width="4%" align='center'><b>Detil</b></td>			
		</tr>
		
		
	<?php	
		while ($data = mysql_fetch_array($qrydata))
		{
			$no++;
			$idorder  = $data['idterima'];
			$tglorder = tgl_indo($data['tgl_terima']);
			
			echo "<tr class='row' bgcolor='#CFCEC8'>";
			echo "<td align='right'>$no.</td>";
			echo "<td>&nbsp;$idorder</td>";
			echo "<td>&nbsp;$tglorder<input type='hidden' id='tgl_terima' value='$tglorder'></td>";
			echo "<td align='center' class='detil' id='$idorder'><input type='button' name='detilorder' id='$idorder' value='view detil'></td>";
			echo "</tr>";
		}	
	}

?>