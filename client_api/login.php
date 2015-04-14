<?php
session_start();

include ("../inc/helper.php");
include ("../inc/konfigurasi.php");
include ("../inc/db.pdo.class.php");


$db=new dB($dbsetting);
header('Content-Type: application/json');
if($_POST){
	$user=$_POST['u'];
	$password=$_POST['p'];
	$jenis_user="";
	$regid=$_POST['regid'];
	if(substr($user, 0,1)=='D'){
		$jenis_user="MHS";
		$qu="SELECT * FROM tbmhs WHERE nim='$user' LIMIT 1";
	}else{
		$jenis_user="DOSEN";
		$qu="SELECT * FROM tbdosen WHERE nip='$user' LIMIT 1";
	}

	//$qu="SELECT * FROM tbadmin WHERE username='$user' LIMIT 1";
	$db->runQuery($qu);
	if($db->dbRows()>0){
		$r=$db->dbFetch();
		$dbpass=$r['password'];
		$response=array();
		$response["login"] = array();
		if($r['status']=='A'){
			if($dbpass==md5($password)){
				if($jenis_user=="MHS"){
					$detail['nama_lengkap']=$r['nmLengkap'];
					$detail['id_user']=$r['idmhs'];
					$detail['id_prodi']=$r['idProdi'];
					$detail['username']=$r['nim'];
					$detail['email']=$r['email'];
					$detail['jenis']="M";

					$gcm_reg="REPLACE INTO gcm_service SET 
					iduser='".$r['nim']."',
					jenisuser='M',
					regid='".$regid."',
					aktif='Y'";

				}else{
					$detail['nama_lengkap']=$r['nmLengkap'];
					$detail['id_user']=$r['iddosen'];
					$detail['id_prodi']=$r['idProdi'];
					$detail['username']=$r['nip'];
					$detail['email']=$r['email'];
					$detail['jenis']=$r['jenis'];

					$gcm_reg="REPLACE INTO gcm_service SET 
					iduser='".$r['nip']."',
					jenisuser='".$r['jenis']."',
					regid='".$regid."',
					aktif='Y'";
				}
				//comingsoon
				$db->runQuery($gcm_reg);
				
				$response["success"] = "1";
				$response["msg"] = "Login Sukses";
				array_push($response["login"], $detail);
				echo json_encode($response);
			}else{
				$response["success"] = "0";
				$response["login"] = null;
				$response["msg"] = "Password Salah";
				echo json_encode($response);
			}
		}else{
			$response["success"] = "0";
			$response["login"] = null;
			$response["msg"] = "Akun anda tidak aktif";
			echo json_encode($response);
		}
	}else{
			$response["success"] = "0";
			$response["login"] = null;
			$response["msg"] = "Anda Tidak Terdaftar";
			echo json_encode($response);
	}
}else{
	$response["success"] = "0";
	$response["data"] = null;
	$response["msg"] = "Request not found";
	echo json_encode($response);
}

?>