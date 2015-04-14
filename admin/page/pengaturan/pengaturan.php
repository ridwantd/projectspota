<?php $db=new dB($dbsetting); 
$lvl=$_SESSION['login-admin']['lvl'];
if($lvl=='P'){
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
				Pengaturan Website
			</li>
			<li class="search-box">
				<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
			</li>
		</ol>
		<div class="page-header">
			<h1>Pengaturan Website<!--  <small>overview &amp; stats </small> --></h1>
		</div>
	</div>
</div>
<?php
$conf="SELECT * FROM web_setting WHERE idProdi='".$_SESSION['login-admin']['prodi']."'";
$db->runQuery($conf);
$smt="";
$thnajaran="";
$min_setuju="";
if($db->dbRows()>0){
	while($p=$db->dbFetch()){
		switch($p['name']){
			case 'smt':
				$smt=$p['values'];
			break;

			case 'thn_ajaran';
				$thnajaran=$p['values'];
			break;

			case 'min_close':
				$min_setuju=$p['values'];
			break;
		}
	}
}

?>
<div class="row">
	<div class="col-sm-4">
		<form id="pengaturan" method="post" name="pengaturan">
			<input name="act" value="simpan" type="hidden" />
			<div class="form-group">
				<label for="Semester Aktif">Semester Aktif</label>
				<input type="text" value="<?php echo $smt;?>" name="smt" id="smt" class="form-control" placeholder="cth:GAS-2014"/>
			</div>
			<div class="form-group">
				<label for="Tahun Ajaran">Tahun Ajaran</label>
				<input type="text" id="thn_ajaran" name="thn_ajaran" value="<?php echo $thnajaran;?>" placeholder="cth: 2014/2015" class="form-control"/>
			</div>
			<div class="form-group">
				<label for="Tahun Ajaran">Syarat Minimal Close Draft Praoutline</label>
				<select name="min_setuju" id="min_setuju" class="form-control">
					<option value="">- Pilih -</option>
					<?php
						for($x=1;$x<=10;$x++){
							if($x==$min_setuju){
								echo '<option selected value="'.$x.'">'.$x.'</option>';
							}else{
								echo '<option value="'.$x.'">'.$x.'</option>';
							}
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<button class="btn btn-primary btn-sm"><i class="icon-save"></i> Simpan Pengaturan</button>
			</div>
		</form>
	</div>
</div>
<?php
}
?>