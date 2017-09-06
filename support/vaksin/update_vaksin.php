<script type="text/javascript">
	$(document).ready(function(){
		$('#ya').click(function(){
			location.reload();	
			$("#kode_batch").val('');
			$("#nama_vaksin").val('');
			$("#jenis_vaksin").val('');
			$("#tgl_diterima").val('');
			$("#exp").val('');
			$("#jml_stok").val('');
		});
	
		$('#Back').click(function(){			
			document.location.href='listview_vaksin.php';
		});
		
	});
</script>
<?php
	include "../../conf/openconn.php";
	include "../../lib/functions-php.php";
	
	if ($_POST['kode_batch']!='')
	{
		$kode		= $_POST['kode_batch'];
		$nama		= $_POST['nama_vaksin'];
		$jenis		= $_POST['jenis_vaksin'];
		$tglterima	= strtotime($_POST['tgl_diterima']);		
		$expdate	= strtotime($_POST['expdate']);
		$vvm        = $_POST['vvm'];
		$stok       = $_POST['jml_stok'];
		$satuan     = $_POST['satuan'];

		
		$tglb	= date("Y-m-d",$tglterima);
		$tglx	= date("Y-m-d",$expdate);

		$tglskr = date('Y/m/d');
		$xtgl = explode("/",$tglskr);
		$bln  = $xtgl[1];
		$thn  = $xtgl[0];

	 
			$sql = " UPDATE master_vaksin SET
					nama 		 	='$nama', 
					id_jenis	    ='$jenis',  
					tgl_terima		='$tglb',
					tgl_expired   	='$tglx',
					vvm             ='$vvm',
					stok            ='$stok',
					id_satuan       ='$satuan'
				where kode_batch='".$kode."'";
										
		 	mysql_query($sql, $koneksi) or die (mysql_error());
	 
		if (($vvm=='C') || ($vvm=='D')){
			//insert ke tabel vaksin expired 
			$ket ='vvm';
			$exp = "INSERT INTO expired_stok SET 
					kode_batch='$kode',
					id_jenis='$jenis',
					stok_exp='$stok',
					tgl_exp='$tglskr',
					keterangan='$ket'";

			$qxp = mysql_query($exp) or die (mysql_error());

		}else{
				$del = "DELETE from expired_stok where kode_batch='$kode'";
				$qdl = mysql_query($del);
		}	 

	


		if (!$sql)
		{
			echo "&nbsp;&nbsp;<font color='red'><b>Update Data Vaksin Error...</b></font>";
		}else{
			echo "&nbsp;&nbsp;<font color='green'><b>Update Data Vaksin Berhasil...</b></font>&nbsp;<input type='button' id='Back' value='Back'>";
	
		}
	}


 
?>
