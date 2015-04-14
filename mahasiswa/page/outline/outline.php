<?php

/*$cek="SELECT id FROM tbrekaphasil WHERE nim='".$_SESSION['login-mhs']['nim']."' AND kep_akhir='1' LIMIT 1";
$db->runQuery($cek);
if($db->dbRows()>0){*/
	switch ($_GET['menu']) {		
		case 'diskusi':
			include "diskusi.php";
		break;

		case 'list':
			include "list.php";
		break;
		
		case 'review':
			include "review.php";
		break;
		
		case 'new':
			include "new.php";
		break;

		case 'jadwal_outline':
			include "jadwal_outline.php";
		break;
		
		case 'jadwal_sidang':
			include "jadwal_sidang.php";
		break;
		
		default:
			echo "<script>location.href='".MHS_PAGE."dashboard.php'</script>";
		break;
	}
/*}else{
	echo "<div class='alert alert-danger'>Anda Belum Dapat Mengajukan Diskusi Tugas Akhir</div>";
}*/
?>