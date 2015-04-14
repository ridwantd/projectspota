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
			<li>
				<a href="<?php ECHO ADMIN_PAGE;?>dashboard.php?page=user&menu=man-user">
					User
				</a>
			</li>
			<li class="active">
				Manajemen Admin
			</li>
			
		</ol>
		<div class="page-header">
			<h1>Manajemen Admin SPOTA</h1>
		</div>
	</div>
</div>
<!-- <button class="btn btn-primary btn-sm" id="btnTambahUser"><i class="clip-user-6"></i> Buat User Baru</button> -->
<a href="page/user/form-tambahuser.php" class="btn btn-primary btn-sm" data-target="#tambahuser" data-toggle="modal"><i class="clip-user-6"></i> Buat User Baru</a>
<hr/>
<div class="row">
	<div class="col-md-12">
		<!-- start: DYNAMIC TABLE PANEL -->
		<table class="table table-striped table-bordered table-hover table-full-width" id="daftar-user">
			<thead>
				<tr>
					<th style="width:30%;text-align:center">Nama & Username</th>
					<th style="width:20%;text-align:center">Jabatan</th>
					<th style="width:20%text-align:center">NIP</th>
					<th style="width:20%text-align:center">Program Studi</th>
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

<div id="tambahuser" class="modal fade" tabindex="-1" data-backdrop="static" data-width="760" data-keyboard="false" style="display: none;">
   	<form id="tambahuserbaru" action="" method="post" class="form-horizontal">
	   	<div class="modal-header">
	        <h4 class="modal-title" id="myModalLabel">Tambah Admin</h4>
	    </div>
	  	<div class="modal-body"></div>
	  	<div class="modal-footer">
	    	<button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Batal</button>
	    	<button type="submit" class="btn btn-primary btn-sm">Tambah</button>
	  	</div>
  	</div>
  </form> 
</div>
<div id="edituser" class="modal fade" tabindex="-1" data-backdrop="static" data-width="760" data-keyboard="false" style="display: none;">
   	<form id="editdatauser" action="" method="post" class="form-horizontal">
	   	<div class="modal-header">
	        <h4 class="modal-title" id="myModalLabel">Edit Admin</h4>
	    </div>
	  	<div class="modal-body"></div>
	  	<div class="modal-footer">
	    	<button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Batal</button>
	    	<button type="submit" class="btn btn-primary btn-sm">Update</button>
	  	</div>
  	</div>
  </form> 
</div>