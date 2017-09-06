<?php
		date_default_timezone_set("Asia/Jakarta");
        include "../../conf/openconn.php";
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=vaksin-expired.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        $bulan = $_GET['bulan'];
        $tahun = $_GET['tahun'];
        
        if ($_GET['bulan'] || $_GET['tahun']){
			$getdatastok = "Select * from expired_stok where month(tgl_exp)=$bulan and year(tgl_exp)=$tahun  ORDER BY id_jenis ASC";
			$qrydatastok = mysql_query($getdatastok);
	
		}else{
			$getdatastok = "Select * from expired_stok ORDER BY id_jenis ASC";
			$qrydatastok = mysql_query($getdatastok);
	
		} ?>

        <table width="550" border="1">
        <tr class='atas'>
			<td width="4%"><b>No.</b></td>
			<td width='10%'><b>Kode Batch</b></td>
			<td width="15%" style='text-align:center'><b>Jenis Vaksin</b></td>
			<td align="center" width="10%"><b>Jml Expired</b></td>
			<td align="center" width="15%"><b>Keterangan</b></td>	
 		
		</tr>
    <?php		
        while ($print=mysql_fetch_array($qrydatastok))
		{ 
			$nomer++;
			$idx          =$print['idx'];
			$kodebatch    =$print['kode_batch'];
			$id_jenis     =$print['id_jenis'];
            $jumlah       =$print['stok_exp'];
			$ket          =$print['keterangan'];
			 
			if ($ket=='vvm'){
				$ket='Expired by Status VVM';
			}else{
				$ket='Expired by date';
			}

            $getnama = "SELECT nama from jenis_vaksin where id_jenis='".$id_jenis."'";
            $query   = mysql_query($getnama);
            while($nm=mysql_fetch_array($query)){
                $nama = $nm['nama'];

            }
           
			 
		?>
		<tr class='baris' id='stokvaksin_<?php echo $idx;?>'>
			 <td align="right"><?php echo $nomer;?>.</td>	
			 <td><?php echo $kodebatch;?></td>		 
			 <td><?php echo $nama;?></td>
			 <td align="center"><?php echo $jumlah;?></td>
             <td align="center"><?php echo $ket;?></td>
             
		 
			</tr>
		<?php }	?> 
		
		</table>