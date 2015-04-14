<?php
session_start();
include ("../../../inc/helper.php");
include ("../../../inc/konfigurasi.php");
include ("../../../inc/db.pdo.class.php");
if($_SESSION['login-admin']['lvl']=='S'){
	$db=new dB($dbsetting);
	$id=$_GET['id'];
	if(ctype_digit($id)){
		$query="SELECT tp.*,tj.nmJurusan,tf.nmFakultas FROM tbprodi tp 
		LEFT JOIN tbjurusan tj ON (tp.idJur=tj.idJur)
		LEFT JOIN tbfakultas tf ON(tp.idFak=tf.idFak) WHERE tp.idProdi='$id' LIMIT 1";
		//echo $query;
		$db->runQuery($query);
		if($db->dbRows()>0){
		$e=$db->dbFetch();
	?>
		<input type="hidden" name="act" value="update"/>
		<input type="hidden" name="idProdi" value="<?php echo $e['idProdi'];?>"/>
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
							if($e['idFak']==$j['idFak']){
								echo "<option selected value='".$j['idFak']."'>".$j['nmFakultas']."</option>";
							}else{
								echo "<option value='".$j['idFak']."'>".$j['nmFakultas']."</option>";
							}
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
					<?php
					$q="SELECT * FROM tbjurusan WHERE idFak='".$e['idFak']."' ORDER BY idFak";
					$db->runQuery($q);
					if($db->dbRows()>0){
						while($s=$db->dbFetch()){
							if($e['idJur']==$s['idJur']){
								echo "<option selected value='".$s['idJur']."'>".$s['nmJurusan']."</option>";
							}else{
								echo "<option value='".$s['idJur']."'>".$s['nmJurusan']."</option>";
							}
						}
					}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-4">Nama Program Studi</label>
			<div class="col-sm-8">
				<input type="text" name="nmProdi" value="<?php echo $e['nmProdi'];?>" class="form-control" />
			</div>
		</div>
	<?php
		}
	}
}
?>
