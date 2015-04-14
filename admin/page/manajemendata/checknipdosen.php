<?php
session_start();
include ("../../../inc/helper.php");
include ("../../../inc/konfigurasi.php");
include ("../../../inc/db.pdo.class.php");

$db=new dB($dbsetting);
if($_POST['nip_dosen']){
		$db->runQuery("SELECT iddosen FROM tbdosen WHERE nip='".$_POST['nip_dosen']."' LIMIT 1");
		if($db->dbRows()>0){
			echo "false";
		}else{
			echo "true";
		}
	}
?>