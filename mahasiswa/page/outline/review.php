<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-home-3"></i>
				<a href="<?php ECHO MHS_PAGE;?>">
					Home
				</a>
			</li>
			<li class="active">
				Review Diskusi
			</li>			
		</ol>
	</div>
</div>
<?php
$db=new dB($dbsetting); 
$nim=$_SESSION['login-mhs']['nim'];
$id_dis=$_GET['id'];
if(ctype_digit($id_dis)){
	//set status terbaca
	$up="UPDATE tbreviewdiskusi SET status='1' where idDiskusi='$id_dis' and reviewer not like '$nim'";
	$db->runQuery($up);
	//

	$checkdiskusi="SELECT * FROM tbdiskusi WHERE nim='$nim'";
	$db->runQuery($checkdiskusi);
	if($db->dbRows()>0){
		$dis="SELECT  tp.*, tr.*, tm.*, tb.*, COUNT(tr.idDiskusi) as jlhreview
			FROM tbdiskusi tp 
			LEFT JOIN tbreviewdiskusi tr ON (tp.idDiskusi=tr.idDiskusi)
			LEFT JOIN tbmhs tm ON (tp.nim=tm.nim)
			LEFT JOIN tbbab tb ON (tp.idBab=tb.idBab)
			WHERE tp.nim='$nim' AND tp.idDiskusi='$id_dis' GROUP BY tp.idDiskusi";
		$db->runQuery($dis);
		if($db->dbRows()>0){
			$stat=$db->dbFetch();
			if($stat['stDiskusi']=='0'){//dalam proses bimbingan
				?>
				<div class="row">
					<div class="col-sm-12">	
						<p><h3><?php echo "$stat[namaBab] ( $stat[subDiskusi] )";?></h3></p>
							<p>Jumlah Review : <span class="badge badge-info"><?php echo $stat['jlhreview'];?></span></p>
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
										$rev="SELECT tr.*,td.nmLengkap as nmDosen,td.foto as ftdosen, tm.nmLengkap as nmMhs,tm.foto as ftmhs FROM tbreviewdiskusi tr 
										LEFT JOIN tbdosen td ON (td.nip=tr.reviewer)
										LEFT JOIN tbmhs tm ON (tm.nim=tr.reviewer)
										GROUP BY tr.idRev HAVING tr.idDiskusi='".$stat['idDiskusi']."'";
										$db->runQuery($rev);
										if($db->dbRows()>0){
											echo '<ol class="discussion">';
											while($r=$db->dbFetch()){
												if($r['reviewer']==$nim){
													$jenis="self";
													$nama='<span style="float:right"><small class="label label-info">'.$r['nmMhs'].'</small></span><br/>';
													$foto=$r['ftmhs'];
												}else{
													$jenis="other";
													$nama='<small class="label label-info">'.$r['nmDosen'].'</small> <br/>';
													$foto=$r['ftdosen'];
												}

												?>
													<li class="<?php echo $jenis;?>">
														<div class="avatar">
															<img alt="" style="width:50px;height:50px;" src="../img/<?php echo $foto;?>">
														</div>
														<div class="messages">
															<?php echo $nama;?>
															<p>
																<?php echo bbcode_quote($r['rev_text']);?>
															</p><br/>
															<?php
																if($r['file_lamp']==''){
															?>
															<span class="time"><small><em><?php echo tanggalIndo($r['tgl'],'j F Y') ;?>, <?php echo substr($r['wkt'], 0,5);?></em></small></span>
															<?php
																}else{
															?>
															<p>Lampiran - <a class="btn btn-xs btn-bricky" href="<?php echo DOMAIN_UTAMA."/download.php?j=diskusi&rev=".$r['idRev'];?>">Download</a></p>
															<span class="time"><small><em><?php echo tanggalIndo($r['tgl'],'j F Y') ;?>, <?php echo substr($r['wkt'], 0,5);?></em></small></span>
															<?php
															}?>
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
							<div class="col-sm-12">
								<div class="panel panel-default">
									<!-- <div class="panel-heading"></div> -->
									<form id="post_review" name="post_review" method="POST" action="" enctype="multipart/form-data">
										<input type="hidden" name="act" value="post_review" />
										<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
										<input type="hidden" name="sub" value="<?php echo $stat['subDiskusi'];?>" />
										<div class="panel-body">
											<div class="form-group">
												Tanggapan : <br/>
												<textarea name="text_review" rows="12" id="text_review" class="ckeditor form-control"><?php echo $text;?></textarea>
											</div>
											<div class="form-group">
												<label for="gambar-berita">
													Lampiran
												</label>
												<input type="file" name="berkas" id="berkas" class="form-control" title="Silakan Pilih Berkas untuk diupload."/>
											</div>
											<div class="form-group">
											<button type="submit" class="btn btn-primary" id="reply"><i class="clip-upload"></i> Submit</button> 
												<span id="loading" style="display:none"><i class="clip-spin-alt icon-spin"></i><em> Loading..</em></span>
											</div>
										</div>
									</form>
								</div>
							</div>							
						</div>
						<?php 
					}else{
						echo "<p><div class='alert alert-danger'>Belum Ada Review</div></p>";
						?>
						<div class="row">
							<div class="col-sm-12">
								<div class="panel panel-default">
									<!-- <div class="panel-heading"></div> -->
									<form id="post_review" name="post_review" method="POST" action="" enctype="multipart/form-data">
										<input type="hidden" name="act" value="post_review" />
										<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
										<input type="hidden" name="sub" value="<?php echo $stat['subDiskusi'];?>" />
										<div class="panel-body">
											<div class="form-group">
												Tanggapan : <br/>
												<textarea name="text_review" rows="12" id="text_review" class="ckeditor form-control"><?php echo $text;?></textarea>
											</div>
											<div class="form-group">
												<label for="gambar-berita">
													Lampiran
												</label>
												<input type="file" name="berkas" id="berkas" class="form-control" title="Silakan Pilih Berkas untuk diupload."/>
											</div>
											<div class="form-group">
											<button type="submit" class="btn btn-primary" id="reply"><i class="clip-upload"></i> Submit</button> 
												<span id="loading" style="display:none"><i class="clip-spin-alt icon-spin"></i><em> Loading..</em></span>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					<?php
						}
			}else if($stat['stDiskusi']=='1'){//closed
				?>
				<div class="row">
					<div class="col-sm-12">	
						<p><h3><?php echo "$stat[namaBab] ( $stat[subDiskusi] )";?></h3></p>
							<p>Jumlah Review : <span class="badge badge-info"><?php echo $stat['jlhreview'];?></span></p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-default">
							<div class="panel-body">
								<?php
								$rev="SELECT tr.*,td.nmLengkap as nmDosen,td.foto as ftdosen, tm.nmLengkap as nmMhs,tm.foto as ftmhs FROM tbreviewdiskusi tr 
								LEFT JOIN tbdosen td ON (td.nip=tr.reviewer)
								LEFT JOIN tbmhs tm ON (tm.nim=tr.reviewer)
								GROUP BY tr.idRev HAVING tr.idDiskusi='".$stat['idDiskusi']."'";
								$db->runQuery($rev);
								if($db->dbRows()>0){
									echo '<ol class="discussion">';
									while($r=$db->dbFetch()){
										if($r['reviewer']==$nim){
											$jenis="self";
											$nama='<span style="float:right"><small class="label label-info">'.$r['nmMhs'].'</small></span><br/>';
											$foto=$r['ftmhs'];
										}else{
											$jenis="other";
											$nama='<small class="label label-info">'.$r['nmDosen'].'</small> <br/>';
											$foto=$r['ftdosen'];
										}
										?>
										<li class="<?php echo $jenis;?>">
											<div class="avatar">
												<img alt="" style="width:50px;height:50px;" src="../img/<?php echo $foto;?>">
											</div>
											<div class="messages">
												<?php echo $nama;?>
												<p>
													<?php echo bbcode_quote($r['rev_text']);?>
												</p><br/>
												<?php
													if($r['lampiran']==''){
												?>
												<span class="time"><small><em><?php echo tanggalIndo($r['tgl'],'j F Y') ;?>, <?php echo substr($r['wkt'], 0,5);?></em></small></span>
												<?php
													}else{
												?>
												<p>Lampiran - <a class="btn btn-xs btn-bricky" href="<?php echo MHS_PAGE."download.php?att_id=".$r['idRev'];?>"><?php echo "$r[lampiran]";?></a></p>
												<span class="time"><small><em><?php echo tanggalIndo($r['tgl'],'j F Y') ;?>, <?php echo substr($r['wkt'], 0,5);?></em></small></span>
												<?php
												}?>
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
				</div>
			<?php						
			}
		}
	}
}else{
	echo "<p><div class='alert alert-danger'>Tidak Ada Data</div></p>";
}?>

