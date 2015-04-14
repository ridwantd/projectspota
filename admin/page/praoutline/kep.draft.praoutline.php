<?php $db=new dB($dbsetting); 
if(!$_GET['prid']){
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
				Daftar Draf Praoutline 
			</li>
			<li class="search-box">
				<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
			</li>				
		</ol>
		<div class="page-header">
			<h1>Daftar Draf Praoutline<!--  <small>overview &amp; stats </small> --></h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-striped table-bordered table-hover table-full-width" id="kep-draft-praoutline">
			<thead>
				<tr>
					<th style="width:15%;text-align:center">Nama Mahasiswa</th>
					<th style="width:50%;text-align:center">Judul Tugas Akhir</th>
					<th style="width:15%;text-align:center">Tahun Ajaran</th>
					<th style="width:15%;text-align:center">Tanggal</th>
					<th style="width:8%;text-align:center">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="5" class="dataTables_empty">Loading data from server</td>
				</tr>
			</tbody>
		</table>

		<!-- end: DYNAMIC TABLE PANEL -->
	</div>
</div>
<?php
}else{
	$idpraoutline=$_GET['prid'];
	if(ctype_digit($idpraoutline)){
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
					<li>
						<a href="<?php ECHO DOSEN_PAGE;?>dashboard.php?page=praoutline&menu=kep-draft-praoutline">
							Daftar Draf Praoutline 
						</a>
					</li>
					<li class="active">
						Close Draft Praoutline 
					</li>
					<li class="search-box">
						<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
					</li>				
				</ol>
				<div class="page-header">
					<h1>Close Draft Praoutline<!--  <small>overview &amp; stats </small> --></h1>
				</div>
			</div>
		</div>
		<?php
		$q="SELECT tp.*,(SELECT nmLengkap FROM tbmhs WHERE nim=tp.nim) as nama FROM tbpraoutline tp WHERE tp.id='$idpraoutline'";
		$db->runQuery($q);
		if($db->dbRows()>0){
			$pr=$db->dbFetch();
			?>
			<div class="row">
				<div class="col-sm-12">
					<p><h3 style="text-align:left;margin-top:0"><?php echo strtoupper($pr['judul']);?></h3></p>
					<?php echo $pr['deskripsi'];?>
					<div class="row">
						<div class="col-sm-8">
							<p>Oleh : <?php echo $pr['nama']." (".$pr['nim'].")";?></p>
						</div>
					</div>
				</div>
			</div>
			<form id="putusan_judul" method="POST" action="page/praoutline/act.praoutline.php">
				<input type="hidden" name="act" value="close_judul" />
				<input type="hidden" name="nim" value="<?php echo $pr['nim'];?>" />
				<input type="hidden" name="idpr" value="<?php echo $pr['id'];?>" />
				<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-default">
							<!-- <div class="panel-heading"></div> -->
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label> Putusan </label>
											<select name="putusan" id="putusan" class="form-control">
												<option value=""> - Pilih -</option>
												<option value="1"> Terima </option>
												<option value="2"> Tolak </option>
												<option value="3"> Gugur</option>
											</select>
										</div>
									</div>
									<div class="col-sm-9">
										<div class="form-group">
											<label>Keterangan </label>
											<textarea name="ket" id="ket" class="form-control"></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-sm-12">
										<label>Judul Final</label>
										<input type="text" value="<?php echo $pr['judul'];?>" name="judul_final" id="judul_final" class="form-control" />
									</div>
								</div>
								<?php
								$d="SELECT * FROM tbdosen WHERE idProdi='".$_SESSION['login-admin']['prodi']."' ORDER by nmLengkap ASC";
								?>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Dosen Pembimbing 1 </label>
											<select name="pemb1" id="pemb1" class="form-control search-select">
												<?php 
												$db->runQuery($d);
												echo '<option value="">-Pilih-</option>';
												while($pemb1=$db->dbFetch()){
													echo '<option value="'.$pemb1['nip'].'">'.$pemb1['nmLengkap'].'</option>';
												}
												?>
											</select>
										</div>
										<div class="form-group">
											<label>Dosen Pembimbing 2 </label>
											<select name="pemb2" id="pemb2" class="form-control search-select">
												<?php 
												$db->runQuery($d);
												echo '<option value="">-Pilih-</option>';
												while($pemb2=$db->dbFetch()){
													echo '<option value="'.$pemb2['nip'].'">'.$pemb2['nmLengkap'].'</option>';
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Dosen Penguji 1 </label>
											<select name="peng1" id="peng1" class="form-control search-select">
												<?php 
												$db->runQuery($d);
												echo '<option value="">-Pilih-</option>';
												while($peng1=$db->dbFetch()){
													echo '<option value="'.$peng1['nip'].'">'.$peng1['nmLengkap'].'</option>';
												}
												?>
											</select>
										</div>
										<div class="form-group">
											<label>Dosen Penguji 2</label>
											<select name="peng2" id="peng2" class="form-control search-select">
												<?php 
												$db->runQuery($d);
												echo '<option value="">-Pilih-</option>';
												while($peng2=$db->dbFetch()){
													echo '<option value="'.$peng2['nip'].'">'.$peng2['nmLengkap'].'</option>';
												}
												?>
											</select>
										</div>
									</div>	
								</div>
								<div class="form-group">
								<button type="submit" class="btn btn-primary" id="btnUpload"><i class="clip-checkmark-circle"></i> Simpan</button> 
									<span id="loading" style="display:none"><i class="clip-spin-alt icon-spin"></i><em> Loading..</em></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
			<?php
		}
	}
}
?>