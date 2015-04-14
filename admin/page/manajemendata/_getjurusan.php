<?php
if($_POST){
	include ("../../../inc/helper.php");
	include ("../../../inc/konfigurasi.php");
	include ("../../../inc/db.pdo.class.php");

	$db=new dB($dbsetting);

	switch ($_POST['act']) {
		case 'getjur':
			$kodefak=$_POST['idFak'];
			$q="SELECT * FROM tbjurusan WHERE idFak='$kodefak'";
			$db->runQuery($q);
			if($db->dbRows()>0){
				echo '<option value="" selected >-Pilih Jurusan-</option>';
				while($r=$db->dbFetch()){
					echo '<option value="'.$r['idJur'].'">'.$r['nmJurusan'].'</option>';
				}
			}else{
				echo '<option value="" selected >-Data Jurusan Tidak Ada-</option>';
			}
		break;
	}
}
	
?>