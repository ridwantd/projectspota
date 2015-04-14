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
		<label class="col-sm-4">Fakultas</label>
		<div class="col-sm-8">
			<select name="idFak" id="fromidfak" class="form-control" onChange='getJurusan()'>
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
		<label class="col-sm-4">Jurusan</label>
		<div class="col-sm-8">
			<select name="idJur" class="form-control selectJur" id="selectJur">
				<option value="">-Pilih Jurusan-</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-4">Nama Program Studi</label>
		<div class="col-sm-8">
			<input type="text" name="nmProdi" class="form-control" />
		</div>
	</div>
<?php } ?>