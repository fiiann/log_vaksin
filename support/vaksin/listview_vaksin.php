<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Data Master Vaksin</title>

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
		 
			$.ajax({
					type :"POST",
					url  :"hapus_datavaksin.php",
					data :"kode_batch="+id,
					success : function(html){
						$("#confirm").html(html);
						$("#delconfirm").hide();	
						$("#confirm").fadeOut(5000);
					}
			});
			$("#datavaksin_"+id).remove();
		});
		
		$(".hapus").click(function(){
			var id = $(this).attr('id');
			$("#del_id").val(id);
			$("#delconfirm").show();
			
		});
			
		$('#inputdata').click(function(){	
			//alert('input');
			document.location.href='master_vaksin.php';
			
		});
		
		
		
		/*$(".baris").click(function(){
			var id = $(this).attr('data-id');
			$.ajax({
					type : 'get',
					url  : 'formstok.php',
					data : 'kode_batch='+id,
					success:function(html){
						$("#formstok").html(html);
					}
			}) 
		})*/

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

		$(".grouping").change(function(){
			var id = $(this).val();
			$.ajax({
					type : 'post',
					url  : 'listview_vaksin.php',
					data : 'id_jenis='+id,
					success:function(html){
						$("#listview_container").html(html);
					}
			})
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
 
      
      echo "<h4>Hal : ".$noPage."</h4>";

	  if($_POST['id_jenis']!=''){
		   $idjn = $_POST['id_jenis'];
	  }else{
		   $idjn = '0';
	  }
	 

	  if($idjn==0){
		 $query = "SELECT * FROM master_vaksin  ORDER BY kode_batch DESC LIMIT $offset, $dataPerPage";
         $result = mysql_query($query) or die('Error');
 
	  }else{
	   $query = "SELECT * FROM master_vaksin WHERE id_jenis='$idjn' ORDER BY kode_batch DESC LIMIT $offset, $dataPerPage";
       $result = mysql_query($query) or die('Error');
	  }
      // MENGAMBIL DATA     
    
      // Penomoran Item
      $nomor=1;
	  $nomor1=0;
      $nomor1 = (20 * $noPage)-20;
	  $tskr = date('Y-m-d');
?>	
		<div class="form_description">
			<h2>&nbsp;&nbsp;Data Master Vaksin</h2>
		</div>		
		<input type='hidden' id='del_id'>	
		<div id='button' style='padding-left:12px'><input type="button" name="inputdata" id="inputdata" value="Input Data Vaksin">
		<span id="grup" style="float:right;padding-right:200px">
		   Tampil : <select class="grouping">
		   <option selected value='0'>Semua</option>
		   <?php
		   	  //get jenis vaksin
			  $jen = "SELECT id_jenis, nama from jenis_vaksin ORDER by id_jenis ASC";
			  $qjn = mysql_query($jen) or die (mysql_error());
			  while ($jn=mysql_fetch_array($qjn)){
				  $idj = $jn['id_jenis'];
				  $nmj = $jn['nama'];
				  
				  if($idj==$idjn){ $pilih="selected";}
				  else {$pilih="";}
				
				  echo "<option value='$idj' $pilih>$nmj</option>";
			  }
		   
		   ?>
		   
		   </select>
		   
	    </span>
		
		</div>
		
		<table class='listobat' id="listobat" width="85%" cellpadding="2" cellspacing="2" style='padding:0 10px 20px 10px'>
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
			<td width="10%">Kode Batch</td>
			<td width="10%" style='text-align:center'>Jenis Vaksin</td>
			<td width="10%" align="center">VVM</td>
			<td width="10%">Tgl Diterima</td>
			<td width="10%">Tgl Expired</td>
			<td width="10%">Stok</td>
			<td align="center" width="15%">Rentang Expired</td>	
			<td width="10%" align='center'>Tool</td>			
		</tr>
		 
		<?php
		 
	
		if($idjn=='0'){
			$getdataobat = "SELECT * from master_vaksin  ORDER BY kode_batch ASC LIMIT $offset, $dataPerPage";
			$qrydataobat = mysql_query($getdataobat);
	
		}else{
			$getdataobat = "SELECT * from master_vaksin WHERE id_jenis='$idjn' ORDER BY kode_batch ASC LIMIT $offset, $dataPerPage";
			$qrydataobat = mysql_query($getdataobat);
	
		}
		//get data master obat
		while ($print=mysql_fetch_array($qrydataobat))
		{ 
			$nomer++;
			$kode_batch   = $print['kode_batch'];
			$nama_vaksin  = $print['nama'];
			$vvm 		  = $print['vvm'];
			$tgl_diterima =tgl_eng_to_ind($print['tgl_terima']);
			$exp	  	  =tgl_eng_to_ind($print['tgl_expired']);
			$stok         = $print['stok'];

			
			//ambil selisih tanggal sekarang dengan tanggal expired pada database
			//--tgl exp dari database--//
			$tgl_exp   = $print['tgl_expired'];
			$pecah_exp = explode("-",$tgl_exp);
			$tgl_exp   = $pecah_exp[2];
			$bln_exp   = $pecah_exp[1];
			$thn_exp   = $pecah_exp[0];
			
			//--tgl skr--//
			$datenow   = date("Y-m-d");
			$pecah_skr = explode("-",$datenow);
			$tgl_skr   = $pecah_skr[2];
			$bln_skr   = $pecah_skr[1];
			$thn_skr   = $pecah_skr[0];
			
			//hitung selisih
			$jd1 = GregorianToJD($bln_exp, $tgl_exp, $thn_exp);
			$jd2 = GregorianToJD($bln_skr, $tgl_skr, $thn_skr);
			$selisih = $jd1 - $jd2;
			 
			if ($selisih>=365){
				$tahun  = floor($selisih/365);
				$bulan  = floor(($selisih%365)/30);	
				$hari   = floor($selisih - ($tahun*365) - ($bulan*30));
				$hasil  = $tahun. " Thn/".$bulan." Bln/".$hari." Hari";
			}
			else if (($selisih>=30) && ($selisih<365))
			{
				$tahun  = floor($selisih/365);
				$bulan  = floor(($selisih%365)/30);	
				$hari   = floor($selisih - ($tahun*365) - ($bulan*30));
				$hasil  = $bulan." Bln/".$hari." Hari";
				 
			}else if ($selisih<=29) {
				$hasil = $selisih." Hari";
			}
			
			if (($selisih<30) && ($selisih>=1))
			{
				$warna = 'red';
			}else{
				$warna = 'green';
			}
			
			if ($hasil<=0)
			{
				$warna = 'red';
				$hasil = 'Vaksin Expired';
				//insert ke tabel vaksin expired 
				$ket ='date';
				//cek 
				$ck = "SELECT kode_batch from expired_stok where kode_batch='$kode_batch'";
				$qc = mysql_query($ck) or die (mysql_error());
				$ono= mysql_num_rows($qc);
				if ($ono!=0){
					
				}else{
					 

					$inexp = "INSERT INTO expired_stok SET 
					kode_batch='$kode_batch',
					id_jenis='$jenis',
					stok_exp='$stok',
					tgl_exp='$datenow',
					keterangan='$ket'";

			     $qxp = mysql_query($inexp) or die (mysql_error());

				}
			 	
			}
			
			 
			$jenis	  =$print['id_jenis'];
			$sqljenis = "select nama from jenis_vaksin where id_jenis='".$jenis."'";
			$qryjenis = mysql_query($sqljenis);
			while ($data_cat = mysql_fetch_array($qryjenis))
			{
				$nama_jenis = $data_cat['nama'];			
			}			
			
		 			
			if (($hasil<=1) || ($stok==0))
			{
				echo "<tr class='baris' bgcolor='#FA6464' id='datavaksin_$kode_batch' data-id='$kode_batch' style='display:none'>";
			
			}else{
				echo "<tr class='baris' bgcolor='#eeeeee' id='datavaksin_$kode_batch' data-id='$kode_batch'>";			
			}

			if (($vvm=='C') || ($vvm=='D')){
				$bgcolor = 'maroon';
				echo "<tr class='baris' bgcolor='$bgcolor' id='datavaksin_$kode_batch' data-id='$kode_batch' style='display:none'>";
				$hasil = 'Expired by VVM';
				$warna = 'maroon';
			}
			

		?>
		
			 <td align="right">
			  <?php if ($noPage <= 1)
           	 {
                echo $nomor++."<br>";
             }else{     
                echo $nomor1=$nomor1+1 ."<br>";
             }?>
			 
			 </td>			 
			 <td><?php echo $kode_batch;?></td>
			 <td><?php echo $nama_jenis;?></td>
			 <td align="center"><?php echo $vvm;?></td>
			 <td align="center"><?php echo $tgl_diterima;?></td>
			 <td align="center"><?php echo $exp;?></td>		
			 <td align="right"><?php echo $stok;?></td>
			 <td bgcolor="<?php echo $warna;?>" style='text-align:right;font-weight:bold;color:white'><?php echo $hasil."&nbsp;"?></td>		 
			 <td  align='center'>
				<input type='button' name='edit' class="edit" id="<?php echo $kode_batch?>" value='E'>
				<input type='button' name='del' class="hapus" id="<?php echo $kode_batch?>" value='X'>			
			 </td>	
			</tr>
		<?php }	?> 
		
		</table>
		<div id="confirm"></div>
		<?php
        
 
      // Mencari jumlah semua data tabel 'alamat', kemudian simpan dalam variabel $jumData
        $query3   = "SELECT COUNT(*) AS jumData FROM master_vaksin";
        $hasil3  = mysql_query($query3);
        $data3    = mysql_fetch_array($hasil3);
 
        $jumData = $data3['jumData'];
        echo "<br><center>";
          if ($jumData > 20)
            {
 
              // Menentukan jumlah halaman yang muncul berdasarkan jumlah semua data
              $jumPage = ceil($jumData/$dataPerPage);
 
              // Menampilkan link 'Sebelum'   
              if ($noPage > 20) 
              {
              $query = "SELECT * FROM master_vaksin";
              $result = mysql_query($query) or die('Error');
 
              $data = mysql_fetch_array($result);
 
              echo  "<a href='".$_SERVER['PHP_SELF']."?page=".($noPage-1)."'><< Back</a>";
               }
              // Menampilkan nomor halaman dan linknya
              for($page = 1; $page <= $jumPage; $page++)
              {
 
                if ((($page >= $noPage - 20) && ($page <= $noPage + 20)) || ($page == 1) || ($page == $jumPage))
                {
 
                  if (($showPage == 1) && ($page != 20))  echo "<a href='#'></a>";
                 // if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "<a href='#'>...</a>";
                  if ($page == $noPage) echo "<a href='#' style='background-color:#000;font-weight:bold;color:white;text-decoration:none;padding:2px 4px 2px 4px'>".$page."</a>";
                  else echo " <a href='".$_SERVER['PHP_SELF']."?page=".$page."' style='text-decoration:none;padding:2px 4px 2px 4px'>".$page."</a> ";
                  $showPage = $page;
                }
              }
 
            
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