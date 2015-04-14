<?php $db=new dB($dbsetting); ?>
<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-home-3"></i>
				<a href="<?php ECHO ADMIN_PAGE;?>">
					Home
				</a>
			</li>
			<li>
				<a href="<?php ECHO ADMIN_PAGE;?>dashboard.php?page=pengumuman&menu=daftar-pengumuman">
					Daftar Pengumuman
				</a>
			</li>
			<li class="active">
				Buat Pengumuman Baru
			</li>
			<li class="search-box">
				<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
			</li>
		</ol>
		<div class="page-header">
			<h1>Buat Pengumuman Baru<!--  <small>overview &amp; stats </small> --></h1>
		</div>
	</div>
</div>

<form id="tulis_pengumuman" method="POST" action="page/pengumuman/act.pengumuman.php">
	<input type="hidden" name="act" value="insert" />
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading"></div>
			<div class="panel-body">
				<div class="form-group">
					<input type="text" name="judul" placeholder="JUDUL PENGUMUMAN" class="required form-control" Title="Silakan masukkan judul pengumuman."/>
				</div>
				<div class="form-group">
					<textarea name="isi_pengumuman" id="isi_pengumuman" class="ckeditor form-control"></textarea>
				</div>
				<div class="row">
					<div class="form-group col-sm-5">
						<label for="file-pengumuman">
							Tujuan
						</label>
						<select class="form-control required" id="tujuan" name="tujuan" id="tujuan" title="Silakan Pilih Tujuan Pengumuan">
							<option value="">- Pilih -</option>
							<option value="A">Semua</option>
							<option value="D">Dosen</option>
							<option value="M">Mahasiswa</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="checkbox-inline">
						<input type="checkbox" name="draft" value="yes" class="grey">
						Simpan Sebagai <em>draft</em>
					</label>
					<button type="submit" class="btn btn-primary" id="btnTerbitkan"><i class="clip-earth-2"></i> Terbitkan</button> 
					<span id="loading" style="display:none"><i class="clip-spin-alt icon-spin"></i><em> Loading..</em></span>
				</div>
			</div>
		</div>
	</div>
</div>
</form>