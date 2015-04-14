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
			<!-- <li>
				<a href="<?php ECHO ADMIN_PAGE;?>dashboard.php?page=data&menu=data-jurusan">
					Data
				</a>
			</li> -->
			<li class="active">
				Data Jurusan
			</li>
			<li class="search-box">
				<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
			</li>
			
		</ol>
		<div class="page-header">
			<h1>Data Jurusan<!--  <small>overview &amp; stats </small> --></h1>
		</div>
	</div>
</div>
<a href="page/manajemendata/form-tambahjurusan.php" class="btn btn-primary btn-sm" data-target="#tambahjurusan" data-toggle="modal"><i class="clip-user-6"></i> Tambah Jurusan Baru</a>
<hr/>
<div class="row">
	<div class="col-md-12">
		<!-- start: DYNAMIC TABLE PANEL -->
		<table class="table table-striped table-bordered table-hover table-full-width" id="data-jurusan">
			<thead>
				<tr>
					<th style="width:10%;text-align:center">Kode Fakultas</th>
					<th style="width:20%;text-align:center">Nama Fakultas</th>
					<th style="text-align:center">Nama Jurusan</th>
					<th style="width:10%;text-align:center">Aksi</th>
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

<div id="tambahjurusan" class="modal fade" tabindex="-1" data-backdrop="static" data-width="460" data-keyboard="false" style="display: none;">
   	<form id="tambahdatajur" action="" method="post" class="form-horizontal">
	   	<div class="modal-header">
	        <h4 class="modal-title" id="myModalLabel">Tambah Data Jurusan </h4>
	    </div>
	  	<div class="modal-body"></div>
	  	<div class="modal-footer">
	    	<button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Batal</button>
	    	<button type="submit" class="btn btn-primary btn-sm">Tambah</button>
	  	</div>
  	</div>
  </form> 
</div>
<div id="editjurusan" class="modal fade" tabindex="-1" data-backdrop="static" data-width="460" data-keyboard="false" style="display: none;">
   	<form id="editdatajur" action="" method="post" class="form-horizontal">
	   	<div class="modal-header">
	        <h4 class="modal-title" id="myModalLabel">Edit Data Jurusan</h4>
	    </div>
	  	<div class="modal-body"></div>
	  	<div class="modal-footer">
	    	<button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Batal</button>
	    	<button type="submit" class="btn btn-primary btn-sm">Update</button>
	  	</div>
  	</div>
  </form> 
</div>
