<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Data User</title>
<link rel="stylesheet" type="text/css" href="../../css/view.css" media="all">
<script type="text/javascript" src="../../js/view.js"></script>
<script type="text/javascript" src="../../js/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../../js/jquery/jquery/jquery-ui-1.8.18.custom.min.js"></script>
<link type="text/css" href="../../css/jquery/jquery-ui-1.8.18.custom.css" rel="stylesheet"/>
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
					url  :"hapus_datauser.php",
					data :"iduser="+id,
					success : function(html){
						$("#confirm").html(html);
						$("#delconfirm").hide();	
						$("#confirm").fadeOut(5000);
					}
			});
			$("#datauser_"+id).remove();
		});
		
		$(".hapus").click(function(){
			var id = $(this).attr('id');
			$("#del_id").val(id);
			$("#delconfirm").show();
			
			 
			//	
			
		});
			
	});

</script>

</head>
<body id="main_body" >
<?php
	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php"; 	
	
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
 
      
      echo "<h4>Hal : ".$noPage."</h4>";
 
      // MENGAMBIL DATA     
      $query = "SELECT * FROM user ORDER BY iduser DESC LIMIT $offset, $dataPerPage";
 
      $result = mysql_query($query) or die('Error');
 
      // Penomoran Item
      $nomor=1;
	  $nomor1=0;
      $nomor1 = (10 * $noPage)-10;
	
?>	
	
	<img id="top" src="../../images/top.png" alt="">
	<div id="listview_container">
	
		<h1><a>Data Master Obat</a></h1>
		<div class="form_description">
			<h2>&nbsp;&nbsp;Data User</h2>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;data User Sisfo Pengelolaan Obat</p>
		</div>		
		<input type='hidden' id='del_id'>	
		<table id="listobat" width="100%" cellpadding="2" cellspacing="2" style='padding:0 10px 20px 10px'>
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
		<tr bgcolor="#D6EDB2">
			<td width="4%">No.</td>
			<td width="7%">ID User</td>
			<td width="15%">Nama User</td>
			<td width="35%" style='text-align:center'>Alamat</td>
			<td width="10%" style='text-align:center'>Username</td>
			<td width="15%" style='text-align:center'>Password</td>
			<td width="10%" style='text-align:center'>Akses</td>
			<td width="4%">Hapus</td>
			
		</tr>
		 
		<?php
		//get data master obat
		$getdataobat = "Select * from user ORDER BY iduser ASC LIMIT $offset, $dataPerPage";
		$qrydataobat = mysql_query($getdataobat);
		while ($print=mysql_fetch_array($qrydataobat))
		{ 
			$nomer++;
			$iduser   =$print['iduser'];
			$namauser =$print['namauser'];
			$alamat   =$print['alamatuser'];
			$username =$print['username'];
			$password =$print['password'];
			$akses	  =$print['idakses'];
			
			if ($akses==0)
			{
				$akses_txt = 'Administrator';
			}else{
				$akses_txt = 'Public User';
			}
			
		?>
		
			<tr bgcolor="#eeeeee" id="datauser_<?php echo $iduser?>">
			 <td align="right"><?php echo $nomer;?>.</td>			 
			 <td><a href="../user/edit_user.php?iduser=<?php echo $iduser;?>"><?php echo $iduser;?></td>
			 <td><?php echo $namauser;?></td>
			 <td><?php echo $alamat;?></td>
			 <td><?php echo $username;?></td>
			 <td align='center'><?php echo $password;?></td>
			 <td><?php echo $akses_txt;?></td>
			 <td><input type='button' name='del' class="hapus" id="<?php echo $iduser?>" value='X'></td>	
			</tr>
		<?php }	?> 
		
		</table>
		<div id="confirm"></div>
		<?php
        
 
      // Mencari jumlah semua data tabel 'alamat', kemudian simpan dalam variabel $jumData
        $query3   = "SELECT COUNT(*) AS jumData FROM user";
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
              $query = "SELECT * FROM user";
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
 		<div id="footer_view">
			Sisfo Pengelolaan Obat <a href="">2014</a>
		</div>
	</div>
	<img id="bottom" src="../../images/bottom.png" alt="">
	</body>
</html>