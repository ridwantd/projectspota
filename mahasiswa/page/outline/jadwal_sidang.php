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
			<h1>Pengajuan Jadwal Sidang Skripsi<small></small></h1>
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

$cek="select*from tbjadwal where idMhs='$idmhs' and jenis='Sidang'";
	$db->runQuery($cek);
	if($db->dbRows()>0){
		$view=$db->dbFetch();	
		if($view['publish']=='N' AND $view['jenis']=='Sidang'){
			echo "<div class='alert alert-danger'>Anda Telah Mengajukan Jadwal Sidang Skripsi. Silahkan Tunggu Konfirmasi Admin.</div>";
		}else if($view['publish']=='Y' AND $view['jenis']=='Sidang'){
			$tg=date_create($view['start']);
			$tgl=tanggalIndo($view['start'],'j F Y');
			$jm=date_format($tg, 'H:i');
			echo "<div class='alert alert-info'>Jadwal Sidang Skripsi Telah Di Konfirmasi pada tanggal <b>$tgl</b> di $view[ruangan].</div>";
		}	
	}else{
?>
<div class="row">
	<div class="col-sm-12">
		<!-- start: Form PANEL -->
		<form id="post_jadwal" name="post_jadwal" method="POST" action="">
			<input type="hidden" name="act" value="jadwal" />
			<input type="hidden" name="jenis" value="Sidang" />
			<div class="col-sm-6">
				<div class="form-group">
					<label>Judul Skripsi</label>
					<textarea name="judul" id="judul" class="form-control required"><?php echo $all['judul_final'];?></textarea>
				</div>
				<div class="form-group">
					<label>Ruangan</label>
					<input type="text" name="ruang" class="form-control required" value="Ruang Sidang" />
				</div>	
				<div class="form-group">
					<label>Tanggal</label>
					<div class="input-group">
						<span class="input-group-addon"> <i class="icon-calendar"></i> </span>
						<input type="text" class="form-control date-range required" name="daterange" id="daterange" title="Tanggal Harus Dipilih">
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<button type="submit" class="btn btn-primary" id="btnTerbitkan">Ajukan Jadwal</button> 
						<span id="loading" style="display:none"><i class="clip-spin-alt icon-spin"></i><em> Loading..</em></span>
					</div>
				</div>		
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label>Dosen Pembimbing 1</label>
					<?php
						$pb1="SELECT * FROM tbdosen where nip='".$all['pemb1']."'";
							$db->runQuery($pb1);
							$pemb1=$db->dbFetch();	
					?>
					<input type="text" name="pemb1" id="pemb1" class="form-control required" value="<?php echo $pemb1['nmLengkap'];?>" />
				</div>
				<div class="form-group">
					<label>Dosen Pembimbing 2</label>
					<?php
						$pb2="SELECT * FROM tbdosen where nip='".$all['pemb2']."'";
							$db->runQuery($pb2);
							$pemb2=$db->dbFetch();	
					?>
					<input type="text" name="pemb2" id="pemb2" class="form-control required" value="<?php echo $pemb2['nmLengkap'];?>" />
				</div>
				<div class="form-group">
					<label>Dosen Penguji 1</label>
					<?php
						$pg1="SELECT * FROM tbdosen where nip='".$all['peng1']."'";
							$db->runQuery($pg1);
							$peng1=$db->dbFetch();	
					?>
					<input type="text" name="peng1" id="peng1"class="form-control required" value="<?php echo $peng1['nmLengkap'];?>"/>
				</div>
				<div class="form-group">
					<label>Dosen Penguji 2</label>
					<?php
						$pg2="SELECT * FROM tbdosen where nip='".$all['peng2']."'";
							$db->runQuery($pg2);
							$peng2=$db->dbFetch();	
					?>
					<input type="text" name="peng2" id="peng2" class="form-control required" value="<?php echo $peng2['nmLengkap'];?>"/>
				</div>
			</div>
		</form>	
		<!-- end: Form PANEL -->
	</div>
</div>
<?php
}?>