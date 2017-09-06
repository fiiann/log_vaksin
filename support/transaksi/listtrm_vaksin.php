<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>List Data Penerimaan Obat</title>
<script type="text/javascript" src="../js/view.js"></script>
<link rel="stylesheet" type="text/css" href="../../css/view.css" media="all"> 
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet"/>
<style>
#navcontainer ul
{
margin: 0;
width:420px;
padding: 10px 5px 10px;
list-style-type: none;
text-align: center;

}


#navcontainer ul li { display: inline; }

#navcontainer ul li a
{
text-decoration: none;
padding: .2em 1em;
color: #000;
background-color: #c0c0c0;
}

#navcontainer ul li a:hover
{
color: #fff;
background-color: #378503;
}


.ui-widget-overlay.custom-overlay
{
    background-color: black;
    background-image: none;
    opacity: 0.9;
    z-index: 1040;    
}

 .ui-datepicker-calendar {
	    display: none;
	}​
</style>

<script type="text/javascript">
	$(function() {	
		$("#tglterima").datepicker({
			 changeMonth: true,
             changeYear: true, 
			 showButtonPanel: true,
			 closeText: 'Close',
			 yearRange: "c-5:c+15",	
			 regional:"id",
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
					
				$("#tglterima").val(months+", "+year);
				$("#blnterima").val(month+", "+year);
				
				var bulanterima	 = $("#blnterima").val();
				
					$.ajax ({
						type : "POST",
						url	 : "load_data_terima.php",
						cache: false,
						data : "bulanterima="+bulanterima, 
						success : function(html)
						{						
							$("#tampil_list").html(html);
						}
			});
		 }	 
		});		 
		
		
		});
	
		
	$(document).ready(function() {			
		
		$("#detildialog").dialog({
					autoOpen:false,
					width:800,
					height:550,
					title:'Detil Penerimaan Vaksin', 
					top:80,
					modal:true, 
					buttons:{
						'Close' :function(){ 
							$(this).dialog('close');
						    }
						}
		});
	
		
		
		$(".detil").live('click',function(){
			var idterima	 = $(this).attr('id');
			var tglterima = $("#tgl_terima").val();
 
			
			$.ajax ({
						type : "POST",
						url  : "detil_terimavaksin.php",
						cache: false,
						data : "idterima="+idterima+"&tglterima="+tglterima,
						success : function(html){
							$("#detildialog").dialog('open');
							$("#viewdetil").html(html);
						}

			});	
		});
		
		
		$("#tglterima").change(function(){
			var tglterima = $("#tglterima").val();
			
			$.ajax ({
						type : "POST",
						url	 : "load_data_terima.php",
						cache: false,
						data : "tglterima="+tglterima,
						success : function(html)
						{						
							$("#tampil_list").html(html);
						}
			});
		});
		
		$(function() {
			$( "#tabs" ).tabs({
			collapsible: true
			});
		});
			
			 
	});

</script>
</head>
<body id="main">
<?php
	include "../../librari/inc.koneksi.php";
	include "../../librari/inc.librari.php"; 	

 ?>		
 
 	<div id="listview_container">	
				<div class="form_description">		 
				<img src="../../images/order-med.png" style="padding:5px"><span id="head" style="font-family:trebuchet ms;font-size:30px;font-weight:bold">Data Penerimaan Vaksin</span>
			</div>		
		<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Penerimaan Vaksin</a></li>  
		</ul>
		<div id="tabs-1">		 
		 
		<table width="100%" cellpadding="4" border="0">
		<tr>
			<td width="15%">&nbsp;<b>Bulan & Tahun</b></td>
			<td width="45%">: 
				<input type="text" name="tglterima" id="tglterima" class="element text small" size="10">
				<input type="hidden" name="blnterima" id="blnterima" class="element text small" size="10">
			 
			</td>	
		</table>	
		<div id="tampil_list"></div>
		<div id="detildialog">
			<div id="viewdetil"></div>
		</div>
		<br><br><br>
	</div>
	</div>
	</div>
	<img id="bottom" src="../../images/bottom.png" alt="">	
	</body>
</html>