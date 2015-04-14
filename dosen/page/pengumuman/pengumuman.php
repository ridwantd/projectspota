<?php $db=new dB($dbsetting); 
if(!isset($_GET['lihat'])){
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
					Daftar Pengumuman
				</li>
				<li class="search-box">
					<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
				</li>				
			</ol>
			<div class="page-header">
				<h1>Daftar Pengumuman<!--  <small>overview &amp; stats </small> --></h1>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- start: DYNAMIC TABLE PANEL -->
			<?php
			//variabel untuk menampilkan jumlah notif ada di _header.php
			if($db->dbRows($notif_pengumuman)>0){
				if($jlh_notif_pengumuman>0){
					?>
					<div class="alert alert-warning">
						<button data-dismiss="alert" class="close">
							×
						</button>
						<i class="icon-exclamation-triangle"></i>
						Terdapat <strong><?php echo $jlh_notif_pengumuman;?></strong> Pengumuman Terbaru.
					</div>
					<?php
				}
			}
			?>
			<table class="table table-striped table-bordered table-hover table-full-width" id="list-pengumuman">
				<thead>
					<tr>
						<th style="width:50%;text-align:center">Pengumuman</th>
						<th style="width:20%;text-align:center">Tanggal</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="2" class="dataTables_empty">Loading data from server</td>
					</tr>
				</tbody>
			</table>

			<!-- end: DYNAMIC TABLE PANEL -->
		</div>
	</div>
<?php
}else{
	$idpengumuman=$_GET['lihat'];
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
				<li>
					<a href="<?php ECHO MHS_PAGE;?>dashboard.php?page=pengumuman">
						Daftar Pengumuman
					</a>
				</li>
				<li class="active">
					Lihat Pengumuman
				</li>
				<li class="search-box">
					<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
				</li>
			</ol>
			<div class="page-header">
				<h1>Lihat Pengumuman<!--  <small>overview &amp; stats </small> --></h1>
			</div>
		</div>
	</div>
	<?php
	if(ctype_digit($idpengumuman)){
		$p="SELECT tp.*, (SELECT count(idkonten) FROM tmp_notif WHERE idkonten='$idpengumuman' AND iduser='".$_SESSION['login-dosen']['id']."' AND typeuser='D') as found FROM tbpengumuman tp WHERE tp.id='$idpengumuman' AND tp.idProdi='".$_SESSION['login-dosen']['prodi']."' AND tujuan IN ('A','D') LIMIT 1";
		//echo $p;
		$db->runQuery($p);
		if($db->dbRows()>0){
			$rp=$db->dbFetch();
			if($rp['found']=='0'){
				$in="INSERT INTO tmp_notif SET idkonten='".$idpengumuman."', idProdi='".$_SESSION['login-dosen']['prodi']."', iduser='".$_SESSION['login-dosen']['id']."', typeuser='D', `date`='".NOW."', jenis='P'";
				$db->runQuery($in);
			}
			?>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<p class="lead">
								<?php echo $rp['judul'];?>
							</p>
							<p>
								<?php echo $rp['isi'];?>
							</p>
							<p>
								<label class="label label-info">Diposting tanggal <?php echo tanggalIndo($rp['tgl'],'j F y, H:i');?> </label>
							</p>
						</div>
					</div>
				</div>
			</div>
			<a href="?page=pengumuman" class="btn btn-sm btn-info">
				Kembali
			</a>
			<?php
		}else{
			echo "Not Found";
		}
	}else{
		echo "Not Found";
	}
}
?>