<?php
session_start();
if($_POST){
	include ("../../../inc/helper.php");
	include ("../../../inc/konfigurasi.php");
	include ("../../../inc/db.pdo.class.php");

	$db=new dB($dbsetting);

	switch($_POST['act']){
		case 'insert':
		$insert="INSERT INTO tbprodi SET
		idFak='".$_POST['idFak']."',
		idJur='".$_POST['idJur']."',
		nmProdi='".$_POST['nmProdi']."'
		";
		//echo $insert;
		if($db->runQuery($insert)){
			echo json_encode(array("result"=>true,"msg"=>"Data Program Studi baru berhasil ditambahkan."));
		}else{
			echo json_encode(array("result"=>false,"msg"=>"Aksi Gagal DBERROR."));
		}
		break;

		case 'update':
		$id=$_POST['idProdi'];
		if(ctype_digit($id)){
			$update="UPDATE tbprodi SET
			idFak='".$_POST['idFak']."',
			idJur='".$_POST['idJur']."',
			nmProdi='".$_POST['nmProdi']."' WHERE idProdi='$id'";	
			//echo $update;
			if($db->runQuery($update)){
				echo json_encode(array("result"=>true,"msg"=>"Data Fakultas telah diupdate."));
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Aksi update Gagal DBERROR."));
			}
		}
		break;

		case 'hapusprodi':
		$id=$_POST['idProdi'];
		if(ctype_digit($id)){
			$hapus="DELETE FROM tbprodi WHERE idProdi='$id'";
			if($db->runQuery($hapus)){
				echo json_encode(array("result"=>true,"msg"=>"Data Program Studi telah dihapus."));
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Aksi gagal DBERROR."));
			}
		}
		break;
	}
}
?>