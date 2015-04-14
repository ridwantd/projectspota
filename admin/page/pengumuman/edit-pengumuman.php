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
				Edit Pengumuman
			</li>
			<li class="search-box">
				<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
			</li>
		</ol>
		<div class="page-header">
			<h1>Edit Pengumuman</h1>
		</div>
	</div>
</div>
<?php
$idpengumuman=$_GET['pengumuman'];
if(ctype_digit($idpengumuman)){
$query="SELECT * FROM tbpengumuman WHERE id = '$idpengumuman' LIMIT 1";
$db->runQuery($query);
	if($db->dbRows()>0){
		$b=$db->dbFetch();
	?>
	<form id="tulis_pengumuman" method="POST" action="page/pengumuman/act.pengumuman.php">
		<input type="hidden" name="act" value="update" />
		<input type="hidden" name="pengumuman" value="<?php echo $b['id']; ?>" />
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading"></div>
				<div class="panel-body">
					<div class="form-group">
						<input type="text" name="judul" placeholder="Judul Pengimiman" class="required form-control" title="Silakan masukkan judul pengumuman" value="<?php echo $b['judul'];?>"/>
					</div>
					<div class="form-group">
						<textarea name="isi_pengumuman" id="isi_pengumuman" class="ckeditor form-control"><?php echo $b['isi'];?></textarea>
					</div>
					<div class="row">
					<div class="form-group col-sm-5">
						<label for="file-pengumuman">
							Tujuan
						</label>
						<select class="form-control" id="tujuan" name="tujuan" id="tujuan">
							<option value="">- Pilih -</option>
							<option <?php echo ($b['tujuan']=='A')?"selected":"";?> value="A">Semua</option>
							<option <?php echo ($b['tujuan']=='D')?"selected":"";?> value="D">Dosen</option>
							<option <?php echo ($b['tujuan']=='M')?"selected":"";?> value="M">Mahasiswa</option>
						</select>
					</div>
				</div>
					<div class="form-group">
						<label class="checkbox-inline">
							<input type="checkbox" name="draft" <?php echo($b['publish']=="N")?"checked":"";?> value="yes" class="grey">
							Simpan Sebagai <em>draft</em>
						</label>
						<button type="submit" class="btn btn-primary" id="btnTerbitkan">Update Pengumuman</button>
						<span id="loading" style="display:none"><i class="clip-spin-alt icon-spin"></i><em> Loading..</em></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	</form>

	<?php
	}else{

	}
}else{

}
?>