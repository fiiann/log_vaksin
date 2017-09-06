<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Master Obat</title>
<link rel="stylesheet" type="text/css" href="../css/adminview.css" media="all">
<script type="text/javascript" src="../js/adminview.js"></script>
<script type="text/javascript" src="../../js/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../../js/jquery/jquery-ui-1.9.2.custom.min.js"></script>
<link type="text/css" href="../../css/jquery-ui.css" rel="stylesheet"/>
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
							document.location.href='listview_transaksi.php';							
						}
				});
						
			}else{
				alert("Pastikan Kolom Tanggal Purchasing tidak kosong, dan atau anda belum memilih data obat untuk diproses");
				return false;	
			}
		
		}
		
		 
		 
		 	$("#boxpdf").dialog({
					autoOpen:false,
					width:850,
					height:'auto',
					title:'Convert Order to PDF', 
					position:'top',
					top:20, 
					modal:true, 
					buttons:{
						'Close' :function(){ 
							$(this).dialog('close');
						    }
						}
			});
			
		 $("#detilbox").dialog({
					autoOpen:false,
					width:900,
					height:530,
					title:'Data Detil Permintaan Vaksin', 
					top:10, 
					modal:true, 
					buttons:{
						'Cetak Order' :function(){							
							 var idorder	 = $("#idorder").val();
						  	 var tglorder = $("#tglorder").val();			
							 $.post("print_pdfprov.php",{idorder:idorder, tglorder:tglorder},function(result)
							 {	 $("#boxpdf").dialog('open');
								 $("#content").html(result);
								 });
						},	
						'Close' :function(){ 
							$(this).dialog('close');
						    }
						}
		 });
		 
		 
		 $(".detil").click(function(){
			var idorder 	= $(this).attr('id');
			var tglorder	= $("#tglorder").val();
 			$.ajax({
					type  :"POST",
					url   :"detil_order_prov.php",
					cache : false,
					data  : "idorder="+idorder+"&tglorder="+tglorder,
					success : function(html){
						$("#detilbox").dialog('open');
						$("#detilorder").html(html);					
					}

			});	
		 });
			
	});

</script>
<style>	
.listobat tr.baris:hover {background:#FCEDA9}
.atas {font-weight:bold;color:white}
</style>
</head>
<body bgcolor="#ffffff" >
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
      $query = "SELECT Distinct
					   t.idorder 	
					  ,t.tgl_order
					  ,td.idorder
					  ,td.is_order
					  FROM trxprov t
					  INNER JOIN trxprov_detil td
						on t.idorder=td.idorder 
					  WHERE td.is_order=0	
					  ORDER BY t.idorder DESC LIMIT $offset, $dataPerPage"; 
      $result = mysql_query($query) or die('Error SQL sintaks '.mysql_error());
 
      // Penomoran Item
      $nomor=1;
	  $nomor1=0;
      $nomor1 = (10 * $noPage)-10;
	
?>		
	<div id="form_container">
	
		<h1><a>List Permintaan Vaksin</a></h1>
		<div class="form_description">
			<h2>&nbsp;&nbsp;List Permintaan Vaksin Provinsi</h2>
		</div>		
		<input type='hidden' id='del_id'>	
		<table class='listobat' id="listobat" width="100%" cellpadding="2" cellspacing="2" style='padding:0 10px 20px 10px'>
		
		<tr class='atas' bgcolor="#616161">
			<td width="4%" align="right">No.</td>
			<td width="15%">&nbsp;ID Transaksi</td>
			<td width="15%" style='text-align:center'>Tanggal Transaksi</td>
			<td width="4%" align='center'>detil</td>			
		</tr>
		 
		<?php
		//get data master obat
		$getdataobat = "SELECT Distinct 
					   t.idorder	
					  ,t.tgl_order
					  ,td.idorder
					  ,td.is_order
					  FROM trxprov t
					  INNER JOIN trxprov_detil td
						on t.idorder=td.idorder 
					  WHERE td.is_order=0	
					  ORDER BY t.idorder DESC LIMIT $offset, $dataPerPage";
		$qrydataobat = mysql_query($getdataobat);
		while ($print=mysql_fetch_array($qrydataobat))
		{ 
			$nomer++;
			$idorder  =$print['idorder'];
			$tglorder =tgl_indo($print['tgl_order']);
			 
		
			echo "<input type='hidden' name='tglorder' id='tglorder' value=$print[tgl_order]>";
		 
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
			 <td>&nbsp;<?php echo $idorder;?></td>
			 <td align="center"><?php echo $tglorder;?></td>	 
			 <td  align='center'><input type='button' name='detil' class="detil" id="<?php echo $idorder?>" value='detil data'></td>	
			</tr>
		<?php }	?> 
		
		</table>
		<div id="confirmsave"></div>
		<?php
        
 
      // Mencari jumlah semua data tabel 'alamat', kemudian simpan dalam variabel $jumData
        $query3   = "SELECT COUNT(*) AS jumData FROM trxprov";
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
              $query = "SELECT * FROM trxprov";
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
	<div id="boxpdf" style="float:center">
		<div id="content" ></div>
	</div>
	<div id="detilbox">
		<div id="detilorder"></div>
	</div>
	<div id="prosesbox">
		<div id="formpurchasing"></div>
	</div>
	</body>
</html>