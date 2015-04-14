<?php
session_start();
if($_SESSION['login-admin']['lvl']=='S'){
?>
	<input type="hidden" name="act" value="insert"/>
	<div class="form-group">
		<label class="col-sm-3">Kode Fakultas *</label>
		<div class="col-sm-8">
			<input type="text" name="idFak" class="form-control"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3">Nama Fakultas</label>
		<div class="col-sm-8">
			<input type="text" name="nmFakultas" class="form-control" />
		</div>
	</div>
<?php } ?>