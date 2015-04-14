<?php $db=new dB($dbsetting); 
$lvl=$_SESSION['login-dosen']['lvl'];
?>
<div class="row">
	<div class="col-sm-12">
		<!-- start: PAGE TITLE & BREADCRUMB -->
		<ol class="breadcrumb">
			<li>
				<i class="clip-home-3"></i>
				<a href="<?php ECHO ADMIN_PAGE;?>">
					Home
				</a>
			</li>
			<li class="active">
				Dashboard
			</li>
			<li class="search-box">
				<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
			</li>
		</ol>
		<div class="page-header">
			<h1>Dashboard <!-- <small>Hi, <?php echo $_SESSION['login-dosen']['nama_lengkap'];?></small> --> </h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<!-- UCAPAN SELAMAT DATA KEPADA PENGGUNA -->
		<div class="well well-lg">
			<h4>Hi, <?php echo $_SESSION['login-dosen']['nama_lengkap'];?></h4>
			<p>Selamat datang di Sistem Pendukung Outline Tugas Akhir (SPOTA) Universitas Tanjungpura</p>
			<p>
				<?php 
				//informatika only
				if($_SESSION['login-dosen']['prodi']=="2"){ ?>
				<a href="../spotaif.apk" class="btn btn-blue">
					Download Aplikasi Android
				</a>
				<?php }?>
			</p>
		</div>
		<!-- NOTIFIKASI PENGUMUMAN TERBARU --> 
		<?php
		$p="SELECT COUNT(id) as jlh FROM tbpengumuman WHERE id NOT IN(SELECT idkonten FROM tmp_notif WHERE iduser='".$_SESSION['login-dosen']['id']."' AND typeuser='D' AND jenis='P') AND idProdi='".$_SESSION['login-dosen']['prodi']."' AND tujuan IN ('A','D')";
		//echo $p;
		$db->runQuery($p);
		if($db->dbRows()>0){
			$pp=$db->dbFetch();
			if($pp['jlh']>0){
			?>
			<div class="alert alert-block alert-warning fade in">
				<button data-dismiss="alert" class="close" type="button">
					×
				</button>
				<h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Pengumuman Terbaru</h4>
				<p>
					Terdapat <?php echo $pp['jlh'];?> Pengumuman Terbaru Yang Belum Dibaca
				</p>
				<p>
					<a href="?page=pengumuman" class="btn btn-yellow">
						Lihat Semua Pengumuman
					</a>
				</p>
			</div>
			<?php
			}else{
				?>
				<div class="alert alert-block alert-warning fade in">
					<button data-dismiss="alert" class="close" type="button">
						×
					</button>
					<h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Pengumuman Terbaru</h4>
					<p>
						Tidak Ada Pengumuman Terbaru
					</p>
					<p>
						<a href="?page=pengumuman" class="btn btn-yellow">
							Lihat Semua Pengumuman
						</a>
					</p>
				</div>
				<?php
			}
		}
		
		//NOTIFIKASI JUDUL TERBARU
		$q_jdl_terbaru="SELECT COUNT(id) as jlh FROM tbpraoutline WHERE id NOT IN(SELECT idkonten FROM tmp_notif WHERE iduser='".$_SESSION['login-dosen']['id']."' AND typeuser='D' AND jenis='J') AND status_usulan='0' ";
		//echo $p;
		$db->runQuery($q_jdl_terbaru);
		if($db->dbRows()>0){
			$jdl=$db->dbFetch();
			if($jdl['jlh']>0){
			?>
			<div class="alert alert-block alert-warning fade in">
				<button data-dismiss="alert" class="close" type="button">
					×
				</button>
				<h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Draft Praoutline Terbaru</h4>
				<p>
					Terdapat <strong><?php echo $jdl['jlh'];?></strong> Draft Praoutline Terbaru.
				</p>
				<p>
					<a href="?page=praoutline&menu=new" class="btn btn-yellow">
						Lihat Draft Praoutline Terbaru
					</a>
				</p>
			</div>
			<?php
			}else{
				?>
				<div class="alert alert-block alert-warning fade in">
					<button data-dismiss="alert" class="close" type="button">
						×
					</button>
					<h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Draft Praoutline Terbaru</h4>
					<p>
						Tidak terdapat draft praoutline terbaru.
					</p>
					<p>
						<a href="?page=praoutline&menu=new" class="btn btn-yellow">
							Lihat Draft Praoutline
						</a>
						<a href="?page=praoutline&menu=cari" class="btn btn-yellow">
							Cari Draft Praoutline
						</a>
					</p>
				</div>
				<?php
			}
		}
		?>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-body">
				<div id='calendar'></div>
			</div>
		</div>
	</div>
</div>
<div id="JadwalDetail" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
   	<form id="eform-kategori" method="post">
	   	<div class="modal-header">
	        <h4 class="modal-title" id="myModalLabel"><span id="jenis"></span></h4>
	    </div>
	  	<div class="modal-body">
	    	<table class="table" id="tbjadwal">
	    		<tr>
	    			<td>Nama</td>
	    			<td> <span id="nama"></span></td>
	    		</tr>
	    		<tr>
	    			<td>Judul Skrpsi</td>
	    			<td> <span id="judul"></span></td>
	    		</tr>
	    		<tr>
	    			<td>Tanggal / Waktu</td>
	    			<td> <span id="tgl"></span></td>
	    		</tr>
	    		<tr>
	    			<td>Ruangan</td>
	    			<td> <span id="ruangan"></span></td>
	    		</tr>
	    		<tr>
	    			<td>Pembimbing</td>
	    			<td> <span id="pembimbing1"></span><br/><span id="pembimbing2"></span></td>
	    		</tr>
	    		<tr>
	    			<td>Penguji</td>
	    			<td> <span id="penguji1"></span><br/><span id="penguji2"></span></td>
	    		</tr>
	    	</table>
	 	</div>
	  	<div class="modal-footer">
	    	<button type="button" data-dismiss="modal" class="btn btn-default">Tutup</button>
	    	<!-- <button type="submit" class="btn btn-primary">Update</button> -->
	  	</div>
  	</div>
  	 </form>
</div>