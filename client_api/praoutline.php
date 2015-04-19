<?php
session_start();

include ("../inc/helper.php");
include ("../inc/gcm_helper.php");
include ("../inc/konfigurasi.php");
include ("../inc/db.pdo.class.php");


$db=new dB($dbsetting);
header('Content-Type: application/json');
if($_POST){
	switch($_POST['act']){
		
		case 'cari':
			//pencarian draft praoutline
			$key=$_POST['keyword'];
			$prodi=$_POST['idprodi'];
			$pecah=explode(" ", $key);
				$jpecah=count($pecah);
				/*if($jpecah==1){*/
					if(ctype_alnum($key)){
						$by=" tp.nim LIKE '%$key%' OR tp.judul LIKE '%$key%' ";
					}else{
						$newkey=str_replace("'", "\'", $key);
						$by=" tp.nim LIKE '%$key%' OR tp.judul LIKE '%$newkey%' ";
					}
					
				/*}else{
					$by="";
					if(ctype_alnum($key)){
						for($x=0;$x<$jpecah;$x++){
							if($x==0){
								$by.=" tp.nim LIKE '%$key%' OR tp.judul like '%$pecah[$x]%' ";
							}else{
								$by.=" tp.nim LIKE '%$key%' OR OR tp.judul like '%$pecah[$x]%' ";
							}
						}
					}else{
						$newpecah=str_replace("'", "\'", $pecah[$x]);
						for($x=0;$x<$jpecah;$x++){
							if($x==0){
								$by.=" tp.nim LIKE '%$key%' OR tp.judul like '%$newpecah[$x]%' ";
							}else{
								$by.=" tp.nim LIKE '%$key%' OR OR tp.judul like '%$newpecah[$x]%' ";
							}
						}
					}
						
				}*/
				$cari="SELECT 
					tp.id,
					tp.nim,
					tp.deskripsi,
					tm.nmLengkap as nama,
					tp.judul,
					tp.tgl_upload,
					tp.wkt_upload,
					tp.status_usulan,
					COUNT(tr.id) as jlhreview,
					COUNT(if(tr.jenis_review='0',1,null)) as komentar,
					COUNT(if(tr.jenis_review='1',1,null)) as putusan,
					COUNT(if(tr.putusan='1',1,null)) as setuju,
					count(if(tr.putusan='0',1,null)) as tdk_setuju
				FROM tbpraoutline tp 
				LEFT JOIN tbreview tr ON (tp.id=tr.idpraoutline)
				JOIN tbmhs tm ON (tp.nim=tm.nim)
				WHERE $by GROUP BY tp.id";

				$db->runQuery($cari);
				if($db->dbRows()>0){
					$response=array();
					$response["data"]=array();
						while($rcari=$db->dbFetch()){
							$draft=array();

							if($rcari['status_usulan']==0){
								$draft['status']='Dalam Proses';
							}else if($rcari['status_usulan']==1){
								$draft['status']='Judul Diterima';
							}else if($rcari['status_usulan']==2){
								$draft['status']='Judul Ditolak';
							}else if($rcari['status_usulan']==3){
								$draft['status']='Judul Gugur';
							}

							$draft['iddraft']=$rcari['id'];
							$draft['judul']=$rcari['judul'];
							$draft['tgl']=tanggalIndo($rcari['tgl_upload'],'j F Y');
							$draft['setuju']=$rcari['setuju']." Setuju";
							$draft['tolak']=$rcari['tdk_setuju']." Tidak Setuju";
							$draft['nim']=$rcari['nim'];
							$draft['namamhs']=$rcari['nama'];
							$draft['jlhrev']=$rcari['jlhreview'];

							array_push($response["data"], $draft);
						}
						$response["success"] = "1";
						$response["msg"] = "Sukses";
						echo json_encode($response);
				}else{
					$response["success"] = "0";
					$response["data"] = null;
					$response["msg"] = "Data Tidak Ada";
					echo json_encode($response);
				}
		break;

		//menampilkan informasi draft praoutline
		case 'lihat':
			$id=$_POST['iddraft'];
			$username=$_POST['username'];
			$iduser=$_POST['iduser'];
			$jenisuser=$_POST['jenisuser'];
			$prodi=$_POST['idprodi'];
			if($id!=""){
				$q="SELECT 
					tp.id,
					tp.nim,
					tp.deskripsi,
					tm.nmLengkap as nama,
					tp.judul,
					tp.tgl_upload,
					tp.wkt_upload,
					tp.berkas,
					tp.status_usulan,
					tm.foto,
					COUNT(tr.id) as jlhreview,
					COUNT(if(tr.jenis_review='0',1,null)) as komentar,
					COUNT(if(tr.jenis_review='1',1,null)) as putusan,
					COUNT(if(tr.putusan='1',1,null)) as setuju,
					COUNT(if(tr.putusan='0',1,null)) as tdk_setuju
				FROM tbpraoutline tp 
				LEFT JOIN tbreview tr ON (tp.id=tr.idpraoutline)
				JOIN tbmhs tm ON (tp.nim=tm.nim)
				WHERE tp.id='$id'";

				$db->runQuery($q);
				if($db->dbRows()>0){
					$r=$db->dbFetch();
					$response=array();
					$response["data"]=array();

					if($r['status_usulan']==0){
						$draft['status']='Dalam Proses';
					}else if($r['status_usulan']==1){
						$draft['status']='Judul Diterima';
					}else if($r['status_usulan']==2){
						$draft['status']='Judul Ditolak';
					}else if($r['status_usulan']==3){
						$draft['status']='Judul Gugur';
					}

					$draft['iddraft']=$r['id'];
					$draft['idprodi']=$r['idProdi'];
					$draft['judul']=$r['judul'];
					$draft['berkas']=DOMAIN_UTAMA."/download.php?doc_id=".$r['id'];
					$draft['tgl']=tanggalIndo($r['tgl_upload'],'j F Y');
					$draft['setuju']=$r['setuju']." Setuju";
					$draft['tolak']=$r['tdk_setuju']." Tidak Setuju";
					$draft['jlhreview']=$r['jlhreview']." Tanggapan";
					$draft['nim']=$r['nim'];
					$draft['kdstatus']=$r['status_usulan'];
					$draft['namamhs']=$r['nama'];
					$draft['foto']=LINK_GAMBAR.$r['foto'];

					$q_rekap_hasil="SELECT *,
					(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=pemb1) as dpemb1,
					(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=pemb2) as dpemb2,
					(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=peng1) as dpeng1,
					(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=peng2) as dpeng2
			 		FROM tbrekaphasil where kep_akhir='".$r['status_usulan']."' AND idpraoutline='".$r['id']."' LIMIT 1";
					$db->runQuery($q_rekap_hasil);
					if($db->dbRows()>0){
						$rkh=$db->dbFetch();
						$draft['kep_judul']=$rkh['judul_final'];
						$draft['kep_pemb1']=$rkh['dpemb1'];
						$draft['kep_pemb2']=$rkh['dpemb2'];
						$draft['kep_peng1']=$rkh['dpeng1'];
						$draft['kep_peng2']=$rkh['dpeng2'];
						$draft['kep_tgl']=tanggalIndo($rkh['tgl_kep']." ".$rkh['wkt_kep'],'j F Y H:i');
						$draft['kep_ket']=($rkh['ket']!="")?$rkh['ket']:"Tidak Ada.";
						$draft['kep_smt']=$rkh['semester'];
						$draft['kep_thn_ajaran']=$rkh['tahun_ajaran'];
					}

					//------------
					//aksi untuk insert ke tmp_notif dan tmp_notif_r untuk judul terbaru dan pemberitahuan terbaru
					if($jenisuser=="K"){
						$jenisuser="D";
					}
					$notifr="UPDATE tmp_notif_r SET `read`='Y' WHERE idkonten='$id' AND idProdi='$prodi' AND user='$username' AND jns_usr='$jenisuser' AND `read`='N'";
					$db->runQuery($notifr);

					$checknotif="SELECT COUNT(id) as jlh FROM tmp_notif WHERE idkonten='$id' AND idProdi='$prodi' AND iduser='$iduser' AND typeuser='$jenisuser' AND jenis='J'";
					$db->runQuery($checknotif);
					$r=$db->dbFetch();
					if($r['jlh']==0){
						$db->runQuery("INSERT INTO tmp_notif SET idkonten='$id', idProdi='$prodi',iduser='$iduser',typeuser='$jenisuser',jenis='J', `date`='".NOW."'");
					}
					//-----------
					$response["success"] = "1";
					$response["msg"] = "Sukses ";
					array_push($response["data"], $draft);
					echo json_encode($response);
				}else{
					$response["success"] = "0";
					$response["data"] = null;
					$response["msg"] = "Data Tidak Ada";
					echo json_encode($response);
				}
			}else{
				$response["success"] = "0";
				$response["data"] = null;
				$response["msg"] = "Request not found";
				echo json_encode($response);
			}
		break;

		//menampilka data review dari draft praoutline
		case 'review':
			$id=$_POST['iddraft'];
			$prodi=$_POST['idprodi'];
			if($id!=""){
				$rev="SELECT tr.*,td.nmLengkap as nmDosen,
					td.foto as ftdosen, 
					tm.nmLengkap as nmMhs,
					tm.foto as ftmhs FROM 
					tbreview tr 
						LEFT JOIN tbdosen td ON (td.nip=tr.reviewer)
						LEFT JOIN tbmhs tm ON (tm.nim=tr.reviewer)
						WHERE tr.idProdi='$prodi'
						GROUP BY tr.id HAVING tr.idpraoutline='".$id."'";
				$db->runQuery($rev);
				if($db->dbRows()>0){
					$response=array();
					$response["data"]=array();
					
					while($r=$db->dbFetch()){
						$review=array();

						if($r['putusan']=='1'){
							$review['putusan']="Setuju";
						}else if($r['putusan']=='0'){
							$review['putusan']="Tidak Setuju";
						}else{
							$review['putusan']="";
						}

						$review['revid']=$r['id'];
						$review['reviewer']=($r['nmMhs']!="")?$r['nmMhs']:$r['nmDosen'];
						$review['revtext']=strip_tags(bbcode_quote($r['review_text'],"webapi"));
						// $review['revwebtext']=bbcode_quote(strip_tags($r['review_text']));
						$review['revwebtext']=bbcode_quote(($r['review_text']));
						$review['revtgl']=tanggalIndo($r['tgl']." ".$r['wkt'],'j F Y H:i');

						array_push($response["data"], $review);
					}
					$response["success"] = "1";
					$response["msg"] = "Sukses";

					echo json_encode($response);

				}else{
					$response["success"] = "0";
					$response["data"] = null;
					$response["msg"] = "Data Tidak Ada";
					echo json_encode($response);
				}
			}else{
				$response["success"] = "0";
				$response["data"] = null;
				$response["msg"] = "Request not found";
				echo json_encode($response);
			}
		break;

		//aksi post tanggapan / review untuk draft praoutline
		case 'postrev':
			$idpraoutline=$_POST['iddraft'];
			$reviewer=$_POST['reviewer'];
			$prodi=$_POST['prodi'];
			$jenisuser=$_POST['juser'];
			$nama_reviewer="";
			$putusan=$_POST['putusan'];
			if($putusan!=""){
				$jenisrev=" jenis_review='1', ";
			}else{
				$jenisrev=" jenis_review='0', ";
				if($putusan!=""){
					$kep="jenis_review='1', putusan='".$putusan."',";
					$check="SELECT id FROM tbreview WHERE idProdi='$prodi' AND idpraoutline='$idpraoutline'
					AND reviewer='$reviewer' AND (putusan IS NOT NULL AND putusan <> '')";
					$db->runQuery($check);
					if($db->dbRows()>0){
						$response["success"] = "0";
						$response["data"] = null;
						$response["msg"] = "Maaf, Anda Telah Memberikan Keputusan pada Draft Praoutline ini";
						echo json_encode($response);
						exit;
					}
				}
			}
			$revtext=$_POST['revtext'];
			if(ctype_digit($idpraoutline)){
				$insert="INSERT INTO tbreview SET
				idpraoutline='".$idpraoutline."',
				idProdi='".$prodi."',
				reviewer='".$reviewer."',
				review_text='".$revtext."',
				putusan='".$putusan."',
				$jenisrev
				tgl='".CURDATE."',
				wkt='".CURTIME."'";

				if($db->runQuery($insert)){
					$response["success"] = "1";
					$response["data"] = null;
					$response["msg"] = "Sukses Menambahkan Tanggapan";
					echo json_encode($response);

					if($jenisuser=="M"){
						$nmq="SELECT nmLengkap FROM tbmhs WHERE nim='$reviewer'";
						$jenis=" jns_usr='D', ";
					}else{
						$nmq="SELECT nmLengkap FROM tbdosen WHERE nip='$reviewer'";
						$jenis=" jns_usr='M', ";
					}
					$db->runQuery($nmq);
					if($db->dbRows()>0){
						$x=$db->dbFetch();
						$nama_reviewer=$x['nmLengkap'];
					}
					
					$notif="SELECT DISTINCT(reviewer),gs.regid 
					FROM tbreview 
					LEFT JOIN gcm_service gs ON (gs.iduser=tbreview.reviewer)
					WHERE reviewer<>'$reviewer' AND idpraoutline='$idpraoutline'";
					//echo $notif;
					$db->runQuery($notif);
					if($db->dbRows()>0){
						$revnama=array();
						$registrationid=array();
						while($r=$db->dbFetch()){
							$revnama[]=$r['reviewer'];
							array_push($registrationid, $r['regid']);
						}
						if(count($revnama)>0){
							for($ss=0;$ss<count($revnama);$ss++){
								$setnotif="INSERT INTO tmp_notif_r SET 
								idkonten='$idpraoutline', 
								idProdi='".$prodi."', 
								user='".$revnama[$ss]."', 
								$jenis
								tgl='".NOW."', 
								msg='".$nama_reviewer." (".$reviewer.") Menambahkan Tanggapan baru', 
								`read`='N'";
								
								$db->runQuery($setnotif);
							}
						//gcm
						//-----------------------------------------------------------------------------
						$isipesan=$nama_reviewer. " Menambahkan Tanggapan Baru";
						$pesan=json_encode(array("jenisnotif"=>"P","pesan"=>$isipesan));
						$message = array("spota" => $pesan);  

						sendPushNotificationToGCM($registrationid, $message);
						//--------------------------------------------------------------------------------
						}
						
					}

				}else{
					$response["success"] = "0";
					$response["data"] = null;
					$response["msg"] = "Gagal Menambahkan Tanggapan, DBError";
					echo json_encode($response);
				}	
			}else{
				$response["success"] = "0";
				$response["data"] = null;
				$response["msg"] = "Request not found la";
				echo json_encode($response);
			}
		break;

		//aksi close draft praoutline
		case 'closedraft':
			$idpraoutline=$_POST['idpraoutline'];
			$nim=$_POST['nim'];
			$putusan=$_POST['putusan'];
			$keterangan=$_POST['ket'];
			$idprodi=$_POST['idprodi'];
			switch ($putusan) {
				case '1':
					$q1="INSERT INTO tbrekaphasil SET 
					idpraoutline='".$idpraoutline."',
					idProdi='".$idprodi."',
					nim='".$nim."',
					kep_akhir='".$putusan."',
					judul_final='".$_POST['judulfinal']."',
					pemb1='".$_POST['pemb1']."',
					pemb2='".$_POST['pemb2']."',
					peng1='".$_POST['peng1']."',
					peng2='".$_POST['peng2']."',
					tgl_kep='".CURDATE."',
					wkt_kep='".CURTIME."',
					semester=(SELECT `values` FROM web_setting WHERE idProdi='".$idprodi."' AND `name`='smt'),
					tahun_ajaran=(SELECT `values` FROM web_setting WHERE idProdi='".$idprodi."' AND `name`='thn_ajaran'),
					ket='".$keterangan."'";

					$notif="INSERT INTO tmp_notif_r SET 
								idkonten='$idpraoutline', 
								idProdi='".$idprodi."', 
								user='".$nim."', 
								jns_usr='M',
								tgl='".NOW."', 
								msg='Usulan Draft Anda Diterima.', 
								`read`='N'";
					$isipesan="Selamat, Draft Praoutline Yang Anda Ajukan Disetujui";
				break;

				case '2':
					$q1="INSERT INTO tbrekaphasil SET 
					idpraoutline='".$idpraoutline."',
					idProdi='".$idprodi."',
					nim='".$nim."',
					kep_akhir='".$putusan."',
					tgl_kep='".CURDATE."',
					wkt_kep='".CURTIME."',
					semester=(SELECT `values` FROM web_setting WHERE idProdi='".$idprodi."' AND `name`='smt'),
					tahun_ajaran=(SELECT `values` FROM web_setting WHERE idProdi='".$idprodi."' AND `name`='thn_ajaran'),
					ket='".$keterangan."'";

					$notif="INSERT INTO tmp_notif_r SET 
								idkonten='$idpraoutline', 
								idProdi='".$idprodi."', 
								user='".$nim."', 
								jns_usr='M',
								tgl='".NOW."', 
								msg='Usulan Draft Anda Ditolak.', 
								`read`='N'";
					$isipesan="Maaf, Draft Praoutline Yang Anda Ajukan Tidak Disetujui";
				break;

				case '3':
					$q1="INSERT INTO tbrekaphasil SET 
					idpraoutline='".$idpraoutline."',
					idProdi='".$idprodi."',
					nim='".$nim."',
					kep_akhir='".$putusan."',
					tgl_kep='".CURDATE."',
					wkt_kep='".CURTIME."',
					semester=(SELECT `values` FROM web_setting WHERE idProdi='".$idprodi."' AND `name`='smt'),
					tahun_ajaran=(SELECT `values` FROM web_setting WHERE idProdi='".$idprodi."' AND `name`='thn_ajaran'),
					ket='".$keterangan."'";

					$notif="INSERT INTO tmp_notif_r SET 
								idkonten='$idpraoutline', 
								idProdi='".$idprodi."', 
								user='".$nim."', 
								jns_usr='M',
								tgl='".NOW."', 
								msg='Usulan Draft Anda Gugur.', 
								`read`='N'";
					$isipesan="Maaf, Draft Praoutline Yang Anda Ajukan Gugur";
				break;
			}

			$q2="UPDATE tbpraoutline SET status_usulan='".$putusan."' WHERE id='".$idpraoutline."' ";
			if($db->runQuery($q1)){
				echo json_encode(array("success"=>"1","data"=>null,"msg"=>"Putusan Draft Praoutline Sukses"));
				$db->runQuery($q2);
				$db->runQuery($notif);
				//gcm
				//-----------------------------------------------------------------------------
				$g="SELECT regid FROM gcm_service WHERE jenisuser IN('M') AND iduser='$nim'";
				$db->runQuery($g);
				$registrationid=array();
				while($r=$db->dbFetch()){
					array_push($registrationid, $r['regid']);
				}
				$pesan=json_encode(array("jenisnotif"=>"P","pesan"=>$isipesan));
				$message = array("spota" => $pesan);  

				sendPushNotificationToGCM($registrationid, $message);
				//--------------------------------------------------------------------------------
			}else{
				echo json_encode(array("success"=>"0","data"=>null,"msg"=>"Aksi Gagal."));
			}
			
		break;

		//aksi mengambil id draft praoutline aktif (untuk mahasiswa) 
		case 'getid':
			$nim=$_POST['nim'];
			if(ctype_alnum($nim)){
				$cq="SELECT id FROM tbpraoutline WHERE nim='$nim' ORDER BY tgl_upload DESC, wkt_upload DESC LIMIT 1";
				$db->runQuery($cq);
				if($db->dbRows()>0){
					$d=$db->dbFetch();
					$idpra=$d['id'];

					$response["success"] = "1";
					$response["data"] = $idpra;
					$response["msg"] = "Sukses";
					echo json_encode($response);

				}else{
					$response["success"] = "0";
					$response["data"] = null;
					$response["msg"] = "Anda Belum Mengupload Draft Praoutline, Silakan Upload Terlebih Dahulu Pada Website SPOTA Teknik Informatika Untan.";
					echo json_encode($response);
				}
			}else{
				$response["success"] = "0";
				$response["data"] = null;
				$response["msg"] = "Request not found";
				echo json_encode($response);
			}
		break;

		//menampilkan daftar draft praoutline yang baru di upload mahasiswa (untuk dosen)
		case 'new':
			$iduser=$_POST['iddosen'];
			$prodi=$_POST['idprodi'];
			$new="SELECT 
					tp.id,
					tp.nim,
					tp.deskripsi,
					tm.nmLengkap as nama,
					tp.judul,
					tp.tgl_upload,
					tp.wkt_upload,
					tp.status_usulan,
					COUNT(tr.id) as jlhreview,
					COUNT(if(tr.jenis_review='0',1,null)) as komentar,
					COUNT(if(tr.jenis_review='1',1,null)) as putusan,
					COUNT(if(tr.putusan='1',1,null)) as setuju,
					count(if(tr.putusan='0',1,null)) as tdk_setuju
				FROM tbpraoutline tp 
				LEFT JOIN tbreview tr ON (tp.id=tr.idpraoutline)
				JOIN tbmhs tm ON (tp.nim=tm.nim)
				WHERE tp.idProdi='$prodi' AND tp.id NOT IN (SELECT idkonten FROM tmp_notif WHERE iduser='$iduser' AND typeuser IN ('D','K'))
				AND tp.status_usulan='0'
				GROUP BY tp.id";

			$db->runQuery($new);
			if($db->dbRows()>0){
				
				$response=array();
				$response["data"]=array();
				while($r=$db->dbFetch()){
					$draft=array();
					if($r['status_usulan']==0){
						$draft['status']='Dalam Proses';
					}else if($r['status_usulan']==1){
						$draft['status']='Judul Diterima';
					}else if($r['status_usulan']==2){
						$draft['status']='Judul Ditolak';
					}else if($r['status_usulan']==3){
						$draft['status']='Judul Gugur';
					}

					$draft['iddraft']=$r['id'];
					$draft['idprodi']=$r['idProdi'];
					$draft['judul']=$r['judul'];
					$draft['berkas']=DOMAIN_UTAMA."/download.php?doc_id=".$r['id'];
					$draft['tgl']=tanggalIndo($r['tgl_upload'],'j F Y');
					$draft['setuju']=$r['setuju']." Setuju";
					$draft['tolak']=$r['tdk_setuju']." Tidak Setuju";
					$draft['jlhreview']=$r['jlhreview']." Tanggapan";
					$draft['nim']=$r['nim'];
					$draft['kdstatus']=$r['status_usulan'];
					$draft['namamhs']=$r['nama'];

					array_push($response["data"], $draft);
				}

				$response["success"] = "1";
				$response["msg"] = "Sukses";
				
				echo json_encode($response);
			}else{
				$response["success"] = "1";
				$response["data"] = null;
				$response["msg"] = "Data Tidak Ada";
				echo json_encode($response);
			}
		break;

		//menampilkan daftar draft praoutline yang siap di close dari batas minimum jumlah setuju
		case 'accepted':
			$prodi=$_POST['idprodi'];
			$new="SELECT 
					tp.id,
					tp.nim,
					tp.deskripsi,
					tm.nmLengkap as nama,
					tp.judul,
					tp.tgl_upload,
					tp.wkt_upload,
					tp.status_usulan,
					COUNT(tr.id) as jlhreview,
					COUNT(if(tr.jenis_review='0',1,null)) as komentar,
					COUNT(if(tr.jenis_review='1',1,null)) as putusan,
					COUNT(if(tr.putusan='1',1,null)) as setuju,
					count(if(tr.putusan='0',1,null)) as tdk_setuju
				FROM tbpraoutline tp 
				LEFT JOIN tbreview tr ON (tp.id=tr.idpraoutline)
				JOIN tbmhs tm ON (tp.nim=tm.nim)
				WHERE tp.idProdi='$prodi' AND tp.status_usulan='0'
				GROUP BY tp.id 
				HAVING (COUNT(if(tr.putusan='1',1,null))) >= (SELECT `values` FROM web_setting WHERE `name`='min_close' AND idProdi='$prodi')";

			$db->runQuery($new);
			if($db->dbRows()>0){
				
				$response=array();
				$response["data"]=array();
				while($r=$db->dbFetch()){
					$draft=array();
					if($r['status_usulan']==0){
						$draft['status']='Dalam Proses';
					}else if($r['status_usulan']==1){
						$draft['status']='Judul Diterima';
					}else if($r['status_usulan']==2){
						$draft['status']='Judul Ditolak';
					}else if($r['status_usulan']==3){
						$draft['status']='Judul Gugur';
					}

					$draft['iddraft']=$r['id'];
					$draft['idprodi']=$r['idProdi'];
					$draft['judul']=$r['judul'];
					$draft['berkas']=DOMAIN_UTAMA."/download.php?doc_id=".$r['id'];
					$draft['tgl']=tanggalIndo($r['tgl_upload'],'j F Y');
					$draft['setuju']=$r['setuju']." Setuju";
					$draft['tolak']=$r['tdk_setuju']." Tidak Setuju";
					$draft['jlhreview']=$r['jlhreview']." Tanggapan";
					$draft['nim']=$r['nim'];
					$draft['kdstatus']=$r['status_usulan'];
					$draft['namamhs']=$r['nama'];

					array_push($response["data"], $draft);
				}

				$response["success"] = "1";
				$response["msg"] = "Sukses";
				
				echo json_encode($response);
			}else{
				$response["success"] = "1";
				$response["data"] = null;
				$response["msg"] = "Data Tidak Ada";
				echo json_encode($response);
			}
		break;

		//menampilkan daftar draft praoutline yang pernah di komentari/ditanggapi oleh dosen
		case 'history':
			$nipdosen=$_POST['nip'];
			$prodi=$_POST['idprodi'];
			//$optional="(SELECT CONCAT(tgl," ",wkt)FROM tbreview WHERE reviewer='$nipdosen' AND idpraoutline=tp.id ORDER BY tgl DESC,wkt DESC LIMIT 1)lastcomment,";
			$history="SELECT 
				tp.id,
				tp.nim,
				tp.deskripsi,
				tm.nmLengkap as nama,
				tp.judul,
				tp.tgl_upload,
				tp.wkt_upload,
				tp.berkas,
				tp.status_usulan,
				COUNT(tr.id) as jlhreview,
				COUNT(if(tr.jenis_review='0',1,null)) as komentar,
				COUNT(if(tr.jenis_review='1',1,null)) as putusan,
				COUNT(if(tr.putusan='1',1,null)) as setuju,
				COUNT(if(tr.putusan='0',1,null)) as tdk_setuju
			FROM tbpraoutline tp 
			LEFT JOIN tbreview tr ON (tp.id=tr.idpraoutline)
			JOIN tbmhs tm ON (tp.nim=tm.nim)
			WHERE tp.idProdi='$prodi' AND tp.id IN 
				(SELECT idpraoutline 
					FROM tbreview 
					WHERE reviewer='$nipdosen')
			GROUP BY tp.id
			ORDER BY (select tgl FROM tbreview where reviewer='$nipdosen' AND idpraoutline=tp.id ORDER BY tgl DESC, wkt DESC LIMIT 1) DESC
			";

			$db->runQuery($history);
			if($db->dbRows()>0){
				$response=array();
				$response["data"]=array();
				while($r=$db->dbFetch()){
					$draft=array();

					if($r['status_usulan']==0){
						$draft['status']='Dalam Proses';
					}else if($r['status_usulan']==1){
						$draft['status']='Judul Diterima';
					}else if($r['status_usulan']==2){
						$draft['status']='Judul Ditolak';
					}else if($r['status_usulan']==3){
						$draft['status']='Judul Gugur';
					}

					$draft['iddraft']=$r['id'];
					$draft['idprodi']=$r['idProdi'];
					$draft['judul']=$r['judul'];
					$draft['berkas']=DOMAIN_UTAMA."/download.php?doc_id=".$r['id'];
					$draft['tgl']=tanggalIndo($r['tgl_upload'],'j F Y');
					$draft['setuju']=$r['setuju']." Setuju";
					$draft['tolak']=$r['tdk_setuju']." Tidak Setuju";
					$draft['jlhreview']=$r['jlhreview']." Tanggapan";
					$draft['nim']=$r['nim'];
					$draft['kdstatus']=$r['status_usulan'];
					$draft['namamhs']=$r['nama'];
					array_push($response["data"], $draft);
				}

				$response["success"] = "1";
				$response["msg"] = "Sukses";
				
				echo json_encode($response);
			}else{
				$response["success"] = "1";
				$response["data"] = null;
				$response["msg"] = "Data Tidak Ada";
				echo json_encode($response);
			}
		break;

		//menampilkan daftar draft praoutline yang pernah di komentari/ditanggapi oleh dosen
		case 'notreviewed':
			$nipdosen=$_POST['nip'];
			$prodi=$_POST['idprodi'];
			$notrev="SELECT 
				tp.id,
				tp.nim,
				tp.deskripsi,
				tm.nmLengkap as nama,
				tp.judul,
				tp.tgl_upload,
				tp.wkt_upload,
				tp.berkas,
				tp.status_usulan,
				COUNT(tr.id) as jlhreview,
				COUNT(if(tr.jenis_review='0',1,null)) as komentar,
				COUNT(if(tr.jenis_review='1',1,null)) as putusan,
				COUNT(if(tr.putusan='1',1,null)) as setuju,
				COUNT(if(tr.putusan='0',1,null)) as tdk_setuju
			FROM tbpraoutline tp 
			LEFT JOIN tbreview tr ON (tp.id=tr.idpraoutline)
			JOIN tbmhs tm ON (tp.nim=tm.nim)
			WHERE tp.idProdi='$prodi' AND tp.status_usulan='0' AND tp.id NOT IN 
				(SELECT idpraoutline 
					FROM tbreview 
					WHERE reviewer='$nipdosen')
			GROUP BY tp.id";

			$db->runQuery($notrev);
			if($db->dbRows()>0){
				$response=array();
				$response["data"]=array();
				while($r=$db->dbFetch()){
					$draft=array();

					if($r['status_usulan']==0){
						$draft['status']='Dalam Proses';
					}else if($r['status_usulan']==1){
						$draft['status']='Judul Diterima';
					}else if($r['status_usulan']==2){
						$draft['status']='Judul Ditolak';
					}else if($r['status_usulan']==3){
						$draft['status']='Judul Gugur';
					}

					$draft['iddraft']=$r['id'];
					$draft['idprodi']=$r['idProdi'];
					$draft['judul']=$r['judul'];
					$draft['berkas']=DOMAIN_UTAMA."/download.php?doc_id=".$r['id'];
					$draft['tgl']=tanggalIndo($r['tgl_upload'],'j F Y');
					$draft['setuju']=$r['setuju']." Setuju";
					$draft['tolak']=$r['tdk_setuju']." Tidak Setuju";
					$draft['jlhreview']=$r['jlhreview']." Tanggapan";
					$draft['nim']=$r['nim'];
					$draft['kdstatus']=$r['status_usulan'];
					$draft['namamhs']=$r['nama'];
					array_push($response["data"], $draft);
				}

				$response["success"] = "1";
				$response["msg"] = "Sukses";
				
				echo json_encode($response);
			}else{
				$response["success"] = "1";
				$response["data"] = null;
				$response["msg"] = "Data Tidak Ada";
				echo json_encode($response);
			}
		break;

		//menampilkan daftar draft praoutline hasil keputusan dimana dosen menjadi salah satu bagian dari team.
		case 'keputusan':
			$nipdosen=$_POST['nip'];
			$prodi=$_POST['idprodi'];
			$kep="SELECT trh.*,
			(SELECT nmLengkap FROM tbdosen WHERE nip=trh.pemb1) as dpemb1,
			(SELECT nmLengkap FROM tbdosen WHERE nip=trh.pemb2) as dpemb2,
			(SELECT nmLengkap FROM tbdosen WHERE nip=trh.peng1) as dpeng1,
			(SELECT nmLengkap FROM tbdosen WHERE nip=trh.peng2) as dpeng2,
			(SELECT nmLengkap FROM tbmhs WHERE nim=trh.nim) as nm_mhs
			FROM tbrekaphasil trh
			WHERE trh.idProdi='$prodi' AND trh.kep_akhir='1' AND (trh.pemb1='$nipdosen' OR trh.pemb2='$nipdosen' OR trh.peng1='$nipdosen' OR trh.peng2='$nipdosen')
			ORDER BY trh.tgl_kep DESC, trh.wkt_kep DESC";

			$db->runQuery($kep);
			if($db->dbRows()>0){
				$response=array();
				$response["data"]=array();
				while($r=$db->dbFetch()){
					$draft=array();

					if($r['pemb1']==$nipdosen){
						$draft['stat_sebagai']='Sebagai Pembimbing 1';
					}
					if($r['pemb2']==$nipdosen){
						$draft['stat_sebagai']='Sebagai Pembimbing 2';
					}
					if($r['peng1']==$nipdosen){
						$draft['stat_sebagai']='Sebagai Penguji 1';
					}
					if($r['peng2']==$nipdosen){
						$draft['stat_sebagai']='Sebagai Penguji 2';
					}

					$draft['iddraft']=$r['idpraoutline'];
					$draft['idprodi']=$r['idProdi'];
					$draft['judul']=$r['judul_final'];
					$draft['tgl']=tanggalIndo($r['tgl_kep']." ".$r['wkt_kep'],'j F Y H:i');
					$draft['nim']=$r['nim'];
					$draft['namamhs']=$r['nm_mhs'];
					array_push($response["data"], $draft);
				}

				$response["success"] = "1";
				$response["msg"] = "Sukses";
				
				echo json_encode($response);
			}else{
				$response["success"] = "1";
				$response["data"] = null;
				$response["msg"] = "Data Tidak Ada";
				echo json_encode($response);
			}
		break;
		
		default:
			$response["success"] = "0";
			$response["data"] = null;
			$response["msg"] = "Request not found";
			echo json_encode($response);
		break;

	}
}else{
	$response["success"] = "0";
	$response["data"] = null;
	$response["msg"] = "Request not found";
	echo json_encode($response);
}