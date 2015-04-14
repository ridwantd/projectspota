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
				Diskusi Baru
			</li>
			
		</ol>
		<div class="page-header">
			<h1>Ajukan Diskusi Tugas Akhir <small></small></h1>
		</div>
	</div>
</div>
<?php
$db=new dB($dbsetting);
$nim=$_SESSION['login-mhs']['nim'];
	$nmPemb1="SELECT 
		td.nip,
		td.nmLengkap,
		tr.nim,
		tr.pemb1
	FROM tbdosen td
	LEFT JOIN tbrekaphasil tr ON (td.nip=tr.pemb1)
	WHERE tr.nim='$nim' AND tr.kep_akhir='1'";
	$db->runQuery($nmPemb1);
	$pemb1=$db->dbFetch();	

	$nmPemb2="SELECT 
		td.nip,
		td.nmLengkap,
		tr.nim,
		tr.pemb2
	FROM tbdosen td
	LEFT JOIN tbrekaphasil tr ON (td.nip=tr.pemb2)
	WHERE tr.nim='$nim' AND tr.kep_akhir='1'";
	
	$db->runQuery($nmPemb2);		
	$pemb2=$db->dbFetch();
			
?>
<form id="tambah_diskusi" method="POST" action="">
<input type="hidden" name="act" value="diskusi" />
	<div class="row">
		<div class="col-sm-4">
			<div class="form-group">
				<label for="form-field-select-1">
					Pilih Dosen Pembimbing
				</label>
				<select name="pemb" id="pemb" class="form-control">
					<option value="">-Pilih Dosen Pembimbing-</option>
					<option value="<?php echo $pemb1['nip']?>"><?php echo $pemb1['nmLengkap'];?></option>		
					<option value="<?php echo $pemb2['nip']?>"><?php echo $pemb2['nmLengkap'];?></option>	
				</select>
			</div>
		</div>	
	</div>
	<div class="row">
		<div class="col-sm-4">
			<div class="form-group">
				<label for="form-field-select-1">
					Status Tugas Akhir
				</label>
				<select name="stta" id="stta" class="form-control">
					<option value="">-Pilih Status Tugas Akhir-</option>
					<option value="1">Tugas Akhir 1</option>		
					<option value="2">Tugas Akhir 2</option>	
				</select>
			</div>
		</div>	
	</div>
	<div class="row">
		<div class="col-sm-5">
			<div class="form-group">
				<label for="form-field-select-1">
					Pilih BAB Diskusi
				</label>
				<select name="bab" id="bab" class="form-control">
					<option value="">-Pilih BAB Diskusi-</option>
				<?php
				$bab="SELECT tb.idBab, tb.namaBab FROM tbbab tb";
				$db->runQuery($bab);
				while($new=$db->dbFetch())
				{
				?>
					<option value="<?php echo $new['idBab'];?>"><?php echo $new['namaBab'];?></option>
				<?php
				}
				?>
				</select>
			</div>
		</div>	
	</div>
	<div class="row">		
		<div class="form-group col-sm-7">
			<label class="control-label" for="form-field-1">
				Sub Bahasan Diskusi
			</label>
			
			<input type="text" placeholder="Sub Bahasan" id="sub" class="form-control" name="sub" value="<?php echo $_POST['sub'];?>">				
		</div>
	</div>
	<div class="row">
	<div class="col-sm-2">
		<div class="form-group">
			<input type="submit" class="btn btn-blue" name="simpan" value="Ajukan Diskusi">
		</div>
	</div>
	</div>
</form>
