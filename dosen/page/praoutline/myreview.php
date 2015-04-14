<?php $db=new dB($dbsetting);  ?>
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
			<h1>Daftar Draft Praoutline <small> yang pernah dikomentari/ditanggapi </small></h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<!-- start: DYNAMIC TABLE PANEL -->
		<table class="table table-striped table-bordered table-hover table-full-width" id="list-myreview">
			<thead>
				<tr>
					<th style="width:15%;text-align:center">Nama Mahasiswa</th>
					<th style="width:50%;text-align:center">Judul Tugas Akhir</th>
					<th style="width:10%;text-align:center">Tahun Ajaran</th>
					<th style="width:15%;text-align:center">Tanggal</th>
					<th style="width:10%;text-align:center">Status</th>
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