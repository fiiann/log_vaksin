<style>
.head,.keterangan {font-size:12px;text-align:left;} 
.row:hover{font-size:12px;background:#F5BC00}
.row{font-size:12px;}
.top {font-size:12px;font-weight:bold;color:white}
#text{font-weight:normal;color:black;padding-left:5px;}
</style>
<script type="text/javascript">
		$(document).ready(function() {
			$("#TbPDF").click(function(){
				var idorder	 = $("#idorder").val();
				var tglorder = $("#tglorder").val();
				var idpus	 = $("#idpuskesmas").val();
			
			$.post("../transaksi/print_pdforder.php",{idorder:idorder, tglorder:tglorder, idpuskesmas:idpus},function(result)
				{
					$("#boxpdf").dialog('open');
					$("#content").html(result);					 
					});
			});
			
				 
			$(".cek").click(function()
			{
				var id=$(this).attr('id');						
			}).change(function(){
				var id=$(this).attr('id');
			if ($("#checkacc_"+id).is(":checked"))
			{
				if ($("#jmlorder_"+id).val()>0)
				{
					$("#kodeobat_"+id).attr("checked","checked");
				}else{
					$("#checkacc_"+id).attr("checked",false);
					alert("Pastikan Jumlah Order bukan 0");
					$(".ui-dialog-buttonpane button:contains('Proses')").button("disable");							
				}
			}
			else if (!$("#checkacc_"+id).is(":checked"))
			{
			
				$("#kodeobat_"+id).attr("checked",false);
				$("#namaobat_"+id).attr("checked",false);
			}		
		
		});
			
			
			
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

		   $("#approval_dialog").dialog({
					autoOpen:false,
					width:600,
					height:400,
					title:'Detil Approval Amprahan Vaksin', 
					position:'top',
					top:20, 
					modal:true, 
					buttons:{
						'Close':function(){ 
							$(this).dialog('close');
						}
					}
		   })		

			$("#amprah_dialog").dialog({
					autoOpen:false,
					width:600,
					height:400,
					title:'Proses Pemenuhan Amprah Vaksin', 
					position:'top',
					top:20, 
					modal:true, 
					buttons:{
						'Proses':function(){
							var kode_batch = [];
							var jml_stj    = [];
							var stokv      = [];
							var idproses   = $("#idproses").val();
							var idjenis    = $("#id_jenis").val();
							var nomer      = $("#nomer").val();

							$("input[name='kode_batch[]']").each(function(){
								kode_batch.push($(this).val());
							})

							$("input[name='jml_disetujui[]']").each(function(){
								jml_stj.push($(this).val());
							})

							$("input[name='stok_vaksin[]']").each(function(){
								stokv.push($(this).val());
							}) 
							
					 

							$.ajax({
									type : 'post',
									url  : 'amprah_approval.php',
									data : 'id_proses='+idproses+'&kode_batch='+kode_batch+'&jml_approval='+jml_stj+'&id_jenis='+idjenis+'&stok_vaksin='+stokv,
									success:function(html){										
										alert(html);	
										
									}
							})
	
							$(this).dialog('close');
							$("#proses_"+nomer).replaceWith('<input type="button" class="view_detil" data-id='+idjenis+' id="detil_'+nomer+'" value="Selesai">');
				
						},
						'Close' :function(){ 
						     	$(this).dialog('close');
						    }
					}
			});	

			$(document).on('click','.view_detil',function(){
				var id  = $(this).attr('data-id');
				var idx = $("#idproses").val();
				$.ajax({
					   type : 'post',
					   url  : './view_approval_detil.php',
					   data : 'idjenis='+id+'&idproses='+idx,
					   success:function(html){
						   $("#approval_dialog").dialog('open');
						   $("#approval_detil").html(html);
					   }
				})
			})

			$(document).on('click','.proses',function(){
				var id = $(this).attr('data-id');
				var trx= $("#idproses").val();
				var jml= $(this).attr('data-jumlah');
				var nom= $(this).attr('data-no');
				$("#nomer").val(nom);
				$.ajax({
						type : 'post',
						url  : 'proses_amprahan.php',
						data : 'idjenis='+id+'&idproses='+trx+'&jumlah='+jml,
						success:function(html){
							$("#amprah_dialog").dialog('open');
							$("#proses_amprah").html(html);
						}
				})
			})
			
		});
</script>

<?php
	include "../../conf/openconn.php";
	include "../../lib/functions-php.php"; 	
	
	
	if ($_POST['idorder']!='')
	{
		$idproses	= $_POST['idorder'];
		$kode_ins	= $_POST['kode_instansi'];
		$tglorder	= $_POST['tglorder'];
	 
		//get nama puskesmas 
		$sqlp = "select nama from instansi where kode_instansi='".$kode_ins."'";
		$qryp = mysql_query($sqlp);
		while ($pus=mysql_fetch_array($qryp))
		{
			$namap	 = $pus['nama'];				
		}
		
		
		$tglorder   = tgl_indo ($_POST['tglorder']);
		
		?>
			
		<table class="head" width="100%" cellpadding="4" border="0">
		<tr>
			<td>&nbsp;<b>Tanggal Amprahan</b></td>
			<td width="25%">: <?php echo $tglorder;?><input type="hidden" id="tglorder" value="<?php echo $tglorder;?>"><input type="hidden" id="idproses" value="<?php echo $idproses;?>"></td>	
			<td width="15%">&nbsp;<b>Instansi</b></td>
			<td width="35%">: <?php echo $namap;?><input type="hidden" id="kode_instansi" value="<?php echo $idpusk;?>"></td>				
		</tr>		 
		</table>	
<?php		
		$getdata = "select a.id_jenis
						  ,a.jumlah
						  ,v.nama 
				    FROM amprahan_detil a 
					inner join jenis_vaksin v 
					 on a.id_jenis=v.id_jenis 
					WHERE a.id_proses='".$idproses."'";			
					
		$qrydata	= mysql_query($getdata);		
		?>

		<table class='list' width="100%" cellspacing="2" cellpadding="2" style='padding-left:10px;'>
		<tr class='top' bgcolor="#80B302" width="60%">
			<td width="4%" align="center"><b>No.</b></td>
			<td width="30%" align="center"><b>Nama Vaksin</b></td>
			<td width="10%" align="center"><b>Jml Order</b></td>
			<td width="10%" align="center"><b>Status</b></td>				
		</tr>
		
	<?php	
		while ($data = mysql_fetch_array($qrydata))
		{
			$no++;
			$idjenis = $data['id_jenis'];
			$nama = $data['nama'];
			$jml  = $data['jumlah'];


			//get status vaksin pada tabel amprahan_approval_detil
			$get = "SELECT id_jenis from amprah_approval_detil where id_jenis='".$idjenis."' and id_proses='".$idproses."'";
			$qry = mysql_query($get);
			$ketemu = mysql_num_rows($qry);
			if ($ketemu!=0){
				$status='Selesai';
			}else{
				$status='Proses';
			}
			
			echo "<tr class='row' id='amp_row_$no' bgcolor='#D7ED9F'>";
			echo "<td align='right'>$no.</td>";
			echo "<td align='left'>&nbsp; $nama</td>";
			echo "<td align='right'>&nbsp; $jml</td>";
			echo "<td align='center'>";
				if ($status=='Selesai'){
			      echo "<input type='button' class='view_detil' data-no='$no' data-id='$idjenis' id='view_detil_$no' data-jumlah='$jml' value='Selesai'>";
				}else{
				  echo "<input type='button' class='proses' data-no='$no' data-id='$idjenis' id='proses_$no' data-jumlah='$jml' value='Proses'>";		
				}
			echo "</td>";	
			echo "</tr>";
		}	
		echo "</table>";
	 
	}
?>
<div id="boxpdf" style="float:center">
	<div id="content" ></div>
</div>

<div id="amprah_dialog" style="float:center">
	<div id="proses_amprah" ></div>
</div>

<div id="approval_dialog" style="float:center">
	<div id="approval_detil" ></div>
</div>

<input type="hidden" id="nomer">

