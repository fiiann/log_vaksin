<script type="text/javascript">
	$(document).ready(function(){
		$('#ya').click(function(){
			location.reload();	
			$("#jenis_vaksin").val('');
            $("#jumlah_stok").val('');
			$("#satuan").val('');
		});
	
		$('#tidak').click(function(){
			$("#confirm").hide();
		});
	});
</script>
<?php
	include "../../conf/openconn.php";
 
	
	if ($_POST['id_jenis']!='')
	{
		$jenis	    = $_POST['id_jenis'];
		$bulan		= $_POST['bulan'];
        $tahun      = $_POST['tahun'];
        $jumlah     = $_POST['jumlah'];	
		$satuan     = $_POST['satuan'];


		//cek apakah sudah ada jenis vaksin yang sama
		$cek = "SELECT id_jenis from master_stok where id_jenis='".$jenis."'";
		$qry = mysql_query($cek);
		$ada = mysql_num_rows($qry);
		if ($ada!=0){
			 //ambil stok terakhir
			 $get  = "SELECT stok_tersedia FROM master_stok where id_jenis='".$jenis."'";
			 $qry  = mysql_query($get) or die (mysql_error());
			 while ($s=mysql_fetch_array($qry)){
				 $stok_akhir = $s['stok_tersedia'];
			 }

			 $totstok = $stok_akhir + $jumlah;

			 //update stok terakhir
			 $upd = "UPDATE master_stok SET 
			         stok_tersedia='$totstok' where id_jenis='".$jenis."'";
			 $qup = mysql_query($upd);

		}else{
				//insert ke master stok
				$mas = "INSERT INTO master_stok SET 
		       			 id_jenis='$jenis',
						 stok_tersedia='$jumlah',
						 satuan='$satuan'";
				$qmas = mysql_query($mas) or die (mysql_error());
		}

	

		//insert ke tabel detil stok
		$sql = " INSERT INTO master_stok_detil SET
					id_jenis	    ='$jenis', 
					bulan     	    ='$bulan', 
					tahun	        ='$tahun',  
                    jumlah          ='$jumlah',
					satuan          ='$satuan'";
					
		mysql_query($sql, $koneksi) 
			  or die ("Simpan Data Gagal..".mysql_error());
	
		if (!$sql)
		{
			 echo "Simpan Data Stok Vaksin Error...";
		}else{
			 echo "Simpan Data Stok Vaksin Berhasil, Input Data Lagi? <input type='button' id='ya' value='Ya'> <input type='button' id='tidak' value='Tidak'>";
	
		}
	}


 
?>
