<?php $db=new dB($dbsetting); ?>
<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-home-3"></i>
				<a href="<?php ECHO DOSEN_PAGE;?>">
					Home
				</a>
			</li>
			<li class="active">
				Statistik Draf Praoutline 
			</li>
			<li class="search-box">
				<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
			</li>				
		</ol>
		<div class="page-header">
			<h1>Statistik Draf Praoutline<!--  <small>overview &amp; stats </small> --></h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<h3>Statistik Draft Praoutline</h3>
		<table class="table table-striped table-bordered table-hover table-full-width" id="stat-draft-praoutline">
			<thead>
				<tr>
					<th style="width:15%;text-align:center">Semester</th>
					<th style="width:8%;text-align:center">Draft Dalam Proses</th>
					<th style="width:8%;text-align:center">Draft Diterima</th>
					<th style="width:8%;text-align:center">Draft Ditolak</th>
					<th style="width:8%;text-align:center">Draft Gugur</th>
					<th style="width:8%;text-align:center">Total</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="6" class="dataTables_empty">Loading data from server</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="col-md-6">
		<h3>Statistik Dosen</h3>
		<?php
		$qlistsmt="SELECT DISTINCT(semester) as smt FROM tbpraoutline
			WHERE idProdi='".$_SESSION['login-dosen']['prodi']."' ORDER BY semester DESC";
		$db->runQuery($qlistsmt);
		if($db->dbRows()>0){
			while($smt=$db->dbFetch()){
				$listsmt[]=$smt['smt'];
			}
		}

		if($_GET['smt']!=""){
			$filtersmt="'".$_GET['smt']."' ";
		}else{
			$filtersmt="(SELECT `values` FROM web_setting WHERE `name`='smt' AND idProdi='".$_SESSION['login-dosen']['prodi']."')";
		}

		$q="SELECT COUNT(if(trh.pemb1=td.nip,1,null)) as pemb1,
			COUNT(if(trh.pemb2=td.nip,1,null)) as pemb2,
			COUNT(if(trh.peng1=td.nip,1,null)) as peng1,
			COUNT(if(trh.peng2=td.nip,1,null)) as peng2
		FROM tbrekaphasil trh,tbdosen td 
		WHERE td.nip='".$_SESSION['login-dosen']['nip']."' AND trh.semester=$filtersmt 
		GROUP BY td.nip";
		//echo $q;
		$db->runQuery($q);
		$rs=$db->dbFetch();
		?>
		<select class="form-control" onChange="viewDataStat(this.value)">
			<?php
			for($c=0;$c<count($listsmt);$c++){
				if($_GET['smt']==$listsmt[$c]){
					echo '<option selected value="'.$listsmt[$c].'">'.$listsmt[$c].'</option>';
				}else{
					echo '<option value="'.$listsmt[$c].'">'.$listsmt[$c].'</option>';
				}
				
			}
			?>
		</select>
		<br/>
		<table class="table table-striped table-bordered table-hover">
			<tr>
				<td>Nama Dosen</td>
				<td>Pembimbing 1</td>
				<td>Pembimbing 2</td>
				<td>Penguji 1</td>
				<td>Penguji 2</td>
			</tr>
			<tr>
				<td><?php echo $_SESSION['login-dosen']['nama_lengkap'];?></td>
				<td><?php echo $rs['pemb1'];?></td>
				<td><?php echo $rs['pemb2'];?></td>
				<td><?php echo $rs['peng1'];?></td>
				<td><?php echo $rs['peng2'];?></td>
			</tr>
		</table>
		<!--<table class="table table-striped table-bordered table-hover table-full-width" id="stat-dosen">
			<thead>
				<tr>
					<th style="width:15%;text-align:center">Semester</th>
					<th style="width:8%;text-align:center">Draft Dalam Proses</th>
					<th style="width:8%;text-align:center">Draft Diterima</th>
					<th style="width:8%;text-align:center">Draft Ditolak</th>
					<th style="width:8%;text-align:center">Draft Gugur</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="5" class="dataTables_empty">Loading data from server</td>
				</tr>
			</tbody>
		</table> -->
	</div>
</div>
<?php
if($_SESSION['login-dosen']['jenisdosen']=='K'){
?>
<div class="row">
	<div class="col-md-10">
		<hr/>
		<h3>Statistik Keseluruhan Dosen</h3>
		<table class="table table-striped table-bordered table-hover table-full-width" id="stat-keldosen">
			<thead>
				<tr>
					<th style="width:15%;text-align:center">Nama Dosen</th>
					<th style="width:10%;text-align:center">NIP</th>
					<th style="width:5%;text-align:center">Sbg Pembimbing 1</th>
					<th style="width:5%;text-align:center">Sbg Pembimbing 2</th>
					<th style="width:5%;text-align:center">Sbg Penguji 1</th>
					<th style="width:5%;text-align:center">Sbg Penguji 2</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="6" class="dataTables_empty">Loading data from server</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="modal fade" id="mhsmodal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">Daftar Mahasiswa</h4>
			</div>
			<div class="modal-body">
				<span id="datadaftar"></span>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal">
					OK
				</button>
			</div>
		</div>
	</div>
</div>

<?php
}
?>
