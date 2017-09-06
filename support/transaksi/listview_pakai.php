<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>List Purchasing Obat</title>
<link rel="stylesheet" type="text/css" href="../css/adminview.css" media="all">
<script type="text/javascript" src="../js/adminview.js"></script>
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet"/>
<script type="text/javascript">
	$(document).ready(function() {

		$("#prosesbox").dialog({
					autoOpen:false,
					width:700,
					height:'auto',
					title:'Proses Pemenuhan Permintaan Vaksin',
					position:['top',10],
					modal:true,
					buttons:{
						'Simpan Data' :function(){
							getdataobat();
						},
						'Close' :function(){
							$(this).dialog('close');
						    }
						}
		 });


		 $("#detilbox").dialog({
					autoOpen:false,
					width:750,
					height:500,
					title:'Laporan Pemakaian Vaksin Puskesmas',
					top:30,
					modal:true,
					buttons:{
						'Close' :function(){
							$(this).dialog('close');
						    }
						}
		 });


		 $(".detil").click(function(){
			var idpakai 	= $(this).attr('id');
			var kodein 		= $("#kode_instansi").val();
			var tglpakai	= $("#tanggal").val();
 			$.ajax({
					type  :"POST",
					url   :"getdetil_pakai.php",
					cache : false,
					data  : "idpakai="+idpakai+"&tglpakai="+tglpakai+"&kode_instansi="+kodein,
					success : function(html){
						$("#detilbox").dialog('open');
						$("#detilorder").html(html);
					}

			});
		 });

		 $("#grouping").change(function(){
			 var n = $(this).val();
			 $.ajax({
				   type : 'post',
					 url  : 'listview_pakai.php',
					 data : 'grouping='+n,
					 success:function(html){
						 $("#form_container").html(html)
					 }
			 })
		 })

	});

