<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>List instansi</title>
<!--link rel="stylesheet" type="text/css" href="../css/adminview.css" media="all"-->
<!--script type="text/javascript" src="../js/adminview.js"></script-->
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet"/>
<script type="text/javascript">
	$(document).ready(function() {
		 
		var hapusconfirm = $("<span id='text'>&nbsp;&nbsp;&nbsp;<font size='3'>Yakin Data akan dihapus?</font></span> <input type='button' id='Ya' value='Ya'> <input type='button' id='No' value='Tidak'>");
		$("#delconfirm").html(hapusconfirm); 
		
		$("#delconfirm").hide();	
		 
		$("#No").click(function(){
			$("#delconfirm").hide();
		});	
		
		$("#Ya").click(function(){
			var id = $("#del_id").val();
			
			$.ajax({
					type :"POST",
					url  :"hapus_instansi.php",
					data :"kdp="+id,
					success : function(html){
						$("#confirm").html(html);
						$("#delconfirm").hide();	
						$("#confirm").fadeOut(5000);
						$("#data_instansi_"+id).remove();
					}
			});
 
			 
		});
		
		$(".hapus").click(function(){
			var id = $(this).attr('id');
			$("#del_id").val(id);
			$("#delconfirm").show();
			
		});
		
		
		$('#datainstansi').click(function(){	
			document.location.href='datainstansi.php';
		});
		
			
	});

</script>
<style>
body {
	background-color:#ccc;
	font-family:Tahoma;
	font-size:13px;
}
	.listp:hover {background:#8DE68A}
</style>
</head>
<body bgcolor="#eee" >
<?php
	include "../../conf/openconn.php";
	include "../../lib/functions-php.php"; 	
	
	// JUMLAH DATA YANG DITAMPILKAN PER HALAMAN
      $dataPerPage = 6;
 
      // Apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
      // Sedangkan apabila belum, nomor halamannya 1.
      if(isset($_GET['page']))
      {
        $noPage = $_GET['page'];
      }
      else $noPage = 1;
 
      // Perhitungan offset
      $offset = ($noPage - 1) * $dataPerPage;
 
      
      echo "<h4>Hal : ".$noPage."</h4>";
 
      // MENGAMBIL DATA     
      $query = "SELECT * FROM instansi ORDER BY kode_instansi DESC LIMIT $offset, $dataPerPage";
 
      $result = mysql_query($query) or die('Error');
 
      // Penomoran Item
      $nomor=1;
	  $nomor1=0;
      $nomor1 = (6 * $noPage)-6;
	
?>	
	<div id="listview2_container">
 
		<div class="form_description">
			<h2>&nbsp;&nbsp;Data Instansi</h2>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;List Data Instansi </p>
		</div>		
		<input type='hidden' id='del_id'>
		<span id='button' style='padding-left:12px'><input type='button' name='datainstansi' id='datainstansi' value='Input Data Instansi'></span>	
		<table id="listp" width="90%" cellpadding="2" cellspacing="2" style='padding:0 10px 20px 10px'>
		<tr>
			<td>
			<?php if ($noPage <= 1)
            {
            //  echo $nomor++."<br>";
            }
            else
            {     
             // echo $nomor1=$nomor1+1 ."<br>";
            } ?>
			</td>
		</tr>	
		<tr bgcolor="#c0c0c0">
			<td width="2%"><b>No.</b></td>
			<td width="20%"><b>Nama Instansi</b></td>
			<td width="20%"><b>Alamat</b></td>
			<td width="15%"><b>Kecamatan</b></td>
			<td width="30%"><b>Kota</b></td>		
			<td width="4%"><b>Hapus</b></td>			
		</tr>
		 
		<?php
		//get data master obat
		$getdataobat = "Select * from instansi ORDER BY kode_instansi  ASC LIMIT $offset, $dataPerPage";
		$qrydataobat = mysql_query($getdataobat);
		while ($print=mysql_fetch_array($qrydataobat))
		{ 
			$nomer++;
			$kode	  =$print['kode_instansi'];
			$nama	  =$print['nama'];
			$alamat	  =$print['alamat'];			
			$kota     =$print['kota'];
			$kecamatan=$print['kecamatan'];
			$notelp	  =$print['notelp'];
		 
			 
		?>
		
			<tr bgcolor="#eeeeee" class="listp"  id="data_instansi_<?php echo $kode?>">
			 <td align="right">
			 <?php if ($noPage <= 1)
           	 {
                echo $nomor++."<br>";
             }else{     
                echo $nomor1=$nomor1+1 ."<br>";
             }?></td>			 		 
			 <td><a href="edit_instansi.php?kdp=<?php echo $kode;?>"><?php echo $nama;?></a></td>
			 <td><?php echo $alamat;?></td>
			 <td><?php echo $kecamatan;?></td>			 
	     	 <td><?php echo $kota;?></td>
			  <td align='center'><input type='button' name='del' class="hapus" id="<?php echo $kode?>" value='X'></td>	
			</tr>
		<?php }	?> 
		
		</table>
		<div id="confirm"></div>
		<?php
        
 
      // Mencari jumlah semua data tabel 'alamat', kemudian simpan dalam variabel $jumData
        $query3   = "SELECT COUNT(*) AS jumData FROM instansi";
        $hasil3   = mysql_query($query3);
        $data3    = mysql_fetch_array($hasil3);
 
        $jumData = $data3['jumData'];
        echo "<br><center>";
          if ($jumData > 6)
            {
 
              // Menentukan jumlah halaman yang muncul berdasarkan jumlah semua data
              $jumPage = ceil($jumData/$dataPerPage);
 
              // Menampilkan link 'Sebelum'   
              if ($noPage > 6) 
              {
              $query = "SELECT * FROM instansi";
              $result = mysql_query($query) or die('Error');
 
              $data = mysql_fetch_array($result);
 
              echo  "<a href='".$_SERVER['PHP_SELF']."?page=".($noPage-1)."'><< Back</a>";
               }
              // Menampilkan nomor halaman dan linknya
              for($page = 1; $page <= $jumPage; $page++)
              {
 
                if ((($page >= $noPage - 6) && ($page <= $noPage + 6)) || ($page == 1) || ($page == $jumPage))
                {
 
                  if (($showPage == 1) && ($page != 6))  echo "<a href='#'> </a>";
                  if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "<a href='#'> </a>";
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
	</body>
</html>