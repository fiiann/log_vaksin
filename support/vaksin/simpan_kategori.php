<script type="text/javascript">
	$(document).ready(function(){
		$('#ya').click(function(){
			location.reload();	
			$("#namakategori").val('');	
		});
	
		$('#tidak').click(function(){
			
		});
	});
</script>


<?
	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php";
	
	if ($_POST['nama']!='')
	{
		$idkategori	= $_POST['idkategori'];
		$nama		= $_POST['nama'];
		
		
		$sqlkat = " INSERT INTO kategoriobat SET
					idkategori   ='$idkategori', 
					namakategori ='$nama'";
					
					
		mysql_query($sqlkat, $koneksi) 
			  or die ("Simpan Data Kategori Gagal..".mysql_error());
	
	}
	
	if (!$sqlkat)
	{
		echo " Error " ;	
	}else{
		echo " Simpan Data Berhasil, Input Data Lagi? <input type='button' id='ya' value='Ya'> <input type='button' id='tidak' value='Tidak'>";
	}
 
?>
