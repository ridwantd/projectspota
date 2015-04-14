<?php
session_start();
include ("../../../inc/helper.php");
include ("../../../inc/konfigurasi.php");
include ("../../../inc/db.pdo.class.php");
if($_SESSION['login-admin']['lvl']=='S'){
	$db=new dB($dbsetting);
	$id=$_GET['id'];
	if(ctype_digit($id)){
		$query="SELECT tj.*,tf.nmFakultas FROM tbjurusan tj LEFT JOIN tbfakultas tf ON(tj.idFak=tf.idFak) WHERE tj.idJur='$id' LIMIT 1";
		//echo $query;
		$db->runQuery($query);
		if($db->dbRows()>0){
		$e=$db->dbFetch();
	?>
		<input type="hidden" name="act" value="update"/>
		<input type="hidden" name="idJur" value="<?php echo $e['idJur'];?>"/>
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
			<label class="col-sm-3">Nama Jurusan</label>
			<div class="col-sm-8">
				<input type="text" name="nmJurusan" value="<?php echo $e['nmJurusan'];?>" class="form-control" />
			</div>
		</div>
	<?php
		}
	}
}
?>
