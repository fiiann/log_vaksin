<?php 

 include_once "../conf/openconn.php";

 $kodei   = $_POST['kode_instansi'];
 $bln_a   = $_POST['bulan'];
 $thn_a   = $_POST['tahun'];

 //cek apakah sudah pernah amprahan di tabel pakai
 $cek = "SELECT kode_instansi from pemakaian where kode_instansi='$kodei'";
 $qck = mysql_query($cek) or die (mysql_error());
 $ada = mysql_num_rows($qck);
 if ($ada!=0){
    $getbt = "SELECT is_approve, tahun, bulan FROM pemakaian WHERE kode_instansi='$kodei'";
    $qrybt = mysql_query($getbt) or die (mysql_error());
    while ($bt=mysql_fetch_array($qrybt)){
        $bln_p = $bt['bulan'];
        $thn_p = $bt['tahun'];
        $isap  = $bt['is_approve'];
    }

    if (($thn_a>=$thn_p) && ($bln_a>=$bln_p) && ($isap==0)){
        $data['status']='waiting';
    }else if (($thn_a>=$thn_p) && ($isap==0)){
        $data['status']='waiting';
    }else if (($thn_a==$thn_p) && ($bln_a==$bln_p) && ($isap==1)){
        $data['status']='already';
    }else{
        $data['status']='ok';
    }

 }else{
    $data['status']='ok';
 }

 echo json_encode($data);

?>