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
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm" style="font-size: 11pt">
    <page_header>
		<br>
        <table class="page_header" border="0" style="border-collapse:collapse;">
            <tr>
                <td width="775" align="right">Transaksi Vaksin Online, version 1.0</td>
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
	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php"; 	
	
	
	if ($_POST['idterima']!='')
	{
		$idterima	= $_POST['idterima'];
		$tglterima	= $_POST['tglterima'];
		
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
		<table class="atas" width="785" cellpadding="4" border="0">
		<tr>
			<td width="120">&nbsp;<b>ID Terima</b></td>
			<td width="150">: <?php echo $idterima;?></td>	
			<td width="100">&nbsp;</td>
			<td width="150">&nbsp;<b> </b></td>
			<td width="150"></td>				
		</tr>
		<tr>
			<td>&nbsp;<b>Tanggal Terima</b></td>
			<td>: <?php echo $tglterima;?></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>				
		</tr>
		</table>
		<br>
		<table class='top' width="785" cellspacing="2" cellpadding="2" border="0">
		<tr>
			<td id='text' width="270" align='left'>&nbsp;DETIL PENERIMAAN :</td>
			<td width="200">&nbsp;</td>
			<td width="250" align='right'>&nbsp;</td>
		</tr>
		</table>	
		<table class='list' width="785" cellspacing="2" cellpadding="2" style='padding-left:10px'>
		<tr class='top' bgcolor="#cccccc">
			<td width="30" align="center"><b>No.</b></td>
			<td width="120" align="center"><b>Kode Vaksin</b></td>
			<td width="250" align="center"><b>Nama Vaksin</b></td>
			<td width="120" align="center"><b>Jenis Vaksin</b></td>
			<td width="90" align="center"><b>Jml Terima</b></td>
			<td width="90" align="center"><b>Satuan</b></td>	
			
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
			$ketorder  = $data['ket_order'];
			
			echo "<tr class='row' bgcolor='#eeeeee'>";
			echo "<td align='right'>$no.</td>";
			echo "<td align='center'>$kodevaksin</td>";
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
	<br><br><br><br>
	<br><br><br><br>
	<div align="center">
	</div>
</page>

<?php
    $content = ob_get_clean();
	require_once('../../html2pdf_v4.03/html2pdf.class.php');
    try
    {
		$html2pdf = new HTML2PDF('P', array(215,330), 'en', true, 'UTF-8', 0);
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

		$rootpath = $_SERVER['DOCUMENT_ROOT']."/sisfo-vaksin/pdfcetak/";
		$filename = "TerimaVaksin-".$idterima.".pdf";
		$html2pdf->Output($rootpath.$filename,'F');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
echo "<iframe id='iframe1' src='http://localhost/sisfo-vaksin/pdfcetak/".$filename."#view=FitH' width='740' height='400' frameborder='0'></iframe>";
?>
</div>