<?php
	include "../../conf/openconn.php";
	include "../../lib/functions-php.php"; 	
	
	$idjenis	= $_POST['idjenis'];
	$idproses	= $_POST['idproses'];

    //get detil data 
    $get = "SELECT  a.id_jenis
                   ,a.kode_batch 
                   ,a.jumlah 
                   ,j.nama 
            FROM amprah_approval_detil a 
            inner join jenis_vaksin j 
             on a.id_jenis=j.id_jenis
            where a.id_jenis='".$idjenis."' and a.id_proses='".$idproses."'";
    $que = mysql_query($get); 
    
    ?>


    <table class='list' width="100%" cellspacing="2" cellpadding="2" style='padding-left:10px;'>
		<tr class='top' bgcolor="#80B302" width="60%">
			<td width="4%" align="center"><b>No.</b></td>
            <td width="20%" align="center"><b>Kode Batch</b></td>    
			<td width="15%" align="center"><b>Vaksin</b></td>
            <td width="10%" align="center"><b>Jml Dipenuhi</b></td>
		</tr>

<?php
    while ($data=mysql_fetch_array($que))
    {
        $no++;
        $kode = $data['kode_batch'];
        $nama = $data['nama'];
        $jml  = $data['jumlah'];

        ?>

	    <tr background='#fff'>
			<td width="4%" align="center"><b><?php echo $no;?></b></td>
			<td width="30%" align="center"><b><?php echo $kode;?></b></td>
			<td width="10%" align="center"><b><?php echo $nama;?></b></td>
            <td width="10%" align="center"><b><?php echo $jml;?></b></td>
		</tr>

   <?php }        

   ?>
   </table>