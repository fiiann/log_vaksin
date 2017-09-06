
<?php
  header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=laporan-monitoring.xls");
        header("Pragma: no-cache");
        header("Expires: 0");  

 

 
  include "../../conf/openconn.php";
  include "../../lib/functions-php.php"; 
  
  $bln   = $_GET['bulan'];
  $thn   = $_GET['tahun'];
 
  $month = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		
  $bulan = $bln-1;
  if ($bulan<1){
     $bulan = 12;
     $tahun = $thn-1; 
  }else{
     $tahun = $thn;
  }

  $skr = date('Y-m-d');
 
  //stok awal bulan
  $get_stok_awal = "SELECT id_jenis,
                      SUM(IF(id_jenis='JN61201',stok,0)) AS polio,
                      SUM(IF(id_jenis='JN61203',stok,0)) AS bcg,
                      SUM(IF(id_jenis='JN61206',stok,0)) AS campak,
                      SUM(IF(id_jenis='JN61208',stok,0)) AS tt,
                      SUM(IF(id_jenis='JN61211',stok,0)) AS hb,
                      SUM(IF(id_jenis='JN61216',stok,0)) AS pentabio, 
                      SUM(IF(id_jenis='JN61209',stok,0)) AS td,
                      SUM(IF(id_jenis='JN61210',stok,0)) AS dt,
                      SUM(IF(id_jenis='JN61212',stok,0)) AS ads1, 
                      SUM(IF(id_jenis='JN61213',stok,0)) AS ads2,
                      SUM(IF(id_jenis='JN61214',stok,0)) AS ads3,
                      SUM(IF(id_jenis='JN61215',stok,0)) AS safety1,
                      SUM(IF(id_jenis='JN61216',stok,0)) AS safety2
                      
                      from master_vaksin
                      WHERE month(tgl_terima)='$bulan' and year(tgl_terima)='$tahun' and stok!=0 and vvm!='C' and (vvm!='D')";

  $qrystokawal = mysql_query($get_stok_awal) or die (mysql_error());
  while($sa=mysql_fetch_array($qrystokawal)){
       $polio = $sa['polio'];
       $bcg = $sa['bcg'];
       $hb = $sa['hb'];
       $campak = $sa['campak'];
       $tt = $sa['tt'];
       $pentabio = $sa['pentabio'];
       $td = $sa['td'];
       $dt = $sa['dt'];
       $ads1 = $sa['ads1'];
       $ads2 = $sa['ads2'];
       $ads3 = $sa['ads3'];
       $safety1 = $sa['safety1'];
       $safety2 = $sa['safety2'];
       
       
  }                    

  //penerimaan bulan ini
  $get_penerimaan = "SELECT id_jenis,
                      SUM(IF(id_jenis='JN61201',stok,0)) AS Tpolio,
                      SUM(IF(id_jenis='JN61203',stok,0)) AS Tbcg,
                      SUM(IF(id_jenis='JN61206',stok,0)) AS Tcampak,
                      SUM(IF(id_jenis='JN61208',stok,0)) AS Ttt,
                      SUM(IF(id_jenis='JN61211',stok,0)) AS Thb,
                      SUM(IF(id_jenis='JN61216',stok,0)) AS Tpentabio,
                      SUM(IF(id_jenis='JN61209',stok,0)) AS Ttd,
                      SUM(IF(id_jenis='JN61210',stok,0)) AS Tdt,
                      SUM(IF(id_jenis='JN61212',stok,0)) AS Tads1,
                      SUM(IF(id_jenis='JN61213',stok,0)) AS Tads2,
                      SUM(IF(id_jenis='JN61214',stok,0)) AS Tads3,
                      SUM(IF(id_jenis='JN61215',stok,0)) AS Tsafety1,
                      SUM(IF(id_jenis='JN61216',stok,0)) AS Tsafety2
                      
                      from master_vaksin
                      WHERE month(tgl_terima)='$bln' and year(tgl_terima)='$thn' and stok!=0 and vvm!='C' and (vvm!='D')";

  $qryterima = mysql_query($get_penerimaan) or die (mysql_error());
  while($tr=mysql_fetch_array($qryterima)){
       $Tpolio = $tr['Tpolio'];
       $Tbcg = $tr['Tbcg'];
       $Thb = $tr['Thb'];
       $Tcampak = $tr['Tcampak'];
       $Ttt = $tr['Ttt'];
       $Tpentabio = $tr['Tpentabio'];
       $Ttd = $tr['Ttd'];
       $Tdt = $tr['Tdt'];
       $Tads1 = $tr['Tads1'];
       $Tads2 = $tr['Tads2'];
       $Tads3 = $tr['Tads3'];
       $TSafety1 = $tr['Tsafety1'];
       $TSafety2 = $tr['Tsafety2'];
       
       
  }    


 //pengeluaran ke puskesmas bulan ini
  $get_keluar = "SELECT  a.tanggal,
                         a.id_proses,
                          SUM(IF(b.id_jenis='JN61201',b.jumlah,0)) AS Ppolio,
                          SUM(IF(b.id_jenis='JN61203',b.jumlah,0)) AS Pbcg,
                          SUM(IF(b.id_jenis='JN61206',b.jumlah,0)) AS Pcampak,
                          SUM(IF(b.id_jenis='JN61208',b.jumlah,0)) AS Ptt,
                          SUM(IF(b.id_jenis='JN61211',b.jumlah,0)) AS Phb,
                          SUM(IF(b.id_jenis='JN61216',b.jumlah,0)) AS Ppentabio,
                          SUM(IF(b.id_jenis='JN61209',b.jumlah,0)) AS Ptd,
                          SUM(IF(b.id_jenis='JN61210',b.jumlah,0)) AS Pdt,   
                          SUM(IF(b.id_jenis='JN61212',b.jumlah,0)) AS Pads1,
                          SUM(IF(b.id_jenis='JN61213',b.jumlah,0)) AS Pads2,
                          SUM(IF(b.id_jenis='JN61214',b.jumlah,0)) AS Pads3,
                          SUM(IF(b.id_jenis='JN61215',b.jumlah,0)) AS PSafety1,
                          SUM(IF(b.id_jenis='JN61216',b.jumlah,0)) AS PSafety2
                      from amprah_approval a 
                      inner join amprah_approval_detil b 
                       on a.id_proses=b.id_proses
                      WHERE month(a.tanggal)='$bln' and year(a.tanggal)='$thn'";

  $qrykeluar = mysql_query($get_keluar) or die (mysql_error());     
  while($tr=mysql_fetch_array($qrykeluar)){
       $Ppolio = $tr['Ppolio'];
       $Pbcg = $tr['Pbcg'];
       $Phb = $tr['Phb'];
       $Pcampak = $tr['Pcampak'];
       $Ptt = $tr['Ptt'];
       $Ppentabio = $tr['Ppentabio'];
       $Ptd = $tr['Ptd'];
       $Pdt = $tr['Pdt'];
       $Pads1 = $tr['Pads1'];
       $Pads2 = $tr['Pads2'];
       $Pads3 = $tr['Pads3'];
       $PSafety1 = $tr['PSafety1'];
       $PSafety2 = $tr['PSafety2'];
       
  }    

 //data cakupan
 $get_cakupan = "SELECT SUM(IF(id_jenis='JN61201',jumlah,0)) AS Cpolio,
                        SUM(IF(id_jenis='JN61203',jumlah,0)) AS Cbcg,
                        SUM(IF(id_jenis='JN61206',jumlah,0)) AS Ccampak,
                        SUM(IF(id_jenis='JN61208',jumlah,0)) AS Ctt,
                        SUM(IF(id_jenis='JN61211',jumlah,0)) AS Chb,
                        SUM(IF(id_jenis='JN61216',jumlah,0)) AS Cpentabio,
                        SUM(IF(id_jenis='JN61209',jumlah,0)) AS Ctd,
                        SUM(IF(id_jenis='JN61210',jumlah,0)) AS Cdt
  
                 from data_cakupan   
                 where bulan='$bln' and tahun='$thn'";     
 $qrycakupan = mysql_query($get_cakupan) or die (mysql_error());
 while ($ck=mysql_fetch_array($qrycakupan)){
     $Cpolio = $ck['Cpolio'];
     $Cbcg   = $ck['Cbcg'];
     $Ccampak= $ck['Ccampak'];
     $Ctt    = $ck['Ctt'];
     $Chb    = $ck['Chb'];
     $Cpentabio = $ck['Cpentabio'];
     $Ctd = $ck['Ctd'];
     $Cdt = $ck['Cdt'];
 
     
 }


 //pemakaian 
 $pakai = "SELECT p.bulan, 
                  p.tahun, 
                  SUM(IF(i.id_jenis='JN61201',i.jumlah,0)) AS Kpolio,
                  SUM(IF(i.id_jenis='JN61203',i.jumlah,0)) AS Kbcg,
                  SUM(IF(i.id_jenis='JN61206',i.jumlah,0)) AS Kcampak,
                  SUM(IF(i.id_jenis='JN61208',i.jumlah,0)) AS Ktt,
                  SUM(IF(i.id_jenis='JN61211',i.jumlah,0)) AS Khb,
                  SUM(IF(i.id_jenis='JN61216',i.jumlah,0)) AS Kpentabio,
                  SUM(IF(i.id_jenis='JN61209',i.jumlah,0)) AS Ktd,
                  SUM(IF(i.id_jenis='JN61210',i.jumlah,0)) AS Kdt,
                  SUM(IF(i.id_jenis='JN61212',i.jumlah,0)) AS Kads1,
                  SUM(IF(i.id_jenis='JN61213',i.jumlah,0)) AS Kads2,
                  SUM(IF(i.id_jenis='JN61214',i.jumlah,0)) AS Kads3,
                  SUM(IF(i.id_jenis='JN61215',i.jumlah,0)) AS KSafety1,
                  SUM(IF(i.id_jenis='JN61216',i.jumlah,0)) AS KSafety2
                  
           from pemakaian p 
           inner join pemakaian_detil i 
            on p.id_pakai=i.id_pakai 
           where p.bulan = '$bulan' and p.tahun='$tahun' and p.is_approve=1";
 $qrypakai = mysql_query($pakai) or die (mysql_error());
 while ($pk=mysql_fetch_array($qrypakai)){
     $Kpolio = $pk['Kpolio'];
     $Kbcg   = $pk['Kbcg'];
     $Kcampak= $pk['Kcampak'];
     $Ktt    = $pk['Ktt'];
     $Khb    = $pk['Khb'];
     $Kpentabio = $pk['Kpentabio'];
     $Ktd = $pk['Ktd'];
     $Kdt = $pk['Kdt'];
     $Kads1 = $pk['Kads1'];
     $Kads2 = $pk['Kads2'];
     $Kads3 = $pk['Kads3'];
     $KSafety1 = $pk['KSafety1'];
     $KSafety2 = $pk['KSafety2'];
     
 }
          

 //stok akhir bulan
 $SPolio = ($polio+$Tpolio)-$Ppolio;
 $SBcg   = ($bcg+$Tbcg)-$Pbcg;
 $SHb    = ($hb+$Thb)-$Phb;
 $SCampak= ($campak+$Tcampak)-$Pcampak;
 $STt    = ($tt+$Ttt)-$Ptt;
 $SPentabio = ($pentabio+$Tpentabio)-$Ppentabio;
 $Std = ($td+$Ttd)-$Ptd;
 $Sdt = ($dt+$Tdt)-$Pdt;
 $Sads1 = ($ads1+$Tads1)-$Pads1;
 $Sads2 = ($ads2+$Tads2)-$Pads2;
 $Sads3 = ($ads3+$Tads3)-$Pads3;
 $SSafety1 = ($safety1+$TSafety1)-$PSafety1;
 $SSafety2 = ($safety2+$TSafety2)-$PSafety2;
 

 //IP Vaksin 
 $IPolio = $Kpolio/$Cpolio;
 $IBcg = $Kbcg/$Cbcg;
 $Ihb = $Khb/$Chb;
 $ICampak = $Kcampak/$Ccampak;
 $ITt = $Ktt/$Ctt;
 $IPentabio = $Kpentabio/$Cpentabio;
 $ITd = $Ktd/$Ctd;
 $IDt = $Kdt/$Cdt;
 
 ?>
