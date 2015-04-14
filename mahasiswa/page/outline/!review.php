<?php $db=new dB($dbsetting); ?>
<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-home-3"></i>
				<a href="<?php echo MHS_PAGE;?>">
					Home
				</a>
			</li>
			<?php
			if($_GET['nim']!=""){
				echo '
				<li>
					<a href="'.MHS_PAGE.'dashboard.php?page=praoutline&menu=review">
						Review
					</a>
				</li>
				<li class="active">
					'.$_GET['nim'].'
				</li>';
			}else{
				echo '<li class="active">
						Review
					</li>';
			}
			?>
					
		</ol>
		<div class="page-header">
			<h1>Review <?php echo($_GET['nim']!="")?"<small>".$_GET['nim']."</small>":"";?><small></small></h1>
		</div>
	</div>
</div>
<?php
if($_GET['nim']!=""){
	$nim=$_GET['nim'];
}else{
	$nim=$_SESSION['login-mhs']['nim'];
}

$checkpraoutline="SELECT id FROM tbpraoutline WHERE status_usulan='0' AND nim='$nim' LIMIT 1";
$db->runQuery($checkpraoutline);
if($db->dbRows()>0){
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
		COUNT(if(tr.jenis_review=0,1,null)) as komentar,
		COUNT(if(tr.jenis_review=1,1,null)) as putusan,
		COUNT(if(tr.putusan=1,1,null)) as setuju,
		count(if(tr.putusan=0,1,null)) as tdk_setuju
	FROM tbpraoutline tp 
	LEFT JOIN tbreview tr ON (tp.id=tr.idpraoutline)
	LEFT JOIN tbmhs tm ON (tp.nim=tm.nim)
	WHERE tp.nim='$nim' AND tp.status_usulan='0' GROUP BY tp.id";
	$db->runQuery($stat_judul);
	if($db->dbRows()>0){
		$stat=$db->dbFetch();
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
					<p>Oleh <?php echo $stat['nama']." (".$stat['nim'].")". $statusPraoutline;?> - <a class="btn btn-xs btn-bricky" href="<?php echo DOMAIN_UTAMA."/download.php?doc_id=".$stat['id'];?>"><i class="fa fa-trash-o"></i>Download File</a></p>
				</div>
				<div class="col-sm-4 text-right">
					<p>Jumlah Review : <span class="badge badge-info"><?php echo $stat['jlhreview'];?></span> | Setuju : <span class="badge badge-success"><?php echo $stat['setuju'];?></span> | Tidak Setuju : <span class="badge badge-danger"><?php echo $stat['tdk_setuju'];?></span></p>
				</div><hr/>
			</div>
	<!-- 		UNTUK JUDUL YG SUDAH DI CLOSE  -->
			<?php if($stat['status_usulan']==1){ 
				$kep_final="SELECT * FROM tbrekaphasil WHERE idProdi='".$_SESSION['login-mhs']['prodi']."' AND idpraoutline='".$stat['id']."' LIMIT 1";
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
							$db->runQuery($rev);
							if($db->dbRows()>0){
								echo '<ol class="discussion">';
								while($r=$db->dbFetch()){
									if($r['reviewer']==$nim){
										$jenis="self";
										$nama='<span style="float:right"><small class="label label-info">'.$r['nmMhs'].'</small> <small class="label label-inverse" style="cursor:pointer;" onclick="location.href=\'?page=praoutline&menu=review&quote='.$r['id'].'#post_review\'">Quote</small></span><br/>';
										$foto=$r['ftmhs'];
									}else{
										$jenis="other";
										$nama='<small class="label label-info">'.$r['nmDosen'].'</small>  <small class="label label-inverse"><span style="cursor:pointer" onclick="location.href=\'?page=praoutline&menu=review&quote='.$r['id'].'#post_review\'">Quote</span></small><br/>';
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
				<?php if(empty($_GET['nim']) OR $_GET['nim']==$_SESSION['login-mhs']['nim']){ ?>
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
								<button type="submit" class="btn btn-primary" id="reply"><i class="clip-upload"></i> Submit</button> 
									<span id="loading" style="display:none"><i class="clip-spin-alt icon-spin"></i><em> Loading..</em></span>
								</div>
							</div>
						</form>
					</div>
				</div>
				<?php } ?>
			</div>
		<?php
		}else{
			echo "<div class='alert alert-danger'>Belum Ada Review dari Dosen.</div>";
			?>
			<div class="row">
				<?php if(empty($_GET['nim']) OR $_GET['nim']==$_SESSION['login-mhs']['nim'] ){ ?>
				<div class="col-sm-12">
					<div class="panel panel-default">
						<!-- <div class="panel-heading"></div> -->
						<form id="post_review" method="POST" action="page/praoutline/act.praoutline.php">
							<input type="hidden" name="act" value="post_review" />
							<input type="hidden" name="idpra" value="<?php echo $stat['id'];?>" />
							<div class="panel-body">
								<div class="form-group">
									Tanggapan : <br/>
									<textarea name="text_review" rows="12" id="text_review" class="form-control"></textarea>
								</div>
								<div class="form-group">
								<button type="submit" class="btn btn-primary" id="reply"><i class="clip-upload"></i> Submit</button> 
									<span id="loading" style="display:none"><i class="clip-spin-alt icon-spin"></i><em> Loading..</em></span>
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

?>