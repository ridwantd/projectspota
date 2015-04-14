<?php
session_start();
include ("../../../inc/helper.php");
include ("../../../inc/konfigurasi.php");
include ("../../../inc/db.pdo.class.php");
if($_SESSION['login-admin']['lvl']=='S'){
	$db=new dB($dbsetting);
	$id=$_GET['kode'];
	if(ctype_alpha($id)){
		$query="SELECT * FROM tbfakultas WHERE idFak='$id' LIMIT 1";
		$db->runQuery($query);
		if($db->dbRows()>0){
		$e=$db->dbFetch();
	?>
		<input type="hidden" name="act" value="update"/>
		<div class="form-group">
			<label class="col-sm-3">Kode Fakultas *</label>
			<div class="col-sm-8">
				<input type="text" name="idFak" readonly value="<?php echo $e['idFak'];?>" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3">Nama Fakultas</label>
			<div class="col-sm-8">
				<input type="text" name="nmFakultas" value="<?php echo $e['nmFakultas'];?>" class="form-control" />
			</div>
		</div>
		

	<?php
		}
	}
}
?>
