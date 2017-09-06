<?php
	include "conf/openconn.php";
	include "lib/functions-php.php"; 	
	
	$ki = $_POST['kode_instansi'];
    $tgl_skr = date('Y-m-d');
    
    $tahun = date('Y');
    $x=$tahun-2; 
 ?>		
			
<script>
$(document).ready(function() {
    var max_fields      = 20; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $("#btn"); //Add button ID
	var add_new			= $(".add_new_button");
	
	add_new.hide();
	$("#form_amprahan").hide();
    function list_jenis(x){
		$.ajax({
				type : "POST",
				url  : "get_jenis_vaksin.php",
				success:function(html){		 
					$("#jenis_vaksin_"+x).append(html);
				}
		})
		
	}

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
	
	$("#simpan_minta").prop("disabled",false);
	$(".add_field_button").prop("disabled",false);
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="input-list style-1 clearfix" style="background-color:#eee">&nbsp; '+ x +'&nbsp;&nbsp; | &nbsp;  Jenis Vaksin : <select name="jenis_vaksin[]" id="jenis_vaksin_'+x+'" data-id='+x+' class="jenis_vaksin option-1" style="width:110px"></select> &nbsp; &nbsp; &nbsp; Jumlah Minta : <input type="text" name="jml_minta[]" id="jml_minta" size="30" value="0" style="text-align:right">  &nbsp;&nbsp; <button class="btn btn-danger" id="btn-remove">X</button></div>'); //add input box
			list_jenis(x);
		}
    });
   
    $(wrapper).on("click","#btn-remove", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })

    $("#simpan_minta").click(function(){
		var jumlah = [];
		var vaksin = [];
		var kode_i = $("#kode_instansi").val();
        var tgl    = $("#tanggal").val();
        var bln    = $("#bulan").val();
        var thn    = $("#tahun").val();

		$("input[name='jml_minta[]']").each(function(){
			jumlah.push($(this).val());			
		});
			
		$("select[name='jenis_vaksin[]']").each(function(){
			vaksin.push($(this).val());
		});
		
        

        if (jumlah!=0){
            $.ajax({
                    type : 'post',
                    url  : './trx/simpan_amprahan.php',
                    data : 'jenis_vaksin='+vaksin+'&jumlah='+jumlah+'&kode_instansi='+kode_i+'&tanggal='+tgl+'&bulan='+bln+'&tahun='+thn,
                    beforeSend:function(){
                        $(".loading").show();
                    },success:function(html){
                        $(".loading").hide();
                           $.Zebra_Dialog(html, {
                            'type': 'confirmation',
                            'title': 'Confirm',
                            'buttons': [{
                                caption: 'OK',
                                callback: function() {
                                    list_amprah();
                                }
                            }]
                        });
                    }
            })
        }else{
             $.Zebra_Dialog('Kolom Jumlah Masih Kosong...', {
                            'type': 'warning',
                            'title': 'Perhatian',
                            'buttons': [{
                                caption: 'OK',
                                callback: function() {
                                    
                                }
                            }]
                        });
        }

    })

    $("#proses_amprah").click(function(){
        var bln  = $("#bulan").val();
        var thn  = $("#tahun").val();
        var kodei= $("#kode_instansi").val();

        $.ajax({
              type : 'POST',
              url  : './trx/check_pakai.php',
              data : 'kode_instansi='+kodei+'&bulan='+bln+'&tahun='+thn,
              dataType:'json',
              success:function(data){
                   var st = data.status;
                   $("#form_amprahan").hide();
                   if (st=='waiting'){
                          $.Zebra_Dialog('Maaf Laporan Pemakaian Bulan Sebelumnya masih ditinjau oleh Pusat...', {
                            'type': 'warning',
                            'title': 'Perhatian',
                            'buttons': [{
                                caption: 'OK',
                                callback: function() {
                                    
                                }
                            }]
                        });
                   }else if(st=='already'){
                       $("#form_amprahan").hide();
                         $.Zebra_Dialog('Maaf Amprahan Sudah Pernah diajukan...', {
                            'type': 'warning',
                            'title': 'Perhatian',
                            'buttons': [{
                                caption: 'OK',
                                callback: function() {
                                    
                                }
                            }]
                        });
                   }else{
                       $("#form_amprahan").show();
                   }
              }
        })
    })   
	
});
</script>
<style>
.style-1 input[type="text"] {
  padding: 6px;
  border: solid 1px #dcdcdc;
  transition: box-shadow 0.3s, border 0.3s;
}
.style-1 input[type="text"]:focus,

.style-1 input[type="text"].focus {
  border: solid 1px #707070;
  box-shadow: 0 0 5px 1px #969696;
}

.option-1 {
  padding: 6px;
  border: solid 1px #dcdcdc;
  transition: box-shadow 0.3s, border 0.3s;
  width:110px;
}
.remove_field{
  padding: 10px;
  
  transition: box-shadow 0.5s, border 0.5s;
}
</style>
<fieldset>
	<legend>Form Amprahan Vaksin</legend>
    <form class="form-horizontal">
         <div class="form-group">
          <div class="form-inline">
          <label class="control-label col-sm-3" for="nomor">Bulan dan Tahun</label>
          <div class="col-sm-9">
                <select id="bulan" class="form-control" style="width:200px">
                    <?php
                        $bulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                        for($y=1;$y<=12;$y++){
                            if($y==date("m")){ $pilih="selected";}
                            else {$pilih="";}
                            echo("<option value=\"$y\" $pilih>$bulan[$y]</option>"."\n");
                        }
                    ?>
                </select> <select id="tahun" class="form-control" style="width:120px">
                            <?php   
                            for ($i=0;$i<2;$i++){
                                $x=$x+1;
                                echo "<option value='$x'>$x</option>";
                            } 
                            ?>
               </select> <button class="btn btn-primary" type="button" id="proses_amprah">Proses</button>
         </div>   
      </div>
     </div>
   </form> 
   <div id="result"></div>
    <div class="input_fields_wrap" style="width:770px;" id="form_amprahan">
    <button class="btn btn-primary" id="btn">Add Form</button>
	<br><br>
    
    	<div class="input-list style-1 clearfix" style="background-color:#eee">	 
			<span id="no" class='txt'>&nbsp; 1 &nbsp; | &nbsp;  Jenis Vaksin : <select name='jenis_vaksin[]' data-id='1' class="jenis_vaksin option-1" style="width:110px">
					<option selected>[ None ]</option>
					<?php
						include './conf/openconn.php';
						$get = "select * from jenis_vaksin order by id_jenis ASC";
						$qry = mysql_query($get);
						while($data=mysql_fetch_array($qry))
						{
							$idjns = $data['id_jenis'];
							$nmjns = $data['nama'];
							
							echo "<option value='$idjns'>$nmjns</option>";
						}
						include './conf/closeconn.php';
					?>
				   </select> &nbsp; &nbsp; &nbsp; Jumlah Minta : <input type="text" class="style-1" name="jml_minta[]" id="jml_minta" size="30" value="0" style="text-align:right"> &nbsp;&nbsp; 
				 
		</div>
        
</div>
<button class="btn btn-primary" id="simpan_minta">Simpan Permintaan</button>
<br>
<input type="hidden" id="kode_instansi" value="<?php echo $ki;?>">
<input type="hidden" id="tanggal" value="<?php echo $tgl_skr;?>">

</fieldset>
 
