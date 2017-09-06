<?php

 $kode_instansi = $_POST['kode_instansi'];

 include_once "conf/openconn.php";
 include_once "lib/functions-php.php";

 $get = "SELECT  x.id_proses
                 ,x.tanggal
                 ,x.status 
                 ,x.is_fix      
                 ,i.nama
           from amprahan x 
           inner join instansi i 
            on x.kode_instansi=i.kode_instansi 
           WHERE x.kode_instansi='".$kode_instansi."'";

 $qry = mysql_query($get);
?> 
<head>
<script>
    $(document).ready(function(){
        $('#tujuan_list').DataTable( {
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
<h3>Data Amprahan Vaksin</h3> 
<button class="btn btn-success" id="new_amprahan" data-id="<?php echo $kode_instansi;?>"><i class="glyphicon glyphicon-plus"></i> New Amprahan</button>
<br><br>
<table class="table table-striped table-bordered" width="100%" id="tujuan_list" data-order='[[ 0, "asc" ]]' data-page-length='15'>
    <thead>
      <th>No.</th>
      <th>Tanggal</th>
      <th>Status</th>
      <th>Tool</th>
    </thead>  
 
    <tbody>
     <?php
      while ($data=mysql_fetch_array($qry)){
        $urut++;
        $idp     = $data['id_proses'];
        $tanggal = tgl_indo($data['tanggal']);
        $st      = $data['status'];
        $is_fix  = $data['is_fix'];

        if ($is_fix==0){
            $status='Amprahan belum fix';
            $btn='btn-danger';
        }else if(($st==0) && ($is_fix==1)) {
            $status='Menunggu Pemenuhan DKK';
            $btn='btn-default';
        }else if(($st==1) && ($is_fix==1)){
            $status='Amprahan Selesai';
            $btn='btn-success';
        }
      
    ?>

      <tr id="amprahan_row_<?php echo $idp;?>">
         <td width="5%" align="right"><?php echo $urut;?></td>
         <td width="30%" class="detil_amprahan" style="cursor:pointer" title="atur uraian" data-id="<?php echo $idp;?>"><?php echo $tanggal;?></td>
         <td width="15%"><button class="btn <?php echo $btn;?>"><?php echo $status;?></button></td>
         <td width="15%">
            <?php
             if ($st==0){
               if ($is_fix==1){ ?>
                   <button class="btn btn-primary" title="view amprah" id="edit_amprah" data-id="<?php echo $idp;?>" data-instansi="<?php echo $kode_instansi;?>" data-tgl="<?php echo $tanggal;?>">view</button> 
                   <button class="btn btn-danger" title="hapus" id="detil_amprah" data-id="<?php echo $idp;?>" data-tgl="<?php echo $tanggal;?>">detil</button>
               <?php  }else{?>
                   <button class="btn btn-primary" title="edit amprah" id="edit_amprah" data-id="<?php echo $idp;?>" data-instansi="<?php echo $kode_instansi;?>" data-tgl="<?php echo $tanggal;?>">edit</button> 
                   <button class="btn btn-danger" title="hapus" id="detil_amprah" data-id="<?php echo $idp;?>" data-tgl="<?php echo $tanggal;?>">detil</button>
                      
            <?php } ?>
           
           <?php } else { ?>
                  <button class="btn btn-primary" title="edit" id="edit_amprah" disabled>edit</button> 
                  <button class="btn btn-danger" title="hapus" id="detil_amprah" data-id="<?php echo $idp;?>" data-tgl="<?php echo $tanggal;?>">detil</button>

           <?php } ?>     
            </td>
     </tr>

    <?php } ?>
    
    </tbody>
</table>
 

 