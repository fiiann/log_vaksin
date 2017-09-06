<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Data Stok Vaksin</title>

<script src="../js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet"/>

<style>
body {
	background-color:#ccc;
	font-family:Tahoma;
	font-size:13px;
}
.listobat tr.baris:hover {background:#8DE68A;cursor:pointer}
.atas {
	 font-weight:bold;
	 color:white;
	 }
</style>
</head>
<body>
	<div id="listview_container">
	<?php
	include "../../conf/openconn.php";
	include "../../lib/functions-php.php";


?>
<div id="periode" style="float:left;padding:2px 5px">&nbsp; Bulan

    <select name="bulan" id="bulan">
      <?php
        $month = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
      for($y=1;$y<=12;$y++){
        if($y==date("m")){ $pilih="selected";}
        else {$pilih="";}
        echo("<option value=\"$y\" $pilih>$month[$y]</option>"."\n");
              }
       ?>
    </select>



    <div id='button' style='padding-left:450px'><input type="button" name="inputcakupan" id="inputcakupan" value="Input Cakupan"></div>
    <br>
<table class='liststok' id="liststok" width="70%" cellpadding="2" cellspacing="2" style='padding:0 10px 20px 10px'>
<tr>
  <td>
  <?php if ($noPage <= 1)
        {
        //  echo $nomor++."<br>";
        }
        else
        {
         // echo $nomor1=$nomor1+1 ."<br>";
        } ?>
  </td>
</tr>
<tr class='atas' bgcolor="#80857D">
  <td width="4%">No.</td>
  <td width="20%" style='text-align:center'>Jenis Vaksin</td>
  <td align="center" width="15%">Jml Cakupan</td>
  <td width="10%" align='center'>Tool</td>
</tr>

<?php
if ($_POST['bulan'] || $_POST['tahun']){
  $getdatastok = "SELECT * from data_cakupan where bulan='".$bulan."' and tahun='".$tahun."' ORDER BY id_jenis ASC LIMIT $offset, $dataPerPage";
  $qrydatastok = mysqli_query($koneksi,$getdatastok);

}else{
  $getdatastok = "SELECT * from data_cakupan where bulan='".$xbulan."' and tahun='".$xtahun."' ORDER BY id_jenis ASC LIMIT $offset, $dataPerPage";
  $qrydatastok = mysqli_query($koneksi,$getdatastok);
}
while ($print=mysqli_fetch_array($qrydatastok))
{
  $nomer++;
  $idx          =$print['idx'];
  $id_jenis     =$print['id_jenis'];
        $jumlah       =$print['jumlah'];

        $getnama = "SELECT nama from jenis_vaksin where id_jenis='".$id_jenis."'";
        $query   = mysqli_query($koneksi,$getnama);
        while($nm=mysqli_fetch_array($query)){
            $nama = $nm['nama'];

        }


?>
<tr class='baris' bgcolor='#eee' id='stokvaksin_<?php echo $idx;?>'>
   <td align="right"><?php echo $nomer;?>.</td>
   <td><?php echo $nama;?></td>
   <td align="center"><?php echo $jumlah;?></td>

   <td  align='center'>
    <input type='button' name='edit' class="edit_ckp" id="<?php echo $idx;?>" value='E'>
    <input type='button' name='del' class="hapus_ckp" id="<?php echo $idx;?>" data-stok="<?php echo $jumlah;?>" value='X'>
   </td>
  </tr>
<?php }	?>

</table>
<div id="confirm"></div>
<?php


  // Mencari jumlah semua data tabel 'alamat', kemudian simpan dalam variabel $jumData
    $query3   = "SELECT COUNT(*) AS jumData FROM data_cakupan";
    $hasil3  = mysqli_query($koneksi,$query3);
    $data3    = mysqli_fetch_array($hasil3);

    $jumData = $data3['jumData'];
    echo "<br><center>";
      if ($jumData > 10)
        {

          // Menentukan jumlah halaman yang muncul berdasarkan jumlah semua data
          $jumPage = ceil($jumData/$dataPerPage);

          // Menampilkan link 'Sebelum'
          if ($noPage > 10)
          {
          $query = "SELECT * FROM data_cakupan";
          $result = mysqli_query($koneksi,$query) or die('Error');

          $data = mysqli_fetch_array($result);

        //  echo  "<a href='".$_SERVER['PHP_SELF']."?page=".($noPage-1)."'><< Back</a>";
           }
          // Menampilkan nomor halaman dan linknya
          for($page = 1; $page <= $jumPage; $page++)
          {

            if ((($page >= $noPage - 10) && ($page <= $noPage + 10)) || ($page == 1) || ($page == $jumPage))
            {

              if (($showPage == 1) && ($page != 10))  echo "<a href='#'></a>";
           //   if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  echo "<a href='#'>...</a>";
              if ($page == $noPage) echo "<a href='#' style='text-decoration:none;padding:2px 4px 2px 4px;background-color:#000;color:white;font-weight:bold'>".$page."</a>";
              else echo " <a href='".$_SERVER['PHP_SELF']."?page=".$page."' style='text-decoration:none'>".$page."</a> ";
              $showPage = $page;
            }
          }

          // Menampilkan link 'Sesudah'
       /*   if ($noPage < $jumPage)
          echo "<a href='".$_SERVER['PHP_SELF']."?page=".($noPage+1)."'>Next >></a>";*/
        }

      else
        {
        }

    echo "</center>";
?>
<div id="delconfirm"></div>
<div id="stokbox">
  <div id="formstok"></div>
</div>
</div>

	</div>
	</body>
</html>
