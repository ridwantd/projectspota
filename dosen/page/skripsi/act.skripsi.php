<?php
session_start();
if($_SESSION['login-dosen']){
if($_POST){
	include ("../../../inc/helper.php");
	include ("../../../inc/konfigurasi.php");
	include ("../../../inc/db.pdo.class.php");

	$db=new dB($dbsetting);

	switch($_POST['act']){

		case 'post_forum':
			$idrekap=$_POST['idrek'];
			$nim=$_POST['nim'];
			$nip=$_SESSION['login-dosen']['nip'];
			$isi=$_POST['text_forum'];
			$tglwkt=date("Y-m-d H:i");
			
			$simpan="INSERT INTO tbforum SET
				idForum='',
				idRekap='".$idrekap."',
				nim='".$nim."',
				nip='".$nip."',
				isi='".$isi."',
				tglwkt='".$tglwkt."'";
				
				if($db->runQuery($simpan)){
					echo json_encode(array("result"=>true,"msg"=>"Sukses Menambahkan Diskusi Forum"));
				}else{
					echo json_encode(array("result"=>false,"msg"=>"Gagal Menambahkan Diskusi Forum, DBError"));
				}
		break;
		
		case 'post_review':
			$query = "SHOW TABLE STATUS LIKE 'tbreviewdiskusi'";
			$db->runQuery($query);
			$data  = $db->dbFetch();
			$newID = $data['Auto_increment'];
			
			$nip=$_SESSION['login-dosen']['nip'];
			$id=$_POST['id'];
			$sub=$_POST['sub'];
			$prodi=$_SESSION['login-dosen']['prodi'];
			$rev_text=$_POST['text_review'];
			$stdis=$_POST['putusan'];
			
			if($stdis=='1'){
				$update="UPDATE tbdiskusi SET stDiskusi='$stdis', wktSelesai=CURDATE() WHERE idDiskusi='$id'";
				$db->runQuery($update);
			}else{}
			
			if($_FILES['berkas']['name']!=""){
				$dir=LAMPIRAN_FILE;

				$supportlist=array('pdf','zip','doc','docx'); 
				$namaberkas=$_FILES['berkas']['name'];
				$type=$_FILES['berkas']['type'];
				$tmpname=$_FILES['berkas']['tmp_name'];
				$ext=get_ext($namaberkas);

				if(!in_array($ext, $supportlist)){
					echo json_encode(array("result"=>false,"msg"=>"Hanya Mendukung file pdf, zip, word"));
						exit;
				}

				$nmfile=$newID."-".$nip."-".trim($sub).".".$ext;
				$pathfile=$dir.$nmfile;

				if (move_uploaded_file($tmpname,$pathfile)){
					$query="INSERT INTO tbreviewdiskusi SET
						idRev='$newID',
						idDiskusi='$id',
						idProdi='$prodi',
						reviewer='$nip',
						rev_text='$rev_text',
						file_lamp='".$nmfile."',
						type_filelamp='".$type."',					
						tgl=CURDATE(),
						wkt=CURTIME(),
						status='0'
						";
					if(!$db->runQuery($query)){
						echo json_encode(array("result"=>false,"msg"=>"Review Gagal DbError"));
						@unlink($pathfile);
						exit;
					}else{
						echo json_encode(array("result"=>true,"msg"=>"Review Berhasil Ditambahkan"));
					}
				}else{
					echo json_encode(array("result"=>false,"msg"=>"Review Gagal Ditambahkan"));
					exit;
				}
			}else{
				$query="INSERT INTO tbreviewdiskusi SET
					idRev='$newID',
					idDiskusi='$id',
					idProdi='$prodi',
					reviewer='$nip',
					rev_text='$rev_text',					
					tgl=CURDATE(),
					wkt=CURTIME(),
					status='0'
					";
					if(!$db->runQuery($query)){
						echo json_encode(array("result"=>false,"msg"=>"Review Gagal Ditambahkan"));
					}else{
						echo json_encode(array("result"=>true,"msg"=>"Review Berhasil Ditambahkan"));
					}
			}
		break;
	}
}
}
?>