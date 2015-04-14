<?php
session_start();

include ("../inc/helper.php");
include ("../inc/konfigurasi.php");
include ("../inc/db.pdo.class.php");


$db=new dB($dbsetting);
header('Content-Type: application/json');

if($_POST){
	$regid=$_POST['regid'];
	if($regid!=""){
		$q="DELETE FROM gcm_service WHERE regid='$regid'";
		if($db->runQuery($q)){
			$response["success"] = "1";
			$response["data"] = null;
			$response["msg"] = "Logout Berhasil";
			echo json_encode($response);
		}else{
			$response["success"] = "0";
			$response["data"] = null;
			$response["msg"] = "Logout Gagal";
			echo json_encode($response);
			}
	}else{
		$response["success"] = "0";
		$response["data"] = null;
		$response["msg"] = "Registration id not Found";
		echo json_encode($response);
	}
}else{
	$response["success"] = "0";
	$response["data"] = null;
	$response["msg"] = "Request not found";
	echo json_encode($response);
}