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
			<li><a href="<?php ECHO ADMIN_PAGE;?>dashboard.php?page=jadwal" >
				Manajemen Jadwal Seminar/Sidang </a>
			</li>
			<li class="active">
				Kalender
			</li>
			<li class="search-box">
				<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
			</li>
			
		</ol>
		<div class="page-header">
			<h1>Kalender</h1>
		</div>
	</div>
</div>
<div class="panel-body">
	<div class="col-sm-9">
		<div id='calendar'></div>
	</div>
	<div class="col-sm-3">
		<h4>Keterangan</h4>
		<div id="event-categories">
			<div class="event-category label-green" data-class="label-green">
				<i class="fa fa-move"></i>
				Seminar Outline
			</div>
			<div class="event-category label-orange" data-class="label-orange">
				<i class="fa fa-move"></i>
				Sidang Akhir
			</div>
			<div class="event-category label-teal" data-class="label-teal">
				<i class="fa fa-move"></i>
				Lainnya
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