<?php
 session_start();
 $kode_instansi = $_SESSION['kode_instansi'];
 
 include_once "conf/openconn.php";
 include_once "lib/functions-php.php";

 $get = "SELECT id_pakai, bulan, tahun, tanggal, is_approve, is_fix from pemakaian where kode_instansi='".$kode_instansi."'";
 $qry = mysql_query($get);
?> 
<head>
<script>
    $(document).ready(function(){
        $('#pakai_vaksin').DataTable( {
                "bSortClasses": true,
                "bFilter": true,
              
                "aaSorting": [[1, 'asc']]
		});
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
<h3>Data Pemakaian Vaksin</h3> 
<button class="btn btn-success" id="new_pemakaian" data-id="<?php echo $kode_instansi;?>"><i class="glyphicon glyphicon-plus"></i> New Form Pakai</button>
<br><br>
<table class="table table-striped table-bordered" width="100%" id="pakai_vaksin" data-order='[[ 0, "asc" ]]' data-page-length='15'>
    <thead>
      <th>No.</th>
      <th>Bulan</th>
      <th>Tahun</th>
      <th>Tgl dibuat</th>
      <th>Status Laporan</th>
      <th>Tool</th>
    </thead>  
 
    <tbody>
     <?php
      while ($data=mysql_fetch_array($qry)){
        $urut++;
        $id_pakai = $data['id_pakai'];
        $bulan    = namaBulan($data['bulan']);
        $tahun    = $data['tahun'];
        $is_fix   = $data['is_fix'];
        $is_approv= $data['is_approve'];
        $tanggal  = tgl_indo($data['tanggal']);
      
        if ($is_fix=='0'){
            $stat = 'Belum Fix';
        }else{
            if ($is_approv==0){
                $stat = 'Menunggu Persetujuan';
                $type = 'btn-danger';
            }else{
                $stat = 'Telah Di Setujui';
                $type = 'btn-success';
            }
        }
    ?>

      <tr id="amprahan_row_<?php echo $id_pakai;?>">
         <td width="5%" align="right"><?php echo $urut;?></td>

         <td width="30%" class="detil_pakai" style="cursor:pointer" title="atur uraian" data-id="<?php echo $id_pakai;?>"><?php echo $bulan;?></td>
         <td width="15%"><?php echo $tahun;?></td>
         <td width="15%"><?php echo $tanggal;?></td>
         <td width="15%"><button class="btn <?php echo $type;?>" type="button"><?php echo $stat;?></button></td>
         <td width="15%">  
         <?php 
         if ($is_fix==1){?>
                 <button class="btn btn-primary disabled" title="edit" id="e">edit</button> 
                 <button class="btn btn-primary" title="view" id="view_pakai" data-id="<?php echo $id_pakai;?>" data-tahun="<?php echo $tahun;?>" data-bulan="<?php echo $data['bulan'];?>" data-kode="<?php echo $kode_instansi;?>">view</button>
         <?php }else{?>
                 <button class="btn btn-primary" title="edit" id="edit_pakai" data-id="<?php echo $id_pakai;?>" data-tahun="<?php echo $tahun;?>" data-bulan="<?php echo $data['bulan'];?>" data-kode="<?php echo $kode_instansi;?>">edit</button> 
                
         <?php } ?>
         </td>
     </tr>

    <?php } ?>
    
    </tbody>
</table>
 

 