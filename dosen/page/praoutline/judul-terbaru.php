<?php $db=new dB($dbsetting); 
if(!isset($_GET['lihat'])){
?>
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
					Daftar Draft Praoutline 
				</li>
				<li class="search-box">
					<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
				</li>				
			</ol>
			<div class="page-header">
				<h1>Daftar Draft Praoutline<!--  <small>overview &amp; stats </small> --></h1>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- start: DYNAMIC TABLE PANEL -->
			<?php
			$q_jdl_terbaru="SELECT COUNT(id) as jlh FROM tbpraoutline WHERE id NOT IN (SELECT idkonten FROM tmp_notif WHERE iduser='".$_SESSION['login-dosen']['id']."' AND typeuser='D' AND jenis='J') AND status_usulan='0' ";
			//echo $q_jdl_terbaru;
				$notif_jdl_terbaru=$db->runQuery($q_jdl_terbaru);
				$rjdl_terbaru=$db->dbFetch($notif_jdl_terbaru);
				$jlh_notif_jdl_terbaru=$rjdl_terbaru['jlh'];
			//variabel untuk menampilkan jumlah notif ada di _header.php
			if($db->dbRows($notif_jdl_terbaru)>0){
				if($jlh_notif_jdl_terbaru>0){
					?>
					<div class="alert alert-warning">
						<button data-dismiss="alert" class="close">
							×
						</button>
						<i class="icon-exclamation-triangle"></i>
						Terdapat <strong><?php echo $jlh_notif_jdl_terbaru;?></strong> Draft Praoutline Terbaru.
					</div>
					<?php
				}
			}
			?>
			<table class="table table-striped table-bordered table-hover table-full-width" id="list-judul">
				<thead>
					<tr>
						<th style="width:15%;text-align:center">Nama Mahasiswa</th>
						<th style="width:50%;text-align:center">Judul Tugas Akhir</th>
						<th style="width:15%;text-align:center">Tahun Ajaran</th>
						<th style="width:15%;text-align:center">Tanggal</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="4" class="dataTables_empty">Loading data from server</td>
					</tr>
				</tbody>
			</table>

			<!-- end: DYNAMIC TABLE PANEL -->
		</div>
	</div>
<?php
}
?>