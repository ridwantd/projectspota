<?php $db=new dB($dbsetting); 

$id=$_SESSION['login-admin']['id'];
$db->runQuery("SELECT * FROM tbadmin WHERE idAdmin='$id'");
if($db->dbRows()>0){
	$u=$db->dbFetch();

}
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
				Profil Saya
			</li>
			
		</ol>
		<div class="page-header">
			<h1>Profil Saya <small><strong><?php echo $u['nmLengkap'];?> </strong></small></h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<form id="myprofile" action="" method="post" class="form-horizontal">
			<input type="hidden" name="id" value="<?php echo $u['idAdmin'];?>" />
			<input type="hidden" name="act" value="updatemyprofile"/>
			<div class="form-group">
				<label class="col-sm-2">Nama Lengkap *</label>
				<div class="col-sm-9">
					<input type="text" name="nama_lengkap" value="<?php echo $u['nmLengkap'];?>" class="form-control required" title="Silakan isi Nama Lengkap Anda"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2">Jabatan</label>
				<div class="col-sm-9">
					<input type="text" name="jabatan" value="<?php echo $u['jabatan'];?>" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2">NIP</label>
				<div class="col-sm-9">
					<input type="text" name="nip" value="<?php echo $u['nip'];?>" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2">Email</label>
				<div class="col-sm-9">
					<input type="text" name="emailuser" name="emailuser" value="<?php echo $u['email'];?>" class="form-control" title="Silakan masukkan alamat email yang valid"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2">No Telepon</label>
				<div class="col-sm-9">
					<input type="text" name="telp" value="<?php echo $u['notelp'];?>" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2">Username</label>
				<div class="col-sm-9">
					<input type="text" name="username" value="<?php echo $u['username'];?>" readonly class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2">Password</label>
				<div class="col-sm-4">
					<input type="password" name="pwd" id="pwd" value="" class="form-control" />
				</div>
				*<em>kosongkan jika tidak mengganti password</em>
			</div>
			<div class="form-group">
				<label class="col-sm-2">Password Lama</label>
				<div class="col-sm-4">
					<input type="password" name="pwd_lama" id="pwd_lama" value="" class="form-control" title="Silakan masukkan password lama anda." />
				</div>
				*<em>Wajib diisi jika ingin mengganti password</em>
			</div>
			<hr/>
			<button type="submit" class="btn btn-primary btn-sm">Simpan</button> 
			<span id="loading" style="display:none"><i class="clip-spin-alt icon-spin"></i><em> Menyimpan..</em></span>
		</form>
	</div>
</div>