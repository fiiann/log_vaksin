<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>--Logistik Vaksin Aceh Barat--</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row text-center">
            <h3>Sistem Puskesmas</h3>
        </div>
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="account-wall">
                <img class="profile-img" src="./images/logo-abar.jpg"
                    alt="">
                <form class="form-signin" method="post" action="ceklogin.php">
                <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Log in</button>            
                </form>
            </div>
           
        </div>
   
</div>
 
</body>
<?php 
	if ($_GET['act'] == 1)
	{
		echo "<div align='center' style='padding:50px 0 0 0'><font color=red><b>Usernameeeee Tidak Terdaftar dalam Sistem..!</b></font></div><br />";
	}
	if ($_GET['act'] == 2)
	{
		echo "<div align='center' style='padding:50px 0 0 0'><font color=red><b>Error..Cek Kembali Username/Password !</b></font></div><br />";
	}
	if ($_GET['act'] == 4)
	{
		echo "<div align='center' style='padding:50px 0 0 0'><font color=red><b>Anda telah meninggalkan aplikasi selama lebih dari 5 menit<br />Untuk keamanan, silahkan login kembali</b></font></div><br/>";
	}
 
?>
</html>