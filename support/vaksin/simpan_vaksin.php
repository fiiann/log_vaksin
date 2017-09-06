<script type="text/javascript">
	$(document).ready(function(){
		$('#ya').click(function(){
			location.reload();	
			$("#kodebatch").val('');
			$("#namavaksin").val('');
			$("#jenisvaksin").val('');
			$("#tgl_diterima").val('');
			$("#tgl_expired").val('');
			$("#jml_stok").val('');
			
		});
	
		$('#tidak').click(function(){
			$("#confirm").hide();
		});
	});
</script>
<?php
	include "../../conf/openconn.php";
 
	if ($_POST['batch']!='')
	{
		$kode	    = $_POST['batch'];
		$nama		= $_POST['nama'];
		$jenis		= $_POST['jenis'];
		$vvm        = $_POST['vvm'];
		$stok       = $_POST['jml_stok'];
		$expired	= strtotime($_POST['tgl_expired']);
		$diterima   = strtotime($_POST['tgl_diterima']);
		$satuan     = $_POST['satuan'];
		
		$tgl_dterima	= date("Y-m-d",$diterima);
		$tgl_expired	= date("Y-m-d",$expired);
		
		
		$sql = " INSERT INTO master_vaksin SET
					kode_batch 	    ='$kode', 
					nama     	    ='$nama', 
					id_jenis	    ='$jenis', 
					vvm             ='$vvm', 
					tgl_terima	    ='$tgl_dterima',
					tgl_expired	    ='$tgl_expired',
					stok            ='$stok',
					id_satuan       ='$satuan'";
					
					
		mysql_query($sql, $koneksi) 
			  or die ("Simpan Data Gagal..".mysql_error());
	
		if (!$sql)
		{
			 echo "Simpan Data Vaksin Error...";
		}else{
			 echo "Simpan Data Vaksin Berhasil, Input Data Lagi? <input type='button' id='ya' value='Ya'> <input type='button' id='tidak' value='Tidak'>";
	
		}
	}


 
?>
