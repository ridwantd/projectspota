<?php
session_start();
include ("inc/helper.php");
include ("inc/konfigurasi.php");
include ("inc/db.pdo.class.php");

$smt=$_GET['smt'];
if($smt!=""){
	$db=new dB($dbsetting);
	if($_GET['detail']==""){
		$q="SELECT td.nip,td.nmLengkap, COUNT(if(trh.pemb1=td.nip,1,null)) as pemb1,
					COUNT(if(trh.pemb2=td.nip,1,null)) as pemb2,
					COUNT(if(trh.peng1=td.nip,1,null)) as peng1,
					COUNT(if(trh.peng2=td.nip,1,null)) as peng2
				FROM tbrekaphasil trh,tbdosen td 
				WHERE  trh.semester='$smt'
				AND td.status='A'
				GROUP BY td.nip
				ORDER BY td.nip
				";

		$db->runQuery($q);
		?>
		<h3>Statistik Dosen <?php echo $smt ;?></h3>
		<table border="1">
		<tr>
			<td>Nama</td>
			<td>NIP</td>
			<td>Pembimbing 1</td>
			<td>Pembimbing 2</td>
			<td>Penguji 1</td>
			<td>Penguji 2</td>
		</tr>
		<?php
		if($db->dbRows()>0){
			while($stat=$db->dbFetch()){
				echo '<tr>
			<td>'.$stat['nmLengkap'].'</td>
			<td>'.$stat['nip'].'</td>
			<td style="text-align:center"><a href="?smt='.$smt.'&detail='.$stat['nip'].'&show=pemb1">'.$stat['pemb1'].'</a></td>
			<td style="text-align:center"><a href="?smt='.$smt.'&detail='.$stat['nip'].'&show=pemb2">'.$stat['pemb2'].'</a></td>
			<td style="text-align:center"><a href="?smt='.$smt.'&detail='.$stat['nip'].'&show=peng1">'.$stat['peng1'].'</a></td>
			<td style="text-align:center"><a href="?smt='.$smt.'&detail='.$stat['nip'].'&show=peng2">'.$stat['peng2'].'</a></td>
		</tr>';
			}
		}
		?>
		</table>
		<?php
	}else{
		$nip=$_GET['detail'];
		$jenis=$_GET['show'];
		$d="SELECT nmLengkap FROM tbdosen WHERE nip='$nip'";
		$db->runQuery($d);
		if($db->dbRows()>0){
			$dosen=$db->dbFetch();
		}
		switch($jenis){
			case 'pemb1':
				$qq="SELECT tm.nim, tm.nmLengkap, trh.judul_final
			FROM tbrekaphasil trh
	        LEFT JOIN tbdosen td ON (trh.pemb1=td.nip)
	        LEFT JOiN tbmhs tm ON (trh.nim=tm.nim)
			WHERE  trh.semester='$smt' AND td.nip='$nip'";
			$txt="Sebagai Pembimbing 1";
			break;
			
			case 'pemb2':
				$qq="SELECT tm.nim, tm.nmLengkap, trh.judul_final
			FROM tbrekaphasil trh
	        LEFT JOIN tbdosen td ON (trh.pemb2=td.nip)
	        LEFT JOiN tbmhs tm ON (trh.nim=tm.nim)
			WHERE  trh.semester='$smt' AND td.nip='$nip'";
			$txt="Sebagai Pembimbing 2";
			break;
			
			case 'peng1':
				$qq="SELECT tm.nim, tm.nmLengkap, trh.judul_final
			FROM tbrekaphasil trh
	        LEFT JOIN tbdosen td ON (trh.peng1=td.nip)
	        LEFT JOiN tbmhs tm ON (trh.nim=tm.nim)
			WHERE  trh.semester='$smt' AND td.nip='$nip'";
			$txt="Sebagai Penguji 1";
			break;
			
			case 'peng2':
				$qq="SELECT tm.nim, tm.nmLengkap, trh.judul_final
			FROM tbrekaphasil trh
	        LEFT JOIN tbdosen td ON (trh.peng2=td.nip)
	        LEFT JOiN tbmhs tm ON (trh.nim=tm.nim)
			WHERE  trh.semester='$smt' AND td.nip='$nip'";
			$txt="Sebagai Penguji 2";
			break;
		}
		
		//echo $qq;
		
		$db->runQuery($qq);
		echo $dosen['nmLengkap']." : ";
		echo $txt."<br/>";
		echo '<p>Daftar Mahasiswa<br/>';
		echo 'semester : '.$smt.'</p>';
		echo '<table border="1">';
		echo '<tr>
			<td>NIM</td>
			<td>Nama Mahasiswa</td>
			<td>Judul</td>
		</tr> ';
		if($db->dbRows()>0){
			while($m=$db->dbFetch()){
				echo '<tr>
			<td>'.$m['nim'].'</td>
			<td>'.$m['nmLengkap'].'</td>
			<td>'.$m['judul_final'].'</td>
		</tr> ';
			}
		}
		echo '</table>'; 
	}
}else{
	$db2=new dB($dbsetting);
	if($_GET['detail']==""){
		$q="SELECT td.nip,td.nmLengkap, COUNT(if(trh.pemb1=td.nip,1,null)) as pemb1,
					COUNT(if(trh.pemb2=td.nip,1,null)) as pemb2,
					COUNT(if(trh.peng1=td.nip,1,null)) as peng1,
					COUNT(if(trh.peng2=td.nip,1,null)) as peng2
				FROM tbrekaphasil trh,tbdosen td 
				WHERE td.status='A'
				GROUP BY td.nip
				ORDER BY td.nip
				";

		$db2->runQuery($q);
		?>
		<h3>Statistik Dosen <?php echo $smt ;?></h3>
		<table border="1">
		<tr>
			<td>Nama</td>
			<td>NIP</td>
			<td>Pembimbing 1</td>
			<td>Pembimbing 2</td>
			<td>Penguji 1</td>
			<td>Penguji 2</td>
		</tr>
		<?php
		if($db2->dbRows()>0){
			while($stat=$db2->dbFetch()){
				echo '<tr>
			<td>'.$stat['nmLengkap'].'</td>
			<td>'.$stat['nip'].'</td>
			<td style="text-align:center"><a href="?detail='.$stat['nip'].'&show=pemb1">'.$stat['pemb1'].'</a></td>
			<td style="text-align:center"><a href="?detail='.$stat['nip'].'&show=pemb2">'.$stat['pemb2'].'</a></td>
			<td style="text-align:center"><a href="?detail='.$stat['nip'].'&show=peng1">'.$stat['peng1'].'</a></td>
			<td style="text-align:center"><a href="?detail='.$stat['nip'].'&show=peng2">'.$stat['peng2'].'</a></td>
		</tr>';
			}
		}
		?>
		</table>
		<?php
	}else{
		$nip=$_GET['detail'];
		$jenis=$_GET['show'];
		$d="SELECT nmLengkap FROM tbdosen WHERE nip='$nip'";
		$db2->runQuery($d);
		if($db2->dbRows()>0){
			$dosen=$db2->dbFetch();
		}
		switch($jenis){
			case 'pemb1':
				$qq="SELECT tm.nim, tm.nmLengkap, trh.judul_final, trh.semester
			FROM tbrekaphasil trh
	        LEFT JOIN tbdosen td ON (trh.pemb1=td.nip)
	        LEFT JOiN tbmhs tm ON (trh.nim=tm.nim)
			WHERE  td.nip='$nip' ORDER BY trh.semester, tm.nim";
			$txt="Sebagai Pembimbing 1";
			break;
			
			case 'pemb2':
				$qq="SELECT tm.nim, tm.nmLengkap, trh.judul_final, trh.semester
			FROM tbrekaphasil trh
	        LEFT JOIN tbdosen td ON (trh.pemb2=td.nip)
	        LEFT JOiN tbmhs tm ON (trh.nim=tm.nim)
			WHERE  td.nip='$nip' ORDER BY trh.semester, tm.nim";
			$txt="Sebagai Pembimbing 2";
			break;
			
			case 'peng1':
				$qq="SELECT tm.nim, tm.nmLengkap, trh.judul_final, trh.semester
			FROM tbrekaphasil trh
	        LEFT JOIN tbdosen td ON (trh.peng1=td.nip)
	        LEFT JOiN tbmhs tm ON (trh.nim=tm.nim)
			WHERE  td.nip='$nip' ORDER BY trh.semester, tm.nim";
			$txt="Sebagai Penguji 1";
			break;
			
			case 'peng2':
				$qq="SELECT tm.nim, tm.nmLengkap, trh.judul_final, trh.semester
			FROM tbrekaphasil trh
	        LEFT JOIN tbdosen td ON (trh.peng2=td.nip)
	        LEFT JOiN tbmhs tm ON (trh.nim=tm.nim)
			WHERE td.nip='$nip' ORDER BY trh.semester, tm.nim";
			$txt="Sebagai Penguji 2";
			break;
		}
		
		//echo $qq;
		
		$db2->runQuery($qq);
		echo $dosen['nmLengkap']." : ";
		echo $txt."<br/>";
		echo '<p>Daftar Mahasiswa</p>';
		echo '<table border="1">';
		echo '<tr>
			<td>NIM</td>
			<td>Nama Mahasiswa</td>
			<td>Judul</td>
			<td>Semester</td>
		</tr> ';
		if($db2->dbRows()>0){
			while($m=$db2->dbFetch()){
				echo '<tr>
			<td>'.$m['nim'].'</td>
			<td>'.$m['nmLengkap'].'</td>
			<td>'.$m['judul_final'].'</td>
			<td>'.$m['semester'].'</td>
		</tr> ';
			}
		}
		echo '</table>'; 
	}
}
?>