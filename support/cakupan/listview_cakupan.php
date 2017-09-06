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
         $('#inputcakupan').click(function(){	
			//alert('input');
			document.location.href='input_cakupan.php';
			
		});
		
		var hapusconfirm = $("<span id='text'>&nbsp;&nbsp;&nbsp;<font size='3'>Yakin Data akan dihapus?</font></span> <input type='button' id='Ya' value='Ya'> <input type='button' id='No' value='Tidak'>");
		$("#delconfirm").html(hapusconfirm); 
		
		$("#delconfirm").hide();	
		 
		$("#No").click(function(){
			$("#delconfirm").hide();
		});	
		
		$("#Ya").click(function(){
			var idx   = $("#del_id").val();
			var jstok = $("#jml_stok").val();
			$("#stokvaksin_"+idx).remove();
			$.ajax({
					type :"POST",
					url  :"hapus_cakupan.php",
					data :"idx="+idx,
					success : function(html){
						$("#confirm").html(html);
						$("#delconfirm").hide();	
						$("#confirm").fadeOut(5000);
						
					}
			});
			
		});
		
		$(".hapus_ckp").click(function(){
			var id = $(this).attr('id');
			var st = $(this).attr('data-stok');

			$("#del_id").val(id);
			$("#jml_stok").val(st);
			$("#delconfirm").show();
			
		});

		$(".edit_ckp").click(function(){
			var idx = $(this).attr('id');
			$.ajax({
					type : 'get',
					url  : 'edit_cakupan.php',
					data : 'idx='+idx,
					success:function(html){
						$("#listview_container").html(html);
					}
			})
		})

			$("#bulan").change(function(){
			var bln = $(this).val();
			var thn = $("#tahun").val();
			$.ajax({
				   type :'post',
				   url  : 'listview_cakupan.php',
				   data : 'bulan='+bln+'&tahun='+thn,
				   success:function(html){
					   $("#listview_container").html(html);
				   }
			})
		})

		$("#tahun").change(function(){
			var bln = $("#bulan").val();
			var thn = $(this).val();
			$.ajax({
				   type :'post',
				   url  : 'listview_cakupan.php',
				   data : 'bulan='+bln+'&tahun='+thn,
				   success:function(html){
					   $("#listview_container").html(html);
				   }
			})
		})
        
    })		 

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

	$now = date('Y-m');
	$xnow = explode("-",$now);

	$xtahun=$xnow[0];
	$xbulan=$xnow[1];

	

	$tahunnow = date('Y');
    $x=$tahunnow-2; 
    
    if (isset($_POST['bulan']))
    {
		$bulan = $_POST['bulan'];		    	
    }
    else {
    	echo "gak ada bualn";
    }

	// $bulan = $_POST['bulan'];
	$tahun = $_POST['tahun'];

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
 
      echo "<h4>&nbsp;&nbsp;Hal : ".$noPage."</h4>";

      // MENGAMBIL DATA     
	  if ($_POST['bulan'] || $_POST['tahun']){
		   $query = "SELECT * FROM data_cakupan where bulan='".$bulan."' and tahun='".$tahun."'  ORDER BY id_jenis DESC LIMIT $offset, $dataPerPage";
           $result = mysqli_query($koneksi,$query) or die('Error');
	  }else{
		   $query = "SELECT * FROM data_cakupan where bulan='".$xbulan."' and tahun='".$xtahun."' ORDER BY id_jenis DESC LIMIT $offset, $dataPerPage";
 	       $result = mysqli_query($koneksi, $query) or die('Error');
 
	  }
     
      // Penomoran Item
      $nomor=1;
	  $nomor1=0;
      $nomor1 = (10 * $noPage)-10;
	
