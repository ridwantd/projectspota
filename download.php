<?php
session_start();
include ("inc/helper.php");
include ("inc/konfigurasi.php");
include ("inc/db.pdo.class.php");

$db=new dB($dbsetting);

switch($_GET['j']){

	default:
	$id=$_GET['doc_id'];
	if(ctype_digit($id)){
		$q="SELECT id,nim,berkas FROM tbpraoutline WHERE id='$id' LIMIT 1";
		$db->runQuery($q);
		if($db->dbRows()>0){
			$r=$db->dbFetch();
			$berkas=$r['berkas'];
			$nim=$r['nim'];
			if(file_exists(LAMPIRAN_FILE.$berkas)){
				header("Content-Disposition: attachment; filename=spota_".$berkas);
				header("Content-length: ".filesize(LAMPIRAN_FILE.$berkas));
				header("Content-type: application/pdf");
				$fp  = fopen(LAMPIRAN_FILE.$berkas, 'r');
			   	$content = fread($fp, filesize(LAMPIRAN_FILE.$berkas));
			   	fclose($fp);
				echo $content;
				
			}
		}else{
			echo "data tidak ditemukan";
		}
	}
	break;

	case 'diskusi':
		$id=$_GET['rev'];
		if(ctype_digit($id)){
			$q="SELECT idRev,file_lamp,type_filelamp FROM tbreviewdiskusi WHERE idRev='$id' LIMIT 1";
			$db->runQuery($q);
			if($db->dbRows()>0){
				$r=$db->dbFetch();
				$berkas=$r['file_lamp'];
				$tipeberkas=$r['type_filelamp'];
				if(file_exists(LAMPIRAN_FILE.$berkas)){
					header("Content-Disposition: attachment; filename=spota_".$berkas);
					header("Content-length: ".filesize(LAMPIRAN_FILE.$berkas));
					header("Content-type:".$tipeberkas);
					$fp  = fopen(LAMPIRAN_FILE.$berkas, 'r');
				   	$content = fread($fp, filesize(LAMPIRAN_FILE.$berkas));
				   	fclose($fp);
					echo $content;
					
				}
			}else{
				echo "data tidak ditemukan";
			}
		}
	break;
}
?>