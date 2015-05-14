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
				Upload
			</li>
			<li class="search-box">
				<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
			</li>
		</ol>
		<div class="page-header">
			<h1>Upload Draft Praoutline <small></small></h1>
		</div>
	</div>
</div>
<?php
$db=new dB($dbsetting);
$nim=$_SESSION['login-mhs']['nim'];
$check="SELECT id FROM tbpraoutline WHERE nim='$nim' AND status_usulan IN ('0','1')"; //tambahkan AND status_usulan NOT IN ('2','3') jika judul telah gugur atau ditolak
$db->runQuery($check);
if($db->dbRows()>0){
?>
<div class="alert alert-block alert-info fade in">
	<h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Draft Praoutline Anda Telah Diupload</h4>
	<p>
		Silakan lihat menu review untuk melihat review dari dosen.
	</p>
	<p>
		<a href="?page=praoutline&menu=review" class="btn btn-blue">
			Lihat Review
		</a>
		<?php 
			//informatika only
			if($_SESSION['login-mhs']['prodi']=="2"){ ?>
			<a href="../spotaif.apk" class="btn btn-blue">
				Download Aplikasi Android
			</a>
			<?php }?>
	</p>
</div>

<?php
}else{
?>
<div class="alert alert-danger">
	<h4 class="alert-heading">Perhatian</h4>
	<ul>
		<li><strong>Pastikan File Yang Anda Upload Berupa File PDF</strong></li>
		<li><strong>Periksa Terlebih Dahulu File Draft Praoutline Yang Akan diupload</strong></li>
		<li><strong>Jika Terdapat Kesalahan Upload Draft Praoutline Harap Menghubungi Administrator SPOTA Prodi Masing-Masing</strong></li>
	</ul>
	
</div>
<form id="upload_usulan" method="POST" enctype="multipart/form-data" action="page/praoutline/act.praoutline.php">
	<input type="hidden" name="act" value="upload" />
	<input type="hidden" name="nim" value="<?php echo $_SESSION['login-mhs']['nim'];?>" />
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<!-- <div class="panel-heading"></div> -->
				<div class="panel-body">
					<div class="form-group">
						<input type="text" name="judul" placeholder="JUDUL SKRIPSI" class="required form-control" Title="Silakan masukkan judul skripsi yang akan diajukan."/>
					</div>
					<div class="form-group">
						<textarea name="deskripsi" id="deskripsi" class="ckeditor form-control"></textarea>
					</div>
					<div class="row">
						<div class="form-group col-sm-5">
							<label for="gambar-berita">
								Berkas (pdf file)
							</label>
							<input type="file" name="berkas" id="berkas" class="form-control required" title="Silakan Pilih Berkas untuk diupload."/>
						</div>
					</div>
					<div class="form-group">
					<button type="submit" class="btn btn-primary" id="btnUpload"><i class="clip-upload"></i> Upload</button> 
						<span id="loading" style="display:none"><i class="clip-spin-alt icon-spin"></i><em> Loading..</em></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<?php
}
?>