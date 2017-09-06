
<?php
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=laporan-pengiriman.xls");
        header("Pragma: no-cache");
        header("Expires: 0");    

  include "../../conf/openconn.php";
  include "../../lib/functions-php.php"; 
  
  $bulan = $_GET['bulan'];
  $tahun = $_GET['tahun'];
  $month = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

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
<style>
body {
	font-family : Tahoma;
}
.baris:hover{background-color:#D9F299}
</style>
<input type='hidden' id='bulan' value='<?php echo $bulan;?>'>
<input type='hidden' id='tahun' value='<?php echo $tahun;?>'>
<table>
<tr>
  <td colspan="18" align='center'><h4>Laporan Pengiriman Vaksin Ke Puskesmas dalam Kab. Aceh Barat <?php echo $_GET['tahun'];?></h4></td>
</tr>
<tr>
  <td colspan="18" align='center'><b>Tahun : <?php echo $tahun;?></b></td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
 <td colspan="2">
    <?php $bl = $_GET['bulan'];?>
    BULAN : <?php echo $month[$bl];?> 
 </td>
</tr>
</table> 
<table width="100%" cellpadding="2" cellspacing="1" border="1" style="font-family:Tahoma;font-size:11px;font-weight:bold">	
		<tr class='atas'>
			<td rowspan="2" width="3%">No.</td>
            <td rowspan='2' width='15%'>Kecamatan</td>
			<td rowspan="2" width="12%">Nama Puskesmas</td>
			<td colspan="16" align="center">Vaksin</td>
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
			<!--td align="center">Tgl Amprah</td-->		
		</tr>
		 
	<?php
		 
	 
	 
		while ($print=mysql_fetch_array($qry))
		{ 
			$nomer++;
			$nama = $print['nama'];
			$tgl  = $print['tanggal'];
            $kodeins = $print['kode_instansi'];

			//get nama kecamatan 
			$kec = "SELECT kecamatan from instansi where kode_instansi='$kodeins' group by kecamatan";
			$qke = mysql_query($kec);
			while ($nk=mysql_fetch_array($qke)){
				$kecamatan = $nk['kecamatan'];
			}


            $tot1 = $tot1+$print['ksatu'];
            $tot2 = $tot2+$print['kdua'];
            $tot3 = $tot3+$print['ktiga'];
            $tot4 = $tot4+$print['kempat'];
            $tot5 = $tot5+$print['klima'];
            $tot6 = $tot6+$print['kenam'];
            $tot7 = $tot7+$print['ktujuh'];
            $tot8 = $tot8+$print['kdelapan'];
            $tot9 = $tot9+$print['ksembilan'];
            $tot10 = $tot10+$print['ksepuluh'];
            $tot11 = $tot11+$print['ksebelas'];
            $tot12 = $tot12+$print['kduabelas'];
            $tot13 = $tot13+$print['ktigabelas'];
            $tot14 = $tot14+$print['kempatbelas'];
            $tot15 = $tot15+$print['klimabelas'];
            $tot16 = $tot16+$print['kenambelas'];
            
		?>
		
			<tr class='baris' bgcolor="#eee" id="dataobat_<?php echo $kodevaksin?>">
			 <td align="right"><?php echo $nomer;?>.</td>	
             <td align='left'><?php echo $kecamatan;?></td>		 
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
			 <!--td align="right"><?php echo tgl_indo($tgl);?></td-->							 
			</tr>
		<?php }	?> 
		<tr>
         <td colspan='3' align='center'>Jumlah Kab/Kota</td>
         <td><?php echo $tot1;?></td>
         <td><?php echo $tot2;?></td>
         <td><?php echo $tot3;?></td>
         <td><?php echo $tot4;?></td>
         <td><?php echo $tot5;?></td>
         <td><?php echo $tot6;?></td>
         <td><?php echo $tot7;?></td>
         <td><?php echo $tot8;?></td>
         <td><?php echo $tot9;?></td>
         <td><?php echo $tot10;?></td>
         <td><?php echo $tot11;?></td>
         <td><?php echo $tot12;?></td>
         <td><?php echo $tot13;?></td>
         <td><?php echo $tot14;?></td>
         <td><?php echo $tot15;?></td>
         <td><?php echo $tot16;?></td>
         
 
         
        </tr> 
		</table>
        <br>
<table>
<tr>
 <td align='center' colspan='2'>Mengetahui</td>
</tr>
<tr>
 <td align='center' colspan='2'>Dinas Kesehatan Aceh Barat</td>
</tr>
<tr>
 <td align='center' colspan='2'>Kepala Bidang P2PL</td>
 <td colspan="13">&nbsp;</td>
 <td align='center' colspan='2'>Pengelola Cold Chain</td>
</tr>  
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr>
 <td align='center' colspan='2'><b><u>Dr. S U H A D A</u></b></td>
 <td colspan="13"></td>
 <td align='center' colspan='2'>Rosi Maulisa, SKM</td>
</tr> 
<tr>
 <td align='center' colspan='2'><b>NIP:19781012 200803 1 001</b></td>
</tr> 
</table>