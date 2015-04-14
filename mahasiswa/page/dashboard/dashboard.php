<?php $db=new dB($dbsetting); ?>
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
			<h1>Dashboard <!-- <small>Hi, Selamat Datang <?php echo $_SESSION['login-mhs']['nama_lengkap'];?> </small> --> </h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<!-- UCAPAN SELAMAT DATA KEPADA PENGGUNA -->
		<div class="well well-lg">
			<h4>Hi, <?php echo $_SESSION['login-mhs']['nama_lengkap'];?></h4>
			<p>Selamat datang di Sistem Pendukung Outline Tugas Akhir (SPOTA) Universitas Tanjungpura</p>
		</div>

		<!-- NOTIFIKASI JIKA JUDUL DI TOLAK -->
		<?php
		$q1="SELECT tp.id, tp.judul, tp.status_usulan, trh.ket 
		FROM tbpraoutline tp
		LEFT JOIN tbrekaphasil trh ON (tp.id=trh.idpraoutline)
		WHERE tp.nim='".$_SESSION['login-mhs']['nim']."' 
		AND tp.idProdi='".$_SESSION['login-mhs']['prodi']."' 
		ORDER BY tp.id DESC LIMIT 1";
		//echo $q1;
		$db->runQuery($q1);
		if($db->dbRows()>0){
			$r1=$db->dbFetch();
			switch($r1['status_usulan']){
				case '0':
					?>
					<div class="alert alert-block alert-info fade in">
						<h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Draft Praoutline Masih Dalam Proses Review</h4>
						<p>
							Silakan lihat menu review untuk melihat review dari dosen.
						</p>
						<p>
							<a href="?page=praoutline&menu=review" class="btn btn-blue">
								Lihat Review
							</a>
							<?php 
							//informatika only
							if($_SESSION['login-mhs']['prodi']=="2"){ ?>
							<a href="../spotaif.apk" class="btn btn-blue">
								Download Aplikasi Android
							</a>
							<?php }?>
						</p>
					</div>
					<?php
				break;

				case '1':
					?>
					<div class="alert alert-block alert-info fade in">
						<button data-dismiss="alert" class="close" type="button">
							&times;
						</button>
						<h4 class="alert-heading"><i class="icon-info-circle"></i> Draft Praoutline Anda Telah DiSetujui</h4>
						<!-- <p>
							Duis mollis, est non commodo luctus,
							nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum.
						</p> -->
						<p>
							<a href="?page=praoutline&menu=review" class="btn btn-blue">
								Lihat Putusan
							</a>
						</p>
					</div>
					<?php
				break;

				case '2':
					?>
					<div class="alert alert-block alert-danger fade in">
						<button data-dismiss="alert" class="close" type="button">
							&times;
						</button>
						<h4 class="alert-heading"><i class="fa fa-times-circle"></i> Judul yang Anda Ajukan Tidak Disetujui</h4>
						<p>Keterangan : </p>
						<p><?php echo $r1['ket'];?></p>
						<p>
							<a href="dashboard.php?page=praoutline&menu=upload" class="btn btn-bricky">
								Upload Judul Baru
							</a>
						</p>
					</div>
					<?php
				break;
			}
		}
		?>

		<!-- NOTIFIKASI BALASAN REVIEW TERBARU --> 
		<!-- NOTIFIKASI PENGUMUMAN TERBARU --> 
		<?php
		//$p="SELECT COUNT(id) as jlh FROM tbpengumuman WHERE id NOT IN (SELECT idkonten FROM tmp_notif WHERE iduser='".$_SESSION['login-mhs']['prodi']."' AND idProdi='".$_SESSION['login-mhs']['prodi']."') AND tujuan IN ('A','M')";
		$p="SELECT COUNT(id) as jlh FROM tbpengumuman WHERE id NOT IN(SELECT idkonten FROM tmp_notif WHERE iduser='".$_SESSION['login-mhs']['id']."' AND typeuser='M' AND jenis='P') AND idProdi='".$_SESSION['login-mhs']['prodi']."' AND tujuan IN ('A','M')";
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
						Tidak Terdapat Pengumuman Terbaru
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