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
			
			$check="SELECT ta.idAdmin,ta.username,ta.password,ta.nmLengkap,ta.jabatan,ta.email,ta.idProdi,ta.jenisAdmin, tp.nmProdi FROM tbadmin ta LEFT JOIN tbprodi tp ON (ta.idProdi=tp.idProdi) WHERE ta.username='$username' AND ta.aktif='Y' LIMIT 1";
			$db->runQuery($check);
			
			if($db->dbRows()>0){
				$log=$db->dbFetch();
				if($log['password']==md5($password)){
					$sesilogin=array(
						"username"=>$log['username'],
						"prodi"=>$log['idProdi'],
						"nmprodi"=>$log['nmProdi'],
						"lvl"=>$log['jenisAdmin'],
						"nama_lengkap"=>$log['nmLengkap'],
						"id"=>$log['idAdmin'],
						"jabatan"=>$log['jabatan']
					);
									
					$_SESSION['login-admin']=$sesilogin; 
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
			unset($_SESSION['login-admin']);
			echo json_encode(array("result"=>true));
		break;

		case 'recoverpass' : // coming soon
			$email=$_POST['email'];
			$query="SELECT * FROM tbadmin WHERE email='$email' limit 1";
			$db->runQuery($query);
			if($db->dbRows()>0){
				$r=$db->dbFetch();
				$idadmin=$r['idAdmin'];
				$username=$r['username'];
				$password=$r['password'];
				$date=date('Y-m-d H:i:s');
				$recoverkey=md5($password.$username.$date);
				$recover="INSERT INTO temp_resetpass SET tglrecover='$date', iduser='$idadmin', jenis='A', rkey='$recoverkey'";
				//echo $recover;
				$db->runQuery($recover);

				//$linkreset="/~project/spota/admin/request.php?key=$recoverkey";
				//koding kirim email
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