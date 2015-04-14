<?php
session_start();
if($_SESSION['login-mhs']){
if($_POST){
	include ("../../../inc/helper.php");
	include ("../../../inc/konfigurasi.php");
	include ("../../../inc/db.pdo.class.php");

	$db=new dB($dbsetting);

	switch($_POST['act']){
		
		case 'diskusi':
			$pemb=$_POST['pemb'];
			$bab=$_POST['bab'];
			$sub=$_POST['sub'];
			$nim=$_SESSION['login-mhs']['nim'];
			$prodi=$_SESSION['login-mhs']['prodi'];
			$stta=$_POST['stta'];
			
			$simpan="INSERT INTO tbdiskusi SET
				idDiskusi='',
				idProdi='".$prodi."',
				nim='".$nim."',
				pemb='".$pemb."',
				idBab='".$bab."',
				subDiskusi='".$sub."',
				wktMulai=CURDATE(),
				wktSelesai=null,
				stDiskusi='0',
				stTA='".$stta."'";
				
				if($db->runQuery($simpan)){
						echo json_encode(array("result"=>true,"msg"=>"Sukses Menambahkan Diskusi"));
					}else{
						echo json_encode(array("result"=>false,"msg"=>"Gagal Menambahkan Diskusi, DBError"));
					}
		break;

		case 'post_review':
			$query = "SHOW TABLE STATUS LIKE 'tbreviewdiskusi'";
			$db->runQuery($query);
			$data  = $db->dbFetch();
			$newID = $data['Auto_increment'];
			
			$nim=$_SESSION['login-mhs']['nim'];
			$id=$_POST['id'];
			$sub=$_POST['sub'];
			$prodi=$_SESSION['login-mhs']['prodi'];
			$rev_text=$_POST['text_review'];

			//print_r($_POST);
			//print_r($_FILES);
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

				$nmfile=$newID."-".$nim."-".trim($sub).".".$ext;
				$pathfile=$dir.$nmfile;

				if (move_uploaded_file($tmpname,$pathfile)){
					$query="INSERT INTO tbreviewdiskusi SET
						idRev='$newID',
						idDiskusi='$id',
						idProdi='$prodi',
						reviewer='$nim',
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
			}else {
				$query="INSERT INTO tbreviewdiskusi SET
					idRev='$newID',
					idDiskusi='$id',
					idProdi='$prodi',
					reviewer='$nim',
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
		
		case 'jadwal':
			$judul=$_POST['judul'];
			$pemb1=$_POST['pemb1'];
			$pemb2=$_POST['pemb2'];
			$peng1=$_POST['peng1'];
			$peng2=$_POST['peng2'];
			$jenis=$_POST['jenis'];
			$ruang=$_POST['ruang'];
			$daterange=$_POST['daterange'];
			$date=explode("-",$daterange);
				$date1=date_create($date[0]);
				$start=date_format($date1, 'Y-m-d');
				$date2=date_create($date[1]);
				$end=date_format($date2, 'Y-m-d');
			$idmhs=$_SESSION['login-mhs']['id'];
			$prodi=$_SESSION['login-mhs']['prodi'];
			
			$submit="INSERT INTO tbjadwal SET
				id='',
				idMhs='".$idmhs."',
				idProdi='".$prodi."',
				judul='".$judul."',
				ruangan='".$ruang."',
				jenis='".$jenis."',
				start='".$start."',
				end='".$end."',
				pemb1='".$pemb1."',
				pemb2='".$pemb2."',
				peng1='".$peng1."',
				peng2='".$peng2."',
				publish='N'";
				
				if($db->runQuery($submit)){
						echo json_encode(array("result"=>true,"msg"=>"Sukses Mengajukan Jadwal"));
					}else{
						echo json_encode(array("result"=>false,"msg"=>"Gagal Mengajukan Jadwal, DBError"));
					}
		break;
	}
}	
}