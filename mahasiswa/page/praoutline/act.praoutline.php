<?php
session_start();
if($_SESSION['login-mhs']){
if($_POST){
	include ("../../../inc/helper.php");
	include ("../../../inc/gcm_helper.php");
	include ("../../../inc/konfigurasi.php");
	include ("../../../inc/db.pdo.class.php");

	$db=new dB($dbsetting);
	$db2=new dB($dbsetting);

	switch($_POST['act']){

		case 'upload':
			$query = "SHOW TABLE STATUS LIKE 'tbpraoutline'";
			$db->runQuery($query);
			$data  = $db->dbFetch();
			$newID = $data['Auto_increment'];
			$nim=$_SESSION['login-mhs']['nim'];

			//cek apakah draft sudah terupload sebelumnya
			$check="SELECT id FROM tbpraoutline WHERE nim='$nim' AND status_usulan IN ('0','1')";
			$db->runQuery($check);
			if($db->dbRows()>0){
				echo json_encode(array("result"=>false,"msg"=>"Draft Praoutline Anda Telah DiUpload."));
				exit;
			}

			if(!isset($_FILES['berkas']) || !is_uploaded_file($_FILES['berkas']['tmp_name'])){
				echo json_encode(array("result"=>false,"msg"=>"Pastikan File  Sudah dipilih"));
				exit;
			}else{
				$dir=LAMPIRAN_FILE;

				//$supportlist=array('pdf','zip','doc','docx'); 
				$namaberkas=$_FILES['berkas']['name'];
				$type=$_FILES['berkas']['type'];
				$tmpname=$_FILES['berkas']['tmp_name'];
				$ext=get_ext($namaberkas);

				if($ext!='pdf'){
					echo json_encode(array("result"=>false,"msg"=>"Hanya Mendukung file pdf"));
						exit;
				}

				$pathfile=$dir.$newID."-".$nim.".".$ext;
				//echo $pathfile;
				if (move_uploaded_file($tmpname,$pathfile)){
					$query="INSERT INTO tbpraoutline SET
					id='$newID',
					nim='$nim',
					judul='".$_POST['judul']."',
					deskripsi='".$_POST['deskripsi']."',
					berkas='".$newID."-".$nim.".".$ext."',
					idProdi='".$_SESSION['login-mhs']['prodi']."',
					semester=(SELECT `values` FROM web_setting WHERE idProdi='".$_SESSION['login-mhs']['prodi']."' AND `name`='smt'),
					thn_ajaran=(SELECT `values` FROM web_setting WHERE idProdi='".$_SESSION['login-mhs']['prodi']."' AND `name`='thn_ajaran'),
					tgl_upload='".CURDATE."',
					wkt_upload='".CURTIME."'
					";
					//echo $query;
					if(!$db->runQuery($query)){
						echo json_encode(array("result"=>false,"msg"=>"Upload Berkas Gagal DbError"));
						@unlink($pathfile);
						exit;
					}else{
						echo json_encode(array("result"=>true,"msg"=>"Upload Desain Praoutline Berhasil"));
						//notif gcm
						//-----------------------------------------------------------------------------
						$g="SELECT regid FROM gcm_service WHERE jenisuser IN('D','K')";
						$db->runQuery($g);
						$registrationid=array();
						while($r=$db->dbFetch()){
							array_push($registrationid, $r['regid']);
						}
						$isipesan="Terdapat Draft Praoutline Terbaru";
						$pesan=json_encode(array("jenisnotif"=>"J","pesan"=>$isipesan));
						$message = array("spota" => $pesan);  

						sendPushNotificationToGCM($registrationid, $message);
						//--------------------------------------------------------------------------------
					}
				}else{
					echo json_encode(array("result"=>false,"msg"=>"Upload Berkas Gagal"));
					exit;
				}

			}	
		break;

		case 'post_review':
			$idpraoutline=$_POST['idpra'];
			$nim=$_SESSION['login-mhs']['nim'];
			$prodi=$_SESSION['login-mhs']['prodi'];
			if(ctype_digit($idpraoutline)){
				if($_POST['text_review']==""){
					echo json_encode(array("result"=>false,"msg"=>"Tanggapan harus diisi"));
				}else{
					$insert="INSERT INTO tbreview SET
					idpraoutline='".$idpraoutline."',
					idProdi='".$prodi."',
					reviewer='".$nim."',
					review_text='".$_POST['text_review']."',
					jenis_review='0',
					tgl='".CURDATE."',
					wkt='".CURTIME."'";

					if($db->runQuery($insert)){
						echo json_encode(array("result"=>true,"msg"=>"Sukses Menambahkan Tanggapan"));	
						if(count($_SESSION['selected_user'])>0){
							//print_r($_SESSION['selected_user']);
							$selecteduser="";
							for($xx=0;$xx<count($_SESSION['selected_user']);$xx++){
								$notif="INSERT INTO tmp_notif_r SET 
								idkonten='$idpraoutline', 
								idProdi='".$_SESSION['login-mhs']['prodi']."', 
								user='".$_SESSION['selected_user'][$xx]."', 
								jns_usr='D',
								tgl='".NOW."', 
								msg='".$_SESSION['login-mhs']['nama_lengkap']." (".$_SESSION['login-mhs']['nim'].") Menambahkan Tanggapan baru', 
								`read`='N'";
								//echo $notif;
								$db->runQuery($notif);
								if($xx==0){
									$selecteduser.="'".$_SESSION['selected_user'][$xx]."'";
								}else{
									$selecteduser.=",'".$_SESSION['selected_user'][$xx]."'";
								}
							}
							//notif gcm
							//-----------------------------------------------------------------------------
							$g="SELECT regid FROM gcm_service WHERE iduser IN($selecteduser) AND jenisuser IN('D','K')";
							$db->runQuery($g);
							if($db->dbRows()>0){
								$registrationid=array();
								while($r=$db->dbFetch()){
									array_push($registrationid, $r['regid']);
								}
								$isipesan=$_SESSION['login-mhs']['nama_lengkap']." Menambahkan Tanggapan baru";
								$pesan=json_encode(array("jenisnotif"=>"P","pesan"=>$isipesan));
								$message = array("spota" => $pesan);  

								sendPushNotificationToGCM($registrationid, $message);
							}
							//--------------------------------------------------------------------------------	
						}
					}else{
						echo json_encode(array("result"=>false,"msg"=>"Gagal Menambahkan Tanggapan, DBError"));
					}
				}
			}
		break;

		case 'cari':
			$key=$_POST['key'];
			$jenis=$_POST['by'];
			if($jenis=='nim'){
				if(ctype_alnum($key)){
					$by=" tp.nim LIKE '%$key%' ";
				}else{
					$newkey=str_replace("'", "\'", $key);
					$by=" tp.nim LIKE '%$newkey%' ";
				}
				
			}else{
				$pecah=explode(" ", $key);
				$jpecah=count($pecah);
				if($jpecah==1){
					if(ctype_alnum($key)){
						$by=" tp.judul LIKE '%$key%' ";
					}else{
						$newkey=str_replace("'", "\'", $key);
						$by=" tp.judul LIKE '%$newkey%' ";
					}
					
				}else{
					$by="";
					if(ctype_alnum($key)){
						for($x=0;$x<$jpecah;$x++){
							if($x==0){
								$by.=" tp.judul like '%$pecah[$x]%' ";
							}else{
								$by.=" OR tp.judul like '%$pecah[$x]%' ";
							}
						}
					}else{
						$newpecah=str_replace("'", "\'", $pecah[$x]);
						for($x=0;$x<$jpecah;$x++){
							if($x==0){
								$by.=" tp.judul like '%$newpecah[$x]%' ";
							}else{
								$by.=" OR tp.judul like '%$newpecah[$x]%' ";
							}
						}
					}
						
				}		
			}
			//include "result-cari.php";
			/*$cari="SELECT * FROM tbpraoutline WHERE $by ORDER BY tgl_upload,wkt_upload,nim,judul";*/
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

			/*$cari="SELECT 
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
				count(if(tr.putusan='0',1,null)) as tdk_setuju,
				(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=trh.pemb1) as dpemb1,
				(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=trh.pemb2) as dpemb2,
				(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=trh.peng1) as dpeng1,
				(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=trh.peng2) as dpeng2
			FROM tbpraoutline tp 
			LEFT JOIN tbreview tr ON (tp.id=tr.idpraoutline)
			LEFT JOIN tbrekaphasil trh ON (tp.id=trh.idpraoutline)
			JOIN tbmhs tm ON (tp.nim=tm.nim)
			WHERE $by GROUP BY tp.id";*/

			//echo $cari;
			$db->runQuery($cari);
			if($db->dbRows()>0){
				?>
				<h3>Hasil Pencarian '<?php echo $key;?>'</h3>
					<hr>
					<?php 
					while($rcari=$db->dbFetch()){
						if($rcari['status_usulan']==0){
							$statusPraoutline=' - <span class="label label-default">Dalam Proses</span>';
						}else if($rcari['status_usulan']==1){
							$statusPraoutline=' - <span class="label label-success">Judul Diterima</span>';
						}else if($rcari['status_usulan']==2){
							$statusPraoutline=' - <span class="label label-danger">Judul Ditolak</span>';
						}else if($rcari['status_usulan']==3){
							$statusPraoutline=' - <span class="label label-danger">Judul Gugur</span>';
						}
					?>
					<div class="row">
						<div class="col-sm-12">	
							<p><h4 style="text-align:left;margin-top:0"><a href="?page=praoutline&menu=review&prid=<?php echo $rcari['id'];?>"><?php echo strtoupper($rcari['judul']);?></a></h4></p>
							<?php echo substr($rcari['deskripsi'],0,200).' ...';?>
							<div class="row">
								<div class="col-sm-8">
									<p>Oleh <?php echo $rcari['nama']." (".$rcari['nim'].")". $statusPraoutline;?> - <a class="btn btn-xs btn-bricky" href="#"><i class="fa fa-trash-o"></i>Download File</a></p>
								</div>
								<div class="col-sm-4 text-right">
									<p>Jumlah Review : <span class="badge badge-info"><?php echo $rcari['jlhreview'];?></span> | Setuju : <span class="badge badge-success"><?php echo $rcari['setuju'];?></span> | Tidak Setuju : <span class="badge badge-danger"><?php echo $rcari['tdk_setuju'];?></span></p>
								</div><hr/>
							</div>
							<?php switch($rcari['status_usulan']){
								case '1': 
								$kep_final="SELECT *,
								(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=pemb1) as dpemb1,
								(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=pemb2) as dpemb2,
								(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=peng1) as dpeng1,
								(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=peng2) as dpeng2
								 FROM tbrekaphasil WHERE idProdi='".$_SESSION['login-mhs']['prodi']."' AND idpraoutline='".$rcari['id']."' LIMIT 1";
								$db2->runQuery($kep_final);
								if($db2->dbRows()>0){
									$kep=$db2->dbFetch();
									?>
									<div class="alert alert-block alert-info">
										<!-- <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Info!</h4> -->
										<div class="row">
											<div class="col-sm-3">
												<strong><u>Ditetapkan</u></strong> <br/>
												Tanggal : <?php echo tanggalIndo($kep['tgl_kep'],'j F Y');?> <br/>
												Waktu : <?php echo substr($kep['wkt_kep'],0,5);?> <br/>
												Semester : <?php echo $kep['semester'];?> <br/>
												Tahun Akademik : <?php echo $kep['tahun_ajaran'];?>
											</div>
											<div class="col-sm-4">
												<strong><u>Dosen Pembimbing & Penguji</u></strong><br/>
												Pembimbing 1 : <?php echo $kep['dpemb1'];?> <br/>
												Pembimbing 2 : <?php echo $kep['dpemb2'];?> <br/>
												Penguji 1 : <?php echo $kep['dpeng1'];?> <br/>
												Penguji 2 : <?php echo $kep['dpeng2'];?>
											</div>
											<div class="col-sm-4">
												<strong><u>Judul Outline</u></strong><br/>
												<?php echo $kep['judul_final']; ?>
												<strong><u>Catatan</u></strong><br/>
												<?php echo $kep['ket']; ?>
											</div>
										</div>
									</div>
									<?php
								}else{
									echo '<div class="alert alert-danger">
											<i class="clip-cancel-circle"></i>
											<strong>Maaf!</strong> Data Tidak Ditemukan..
										</div>';
								}

								break;

								case '2':
								break;
							} 
							?>
						</div>
					</div>
					<?php
					}
					?>
				<?php
			}else{
				echo '<div class="alert alert-danger">
						<i class="clip-cancel-circle"></i>
						<strong>Maaf!</strong> Data Tidak Ditemukan..
					</div>';
			}
		break;
	}
}
}
?>