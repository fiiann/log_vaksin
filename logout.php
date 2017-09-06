<?php
 	session_start(); 
	
	unset($_SESSION['username']); 
	unset($_SESSION['password']);
	unset($_SESSION['id']);
		
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