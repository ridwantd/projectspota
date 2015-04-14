<?php
session_start();
if($_POST){
	include ("../../../inc/helper.php");
	include ("../../../inc/konfigurasi.php");
	include ("../../../inc/db.pdo.class.php");

	$db=new dB($dbsetting);

	switch($_POST['act']){
		case 'insert':
		$insert="INSERT INTO tbjurusan SET
		idFak='".$_POST['idFak']."',
		nmJurusan='".$_POST['nmJurusan']."'
		";
		//echo $insert;
		if($db->runQuery($insert)){
			echo json_encode(array("result"=>true,"msg"=>"Data Jurusan berhasil ditambahkan."));
		}else{
			echo json_encode(array("result"=>false,"msg"=>"Aksi Gagal DBERROR."));
		}
		break;

		case 'update':
		$id=$_POST['idJur'];
		if(ctype_digit($id)){
			$update="UPDATE tbjurusan SET
			idFak='".$_POST['idFak']."',	
			nmJurusan='".$_POST['nmJurusan']."' WHERE idJur='$id'";	
			//echo $update;
			if($db->runQuery($update)){
				echo json_encode(array("result"=>true,"msg"=>"Data Jurusan telah diupdate."));
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Aksi update Gagal DBERROR."));
			}
		}
		break;

		case 'hapusjur':
		$id=$_POST['idJur'];
		if(ctype_digit($id)){
			$hapus="DELETE FROM tbjurusan WHERE idJur='$id'";
			if($db->runQuery($hapus)){
				echo json_encode(array("result"=>true,"msg"=>"Data Jurusan telah dihapus."));
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Aksi gagal DBERROR."));
			}
		}
		break;
	}
}
?>