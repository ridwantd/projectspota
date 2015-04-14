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
			<?php
			switch ($_GET['act']) {
				case 'tambah':
					$title="Tambah Data Dosen";
					echo '
						<li>
							<a href="'.ADMIN_PAGE.'dashboard.php?page=data&menu=data-dosen">
								Manajemen Data Dosen
							</a>
						</li>
						<li class="active">
							Tambah Data Dosen
						</li>';
				break;

				case 'edit':
					$title="Edit Data Dosen";
					echo '
						<li>
							<a href="'.ADMIN_PAGE.'dashboard.php?page=data&menu=data-dosen">
								Manajemen Data Dosen
							</a>
						</li>
						<li class="active">
							Edit Data Dosen
						</li>';
				break;
				
				default:
					$title="Manajemen Data Dosen";
					echo '
						<li class="active">
							Manajemen Data Dosen
						</li>';
				break;
			}
			?>
			<li class="search-box">
				<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
			</li>
			
		</ol>
		<div class="page-header">
			<h1><?php echo $title;?></h1>
		</div>
	</div>
</div>

<?php
switch($_GET['act']){
default:
?>

<a href="?page=data&menu=data-dosen&act=tambah" class="btn btn-primary btn-sm" data-toggle="modal"><i class="clip-user-6"></i> Tambah Data</a>
<hr/>
<div class="row">
	<div class="col-md-12">
		<!-- start: DYNAMIC TABLE PANEL -->
		<table class="table table-striped table-bordered table-hover table-full-width" id="data-dosen">
			<thead>
				<tr>
					<th style="width:30%;text-align:center">Nama Lengkap</th>
					<th style="width:15%;text-align:center">NIP</th>
					<th style="width:20%;text-align:center">Email</th>
					<?php if($_SESSION['login-admin']['lvl']=='S') { 
						echo '<th style="width:20%;text-align:center">Program Studi</th>';
					} ?>
					<th style="width:10%;text-align:center">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="<?php if($_SESSION['login-admin']['lvl']=='S'){ echo "5";}else{ echo "4";} ?>" class="dataTables_empty">Loading data from server</td>
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
<form id="tambah_dosen" method="POST" enctype="multipart/form-data" action="page/manajemendata/act.data-dosen.php">
<input type="hidden" name="act" value="insert" />
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">
				NIP * <sup>Tanpa Spasi</sup>
			</label>
			<input type="text" class="form-control" id="nip_dosen" name="nip_dosen"/>
		</div>
		<div class="form-group">
			<label class="control-label">
				Nama Lengkap *
			</label>
			<input type="text" class="form-control" id="nmLengkap" name="nmLengkap" />
		</div>
		<div class="form-group">
			<label class="control-label">
				Alamat Email 
			</label>
			<input type="email" class="form-control" id="email" name="email" />
		</div>
		<div class="form-group">
			<label class="control-label">
				No Telp
			</label>
			<input type="text" class="form-control" id="nohp" name="nohp" />
		</div>
		<div class="form-group">
			<label class="control-label">
				Password *
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
				Jabatan *
			</label>
			<select name="jabatan" class="form-control" id="jabatan">
				<option value="">- Pilih -</option>
				<option value="K">Kaprodi</option>
				<option value="D">Dosen</option>
			</select>
		</div>
		<?php
		if ($_SESSION['login-admin']['lvl']=='S'){
		?>
		<div class="form-group">
			<label class="control-label">
				Program Studi *
			</label>
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
		<?php
		}
		?>
		<div class="form-group">
			<label class="control-label">
				Foto
			</label>
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
<?php
break;

case 'edit':
$id=$_GET['id'];
if(ctype_digit($id)){
	$e="SELECT * FROM tbdosen WHERE iddosen='$id' LIMIT 1";
	$db->runQuery($e);
	if($db->dbRows()>0){
	$edit=$db->dbFetch();
		?>
		<form id="edit_dosen" method="POST" enctype="multipart/form-data" action="page/manajemendata/act.data-dosen.php">
		<input type="hidden" name="act" value="update" />
		<input type="hidden" name="dosen" value="<?php echo $id;?>" />
		<input type="hidden" name="img" value="<?php echo $edit['foto'];?>" />
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">
						NIP * <sup>Tanpa Spasi</sup>
					</label>
					<input type="text" class="form-control" id="nip_dosen" value="<?php echo $edit['nip'];?>" name="nip_dosen"/>
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
				<div class="form-group">
					<label class="control-label">
						No Telp
					</label>
					<input type="text" class="form-control" value="<?php echo $edit['nohp'];?>" id="nohp" name="nohp" />
				</div>
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
						Jabatan *
					</label>
					<select name="jabatan" class="form-control" id="jabatan">
						<option value="">- Pilih -</option>
						<option <?php echo ($edit['jenis']=='K')?"selected":"";?> value="K">Kaprodi</option>
						<option <?php echo ($edit['jenis']=='D')?"selected":"";?> value="D">Dosen</option>
					</select>
				</div>
				<?php
				if ($_SESSION['login-admin']['lvl']=='S'){
				?>
				<div class="form-group">
					<label class="control-label">
						Program Studi *
					</label>
					<select name="prodi" class="form-control">
						<option value="">- Pilih Program Studi -</option>
						<?php
						$query="Select tp.*,tj.nmJurusan, tf.nmFakultas From tbprodi tp LEFT JOIN tbjurusan tj ON (tp.idJur=tj.idJur) LEFT JOIN tbfakultas tf ON(tf.idFak=tp.idFak)";
						$db->runQuery($query);
						if($db->dbRows()>0){
							while($r=$db->dbFetch()){
								if($r['idProdi']==$edit['idProdi']){
									echo "<option value='".$r['idProdi']."' selected>".$r['nmFakultas']." - ".$r['nmProdi']."</option>";
								}else{
									echo "<option value='".$r['idProdi']."'>".$r['nmFakultas']." - ".$r['nmProdi']."</option>";
								}
								
							}
						}
						?>
					</select>
				</div>
				<?php
				}
				?>
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
		<?php
	}else{

	}
}else{
	//notfound page
}
break;

}
?>

<!-- <div id="tambahfakultas" class="modal fade" tabindex="-1" data-backdrop="static" data-width="460" data-keyboard="false" style="display: none;">
   	<form id="tambahdatafak" action="" method="post" class="form-horizontal">
	   	<div class="modal-header">
	        <h4 class="modal-title" id="myModalLabel">Tambah Data Fakultas </h4>
	    </div>
	  	<div class="modal-body"></div>
	  	<div class="modal-footer">
	    	<button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Batal</button>
	    	<button type="submit" class="btn btn-primary btn-sm">Tambah</button>
	  	</div>
  	</div>
  </form> 
</div>
<div id="editfakultas" class="modal fade" tabindex="-1" data-backdrop="static" data-width="460" data-keyboard="false" style="display: none;">
   	<form id="editdatafak" action="" method="post" class="form-horizontal">
	   	<div class="modal-header">
	        <h4 class="modal-title" id="myModalLabel">Edit Data Fakultas</h4>
	    </div>
	  	<div class="modal-body"></div>
	  	<div class="modal-footer">
	    	<button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Batal</button>
	    	<button type="submit" class="btn btn-primary btn-sm">Update</button>
	  	</div>
  	</div>
  </form> 
</div> -->