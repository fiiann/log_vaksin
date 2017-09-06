<?php
date_default_timezone_set("Asia/Jakarta");
session_start();
ob_start();
		
?>
<style type="text/css">
p {
	text-align:justify;
}
 
</style>
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm" style="font-size: 10pt">
    <page_header>
		<br>
        <table class="page_header" border="0" style="border-collapse:collapse;">
            <tr>
                <td width="775" align="right">Logistik Vaksin Aceh Barat</td>
				<td width="23"></td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table class="page_footer">
            <tr>
			<td width="23"></td>
            <td width="752" align="center">Page [[page_cu]] of [[page_nb]]</td>
			<td width="23"></td>
            </tr>
			<br>
			<br>
        </table>
    </page_footer>
	<?php
	include "../../conf/openconn.php";
	include "../../lib/functions-php.php"; 	
	
	
	if ($_POST['idpakai']!='')
	{
		$idpakai	= $_POST['idpakai'];
		$kode_in	= $_POST['kodein'];
		$tglpakai	= $_POST['tglpakai'];
		
		//get nama poli 
		$sqlpoli = "select nama from instansi where kode_instansi='".$kode_in."'";
		$qrypoli = mysql_query($sqlpoli);
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
		<h4>Data Pemakaian Vaksin</h4>
		<br><br>
		<table class="atas" width="785" cellpadding="4" border="0">
		<tr>
			<td width="100">&nbsp;<b>ID Laporan</b></td>
			<td width="120">: <?php echo $idpakai;?></td>	
			<td width="20">&nbsp;</td>
			<td width="130">&nbsp;<b>Nama Instansi</b></td>
			<td width="150">: <?php echo $namap;?></td>				
		</tr>
		<tr>
			<td>&nbsp;<b>Tgl Laporan</b></td>
			<td>: <?php echo $tglpakai;?></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>				
		</tr>
		</table>
		<br>
		 
		<table class='list' width="775" cellspacing="1" cellpadding="2" border="0.2">
		<tr class='top'>
			<td width="40" align="center"><b>No.</b></td>
			<td width="220" align="center"><b>Jenis Vaksin</b></td>			
			<td width="130" align="center"><b>Jml Pakai</b></td>
			<td width="100" align="center"><b>Satuan</b></td>				
		</tr>
		
	<?php	
		while ($data = mysql_fetch_array($qrydata))
		{
			$no++;
			$vaksin       = $data['nama'];
			$satuan	      = $data['satuan'];
			$jmlpakai     = $data['jumlah'];
			
			
			echo "<tr class='row'>";
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
 
	 
</page>

<?php
    $content = ob_get_clean();
	require_once('../../html2pdf_v4.03/html2pdf.class.php');
    try
    {
		$html2pdf = new HTML2PDF('P', array(215,330), 'en', true, 'UTF-8', 0);
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

		$rootpath = $_SERVER['DOCUMENT_ROOT']."/logistik-vaksin/support/folder_pdf/";
		$filename = "LapPemakaianVaksin-".$idpakai.".pdf";
		$html2pdf->Output($rootpath.$filename,'F');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
echo "<iframe id='iframe1' src='http://localhost/logistik-vaksin/support/folder_pdf/".$filename."#view=FitH' width='740' height='400' frameborder='0'></iframe>";
?>
</div>