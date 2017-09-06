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

		$("#update_exp").click(function(){
			var jenis       = $("#id_jenis").val();
			var idx 	    = $("#idx_exp").val();	 
			var s_exp		= $("#stok_expired").val();
            var s_awl       = $("#stok_tersedia").val();
            var satuan      = $("#satuan").val();
			var aksi        = "update";

			if (s_exp.length>0) 
			{
				
				$.ajax({
						type 	: "POST",
						url	 	: "simpan_stok_expired.php",
						data 	: "aksi="+aksi+"&idx_exp="+idx+"&id_jenis="+jenis+"&stok_awal="+s_awl+"&stok_expired="+s_exp+"&satuan="+satuan,
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
    
    $idx = $_GET['id'];
    $get = "SELECT * from expired_stok where idx='".$idx."'";
    $qr  = mysql_query($get) or die (mysql_error());
    while ($ot=mysql_fetch_array($qr)){
        $jenis = $ot['id_jenis'];
        $month = $ot['bulan'];
        $tahun = $ot['tahun'];
        $sawal = $ot['stok_awal'];
        $sexp  = $ot['stok_expired'];
        $satuan= $ot['satuan'];
    
    }
?>


<body id="main_body" >
	<input type="hidden" id="idx_exp" value="<?php echo $idx;?>">
	<input type="hidden" id="id_jenis" value="<?php echo $jenis;?>">
	
	<img id="top" src="../../images/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Edit Stok Vaksin Expired</a></h1>
		<form id="form_898777" class="appnitro"  method="post" action="">
					<div class="form_description">
			<h2>Stok Vaksin Expired</h2>
			<p>isi data Vaksin Expired dengan lengkap dan benar, <font color="red">(*)Field Harus Diisi</font></p>
		</div>						
			<ul >
			
		<li id="li_7" >
		<label class="description" for="element_7">Jenis Vaksin *</label>
		<div>
		<select class="element select small" id="jenis_vaksin" name="jenis_vaksin" disabled> 
            <option selected>Pilih Satu</option>
			<?php
				$sqljenis = "Select * from jenis_vaksin order by id_jenis";
				$query		 = mysql_query($sqljenis);
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
		<label class="description" for="element_6">Stok Tersedia*</label>
		<div>
			<input id="stok_tersedia" name="stok_tersedia" class="element text small" type="text" maxlength="255" value="<?php echo $sawal;?>" disabled/> 
		</div> 
		</li>
		<li id="li_6" >
		<label class="description" for="element_6">Jumlah Stok *</label>
		<div>
			<input id="stok_expired" name="stok_expired" class="element text small" type="text" maxlength="255" value="<?php echo $sexp;?>"/> 
		</div> 
		</li>	
        <li id="li_6" >
		<label class="description" for="element_6">Satuan *</label>
		<div>
			<input id="satuan" name="satuan" class="element text small" type="text" maxlength="255" value="<?php echo $satuan;?>"/> 
		</div> 
		</li>
		<li class="buttons">
			    <input type="hidden" name="form_id" value="898777" /> 
				<input id="update_exp" class="button_text" type="button" name="simpanstok" value="Update Stok" />
		</li>
		<div id="confirm"></div>
			</ul>
		</form>	
	</div>
	<img id="bottom" src="../../images/bottom.png" alt="">
	</body>
</html>