<script type="text/javascript">
		$("#cetakExcel").click(function(){
			var bulan  = $("#bulan").val();	
			var tahun  = $("#tahun").val();	
			window.open('report_kirim_excel.php?bulan='+bulan+'&tahun='+tahun);
		});

</script>
<style>
body {
	font-family : Tahoma;
}
.baris:hover{background-color:#D9F299}
</style>
<?php
  include "../../conf/openconn.php";
  include "../../lib/functions-php.php"; 
  
  $bulan = $_POST['bulan'];
  $tahun = $_POST['tahun'];

  $get = "SELECT  
  				 a.kode_instansi
				,a.tanggal 
  				,SUM(IF(d.id_jenis='JN61201',d.jumlah,0)) AS ksatu
				,SUM(IF(d.id_jenis='JN61202',d.jumlah,0)) AS kdua 
				,SUM(IF(d.id_jenis='JN61203',d.jumlah,0)) AS ktiga
				,SUM(IF(d.id_jenis='JN61204',d.jumlah,0)) AS kempat
				,SUM(IF(d.id_jenis='JN61205',d.jumlah,0)) AS klima
				,SUM(IF(d.id_jenis='JN61206',d.jumlah,0)) AS kenam 
				,SUM(IF(d.id_jenis='JN61207',d.jumlah,0)) AS ktujuh 
				,SUM(IF(d.id_jenis='JN61208',d.jumlah,0)) AS kdelapan
				,SUM(IF(d.id_jenis='JN61209',d.jumlah,0)) AS ksembilan
				,SUM(IF(d.id_jenis='JN61210',d.jumlah,0)) AS ksepuluh
				,SUM(IF(d.id_jenis='JN61211',d.jumlah,0)) AS ksebelas
				,SUM(IF(d.id_jenis='JN61212',d.jumlah,0)) AS kduabelas
				,SUM(IF(d.id_jenis='JN61213',d.jumlah,0)) AS ktigabelas
				,SUM(IF(d.id_jenis='JN61214',d.jumlah,0)) AS kempatbelas
				,SUM(IF(d.id_jenis='JN61215',d.jumlah,0)) AS klimabelas
				,SUM(IF(d.id_jenis='JN61216',d.jumlah,0)) AS kenambelas
				,i.nama
		 from amprah_approval a 
		 inner join amprah_approval_detil d
		  on a.id_proses = d.id_proses
		 inner join instansi i 
		  on a.kode_instansi = i.kode_instansi
		 where month(a.tanggal)='$bulan' and year(a.tanggal)='$tahun' GROUP by a.kode_instansi";

  $qry = mysql_query($get) or die (mysql_error());		 
		

?>
<input type='hidden' id='bulan' value='<?php echo $bulan;?>'>
<input type='hidden' id='tahun' value='<?php echo $tahun;?>'>
<table width="100%" cellpadding="2" cellspacing="1" border="1" style="font-family:Tahoma;font-size:11px;font-weight:bold">	
		<tr class='atas'>
			<td rowspan="2" width="3%">No.</td>
			<td rowspan="2" width="12%">Nama Puskesmas</td>
			<td colspan="17" align="center">Vaksin</td>
		</tr>
		<tr class='atas'>
			<td align="center">Polio</td>
			<td align="center">Dropper</td>
			<td align="center">BCG</td>
			<td align="center">Pelarut BCG</td>
			<td align="center">DPT-HB</td>
			<td align="center">Campak</td>
			<td align="center">Pelarut Campak</td>			
			<td align="center">TT</td>
			<td align="center">TD</td>
			<td align="center">DT</td>
			<td align="center">HB-Uniject</td>
			<td align="center">Ads 0.05</td>
			<td align="center">Ads 0.5</td>
			<td align="center">Ads 5</td>
			<td align="center">Safety Box</td>
			<td align="center">Pentabio</td>
 	
		</tr>
		 
	<?php
		 
	 
	 
		while ($print=mysql_fetch_array($qry))
		{ 
			$nomer++;
			$nama = $print['nama'];
			$tgl  = $print['tanggal'];
		?>
		
			<tr class='baris' bgcolor="#eee" id="dataobat_<?php echo $kodevaksin?>">
			 <td align="right"><?php echo $nomer;?>.</td>			 
			 <td align="left"><?php echo $nama;?></td>
			 <td align="right"><?php echo $print['ksatu'];?></td>
			 <td align="right"><?php echo $print['kdua'];?></td>
			 <td align="right"><?php echo $print['ktiga'];?></td>
			 <td align="right"><?php echo $print['kempat'];?></td>
			 <td align="right"><?php echo $print['klima'];?></td>
			 <td align="right"><?php echo $print['kenam'];?></td>
			 <td align="right"><?php echo $print['ktujuh'];?></td>
			 <td align="right"><?php echo $print['kdelapan'];?></td>		 					 
			 <td align="right"><?php echo $print['ksembilan'];?></td>		 					 
			 <td align="right"><?php echo $print['ksepuluh'];?></td>		 					 
			 <td align="right"><?php echo $print['ksebelas'];?></td>		 					 
			 <td align="right"><?php echo $print['kduabelas'];?></td>		 					 
			 <td align="right"><?php echo $print['ktigabelas'];?></td>		 					 
			 <td align="right"><?php echo $print['kempatbelas'];?></td>		 
			 <td align="right"><?php echo $print['klimabelas'];?></td>		 					 
			 <td align="right"><?php echo $print['kenambelas'];?></td>		 					 
 						 
			</tr>
		<?php }	?> 
		
		</table>
		<br>
		<?php 
		if ($nomer>0){?>
		<div id="button" style="padding:0 10px"><input type="button" name="cetak" id="cetakExcel" value="Cetak ke Format Excel" style="float:left;padding:5px 5px;"></div>
		<?php }else{
			echo "Tidak ada data";
		} ?>
<div id="boxpdf" style="float:center">
	<div id="content" ></div>
</div>		