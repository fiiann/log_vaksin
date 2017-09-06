<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Form Transaksi Obat</title>
<script type="text/javascript">

	jQuery.expr[':'].contains = function(a,i,m)
	{
		return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase())>=0;
	};

	$(document).ready(function() {

			$(".ui-dialog-buttonpane button:contains('Order Vaksin')").button("disable");				
			
			 // menambah multiple select untuk checkbox
			$("#all").click(function () {
			$("input[type='checkbox']").attr('checked',this.checked);	
			$(".checkobat").attr('checked', this.checked);
			
			if ($(".checkobat:checked").length>0)
				{
				 $(".ui-dialog-buttonpane button:contains('Order Vaksin')").button("enable");	
				}else{
				 $(".ui-dialog-buttonpane button:contains('Order Vaksin')").button("disable");		
				}			
			});	
			
			$("input[name='kodevaksin[]']").click(function(){
		
				if($("input[name='kodevaksin[]']").length == $("input[name='kodevaksin[]']:checked").length) {
					$("#all").attr("checked", "checked");
					$(".ui-dialog-buttonpane button:contains('Order Vaksin')").button("enable");
				}else{
					$("#all").removeAttr("checked");
					if ($("input[name='kodevaksin[]']:checked").length>0)
					{
						$(".ui-dialog-buttonpane button:contains('Order Vaksin')").button("enable"); 
					}else{
						$(".ui-dialog-buttonpane button:contains('Order Vaksin')").button("disable");				
				}
		}
 
    });
		 
		 
		$('input[name="search"]').keyup(function(){ 
			var searchterm = $(this).val();
		if(searchterm.length>2) {
			var match = $('tr.data-row:contains("' + searchterm + '")');
			var nomatch = $('tr.data-row:not(:contains("' + searchterm + '"))');
			match.addClass('selected');
			nomatch.css("display", "none");
		} else {
			$('tr.data-row').css("display", "");
			$('tr.data-row').removeClass('selected');
		}   
		});
		
		 
		 
		$(".pilih").click(function()
		{
			var id=$(this).attr('id');						
		}).change(function(){
			var id=$(this).attr('id');
			if ($("#kodevaksin_"+id).is(":checked"))
			{
				if ($("#jmlorder_"+id).val()>0)
				{
					$("#kodevaksin_"+id).attr("checked","checked");
					$("#namavaksin_"+id).attr("checked","checked");
					$("#kategori_"+id).attr("checked","checked");
					$("#jenis_"+id).attr("checked","checked");
					$("#jmlstok_"+id).attr("checked","checked");
					$("#qtyordercek_"+id).attr("checked","checked");	
					$("#satuan_"+id).attr("checked","checked");
				}else{
					$("#kodevaksin_"+id).attr("checked",false);
					alert("Pastikan Jumlah Order bukan 0");
					$(".ui-dialog-buttonpane button:contains('Add Obat')").button("disable");							
				}
			}
		else if (!$("#kodevaksin_"+id).is(":checked"))
		{
			
				$("#kodevaksin_"+id).attr("checked",false);
				$("#namavaksin_"+id).attr("checked",false);
				$("#kategori_"+id).attr("checked",false);
				$("#jenis_"+id).attr("checked",false);
				$("#jmlstok_"+id).attr("checked",false);
				$("#qtyordercek_"+id).attr("checked",false);	
				$("#satuan_"+id).attr("checked",false);
		}		
		
	});
	
	$(".cekstok").click(function(){
		var id = $(this).attr('id');				
	}).change(function(){
		var id 		= $(this).attr('id');
		var jmlstok	= parseInt($("#jmlstok_"+id).val());
		var jmlorder= parseInt($("#jmlorder_"+id).val());
		var namaobat= $("#namaobat_"+id).val();
		$("#qtyordercek_"+id).val(jmlorder);
		if (jmlorder>jmlstok)
		{		
		
			$("#jmlorder_"+id).val(0);
			alert("MAAF..Stok Obat "+namaobat+" Tidak Mencukupi...!");
			
		}
	});
	
	
});
</script>
<style>
  .daftar tr#select:hover{background:#eecc00}
  .data-header {font-weight:bold;color:#fff}

</style>
</head>
<body id="main_body" >
<?php
	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php"; 	
	?>
		<div id="cari" align="left">Cari Nama Vaksin : <input type="text" name="search" class="element text small" id="search">&nbsp;&nbsp;<font color="red"><b>Merah</b></font> : kedaluarsa/expired
		<table class="daftar" bgcolor="#BAB997" width="100%" cellpadding="0" border="0">
		<tr class='data-header' bgcolor="#4F4E33">
			<td align="center">No.</td>
			<td>&nbsp;Kode Vaksin</td>
			<td>&nbsp;Nama Vaksin</td>
			<td align="center">Jenis Vaksin</td>
			<td align="center">Stok</td>
			<td align="center">Jml Terima</td>			
			<td align="center">Satuan</td>		
			<td align="center">Exp. Date</td>			
			<td align="center">Pilih</td>
		</tr>	
	<?php
		
		//ambil data obat dari database
		$getdetil= "SELECT s.kode_vaksin
						,s.nama_vaksin
						,s.jml_stok
						,s.id_jenis
						,s.satuan
						,s.expired_date
						,j.id_jenis
						,j.nama_jenis
					FROM master_vaksin s
					INNER JOIN jenis_vaksin j
						on s.id_jenis = j.id_jenis
					ORDER by s.nama_vaksin";	
		$qrydetil = mysql_query($getdetil);
		while ($out=mysql_fetch_array($qrydetil))
		{
			$nomer++;
			$kodevaksin = $out['kode_vaksin'];
			$namavaksin = $out['nama_vaksin'];
			$jenis	  = $out['nama_jenis'];
			$jmlstok  = $out['jml_stok'];
			$satuan   = $out['satuan'];
			$exp	  = tgl_eng_to_ind($out['expired_date']);
			
			
			//ambil selisih tanggal sekarang dengan tanggal expired pada database
			//--tgl exp dari database--//
			$tgl_exp  = $out['expired_date'];
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
				
			if ($selisih>=30)
			{
				$tahun  = floor($selisih/365);
				$bulan  = floor(($selisih%365)/30);	
				$hari   = floor($selisih - ($tahun*365) - ($bulan*30));
				$hasil  = $bulan." Bln ".$hari." Hari";
			}else if ($selisih<=29) {
				$hasil = $selisih." Hari";
			}
			
			if ($selisih<=30)
			{
				$warna = 'red';
			}else{
				$warna = 'green';
			}
			
			if ($hasil<=0)
			{
				$hasiltxt = ' - Expired';
			}else{
				$hasiltxt = '';
			}

			 
			 
				if ($hasil<=0){?>
					<tr class='data-row' id='select' bgcolor="#F76565">		
				<?php 	
					}else{?>
					<tr class='data-row' id='select' bgcolor="#CFCEC8">
				<?php	
				}
				?>
			
		
			<td width="5%" align="right"><?php echo $nomer;?>.</td>
			<td width="12%">&nbsp;
				<?php echo $kodevaksin;?>
				
			</td>
			<td width="25%">&nbsp;
				<?php echo $namavaksin."<font color='white'><b>".$hasiltxt."</b></font>"?>
				<input type="checkbox" name="namavaksin[]" id="namavaksin_<?php echo $kodevaksin;?>" value="<?php echo $namavaksin;?>" style='display:none;'>		
			</td>
			<td width="12%">&nbsp;
				<?php echo $jenis;?>
				<input type="checkbox" name="jenis[]" id="jenis_<?php echo $kodevaksin;?>" value="<?php echo $jenis;?>" style='display:none;'>								
			</td>
			<td width="8%" align="right" id="restok">				
					<?php echo $jmlstok;?>&nbsp;
					<input type="checkbox" name="jmlstok[]" id="jmlstok_<?php echo $kodevaksin;?>" value="<?php echo $jmlstok;?>" style='display:none;'>													
			</td>
			<?php 
					if ($hasil<=0)
					{ ?>
					<td width="10%" align="center">					
						<input type="text" name="jmlordercek[]" id="jmlorder_cek" size="5" value="<?php echo $qty_order;?>" disabled style='text-align:right'>
					</td>
					<?php } else{ ?>
					<td width="10%" align="center" class="cekstok" id="<?php echo $kodevaksin;?>">											
						<input type="text" name="jmlorder[]" id="jmlorder_<?php echo $kodevaksin;?>" size="5" value="1" style='text-align:right'>				
						<input type="checkbox" name="qtyordercek[]" id="qtyordercek_<?php echo $kodevaksin;?>" style='display:none;'>
					</td>
			<?php } ?>
			
			<td width="12%">&nbsp;
				<?php echo $satuan;?>
				<input type="checkbox" name="satuan[]" id="satuan_<?php echo $kodevaksin;?>" value="<?php echo $satuan;?>" style='display:none;'>									
			</td>			
			<td width="12%">&nbsp;
				<?php echo $exp;?>
				<input type="checkbox" name="expired_date[]" id="expired_<?php echo $kodevaksin;?>" value="<?php echo $exp;?>" style='display:none;'>									
			</td>			
			
			
			<?php 
			
			if ($hasil<=0){?>
					<td width="10%" align="center" class="terpilih"><input type="checkbox" name="checked_ex[]" class="checked_ex" id="checked_ex" disabled></td>			
			<?php
				}else{			
			?>
					<td width="10%" align="center" class="pilih" id="<?php echo $kodevaksin;?>"><input type="checkbox" name="kodevaksin[]" class="checkobat" id="kodevaksin_<?php echo $kodevaksin;?>" value="<?php echo $kodevaksin;?>"></td>
		<?php } ?>
			</tr>
			
		<?php	
		
		
		}
		echo "</table>";
 ?>		
	
	</body>
</html>