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
	
    function list_jenis(x){
		$.ajax({
				type : "POST",
				url  : "get_jenis_vaksin.php",
				success:function(html){		 
					$("#jenis_vaksin_"+x).append(html);
				}
		})
		
	}

    function listpakai(){
                var id = $('#kode_instansi').val;
                $.ajax({
                     type : 'post',
                     url  : 'pemakaian.php',
                     data : 'kode_instansi='+id,
                     beforeSend:function(){
                       $(".loading").show();
                     },
                     success:function(html){
                       $(".loading").hide();
                       $("#konten").html(html);
                     }
                })
             }
	
	$("#simpan_pakai").prop("disabled",false);
	$(".add_field_button").prop("disabled",false);
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
       
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="input-list style-1 clearfix" style="background-color:#eee">&nbsp; '+ x +'&nbsp;&nbsp; | &nbsp;  Jenis Vaksin : <select name="jenis_vaksin[]" id="jenis_vaksin_'+x+'" data-id='+x+' class="jenis_vaksin option-1" style="width:110px"></select> &nbsp; &nbsp; &nbsp; Stok : <input type="text" id="stok_'+x+'" class="style-1" style="text-align:right" disabled>&nbsp; Jumlah Pemakaian : <input type="text" class="jumlah_pakai" data-id='+x+' name="jml_pakai[]" id="jml_pakai_'+x+'" value="0" style="text-align:right">  &nbsp;&nbsp;  Satuan : <input type="text" class="style-1" id="satuan" name="satuan[]"><input type="hidden" class="style-1" id="sisa_stok_'+x+'" name="sisa_stok[]"> <button class="btn btn-danger" id="btn-remove">X</button></div>'); //add input box
			list_jenis(x);
		}
    });
   
    $(wrapper).on("click","#btn-remove", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })


   $(document).on('change','.jenis_vaksin',function(){
        var idjn = $(this).val();
        var kdi  = $("#kode_instansi").val();
        var id = $(this).attr('data-id');
    
        $.ajax({
              type : 'post',
              url  : './trx/getjmlstok.php',
              data : 'idjenis='+idjn+'&kode_instansi='+kdi,
              dataType : "json",
              success:function(data){
                  var jstok = data.stok;
                  $("#stok_"+id).val(jstok);
              }
        })
   })
  /*  $(".jenis_vaksin").change(function(){
     
    })
*/
    $("#simpan_pakai").click(function(){
		var jumlah = [];
		var vaksin = [];
        var satuan = [];
		var kode_i = $("#kode_instansi").val();
        var bulan  = $("#bulan").val();
        var tahun  = $("#tahun").val();
        var aksi   = "insert";
        var idpakai= $("#id_pakai").val();
        var sisa   = [];

        $("input[name='sisa_stok[]']").each(function(){
            sisa.push($(this).val());
        })

		$("input[name='jml_pakai[]']").each(function(){
			jumlah.push($(this).val());			
		});
			
		$("select[name='jenis_vaksin[]']").each(function(){
			vaksin.push($(this).val());
		});
		
        $("input[name='satuan[]']").each(function(){
            satuan.push($(this).val());
        })     

 
        if (jumlah!=0){
            $.ajax({
                    type : 'post',
                    url  : './trx/simpan_pemakaian.php',
                    data : 'aksi='+aksi+'&idpakai='+idpakai+'&jenis_vaksin='+vaksin+'&jumlah='+jumlah+'&kode_instansi='+kode_i+'&bulan='+bulan+'&tahun='+tahun+'&satuan='+satuan+'&sisa='+sisa,
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
                                    listpakai();
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


    $(document).on('click keyup','.jumlah_pakai',function(){
        var id = $(this).attr('data-id');
        var jp = parseInt($("#jml_pakai_"+id).val());
        var st = parseInt($("#stok_"+id).val());

        if (jp>st){
             alert('Oopss melebihi stok yang tersedia...');
             $("#jml_pakai_"+id).val(0);
             $("#jml_pakai_"+id).focus();
             $("#sisa_stok_"+id).val(st);
        }else{
             var sisa = st-jp;
             $("#sisa_stok_"+id).val(sisa);
        }
    })
	
});
</script>
<style>
.style-1 input[type="text"] {
  padding: 6px;
  border: solid 1px #dcdcdc;
  transition: box-shadow 0.3s, border 0.3s;
  border-radius:4px;
  width:70px;
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
}
.remove_field{
  padding: 10px;
  
  transition: box-shadow 0.5s, border 0.5s;
}
</style>
<fieldset>
	<legend>Form Pemakaian Vaksin</legend>
    <div class="input_fields_wrap" style="width:850px;">
    <button class="btn btn-primary" id="btn">Add Form</button>
    <br><br>
    <input type="hidden" id="id_pakai" value="<?php echo autonumb('pemakaian','id_pakai',2,'PV');?>">
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
                            </select>
         </div>   
      </div>
     </div>
   </form>    
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
				   </select> &nbsp; &nbsp; &nbsp; Stok : <input type="text" id="stok_1" class="style-1" style="text-align:right" disabled>&nbsp;  Jumlah Pemakaian : <input type="text" class="jumlah_pakai style-1" name="jml_pakai[]" data-id="1" id="jml_pakai_1" value="0" style="text-align:right"> &nbsp;&nbsp; 
				   Satuan : <input type="text" class="style-1" id="satuan" name="satuan[]">
                   <input type="hidden" class="style-1" id="sisa_stok_1" name="sisa_stok[]">
                
		</div>
</div>
<br>
<input type="hidden" id="kode_instansi" value="<?php echo $ki;?>">
<input type="hidden" id="tanggal" value="<?php echo $tgl_skr;?>">
<button class="btn btn-primary" id="simpan_pakai">Simpan Pemakaian</button>
</fieldset>
 
