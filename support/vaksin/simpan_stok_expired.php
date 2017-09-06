<script type="text/javascript">
	$(document).ready(function(){
		$('#ya').click(function(){
			location.reload();	
			$("#stok_expired").val('');
            $("#stok_tersedia").val('');
			$("#satuan").val();
		});
	
		$('#tidak').click(function(){
			$("#confirm").hide();
		});
	});
</script>
<?php
	include "../../conf/openconn.php";
 
	
	if ($_POST['aksi']=="insert")
	{
		$jenis	    = $_POST['id_jenis'];
		$bulan		= $_POST['bulan'];
        $tahun      = $_POST['tahun'];
        $sawal      = $_POST['stok_awal'];
        $sexp       = $_POST['stok_expired'];	
		$satuan     = $_POST['satuan'];
        $tanggal    = date('Y-m-d');

		 
        //insert ke tabel stok expired
        $ins = "INSERT INTO expired_stok SET 
		          id_jenis ='$jenis',
				  bulan ='$bulan',
				  tahun ='$tahun',
				  stok_awal='$sawal',
				  stok_expired='$sexp',
				  satuan='$satuan',
				  tgl_create='$tanggal'";

        $qry = mysql_query($ins) or die (mysql_error());

		//update stok vaksin setelah dikurangi expired
		$stok_sisa = $sawal-$sexp;
		$upd = "UPDATE master_stok SET stok_tersedia='$stok_sisa' where id_jenis='".$jenis."'";
		$qup = mysql_query($upd) or die (mysql_error());
	
		if (!$qry)
		{
			 echo "Simpan Data Error...";
		}else{
			 echo "Simpan Data Berhasil, Input Data Lagi? <input type='button' id='ya' value='Ya'> <input type='button' id='tidak' value='Tidak'>";
	
		}
	}else{
		$jenis      = $_POST['id_jenis'];
		$idx	    = $_POST['idx_exp'];
	    $sawal      = $_POST['stok_awal'];
        $sexp       = $_POST['stok_expired'];	
		$satuan     = $_POST['satuan'];
        $tgl_update = date('Y-m-d');

		//insert ke tabel stok expired
        $ins = "UPDATE expired_stok SET 
		          stok_expired='$sexp',
				  satuan='$satuan',
				  tgl_update='$tgl_update' 
				where idx='".$idx."'";

        $qry = mysql_query($ins) or die (mysql_error());

		//update stok vaksin setelah dikurangi expired
		$stok_sisa = $sawal-$sexp;
		$upd = "UPDATE master_stok SET stok_tersedia='$stok_sisa' where id_jenis='".$jenis."'";
		$qup = mysql_query($upd) or die (mysql_error());

	}

	if (!$qup)
		{
			 echo "Update Data Error...";
		}else{
			 echo "Update Data Berhasil..";
	}
?>
