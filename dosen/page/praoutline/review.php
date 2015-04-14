<?php $db=new dB($dbsetting); ?>
<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-home-3"></i>
				<a href="<?php echo DOSEN_PAGE;?>">
					Home
				</a>
			</li>
			<!-- <li>
				<a href="<?php echo DOSEN_PAGE;?>dashboard.php?page=praoutline&menu=cari">
					Pencarian
				</a>
			</li> -->								
			<li class="active">
				Review
			</li>
			<li class="search-box">
				<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
			</li>			
		</ol>
		<div class="page-header">
			<h1>Review <?php echo($_GET['nim']!="")?"<small>".$_GET['nim']."</small>":"";?><small></small></h1>
		</div>
	</div>
</div>
<?php
$nip=$_SESSION['login-dosen']['nip'];
unset($_SESSION['selected_user']);
$where=" WHERE ";
if(isset($_GET['prid'])){
//tampilan review dari hasil pencarian
$idpra=$_GET['prid'];
if(!ctype_digit($idpra)){
	$idpra='0';	
}
$where.=" tp.id='$idpra' ";
$checkpraoutline="SELECT id,nim, ((SELECT count(id) FROM tmp_notif WHERE iduser='".$_SESSION['login-dosen']['id']."' AND typeuser='D' AND jenis='J' AND idkonten=tbpraoutline.id)) as found FROM tbpraoutline WHERE id='$idpra' LIMIT 1";

//$checkpraoutline="SELECT id FROM tbpraoutline WHERE status_usulan='0' AND nim='$nim' LIMIT 1";
$db->runQuery($checkpraoutline);
if($db->dbRows()>0){
	$fromtp=$db->dbFetch();
	$selectednim=$fromtp['nim'];// nim dari praoutline
	$selectedid=$fromtp['id'];

	//menghilangkan notif
	if(count($_SESSION['new_review_dsn'][$idpra])>0){
		$id_notif_r=implode(",",$_SESSION['new_review_dsn'][$idpra]);
		$db->runQuery("UPDATE tmp_notif_r SET `read`='Y' WHERE id IN ($id_notif_r)");
	}

	if($fromtp['found']=='0'){
		$in="INSERT INTO tmp_notif SET idkonten='".$selectedid."', idProdi='".$_SESSION['login-dosen']['prodi']."', iduser='".$_SESSION['login-dosen']['id']."', typeuser='D', `date`=NOW(), jenis='J'";
		$db->runQuery($in);
		//echo $in;
	}
	if(!isset($_GET['prid'])){
		$where.="tp.nim='$selectednim' AND tp.id='$selectedid'";
	}

	$stat_judul="SELECT 
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
		COUNT(if(tr.putusan='0',1,null)) as tdk_setuju
	FROM tbpraoutline tp 
	LEFT JOIN tbreview tr ON (tp.id=tr.idpraoutline)
	JOIN tbmhs tm ON (tp.nim=tm.nim)
	$where GROUP BY tp.id";

	$db->runQuery($stat_judul);
	if($db->dbRows()>0){
		$stat=$db->dbFetch();

		$_SESSION['selected_user']=array();
		$_SESSION['selected_user'][]=$selectednim;

		if($stat['status_usulan']==0){
			$statusPraoutline=' - <span class="label label-default">Dalam Proses</span>';
		}else if($stat['status_usulan']==1){
			$statusPraoutline=' - <span class="label label-success">Judul Diterima</span>';
		}else if($stat['status_usulan']==2){
			$statusPraoutline=' - <span class="label label-danger">Judul Ditolak</span>';
		}else if($stat['status_usulan']==3){
			$statusPraoutline=' - <span class="label label-danger">Judul Gugur</span>';
		}	
	?>
	<div class="row">
		<div class="col-sm-12">	
			<p><h3 style="text-align:left;margin-top:0"><?php echo strtoupper($stat['judul']);?></h3></p>
			<?php echo $stat['deskripsi'];?>
			<div class="row">
				<div class="col-sm-8">
					<p>Oleh : <?php echo $stat['nama']." (".$stat['nim'].")". $statusPraoutline;?> - <a class="btn btn-xs btn-bricky" href="<?php echo DOMAIN_UTAMA."/download.php?doc_id=".$stat['id'];?>"><i class="fa fa-trash-o"></i>Download File</a></p>
				</div>
				<div class="col-sm-4 text-right">
					<p>Jumlah Review : <span class="badge badge-info"><?php echo $stat['jlhreview'];?></span> | Setuju : <span class="badge badge-success"><?php echo $stat['setuju'];?></span> | Tidak Setuju : <span class="badge badge-danger"><?php echo $stat['tdk_setuju'];?></span></p>
				</div><hr/>
			</div>
	<!-- 		UNTUK JUDUL YG SUDAH DI CLOSE  -->
			<?php 
			$kep_final="SELECT *,
			(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=pemb1) as dpemb1,
			(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=pemb2) as dpemb2,
			(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=peng1) as dpeng1,
			(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=peng2) as dpeng2 FROM tbrekaphasil WHERE idProdi='".$_SESSION['login-dosen']['prodi']."' AND idpraoutline='".$stat['id']."' AND kep_akhir='".$stat['status_usulan']."' LIMIT 1";
			switch($stat['status_usulan']){
				case '1': 
				//echo $kep_final;
					$db->runQuery($kep_final);
					if($db->dbRows()>0){
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
									Pembimbing 1 : <?php echo $kep['dpemb1'];?> <br/>
									Pembimbing 2 : <?php echo $kep['dpemb2'];?> <br/>
									Penguji 1 : <?php echo $kep['dpeng1'];?> <br/>
									Penguji 2 : <?php echo $kep['dpeng2'];?>
								</div>
								<div class="col-sm-4">
									<strong><u>Judul Outline</u></strong><br/>
									<?php echo $kep['judul_final']; ?><br/>
									<strong><u>Catatan</u></strong><br/>
									<?php echo $kep['ket']; ?>
								</div>
							</div>
						</div>
						<?php
					}/*else{
						echo '<div class="alert alert-danger">
								<i class="clip-cancel-circle"></i>
								<strong>Maaf!</strong> Data Tidak Ditemukan..
							</div>';
					}*/
				break;

				case '2':
					$db->runQuery($kep_final);
					if($db->dbRows()>0){
					$tolak=$db->dbFetch();
					?>
					<div class="alert alert-block alert-danger">
						<div class="row">
							<div class="col-sm-3">
								<strong><u>Ditetapkan</u></strong> <br/>
								Tanggal : <?php echo tanggalIndo($tolak['tgl_kep'],'j F Y');?> <br/>
								Waktu : <?php echo substr($tolak['wkt_kep'],0,5);?> <br/>
							</div>
							<div class="col-sm-9">
								<strong><u>Catatan</u></strong><br/>
								<?php echo $tolak['ket']; ?>
							</div>
						</div>
					</div>
					<?php	
					}
				break;
			} 
			?>
		</div>
	</div>
	<?php
		if($stat['jlhreview']>0){
		?>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<?php
							$rev="SELECT tr.*,td.nmLengkap as nmDosen,td.foto as ftdosen, tm.nmLengkap as nmMhs,tm.foto as ftmhs FROM tbreview tr 
							LEFT JOIN tbdosen td ON (td.nip=tr.reviewer)
							LEFT JOIN tbmhs tm ON (tm.nim=tr.reviewer)
							GROUP BY tr.id HAVING tr.idpraoutline='".$stat['id']."'";
							//echo $rev;
							$db->runQuery($rev);
							if($db->dbRows()>0){
								echo '<ol class="discussion">';
								while($r=$db->dbFetch()){
									if($r['reviewer']==$selectednim){
										$jenis="self";
										$nama='<div style="padding-bottom:5px;"><span style="float:right"><small class="label label-info">'.$r['nmMhs'].'</small> <small class="label label-inverse" style="cursor:pointer;" onclick="location.href=\'?page=praoutline&menu=review&prid='.$_GET['prid'].'&quote='.$r['id'].'#post_review\'">Quote</small></span></div>';
										$foto=$r['ftmhs'];
										if(!in_array($r['reviewer'], $_SESSION['selected_user'])){
											$_SESSION['selected_user'][]=$r['reviewer'];
										}
									}else{
										$jenis="other";
										$nama='<div style="padding-bottom:5px;"><small class="label label-info">'.$r['nmDosen'].'</small>  <small class="label label-inverse"><span style="cursor:pointer" onclick="location.href=\'?page=praoutline&menu=review&prid='.$_GET['prid'].'&quote='.$r['id'].'#post_review\'">Quote</span></small></div>';
										$foto=$r['ftdosen'];
									}

									if($r['putusan']=='1'){
										$putusan="Setuju";
									}else if($r['putusan']=='0'){
										$putusan="Tidak Setuju";
									}else{
										$putusan="";
									}

									?>
										<li class="<?php echo $jenis;?>">
											<div class="avatar">
												<img alt="" style="width:50px;height:50px;" src="../img/<?php echo $foto;?>">
											</div>
											<div class="messages">
												<?php echo $nama;?>
												<p>
													<?php echo bbcode_quote($r['review_text']);?>
												</p><br/>
												<span class="time"><small><em><?php echo tanggalIndo($r['tgl'],'j F Y') ;?>, <?php echo substr($r['wkt'], 0,5);?></em></small> <small class="label label-danger"><?php echo $putusan;?></small></span>
											</div>
										</li>							
									<?php
								}
								echo '</ol>';
							}else{
								echo '<div class="alert alert-danger">
										<i class="clip-cancel-circle"></i>
										<strong>Maaf!</strong> Belum Ada Review..
									</div>';
							}
							?>
							
						</div>
					</div>
				</div>
				<?php
				if($_GET['quote']){
					if(ctype_digit($_GET['quote'])){
						$nmReviewer="";
						$text="";
						$q="SELECT tr.review_text,tr.tgl,tr.wkt, td.nmLengkap as nmDosen, tm.nmLengkap as nmMhs 
						FROM tbreview tr 
							LEFT JOIN tbdosen td ON (td.nip=tr.reviewer)
							LEFT JOIN tbmhs tm ON (tm.nim=tr.reviewer)
						WHERE tr.id='".$_GET['quote']."' LIMIT 1";
						$db->runQuery($q);
						if($db->dbRows()>0){
							$qq=$db->dbFetch();
							if($qq['nmDosen']!=""){
								$nmReviewer=$qq['nmDosen'];
							}else if($qq['nmMhs']!=""){
								$nmReviewer=$qq['nmMhs'];
							}

							if($qq['putusan']=='1'){
								$putusan="Setuju";
							}else if($qq['putusan']=='0'){
								$putusan="Tidak Setuju";
							}else{
								$putusan="";
							}
							$text.="[quote=";
							$text.="$nmReviewer;".tanggalIndo($qq['tgl'],'j F Y')."]";
							$text.=$qq['review_text'];
							$text.="[/quote]";
						}
					}
				}
				?>
				<?php 
				$tanggapan=true;
				$selisih=selisih_tgl($stat['tgl_upload'],date('Y-m-d'));

				if($stat['status_usulan']=='0'){ 
					$tanggapan=true;
				}else{
					$tanggapan=false;
				}
				if($_SESSION['login-dosen']['prodi']=="2"){
					if($selisih['hari']>7){
						if($stat['setuju']>1){
							$tanggapan=false;
						}else{
							$tanggapan=true;
						}
					}
				}	
				?>
				<?php if($tanggapan==true){?>
				<div class="col-sm-12">
					<div class="panel panel-default">
						<!-- <div class="panel-heading"></div> -->
						<form id="post_review" method="POST" action="page/praoutline/act.praoutline.php">
							<input type="hidden" name="act" value="post_review" />
							<input type="hidden" name="idpra" value="<?php echo $stat['id'];?>" />
							<div class="panel-body">
								<div class="form-group">
									Tanggapan : <br/>
									<textarea name="text_review" rows="12" id="text_review" class=" ckeditor form-control"><?php echo $text;?></textarea>
								</div>
								<div class="form-group">
									<label class="col-sm-1 control-label" style="padding-top:6px;">
										Putusan :
									</label>
									<div class="col-sm-3">
										<select name="putusan" id="putusan" class="form-control">
											<option value="">-Pilih-</option>
											<option value="1">Setuju</option>
											<option value="0">Tidak Setuju</option>
										</select>
									</div>
									<div class="col-sm-6">
										<button type="submit" class="btn btn-primary" id="reply"> Submit</button> 
										<span id="loading" style="display:none"><i class="clip-spin-alt icon-spin"></i><em> Loading..</em></span>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<?php } ?>
			</div>
		<?php
		}else{
			//form tanggapan jika review masih kosong
			echo "<div class='alert alert-danger'>Belum Ada Review, Silakan Berikan Tanggapan Terhadap Judul ini.</div>";
			?>
			<div class="row">
				<?php 
				$tanggapan=true;
				$selisih=selisih_tgl($stat['tgl_upload'],date('Y-m-d'));

				if($stat['status_usulan']=='0'){ 
					$tanggapan=true;
				}else{
					$tanggapan=false;
				}
				if($_SESSION['login-dosen']['prodi']=="2"){
					if($selisih['hari']>7){
						if($stat['setuju']>1){
							$tanggapan=false;
						}else{
							$tanggapan=true;
						}
					}
				}	
				?>
				<?php if($tanggapan==true){?>
				<div class="col-sm-12">
					<div class="panel panel-default">
						<!-- <div class="panel-heading"></div> -->
						<form id="post_review" method="POST" action="page/praoutline/act.praoutline.php">
							<input type="hidden" name="act" value="post_review" />
							<input type="hidden" name="idpra" value="<?php echo $stat['id'];?>" />
							<div class="panel-body">
								<div class="form-group">
									Tanggapan : <br/>
									<textarea name="text_review" rows="12" id="text_review" class="ckeditor form-control"></textarea>
								</div>
								<div class="form-group">
									<label class="col-sm-1 control-label" style="padding-top:6px;">
										Putusan :
									</label>
									<div class="col-sm-3">
										<select name="putusan" id="putusan" class="form-control">
											<option value="">-Pilih-</option>
											<option value="1">Setuju</option>
											<option value="0">Tidak Setuju</option>
										</select>
									</div>
									<div class="col-sm-6">
										<button type="submit" class="btn btn-primary" id="reply"> Submit</button> 
										<span id="loading" style="display:none"><i class="clip-spin-alt icon-spin"></i><em> Loading..</em></span>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<?php } ?>
			</div>
		<?php
		}
	}
}else{
	echo "<div class='alert alert-danger'>Maaf. Data Review Untuk Mahasiswa ".$_GET['nim']." Tidak Ditemukan. </div>";
}

}else{
	echo "<div class='alert alert-danger'>Maaf. Data Review Untuk Tidak Ditemukan. </div>";
}

//print_r($_SESSION['new_review_dsn']);
//print_r($_SESSION['selected_user']);
?>