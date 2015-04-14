<?php
session_start();
if($_POST){
	include ("../../../inc/helper.php");
	include ("../../../inc/konfigurasi.php");
	include ("../../../inc/db.pdo.class.php");

	$db=new dB($dbsetting);

	switch($_POST['act']){
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