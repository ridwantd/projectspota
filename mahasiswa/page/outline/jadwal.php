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
				Jadwal
			</li>			
		</ol>
		<div class="page-header">
			<h1>Pengajuan Jadwal Seminar dan Sidang <small></small></h1>
		</div>
	</div>
</div>
<?php
$nim=$_SESSION['login-mhs']['nim'];
$prodi=$_SESSION['login-mhs']['prodi'];
$idmhs=$_SESSION['login-mhs']['id'];

$ket="SELECT * FROM tbrekaphasil where nim='$nim'";
	$db->runQuery($ket);
	$all=$db->dbFetch();	

$cek="select*from tbjadwal where idMhs='$idmhs'";
	$db->runQuery($cek);
	if($db->dbRows()>0){
		$view=$db->dbFetch();	
		if($view['publish']=='N' AND $view['jenis']=='Outline'){
			echo "<div class='alert alert-danger'>Anda Telah Mengajukan Jadwal Seminar Outline. Silahkan Tunggu Konfirmasi Admin.</div>";
		}else if($view['publish']=='Y' AND $view['jenis']=='Outline'){
			$tg=date_create($view['start']);
			$tgl=tanggalIndo($view['start'],'j F Y');
			$jm=date_format($tg, 'H:i');
			
			$nim=$_SESSION['login-mhs']['nim'];
			$id=$_SESSION['login-mhs']['id'];
			$key=md5($nim)."%$id";
			echo "<div class='alert alert-info'>Jadwal Seminar Outline Telah Di Konfirmasi pada tanggal <b>$tgl</b> pukul <b>$jm</b> di Ruang <b>$view[ruangan]</b>.
				<p>Link Daftar Peserta Seminar : <a href="?><?php echo DOMAIN_UTAMA."/daftar_peserta?key=$key"." target=_blank>".DOMAIN_UTAMA."/daftar_peserta?key=$key";?><?php echo "</a></p></div>";
		}else if($view['publish']=='N' AND $view['jenis']=='Sidang'){
			echo "<div class='alert alert-danger'>Anda Telah Mengajukan Jadwal Sidang Skripsi. Silahkan Tunggu Konfirmasi Admin.</div>";
		}else if($view['publish']=='Y' AND $view['jenis']=='Sidang'){
			$tg=date_create($view['start']);
			$tgl=tanggalIndo($view['start'],'j F Y');
			$jm=date_format($tg, 'H:i');
			echo "<div class='alert alert-info'>Jadwal Sidang Skripsi Telah Di Konfirmasi pada tanggal <b>$tgl</b> di $view[ruangan].</div>";
		}
	?>
		<div class="row">
	<div class="col-sm-12">
		<!-- start: Form PANEL -->

		<form method="POST" enctype="multipart/form-data" action="page/outline/act.outline.php">
			<input type="hidden" name="act" value="jadwal" />
			<input type="hidden" name="judul" value="<?php echo "$all[judul_final]";?>" />
			<?php
				$pb1="SELECT * FROM tbdosen where nip='$all[pemb1]'";
					$db->runQuery($pb1);
					$pemb1=$db->dbFetch();	
			?>
			<input type="hidden" name="pemb1" value="<?php echo "$pemb1[nmLengkap]";?>" />
			<?php
				$pb2="SELECT * FROM tbdosen where nip='$all[pemb2]'";
					$db->runQuery($pb2);
					$pemb2=$db->dbFetch();	
			?>
			<input type="hidden" name="pemb2" value="<?php echo "$pemb2[nmLengkap]";?>" />
			<?php
				$pg1="SELECT * FROM tbdosen where nip='$all[peng1]'";
					$db->runQuery($pg1);
					$peng1=$db->dbFetch();	
			?>
			<input type="hidden" name="peng1" value="<?php echo "$peng1[nmLengkap]";?>" />
			<?php
				$pg2="SELECT * FROM tbdosen where nip='$all[peng2]'";
					$db->runQuery($pg2);
					$peng2=$db->dbFetch();	
			?>
			<input type="hidden" name="peng2" value="<?php echo "$peng2[nmLengkap]";?>" />
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<label for="form-field-select-1">
							Jenis Kegiatan 
						</label>
						<select name="jenis" class="form-control">
							<option value="Outline">Seminar Outline</option>		
							<option value="Sidang">Sidang Skripsi</option>	
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<label for="form-field-select-1">
							Ruang Pelaksanaan
						</label>
						<select name="ruang" class="form-control">
							<option value="Lab A">LAB A</option>		
							<option value="Lab B">LAB B</option>	
							<option value="Lab C">LAB C</option>	
							<option value="Lab D">LAB D</option>	
							<option value="Ruang Sidang">Ruang Sidang</option>	
						</select>
					</div>
				</div>	
			</div>
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<p>
							Range Tanggal Pengajuan
						</p>
						<div class="input-group">
							<span class="input-group-addon"> <i class="icon-calendar"></i> </span>
							<input type="text" class="form-control date-range" name="daterange">
						</div>
					</div>
				</div>	
			</div>
			<div class="row">
				<div class="col-sm-2">
					<div class="form-group">
						<input type="submit" class="form-control" name="simpan" value="Ajukan">
					</div>
				</div>
			</div>
		</form>
		
		<!-- end: Form PANEL -->
	</div>
</div>
		<?php
	}else{
?>
<div class="row">
	<div class="col-sm-12">
		<!-- start: Form PANEL -->

		<form method="POST" enctype="multipart/form-data" action="page/outline/act.outline.php">
			<input type="hidden" name="act" value="jadwal" />
			<input type="hidden" name="judul" value="<?php echo "$all[judul_final]";?>" />
			<?php
				$pb1="SELECT * FROM tbdosen where nip='$all[pemb1]'";
					$db->runQuery($pb1);
					$pemb1=$db->dbFetch();	
			?>
			<input type="hidden" name="pemb1" value="<?php echo "$pemb1[nmLengkap]";?>" />
			<?php
				$pb2="SELECT * FROM tbdosen where nip='$all[pemb2]'";
					$db->runQuery($pb2);
					$pemb2=$db->dbFetch();	
			?>
			<input type="hidden" name="pemb2" value="<?php echo "$pemb2[nmLengkap]";?>" />
			<?php
				$pg1="SELECT * FROM tbdosen where nip='$all[peng1]'";
					$db->runQuery($pg1);
					$peng1=$db->dbFetch();	
			?>
			<input type="hidden" name="peng1" value="<?php echo "$peng1[nmLengkap]";?>" />
			<?php
				$pg2="SELECT * FROM tbdosen where nip='$all[peng2]'";
					$db->runQuery($pg2);
					$peng2=$db->dbFetch();	
			?>
			<input type="hidden" name="peng2" value="<?php echo "$peng2[nmLengkap]";?>" />
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<label for="form-field-select-1">
							Jenis Kegiatan 
						</label>
						<select name="jenis" class="form-control">
							<option value="Outline">Seminar Outline</option>		
							<option value="Sidang">Sidang Skripsi</option>	
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<label for="form-field-select-1">
							Ruang Pelaksanaan
						</label>
						<select name="ruang" class="form-control">
							<option value="Lab A">LAB A</option>		
							<option value="Lab B">LAB B</option>	
							<option value="Lab C">LAB C</option>	
							<option value="Lab D">LAB D</option>	
							<option value="Ruang Sidang">Ruang Sidang</option>	
						</select>
					</div>
				</div>	
			</div>
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<p>
							Range Tanggal Pengajuan
						</p>
						<div class="input-group">
							<span class="input-group-addon"> <i class="icon-calendar"></i> </span>
							<input type="text" class="form-control date-range" name="daterange">
						</div>
					</div>
				</div>	
			</div>
			<div class="row">
				<div class="col-sm-2">
					<div class="form-group">
						<input type="submit" class="form-control" name="simpan" value="Ajukan">
					</div>
				</div>
			</div>
		</form>
		
		<!-- end: Form PANEL -->
	</div>
</div>
<?php
}?>