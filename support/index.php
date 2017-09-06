<?php
//---------- OTENTIKASI -------------------
session_start();
$admin_pass 	= $_SESSION['admin_password'];
$admin_user		= $_SESSION['admin_username'];
echo $admin_pass;

if(!empty($_SESSION['admin_username']) && !empty($_SESSION['admin_password']))
{
include_once "../librari/inc.koneksi.php";
		$cek="SELECT * FROM user WHERE username='$admin_user' AND password='$admin_pass'";
		$result=mysql_query($cek);
	
		$hasil=mysql_num_rows($result);

	if (empty($hasil))
	{
		header("location:login.php");
		exit;
	}
	else
	{
		header("location:adminpage.php");
		exit;
	}
}
else
{
	header("location:login.php");
	exit;
}
//------------------------------------------
?>