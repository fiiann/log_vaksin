<?php
  include_once "conf/openconn.php";
  $idp = $_POST['id_proses'];
  $tgl = $_POST['tanggal'];
 
  
  $get = "SELECT d.id_jenis
                 ,d.jumlah 
                 ,j.id_jenis
                 ,j.nama 
                 ,a.kode_batch
                 ,a.jumlah as dipenuhi
          from amprahan_detil d 
          inner join jenis_vaksin j 
           on d.id_jenis=j.id_jenis
          inner join amprah_approval_detil a 
           on d.id_jenis=a.id_jenis          
          where a.id_proses='".$idp."' group by a.id_jenis";       
                
  $qry = mysql_query($get) or die (mysql_error());
  

  ?>

  <table class="table table-striped">
    <tr>
      <td width="150">Tanggal</td>
      <td>: <?php echo $tgl;?></td>
    <tr>
    <tr>
     <td colspan="2">
        <table class="table table-striped">
        <thead>
          <th>Kode Batch</th>
          <th>Nama Vaksin</th>
          <th>Jumlah Order</th>
          <th>Jumlah Dipenuhi</th>
        </thead>
        <tbody>
   <?php 
       while ($det=mysql_fetch_array($qry)){
            $kode_batch  = $det['kode_batch'];
            $nama_vaksin = $det['nama'];
            $order     = $det['jumlah'];
            $penuhi    = $det['dipenuhi'];


          echo "<tr>
                 <td>$kode_batch</td>
                 <td>$nama_vaksin</td>
                 <td align='center'>$order</td>
                 <td align='center'>$penuhi</td>
               </tr>";     
      }
  
  ?>
           
        </tbody>
        </table>
     </td>
    </tr>
  </table>  