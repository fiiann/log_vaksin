<?php

 $kode_instansi = $_POST['kode_instansi'];

 include_once "conf/openconn.php";
 include_once "lib/functions-php.php";


 $tahun = date('Y');
 $x=$tahun-2; 
    
 //get jenis vaksin
 $vaksin = "SELECT id_jenis,nama from jenis_vaksin ORDER by id_jenis ASC";
 $qrvaks = mysql_query($vaksin);

 $date = date('Y-m');
 $exdate = explode("-",$date);
 $months = $exdate[1];
 $year  = $exdate[0];

 
?> 
<head>
<script>
    $(document).ready(function(){
        $("#bulan").change(function(){
            var bln   = $(this).val();
            var thn   = $("#tahun").val();
            var kdins = $("#kode_instansi").val();
            
            $.ajax({
                   type : 'post',
                   url  : './trx/getdatastok.php',
                   data : 'kode_instansi='+kdins+'&bulan='+bln+'&tahun='+thn,
                   beforeSend:function(){
                       $(".loading").show();
                   },
                   success:function(html){
                       $(".loading").hide();
                       $("#konten_stok").html(html);
                   }
            })
        })

        $("#tahun").change(function(){
            var bln   = $("#bulan").val();
            var thn   = $(this).val();
            var kdins = $("#kode_instansi").val();
            
            $.ajax({
                   type : 'post',
                   url  : './trx/getdatastok.php',
                   data : 'kode_instansi='+kdins+'&bulan='+bln+'&tahun='+thn,
                   beforeSend:function(){
                       $(".loading").show();
                   },
                   success:function(html){
                       $(".loading").hide();
                       $("#konten_stok").html(html);
                   }
            })
        })

    })


</script>
<style>
 .dataTables_paginate {
     font-weight:bold;
     display:block;
     float:right;
 }

 
</style> 
</head>
<h3>Data Stok Vaksin</h3> 
<input type="hidden" id="kode_instansi" value="<?php echo $kode_instansi;?>">

 <div id="periode" style="float:left;padding:2px 5px">Bulan  
        <select id="bulan">
            <?php
			
				   $month = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
					for($y=1;$y<=12;$y++){
						if($y==date("m")){ $pilih="selected";}
						else {$pilih="";}
						echo("<option value=\"$y\" $pilih>$month[$y]</option>"."\n");
          			  }
         
			
            ?>
            </select>
        
        
         Tahun : <select id="tahun">
            <?php   
            
             for ($i=0;$i<2;$i++){
                $x=$x+1;
                if ($x==date('Y')){ $pil="selected";}else{$pil="";}
                echo "<option value='$x' $pil>$x</option>";
              } 
            ?>
          </select>
        </div>  
<div id="konten_stok">        
<table class="table table-striped table-bordered" width="60%" id="tujuan_list">
    <thead>
      <th>No.</th>
      <th>Nama Vaksin</th>
      <th>Jumlah Stok</th>
    </thead>  
 
    <tbody>
     <?php
      while ($vak=mysql_fetch_array($qrvaks)){
        $urut++;  
        $idj = $vak['id_jenis'];
        $nm  = $vak['nama'];

        //get total vaksin per jenis
        $getot = "SELECT SUM(jumlah) as total from instansi_stok where kode_instansi='".$kode_instansi."' and id_jenis='".$idj."' and bulan='".$months."' and tahun='".$year."'";
        $qtot  = mysql_query($getot);
        while ($tot=mysql_fetch_array($qtot)){
            $jtot = $tot['total'];
        }
    ?>
      <tr id="amprahan_row_<?php echo $idjenis;?>">
         <td width="5%" align="right"><?php echo $urut;?></td>
         <td width="30%"><?php echo $nm;?></td>
         <td width="15%" align="right"><?php echo $jtot;?></td>
     </tr>
    <?php } ?>   
    </tbody>
</table>
</div> 

 