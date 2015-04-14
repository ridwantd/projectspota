<?php
session_start();

include ("../inc/helper.php");
include ("../inc/konfigurasi.php");
include ("../inc/db.pdo.class.php");


$db=new dB($dbsetting);
if($_POST){
	switch($_POST['act']){
		case 'lihat':
			$jenis=$_POST['j'];
			$id=$_POST['who'];

			if(ctype_digit($id) && ctype_alnum($jenis)){
				if($jenis=="M"){
					$qu="SELECT * FROM tbmhs WHERE idMhs='$id' LIMIT 1";
					$db->runQuery($qu);
					if($db->dbRows()>0){
						$r=$db->dbFetch();
						$response=array();
						$response["profil"] = array();

						$detail['nama_lengkap']=$r['nmLengkap'];
						$detail['id_user']=$r['idmhs'];
						$detail['id_prodi']=$r['idProdi'];
						$detail['username']=$r['nim'];
						$detail['email']=$r['email'];
						$detail['angkatan']=$r['thnmasuk'];
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
				}else if($jenis=="D" OR $jenis=="K"){
					$qu="SELECT * FROM tbdosen WHERE idDosen='$id' LIMIT 1";
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
						$detail['nohp']=$r['jenis'];
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
				if($jenis=="M"){
					$u="UPDATE tbmhs SET 
					nmLengkap='".$_POST['nama']."', 
					email='".$_POST['email']."' 
					WHERE idmhs='$id'";
				}else if($jenis=="D" OR $jenis=="K"){
					$u="UPDATE tbdosen SET 
					nmLengkap='".$_POST['nama']."', 
					email='".$_POST['email']."', 
					nohp='".$_POST['nohp']."', 
					jabatan='".$_POST['jabatan']."' 
					WHERE iddosen='$id'";
				}
				
				if($db->runQuery($u)){
					$response["success"] = "1";
					$response["profil"] = null;
					$response["msg"] = "Profil Berhasil Diupdate";
					echo json_encode($response);
				}else{
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
			$pwd=$_POST['pwd'];
			$u="";
			if(ctype_digit($id)){
				if($jenis=="M"){
					$s="SELECT password FROM tbmhs WHERE idmhs='$id' LIMIT 1";
					$db->runQuery($s);
					if($db->dbRows()>0){
						$r=$db->dbFetch();
						if($r['password']==md5($pwd)){
							$u="UPDATE tbmhs SET password='".md5($pwd)."' WHERE idmhs='$id'";
						}else{
							echo json_encode(array("success"=>"0",
								"profil"=>null,
								"msg"=>"Password Lama Tidak Sesuai"));
						}
					}else{
						echo json_encode(array("success"=>"0","profil"=>null,"msg"=>"Data Not Found"));
					}
				}else if($jenis=="D" OR $jenis=="K"){
					$s="SELECT password FROM tbdosen WHERE iddosen='$id' LIMIT 1";
					$db->runQuery($s);
					if($db->dbRows()>0){
						$r=$db->dbFetch();
						if($r['password']==md5($pwd)){
							$u="UPDATE tbdosen SET password='".md5($pwd)."' WHERE iddosen='$id'";
						}else{
							echo json_encode(array("success"=>"0","profil"=>null,"msg"=>"Password Lama Tidak Sesuai"));
						}
					}else{
						echo json_encode(array("success"=>"0","profil"=>null,"msg"=>"Data Not Found"));
					}
				}
				
				if($db->runQuery($u)){
					echo json_encode(array("success"=>"1","profil"=>null,"msg"=>"Profil Berhasil diupdate"));
				}else{
					echo json_encode(array("success"=>"0","profil"=>null,"msg"=>"Gagal Update Data"));				}
			}else{
				$response["success"] = "0";
				$response["profil"] = null;
				$response["msg"] = "Sorry, Cant Process Your Request";
				echo json_encode($response);
			}
		break;
	}
}else{
	$response["success"] = "0";
	$response["profil"] = null;
	$response["msg"] = "Request not found";
	echo json_encode($response);
}