?>	
		<div class="form_description">
			<h2>&nbsp;&nbsp;Data Cakupan</h2>
		</div>		
		<input type='hidden' id='del_id'>	
		<input type='hidden' id='jml_stok'>	
		
		<div id="periode" style="float:left;padding:2px 5px">&nbsp; Bulan  
        
        <select name="bulan" id="">
        	<?php 
        		$month = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
					for($y=1;$y<=12;$y++){
						if($y==date("m")){ $pilih="selected";}
						else {$pilih="";}
						echo("<option value=\"$y\" $pilih>$month[$y]</option>"."\n");
          			  }
        	 ?>
        </select>

		

        <div id='button' style='padding-left:450px'><input type="button" name="inputcakupan" id="inputcakupan" value="Input Cakupan"></div>
        <br>
		<table class='liststok' id="liststok" width="70%" cellpadding="2" cellspacing="2" style='padding:0 10px 20px 10px'>
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
			<td align="center" width="15%">Jml Cakupan</td>
			<td width="10%" align='center'>Tool</td>			
		</tr>
		 
		<?php
		if ($_POST['bulan'] || $_POST['tahun']){
			$getdatastok = "SELECT * from data_cakupan where bulan='".$bulan."' and tahun='".$tahun."' ORDER BY id_jenis ASC LIMIT $offset, $dataPerPage";
			$qrydatastok = mysqli_query($koneksi,$koneksi,$getdatastok);
	
		}else{
			$getdatastok = "SELECT * from data_cakupan where bulan='".$xbulan."' and tahun='".$xtahun."' ORDER BY id_jenis ASC LIMIT $offset, $dataPerPage";
			$qrydatastok = mysqli_query($koneksi,$koneksi,$getdatastok);
		} 
		while ($print=mysqli_fetch_array($qrydatastok))
		{ 
			$nomer++;
			$idx          =$print['idx'];
			$id_jenis     =$print['id_jenis'];
            $jumlah       =$print['jumlah'];
		
            $getnama = "SELECT nama from jenis_vaksin where id_jenis='".$id_jenis."'";
            $query   = mysqli_query($koneksi,$koneksi,$getnama);
            while($nm=mysqli_fetch_array($query)){
                $nama = $nm['nama'];
				 
            }
           
			 
		?>
		<tr class='baris' bgcolor='#eee' id='stokvaksin_<?php echo $idx;?>'>
			 <td align="right"><?php echo $nomer;?>.</td>			 
			 <td><?php echo $nama;?></td>
			 <td align="center"><?php echo $jumlah;?></td>
             
			 <td  align='center'>
				<input type='button' name='edit' class="edit_ckp" id="<?php echo $idx;?>" value='E'>
				<input type='button' name='del' class="hapus_ckp" id="<?php echo $idx;?>" data-stok="<?php echo $jumlah;?>" value='X'>			
			 </td>	
			</tr>
		<?php }	?> 
		
		</table>
		<div id="confirm"></div>
		<?php
        
 
      // Mencari jumlah semua data tabel 'alamat', kemudian simpan dalam variabel $jumData
        $query3   = "SELECT COUNT(*) AS jumData FROM data_cakupan";
        $hasil3  = mysqli_query($koneksi,$query3);
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
              $query = "SELECT * FROM data_cakupan";
              $result = mysqli_query($koneksi,$query) or die('Error');
 
              $data = mysqli_fetch_array($result);
 
            //  echo  "<a href='".$_SERVER['PHP_SELF']."?page=".($noPage-1)."'><< Back</a>";
               }
              // Menampilkan nomor halaman dan linknya
              for($page = 1; $page <= $jumPage; $page++)
              {
 
                if ((($page >= $noPage - 10) && ($page <= $noPage + 10)) || ($page == 1) || ($page == $jumPage))
                {
 
                  if (($showPage == 1) && ($page != 10))  echo "<a href='#'></a>";
               //   if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "<a href='#'>...</a>";
                  if ($page == $noPage) echo "<a href='#' style='text-decoration:none;padding:2px 4px 2px 4px;background-color:#000;color:white;font-weight:bold'>".$page."</a>";
                  else echo " <a href='".$_SERVER['PHP_SELF']."?page=".$page."' style='text-decoration:none'>".$page."</a> ";
                  $showPage = $page;
                }
              }
 
              // Menampilkan link 'Sesudah'
           /*   if ($noPage < $jumPage) 
              echo "<a href='".$_SERVER['PHP_SELF']."?page=".($noPage+1)."'>Next >></a>";*/
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