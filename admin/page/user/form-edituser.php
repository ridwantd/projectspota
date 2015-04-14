<?php
session_start();
include ("../../../inc/helper.php");
include ("../../../inc/konfigurasi.php");
include ("../../../inc/db.pdo.class.php");
if($_SESSION['login-admin']['lvl']=='S'){
	$db=new dB($dbsetting);
	$id=$_GET['user'];
	if(ctype_digit($id)){
		$query="SELECT * FROM tbadmin WHERE idAdmin='$id' LIMIT 1";
		$db->runQuery($query);
		if($db->dbRows()>0){
		$e=$db->dbFetch();
	?>
		<input type="hidden" name="act" value="update"/>
		<input type="hidden" name="id" value="<?php echo $id;?>"/>
		<div class="form-group">
			<label class="col-sm-3">Nama Lengkap *</label>
			<div class="col-sm-8">
				<input type="text" name="nama_lengkap" value="<?php echo $e['nmLengkap'];?>" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3">Jabatan</label>
			<div class="col-sm-8">
				<input type="text" name="jabatan" value="<?php echo $e['jabatan'];?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3">Program Studi</label>
			<div class="col-sm-8">
				<select name="prodi" class="form-control">
					<option value="">- Pilih Program Studi -</option>
					<?php
					$query="Select tp.*,tj.nmJurusan, tf.nmFakultas From tbprodi tp LEFT JOIN tbjurusan tj ON (tp.idJur=tj.idJur) LEFT JOIN tbfakultas tf ON(tf.idFak=tp.idFak)";
					$db->runQuery($query);
					if($db->dbRows()>0){
						while($r=$db->dbFetch()){
							if($e['idProdi']==$r['idProdi']){
								echo "<option value='".$r['idProdi']."' selected>".$r['nmFakultas']." - ".$r['nmProdi']."</option>";
							}else{
								echo "<option value='".$r['idProdi']."'>".$r['nmFakultas']." - ".$r['nmProdi']."</option>";
							}
						}
					}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3">NIP</label>
			<div class="col-sm-8">
				<input type="text" name="nip" value="<?php echo $e['nip'];?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3">Email</label>
			<div class="col-sm-8">
				<input type="text" name="emailuser" name="emailuser" value="<?php echo $e['email'];?>" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3">No Telepon</label>
			<div class="col-sm-8">
				<input type="text" name="telp" value="<?php echo $e['notelp'];?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3">Username</label>
			<div class="col-sm-8">
				<input type="text" name="username" readonly id="username" value="<?php echo $e['username'];?>" id="username" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3">Password</label>
			<div class="col-sm-8">
				<label class="checkbox-inline">
					<input type="checkbox" name="reset_pwd" value="yes" class="grey">
					Reset Password (<em>Password : [username]12345</em>)
				</label>
			</div>
		</div>

	<?php
		}
	}
}
?>
