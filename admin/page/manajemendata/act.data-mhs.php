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
			if(!isset($_FILES['foto']) || !is_uploaded_file($_FILES['foto']['tmp_name']))
			{
				$msg="Data Mahasiswa telah ditambahkan.";

				if($_SESSION['login-admin']['lvl']=='S'){
					$prodi="idProdi='".$_POST['prodi']."',";
				}else{
					$prodi="idProdi='".$_SESSION['login-admin']['prodi']."',";
				}
				
				$query="INSERT into tbmhs 
				SET 
				nim='".$_POST['nim']."',
				nmLengkap='".$_POST['nmLengkap']."',
				password='".md5(trim($_POST['password']))."',
				email='".$_POST['email']."',
				$prodi
				thnmasuk='".$_POST['thnmasuk']."',
				status='A'
				";

			}else{

				$file_gambar=$_FILES['foto'];

				$ThumbSquareSize 		= 200; //Thumbnail will be 150x150
				$BigImageMaxSize 		= 200; //Image Maximum height or width
				$ThumbPrefix			= "thumb_"; //Normal thumb Prefix
				$DestinationDirectory	= DIR_GAMBAR; //Upload Directory ends with / (slash)
				$Quality 				= 90;

				$RandomNumber 	= rand(0, 9999999999); 

				$ImageName 		= str_replace(' ','-',strtolower($_FILES['foto']['name'])); 
				$ImageSize 		= $_FILES['foto']['size']; // Obtain original image size
				$TempSrc	 	= $_FILES['foto']['tmp_name']; // Tmp name of image file stored in PHP tmp folder
				$ImageType	 	= $_FILES['foto']['type']; //Obtain file type, returns "image/png", image/jpeg, text/plain etc.

				switch(strtolower($ImageType))
				{
					case 'image/png':
						$CreatedImage =  imagecreatefrompng($_FILES['foto']['tmp_name']);
						break;
					case 'image/gif':
						$CreatedImage =  imagecreatefromgif($_FILES['foto']['tmp_name']);
						break;			
					case 'image/jpeg':
					case 'image/pjpeg':
						$CreatedImage = imagecreatefromjpeg($_FILES['foto']['tmp_name']);
						break;
					default:
						echo json_encode(array("result"=>false,"msg"=>"File gambar yang didukung hanya *.jpg,*.png,*.gif"));
						exit;

						break;
				}
				
				list($CurWidth,$CurHeight)=getimagesize($TempSrc);
				//Get file extension from Image name, this will be re-added after random name
				$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
				$ImageExt = str_replace('.','',$ImageExt);

				$ImageName 		= "dosen"; 
				
				$NewImageName = $ImageName.'_'.$RandomNumber.'.'.$ImageExt;
				$thumb_DestRandImageName 	= $DestinationDirectory.$NewImageName; //Thumb name
				
				if(!resizeImage($CurWidth,$CurHeight,$BigImageMaxSize,$thumb_DestRandImageName,$CreatedImage,$Quality,$ImageType))
				{
					echo json_encode(array("result"=>false,"msg"=>"Upload Gambar gagal"));
						exit;
				}else{
					$msg="Data Mahasiswa telah ditambahkan.";

					if($_SESSION['login-admin']['lvl']=='S'){
						$prodi="idProdi='".$_POST['prodi']."',";
					}else{
						$prodi="idProdi='".$_SESSION['login-admin']['prodi']."',";
					}
					
					$query="INSERT into tbmhs 
					SET 
					nim='".$_POST['nim']."',
					nmLengkap='".$_POST['nmLengkap']."',
					password='".md5(trim($_POST['password']))."',
					email='".$_POST['email']."',
					$prodi
					thnmasuk='".$_POST['thnmasuk']."',
					foto='".$NewImageName."',
					status='A'
					";
				}
			
			}

			if($db->runQuery($query)){ 
				echo json_encode(array("result"=>true,"msg"=>$msg));
			}else{
				//if($_POST['slider']=="Y"){
					@unlink($DestRandImageName);
					@unlink($thumb_DestRandImageName);
				//}
				echo json_encode(array("result"=>false,"msg"=>"Aksi Gagal DbError"));
				exit;
			}
		break;

		case 'update':
			$id=$_POST['mhs'];
			if(ctype_digit($id)){
				if(!isset($_FILES['foto']) || !is_uploaded_file($_FILES['foto']['tmp_name'])){
					if($_SESSION['login-admin']['lvl']=='S'){
						$prodi="idProdi='".$_POST['prodi']."',";
					}else{
						$prodi="idProdi='".$_SESSION['login-admin']['prodi']."',";
					}

					if($_POST['password']!=""){
						$pass="password='".md5(trim($_POST['password']))."', ";
					}else{
						$pass="";
					}
					$msg="Data Mahasiswa telah diupdate.";

					$queryupdate="UPDATE tbmhs 
					SET
					nim='".$_POST['nim']."',
					nmLengkap='".$_POST['nmLengkap']."',
					$pass
					email='".$_POST['email']."',
					$prodi
					thnmasuk='".$_POST['thnmasuk']."',
					status='A'
					WHERE idmhs='$id'
					";

				}else{

					$ThumbSquareSize 		= 200; //Thumbnail will be 150x150
					$BigImageMaxSize 		= 200; //Image Maximum height or width
					$ThumbPrefix			= "thumb_"; //Normal thumb Prefix
					$DestinationDirectory	= DIR_GAMBAR; //Upload Directory ends with / (slash)
					$Quality 				= 90;

					$RandomNumber 	= rand(0, 9999999999); 

					$ImageName 		= str_replace(' ','-',strtolower($_FILES['foto']['name'])); 
					$ImageSize 		= $_FILES['foto']['size']; // Obtain original image size
					$TempSrc	 	= $_FILES['foto']['tmp_name']; // Tmp name of image file stored in PHP tmp folder
					$ImageType	 	= $_FILES['foto']['type']; //Obtain file type, returns "image/png", image/jpeg, text/plain etc.

					switch(strtolower($ImageType))
					{
						case 'image/png':
							$CreatedImage =  imagecreatefrompng($_FILES['foto']['tmp_name']);
							break;
						case 'image/gif':
							$CreatedImage =  imagecreatefromgif($_FILES['foto']['tmp_name']);
							break;			
						case 'image/jpeg':
						case 'image/pjpeg':
							$CreatedImage = imagecreatefromjpeg($_FILES['foto']['tmp_name']);
							break;
						default:
							echo json_encode(array("result"=>false,"msg"=>"File gambar yang didukung hanya *.jpg,*.png,*.gif"));
							exit;

							break;
					}
					
					list($CurWidth,$CurHeight)=getimagesize($TempSrc);
					$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
					$ImageExt = str_replace('.','',$ImageExt);

					$ImageName 		= "mhs"; 
					
					$NewImageName = $ImageName.'_'.$RandomNumber.'.'.$ImageExt;
					$thumb_DestRandImageName 	= $DestinationDirectory.$NewImageName; //Thumb name
					if(!resizeImage($CurWidth,$CurHeight,$BigImageMaxSize,$thumb_DestRandImageName,$CreatedImage,$Quality,$ImageType))
					{
						echo json_encode(array("result"=>false,"msg"=>"Upload Gambar gagal"));
						exit;

					}else{
						$msg="Data Mahasiswa telah diupdate.";
						if($_SESSION['login-admin']['lvl']=='S'){
							$prodi="idProdi='".$_POST['prodi']."',";
						}else{
							$prodi="idProdi='".$_SESSION['login-admin']['prodi']."',";
						}

						if($_POST['password']!=""){
							$pass="password='".md5(trim($_POST['password']))."', ";
						}else{
							$pass="";
						}

						$queryupdate="UPDATE tbmhs 
						SET  
						nim='".$_POST['nim']."',
						nmLengkap='".$_POST['nmLengkap']."',
						$pass
						email='".$_POST['email']."',
						$prodi
						thnmasuk='".$_POST['thnmasuk']."',
						foto='".$NewImageName."',
						status='A'
						WHERE idmhs='$id'
						";
						@unlink(DIR_GAMBAR.$_POST['img']);
					}
				}
				if($db->runQuery($queryupdate)){ 
					echo json_encode(array("result"=>true,"msg"=>$msg));
					
				}else{
					//if($_POST['slider']=="Y"){
						@unlink($DestRandImageName);
						@unlink($thumb_DestRandImageName);
					//}
					echo json_encode(array("result"=>false,"msg"=>"Aksi Gagal DbError"));
					exit;
				}
			}
		
		break;

		case 'hapusmhs':
			$id=$_POST['idmhs'];
			if(ctype_digit($id)){
				$hapus="DELETE FROM tbmhs WHERE idmhs='$id'";
				if($db->runQuery($hapus)){
					echo json_encode(array("result"=>true,"msg"=>"Data Mahasiswa telah dihapus."));
				}else{
					echo json_encode(array("result"=>false,"msg"=>"Aksi gagal DBERROR."));
				}
			}
		break;

		case 'enable':
			$id=$_POST['id'];
			if(ctype_digit($id)){
				$enable="UPDATE tbmhs SET status='A' WHERE idmhs='$id'";
				if($db->runQuery($enable)){
					echo json_encode(array("result"=>true,"msg"=>"Akun sudah diaktifkan."));
				}else{
					echo json_encode(array("result"=>false,"msg"=>"Aksi Gagal."));
				}
			}
		break;

		case 'disable':
			$id=$_POST['id'];
			if(ctype_digit($id)){
				$enable="UPDATE tbmhs SET status='N' WHERE idmhs='$id'";
				if($db->runQuery($enable)){
					echo json_encode(array("result"=>true,"msg"=>"Akun sudah dinonaktifkan."));
				}else{
					echo json_encode(array("result"=>false,"msg"=>"Aksi Gagal."));
				}
			}
	break;
	}
}
}
?>