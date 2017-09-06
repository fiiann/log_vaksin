<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Master Obat</title>
<link rel="stylesheet" type="text/css" href="../css/adminview.css" media="all">
<script type="text/javascript" src="../js/adminview.js"></script>
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet"/>
<script type="text/javascript">
	$(document).ready(function() {
		 
		  function getdataobat()
		  {
			var idpurchasing   = $("#idpurchasing").val();
			var tglpurchasing  = $("#tglpurchasing").val();
			var idpuskesmas	   = $("#idpuskesmas").val();
			
			var idorder  = [];
			var kodeobat = [];
			var qorder   = [];
			var qacc	 = [];
			var satuan   = [];
				
			$("input[name='idorder[]']:checked").each(function(){
				idorder.push($(this).val());
			});
			
			$("input[name='kodeobat[]']:checked").each(function(){
				kodeobat.push($(this).val());			
			});
				
			$("input[name='qtyorder[]']:checked").each(function(){
				qorder.push($(this).val());
			});	
			
			$("input[name='qty_acc[]']:checked").each(function(){
				qacc.push($(this).val());
			});
		
			$("input[name='satuanobat[]']:checked").each(function(){
				satuan.push($(this).val());				
			});
			
			
			if ((idorder.length>0) && (qorder.length>0) && (tglpurchasing.length>0)) 
			{
				$.ajax({
						type  :"POST",
						url	  :"simpan_purchasing.php",
						cache : false,
						data  : "idpurchasing="+idpurchasing+"&tglpurchasing="+tglpurchasing+"&idpuskesmas="+idpuskesmas+"&idorder="+idorder+"&kodeobat="+kodeobat+"&qtyorder="+qorder+"&qtyacc="+qacc+"&satuan="+satuan,
						success : function(html)
						{						
							$("#confirmsave").html(html);
							$("#prosesbox").dialog('close');
							document.location.href='listtrx_pkm.php';							
						}
				});
						
			}else{
				alert("Pastikan Kolom Tanggal tidak kosong, dan atau anda belum memilih data obat untuk diproses");
				return false;	
			}
		
		}
		
		 
		$("#prosesbox").dialog({
					autoOpen:false,
					width:800,
					height:'auto',
					title:'Prosesing Permintaan Vaksin', 
					position:['top',10],
					modal:true, 
					buttons:{
						'Simpan Proses' :function(){
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
					title:'Data Detil Permintaan Vaksin', 
					top:10, 
					modal:true, 
					buttons:{
						'Simpan' :function(){							
							var idproses = $("#idproses").val();
							var kode_ins = $("#kode_instansi").val();
						  
							$.ajax({
									type : 'post',
									url  : './save_approve.php',
									data : 'idproses='+idproses+'&kode_instansi='+kode_ins,
									success:function(html){
										alert(html);
									}
							})
						},	
						'Close' :function(){ 
							$(this).dialog('close');
						    }
						}
		 });


		  $("#viewbox").dialog({
					autoOpen:false,
					width:750,
					height:500,
					title:'Data Detil Permintaan Vaksin', 
					top:10, 
					modal:true, 
					buttons:{
						'Close' :function(){ 
							$(this).dialog('close');
						    }
						}
		 });
		 
		 
		 $(document).on('click','.detil',function(){
			var idorder 	= $(this).attr('id');
			var kdp		 	= $("#kode_instansi").val();
			var tglorder	= $("#tglorder").val();

		
 			$.ajax({
					type  :"POST",
					url   :"./getdetil_order.php",
					cache : false,
					data  : "idorder="+idorder+"&tglorder="+tglorder+"&kode_instansi="+kdp,
					success : function(html){
						$("#detilbox").dialog('open');
						$("#detilorder").html(html);					
					}

			});		
		 })


		  $(document).on('click','.view',function(){
			var idorder 	= $(this).attr('id');
			var kdp		 	= $("#kode_instansi").val();
			var tglorder	= $("#tglorder").val();

		
 			$.ajax({
					type  :"POST",
					url   :"./getdetil_order.php",
					cache : false,
					data  : "idorder="+idorder+"&tglorder="+tglorder+"&kode_instansi="+kdp,
					success : function(html){
						$("#viewbox").dialog('open');
						$("#vieworder").html(html);					
					}

			});		
		 })

		 
			
	});

</script>
<style>	
.listobat tr.baris:hover {background:#FCEDA9}
.atas {font-weight:bold;color:white}
</style>
</head>
<body bgcolor="#ffffff" >
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
     
      echo "<h4>Hal : ".$noPage."</h4>";
 
      // MENGAMBIL DATA     
      $query = "SELECT Distinct
					   t.id_proses 	
					  ,t.tanggal
					  ,t.kode_instansi
					  ,t.status
					  ,t.is_fix
					  ,i.nama
					  FROM amprahan t
					  inner join instansi i 
					   on t.kode_instansi=i.kode_instansi
					  WHERE t.is_fix=1
					  ORDER BY t.id_proses DESC LIMIT $offset, $dataPerPage"; 
      $result = mysql_query($query) or die('Error SQL sintaks '.mysql_error());
 
      // Penomoran Item
      $nomor=1;
	  $nomor1=0;
      $nomor1 = (10 * $noPage)-10;
	
?>		
	<div id="form_container">
	
 
		<div class="form_description">
			<h2>&nbsp;&nbsp;List Permintaan Vaksin</h2>
		</div>		
		<input type='hidden' id='del_id'>	
		<table class='list_amprahan' id="list_amprahan" width="100%" cellpadding="2" cellspacing="2" style='padding:0 10px 20px 10px'>
		
		<tr class='atas' bgcolor="#616161">
			<td width="4%" align="right">No.</td>
			<td width="25%">&nbsp;Nama Instansi</td>
			<td width="15%" style='text-align:center'>Tanggal Amprahan</td>
			<td width="10%">Status</td>
			<td width="4%" align='center'>detil</td>			
		</tr>
		 
		<?php
		//get data master obat
		 $get_trx = "SELECT Distinct
					   t.id_proses 	
					  ,t.tanggal
					  ,t.kode_instansi
					  ,t.status
					  ,t.is_fix
					  ,i.nama
					  FROM amprahan t
					  inner join instansi i 
					   on t.kode_instansi=i.kode_instansi
					  WHERE t.is_fix=1
					  ORDER BY t.id_proses DESC LIMIT $offset, $dataPerPage"; 
     	 $restrx = mysql_query($get_trx) or die('Error SQL sintaks '.mysql_error());
 
		
		while ($print=mysql_fetch_array($restrx))
		{ 
			$nomer++;
			$idorder  =$print['id_proses'];
			$tglorder =tgl_indo($print['tanggal']);
			$idp	  =$print['kode_instansi'];
			$nama     =$print['nama'];
			$status   =$print['status'];
			$isfix    =$print['is_fix'];

			if ($status=='0'){
				$color = 'red';
				$stat ='Proses';
			}else{
				$color = 'green';
				$stat ='Selesai';
			}

			echo "<input type='hidden' name='kode_instansi' id='kode_instansi' value='$idp'>";
			echo "<input type='hidden' name='tglorder' id='tglorder' value='$print[tanggal]'>"; 
		?>
			
			<tr class='baris' bgcolor="#eeeeee" id="dataobat_<?php echo $idorder?>">
			 <td align="right">
				<?php if ($noPage <= 1)
				{
				   echo $nomor++."<br>";
				}
				else
				{     
				   echo $nomor1=$nomor1+1 ."<br>";
				} ?>
			</td>
			 <td>&nbsp;<?php echo $nama;?></td>
			 <td align="center"><?php echo $tglorder;?></td>	 
			 <td align="center" bgcolor='<?php echo $color;?>'><?php echo $stat;?></td>
			 <td  align='center'>
			 <?php 
			 if($status==1){
				echo  "<input type='button' name='view' class='view' id='$idorder' value='view data'>";		 
			 }else{
				echo  "<input type='button' name='detil' class='detil' id='$idorder' value='detil data'>";		 
			 }?>
			 </td>	
			</tr>
		<?php }	?> 
		
		</table>
		<div id="confirmsave"></div>
		<?php
        
 
      // Mencari jumlah semua data tabel 'alamat', kemudian simpan dalam variabel $jumData
        $query3   = "SELECT COUNT(*) AS jumData FROM amprahan";
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
              $query = "SELECT * FROM trxvaksin";
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
	<div id="viewbox">
		<div id="vieworder"></div>
	</div>
	
	<div id="prosesbox">
		<div id="formpurchasing"></div>
	</div>
	</body>
</html>