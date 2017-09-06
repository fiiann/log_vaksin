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
	$(document).ready(function(){
				
        $("#jenis_vaksin").change(function(){
            var idj = $(this).val();
            $.ajax({
                    type : 'post',
                    url  : 'getstok.php',
                    data : 'idjenis='+idj,
                    dataType : 'json',
                    success:function(data){
                        var stok = data.stok;
                       
                        if (stok=='null'){
                            stok=0;
                        };
                        $("#stok_tersedia").val(stok);
                        $("#stok_tersedia").prop("disabled",true); 
                    }
            })
        })    

		$("#simpan_cakupan").click(function(){
			var jenis 	    = $("#jenis_vaksin").val();
			var bulan   	= $("#bulan").val();
			var tahun		= $("#tahun").val();
            var jumlah      = $("#jumlah_cakupan").val();
			var aksi 		= "insert";
			if ((jenis.length>0) && (jumlah.length>0)) 
			{
				
				$.ajax({
						type 	: "POST",
						url	 	: "simpan_cakupan.php",
						data 	: "aksi="+aksi+"&id_jenis="+jenis+"&bulan="+bulan+"&tahun="+tahun+"&jml_cakupan="+jumlah,
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
    $x=$tahun-1; 
    
?>


<body id="main_body" >
	
	<img id="top" src="../../images/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Input Cakupan</a></h1>
		<form id="form_898777" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>Input Data Cakupan</h2>
			<p>isi data cakupan dengan lengkap dan benar, <font color="red">(*)Field Harus Diisi</font></p>
		</div>						
			<ul >
			
		<li id="li_7" >
		<label class="description" for="element_7">Jenis Vaksin *</label>
		<div>
		<select class="element select small" id="jenis_vaksin" name="jenis_vaksin"> 
            <option selected>Pilih Satu</option>
			<?php
				$sqljenis = "Select * from jenis_vaksin order by id_jenis";
				$query		 = mysqli_query($koneksi,$sqljenis);
				while ($outj=mysql_fetch_array($query))
					{
						$idj		 =$outj['id_jenis'];
						$namajenis   =$outj['nama'];
						
					//	echo "<option value='$id'>$namajenis</option>";
						echo $jenis;
						?>
						
						<option value='<?php echo $idj?>' <?php echo ($outj['id_jenis']==$jenis)?"selected":""; ?>><?php echo $namajenis?></option>
						
						
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
            $bulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            for($y=1;$y<=12;$y++){
            if($y==date("m")){ $pilih="selected";}
            else {$pilih="";}
            echo("<option value=\"$y\" $pilih>$bulan[$y]</option>"."\n");
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
			<input id="jumlah_cakupan" name="jumlah_cakupan" class="element text small" type="text" maxlength="255"/> 
		</div> 
		</li>	
		<li class="buttons">
			    <input type="hidden" name="form_id" value="898777" /> 
				<input id="simpan_cakupan" class="button_text" type="button" name="simpan_cakupan" value="Simpan Cakupan" />
		</li>
		<div id="confirm"></div>
			</ul>
		</form>	
	</div>
	<img id="bottom" src="../../images/bottom.png" alt="">
	</body>
</html>