<?php
	session_start(); 
	require_once ("session_exp.php");
	$admin_pass=$_POST['password'];
	$admin_user=$_POST["username"];

	//$paswd	= md5($admin_pass);
	if(!empty($admin_user) && !empty($admin_pass))
	{
		include_once "../conf/openconn.php";

		
		$sql="SELECT * FROM administrator WHERE username='$admin_user' AND password='$admin_pass'";
		$result=mysqli_query($koneksi, $sql);
	
		$count=mysqli_num_rows($result);


		if($count==1)
		{
			$_SESSION['admin_username']=$admin_user; 
			$_SESSION['admin_password']=$admin_pass;
			while($r=mysqli_fetch_array($result)){
				$idpkm= $r['idx'];
			}
			$_SESSION['id_admin']=$idpkm;
			$u=sha1($idpkm);
			login_validate();						//setel waktu. jika halaman lebih dari 5 menit tidak digunakan, maka akan logout otomatis
			header("Location:adminpage.php?u=$u");
		}
		else 
		{				
			header("Location:login.php?act=1");		//jika data tidak ditemukan
		}
	}
	else
	{
	        header("Location:login.php?act=2");			// jika field tidak diisi
	}
?>