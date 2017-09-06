<html>
 <head><title></title></head>
<style>
.menu_simple ul {
    margin: 0;
    padding: 0;
    width:170px;
    list-style-type: none;

}

.menu_simple ul li a {
    text-decoration: none;
	font-family:Tahoma;
    color: white;
	font-size:11px;
    padding: 7.5px 8px;
    background-color: #005555;
    display:block;
}

.menu_simple ul li a:visited {
    color: white;
}

.menu_simple ul li a:hover, .menu_simple ul li .current {
    color: white;
    background-color: #5FD367;
	font-family:Tahoma;
}
#head {


	font-family:Arial


}
</style>
<body bgcolor='#ccc'>
<span id='text' style='font-family:Tahoma;font-size:15px;font-weight:bold;color:white;'>Administrator Menu</span>
<div class="menu_simple">
  <ul>
    <li><a title="Home" href="content.php" target="konten">Depan</a></li><br>
	<li><span id="head">Master Data</span>
	<ul>
	    <li><a title="Cakupan Wilayah" href="cakupan/listview_cakupan1.php" target="konten">&nbsp;&nbsp;Data Cakupan Wilayah</a></li>	
		<li><a title="Master Vaksin" href="vaksin/listview_vaksin.php" target="konten">&nbsp;&nbsp;Data Vaksin</a></li>
		<li><a title="Jenis Vaksin" href="vaksin/listview_jenisvaksin.php" target="konten">&nbsp;&nbsp;Data Jenis Vaksin</a></li>
		<li><a title="Satuan Vaksin" href="vaksin/listview_satuan.php" target="konten">&nbsp;&nbsp;Data Satuan</a></li>
		<li><a title="Data Instansi" href="instansi/listview_instansi.php" target="konten">&nbsp;&nbsp;Data Instansi</a></li>
		<li><a title="Stok Vaksin" href="vaksin/listview_stokvaksin.php" target="konten">&nbsp;&nbsp;Stok Vaksin</a></li>
		<li><a title="Data Vaksin Expired" href="vaksin/listview_expvaksin.php" target="konten">&nbsp;&nbsp;Data Vaksin Expired</a></li>
	</ul>
	</li>
	<br>
	<li><span id="head">Transaksi Vaksin </span>
		<ul>
			<li><a title="Data Amprahan" href="transaksi/listtrx_pkm.php" target="konten">&nbsp;&nbsp;Amprahan Puskesmas</a></li>
			   <li><a title="Data Pemakaian Vaksin Instansi" href="transaksi/listview_pakai.php" target="konten">&nbsp;&nbsp;Data Pemakaian Instansi</a></li></ul>
	</li><br>
	<br>
	<li><span id="head">Laporan</span>
		<ul>
			<li><a title="Laporan Pengiriman Vaksin" href="report/report_kirim.php" target="konten">&nbsp;&nbsp;Pengiriman Vaksin</a></li>
			<li><a title="Laporan Pemakaian Vaksin" href="report/report_pkm.php" target="konten">&nbsp;&nbsp;Pemakaian Vaksin</a></li>
			<li><a title="Laporan Monitoring" href="report/report_monitoring.php" target="konten">&nbsp;&nbsp;Monitoring Vaksin</a></li>

		</ul>
	</li><br>
	<li><a title="Logout" href="logout.php" target="_top">Keluar</a></li>
  </ul>
</div>
