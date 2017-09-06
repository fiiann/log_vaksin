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
			$("#stokvaksin_"+id).remove();
			$.ajax({
					type :"POST",
					url  :"hapus_stok.php",
					data :"id_jenis="+id,
					success : function(html){
						$("#confirm").html(html);
						$("#delconfirm").hide();	
						$("#confirm").fadeOut(5000);
						
					}
			});
			
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

        $('#inputstok').click(function(){	
			//alert('input');
			document.location.href='stok_vaksin.php';
			
		});

		$(".edit").click(function(){
			var id = $(this).attr('id');
			document.location.href='edit_stok.php?id='+id;
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
      $query = "SELECT * FROM master_stok  ORDER BY id_jenis DESC LIMIT $offset, $dataPerPage";
 
      $result = mysql_query($query) or die('Error');
 
      // Penomoran Item
      $nomor=1;
	  $nomor1=0;
      $nomor1 = (10 * $noPage)-10;
	
?>	
		<div class="form_description">
			<h2>&nbsp;&nbsp;Data Stok Vaksin</h2>
		</div>		
		<input type='hidden' id='del_id'>	
		<!--div id="periode" style="float:left;padding:2px 5px">&nbsp; Bulan  
        <select id="bulan">
            <?php
            $bulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            for($y=1;$y<=12;$y++){
            if($y==date("m")){ $pilih="selected";}
            else {$pilih="";}
            echo("<option value=\"$y\" $pilih>$bulan[$y]</option>"."\n");
            }
            ?>
            </select>
        
        
         Tahun : <select id="tahun">
            <?php   
            
             for ($i=0;$i<2;$i++){
                $x=$x+1;
                if ($x==date('Y')){ $pil="selected";}else{$pil="";}
                echo "<option value='$x' $pil>$x</option>";
              } 
            ?>
          </select>
        </div-->  

        <div id='button' style='padding-left:10px'><input type="button" name="inputstok" id="inputstok" value="Input Stok"></div>
        <table class='liststok' id="liststok" width="50%" cellpadding="2" cellspacing="2" style='padding:0 10px 20px 10px'>
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
			<td align="center" width="15%">Stok Tersedia</td>
			<td align="center" width="15%">Satuan</td>	
			<td width="10%" align='center'>Tool</td>			
		</tr>
		 
		<?php
		
		$getdatastok = "Select * from master_stok ORDER BY id_jenis ASC LIMIT $offset, $dataPerPage";
		$qrydatastok = mysql_query($getdatastok);
		while ($print=mysql_fetch_array($qrydatastok))
		{ 
			$nomer++;
			$id_jenis     =$print['id_jenis'];
            $jumlah       =$print['stok_tersedia'];
			$satuan       =$print['satuan'];

            $getnama = "SELECT nama from jenis_vaksin where id_jenis='".$id_jenis."'";
            $query   = mysql_query($getnama);
            while($nm=mysql_fetch_array($query)){
                $nama = $nm['nama'];

            }
           
			 
		?>
		<tr class='baris' bgcolor='#eee' id='stokvaksin_<?php echo $id_jenis;?>'>
			 <td align="right"><?php echo $nomer;?>.</td>			 
			 <td><?php echo $nama;?></td>
			 <td align="center"><?php echo $jumlah;?></td>
             <td align="center"><?php echo $satuan;?></td>
             
			 <td  align='center'>
				<input type='button' name='edit' class="edit" id="<?php echo $id_jenis;?>" value='E'>
				<input type='button' name='del' class="hapus" id="<?php echo $id_jenis;?>" value='X'>			
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
          if ($jumData > 10)
            {
 
              // Menentukan jumlah halaman yang muncul berdasarkan jumlah semua data
              $jumPage = ceil($jumData/$dataPerPage);
 
              // Menampilkan link 'Sebelum'   
              if ($noPage > 10) 
              {
              $query = "SELECT * FROM master_stok";
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
 		<div id="stokbox">
		  <div id="formstok"></div>
		</div> 
	</div>
	</body>
</html>