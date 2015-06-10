<script type="text/javascript">print()</script>
<?php
include ("inc/helper.php");
include ("inc/konfigurasi.php");
include ("inc/db.pdo.class.php");

$db=new dB($dbsetting);

$idpraoutline=$_GET['rev_id'];
if(!ctype_digit($idpraoutline)){
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="all">
	<!-- <link rel="stylesheet" href="assets/fonts/style.css">
	<link rel="stylesheet" href="assets/css/main.css"> -->
	
</head>
<body>
	
<div class="container">
	<h3>REVIEW SPOTA MAHASISWA</h3>
<?php
	$rev="SELECT tr.*,td.nmLengkap as nmDosen,td.foto as ftdosen, tm.nmLengkap as nmMhs,tm.foto as ftmhs FROM tbreview tr 
	LEFT JOIN tbdosen td ON (td.nip=tr.reviewer)
	LEFT JOIN tbmhs tm ON (tm.nim=tr.reviewer)
	GROUP BY tr.id HAVING tr.idpraoutline='{$idpraoutline}'";
	//echo $rev;
	$db->runQuery($rev);
	if($db->dbRows()>0){
		echo '<table class="table table-bordered">';
		while($r=$db->dbFetch()){
			if(!ctype_digit($r['reviewer'])){
				$nama=$r['nmMhs'];
			}else{
				$nama=$r['nmDosen'];
			}

			if($r['putusan']=='1'){
				$putusan="Setuju";
			}else if($r['putusan']=='0'){
				$putusan="Tidak Setuju";
			}else{
				$putusan="";
			}

			?>
				<tr>
					<td style="width:25%"><strong><?php echo $nama;?> </strong><br/><?php echo tanggalIndo($r['tgl'],'j F Y') ;?>, <?php echo substr($r['wkt'], 0,5);?></td>
					<td><?php echo bbcode_quote($r['review_text']);?></td>
					<td style="width:10%"><?php echo $putusan;?></td>
				</tr>						
			<?php
		}
		echo '</table>';
		echo '<em>Dicetak pada : '.NOW.'</em>';
	}else{
		echo '<div class="alert alert-danger">
				<i class="clip-cancel-circle"></i>
				<strong>Maaf!</strong> Belum Ada Review..
			</div>';
	}
?>
</div>

	<script src="js/jquery-1.8.3.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>