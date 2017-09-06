<script type="text/javascript">
	$(document).ready(function(){
		$('#ya').click(function(){
			location.reload();	
			$("#jenis_vaksin").val('');
            $("#jumlah_cakupan").val('');
	 
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
     	$jml_cakup  = $_POST['jml_cakupan'];
        $tanggal    = date('Y-m-d');

		 
        //insert ke tabel stok expired
        $ins = "INSERT INTO data_cakupan SET 
		          id_jenis ='$jenis',
				  bulan ='$bulan',
				  tahun ='$tahun',
				  jumlah='$jml_cakup',
				  tgl_created='$tanggal'";

        $qry = mysql_query($ins) or die (mysql_error());

		if (!$qry){
			echo "simpan gagal...";
		}else{
			echo "simpan cakupan sukses..Input Data Lagi? <input type='button' id='ya' value='Ya'> <input type='button' id='tidak' value='Tidak'>";
		}

	 
	}else{
		$idx        = $_POST['idx'];
		$jenis	    = $_POST['id_jenis'];
		$bulan		= $_POST['bulan'];
        $tahun      = $_POST['tahun'];
     	$jml_cakup  = $_POST['jml_cakupan'];
        $tanggal    = date('Y-m-d');

		//insert ke tabel stok expired
        $ins = "UPDATE data_cakupan SET 
				  id_jenis ='$jenis',
		          bulan ='$bulan',
				  tahun ='$tahun',
				  jumlah='$jml_cakup',
				  tgl_created='$tanggal'
				where idx='".$idx."'";

        $qry = mysql_query($ins) or die (mysql_error());

		if (!$qry){
			echo "update gagal...";
		}else{
			echo "update cakupan sukses..";
		} 

	}
 
?>
