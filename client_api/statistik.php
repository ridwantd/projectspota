<?php
session_start();

include ("../inc/helper.php");
include ("../inc/gcm_helper.php");
include ("../inc/konfigurasi.php");
include ("../inc/db.pdo.class.php");


$db=new dB($dbsetting);
header('Content-Type: application/json');
if($_POST){
	switch ($_POST['act']) {
		case 'praoutline':
			$prodi=$_POST['idprodi'];
			$smt=$_POST['smt'];

			if($smt!=""){
				$filtersmt="AND tp.semester='".$smt."' ";
			}else{
				$filtersmt="AND tp.semester= (SELECT `values` FROM web_setting WHERE `name`='smt' AND idProdi='".$prodi."') ";
			}
			$qs="SELECT
				tp.semester, 
				COUNT(if(tp.status_usulan='1',1,null)) as terima,
				COUNT(if(tp.status_usulan='2',1,null)) as tolak,
				COUNT(if(tp.status_usulan='3',1,null)) as gugur,
				COUNT(if(tp.status_usulan='0',1,null)) as proses,
				COUNT(tp.semester) as totaldraft
			FROM tbpraoutline tp
			WHERE tp.idProdi='$prodi' $filtersmt
			GROUP BY tp.semester";

			//echo $qs;
			$db->runQuery($qs);
			if($db->dbRows()>0){
				$r=$db->dbFetch();
				$response=array();
				$response["data"]=array();

				$stat['smt']=$r['semester'];
				$stat['jlhterima']=$r['terima'];
				$stat['jlhtolak']=$r['tolak'];
				$stat['jlhgugur']=$r['gugur'];
				$stat['jlhproses']=$r['proses'];


				$response["success"] = "1";
				$response["msg"] = "Statistik Draft Praoutline Berdasarkan Tgl Pengajuan Per Semester";
				array_push($response["data"], $stat);
				echo json_encode($response);
			}else{
				$response=array();
				$response["data"]=array();

				$stat['smt']=$smt;
				$stat['jlhterima']=0;
				$stat['jlhtolak']=0;
				$stat['jlhgugur']=0;
				$stat['jlhproses']=0;


				$response["success"] = "1";
				$response["msg"] = "Statistik Draft Praoutline Berdasarkan Tgl Pengajuan Per Semester";
				array_push($response["data"], $stat);
				echo json_encode($response);
			}

		break;

		case 'dosen':
			$nip=$_POST['nip'];
			$prodi=$_POST['idprodi'];
			$smt=$_POST['smt'];

			if($smt!=""){
				$filtersmt="AND trh.semester='".$smt."' ";
			}else{
				$filtersmt="AND trh.semester= (SELECT `values` FROM web_setting WHERE `name`='smt' AND idProdi='".$prodi."') ";
			}

			$q="SELECT td.nmLengkap,trh.semester,COUNT(if(trh.pemb1=td.nip,1,null)) as pemb1,
				COUNT(if(trh.pemb2=td.nip,1,null)) as pemb2,
				COUNT(if(trh.peng1=td.nip,1,null)) as peng1,
				COUNT(if(trh.peng2=td.nip,1,null)) as peng2
			FROM tbrekaphasil trh,tbdosen td 
			WHERE td.nip='".$nip."' $filtersmt AND td.idProdi='".$prodi."'
			GROUP BY td.nip";

			//echo $q;
			$db->runQuery($q);
			if($db->dbRows()>0){
				$r=$db->dbFetch();
				$response=array();
				$response["data"]=array();

				$stat['nip']=$nip;
				$stat['smt']=$r['semester'];
				$stat['pemb1']=$r['pemb1'];
				$stat['pemb2']=$r['pemb2'];
				$stat['peng1']=$r['peng1'];
				$stat['peng2']=$r['peng2'];


				$response["success"] = "1";
				$response["msg"] = "Statistik Dosen Per Semester";
				array_push($response["data"], $stat);
				echo json_encode($response);
			}else{
				$response=array();
				$response["data"]=array();

				$stat['nip']=$nip;
				$stat['smt']=$smt;
				$stat['pemb1']=0;
				$stat['pemb2']=0;
				$stat['peng1']=0;
				$stat['peng2']=0;

				$response["success"] = "1";
				$response["msg"] = "Sukses";
				array_push($response["data"], $stat);
				echo json_encode($response);
			}
		break;

		case 'listsmt':
			$prodi=$_POST['idprodi'];
			$q="SELECT DISTINCT(semester) as smt FROM tbpraoutline
			WHERE idProdi='$prodi' ORDER BY semester DESC";
			$db->runQuery($q);
			if($db->dbRows()>0){
				$response=array();
				$response["data"]=array();
				while($s=$db->dbFetch()){
					$smt['smt']=$s['smt'];

					array_push($response["data"], $smt);
				}

				$response["success"] = "1";
				$response["msg"] = "Data found";
				echo json_encode($response);
			}else{
				$response["success"] = "0";
				$response["data"] = null;
				$response["msg"] = "Data not found";
				echo json_encode($response);
			}
		break;
		
		default:
			$response["success"] = "0";
			$response["data"] = null;
			$response["msg"] = "Request not found";
			echo json_encode($response);
		break;
	}
}else{
	$response["success"] = "0";
	$response["data"] = null;
	$response["msg"] = "Request not found";
	echo json_encode($response);
}