<?php $db=new dB($dbsetting); 

$id=$_SESSION['login-mhs']['id'];
$e="SELECT * FROM tbmhs WHERE idmhs='$id' LIMIT 1";
	$db->runQuery($e);
	if($db->dbRows()>0){
	$edit=$db->dbFetch();
}else{

	exit;
}
?>
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
				Profil Saya
			</li>
			<li class="search-box">
				<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
			</li>			
		</ol>
		<div class="page-header">
			<h1>Profil Mahasiswa <small><strong><?php echo $edit['nmLengkap'];?> </strong></small></h1>
		</div>
	</div>
</div>
<form id="updateprofil" method="POST" enctype="multipart/form-data" action="page/user/act.user.php">
<input type="hidden" name="act" value="updatemyprofile" />
<input type="hidden" name="mhs" value="<?php echo $id;?>" />
<input type="hidden" name="img" value="<?php echo $edit['foto'];?>" />
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">
				NIM *
			</label>
			<input type="text" readonly class="form-control" id="nim" value="<?php echo $edit['nim'];?>" name="nim"/>
		</div>
		<div class="form-group">
			<label class="control-label">
				Nama Lengkap *
			</label>
			<input type="text" class="form-control" id="nmLengkap" value="<?php echo $edit['nmLengkap'];?>" name="nmLengkap" />
		</div>
		<div class="form-group">
			<label class="control-label">
				Alamat Email 
			</label>
			<input type="email" class="form-control" value="<?php echo $edit['email'];?>" id="email" name="email" />
		</div>
		<!-- <div class="form-group">
			<label class="control-label">
				No Telp
			</label>
			<input type="text" class="form-control" value="<?php echo $edit['nohp'];?>" id="nohp" name="nohp" />
		</div> -->
		<div class="form-group">
			<label class="control-label">
				Password * <sup>Abaikan Jika tidak mengganti password</sup>
			</label>
			<input type="password" class="form-control" name="password" id="password" />
		</div>
		<div class="form-group">
			<label class="control-label">
				Konfirmasi Password
			</label>
			<input type="password"  class="form-control" id="password_again" name="password_again" />
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">
				Foto <sup>*Abaikan jika tidak mengganti foto</sup>
			</label>
			<div class="fileupload-new thumbnail" style="width: 150px; height: 150px;">
				<img src="../img/<?php echo $edit['foto'];?>" alt="">
			</div><br/>
			<input type="file" class="form-control" id="foto" name="foto" />
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		<button class="btn btn-teal btn-block" type="submit">
			Simpan Data
		</button>
	</div>
</div>
</form>