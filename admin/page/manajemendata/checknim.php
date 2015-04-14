<?php
session_start();
include ("../../../inc/helper.php");
include ("../../../inc/konfigurasi.php");
include ("../../../inc/db.pdo.class.php");

$db=new dB($dbsetting);
if($_POST['nim']){
		$db->runQuery("SELECT idmhs FROM tbmhs WHERE nim='".$_POST['nim']."' LIMIT 1");
		if($db->dbRows()>0){
			echo "false";
		}else{
			echo "true";
		}
	}
?>