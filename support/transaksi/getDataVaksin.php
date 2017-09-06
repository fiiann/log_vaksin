<?php
 include_once "../../conf/openconn.php";
 include_once "../../lib/functions-php.php";  


 $term=$_GET["term"];
 $idjenis = $_GET['idjenis'];
 $tgl_skr = date('Y-m-d');

 	   $getdata = "Select m.kode_batch
                               ,m.id_jenis
							   ,m.stok 
							   ,m.tgl_expired 
							   ,m.vvm
							   ,j.nama 
						from master_vaksin m 
						inner join jenis_vaksin j 
						 on m.id_jenis=j.id_jenis 
						WHERE m.kode_batch like '%".$term."%' and m.id_jenis='".$idjenis."' and m.vvm!='C' and (m.vvm!='D') and m.stok>0 order by m.kode_batch LIMIT 5";
		$query = mysql_query($getdata);


 

 $json=array();
    while($ur=mysql_fetch_array($query)){				
        $json[]=array(
					'label'=>$ur["kode_batch"],
                   	'kode_batch'=>$ur["kode_batch"],
                    'stok'=>$ur["stok"],
					'expired'=>tgl_eng_to_ind($ur["tgl_expired"])
                    );
    }

 echo json_encode($json); 
 include_once "../conf/closeconn.php";
?>