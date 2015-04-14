<?php
session_start();
include ("../../../inc/helper.php");
include ("../../../inc/konfigurasi.php");
include ("../../../inc/db.pdo.class.php");

if($_SESSION['login-admin']['lvl']=='S'){
	$db=new dB($dbsetting);
?>
	<input type="hidden" name="act" value="insert"/>
	<div class="form-group">
		<label class="col-sm-3">Fakultas</label>
		<div class="col-sm-8">
			<select name="idFak" class="form-control">
				<option value="">-Pilih Fakultas-</option>
				<?php
				$q="SELECT * FROM tbfakultas ORDER BY idFak";
				$db->runQuery($q);
				if($db->dbRows()>0){
					while($j=$db->dbFetch()){
						echo "<option value='".$j['idFak']."'>".$j['nmFakultas']."</option>";
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3">Nama Jurusan</label>
		<div class="col-sm-8">
			<input type="text" name="nmJurusan" class="form-control" />
		</div>
	</div>
<?php } ?>