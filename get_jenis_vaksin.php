					
					<option selected>[ None ]</option>
					<?php
						include './conf/openconn.php';
						$get = "select * from jenis_vaksin order by id_jenis ASC";
						$qry = mysql_query($get);
						while($data=mysql_fetch_array($qry))
						{
							$idjns = $data['id_jenis'];
							$nmjns = $data['nama'];
							echo "<option value='$idjns'>$nmjns</option>";
						}
						include './conf/closeconn.php';
					?>
