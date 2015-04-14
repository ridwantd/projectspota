<?php
session_start();
if($_POST){
	include ("../../../inc/helper.php");
	include ("../../../inc/konfigurasi.php");
	include ("../../../inc/db.pdo.class.php");

	$db=new dB($dbsetting);

	switch($_POST['act']){
		case 'updatemyprofile':
			$id=$_POST['dosen'];
			if(ctype_digit($id)){
				if(!isset($_FILES['foto']) || !is_uploaded_file($_FILES['foto']['tmp_name'])){
					if($_POST['password']!=""){
						$pass="password='".md5(trim($_POST['password']))."', ";
					}else{
						$pass="";
					}
					$msg="Profil telah disimpan.";

					$queryupdate="UPDATE tbdosen 
					SET
					nmLengkap='".$_POST['nmLengkap']."',
					nohp='".$_POST['nohp']."',
					$pass
					email='".$_POST['email']."'
					WHERE iddosen='$id'
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

					$ImageName 		= "dosen"; 
					
					$NewImageName = $ImageName.'_'.$RandomNumber.'.'.$ImageExt;
					$thumb_DestRandImageName 	= $DestinationDirectory.$NewImageName; //Thumb name
					if(!resizeImage($CurWidth,$CurHeight,$BigImageMaxSize,$thumb_DestRandImageName,$CreatedImage,$Quality,$ImageType))
					{
						echo json_encode(array("result"=>false,"msg"=>"Upload Gambar gagal"));
						exit;

					}else{
						$msg="Profil telah disimpan.";

						if($_POST['password']==""){
							$pass="password='".md5(trim($_POST['password']))."', ";
						}else{
							$pass="";
						}

						$queryupdate="UPDATE tbdosen 
						SET  
						nmLengkap='".$_POST['nmLengkap']."',
						nohp='".$_POST['nohp']."',
						$pass
						email='".$_POST['email']."',
						foto='".$NewImageName."'
						WHERE iddosen='$id'
						";
						@unlink(DIR_GAMBAR.$_POST['img']);
					}
				}
				if($db->runQuery($queryupdate)){ 
					echo json_encode(array("result"=>true,"msg"=>$msg));
					$_SESSION['login-dosen']['nama_lengkap']=$_POST['nmLengkap']; 
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

	}
}
?>