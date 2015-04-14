<?php
session_start();
include ("../../../inc/helper.php");
include ("../../../inc/konfigurasi.php");
include ("../../../inc/db.pdo.class.php");

$db=new dB($dbsetting);
if($_POST['idFak']){
		$db->runQuery("SELECT idFak FROM tbfakultas WHERE idFak='".$_POST['idFak']."' LIMIT 1");
		if($db->dbRows()>0){
			echo "false";
		}else{
			echo "true";
		}
	}
?>