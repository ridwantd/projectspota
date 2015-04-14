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
			
			$check="SELECT 
				td.iddosen,
				td.nip,
				td.password,
				td.nmLengkap,
				td.jabatan,
				td.email,
				td.idProdi,
				td.jenis, 
				tp.nmProdi 
			FROM tbdosen td 
			LEFT JOIN tbprodi tp ON (td.idProdi=tp.idProdi) 
			WHERE td.nip='$username' 
				AND td.status='A' LIMIT 1";
			$db->runQuery($check);
			
			if($db->dbRows()>0){
				$log=$db->dbFetch();
				if($log['password']==md5($password)){
					$sesilogin=array(
						"nip"=>$log['nip'],
						"prodi"=>$log['idProdi'],
						"nmprodi"=>$log['nmProdi'],
						"nama_lengkap"=>$log['nmLengkap'],
						"id"=>$log['iddosen'],
						"jenisdosen"=>$log['jenis']
					);
									
					$_SESSION['login-dosen']=$sesilogin; 
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
					"msg" =>"Gagal Login, Anda tidak terdaftar."
					));
			}
		break;
		case 'logout':
			unset($_SESSION['login-dosen']);
			echo json_encode(array("result"=>true));
		break;

		case 'recoverpass' : // coming soon
			$email=$_POST['email'];
			$query="SELECT * FROM tbdosen WHERE email='$email' limit 1";
			$db->runQuery($query);
			if($db->dbRows()>0){
				$r=$db->dbFetch();
				$iddosen=$r['iddosen'];
				$username=$r['nip'];
				$password=$r['password'];
				$date=date('Y-m-d H:i:s');
				$recoverkey=md5($password.$username.$date);
				$recover="INSERT INTO temp_resetpass SET tglrecover='$date', iduser='$iddosen', jenis='D', rkey='$recoverkey'";
				//echo $recover;
				$db->runQuery($recover);

				//$linkreset="/~project/spota/request.php?key=$recoverkey";
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