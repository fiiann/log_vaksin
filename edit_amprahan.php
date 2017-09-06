<?php
  include_once "conf/openconn.php";
  $idp = $_POST['id_proses'];
  $tgl = $_POST['tanggal'];
  $kins= $_POST['kode_instansi'];

  $isfix = "SELECT is_fix from amprahan where id_proses='$idp'";
  $qfix = mysql_query($isfix);
  while($sfx=mysql_fetch_array($qfix)){
    $is_fix = $sfx['is_fix'];
  }

  $get = "SELECT d.id_jenis
                 ,d.jumlah 
                 ,j.id_jenis
                 ,j.nama 
          from amprahan_detil d 
          inner join jenis_vaksin j 
           on d.id_jenis=j.id_jenis 
          where d.id_proses='".$idp."'";       
                
  $qry = mysql_query($get) or die (mysql_erro());
  

  ?>
 <script type="text/javascript">
 $(document).ready(function(){
   
   $("#simpan_amprah").prop("disabled",true);

     function list_amprah(){
         var kode_i = $("#kode_instansi").val();
		      $.ajax({
                     type : 'post',
                     url  : 'amprahan.php',
                     data : 'kode_instansi='+kode_i,
                     beforeSend:function(){
                       $(".loading").show();
                     },
                     success:function(html){
                       $(".loading").hide();
                       $("#konten").html(html);
                     }
              })
		
	}

   function getjenisvaksin(n){
     var idjenis = [];
     $("input[name='idjenis[]']").each(function(){
       idjenis.push($(this).val());
     })

 
     $.ajax({
           type : 'post',
           url  : './trx/getjenisvaksin.php',
           data : 'id_jenis='+idjenis,
           success:function(html){
             $("#jenis_vaksin_"+n).append(html);
           }
     })
   }

 
   $(".remove").click(function(){
     var id = $(this).attr('id');
     var idproses = $("#idproses").val();
     var idj = $(this).attr('data-id');

     $.ajax({
           type : 'post',
           url  : './trx/del_amprahan.php',
           data : 'id_proses='+idproses+'&id_jenis='+idj,
           success:function(html){
             $("#result").html(html);
           }
        })
        $("#amprah_row_"+id).remove();
   })

   $(".jml_vaksin").click(function(){
       var id = $(this).attr('id');
        
   }).change(function(){
       var id  = $(this).attr('id');
       var idv = $(this).attr('data-id');
       var jml = $("#jumlah_vaksin_"+id).val();
       var idp = $("#idproses").val();
 
       $.ajax({
              type : 'post',
              url  : './trx/update_jml.php',
              data : 'idvaksin='+idv+'&jumlah_vaksin='+jml+'&idproses='+idp,
              beforeSend:function(){
                  $("#loader_"+id).show();
              },
              success:function(html){
                  $("#loader_"+id).hide();
              }
       })
   })
   var n = 0;
   var m = 0;
   $("#add_vaksin").click(function(){
       $("#result").hide();
       n++;
       m=n+'a';
       $("#vaksin").append('<tr id="amprah_row_'+m+'"><td><select id="jenis_vaksin_'+m+'" class="pilih form-control" style="width:150px"></select></td><td width="10%"></td><td class="jvaksin" id='+m+'><input type="text" class="form-control" id="jmlvaksin_'+m+'" style="width:100px;text-align:right;"></td><td class="rem_add" id='+m+'><button class="btn btn-danger" type="button" id="del">X</button></td></tr>');
       getjenisvaksin(m);

         $(".rem_add").click(function(){
          var id = $(this).attr('id');      
      
          $("#amprah_row_"+id).remove();
         })

       
        $(".jvaksin").click(function(){
           var id    = $(this).attr('id');   
          }).change(function(){
            var id    = $(this).attr('id');
            var idjns = $("#jenis_vaksin_"+id).val();
            var jml   = $("#jmlvaksin_"+id).val();
            var idproses = $("#idproses").val();

            $.ajax({
                  type : 'post',
                  url  : './trx/add_amprahan.php',
                  data : 'id_proses='+idproses+'&id_jenis='+idjns+'&jumlah_vaksin='+jml,
                  success:function(html){
                    $("#result").show();
                    $("#result").html(html);
                  }
            })

        })

       
   })

   $("#is_fix").click(function(){
     var idpro = $(this).attr('data-id');
    
     $.ajax({
          type  :'post',
          url   :'./trx/fixing_amprah.php',
          data  : 'id_proses='+idpro,
          beforeSend:function(){
               $("#loading").show();
           },
          success:function(html){
               $.Zebra_Dialog(html, {
                                'type': 'confirmation',
                                'title': 'Confirm',
                                'buttons': [{
                                    caption: 'OK',
                                    callback: function() { 
                                        $("input[type='text']").prop('disabled',true);
                                        $(".btn").prop('disabled',true);                                      
                                        list_amprah();
                                    }
                                }]
                            });
           }

     })
   })


 })
 </script>

  <input type="hidden" id="idproses" value="<?php echo $idp;?>">
  <input type="hidden" id="kode_instansi" value="<?php echo $kins;?>">  
  <table class="table table-striped">
    <tr>
      <td width="150">Tanggal</td>
      <td>: <?php echo $tgl;?> &nbsp;&nbsp; 
        <?php 
          if($is_fix==1){?>
               <button type="button" class="btn btn-success" style="float:right;">Amprahan Telah Fix</button>
               <button type="button" class="btn btn-primary disabled">Add Vaksin</button>
          <?php } else{?>
               <button type="button" class="btn btn-danger" id="is_fix" data-id="<?php echo $idp;?>" style="float:right;">Fix Amprahan</button>
               <button type="button" class="btn btn-primary" id="add_vaksin">Add Vaksin</button>
      
          <?php } 
        ?>
      </td>
    <tr>
    <tr>
     <td colspan="2">
     <?php 
      if ($is_fix==1){
        echo "<span id='ket' style='font-size:12px'></span>";
      }else{
        echo "<span id='ket' style='font-size:12px'>*Penambahan Vaksin otomatis tersimpan bila jumlah order tidak kosong</span>";
      }?>
        <table class="table table-striped" id="vaksin">
        <thead>
          <th>Nama Vaksin</th>
          <th>&nbsp;</th>
          <th>Jumlah Amprah</th>   
          <th>Hapus</th>
        </thead>
        <tbody>
   <?php 
       while ($det=mysql_fetch_array($qry)){
            $nomer++;
            $idjenis     = $det['id_jenis'];
            $nama_vaksin = $det['nama'];
            $jumlah      = $det['jumlah'];

          echo "<tr id='amprah_row_$nomer'>
                 <td>$nama_vaksin</td>
                 <td align='right'>
                    <img src='img/loading_small.gif' class='loader' id='loader_$nomer' style='display:none'>
                    <input type='hidden' id='idjenis' name='idjenis[]' value='$idjenis'>   
                 </td>";
              if ($is_fix==1){
                  echo "<td><input type='text' class='form-control' id='jumlah_vaksin_$nomer' value='$jumlah' style='width:100px;text-align:right' disabled></td>
                        <td><input type='button' class='btn btn-danger' value='X' disabled></td>";
                
              }else{

              echo "<td class='jml_vaksin' id='$nomer' data-id='$idjenis'><input type='text' class='form-control' id='jumlah_vaksin_$nomer' value='$jumlah' style='width:100px;text-align:right'></td>
                 <td class='remove' id='$nomer' data-id='$idjenis'><input type='button' class='btn btn-danger' value='X'></td>
               </tr>";
               }     
      }
  
  ?>
           
        </tbody>
        </table>
     </td>
    </tr>
  </table>  
  <div id="result" style="font-size:10px;color:maroon"></div>
  