<?php
	$db=new dB($dbsetting);
	$idrekap=$_GET['id'];
	$fr="SELECT * FROM tbrekaphasil WHERE id='$idrekap'";
	$db->runQuery($fr);
	$forum=$db->dbFetch();
?>
<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-home-3"></i>
				<a href="<?php ECHO DOSEN_PAGE;?>">
					Home
				</a>
			</li>
			<li class="active">
				Forum
			</li>	
		</ol>		
		<div class="page-header">
			<h1> Forum Pembimbing <small><?php echo "$forum[nim]";?></small></h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="alert alert-info">
			<center><strong>"<?php echo "$forum[judul_final]";?>"</strong></center>
		</div>
		<?php
		$nip=$_SESSION['login-dosen']['nip'];
		$checkfor="SELECT idForum FROM tbforum WHERE idRekap='$idrekap' LIMIT 1";
		$db->runQuery($checkfor);
		if($db->dbRows()>0){
			$dis="SELECT 
				tf.*,
				COUNT(tf.idForum) as jlhreview
			FROM tbforum tf 
			WHERE tf.idRekap='$idrekap' GROUP BY tf.idRekap";
			$db->runQuery($dis);
			if($db->dbRows()>0){
				$stat=$db->dbFetch();
		if($stat['jlhreview']>0){
		?>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<?php
							$rev="SELECT tr.*,td.nmLengkap as nmDosen,td.foto as ftdosen FROM tbforum tr 
							LEFT JOIN tbdosen td ON (td.nip=tr.nip)
							GROUP BY tr.idForum HAVING tr.idRekap='".$idrekap."'";
							$db->runQuery($rev);
							if($db->dbRows()>0){
								echo '<ol class="discussion">';
								while($r=$db->dbFetch()){
									if($r['nip']==$nip){
										$jenis="self";
										$nama='<span style="float:right"><small class="label label-info">'.$r['nmDosen'].'</small></span><br/>';
										$foto=$r['ftdosen'];
									}else{
										$jenis="other";
										$nama='<small class="label label-info">'.$r['nmDosen'].'</small><br/>';
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
													<?php echo bbcode_quote($r['isi']);?>
												</p>
												<span class="time"><small><em><?php echo tanggalIndo($r['tglwkt'],'j F Y, H:i') ;?></em></small></span>
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
						<form id="post_forum" method="POST" action="page/skripsi/act.skripsi.php" enctype="multipart/form-data">
							<input type="hidden" name="act" value="post_forum" />
							<input type="hidden" name="idrek" value="<?php echo $idrekap;?>" />
							<input type="hidden" name="nim" value="<?php echo $forum['nim'];?>" />
							<div class="panel-body">
								<div class="form-group">
									Tanggapan : <br/>
									<textarea name="text_forum" rows="12" id="text_forum" class=" ckeditor form-control"><?php echo $text;?></textarea>
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
	}}
		}else{
			?>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<!-- <div class="panel-heading"></div> -->
						<form id="post_forum" method="POST" action="page/skripsi/act.skripsi.php" enctype="multipart/form-data">
							<input type="hidden" name="act" value="post_forum" />
							<input type="hidden" name="idrek" value="<?php echo $idrekap;?>" />
							<input type="hidden" name="nim" value="<?php echo $forum['nim'];?>" />
							<div class="panel-body">
								<div class="form-group">
									Tanggapan : <br/>
									<textarea name="text_forum" rows="12" id="text_forum" class=" ckeditor form-control"><?php echo $text;?></textarea>
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
?>
	</div>
</div>