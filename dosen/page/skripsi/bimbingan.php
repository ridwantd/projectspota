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
				Bimbingan
			</li>
			
		</ol>
		<div class="page-header">
			<h1> Bimbingan Terbaru <small></small></h1>
		</div>
	</div>
</div>
<?php
$db=new dB($dbsetting);
$nip=$_SESSION['login-dosen']['nip'];
$nama=$_SESSION['login-dosen']['nmLengkap'];
$prodi=$_SESSION['login-dosen']['prodi'];

$new="SELECT 
		td.*,
		tm.*,
		tb.*,
		tr.*
	FROM tbdiskusi td
	LEFT JOIN tbmhs tm ON (td.nim=tm.nim)
	LEFT JOIN tbreviewdiskusi tr ON (td.idDiskusi=tr.idDiskusi)
	LEFT JOIN tbbab tb ON (td.idBab=tb.idBab)
	WHERE td.idDiskusi=tr.idDiskusi and td.pemb='$nip' and tr.reviewer not like '$nip' and tr.status='0' group by td.idDiskusi";
	$db->runQuery($new);
	if($db->dbRows()>0){
		$no=0;
		while($apdet=$db->dbFetch()){
		$no++;
?>
<div class="row">
	<div class="col-md-12">
		<p><h4 style="text-align:left;margin-top:0"><a href="?page=skripsi&menu=review&id=<?php echo $apdet['idDiskusi'];?>&frcode=me"><?php echo $no.". ". strtoupper($apdet['nmLengkap']. " - ". $apdet['nim']);?></a> <img src="../assets/images/update.gif"></h4></p>
			<div class="row">
				<div class="col-sm-7">
					<p style="text-indent:20px"><?php echo $apdet['namaBab']." ( $apdet[subDiskusi] ) ";?></p>
				</div>
			</div>
		<?php
		}}else{
			echo "<div class='alert alert-danger'>Tidak Ada Data Bimbingan Terbaru</div>";
		}
		?>
	</div>
</div>