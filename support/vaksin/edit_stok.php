<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Edit Data Obat</title>
<link rel="stylesheet" type="text/css" href="../css/adminview.css" media="all">
<!--script type="text/javascript" src="../js/adminview.js"></script-->
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet"/>
 
<script type="text/javascript">
	$(document).ready(function(){
				
		$("#updatestok").click(function(){

			var idjenis 	= $("#id_jenis").val();
			var bulan   	= $("#bulan").val();
			var tahun		= $("#tahun").val();
			var jumlah		= $("#jumlah_stok").val();
            var satuan      = $("#satuan").val();
			
			if ((idjenis!="") && (jumlah!=0)) 
			{
				
				$.ajax({
						type 	: "POST",
						url	 	: "update_stok.php",
						data 	: "id_jenis="+idjenis+"&bulan="+bulan+"&tahun="+tahun+"&jumlah="+jumlah+"&satuan="+satuan,
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
 
 	$id = $_GET['id'];

	$get = "SELECT id_jenis, stok_tersedia, satuan FROM master_stok where id_jenis='".$id."'";
    $qry = mysql_query($get); 
	while($vak=mysql_fetch_array($qry)){
		$id_jenis = $vak['id_jenis'];
		$jumlah   = $vak['stok_tersedia'];
		$satuan   = $vak['satuan'];
	}

	$tahun = date('Y');
    $x=$tahun-1; 
    
?>


<body id="main_body" >
	
	<!--img id="top" src="../../images/top.png" alt=""-->
	<div id="form_container">
	
		<h1><a>Data Stok Vaksin</a></h1>
		<form id="form_898777" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>Stok Vaksin</h2>
			<p>isi data Vaksin dengan lengkap dan benar, <font color="red">(*)Field Harus Diisi</font></p>
		</div>						
			<ul >
			
		<li id="li_7" >
		<label class="description" for="element_7">Jenis Vaksin *</label>
		<div>
		<select class="element select small" id="id_jenis" name="id_jenis" disabled> 
			<?php
				$sqljenis    = "Select * from jenis_vaksin order by id_jenis";
				$query		 = mysql_query($sqljenis);
				while ($outj=mysql_fetch_array($query))
					{
						$idj		 =$outj['id_jenis'];
						$nama        =$outj['nama'];
						
					//	echo "<option value='$id'>$namajenis</option>";
						echo $nama;
						?>
						
						<option value='<?php echo $idj?>' <?php echo ($outj['id_jenis']==$id_jenis)?"selected":""; ?>><?php echo $nama?></option>
						
						
						<?php
						}	
			?>
		</select>
		</div> 
		</li>		
		
	 
		<li id="li_6" >
		<label class="description" for="element_6">Bulan dan Tahun *</label>
		<div>
           <select id="bulan" disabled>
            <?php
            $bulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            for($y=1;$y<=12;$y++){
            if($y==date("m")){ $pilih="selected";}
            else {$pilih="";}
            echo("<option value=\"$y\" $pilih>$bulan[$y]</option>"."\n");
            }
            ?>
            </select> <select id="tahun" disabled>
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
		<label class="description" for="element_6">Jumlah Stok *</label>
		<div>
			<input id="jumlah_stok" name="jumlah_stok" class="element text small" type="text" maxlength="255" value="<?php echo $jumlah;?>"/> 
		</div> 
		</li>	
        <li id="li_6" >
		<label class="description" for="element_6">Satuan *</label>
		<div>
			<input id="satuan" name="satuan" class="element text small" type="text" maxlength="255"  value="<?php echo $satuan;?>"/> 
		</div> 
		</li>
		<li class="buttons">
			    <input type="hidden" name="form_id" value="898777" /> 
				<input id="updatestok" class="button_text" type="button" name="updatestok" value="Update Stok" />
		</li>
		<div id="confirm"></div>
			</ul>
		</form>	
	</div>
	<!--img id="bottom" src="../../images/bottom.png" alt=""-->
	</body>
</html>