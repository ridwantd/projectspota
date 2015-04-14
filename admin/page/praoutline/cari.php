<?php 
unset_session("prev_page");
set_session("prev_page","cari");?>
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
				Pencarian
			</li>
			<li class="search-box">
				<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
			</li>	
		</ol>
		<div class="page-header">
			<h1>Pencarian Judul Praoutline <small></small></h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<!-- start: SEARCH RESULT -->
		<div class="search-classic">
			<form method="POST" action="" id="cari">
				<input type="hidden" name="act" value="cari">
				<div class="row">
					<div class="col-sm-3">
						<div class="form-group">
							<select name="by" class="form-control">
								<option <?php echo($_POST['by']=='nim')?'selected':'';?> value="nim">N I M</option>
								<option <?php echo($_POST['by']=='judul')?'selected':'';?> value="judul">Judul Praoutline</option>
							</select>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="form-group">
							<input type="text" name="key" placeholder="Cari..." class="required form-control" value="<?php echo $_POST['key'];?>" Title="Silakan Masukkan Kata Kunci"/>
						</div>
					</div>
					<div class="col-sm-1">
						<div class="form-group">
							<input type="submit" class="form-control" name="cari" value="Cari">
						</div>
					</div>
				</div>
			</form>
			
			<div id="loading" style="display:none;text-align:center"><br/><i class="clip-spin-alt icon-spin icon-2x"></i><br/><em> Searching..</em></div>
			<div id="result-cari"></div>
		</div>
		<!-- end: SEARCH RESULT -->
	</div>
</div>