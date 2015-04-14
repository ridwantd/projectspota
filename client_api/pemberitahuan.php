<?php
session_start();

include ("../inc/helper.php");
include ("../inc/konfigurasi.php");
include ("../inc/db.pdo.class.php");


$db=new dB($dbsetting);
header('Content-Type: application/json');
if($_POST){
	if($_POST['jenis_user']=="M"){
		$jenis="M";
	}else if ($_POST['jenis_user']=="D" OR $_POST['jenis_user']=="K"){
		$jenis="D";
	}else{
		$jenis="A";
	}

	$prodi=$_POST['prodi'];
	$user=$_POST['user'];
	$q="SELECT tnr.* 
		FROM tmp_notif_r tnr 
		LEFT JOIN tbpraoutline tp ON(tp.id=tnr.idkonten) 
		WHERE tnr.read = 'N' 
		AND tnr.jns_usr = '".$jenis."'
		AND tnr.user = '".$user."'
		AND tnr.idProdi = '".$prodi."'";
	$db->runQuery($q);
	if($db->dbRows()>0){
		
		$response=array();
		$response["data"]=array();
		while($p=$db->dbFetch()){
			$draft=array();
			$draft['idkonten']=$p['idkonten'];
			$draft['tgl']=tanggalIndo($p['tgl'],'j F Y H:i:s');
			$draft['pesan']=$p['msg'];
			$draft['read']=$p['read'];
			array_push($response["data"], $draft);
		}

		$response["success"] = "1";
		$response["msg"] = "Sukses";
		
		echo json_encode($response);
	}else{
		$response["success"] = "1";
		$response["data"] = null;
		$response["msg"] = "Tidak Ada Pemberitahuan Terbaru";
		echo json_encode($response);
	}

}else{
	$response["success"] = "0";
	$response["data"] = null;
	$response["msg"] = "Request not found";
	echo json_encode($response);
}