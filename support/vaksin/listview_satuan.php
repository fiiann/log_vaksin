<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Data Stok Vaksin</title>

<script src="../js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet"/>
<script type="text/javascript">
	$(document).ready(function() {
		$("#stokbox").dialog({
					autoOpen:false,
					width:700,
					height:400,
					title:'Input Stock Vaksin', 
					position:['top',10],
					modal:true, 
					buttons:{
						'Simpan Data' :function(){
							 				
						},	
						'Close' :function(){ 
						     	$(this).dialog('close');
						    }
					}
		 });


		var hapusconfirm = $("<span id='text'>&nbsp;&nbsp;&nbsp;<font size='3'>Yakin Data akan dihapus?</font></span> <input type='button' id='Ya' value='Ya'> <input type='button' id='No' value='Tidak'>");
		$("#delconfirm").html(hapusconfirm); 
		
		$("#delconfirm").hide();	
		 
		$("#No").click(function(){
			$("#delconfirm").hide();
		});	
		
		$("#Ya").click(function(){
			var id = $("#del_id").val();
         
			$("#satuan_vaksin_"+id).remove();
			$.ajax({
					type :"POST",
					url  :"hapus_satuan.php",
					data :"id_satuan="+id,
					success : function(html){
						$("#confirm").html(html);
						$("#delconfirm").hide();	
						$("#confirm").fadeOut(5000);
						
					}
			});
			
		});
		
		$(".hapus_satuan").click(function(){
			var id = $(this).attr('id');
			$("#del_id").val(id);
			$("#delconfirm").show();
			
		});
			
       
		$(".edit_satuan").click(function(){
			var id = $(this).attr('id');
			document.location.href='edit_satuan.php?id='+id;
		})

        $('#input_satuan').click(function(){	
			document.location.href='satuan.php';
		});
		
	});

</script>
<style>
body {
	background-color:#ccc;
	font-family:Tahoma;
	font-size:13px;
}
.listobat tr.baris:hover {background:#8DE68A;cursor:pointer}
.atas {
	 font-weight:bold;
	 color:white;
	 }
 

</style>
</head>
<body>



	<div id="listview_container">

	<?php
	include "../../conf/openconn.php";
	include "../../lib/functions-php.php"; 	
 

    // JUMLAH DATA YANG DITAMPILKAN PER HALAMAN
      $dataPerPage = 20;
 
      // Apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut,
      // Sedangkan apabila belum, nomor halamannya 1.
      if(isset($_GET['page']))
      {
        $noPage = $_GET['page'];
      }
      else $noPage = 1;
 
      // Perhitungan offset
      $offset = ($noPage - 1) * $dataPerPage;
 
      
      echo "<h4>&nbsp;&nbsp;Hal : ".$noPage."</h4>";
 
      // MENGAMBIL DATA     
      $query = "SELECT * FROM satuan  ORDER BY id DESC LIMIT $offset, $dataPerPage";
 
      $result = mysqli_query($koneksi, $query) or die('Error');
 
      // Penomoran Item
      $nomor=1;
	  $nomor1=0;
      $nomor1 = (20 * $noPage)-20;
	  $tgl_skr = date('Y-m-d');
	
?>	
		<div class="form_description">
			<h2>&nbsp;&nbsp;Data Satuan Vaksin</h2>
		</div>		
		<input type='hidden' id='del_id'>	
	 
        &nbsp;&nbsp; <input type="button" name="inputsatuan" id="input_satuan" value="Input Data Satuan"> 
        <table class='listjenis' id="listjenis" width="30%" cellpadding="2" cellspacing="2" style='padding:0 10px 20px 10px'>
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
		<tr class='atas' bgcolor="#80857D">
			<td width="4%">No.</td>
			<td width="20%" style='text-align:center'>Jenis Vaksin</td>
			<td align="center" width="10%">Options</td>	
		</tr>
		 
		<?php
		
		$getdatastok = "Select * from satuan 
						GROUP BY id LIMIT $offset, $dataPerPage";
		$qrydatastok = mysqli_query($koneksi, $getdatastok);
		while ($print=mysqli_fetch_array($qrydatastok))
		{ 
			$nomer++;
			$id       =$print['id'];
            $nama     =$print['nama'];  
			 
		?>
		<tr class='baris' bgcolor='#eee' id='satuan_vaksin_<?php echo $id;?>'>
			 <td align="right"><?php echo $nomer;?>.</td>			 
			 <td><?php echo $nama;?></td>
			 <td align="center">
               <input type="button" class="edit_satuan" id="<?php echo $id;?>" value="E">
               <input type="button" class="hapus_satuan" id="<?php echo $id;?>" value="X">
             </td> 
			</tr>
		<?php }	?> 
		</table>
		<div id="confirm"></div>
		<?php
        
 
      // Mencari jumlah semua data tabel 'alamat', kemudian simpan dalam variabel $jumData
   
		$datastok = "Select * from satuan 
					 GROUP BY id LIMIT $offset, $dataPerPage";
        
		$hasil3  = mysql_query($koneksi,$datastok);

        $data3    = mysqli_fetch_array($hasil3);
 
        $jumData = $data3['jumData'];
        echo "<br><center>";
          if ($jumData > 10)
            {
 
              // Menentukan jumlah halaman yang muncul berdasarkan jumlah semua data
              $jumPage = ceil($jumData/$dataPerPage);
 
              // Menampilkan link 'Sebelum'   
              if ($noPage > 10) 
              {
              $getstok = "Select * from satuan
						GROUP BY id LIMIT $offset, $dataPerPage";

              $result = mysql_query($koneksi,$getstok) or die('Error');
 
              $data = mysqli_fetch_array($result);
 
              echo  "<a href='".$_SERVER['PHP_SELF']."?page=".($noPage-1)."'><< Back</a>";
               }
              // Menampilkan nomor halaman dan linknya
              for($page = 1; $page <= $jumPage; $page++)
              {
 
                if ((($page >= $noPage - 20) && ($page <= $noPage + 20)) || ($page == 1) || ($page == $jumPage))
                {
 
                  if (($showPage == 1) && ($page != 20))  echo "<a href='#'>...</a>";
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
 		<div id="stokbox">
		  <div id="formstok"></div>
		</div> 
	</div>
	</body>
</html>