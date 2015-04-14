<?php $db=new dB($dbsetting); 
$lvl=$_SESSION['login-admin']['lvl'];
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
			<h1>Dashboard <!-- <small>overview &amp; stats </small> --></h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="well well-lg">
			<h4>Hi, <?php echo $_SESSION['login-admin']['nama_lengkap'];?></h4>
			<p>Selamat datang di halaman administrator Sistem Pendukung Outline Tugas Akhir (SPOTA) Universitas Tanjungpura</p>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-default">
			<!-- <div class="panel-heading">
				<i class="clip-calendar"></i>
				Jadwal Seminar
				<div class="panel-tools">
					<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
					</a>
					<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
						<i class="fa fa-wrench"></i>
					</a>
					<a class="btn btn-xs btn-link panel-refresh" href="#">
						<i class="fa fa-refresh"></i>
					</a>
					<a class="btn btn-xs btn-link panel-expand" href="#">
						<i class="fa fa-resize-full"></i>
					</a>
					<a class="btn btn-xs btn-link panel-close" href="#">
						<i class="fa fa-times"></i>
					</a>
				</div>
			</div> -->
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