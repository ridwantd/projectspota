<?php
session_start();
if($_SESSION['login-mhs']){
if($_POST){
	include ("../../../inc/helper.php");
	include ("../../../inc/konfigurasi.php");
	include ("../../../inc/db.pdo.class.php");

	$db=new dB($dbsetting);

	switch($_POST['act']){

		case 'upload':
			$query = "SHOW TABLE STATUS LIKE 'tbpraoutline'";
			$db->runQuery($query);
			$data  = $db->dbFetch();
			$newID = $data['Auto_increment'];
			$nim=$_SESSION['login-mhs']['nim'];

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

				if(!$ext=='pdf'){
					echo json_encode(array("result"=>false,"msg"=>"Hanya Mendukung file pdf"));
						exit;
				}

				$pathfile=$dir.$newID."-".$nim.".".$ext;

				if (move_uploaded_file($tmpname,$pathfile)){
					$query="INSERT INTO tbpraoutline SET
					id='$newID',
					nim='$nim',
					judul='".$_POST['judul']."',
					deskripsi='".$_POST['deskripsi']."',
					berkas='".$newID."-".$nim.".".$ext."',
					idProdi='".$_SESSION['login-mhs']['prodi']."',
					tgl_upload=CURDATE(),
					wkt_upload=CURTIME()
					";
					if(!$db->runQuery($query)){
						echo json_encode(array("result"=>false,"msg"=>"Upload Berkas Gagal DbError"));
						@unlink($pathfile);
						exit;
					}else{
						echo json_encode(array("result"=>true,"msg"=>"Upload Desain Praoutline Berhasil"));
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
					tgl=CURDATE(),
					wkt=CURTIME()";

					if($db->runQuery($insert)){
						echo json_encode(array("result"=>true,"msg"=>"Sukses Menambahkan Tanggapan"));
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
				$by=" tp.nim LIKE '%$key%' ";
			}else{
				$pecah=explode(" ", $key);
				$jpecah=count($pecah);
				if($jpecah==1){
					$by=" tp.judul LIKE '%$key%' ";
				}else{
					$by="";
					for($x=0;$x<$jpecah;$x++){
						if($x==0){
							$by.=" tp.judul like '%$pecah[$x]%' ";
						}else{
							$by.=" OR tp.judul like '%$pecah[$x]%' ";
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
				COUNT(if(tr.jenis_review=0,1,null)) as komentar,
				COUNT(if(tr.jenis_review=1,1,null)) as putusan,
				COUNT(if(tr.putusan=1,1,null)) as setuju,
				count(if(tr.putusan=0,1,null)) as tdk_setuju
			FROM tbpraoutline tp 
			JOIN tbreview tr ON (tp.id=tr.idpraoutline)
			JOIN tbmhs tm ON (tp.nim=tm.nim)
			WHERE $by GROUP BY tp.id";

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
							<p><h4 style="text-align:left;margin-top:0"><a href="?page=praoutline&menu=review&nim=<?php echo $rcari['nim'];?>"><?php echo strtoupper($rcari['judul']);?></a></h4></p>
							<?php echo substr($rcari['deskripsi'],0,200).' ...';?>
							<div class="row">
								<div class="col-sm-8">
									<p>Oleh <?php echo $rcari['nama']." (".$rcari['nim'].")". $statusPraoutline;?> - <a class="btn btn-xs btn-bricky" href="#"><i class="fa fa-trash-o"></i>Download File</a></p>
								</div>
								<div class="col-sm-4 text-right">
									<p>Jumlah Review : <span class="badge badge-info"><?php echo $rcari['jlhreview'];?></span> | Setuju : <span class="badge badge-success"><?php echo $rcari['setuju'];?></span> | Tidak Setuju : <span class="badge badge-danger"><?php echo $rcari['tdk_setuju'];?></span></p>
								</div><hr/>
							</div>
							<?php if($rcari['status_usulan']==1){ 
								$kep_final="SELECT * FROM tbrekaphasil WHERE idProdi='".$_SESSION['login-mhs']['prodi']."' AND idpraoutline='".$rcari['id']."' LIMIT 1";
								$db->runQuery($kep_final);
								if($db->dbRows()==0){
									$kep=$db->dbFetch();
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
												Pembimbing 1 : <?php echo $kep['pemb1'];?> <br/>
												Pembimbing 2 : <?php echo $kep['pemb2'];?> <br/>
												Penguji 1 : <?php echo $kep['peng1'];?> <br/>
												Penguji 2 : <?php echo $kep['peng2'];?>
											</div>
											<div class="col-sm-4">
												<strong><u>Judul Outline</u></strong><br/>
												<?php echo $kep['judul_final']; ?>
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