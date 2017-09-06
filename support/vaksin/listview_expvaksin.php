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
			var idx   = $("#del_id").val();
			var jstok = $("#jml_stok").val();
			$("#stokvaksin_"+idx).remove();
			$.ajax({
					type :"POST",
					url  :"hapus_stok_exp.php",
					data :"idx="+idx+'&jml_stok='+jstok,
					success : function(html){
						$("#confirm").html(html);
						$("#delconfirm").hide();	
						$("#confirm").fadeOut(5000);
						
					}
			});
			
		});
		
		$(".hapus_exp").click(function(){
			var id = $(this).attr('id');
			var st = $(this).attr('data-stok');

			$("#del_id").val(id);
			$("#jml_stok").val(st);
			$("#delconfirm").show();
			
		});
			
		$('#inputdata').click(function(){	
			//alert('input');
			document.location.href='master_vaksin.php';
			
		});
		
		$('#inputjenis').click(function(){	
			document.location.href='jenis_vaksin.php';
		});
		
		$(".baris").click(function(){
			var id = $(this).attr('data-id');
			$.ajax({
					type : 'get',
					url  : 'formstok.php',
					data : 'kode_batch='+id,
					success:function(html){
						$("#formstok").html(html);
					}
			}) 
		})

		$(".edit").click(function(){
			var kode_batch = $(this).attr('id');
			$.ajax({
					type : 'get',
					url  : 'edit_vaksin.php',
					data : 'kode_batch='+kode_batch,
					success:function(html){
						$("#listview_container").html(html);
					}
			})
		})

        $('#inputstokexpired').click(function(){	
			//alert('input');
			document.location.href='stok_vaksin_expired.php';
			
		});

		$(".edit_exp").click(function(){
			var id = $(this).attr('id');
			document.location.href='edit_stok_exp.php?id='+id;
		})
 
		$("#bulan").change(function(){
			var bln = $(this).val();
			var thn = $("#tahun").val();
			$.ajax({
				   type :'post',
				   url  : 'listview_expvaksin.php',
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
				   url  : 'listview_expvaksin.php',
				   data : 'bulan='+bln+'&tahun='+thn,
				   success:function(html){
					   $("#listview_container").html(html);
				   }
			})
		})

		$("#export_to_excel").click(function(){	
			var bln = $("#bulan").val();
			var thn = $("#tahun").val();
			window.open('../transaksi/expired_excel.php?bulan='+bln+'&tahun='+thn);
		})
		
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
	    
	$tahun = date('Y');
    $x=$tahun-2; 
    
	$bulan = $_POST['bulan'];
	$tahun = $_POST['tahun'];

    // JUMLAH DATA YANG DITAMPILKAN PER HALAMAN
      $dataPerPage = 15;
 
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
		   $query = "SELECT * FROM expired_stok where month(tgl_exp)=$bulan and year(tgl_exp)=$tahun   ORDER BY id_jenis DESC LIMIT $offset, $dataPerPage";
           $result = mysqli_query($koneksi,$query) or die('Error');
	  }else{
		   $query = "SELECT * FROM expired_stok  ORDER BY id_jenis DESC LIMIT $offset, $dataPerPage";
 	       $result = mysqli_query($koneksi,$query) or die('Error');
	  }
      $ono = mysql_num_rows($result);
      // Penomoran Item
      $nomor=1;
	  $nomor1=0;
      $nomor1 = (15 * $noPage)-15;
	  
