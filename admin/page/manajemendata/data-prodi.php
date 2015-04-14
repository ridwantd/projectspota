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
				<a href="<?php ECHO ADMIN_PAGE;?>dashboard.php?page=data&menu=data-prodi">
					Data
				</a>
			</li> -->
			<li class="active">
				Data Program Studi
			</li>
			<li class="search-box">
				<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
			</li>
			
		</ol>
		<div class="page-header">
			<h1>Data Program Studi<!--  <small>overview &amp; stats </small> --></h1>
		</div>
	</div>
</div>
<a href="page/manajemendata/form-tambahprodi.php" class="btn btn-primary btn-sm" data-target="#tambahprodi" data-toggle="modal"><i class="clip-user-6"></i> Tambah Program Studi</a>
<hr/>
<div class="row">
	<div class="col-md-12">
		<!-- start: DYNAMIC TABLE PANEL -->
		<table class="table table-striped table-bordered table-hover table-full-width" id="data-prodi">
			<thead>
				<tr>
					<th style="width:10%;text-align:center">Kode Fakultas</th>
					<th style="width:20%;text-align:center">Nama Fakultas</th>
					<th style="width:20%;text-align:center">Nama Jurusan</th>
					<th style="text-align:center">Nama Program Studi</th>
					<th style="width:10%;text-align:center">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="5" class="dataTables_empty">Loading data from server</td>
				</tr>
			</tbody>
		</table>

		<!-- end: DYNAMIC TABLE PANEL -->
	</div>
</div>

<div id="tambahprodi" class="modal fade" tabindex="-1" data-backdrop="static" data-width="560" data-keyboard="false" style="display: none;">
   	<form id="tambahdataprodi" action="" method="post" class="form-horizontal">
	   	<div class="modal-header">
	        <h4 class="modal-title" id="myModalLabel">Tambah Data Program Studi </h4>
	    </div>
	  	<div class="modal-body"></div>
	  	<div class="modal-footer">
	    	<button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Batal</button>
	    	<button type="submit" class="btn btn-primary btn-sm">Tambah</button>
	  	</div>
  	</div>
  </form> 
</div>
<div id="editprodi" class="modal fade" tabindex="-1" data-backdrop="static" data-width="560" data-keyboard="false" style="display: none;">
   	<form id="editdataprodi" action="" method="post" class="form-horizontal">
	   	<div class="modal-header">
	        <h4 class="modal-title" id="myModalLabel">Edit Data Program Studi</h4>
	    </div>
	  	<div class="modal-body"></div>
	  	<div class="modal-footer">
	    	<button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Batal</button>
	    	<button type="submit" class="btn btn-primary btn-sm">Update</button>
	  	</div>
  	</div>
  </form> 
</div>
