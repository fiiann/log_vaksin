<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Report Stok Obat</title>
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet"/>
<script type="text/javascript">

  	$(function() {	
		$("#blnpakai").datepicker({
			 changeMonth: true,
             changeYear: true, 
			 showButtonPanel: true,
			 closeText: 'Close',
			 yearRange: "c-5:c+15",	
		     onChangeMonthYear: function (year, month) {
                 $("#startYear").val(year);
                 $("#startMonth").val(month);
				 if (month==1)
					{ months='Januari'}else if (month==2){ months='Februari'}
				else if (month==3){ months='Maret'}else if (month==4){ months='April'}
				else if (month==5){ months='Mei'}else if (month==6){ months='Juni'}
				else if (month==7){ months='Juli'}else if (month==8){ months='Agustus'}
				else if (month==9){ months='September'}else if (month==10){ months='Oktober'}
				else if (month==11){ months='November'}else { months='Desember'}
					
				$("#blnpakai").val(months+", "+year);
				$("#blpakai").val(month+", "+year);
				
				var bulanpakai	 = $("#blpakai").val();
				var idpusk 	 	 = $("#kode_pkm").val();
				/*
					$.ajax ({
						type : "POST",
						url	 : "viewreport_pkm.php",
						cache: false,
						data : "bulanorder="+bulanorder+"&kode_puskesmas="+idpusk,
						success : function(html)
						{						
							$("#tampil_list").html(html);
						}
			});
		   */
		 }	 
		});		 
		
		
		});



	$(document).ready(function() {
		 
		 
	 
	 
	 
		 $("#view_report").click(function(){
			 var bulan = $("#bulan").val();
			 var tahun = $("#tahun").val();
			 $.ajax({
				 	type : 'post',
					url  : 'viewreport_kirim.php',
					data : 'bulan='+bulan+'&tahun='+tahun,
					success:function(html){
						$("#res_report").html(html);
					}
			 })
		 })

	 });
</script>
<style>
 .ui-datepicker-calendar {
	    display: none;
	}​
</style>
</head>
<body id="main_body" >
<?php

	$tahun = date('Y');
    $x=$tahun-2; 
?>	
	<div id="listview_container">

		<div class="form_description">
			<h3 style="font-family:Tahoma">&nbsp;&nbsp;Laporan Pengiriman Vaksin</h3>		 
		</div>		
		&nbsp;&nbsp;<span id="nm_bulan" style="font-family:Tahoma;font-size:13px"> <b>Bulan :</b></span> 
		<select id="bulan">
		<?php
		   $month = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
					for($y=1;$y<=12;$y++){
						if($y==$bulan){ $pilih="selected";}
						else {$pilih="";}
						echo("<option value=\"$y\" $pilih>$month[$y]</option>"."\n");
          			  }  
		?>
		</select>
		&nbsp;&nbsp;&nbsp;
		<span id="nm_tahun" style="font-family:Tahoma;font-size:13px"><b>Tahun :</b> 
		<select id="tahun">
            <?php   
           
				for ($i=0;$i<2;$i++){
					$x=$x+1;
					if ($x==$tahun){ $pil="selected";}else{$pil="";}
					echo "<option value='$x' $pil>$x</option>";
             	 } 
			?>
		</select>	
		&nbsp;&nbsp; 	
		<input type="button" class="view_report" id="view_report" value="Tampilkan"> 
		 
	</div>
	<hr>
	<div id="res_report"></div>
	</body>
</html>