<?php
session_start();
if($_SESSION['login-admin']){
	if($_POST){
		include ("../../../inc/helper.php");
		include ("../../../inc/konfigurasi.php");
		include ("../../../inc/db.pdo.class.php");

		$db=new dB($dbsetting);

		switch($_POST['act']){
			case 'insert':
				$publish='Y';
				if($_POST['draft']=='yes'){
					$publish='N';
				}
				$in=$db->runQuery("INSERT INTO tbpengumuman SET idProdi='{$_SESSION['login-admin']['prodi']}',judul='{$_POST['judul']}',isi='{$_POST['isi_pengumuman']}', tujuan='{$_POST['tujuan']}', tgl='".NOW."', author='{$_SESSION['login-admin']['id']}',publish='".$publish."' ");
				if($in){
					echo json_encode(array("result"=>true,"msg"=>"Pengumuman Berhasil Ditambahkan."));
				}else{
					echo json_encode(array("result"=>false,"msg"=>"Aksi Gagal"));
				}
			break;

			case 'update':
				$idpengumuman=$_POST['pengumuman'];
				if(ctype_digit($idpengumuman)){
					$sql="UPDATE tbpengumuman SET judul='{$_POST['judul']}',isi='{$_POST['isi_pengumuman']}', tujuan='{$_POST['tujuan']}', publish='".$publish."' WHERE id='$idpengumuman'";
					if($db->runQuery($sql)){
						echo json_encode(array("result"=>true,"msg"=>"Pengumuman Berhasil Update."));
					}else{
						echo json_encode(array("result"=>false,"msg"=>"Aksi Gagal"));
					}
				}else{
					echo json_encode(array("result"=>false,"msg"=>"Invalid ID"));
				}
			break;

			case 'hapuspengumuman':
				$idpengumuman=$_POST['pengumuman'];
				if(ctype_digit($idpengumuman)){
					if($db->runQuery("DELETE FROM tbpengumuman WHERE id='$idpengumuman'")){
						echo json_encode(array("result"=>true,"msg"=>"Pengumuman Berhasil Dihapus."));
					}else{
						echo json_encode(array("result"=>false,"msg"=>"Aksi Gagal"));
					}
				}else{
					echo json_encode(array("result"=>false,"msg"=>"Invalid ID"));
				}
			break;

			case 'publish':
				if(ctype_digit($_POST['idpengumuman'])){
					if($db->runQuery("UPDATE tbpengumuman SET publish='Y' WHERE id='{$_POST['idpengumuman']}'")){
						echo json_encode(array("result"=>true,"msg"=>"Pengumuman Berhasil Diterbitkan."));
					}else{
						echo json_encode(array("result"=>false,"msg"=>"Aksi Gagal"));
					}
				}else{
					echo json_encode(array("result"=>false,"msg"=>"Invalid ID"));
				}
			break;

		}
	}
}