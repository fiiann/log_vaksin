<?php

 
 include_once "../conf/openconn.php";
 include_once "../lib/functions-php.php";

 $kode_instansi = $_POST['kode_instansi'];
 $bulan = $_POST['bulan'];
 $tahun = $_POST['tahun'];
 

 //get jenis vaksin
 $vaksin = "SELECT id_jenis,nama from jenis_vaksin ORDER by id_jenis ASC";
 $qrvaks = mysql_query($vaksin);

?>

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
        $getot = "SELECT SUM(jumlah) as total from instansi_stok where kode_instansi='".$kode_instansi."' and id_jenis='".$idj."' and bulan='".$bulan."' and tahun='".$tahun."'";
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