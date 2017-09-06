<html>
<head>
 <link href="../css/login.css" rel="stylesheet" type="text/css">	
 <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">	
 
</head>
<title>Administrator Login - DKK</title>
<body>
<br />
<?php 
	if ($_GET['act'] == 1)
	{
		echo "<div align='center'><font color=red>Data yang diisi tidak ditemukan. Mohon isi dengan data yang sesuai !</font></div><br />";
	}
	if ($_GET['act'] == 2)
	{
		echo "<div align='center'><font color=red>Error..Cek Kembali Username/Password !</font></div><br />";
	}
	if ($_GET['act'] == 3)
	{
		echo "<div align='center'><font color=red>Captcha Salah !Perhatikan Besar Kecil Huruf..!</font></div><br />";
	}
	if ($_GET['act'] == 4)
	{
		echo "<div align='center'><font color=red>Anda telah meninggalkan aplikasi selama lebih dari 5 menit<br />Untuk keamanan, silahkan login kembali</font></div><br/>";
	}
?>
 
 <div class="container">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="account-wall">
                <img class="profile-img" src="../images/logo-abar.jpg"
                    alt="">
                <form class="form-signin" method="post" action="cek_login.php">
                <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Log in</button>
                
                <a href="mailto:admin@logvaksin-abar.com" class="pull-right need-help">Butuh Bantuan? </a><span class="clearfix"></span>
                </form>
            </div>
           
        </div>
   
</div>
</body>
</html>


