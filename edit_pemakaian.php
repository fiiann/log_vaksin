<?php
	include "conf/openconn.php";
	include "lib/functions-php.php"; 	
	
    $idpakai  = $_POST['id_pakai'];
    $kodeins  = $_POST['kode_instansi'];
    $thn_pakai= $_POST['tahun'];
    $bln_pakai= $_POST['bulan'];
 
    $getpakai = "SELECT p.tanggal
                        ,p.bulan 
                        ,p.tahun 
                        ,p.is_fix
                        ,d.id_jenis
                        ,d.jumlah 
                        ,d.satuan
                FROM pemakaian p 
                inner join pemakaian_detil d 
                 on p.id_pakai=d.id_pakai 
                where p.id_pakai='".$idpakai."' and p.kode_instansi='".$kodeins."'";

    $qrypakai = mysql_query($getpakai) or die (mysql_query());            

    
//	$ki = $_POST['kode_instansi'];
    $tgl_skr = date('Y-m-d');
 
    $tahun = date('Y');
    $x=$tahun-1; 

  
  
 ?>		
			
<script>
$(document).ready(function() {
    var max_fields      = 8; //maximum input boxes allowed
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
        var list = $(".list_vaksin tr").length;
        e.preventDefault();
        $(".hapus").prop("disabled",true);
       
        if(list < max_fields){ //max input box allowed
            x++; //text box increment
            
            $(wrapper).append('<div class="input-list style-1 clearfix" style="background-color:#c0c0c0">&nbsp;# &nbsp;&nbsp; | &nbsp;  Jenis Vaksin : <select name="jenis_vaksin[]" data-id='+x+' id="jenis_vaksin_'+x+'" class="jenis_vaksin option-1" style="width:110px"></select> &nbsp; Stok : <input type="text" id="stok_'+x+'" class="style-1" style="text-align:right" disabled> &nbsp; Pemakaian : <input type="text" name="jml_pakai[]" id="jml_pakai_'+x+'" value="0" style="text-align:right">  &nbsp;&nbsp;  Satuan : <input type="text" class="style-1" id="satuan_'+x+'" name="satuan[]"> <button class="save_new btn btn-info btn-sm" id="'+x+'"><i class="glyphicon glyphicon-floppy-disk"></i> </button> <button class="btn btn-danger btn-sm" id="btn-remove">X</button> </div>'); //add input box
            list_jenis(x);
        }
    });
   
    $(wrapper).on("click","#btn-remove", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
        if (x<=1){
            $(".hapus").prop("disabled",false);
        }
    })

    
    $(document).on('click','.save_new',function(){
       var id = $(this).attr('id');
       var idj = $("#jenis_vaksin_"+id).val();
       var idp = $("#id_pakai").val();
       var jm  = $("#jml_pakai_"+id).val();
       var sat = $("#satuan_"+id).val();
       var stok= $("#stok_"+id).val();
       var kodei= $("#kode_instansi").val();
       var sisa = stok - jm;

       $.ajax({
            type : 'post',
            url  : './trx/addpakaivaksin.php',
            data : 'idpakai='+idp+'&idjenis='+idj+'&jumlah='+jm+'&satuan='+sat+'&sisa='+sisa+'&kode_instansi='+kodei,
            success:function(html){
                $("#result_update").html(html);
            }
       })
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

    $(".remove").click(function(){
        var id   = $(this).attr('id');
        var idn  = $(this).attr('data-id');
        var idpk = $("#id_pakai").val();
        var jmlp = parseInt($("#jml_pakai_awal_"+idn).val());
        var stk  = parseInt($("#stok_sisa_"+idn).val());
        var kodi = $("#kode_instansi").val();
        var retur= jmlp+stk;
         $.Zebra_Dialog('<strong>Data ini akan dihapus..?</strong>', {
                        'type': 'question',
                        'title': 'Perhatian',
                        'buttons': [{
                                caption: 'Ya',
                                callback: function() {
                                    $.ajax({
                                        type : 'post',
                                        url  : './trx/del_pakai.php',
                                        data : 'idjenis='+idn+'&idpakai='+idpk+'&stok_retur='+retur+'&kode_instansi='+kodi,
                                        success:function(){

                                        }
                                    })
                                    $("#list_vaksin_"+id).remove();
                                    return true;
                                }
                    }, {
                        caption: 'Tidak'
                    }]
                })   
      
 
    })
/*
    $(".jmlv").click(function(){
        var id = $(this).attr('id');
        var idj= $(this).attr('data-id');
    }).change(function(){
        var id = $(this).attr('id');
        var idj= $(this).attr('data-id');
        var nil= $("#jml_pakai_"+id).val();
        var idpakai = $("#id_pakai").val();
        
        $.ajax({
                type : 'post',
                url  : './trx/auto_simpan.php',
                data : 'id_jenis='+idj+'&jumlah='+nil+'&id_pakai='+idpakai,
                success:function(html){
                    $("#result_update").html(html);
                }
        })
    })
*/

    $(".pakai").click(function(){
        var id = $(this).attr('data-id');
    }).change(function(){
        var id = $(this).attr('data-id');
        var jpak = parseInt($("#jml_pakai_"+id).val());
        var sasi = parseInt($("#stok_sisa_"+id).val());
        var jpaw = parseInt($("#jml_pakai_awal_"+id).val());
        var idpakai= $("#id_pakai").val();
        var kdins  = $("#kode_instansi").val();
        var bln = $("#bulan").val();
        var thn = $("#tahun").val();
       
        var rms  = jpak-jpaw;
        var sisa = sasi-rms;
        if (rms>sasi){
            alert('Opsss..melebihi sisa stok yang tersedia');
            $("#jml_pakai_"+id).val(jpaw);
        }else{
            $.ajax({
                  type : 'post',
                  url  : './trx/auto_simpan.php',
                  data : 'id_jenis='+id+'&jml_pakai='+jpak+'&stok_sisa='+sisa+'&id_pakai='+idpakai+'&kode_instansi='+kdins+'&bulan='+bln+'&tahun='+thn,
                  beforeSend:function(){
                      $("#loader_"+id).show();
                  },
                  success:function(html){
                      $("#loader_"+id).hide();
                      $("#res_"+id).show();
                      $("#res_"+id).fadeOut(4000);
                      $("#stok_sisa_"+id).val(sisa);
                     // $("#result_update").html(html);
                  }
            })
        }
    })

    $(".fixed").click(function(){
        var id_pakai = $("#id_pakai").val();
        $.ajax({
              
                        type : 'post',
                        url  : './trx/fixing_pakai.php',
                        data : 'idpakai='+id_pakai,
                        success:function(html){
                             $.Zebra_Dialog(html, {
                                'type': 'confirmation',
                                'title': 'Confirm',
                                'buttons': [{
                                    caption: 'OK',
                                    callback: function() {
                                        $("input[type='text']").prop("disabled",true);
                                        $(".btn").prop("disabled",true);
                                    }
                                }]
                            });            
                     }
        })
    })


    $(".hapus").click(function(){
        var tipe ='all';
        var jpa = [];
        var sks = [];
        var tot = [];
        var idjn= [];
        var idpk= $("#id_pakai").val();
        var kdi = $("#kode_instansi").val();
        var bln = $("#bulan").val();
        var thn = $("#tahun").val();

        $("input[name='stok_sisa[]']").each(function(){
            sks.push($(this).val());
        })

        $("input[name='jml_pakai_awal[]']").each(function(){
            jpa.push($(this).val());
        })
        
        $("select[name='jenis_vaksin[]']").each(function(){
            idjn.push($(this).val());
        })
        $.Zebra_Dialog('<strong>Yakin Semua Data ini akan dihapus..?</strong>', {
                        'type': 'question',
                        'title': 'Perhatian',
                        'buttons': [{
                                caption: 'Ya',
                                callback: function() {
                                      $.ajax({
                                            type :'post',
                                            url  : './trx/del_pakai.php',
                                            data : 'tipe='+tipe+'&idpakai='+idpk+'&kode_instansi='+kdi+'&id_jenis='+idjn+'&pakai_awal='+jpa+'&stoksisa='+sks+'&tahun='+thn+'&bulan='+bln,
                                            success:function(html){
                                              //  $("#result_update").html(html);
                                              listpakai();
                                            }
                                    })
                                    return true;
                                }
                    }, {
                        caption: 'Tidak'
                    }]
            })   

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
	<legend>Edit Pemakaian Vaksin</legend>
    <div class="input_fields_wrap" style="width:780px;">
    <button class="btn btn-primary" id="btn">Add Form</button> 
    <br><br>
    <div id="result_update"></div>
    <form class="form-horizontal">
         <div class="form-group">
          <div class="form-inline">
          <label class="control-label col-sm-3" for="nomor">Bulan dan Tahun</label>
          <div class="col-sm-9">
                <select id="bulan" class="form-control" style="width:200px" disabled>
                    <?php
                        $bulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                        for($y=1;$y<=12;$y++){
                            if($y==$bln_pakai){ $pilih="selected";}
                            else {$pilih="";}
                            echo("<option value=\"$y\" $pilih>$bulan[$y]</option>"."\n");
                        }
                    ?>
                </select> <select id="tahun" class="form-control" style="width:120px" disabled>
                    <option value="<?php echo $thn_pakai;?>"><?php echo $thn_pakai;?></option>            
               </select>
         </div>   
      </div>
     </div>
   </form>    
    	<div class="input-list style-1 clearfix" style="background-color:#eee">	 
        <table class="list_vaksin">
            <?php 
            while ($pk=mysql_fetch_array($qrypakai)){
                $nomor++;
                $id_jenis = $pk['id_jenis'];
                $jumlah   = $pk['jumlah'];
                $satuan   = $pk['satuan']; 
                $is_fix   = $pk['is_fix'];

                $nmvaksin = "SELECT nama from jenis_vaksin where id_jenis='".$id_jenis."'";
                $qrynama  = mysql_query($nmvaksin) or die (mysql_error());
                while ($nmv=mysql_fetch_array($qrynama)){
                    $namavaksin = $nmv['nama'];
                }

                  //get sisa stok vaksin 
                 $ssa = "SELECT jumlah from instansi_stok where kode_instansi='".$kodeins."' and id_jenis='".$id_jenis."' and bulan='".$bln_pakai."' and tahun='".$thn_pakai."'";
                 $qssa= mysql_query($ssa) or die (mysql_error());
                 while($js=mysql_fetch_array($qssa)){
                     $jmls = $js['jumlah'];
                 }
                     
                 
                
                
                ?>
                <tr id="list_vaksin_<?php echo $nomor;?>"><td class="jmlv" id="<?php echo $nomor;?>" data-id="<?php echo $id_jenis;?>">
                	<span id="list_vaksin" class='txt'>&nbsp; <?php echo $nomor;?> &nbsp; | &nbsp;  Jenis Vaksin : <select id='jenis_vaksin' name="jenis_vaksin[]" class="option-1" style="width:180px" disabled>
					   <option value="<?php echo $id_jenis;?>"><?php echo $namavaksin;?></option> 
				    </select> &nbsp; &nbsp; Pemakaian : <input type="text" class="pakai style-1" id="jml_pakai_<?php echo $id_jenis;?>" data-id="<?php echo $id_jenis;?>" value="<?php echo $jumlah;?>" style="text-align:right"> &nbsp;&nbsp; 
				    Sisa Stok : <input type="text" class="style-1" id="stok_sisa_<?php echo $id_jenis;?>" name="stok_sisa[]" value="<?php echo $jmls;?>" readonly style="text-align:right">
                    &nbsp; <button class="remove btn btn-danger btn-sm" id="<?php echo $nomor;?>" data-id="<?php echo $id_jenis;?>">X</button></span> 
                    <input type="hidden" id="jml_pakai_awal_<?php echo $id_jenis;?>" name="jml_pakai_awal[]" value="<?php echo $jumlah;?>">
                    <span class="loader" id="loader_<?php echo $id_jenis;?>" style="display:none"><img src="img/preloader.gif">menyimpan..</span>
                    <span id="res_<?php echo $id_jenis;?>" style="display:none">tersimpan...</span>
                </td></tr>
            <?php } ?>	
           </table> 	        
		</div>
</div>
<br>
<input type="hidden" id="kode_instansi" value="<?php echo $kodeins;?>">
<input type="hidden" id="id_pakai" value="<?php echo $idpakai;?>">
<input type="hidden" id="tanggal" value="<?php echo $tgl_skr;?>">
<?php 
if ($is_fix==0){
    echo "<button class='hapus btn btn-danger' id='hapus' style='position:absolute;top:123px;left:710px'>Hapus Data Pemakaian</button>";
    echo "<button class='fixed btn btn-primary' id='status_fix' data-id='$idpakai' style='position:absolute;top:123px;left:210px'>Set Status Fix</button>";
}else{
    echo "<button class='btn btn-danger disabled' style='position:absolute;top:123px;left:710px'>Hapus Data Pemakaian</button>";
    echo "<button class='btn btn-success' id='sudah_fix' style='position:absolute;top:123px;left:210px'>Sudah Fix</button>";
}
?>

</fieldset>
 
