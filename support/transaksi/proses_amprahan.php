<?php
	include "../../conf/openconn.php";
	include "../../lib/functions-php.php"; 	
	
    $idproses = $_POST['id_proses'];
    $idjenis  = $_POST['idjenis'];
    $jmlorder = $_POST['jumlah'];

    $tgl_skr = date('Y-m-d');
	$getdatastok = "Select m.id_jenis
							   ,m.stok 
							   ,m.tgl_expired 
							   ,SUM(CASE WHEN m.vvm!='C' AND m.vvm!='D' AND m.tgl_expired!='$tgl_skr'  THEN m.stok ELSE 0 END) AS total 
							   ,j.nama 
						from master_vaksin m 
						inner join jenis_vaksin j 
						 on m.id_jenis=j.id_jenis 
                        where m.id_jenis='$idjenis' 
						GROUP BY id_jenis";
		$qrystok = mysql_query($getdatastok);

    while ($out=mysql_fetch_array($qrystok)){
        $nama = $out['nama'];
        $jstok= $out['total'];    
    }


?>

 

<style>
.head,.keterangan {font-size:12px;text-align:left;margin-left:10px;} 
.row:hover{font-size:12px;background:#F5BC00}
.row{font-size:12px;}
.top {font-size:12px;font-weight:bold;color:white}
#text{font-weight:normal;color:black;padding-left:5px;}
 .ui-autocomplete-loading { background:url('../images/ajax-loader.gif') no-repeat right center;padding-right:5px }
    
</style>  
<script type="text/javascript">
    $(document).ready(function(){
        $(".ui-dialog-buttonpane button:contains('Simpan')").button("disable"); 
        function TotalDiSetujui(){
            var totalx = 0;
            $("input[name='jml_disetujui[]']").each(function(){
                totalx+=parseInt($(this).val());
                
            })
            $("#totaldisetujui").val(totalx);
        }
       
        var nomer=0;
        $(".getVaksin").click(function(){
            var idjenis = $("#id_jenis").val();
            nomer++;
            $("#list_amprah").append('<tr id="vaksin_row_'+nomer+'" bgcolor="#fff"><td>'+nomer+'</td><td align="left"><input type="text" id="kode_batch_'+nomer+'" name="kode_batch[]" style="width:180px"></td><td><span id="tgl_exp_'+nomer+'"></span><td><span id="stok_'+nomer+'"></span><input type="hidden" id="stok_vaksin_'+nomer+'" name="stok_vaksin[]"></td><td class="jum" id='+nomer+'><input type="text" id="jml_disetujui_'+nomer+'" size="5" name="jml_disetujui[]" style="text-align:right"></td><td><input type="button" class="hapus" id='+nomer+' value="x"></td></td></tr>')
            $(".ui-dialog-buttonpane button:contains('Simpan')").button("enable");
        
             $("#kode_batch_"+nomer).autocomplete({       
			   source: function(request, response) {
                      $.ajax({
                          url: 'getDataVaksin.php',
                          dataType: "json",
                          data: {
                              term : request.term,
                              idjenis : idjenis
                          },
                          success: function(data) {
                              response(data);
                          }
                      });
                  },
                  min_length: 2,
                  delay: 150,
                  select: function(event, ui) {
                     	  $(this).val(ui.item.kode_batch);
                          $("#jml_disetujui_"+nomer).val(0);
                          $("#jml_disetujui_"+nomer).focus();
                          $("#stok_"+nomer).html(ui.item.stok);
                          $("#stok_vaksin_"+nomer).val(ui.item.stok);
                          $("#tgl_exp_"+nomer).html(ui.item.expired);
                   
                  }
    	  })

          $(".jum").click(function(){
              var id = $(this).attr('id');          
          }).change(function(){
              TotalDiSetujui();
              var id = $(this).attr('id');
              var st = parseInt($("#stok_vaksin_"+id).val());
              var jm = parseInt($("#jml_disetujui_"+id).val());
              
              $(".ui-dialog-buttonpane button:contains('Simpan')").button("enable");

              if (jm>st){
                  alert('Oopss...Melebihi Stok Vaksin tersedia...');
                  $("#jml_disetujui_"+nomer).val(0);
                  $("#jml_disetujui_"+nomer).focus();
              }
              
          })

          $(".hapus").click(function(){
              var no = $(this).attr('id');
              $("#vaksin_row_"+no).remove();
              TotalDiSetujui();
              var len = $("#list_amprah tr").length;
              
              if (len<=1){
                  $(".ui-dialog-buttonpane button:contains('Simpan')").button("disable");
              }else{
                  $(".ui-dialog-buttonpane button:contains('Simpan')").button("enable");
              }
          })
        
        })
    })

</script>

<div id="proses_amprahan" style="padding:10px">
<div id="result_cari"></div>
<input type="hidden" id="totaldisetujui">
<input type="hidden" id="id_jenis" value="<?php echo $idjenis;?>">
    <table class="head" width="40%" cellspacing="2" celpadding="2">
      <tr>
        <td width="15%">&nbsp; Vaksin</td>
        <td width="25%">: <?php echo $nama;?></td>
      </tr> 
      <tr>
        <td>&nbsp; Total Stok</td>
        <td>: <?php echo $jstok;?>
            <input type="hidden" id="stok_vaksin" value="<?php echo $jstok;?>">
        </td>
      </tr> 
      <tr>
        <td>&nbsp; Jumlah Order</td>
        <td>: <?php echo $jmlorder;?></td>
      </tr>
    </table>   
    <input type="button" id="getVaksin" class="getVaksin" value="Tambah Vaksin">
    <table class='list_amprah' id='list_amprah' width="100%" cellspacing="2" cellpadding="2" style='padding-left:10px;'>
		<tr bgcolor="#80B302">
			<td width="4%" align="right"><b>No.</b></td>
			<td width="30%"><b>Kode Batch</b></td>
            <td width="15%"><b>Tgl Expired</b></td>
            <td width="10%"><b>Stok</b></td>
			<td width="10%"><b>Dipenuhi</b></td>
			<td width="10%" align="center"><b>Hapus</b></td>				
		</tr>
    </table>  
    <div id="result_approval"></div>    
</div>
