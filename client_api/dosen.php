<?php
session_start();

include ("../inc/helper.php");
include ("../inc/konfigurasi.php");
include ("../inc/db.pdo.class.php");


$db=new dB($dbsetting);
header('Content-Type: application/json');
if($_POST){
	switch($_POST['act']){
		case 'profil':
			$jenis=$_POST['j'];
			$id=$_POST['who'];
			$prodi=$_POST['idprodi'];

			if(ctype_digit($id)){
				$qu="SELECT * FROM tbdosen WHERE idDosen='$id' AND idProdi='$prodi' LIMIT 1";
				$db->runQuery($qu);
				if($db->dbRows()>0){
					$r=$db->dbFetch();
					$response=array();
					$response["profil"] = array();
							
					$detail['nama_lengkap']=$r['nmLengkap'];
					$detail['id_user']=$r['iddosen'];
					$detail['id_prodi']=$r['idProdi'];
					$detail['username']=$r['nip'];
					$detail['email']=$r['email'];
					$detail['nohp']=$r['nohp'];
					$detail['jabatan']=$r['jenis'];
					$detail['foto']=LINK_GAMBAR.$r['foto'];
						
					$response["success"] = "1";
					$response["msg"] = "Data Loaded";
					array_push($response["profil"], $detail);
					echo json_encode($response);
				}else{
					$response["success"] = "0";
					$response["profil"] = null;
					$response["msg"] = "Load Data Failed (Data Not Found)";
					echo json_encode($response);
				}
			}else{
				$response["success"] = "0";
				$response["profil"] = null;
				$response["msg"] = "Load Data Failed";
				echo json_encode($response);
			}
		break;

		case 'update':
			$id=$_POST['id'];
			$jenis=$_POST['j'];
			
			if(ctype_digit($id)){

				$RandomNumber 	= rand(0, 9999999999); 
				$ImageName 		= "dosen"; 
				$NewImageName = $ImageName.'_'.$RandomNumber.'.jpg';

				if($_POST['pic']!=""){
					base64_to_jpeg($_POST['pic'],DIR_GAMBAR.$NewImageName);
					$foto=" foto='".$NewImageName."', ";
				}else{
					$foto="";
				}
				
				$oldpic="SELECT foto FROM tbdosen WHERE iddosen='$id'";
				$db->runQuery($oldpic);
				$rpic=$db->dbFetch();
				$gambarlama=$rpic['foto'];

				$u="UPDATE tbdosen SET 
				nmLengkap='".$_POST['nama']."', 
				email='".$_POST['email']."', 
				nohp='".$_POST['nohp']."', 
				$foto
				jabatan='".$_POST['jabatan']."' 
				WHERE iddosen='$id'";

				if($db->runQuery($u)){ 
					$response["success"] = "1";
					$response["profil"] = null;
					$response["msg"] = "Profil Berhasil Diupdate";
					if($_POST['pic']!=""){
						@unlink(DIR_GAMBAR.$gambarlama);
					}
					echo json_encode($response);
				}else{
					@unlink(DIR_GAMBAR.$NewImageName);
					$response["success"] = "0";
					$response["profil"] = null;
					$response["msg"] = "Gagal Update Data - ";
					echo json_encode($response);
				}
			}else{
				$response["success"] = "0";
				$response["profil"] = null;
				$response["msg"] = "Sorry, Cant Process Your Request";
				echo json_encode($response);
			}
		break;

		case 'update_pwd':
			$id=$_POST['id'];
			$jenis=$_POST['j'];
			$pwdbaru=$_POST['pwdbaru'];
			$pwdlama=$_POST['pwdlama'];
			$u="";
			if(ctype_digit($id)){
				$s="SELECT password FROM tbdosen WHERE iddosen='$id' LIMIT 1";
				$db->runQuery($s);
				if($db->dbRows()>0){
					$r=$db->dbFetch();
					if($r['password']==md5($pwdlama)){
						$u="UPDATE tbdosen SET password='".md5($pwdbaru)."' WHERE iddosen='$id'";
					}else{
						echo json_encode(array("success"=>"0","profil"=>null,"msg"=>"Password Lama Tidak Sesuai"));
					}
				}else{
					echo json_encode(array("success"=>"0","profil"=>null,"msg"=>"Data Not Found"));
				}
				
				if($db->runQuery($u)){
					echo json_encode(array("success"=>"1","profil"=>null,"msg"=>"Ganti Password Berhasil"));
				}else{
					echo json_encode(array("success"=>"0","profil"=>null,"msg"=>"DBError"));				}
			}else{
				$response["success"] = "0";
				$response["profil"] = null;
				$response["msg"] = "Sorry, Cant Process Your Request";
				echo json_encode($response);
			}
		break;

		case 'listdosen':
			$prodi=$_POST['idprodi'];
			$q="SELECT * FROM tbdosen WHERE idProdi='$prodi'";
			$db->runQuery($q);
			if($db->dbRows()>0){
				$response=array();
				$response["data"]=array();

				//$dosen=array();

				//$dosen['nip']="";
				//$dosen['namadosen']="Pilih Dosen";
				//array_push($response["data"], $dosen);

				while($r=$db->dbFetch()){
					$dosen=array();

					$dosen['nip']=$r['nip'];
					$dosen['namadosen']=$r['nmLengkap'];
					array_push($response["data"], $dosen);
				}
				$response["success"] = "1";
				$response["msg"] = "Sukses";
				echo json_encode($response);
			}
		break;

		default:
			$response["success"] = "0";
			$response["profil"] = null;
			$response["msg"] = "Request not found";
			echo json_encode($response);
		break;
	}
}else{
	$response["success"] = "0";
	$response["profil"] = null;
	$response["msg"] = "Request not found";
	echo json_encode($response);
}

function base64_to_jpeg($base64_string, $output_file) {
    $ifp = fopen($output_file, "wb"); 

    fwrite($ifp, base64_decode($base64_string)); 
    fclose($ifp); 

    return $output_file; 
}