<?php
session_start();

include ("../inc/helper.php");
include ("../inc/konfigurasi.php");
include ("../inc/db.pdo.class.php");

$db=new dB($dbsetting);
header('Content-Type: application/json');

if($_POST){
	switch ($_POST['act']) {
		case 'list':
			$jenis=$_POST['j'];
			$id_prodi=$_POST['prodi'];
			$iduser=$_POST['iduser'];
			if($jenis!=""){
				$p="";
				switch ($jenis) {
					case 'M':
						$p="SELECT tp.id,tp.judul,tp.tgl, 
						(SELECT count(id) FROM tmp_notif WHERE idkonten=tp.id AND iduser='".$iduser."' AND idProdi='".$id_prodi."' AND jenis='P' AND typeuser='M') as baca 
						FROM tbpengumuman tp WHERE tp.publish='Y' AND tp.idProdi = '$id_prodi'  AND tp.tujuan IN('A','M') ORDER BY tp.tgl DESC";
					break;
					
					case 'D':
					case 'K':
						$p="SELECT tp.id,tp.judul,tp.tgl, 
						(SELECT count(id) FROM tmp_notif WHERE idkonten=tp.id AND iduser='".$iduser."' AND idProdi='".$id_prodi."' AND jenis='P' AND typeuser='D') as baca 
						FROM tbpengumuman tp WHERE tp.publish='Y' AND tp.idProdi = '$id_prodi'  AND tp.tujuan IN('A','D') ORDER BY tp.tgl DESC";
					break;
				}

				$db->runQuery($p);
				if($db->dbRows()>0){
					$response=array();
					$response["data"] = array();
					while($r=$db->dbFetch()){
						$peng=array();
						$peng['id']=$r['id'];
						$peng['judul']=str_replace('"', '`', $r['judul']);
						$peng['tgl']=tanggalIndo($r['tgl'],'j F Y');
						$peng['baca']=$r['baca'];
						array_push($response["data"], $peng);
					}
					$response["success"] = "1";
					$response["msg"] = "Get List Pengumuman Success";
					echo json_encode($response);
				}else{
					$response["success"] = "0";
					$response["data"] = null;
					$response["msg"] = "Tidak Ada Pengumuman";
					echo json_encode($response);
				}
			}else{
				$response["success"] = "0";
				$response["data"] = null;
				$response["msg"] = "Request not found";
				echo json_encode($response);
			}
		break;

		case 'detail':
			$id_prodi=$_POST['prodi'];
			$id_pengumuman=$_POST['id'];
			$iduser=$_POST['iduser'];
			$jenis=$_POST['j'];

			$s="SELECT judul, isi, tgl FROM tbpengumuman WHERE idProdi='$id_prodi' AND publish='Y' AND id='$id_pengumuman' LIMIT 1";
			$db->runQuery($s);
			if($db->dbRows()>0){
				$r=$db->dbFetch();
				$response=array();
				$response["data"] = array();

				$detail['judul']=str_replace('"', '`', $r['judul']);
				$detail['isi']=str_replace('"', '`', $r['isi']);
				$detail['tgl']=tanggalIndo($r['tgl'],'j F Y');
					
				$response["success"] = "1";
				$response["msg"] = "Data Loaded";
				array_push($response["data"], $detail);
				
				$checknotif="SELECT COUNT(id) as jlh FROM tmp_notif WHERE idkonten='$id_pengumuman' AND idProdi='$id_prodi' AND iduser='$iduser' AND typeuser='$jenis' AND jenis='P'";
				$db->runQuery($checknotif);
				$r=$db->dbFetch();
				if($r['jlh']==0){
					$db->runQuery("INSERT INTO tmp_notif SET idkonten='$id_pengumuman', idProdi='$id_prodi',iduser='$iduser',typeuser='$jenis',jenis='P', `date`=NOW()");
				}

				echo json_encode($response);

			}else{
				$response["success"] = "0";
				$response["data"] = null;
				$response["msg"] = "Data Pengumuman Tidak Ditemukan";
				echo json_encode($response);
			}
		break;

		default:
			$response["success"] = "0";
			$response["data"] = null;
			$response["msg"] = "Request act not found";
			echo json_encode($response);
		break;
	}
	
}else{
	$response["success"] = "0";
	$response["data"] = null;
	$response["msg"] = "Request not found";
	echo json_encode($response);
}
?>