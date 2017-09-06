<?php
 $kode = $_GET['u'];
 $ki = base64_decode($kode);
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>-LOG-</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="cache-control" content="no-cache">
  <meta name="description" content="Job Order Mitra Kargo"> 
  <meta name="author" content="786mastoro.shadiq2016">


    <!-- Bootstrap Core CSS -->
    
    <link rel="stylesheet" href="css/zebra-dialog.css">
    <link rel="stylesheet" href="css/spinner.css">
    <link rel="stylesheet" href="css/jquery.dataTables.css">
   
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">


    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui.js" type="text/javascript"></script>
     
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="js/zebra-dialog.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/jquery.formatCurrency-1.4.js"></script>


    <script type="text/javascript">
         $(document).ready(function(){
            $(".loading").hide();


             $("#dialog_amprahan").dialog({
                autoOpen: false,
                height: '650',
                width: '850',
                modal: true,
                title: 'Detil Amprahan',
                buttons: {
                 
                    "Close": function() {
                        $(this).dialog("close");

                      }
                 }
               }) 

             $("#edit_amprahan").dialog({
                autoOpen: false,
                height: '650',
                width: '850',
                modal: true,
                title: 'Edit Amprahan',
                buttons: {
                    "Close": function() {
                        $(this).dialog("close");

                      }
                 }
               }) 

            $(document).on('click','.amprahan',function(){
               var id = $(this).attr('id');
              $.ajax({
                     type : 'post',
                     url  : 'amprahan.php',
                     data : 'kode_instansi='+id,
                     beforeSend:function(){
                       $(".loading").show();
                     },
                     success:function(html){
                       $(".loading").hide();
                       $("#konten").html(html);
                     }
              })
            })
        
           $(document).on('click','.stok',function(){
               var id = $(this).attr('data-id');
               
               $.ajax({
                     type : 'post',
                     url  : 'stokvaksin.php',
                     data : 'kode_instansi='+id,
                     beforeSend:function(){
                       $(".loading").show();
                     },
                     success:function(html){
                       $(".loading").hide();
                       $("#konten").html(html);
                     }
              })
            })
            
           $(document).on('click','#new_amprahan',function(){
              var id = $(this).attr('data-id');
             
              $.ajax({
                     type : 'post',
                     url  : 'form_amprahan.php',
                     data : 'kode_instansi='+id,
                     beforeSend:function(){
                       $(".loading").show();
                     },
                     success:function(html){
                       $(".loading").hide();
                       $("#konten").html(html)
                     }
              })
            })

        

            $(document).on('click','#edit_pakai',function(){
                var id  = $(this).attr('data-id');
                var kis = $(this).attr('data-kode');
                var thn = $(this).attr('data-tahun');
                var bln = $(this).attr('data-bulan');

                $.ajax({
                      type : 'post',
                      url  : 'edit_pemakaian.php',
                      data : 'id_pakai='+id+'&kode_instansi='+kis+'&tahun='+thn+'&bulan='+bln,
                      beforeSend:function(){
                        $(".loading").show();
                      },
                      success:function(html){
                        $(".loading").hide();
                        $("#konten").html(html);
                      }
                })
            })

             $(document).on('click','#view_pakai',function(){
                var id  = $(this).attr('data-id');
                var kis = $(this).attr('data-kode');
                var thn = $(this).attr('data-tahun');
                var bln = $(this).attr('data-bulan');

                $.ajax({
                      type : 'post',
                      url  : 'view_pemakaian.php',
                      data : 'id_pakai='+id+'&kode_instansi='+kis+'&tahun='+thn+'&bulan='+bln,
                      beforeSend:function(){
                        $(".loading").show();
                      },
                      success:function(html){
                        $(".loading").hide();
                        $("#konten").html(html);
                      }
                })
            })

              $(document).on('click','#new_pemakaian',function(){
              var id = $(this).attr('data-id');
              
              $.ajax({
                     type : 'post',
                     url  : 'form_pemakaian.php',
                     data : 'kode_instansi='+id,
                     beforeSend:function(){
                       $(".loading").show();
                     },
                     success:function(html){
                       $(".loading").hide();
                       $("#konten").html(html)
                     }
              })
            })

            $(document).on('click','#detil_amprah',function(){
              var idp = $(this).attr('data-id');
              var tgl = $(this).attr('data-tgl');
              var ins = $(this).attr('data-instansi');
              $.ajax({
                    type : 'post',
                    url  : 'detil_amprahan.php',
                    data : 'id_proses='+idp+'&tanggal='+tgl+'&kode_instansi='+ins,
                    beforeSend:function(){
                      $(".loading").show();
                    },
                    success:function(html){
                      $(".loading").hide();
                      $("#dialog_amprahan").dialog('open');
                      $("#isidetil").html(html);
                    }
              })
            })


            $(document).on('click','#edit_amprah',function(){
              var idp = $(this).attr('data-id');
              var tgl = $(this).attr('data-tgl');
              var ins = $(this).attr('data-instansi');
             
              $.ajax({
                    type : 'post',
                    url  : 'edit_amprahan.php',
                    data : 'id_proses='+idp+'&tanggal='+tgl+'&kode_instansi='+ins,
                    beforeSend:function(){
                      $(".loading").show();
                    },
                    success:function(html){
                      $(".loading").hide();
                      $("#dialog_amprahan").dialog('open');
                      $("#isidetil").html(html);
                    }
              })
            })


            $(document).on('click','.pemakaian',function(){
               var id = $(this).attr('id');
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
             })

             
        
         })
         
        
    </script>
    <style>
    .ui-autocomplete-loading { background:url('images/ajax-loader.gif') no-repeat right center;padding-right:15px }
    
    *{
      margin: 0;
    }
    
    .wrapper {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        margin: 0 auto -155px; /* the bottom margin is the negative value of the footer's height */
    }
    .footer, .push {
        height: 155px; /* .push must be the same height as .footer */
    }  
    
    </style>
</head>
 
<body>
<div class="loading">Loading...</div>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#" class="home">Sistem Informasi Logistik Vaksin</a>
    </div>
    <ul class="nav navbar-nav">
       <li class="active"><a href="main.php?u=<?php echo base64_encode($ki);?>" class="home">Home</a></li>
       <li><a href="#" class="stok" data-id="<?php echo $ki;?>">Stok Vaksin</a></li>
       <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Transaksi
                         <span class="caret"></span></a>
                            <ul class="dropdown-menu">                           
                                <li><a href="#" class="amprahan" id="<?php echo $ki;?>">Amprahan Vaksin</a></li>
                                <li><a href="#" class="pemakaian" id="<?php echo $ki;?>">Pemakaian Vaksin</a></li>
                            </ul>
                        </li>
     

    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#">
            <span class="glyphicon glyphicon-user"></span> 
             <?php 
               //echo $ki;
               //get nama instansi 
               include_once "conf/openconn.php";

               $get = "SELECT nama from instansi where kode_instansi='".$ki."'";
               $qry =  mysqli_query($koneksi, $get);
               while ($ot=mysqli_fetch_array($qry)){
                 $nama = $ot['nama'];
                 echo $nama;
               }
             ?>
             
             
             </a>
        </li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
  </div>
</nav>
  
<div class="container" id="konten">
  <br>
 
  <!--h4>Puskesmas <?php echo $nama;?></h4-->

  <div align="center">
    <img src="images/header-logvaksin.png">
    <img src="images/banner.png">
    
    
    </div>
</div>


<!-- -->
<div id="dialog_amprahan">
  <div id="isidetil"></div>
</div>
 

<!-- -->
</body>
</html>
