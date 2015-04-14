<?php
session_start();
include ("../../../inc/helper.php");
include ("../../../inc/konfigurasi.php");
include ("../../../inc/db.pdo.class.php");

$db=new dB($dbsetting);
if($_POST['username']){
		$db->runQuery("SELECT idAdmin FROM tbadmin WHERE username='".$_POST['username']."' LIMIT 1");
		if($db->dbRows()>0){
			echo "false";
		}else{
			echo "true";
		}
	}
?>