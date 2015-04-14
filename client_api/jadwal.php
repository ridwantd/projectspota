<?php
session_start();

include ("../inc/helper.php");
include ("../inc/konfigurasi.php");
include ("../inc/db.pdo.class.php");


$db=new dB($dbsetting);

if($_POST){

}else{
	$response["success"] = "0";
	$response["data_jadwal"] = null;
	$response["msg"] = "Request not found";
	echo json_encode($response);
}

?>