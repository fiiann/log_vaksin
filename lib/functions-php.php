<?php
    function kdauto($tabel, $inisial){
      $struktur	= mysql_query("SELECT * FROM $tabel");
      $field		= mysql_field_name($struktur,0);
      $panjang	= mysql_field_len($struktur,0);
      
      
      $qry	= mysql_query("SELECT max(".$field.") FROM ".$tabel);
      $row	= mysql_fetch_array($qry); 
      if ($row[0]=="") {
        $angka=0;
      }
      else {
        $angka		= substr($row[0], strlen($inisial));
      }
      
      $angka++;
      $angka	=strval($angka); 
      $tmp	="";
      for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
        $tmp=$tmp."0";	
      }
      return $inisial.$tmp.$angka;
}

function autonumb($tabel, $kolom, $lebar=0, $awalan=''){ 
        $query="select $kolom from $tabel order by $kolom desc limit 1";
            
        $hasil=mysql_query($query);    
        $jumlahrecord=mysql_num_rows($hasil);
        $kode=mysql_fetch_array($hasil);
        $num =substr($kode[0],5,2);
        $thn=date('Y');
        $bln=date('m');

        $y=substr($thn,-1,1);
        $ykode = substr($kode[0],2,1);
        $newy  = substr($thn,3,1);

        if(($jumlahrecord==0) || ($newy>$ykode)){       
            $nomor=1; 
        }else{
            $row=mysql_fetch_array($hasil);
            $nomor=intval($num+1);   
        } 
        if($lebar>0) 
            
            $angka=$awalan.$y.$bln."".str_pad($nomor,$lebar,"0",STR_PAD_LEFT);
        else        
            $angka=$awalan.$y.$bln."".$nomor;
            return $angka;
}


function kode_instansi($tabel, $kolom, $lebar=0, $awalan=''){ 
        $query="select $kolom from $tabel order by $kolom desc limit 1";
            
        $hasil=mysql_query($query);    
        $jumlahrecord=mysql_num_rows($hasil);
        $kode=mysql_fetch_array($hasil);
        $num =substr($kode[0],6,5);
        $thn=date('Y');
        $bln=date('m');

        $y=substr($thn,-1,1);
        $ykode = substr($kode[0],2,1);
        $newy  = substr($thn,3,1);

        if(($jumlahrecord==0) || ($newy>$ykode))       
            $nomor=1; 
        else{
            $row=mysql_fetch_array($hasil);
            $nomor=intval($num+1);   
        } 
        if($lebar>0) 
            
            $angka=$awalan.$y.$bln.str_pad($nomor,$lebar,"0",STR_PAD_LEFT);
        else        
            $angka=$awalan.$y.$bln.$nomor;
            return $angka;
}


function kode_otomatis($tab, $kol, $leb=0, $awal=''){ 
        $sql="select $kol from $tab order by $kol desc limit 1";
            
        $hsl=mysql_query($sql);    
        $jumrec=mysql_num_rows($hsl);
        
        if($jumrec==0)       
            $no=1; 
        else{
            $row=mysql_fetch_array($hsl);
            $no=intval(substr($row,strlen($awal)))+1;   
        } 
        if($leb>0) 
            $angka=$awal.str_pad($no,$leb,"0",STR_PAD_LEFT);
        else        
            $angka=$awal.$no;
            return $angka;
}


function tgl_ind_to_eng() {
	$tgl_eng=substr($tgl,6,4)."-".substr($tgl,3,2)."-".substr($tgl,0,2);
	return $tgl_eng;
}

// Konversi yyyy-mm-dd -> dd-mm-yyyy
function tgl_eng_to_ind($tgl) {
	$tgl_ind=substr($tgl,8,2)."-".substr($tgl,5,2)."-".substr($tgl,0,4);
	return $tgl_ind;
}

function format_angka($angka) {
	$hasil =  number_format($angka,0, ",",".");
	return $hasil;
}
function tgl_indo($tgl){
      $tanggal  = substr($tgl,8,2);
      $bulan    = getBulan(substr($tgl,5,2));
      $tahun    = substr($tgl,0,4);
      return $tanggal.' '.$bulan.' '.$tahun;         
    }    

	function getBulan($bln){
      switch ($bln){
        case 1: 
          return "Jan";
          break;
        case 2:
          return "Feb";
          break;
        case 3:
          return "Mar";
          break;
        case 4:
          return "Apr";
          break;
        case 5:
          return "Mei";
          break;
        case 6:
          return "Jun";
          break;
        case 7:
          return "Jul";
          break;
        case 8:
          return "Agst";
          break;
        case 9:
          return "Sept";
          break;
        case 10:
          return "Okt";
          break;
        case 11:
          return "Nov";
          break;
        case 12:
          return "Des";
          break;
    }
  }
 
  	function namaBulan($month){
      switch ($month){
        case 1: 
          return "Januari";
          break;
        case 2:
          return "Februari";
          break;
        case 3:
          return "Maret";
          break;
        case 4:
          return "April";
          break;
        case 5:
          return "Mei";
          break;
        case 6:
          return "Juni";
          break;
        case 7:
          return "Juli";
          break;
        case 8:
          return "Agustus";
          break;
        case 9:
          return "September";
          break;
        case 10:
          return "Oktober";
          break;
        case 11:
          return "November";
          break;
        case 12:
          return "Desember";
          break;
    }
  }

 
?>