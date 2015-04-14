<?php
session_start();
$idprodi=$_SESSION['login-admin']['prodi'];
include ("../../../inc/helper.php");
include ("../../../inc/konfigurasi.php");
include ("../../../inc/db.pdo.class.php");

$db=new dB($dbsetting);
$s="SELECT tj.*,tm.nim 
	FROM tbjadwal tj 
		LEFT JOIN tbmhs tm 
		ON (tm.idmhs=tj.idmhs) 
	WHERE tj.publish='Y' AND tj.idProdi='$idprodi'";
//echo $s;
$db->runQuery($s);
if($db->dbRows()>0){
	while($r=$db->dbFetch()){
		if($r['jenis']=="Sidang"){
			$warna="label-orange";
		}else if($r['jenis']=="Outline"){
			$warna="label-green";
		}else{
			$warna="label-default";
		}
		$data['id']=$r['id'];
		$data['title']=$r['nim'];
		$data['start']=$r['start'];
		$data['end']=$r['end'];
		$data['className']=$warna;
		$jadwal[]=$data;
	}
	echo json_encode($jadwal);
}
?>