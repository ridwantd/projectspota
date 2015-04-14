<?php $db=new dB($dbsetting); ?>
<?php
switch ($_GET['act']) {
	default:
		?>
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li>
						<i class="clip-home-3"></i>
						<a href="<?php ECHO ADMIN_PAGE;?>">
							Home
						</a>
					</li>
					<li class="active">
						Manajemen Jadwal Seminar/Sidang
					</li>
					<li class="search-box">
						<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
					</li>
					
				</ol>
				<div class="page-header">
					<h1>Daftar Seminar /Sidang</h1>
				</div>
			</div>
		</div>
		<a href="?page=jadwal&act=tambah" class="btn btn-primary btn-sm" data-toggle="modal"><i class="clip-user-6"></i> Tambah Data</a>
		<hr/>
		<div class="row">
			<div class="col-md-12">
				<!-- start: DYNAMIC TABLE PANEL -->
				<table class="table table-striped table-bordered table-hover table-full-width" id="list-jadwal">
					<thead>
						<tr>
							<th style="width:20%;text-align:center">Nama</th>
							<th style="width:50%;text-align:center">Judul</th>
							<th style="width:20%;text-align:center">Tanggal</th>
							<th style="width:10%;text-align:center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="4" class="dataTables_empty">Loading data from server</td>
						</tr>
					</tbody>
				</table>

				<!-- end: DYNAMIC TABLE PANEL -->
			</div>
		</div>
		<?php
	break;

	case 'tambah':
		?>
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li>
						<i class="clip-home-3"></i>
						<a href="<?php ECHO ADMIN_PAGE;?>">
							Home
						</a>
					</li>
					<li><a href="<?php ECHO ADMIN_PAGE;?>dashboard.php?page=jadwal" >
						Manajemen Jadwal Seminar/Sidang </a>
					</li>
					<li class="active">
						Tambah Jadwal
					</li>
					
				</ol>
				<div class="page-header">
					<h1>Tambah Jadwal Seminar/Sidang</h1>
				</div>
			</div>
		</div>
		<form id="form_jadwal" method="POST" action="page/jadwal/act.jadwal.php">
			<input type="hidden" name="act" value="insert" />
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label>Mahasiswa</label>
					<select name="idmhs" id="idmhs" class="form-control search-select required" title="Pilih Mahasiswa">
						<option value="">-Pilih Mahasiswa-</option>
						<?php
						$q="SELECT * FROM tbmhs WHERE idProdi='".$_SESSION['login-admin']['prodi']."'";
						$db->runQuery($q);
						if($db->dbRows()>0){
							while($j=$db->dbFetch()){
								echo "<option value='".$j['idmhs']."'>(".$j['nim'].") ".$j['nmLengkap']."</option>";
							}
						}
						?>
					</select>	
				</div>
				<div class="form-group">
					<label>Judul Skripsi</label>
					<textarea name="judul" id="judul" class="form-control required" title="Judul Skripsi tidak boleh kosong"></textarea>
				</div>
				<div class="form-group">
					<label>Jenis</label>
					<select name="jenis" id="jenis" class="form-control required" title="Silakan tentukan jenis jadwal">
						<option value="">Pilih</option>
						<option value="Sidang">Sidang Akhir</option>
						<option value="Outline">Seminar Outline</option>
					</select>
				</div>
				<div class="form-group">
					<label>Ruangan</label>
					<input type="text" name="ruangan" id="ruangan" class="form-control required" title="Ruangan harus diisi" />
				</div>	
				<div class="form-group">
					<label>Tanggal</label>
					<input type="text" name="tgl" id="tgl" data-date-format="dd-mm-yyyy" data-date-viewmode="days" class="form-control date-picker required" title="Tanggal harus diisi">
				</div>
				<div class="form-group">
					<label>Waktu</label>
					<div class="input-group input-append bootstrap-timepicker">
						<span class="input-group-addon add-on"><i class="clip-clock-2"></i></span>
						<input type="text" name="wkt" id="wkt" class="form-control time-picker required" title="Waktu harus diisi">
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label>Dosen Pembimbing 1</label>
					<input type="text" name="pemb1" class="form-control required" title="Data Pembimbing 1 tidak boleh kosong" />
				</div>
				<div class="form-group">
					<label>Dosen Pembimbing 2</label>
					<input type="text" name="pemb2" class="form-control required" title="Data Pembimbing 2 tidak boleh kosong" />
				</div>
				<div class="form-group">
					<label>Dosen Penguji 1</label>
					<input type="text" name="peng1" class="form-control required" title="Data Penguji 1 tidak boleh kosong"/>
				</div>
				<div class="form-group">
					<label>Dosen Penguji 2</label>
					<input type="text" name="peng2" class="form-control required" title="Data Penguji 2 tidak boleh kosong"/>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<label class="checkbox-inline">
					<input type="checkbox" name="draft" value="yes" class="grey">
					Simpan Sebagai <em>draft</em>
				</label>
				<button type="submit" class="btn btn-primary" id="btnTerbitkan"><i class="clip-earth-2"></i> Terbitkan</button> 
				<span id="loading" style="display:none"><i class="clip-spin-alt icon-spin"></i><em> Loading..</em></span>
			</div>
		</div>
		</form>
		<?php
	break;

	case 'edit':
		$id=$_GET['id'];
		?>
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li>
						<i class="clip-home-3"></i>
						<a href="<?php ECHO ADMIN_PAGE;?>">
							Home
						</a>
					</li>
					<li><a href="<?php ECHO ADMIN_PAGE;?>dashboard.php?page=jadwal" >
						Manajemen Jadwal Seminar/Sidang </a>
					</li>
					<li class="active">
						Edit Jadwal
					</li>
					
				</ol>
				<div class="page-header">
					<h1>Edit Jadwal Seminar<!--  <small>overview &amp; stats </small> --></h1>
				</div>
			</div>
		</div>
		<?php
		if(ctype_digit($id)){
			$e="SELECT * FROM tbjadwal WHERE id='$id' LIMIT 1";
			$db->runQuery($e);
			if($db->dbRows()>0){
				$r=$db->dbFetch();
				$start=explode(" ", $r['start']);
				$tgl=explode("-",$start[0]);
				$etgl=$tgl[2]."-".$tgl[1]."-".$tgl[0];

				$wkt=$start[1];
		?>
			<form id="form_jadwal" method="POST" action="page/jadwal/act.jadwal.php">
				<input type="hidden" name="act" value="update" />
				<input type="hidden" name="idjadwal" value="<?php echo $id;?>" />
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label>Mahasiswa</label>
							<select name="idmhs" id="idmhs" class="form-control search-select required" title="Pilih Mahasiswa">
								<option value="">-Pilih Mahasiswa-</option>
								<?php
								$q="SELECT * FROM tbmhs WHERE idProdi='".$_SESSION['login-admin']['prodi']."'";
								$db->runQuery($q);
								if($db->dbRows()>0){
									while($j=$db->dbFetch()){
										if($j['idmhs']==$r['idMhs']){
											echo "<option selected value='".$j['idmhs']."'>(".$j['nim'].") ".$j['nmLengkap']."</option>";
										}else{
											echo "<option value='".$j['idmhs']."'>(".$j['nim'].") ".$j['nmLengkap']."</option>";
										}
									}
								}
								?>
							</select>	
						</div>
						<div class="form-group">
							<label>Judul Skripsi</label>
							<textarea name="judul" id="judul" class="form-control required" title="Judul Skripsi tidak boleh kosong"><?php echo $r['judul'];?></textarea>
						</div>
						<div class="form-group">
							<label>Jenis</label>
							<select name="jenis" id="jenis" class="form-control required" title="Silakan tentukan jenis jadwal">
								<option value="">Pilih</option>
								<option <?php echo($r['jenis']=="Sidang"?"selected":"");?> value="Sidang">Sidang Akhir</option>
								<option <?php echo($r['jenis']=="Outline"?"selected":"");?> value="Outline">Seminar Outline</option>
							</select>
						</div>
						<div class="form-group">
							<label>Ruangan</label>
							<input type="text" name="ruangan" id="ruangan" class="form-control required" value="<?php echo $r['ruangan'];?>" title="Ruangan harus diisi" />
						</div>	
						<div class="form-group">
							<label>Tanggal</label>
							<input type="text" name="tgl" id="tgl" data-date-format="dd-mm-yyyy" data-date-viewmode="days" class="form-control date-picker required" title="Tanggal harus diisi" value="<?php echo $etgl;?>">
						</div>
						<div class="form-group">
							<label>Waktu</label>
							<div class="input-group input-append bootstrap-timepicker">
								<span class="input-group-addon add-on"><i class="clip-clock-2"></i></span>
								<input type="text" name="wkt" id="wkt" class="form-control time-picker required" title="Waktu harus diisi" value="<?php echo $wkt;?>">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>Dosen Pembimbing 1</label>
							<input type="text" name="pemb1" class="form-control required" title="Data Pembimbing 1 tidak boleh kosong" value="<?php echo $r['pemb1'];?>" />
						</div>
						<div class="form-group">
							<label>Dosen Pembimbing 2</label>
							<input type="text" name="pemb2" class="form-control required" title="Data Pembimbing 2 tidak boleh kosong" value="<?php echo $r['pemb2'];?>" />
						</div>
						<div class="form-group">
							<label>Dosen Penguji 1</label>
							<input type="text" name="peng1" class="form-control required" title="Data Penguji 1 tidak boleh kosong" value="<?php echo $r['peng1'];?>"/>
						</div>
						<div class="form-group">
							<label>Dosen Penguji 2</label>
							<input type="text" name="peng2" class="form-control required" title="Data Penguji 2 tidak boleh kosong" value="<?php echo $r['peng2'];?>"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<label class="checkbox-inline">
							<input type="checkbox" <?php echo($r['publish']=='N'?"checked":"");?> name="draft" value="yes" class="grey">
							Simpan Sebagai <em>draft</em>
						</label>
						<button type="submit" class="btn btn-primary" id="btnTerbitkan"><i class="clip-earth-2"></i> Update</button> 
						<span id="loading" style="display:none"><i class="clip-spin-alt icon-spin"></i><em> Loading..</em></span>
					</div>
				</div>
			</form>
		<?php
			}else{
				//data tidak ditemukan
			}
		}
	break;
}
?>
		