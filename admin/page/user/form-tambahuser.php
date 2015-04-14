<?php
session_start();
include ("../../../inc/helper.php");
include ("../../../inc/konfigurasi.php");
include ("../../../inc/db.pdo.class.php");

$db=new dB($dbsetting);
?>
	<input type="hidden" name="act" value="insert"/>
	<div class="form-group">
		<label class="col-sm-3">Nama Lengkap *</label>
		<div class="col-sm-8">
			<input type="text" name="nama_lengkap" class="form-control"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3">Jabatan</label>
		<div class="col-sm-8">
			<input type="text" name="jabatan" class="form-control" />
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
						echo "<option value='".$r['idProdi']."'>".$r['nmFakultas']." - ".$r['nmProdi']."</option>";
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3">NIP</label>
		<div class="col-sm-8">
			<input type="text" name="nip" class="form-control" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3">Email</label>
		<div class="col-sm-8">
			<input type="text" name="emailuser" class="form-control"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3">No Telepon</label>
		<div class="col-sm-8">
			<input type="text" name="telp" class="form-control" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3">Username</label>
		<div class="col-sm-8">
			<input type="text" name="username" id="username" class="form-control" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3">Password</label>
		<div class="col-sm-5">
			<input type="password" name="pwd" id="pwd" value="" class="form-control" />
		</div>
	</div>