<style>
body {
	font-family : Tahoma;
}
.baris:hover{background-color:#D9F299}
</style>
<br>
<table>
<tr>
 <td colspan="10" align='center'><h4>Laporan Monitoring Vaksin Imunisasi Tahun <?php echo $_GET['tahun'];?></h4></td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
 <td colspan="2">
    <?php $bl = $_GET['bulan'];?>
    BULAN : <?php echo $month[$bl];?> 
    <br>
    KABUPATEN : ACEH BARAT 
 </td>
</tr>
</table> 
<table width="100%" cellpadding="2" cellspacing="1" border="1" style="font-family:Tahoma;font-size:11px;font-weight:bold">	
	<tr bgcolor='#ccc'>
        <th>No.</th>
        <th>Jenis Logistik</th>
        <th>Stok Awal Bulan</th>
        <th>Penerimaan</th>
        <th>Pengeluaran</th>
        <th>Stok Akhir Bulan</th>
        <th>Pemakaian</th>
        <th>Total Cakupan</th>
        <th>IP Vaksin</th>
        <th>Keterangan</th>
    </tr>	 
	<tr bgcolor='#ccc'>
       <td align="center">1</td>
       <td align="center">2</td>
       <td align="center">3</td>
       <td align="center">4</td>
       <td align="center">5</td>
       <td align="center">6</td>
       <td align="center">7</td>
       <td align="center">8</td>
       <td align="center">9</td>
       <td align="center">10</td>
       
       
      </tr>   	 
    <tr bgcolor='#1DA2CF'>
       <td align="center">A</td>
       <td align="center">VAKSIN</td>
       <td align="center">DOSIS</td>
       <td align="center">DOSIS</td>
       <td align="center">DOSIS</td>
       <td align="center">DOSIS</td>
       <td align="center">DOSIS</td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       
    </tr>
    <tr>
       <td align="center">1</td>
       <td align="center">HB-UNIJECT</td>
       <td align="center"><?php echo $hb;?></td>
       <td align="center"><?php echo $Thb;?></td>
       <td align="center"><?php echo $Phb;?></td>
       <td align="center"><?php echo $SHb;?></td>
       <td align="center"><?php echo $Khb;?></td>
       <td align="center"><?php echo $Chb;?></td>
       <td align="center">
       <?php 
        
         echo $Ihb;
        ?>
       </td>
       <td align="center"></td>
 
    </tr>
    <tr>
       <td align="center">2</td>
       <td align="center">BCG</td>
       <td align="center"><?php echo $bcg;?></td>
       <td align="center"><?php echo $Tbcg;?></td>
       <td align="center"><?php echo $Pbcg;?></td>
       <td align="center"><?php echo $SBcg;?></td>
       <td align="center"><?php echo $Kbcg;?></td>
       <td align="center"><?php echo $Cbcg;?></td>
       <td align="center"><?php echo $IBcg;?></td>
       <td align="center"></td>
 
    </tr>
    <tr>
       <td align="center">3</td>
       <td align="center">POLIO</td>
       <td align="center"><?php echo $polio;?></td>
       <td align="center"><?php echo $Tpolio;?></td>
       <td align="center"><?php echo $Ppolio;?></td>
       <td align="center"><?php echo $SPolio;?></td>
       <td align="center"><?php echo $Kpolio;?></td>
       <td align="center"><?php echo $Cpolio;?></td>
       <td align="center"><?php echo $IPolio;?></td>
       <td align="center"></td>
    </tr>
     <tr>
       <td align="center">4</td>
       <td align="center">PENTABIO</td>
       <td align="center"><?php echo $pentabio;?></td>
       <td align="center"><?php echo $Tpentabio;?></td>
       <td align="center"><?php echo $Ppentabio;?></td>
       <td align="center"><?php echo $SPentabio;?></td>
       <td align="center"><?php echo $Kpentabio;?></td>
       <td align="center"><?php echo $Cpentabio;?></td>
       <td align="center"><?php echo $IPentabio;?></td>
       <td align="center"></td>
    </tr>
     <tr>
       <td align="center">5</td>
       <td align="center">CAMPAK</td>
       <td align="center"><?php echo $campak;?></td>
       <td align="center"><?php echo $Tcampak;?></td>
       <td align="center"><?php echo $Pcampak;?></td>
       <td align="center"><?php echo $SCampak;?></td>
       <td align="center"><?php echo $Kcampak;?></td>
       <td align="center"><?php echo $Ccampak;?></td>
       <td align="center"><?php echo $Icampak;?></td>
       <td align="center"></td>
    </tr>
     <tr>
       <td align="center">6</td>
       <td align="center">TT</td>
       <td align="center"><?php echo $tt;?></td>
       <td align="center"><?php echo $Ttt;?></td>
       <td align="center"><?php echo $Ptt;?></td>
       <td align="center"><?php echo $STt;?></td>
       <td align="center"><?php echo $Ktt;?></td>
       <td align="center"><?php echo $Ctt;?></td>
       <td align="center"><?php echo $ITt;?></td>
       <td align="center"></td>
    </tr>
    <tr>
       <td align="center">&nbsp;</td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
    </tr>
    <tr bgcolor='#75B80B'>
       <td align="center">B</td>
       <td align="center">Vaksin Bias</td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
    </tr>
    <tr>
       <td align="center">1</td>
       <td align="center">DT</td>
       <td align="center"><?php echo $dt;?></td>
       <td align="center"><?php echo $Tdt;?></td>
       <td align="center"><?php echo $Pdt;?></td>
       <td align="center"><?php echo $Sdt;?></td>
       <td align="center"><?php echo $Kdt;?></td>
       <td align="center"><?php echo $Cdt;?></td>
       <td align="center"><?php echo $IDt;?></td>
       <td align="center"></td>
    </tr> <tr>
       <td align="center">2</td>
       <td align="center">TD</td>
       <td align="center"><?php echo $td;?></td>
       <td align="center"><?php echo $Ttd;?></td>
       <td align="center"><?php echo $Ptd;?></td>
       <td align="center"><?php echo $Std;?></td>
       <td align="center"><?php echo $Ktd;?></td>
       <td align="center"><?php echo $Ctd;?></td>
       <td align="center"><?php echo $ITd;?></td>
       <td align="center"></td>
    </tr>
     
     <tr>
       <td align="center">&nbsp;</td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
    </tr>
    <tr bgcolor='#FAA02A'>
       <td align="center">C</td>
       <td align="center">ADS</td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center" colspan="3">Keterangan:</td>
 
    </tr>
    <tr>
       <td align="center">1</td>
       <td align="center">0,05 ML </td>
       <td align="center"><?php echo $ads1;?></td>
       <td align="center"><?php echo $Tads1;?></td>
       <td align="center"><?php echo $Pads1;?></td>
       <td align="center"><?php echo $Sads1;?></td>
       <td align="center"><?php echo $Kads1;?></td>
       <td align="center" colspan="3" rowspan="7">&nbsp;</td>
       
    </tr> <tr>
       <td align="center">2</td>
       <td align="center">0,5 ML </td>
       <td align="center"><?php echo $ads2;?></td>
       <td align="center"><?php echo $Tads2;?></td>
       <td align="center"><?php echo $Pads2;?></td>
       <td align="center"><?php echo $Sads2;?></td>
       <td align="center"><?php echo $Kads2;?></td>
       
    </tr>
     <tr>
       <td align="center">3</td>
       <td align="center">5 ML</td>
       <td align="center"><?php echo $ads3;?></td>
       <td align="center"><?php echo $Tads3;?></td>
       <td align="center"><?php echo $Pads3;?></td>
       <td align="center"><?php echo $Sads3;?></td>
       <td align="center"><?php echo $Kads3;?></td>
       
    </tr>
    <tr>
       <td align="center">&nbsp;</td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       
       
    </tr>
    <tr bgcolor='#B80B1E'>
       <td align="center">D</td>
       <td align="center">SAFETY BOX</td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
       <td align="center"></td>
 
    </tr>
    <tr>
       <td align="center">1</td>
       <td align="center">2.5 LTR</td>
       <td align="center"><?php echo $safety1;?></td>
       <td align="center"><?php echo $TSafety1;?></td>
       <td align="center"><?php echo $PSafety1;?></td>
       <td align="center"><?php echo $SSafety1;?></td>
       <td align="center"><?php echo $KSafety1;?></td>
 
    </tr> <tr>
       <td align="center">2</td>
       <td align="center">5 LTR</td>
       <td align="center"><?php echo $safety2;?></td>
       <td align="center"><?php echo $TSafety2;?></td>
       <td align="center"><?php echo $PSafety2;?></td>
       <td align="center"><?php echo $SSafety2;?></td>
       <td align="center"><?php echo $KSafety2;?></td>
 
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
 <td colspan="6">&nbsp;</td>
 <td align='center' colspan='2'>Pengelola Cold Chain</td>
</tr>  
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr>
 <td align='center' colspan='2'><b><u>Dr. S U H A D A</u></b></td>
 <td colspan="6"></td>
 <td align='center' colspan='2'>Rosi Maulisa, SKM</td>
</tr> 
<tr>
 <td align='center' colspan='2'><b>NIP:19781012 200803 1 001</b></td>
</tr> 
</table>
<p>