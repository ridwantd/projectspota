<?php
session_start();
if($_POST){
	include ("../../../inc/helper.php");
	include ("../../../inc/konfigurasi.php");
	include ("../../../inc/db.pdo.class.php");

	$db=new dB($dbsetting);

	switch($_POST['act']){
		default:
			echo json_encode(array("result"=>false,"msg"=>"Request Not Found"));
		break;

		case 'simpan':
			$idprodi=$_SESSION['login-admin']['prodi'];
			$semester=$_POST['smt'];
			$thnajaran=$_POST['thn_ajaran'];
			$minsetuju=$_POST['min_setuju'];

			$c="SELECT * FROM web_setting WHERE idProdi='$idprodi'";
			$db->runQuery($c);
			if($db->dbRows()>0){
				$p="UPDATE web_setting SET `values`='$semester' WHERE name='smt' AND idProdi='$idprodi';";
				$q="UPDATE web_setting SET `values`='$thnajaran' WHERE name='thn_ajaran' AND idProdi='$idprodi';";
				$r="UPDATE web_setting SET `values`='$minsetuju' WHERE name='min_close' AND idProdi='$idprodi';";
			}else{
				$p="INSERT INTO web_setting SET `values`='$semester', name='smt', idProdi='$idprodi';";
				$q="INSERT INTO web_setting SET `values`='$thnajaran', name='thn_ajaran', idProdi='$idprodi';";
				$r="INSERT INTO web_setting SET `values`='$minsetuju', name='min_close', idProdi='$idprodi';";
			}
			
			/*echo $p;
			echo $q;
			echo $r;*/
			if($db->runQuery($p) AND $db->runQuery($q) AND $db->runQuery($r)){
				echo json_encode(array("result"=>true,"msg"=>"Pengaturan Disimpan"));
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Aksi Gagal, DBError"));
			}
		break;
	}
}
?>