</script>
<style>
.listobat tr.baris:hover {background:#fff}
</style>
</head>
<body id="main_body" style="padding-top:20px">
<?php
	include "../../conf/openconn.php";
	include "../../lib/functions-php.php";
?>

	<div id="form_container">
		<div class="form_description">
		<?php
		// JUMLAH DATA YANG DITAMPILKAN PER HALAMAN
				$dataPerPage = 10;

				// Apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
				// Sedangkan apabila belum, nomor halamannya 1.
				if(isset($_GET['page']))
				{
					$noPage = $_GET['page'];
				}
				else $noPage = 1;

				// Perhitungan offset
				$offset = ($noPage - 1) * $dataPerPage;

				//echo "<h4>Hal : ".$noPage."</h4>";

					// MENGAMBIL DATA
					$query = "SELECT  p.id_pakai
												 ,p.kode_instansi
												 ,p.tanggal
												 ,p.is_fix
												 ,p.is_approve
												 ,i.nama
								FROM pemakaian p
								INNER JOIN instansi i
								on p.kode_instansi=i.kode_instansi
								ORDER BY p.id_pakai DESC LIMIT $offset, $dataPerPage";
					$result = mysql_query($query) or die('Error'.mysql_error());
				// Penomoran Item
				$nomor=1;
				$nomor1=0;
				$nomor1 = (10 * $noPage)-10;
		 ?>
		<h2>&nbsp;&nbsp;Data Pemakaian Vaksin</h2>
		</div>
		<input type='hidden' id='del_id'>
		&nbsp;&nbsp; Grouping : <select id="grouping">
		 <option selected>Pilih Satu</option>
		 <option value="1">Telah disetujui</option>
		 <option value="0">Belum disetujui</option>
		</select>
		<table class='listobat' id="listobat" width="100%" cellpadding="2" cellspacing="2" style='padding:0 10px 20px 10px'>
		<tr>
			<td>
			<?php
			if ($noPage <= 1)
            {
            //  echo $nomor++."<br>";
            }
            else
            {
             // echo $nomor1=$nomor1+1 ."<br>";
            } ?>
			</td>
		</tr>
		<tr class='atas' bgcolor="#c0c0c0">
			<td width="4%">No.</td>
			<td width="5%">&nbsp;ID Proses</td>
			<td width="15%" align="center">&nbsp;Tgl Laporan</td>
			<td width="25%">&nbsp;Nama Puskesmas</td>
			<td width="12%">&nbsp;Status</td>
			<td width="4%" align='center'>detil</td>
		</tr>

		<?php

		//get data pakai
		if ($_POST['grouping']==1){
			$getdataobat = "SELECT  p.id_pakai
											 ,p.kode_instansi
											 ,p.tanggal
											 ,p.is_fix
											 ,p.is_approve
											 ,i.nama
							FROM pemakaian p
							INNER JOIN instansi i
							on p.kode_instansi=i.kode_instansi where is_approve=1
							ORDER BY p.id_pakai DESC LIMIT $offset, $dataPerPage";
			$qrydataobat = mysql_query($getdataobat);
		}else{
			$getdataobat = "SELECT  p.id_pakai
											 ,p.kode_instansi
											 ,p.tanggal
											 ,p.is_fix
											 ,p.is_approve
											 ,i.nama
							FROM pemakaian p
							INNER JOIN instansi i
							on p.kode_instansi=i.kode_instansi where is_approve=0
							ORDER BY p.id_pakai DESC LIMIT $offset, $dataPerPage";
			$qrydataobat = mysql_query($getdataobat);
		}


		while ($print=mysql_fetch_array($qrydataobat))
		{
			$nomer++;
			$idpakai           =$print['id_pakai'];
			$tanggal   	       =tgl_indo($print['tanggal']);
			$kodein   	       =$print['kode_instansi'];
			$namain            =$print['nama'];
			$isfix             =$print['is_fix'];
			$isapprove         =$print['is_approve'];


			if ($isapprove==1){
				$is_app = "Telah Disetujui";
			}else{
				$is_app = "Belum Disetujui";
			}

			echo "<input type='hidden' name='kode_instansi' id='kode_instansi' value='$kodein'>";
			echo "<input type='hidden' name='tanggal' id='tanggal' value='$print[tanggal]'>";

		?>

			<tr class='baris' bgcolor="#eeeeee" id="datapakai_<?php echo $idpakai?>">
			 <td align="right"><?php echo $nomor;?>.</td>
			 <td>&nbsp;<?php echo $idpakai;?></td>
			 <td align="center">&nbsp;<?php echo $tanggal;?></td>
			 <td align="left">&nbsp;<?php echo $namain;?></td>
			 <td align="center"><?php echo $is_app;?></td>
			 <td  align='center'><input type='button' name='detil' class="detil" id="<?php echo $idpakai?>" value='detil'></td>
			</tr>
		<?php }	?>

		</table>
		<div id="confirmsave"></div>
		<?php


      // Mencari jumlah semua data tabel 'alamat', kemudian simpan dalam variabel $jumData
        $query3   = "SELECT COUNT(*) AS jumData FROM pemakaian";
        $hasil3  = mysql_query($query3);
        $data3    = mysql_fetch_array($hasil3);

        $jumData = $data3['jumData'];
        echo "<br><center>";
          if ($jumData > 10)
            {

              // Menentukan jumlah halaman yang muncul berdasarkan jumlah semua data
              $jumPage = ceil($jumData/$dataPerPage);

              // Menampilkan link 'Sebelum'
              if ($noPage > 10)
              {
              $query = "SELECT * FROM pemakaian";
              $result = mysql_query($query) or die('Error');

              $data = mysql_fetch_array($result);

              echo  "<a href='".$_SERVER['PHP_SELF']."?page=".($noPage-1)."'><< Back</a>";
               }
              // Menampilkan nomor halaman dan linknya
              for($page = 1; $page <= $jumPage; $page++)
              {

                if ((($page >= $noPage - 10) && ($page <= $noPage + 10)) || ($page == 1) || ($page == $jumPage))
                {

                  if (($showPage == 1) && ($page != 10))  echo "<a href='#'>...</a>";
                  if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "<a href='#'>...</a>";
                  if ($page == $noPage) echo " <a href='#'>".$page."</a>";
                  else echo " <a href='".$_SERVER['PHP_SELF']."?page=".$page."'>".$page."</a> ";
                  $showPage = $page;
                }
              }

              // Menampilkan link 'Sesudah'
              if ($noPage < $jumPage)
              echo "<a href='".$_SERVER['PHP_SELF']."?page=".($noPage+1)."'>Next >></a>";
            }

          else
            {
            }

        echo "</center>";
    ?>
		<div id="delconfirm"></div>

	</div>
	<div id="detilbox">
		<div id="detilorder"></div>
	</div>
	<div id="prosesbox">
		<div id="formpurchasing"></div>
	</div>
	</body>
</html>
