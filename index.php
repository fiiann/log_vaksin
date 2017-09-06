<?php
//---------- OTENTIKASI -------------------
session_start();
$password 	= $_SESSION['password'];
$username	= $_SESSION['username'];

//$paswd	= base64_encode($password);
if(!empty($_SESSION['username']) && !empty($_SESSION['password']))
{
include_once "./conf/openconn.php";
		$cek="SELECT * FROM instansi WHERE username='$username' AND password='$password'";
		$result=mysql_query($cek);
		$hasil=mysql_num_rows($result);

	if (empty($hasil))
	{
		header("location:login.php");
		exit;
	}
	else
	{
		 
		$id = $_SESSION['id'];
		header("location:main.php?t=$id");
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