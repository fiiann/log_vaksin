<?php
 	session_start(); 
	unset($_SESSION['admin_username']); 
	unset($_SESSION['admin_password']);
	unset($_SESSION['id_admin']);
	session_destroy();
	if($_GET['exp'] == 1)
	{ 
		header("Location: login.php?act=4");
	}
	else
	{ 
		header("Location: login.php");
	}
?>