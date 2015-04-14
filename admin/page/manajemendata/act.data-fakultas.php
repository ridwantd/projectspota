<?php
session_start();
if($_POST){
	include ("../../../inc/helper.php");
	include ("../../../inc/konfigurasi.php");
	include ("../../../inc/db.pdo.class.php");

	$db=new dB($dbsetting);

	switch($_POST['act']){
		case 'insert':
		$insert="INSERT INTO tbfakultas SET
		idFak='".$_POST['idFak']."',
		nmFakultas='".$_POST['nmFakultas']."'
		";
		//echo $insert;
		if($db->runQuery($insert)){
			echo json_encode(array("result"=>true,"msg"=>"Data Fakultas baru berhasil ditambahkan."));
		}else{
			echo json_encode(array("result"=>false,"msg"=>"Aksi Gagal DBERROR."));
		}
		break;

		case 'update':
		$id=$_POST['idFak'];
		if(ctype_alpha($id)){
			$update="UPDATE tbfakultas SET
			nmFakultas='".$_POST['nmFakultas']."' WHERE idFak='$id'";	
			//echo $update;
			if($db->runQuery($update)){
				echo json_encode(array("result"=>true,"msg"=>"Data Fakultas telah diupdate."));
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Aksi update Gagal DBERROR."));
			}
		}
		break;

		case 'hapusfak':
		$id=$_POST['idFak'];
		if(ctype_alpha($id)){
			$hapus="DELETE FROM tbfakultas WHERE idFak='$id'";
			if($db->runQuery($hapus)){
				echo json_encode(array("result"=>true,"msg"=>"Data Fakultas telah dihapus."));
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Aksi gagal DBERROR."));
			}
		}
		break;
	}
}
?>