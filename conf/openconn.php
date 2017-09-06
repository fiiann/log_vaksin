<?php 
	$db_host="localhost";
	$db_username="root";
	$db_password="";
	$db_database="logistik_vaksin";

	$koneksi=mysqli_connect($db_host,$db_username,$db_password,$db_database);
	if (mysqli_connect_errno()){
		die("Could not connect to the database: <br />".
			mysqli_connect_error());
	}
?>