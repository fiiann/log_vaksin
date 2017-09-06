<?php
	session_start(); 
 
	$password=$_POST['password'];
	$username=$_POST["username"];

    $user=base64_encode($username);
	$pass=base64_encode($password);

	if(!empty($user) && !empty($pass))
	{
	 
		include_once "conf/openconn.php";
		$sql="SELECT * FROM instansi WHERE username = '$user' AND password = '$pass'";
		$result=mysqli_query($koneksi, $sql);
		$count=mysqli_num_rows($result);
		if($count==1)
		{
			$_SESSION['username']=$user; 
			$_SESSION['password']=$pass;
	 

			while($r=mysqli_fetch_array($result)){
				$idinst= $r['kode_instansi'];
			}
			$_SESSION['kode_instansi']=$idinst;
			$u=base64_encode($idinst);
		//	login_validate();						//setel waktu. jika halaman lebih dari 5 menit tidak digunakan, maka akan logout otomatis
			header("Location:main.php?u=$u");
			 
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