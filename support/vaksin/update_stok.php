<script type="text/javascript">
	$(document).ready(function(){
		$('#ya').click(function(){
			location.reload();	
			$("#jenis_vaksin").val('');
            $("#jumlah_stok").val('');
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
        $jumlah     = $_POST['jumlah'];	
        $satuan     = $_POST['satuan'];

		$sql = "UPDATE master_stok SET
                    stok_tersedia   ='$jumlah',
                    satuan          ='$satuan'
                    where id_jenis='".$jenis."'";
					
		mysql_query($sql, $koneksi) 
			  or die ("Update Data Gagal..".mysql_error());
	
		if (!$sql)
		{
			 echo "Update Data Stok Vaksin Error...";
		}else{
			 echo "Update Data Stok Vaksin Berhasil..";
	
		}
	}


 
?>
