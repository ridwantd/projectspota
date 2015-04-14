<?php
session_start();

include ("../inc/helper.php");
include ("../inc/konfigurasi.php");
include ("../inc/db.pdo.class.php");


$db=new dB($dbsetting);
if($_POST){

	switch ($_POST['act']) {
		case 'login':
			
			$username=$_POST['username'];
			$password=$_POST['password'];
			
			$check="SELECT tm.nim,tm.idmhs,tm.password,tm.nmLengkap,tm.idProdi,tp.nmProdi,tm.status FROM tbmhs tm LEFT JOIN tbprodi tp ON (tm.idProdi=tp.idProdi) WHERE tm.nim='$username' AND tm.status IN ('A','P') LIMIT 1";
			$db->runQuery($check);
			
			if($db->dbRows()>0){
				$log=$db->dbFetch();
				if($log['password']==md5($password)){
					$sesilogin=array(
						"nim"=>$log['nim'],
						"prodi"=>$log['idProdi'],
						"nmprodi"=>$log['nmProdi'],
						"nama_lengkap"=>$log['nmLengkap'],
						"id"=>$log['idmhs'],
						"status"=>$log['status']
					);
									
					$_SESSION['login-mhs']=$sesilogin; 
					echo json_encode(
						array(
						"result" =>TRUE,
						"msg" =>"Login Sukses."
						));
				}else{
					//password salah
					echo json_encode(
						array(
						"result" =>FALSE,
						"msg" =>"Gagal Login, Password anda tidak sesuai/salah."
						));
				}
			}else{
				//username tidak terdaftar
				echo json_encode(array(
					"result" =>FALSE,
					"msg" =>"Gagal Login, Username Anda tidak terdaftar."
					));
			}
		break;
		case 'logout':
			unset($_SESSION['login-mhs']);
			echo json_encode(array("result"=>true));
		break;

		case 'recoverpass' : // coming soon
			$email=$_POST['email'];
			$query="SELECT * FROM tbmhs WHERE email='$email' limit 1";
			$db->runQuery($query);
			if($db->dbRows()>0){
				$r=$db->dbFetch();
				$idmh=$r['idmhs'];
				$username=$r['nim'];
				$password=$r['password'];
				$date=date('Y-m-d H:i:s');
				$recoverkey=md5($password.$username.$date);
				$recover="INSERT INTO temp_resetpass SET tglrecover='$date', iduser='$idmh', jenis='M', rkey='$recoverkey'";
				//echo $recover;
				$db->runQuery($recover);

				//$linkreset="/~project/spota/request.php?key=$recoverkey";
				//script kirim email
				echo json_encode(array(
					"result" =>TRUE,
					"msg" =>"Terima Kasih, \nSilakan Cek Email Anda untuk reset password"
					));
			}else{
				echo json_encode(array(
					"result" =>FALSE,
					"msg" =>"Email tidak terdaftar."
					));
			}
		break;
		
		/*default:
		break;*/
	}

	
}

?>