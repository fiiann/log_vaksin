<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Edit Data Obat</title>
<link rel="stylesheet" type="text/css" href="../css/adminview.css" media="all">
<script type="text/javascript" src="../js/adminview.js"></script>
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet"/>
 
<script type="text/javascript">
	  $(function() {
		$("#exp").datepicker();	 
		$("#exp").change(function() {
             $("#exp").datepicker("option","dateFormat","dd-mm-yy");
		   }); 	
		});
		
	$(function() {
		$("#tgl_diterima").datepicker();	 
		$("#tgl_diterima").change(function() {
             $("#tgl_diterima").datepicker("option","dateFormat","dd-mm-yy");
		   }); 	
		});
	
	$(document).ready(function(){
				
		$("#updatedata").click(function(){
			var jenis 	    = $("#jenis_vaksin").val();
			var bulan   	= $("#bulan").val();
			var tahun		= $("#tahun").val();
            var jumlah      = $("#jumlah_cakupan").val();
			var aksi 		= "update";
			var idx         = $("#idx").val();
			
			if (jenis!='') 
			{
				
				$.ajax({
						type 	: "POST",
						url	 	: "simpan_cakupan.php",
						data 	: "aksi="+aksi+"&idx="+idx+"&id_jenis="+jenis+"&bulan="+bulan+"&tahun="+tahun+"&jml_cakupan="+jumlah,
						success	: function(html)
						{
							$("#confirm").html(html);						
						}
				
				});				
			
			}else{
				alert("Isikan Data Dengan Lengkap dan Benar");
			
			}
			

		});
	
	});
</script>
</head>
<?php
	include "../../conf/openconn.php";
	include "../../lib/functions-php.php";
    $tahun = date('Y');
    $x=$tahun-2; 


	$idx = $_GET['idx'];
	
	$sqlupdate = "select id_jenis, jumlah, bulan, tahun from data_cakupan where idx='".$idx."'";
	$qryupdate = mysql_query($sqlupdate);
	while ($hsl = mysql_fetch_array($qryupdate))
	{
		$id_jenis        = $hsl['id_jenis'];
		$bulan   	     = $hsl['bulan'];
        $tahun           = $hsl['tahun'];
		$jumlah	  		 = $hsl['jumlah'];	 
	}
 	
?>


<body id="main_body" >
	
	<img id="top" src="../../images/top.png" alt="">
	<div id="form_container">
		<input type="hidden" id="idx" value="<?php echo $idx;?>">
		<h1><a>Edit Data Cakupan</a></h1>
		<form id="form_898777" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>Edit Data Cakupan</h2>
			<p>isi data Cakupan dengan lengkap dan benar, <font color="red">(*)Field Harus Diisi</font></p>
		</div>						
			<ul >
			
		<li id="li_7" >
		<label class="description" for="element_7">Jenis Vaksin *</label>
		<div>
		<select class="element select small" id="jenis_vaksin" name="jenis_vaksin"> 
			<?php
				$sqljenis = "Select * from jenis_vaksin order by id_jenis";
				$query		 = mysql_query($sqljenis);
				while ($outj=mysql_fetch_array($query))
					{
						$idj		 =$outj['id_jenis'];
						$namajenis   =$outj['nama'];
						
					//	echo "<option value='$id'>$namajenis</option>";
						echo $id_jenis;
						?>
						
						<option value='<?php echo $idj?>' <?php echo ($outj['id_jenis']==$id_jenis)?"selected":""; ?>><?php echo $namajenis?></option>
						
						
						<?php
						}	
			?>
		</select>
		</div> 
		</li>		
		<li id="li_6" >
		<label class="description" for="element_6">Bulan dan Tahun *</label>
		<div>
           <select id="bulan">
            <?php
            $month = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            for($y=1;$y<=12;$y++){
            if($y==$bulan){ $pilih="selected";}
            else {$pilih="";}
            echo("<option value=\"$y\" $pilih>$month[$y]</option>"."\n");
            }
            ?>
            </select> <select id="tahun">
            <?php   
             for ($i=0;$i<2;$i++){
                $x=$x+1;
                echo "<option value='$x'>$x</option>";
              } 
            ?>
          </select>
  		</div> 
		</li>			
       
		<li id="li_6" >
		<label class="description" for="element_6">Jumlah Cakupan*</label>
		<div>
			<input id="jumlah_cakupan" name="jumlah_cakupan" class="element text small" type="text" value="<?php echo $jumlah;?>"/> 
		</div> 
		</li>	 
	 
		<li class="buttons">
			    <input type="hidden" name="form_id" value="898777" />
			    
				<input id="updatedata" class="button_text" type="button" name="updatedata" value="Update Data" />
		</li>
		<div id="confirm"></div>
			</ul>
		</form>	
	</div>
	<img id="bottom" src="../../images/bottom.png" alt="">
	</body>
</html>