?>	
		<div class="form_description">
			<h2>&nbsp;&nbsp;Data Stok Vaksin Expired</h2>
		</div>		
		<input type='hidden' id='del_id'>	
		<input type='hidden' id='jml_stok'>	
		<br><br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		<?php
		if ($ono!=0){
			echo '<input type="button" id="export_to_excel" value="Export Excel">';
		}else{
		    echo '';
		}?>
		
		<div id="periode" style="float:left;padding:2px 5px">&nbsp; Bulan  
        <select id="bulan">
            <?php
			if ($_POST['bulan'] || $_POST['tahun']){
				    $month = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
					for($y=1;$y<=12;$y++){
						if($y==$bulan){ $pilih="selected";}
						else {$pilih="";}
						echo("<option value=\"$y\" $pilih>$month[$y]</option>"."\n");
          			  }
         
			}else{
				   $month = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
					for($y=1;$y<=12;$y++){
						if($y==date("m")){ $pilih="selected";}
						else {$pilih="";}
						echo("<option value=\"$y\" $pilih>$month[$y]</option>"."\n");
          			  }
         
			}
            ?>
            </select>
        
        
         Tahun : <select id="tahun">
            <?php   
            if($_POST['bulan'] || $_POST['tahun']){
				for ($i=0;$i<2;$i++){
					$x=$x+1;
					if ($x==$tahun){ $pil="selected";}else{$pil="";}
					echo "<option value='$x' $pil>$x</option>";
             	 } 	
			}else{
			   for ($i=0;$i<2;$i++){
					$x=$x+1;
					if ($x==date('Y')){ $pil="selected";}else{$pil="";}
					echo "<option value='$x' $pil>$x</option>";
             	 } 
			}
            
            ?>
          </select>
        </div>  
		<br><br> 
        <table width='45%'>
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
			<td width='10%'>Kode Batch</td>
			<td width="15%" style='text-align:center'>Jenis Vaksin</td>
			<td align="center" width="10%">Jml Expired</td>
			<td align="center" width="15%">Keterangan</td>	
 		
		</tr>
		 
		<?php
		if ($_POST['bulan'] || $_POST['tahun']){
			$getdatastok = "Select * from expired_stok where month(tgl_exp)=$bulan and year(tgl_exp)=$tahun  ORDER BY id_jenis ASC LIMIT $offset, $dataPerPage";
			$qrydatastok = mysqli_query($koneksi,$getdatastok);
	
		}else{
			$getdatastok = "Select * from expired_stok ORDER BY id_jenis ASC LIMIT $offset, $dataPerPage";
			$qrydatastok = mysqli_query($koneksi,$getdatastok);
	
		} 
		while ($print=mysql_fetch_array($qrydatastok))
		{ 
			$nomer++;
			$idx          =$print['idx'];
			$kodebatch    =$print['kode_batch'];
			$id_jenis     =$print['id_jenis'];
            $jumlah       =$print['stok_exp'];
			$ket          =$print['keterangan'];
			 
			if ($ket=='vvm'){
				$ket='Expired by Status VVM';
			}else{
				$ket='Expired by date';
			}

            $getnama = "SELECT nama from jenis_vaksin where id_jenis='".$id_jenis."'";
            $query   = mysqli_query($koneksi,$getnama);
            while($nm=mysql_fetch_array($query)){
                $nama = $nm['nama'];

            }
           
			 
		?>
		<tr class='baris' bgcolor='#eee' id='stokvaksin_<?php echo $idx;?>'>
			 <td align="right"><?php echo $nomer;?>.</td>	
			 <td><?php echo $kodebatch;?></td>		 
			 <td><?php echo $nama;?></td>
			 <td align="center"><?php echo $jumlah;?></td>
             <td align="center"><?php echo $ket;?></td>
             
		 
			</tr>
		<?php }	?> 
		
		</table>
		<div id="confirm"></div>
		<?php
        
 
      // Mencari jumlah semua data tabel 'alamat', kemudian simpan dalam variabel $jumData
        $query3   = "SELECT COUNT(*) AS jumData FROM expired_stok";
        $hasil3  = mysqli_query($koneksi,$query3);
        $data3    = mysql_fetch_array($hasil3);
 
        $jumData = $data3['jumData'];
        echo "<br><center>";
          if ($jumData > 15)
            {
 
              // Menentukan jumlah halaman yang muncul berdasarkan jumlah semua data
              $jumPage = ceil($jumData/$dataPerPage);
 
              // Menampilkan link 'Sebelum'   
              if ($noPage > 15) 
              {
              $query = "SELECT * FROM expired_stok";
              $result = mysqli_query($koneksi,$query) or die('Error');
 
              $data = mysql_fetch_array($result);
 
              echo  "<a href='".$_SERVER['PHP_SELF']."?page=".($noPage-1)."'><< Back</a>";
               }
              // Menampilkan nomor halaman dan linknya
              for($page = 1; $page <= $jumPage; $page++)
              {
 
                if ((($page >= $noPage - 15) && ($page <= $noPage + 15)) || ($page == 1) || ($page == $jumPage))
                {
 
                  if (($showPage == 1) && ($page != 15))  echo "<a href='#'>...</a>";
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