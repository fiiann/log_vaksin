<?php
    include "../../librari/inc.koneksi.php";

	if ($_POST['idorder']!='')
	{	
		$idtrx			= $_POST['idorder'];
		$kodevaksin		= $_POST['kodevaksin'];
		$jmlstok		= $_POST['jmlstok'];
		$jmlorder	    = $_POST['jmlorder'];	
		$is_order		= $_POST['is_order'];
		$satuan			= $_POST['satuan'];
		 
		$kode_o	 = explode(",",$kodevaksin);
		$stok_o	 = explode(",",$jmlstok);
		$order_o = explode(",",$jmlorder);
		$sat	 = explode(",",$satuan);
		
		$jml = count($kode_o);
		
		for ($i=0;$i<$jml;$i++)
		{
			$print_kode  =$kode_o[$i];
			$print_stok  =$stok_o[$i];
			$print_order =$order_o[$i];
			$print_sat	 =$sat[$i];
 		
			$temp ="insert into trxterima_detil (idterima, kode_vaksin, jml_stok, jml_order, satuan) VALUES ('".$idtrx."','".$print_kode."','".$print_stok."','".$print_order."','".$print_sat."')"; 
			
			$qtemp=mysql_query($temp);	
		
			 
				$hasil     = $print_stok+$print_order;	
				
				//update stok temp pada tabel master_obat 
				$updatestok = "update master_vaksin SET jml_stok='".$hasil."' where kode_vaksin='".$print_kode."'";
				$qryupdate	= mysql_query($updatestok);
		}
	
		//cek table 
	
		$tabel_cek 		="select idterima from trxterima where idterima='".$idorder."'";
		$tabel_query	= mysql_query($tabel_cek);
		$data_found		= mysql_num_rows($tabel_query);
		if ($data_found!=0){	 
			return true;
			}
			else
			{	
				$add_sql="insert into trxterima (idterima) VALUES ('".$idtrx."')";	
				$add_result = mysql_query($add_sql);
			}
		
	}
	 
?>