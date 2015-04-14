<?php
session_start();
if($_POST){
	include ("../../../inc/helper.php");
	include ("../../../inc/konfigurasi.php");
	include ("../../../inc/db.pdo.class.php");

	$db=new dB($dbsetting);

	switch($_POST['act']){
		case 'insert':
		$password=md5($_POST['pwd']);
		$level="P";

		$insert="INSERT INTO tbadmin SET
		nmLengkap='".$_POST['nama_lengkap']."',
		jabatan='".$_POST['jabatan']."',
		nip='".$_POST['nip']."',
		email='".$_POST['emailuser']."',
		username='".$_POST['username']."',
		idProdi='".$_POST['prodi']."',
		password='".$password."',
		notelp='".$_POST['telp']."',
		jenisAdmin='".$level."'
		";
		//echo $insert;
		if($db->runQuery($insert)){
			echo json_encode(array("result"=>true,"msg"=>"Admin baru berhasil ditambahkan."));
		}else{
			echo json_encode(array("result"=>false,"msg"=>"Aksi Gagal DBERROR."));
		}
		break;

		case 'update':
		$id=$_POST['id'];
		if(ctype_digit($id)){
			$level="P";

			if($_POST['reset_pwd']=='yes'){
				$password="password='".md5($_POST['username']."12345")."',";
			}else{
				$password="";
			}	

			$update="UPDATE tbadmin SET
			nmLengkap='".$_POST['nama_lengkap']."',
			jabatan='".$_POST['jabatan']."',
			nip='".$_POST['nip']."',
			email='".$_POST['emailuser']."',
			idProdi='".$_POST['prodi']."',
			$password
			notelp='".$_POST['telp']."',
			jenisAdmin='".$level."'
			WHERE idAdmin='$id'";	
			//echo $update;
			if($db->runQuery($update)){
				echo json_encode(array("result"=>true,"msg"=>"Data admin telah diupdate."));
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Aksi update Gagal DBERROR."));
			}
		}
		break;

		case 'updatemyprofile':
			$id=$_POST['id'];
			if($_POST['pwd']!=""){
				$pwd_lama=md5($_POST['pwd_lama']);
				$check="SELECT idAdmin FROM tbadmin WHERE idAdmin='$id' AND password='$pwd_lama' LIMIT 1";
				//echo $check;
				$db->runQuery($check);
				if($db->dbRows()>0){
					$password="password='".md5($_POST['pwd'])."',";
				}else{
					echo json_encode(array("result"=>false,"msg"=>"Password lama anda tidak cocok, silakan masukkan password dengan benar untuk mengganti password."));
					exit;
				}
			}else{
				$password="";
			}
			$queryUpdate="UPDATE tbadmin SET
			nmLengkap='".$_POST['nama_lengkap']."',
			jabatan='".$_POST['jabatan']."',
			nip='".$_POST['nip']."',
			email='".$_POST['emailuser']."',
			$password
			notelp='".$_POST['telp']."'
			WHERE idAdmin='$id'
			";
			//echo $queryUpdate;
			if($db->runQuery($queryUpdate)){
				echo json_encode(array("result"=>true,"msg"=>"Profil telah diupdate."));
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Profil gagal diupdate DBERROR."));
			}
		break;

		case 'hapususer':
		$id=$_POST['id'];
		if(ctype_digit($id)){
			$hapus="DELETE FROM tbadmin WHERE idAdmin='$id'";
			if($db->runQuery($hapus)){
				echo json_encode(array("result"=>true,"msg"=>"Data Admin telah dihapus."));
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Aksi gagal DBERROR."));
			}
		}
		break;

		case 'aktifkanuser':
		$id=$_POST['id'];
		if(ctype_digit($id)){
			$aktifkan="UPDATE tbadmin SET aktif='Y' WHERE idAdmin='$id'";
			if($db->runQuery($aktifkan)){
				echo json_encode(array("result"=>true,"msg"=>"Status Admin Aktif."));
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Aksi gagal DBERROR."));
			}
		}
		break;

		case 'nonaktifkanuser':
		$id=$_POST['id'];
		if(ctype_digit($id)){
			$nonaktifkan="UPDATE tbadmin SET aktif='N' WHERE idAdmin='$id'";
			if($db->runQuery($nonaktifkan)){
				echo json_encode(array("result"=>true,"msg"=>"Status Admin Non Aktif."));
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Aksi gagal DBERROR."));
			}
		}
		break;
	}
}
?>