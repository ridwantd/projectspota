<?php
session_start();
if($_POST){
	include ("../../../inc/helper.php");
	include ("../../../inc/konfigurasi.php");
	include ("../../../inc/db.pdo.class.php");

	$db=new dB($dbsetting);

	switch($_POST['act']){
		case 'insert':
			$idprodi=$_SESSION['login-admin']['prodi'];
			if($_POST['draft']=="yes"){
				$draft="publish='N',";
				$msg="Jadwal disimpan sebagai draft";
			}else{
				$draft="publish='Y',";
				$msg="Jadwal telah diterbitkan.";
			}
			$tgl=explode("-", $_POST['tgl']);
			$wkt=$_POST['wkt'].':00';
			$waktu=$tgl[2]."-".$tgl[1]."-".$tgl[0]." ".$wkt;
			$start="start='".$waktu."',";
			$end="end='0000-00-00 00:00:00',";

			$query="INSERT into tbjadwal 
			SET 
			idProdi='".$idprodi."',
			idMhs='".$_POST['idmhs']."',
			judul='".$_POST['judul']."',
			ruangan='".$_POST['ruangan']."',
			jenis='".$_POST['jenis']."',
			$start
			$end
			$draft
			pemb1='".$_POST['pemb1']."',
			pemb2='".$_POST['pemb2']."',
			peng1='".$_POST['peng1']."',
			peng2='".$_POST['peng2']."'	";
			//echo $query;
			if($db->runQuery($query)){ 
				echo json_encode(array("result"=>true,"msg"=>$msg));
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Aksi Gagal DbError"));
				exit;
			}
			
		break;

		case 'update':
			$idjadwal=$_POST['idjadwal'];
			if(ctype_digit($idjadwal)){
				$idprodi=$_SESSION['login-admin']['prodi'];
				if($_POST['draft']=="yes"){
					$draft="publish='N',";
					$msg="Jadwal disimpan sebagai draft";
				}else{
					$draft="publish='Y',";
					$msg="Jadwal telah diupdate.";
				}
				$tgl=explode("-", $_POST['tgl']);
				$wkt=$_POST['wkt'].':00';
				$waktu=$tgl[2]."-".$tgl[1]."-".$tgl[0]." ".$wkt;
				$start="start='".$waktu."',";
				$end="end='0000-00-00 00:00:00',";

				$update="UPDATE tbjadwal 
					SET 
					idMhs='".$_POST['idmhs']."',
					judul='".$_POST['judul']."',
					ruangan='".$_POST['ruangan']."',
					jenis='".$_POST['jenis']."',
					$start
					$end
					$draft
					pemb1='".$_POST['pemb1']."',
					pemb2='".$_POST['pemb2']."',
					peng1='".$_POST['peng1']."',
					peng2='".$_POST['peng2']."'	
				WHERE id='$idjadwal'";

				//echo $update;
				if($db->runQuery($update)){
					echo json_encode(array("result"=>true,"msg"=>$msg));
				}else{
					@unlink($thumb_DestRandImageName);
					echo json_encode(array("result"=>false,"msg"=>"Aksi Gagal DBError"));
				}
			}
		break;

		case 'publish':
			$idjadwal=$_POST['idjadwal'];
			if(ctype_digit($idjadwal)){
				$pub="UPDATE tbjadwal SET publish='Y' WHERE id='$idjadwal'";
				//echo $pub;
				if($db->runQuery($pub)){
					echo json_encode(array("result"=>true,"msg"=>"Jadwal Telah diterbitkan"));
				}else{
					echo json_encode(array("result"=>false,"msg"=>"Aksi Gagal, DBerror."));
				}
			}
		break;

		case 'hapusjadwal':
			$idjadwal=$_POST['jadwal'];
			if(ctype_digit($idjadwal)){
				$del_pengumuman="DELETE FROM tbjadwal WHERE id='$idjadwal'";
				if($db->runQuery($del_pengumuman)){
					echo json_encode(array("result"=>true,"msg"=>"Jadwal telah berhasil dihapus"));
				}else{
					echo json_encode(array("result"=>false,"msg"=>"Aksi Gagal, DBerror."));
				}
			}
		break;

		case 'detailjadwal':
			$id=$_POST['id'];
			if(ctype_digit($id)){
				$q="SELECT tj.*,tm.nmLengkap, tm.nim, tp.nmProdi
				FROM tbjadwal tj 
				LEFT JOIN tbmhs tm ON(tm.idmhs=tj.idMhs)
				LEFT JOIN tbprodi tp ON(tp.idProdi=tj.idProdi) 
				WHERE tj.id='$id'";

				$db->runQuery($q);
				if($db->dbRows()>0){
					$r=$db->dbFetch();
					$nama=$r['nmLengkap'];
					$nim=$r['nim'];
					$judul_skripsi=$r['judul'];
					$ruangan=$r['ruangan'];
					$jenis=$r['jenis'];
					$pemb1=$r['pemb1'];
					$pemb2=$r['pemb2'];
					$peng1=$r['peng1'];
					$peng2=$r['peng2'];
					$start=explode(" ", $r['start']);
					$tgl=tanggalIndo($start[0], "j F Y");
					$wkt=$start[1];
					echo json_encode(array(
						"result"=>true,
						"msg"=>"Sukses",
						"nama"=>$nama,
						"nim"=>$nim,
						"judul"=>$judul_skripsi,
						"jenis"=>strtoupper($jenis),
						"ruangan"=>$ruangan,
						"pemb1"=>$pemb1,
						"pemb2"=>$pemb2,
						"peng1"=>$peng1,
						"peng2"=>$peng2,
						"tgl"=>$tgl,
						"wkt"=>$wkt,
						));
				}else{
					echo json_encode(array("result"=>false,"msg"=>"Data Tidak Ditemukan"));
				}
			}
		break;
	}
}

?>