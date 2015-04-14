<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-home-3"></i>
				<a href="<?php ECHO MHS_PAGE;?>">
					Home
				</a>
			</li>
			<li class="active">
				Review
			</li>
			
		</ol>
		<div class="page-header">
			<h1> Review Terbaru <small></small></h1>
		</div>
	</div>
</div>
<?php
$db=new dB($dbsetting);
$nim=$_SESSION['login-mhs']['nim'];
$nama=$_SESSION['login-mhs']['nmLengkap'];
$prodi=$_SESSION['login-mhs']['prodi'];

$new="SELECT 
		td.*,
		ts.*,
		tb.*,
		tr.*
	FROM tbdiskusi td
	LEFT JOIN tbdosen ts ON (td.pemb=ts.nip)
	LEFT JOIN tbreviewdiskusi tr ON (td.idDiskusi=tr.idDiskusi)
	LEFT JOIN tbbab tb ON (td.idBab=tb.idBab)
	WHERE td.idDiskusi=tr.idDiskusi and tr.reviewer not like '$nim' and tr.status='0' and td.nim='$nim' group by td.idDiskusi";
	$db->runQuery($new);
	if($db->dbRows()>0){
		$no=0;
		while($apdet=$db->dbFetch()){
		$no++;
?>
<div class="row">
	<div class="col-md-12">
		<p><h4 style="text-align:left;margin-top:0"><a href="?page=outline&menu=review&id=<?php echo $apdet['idDiskusi'];?>"><?php echo $no.". ". strtoupper($apdet['namaBab'])." ( ".$apdet['subDiskusi']." )";?></a> <img src="../assets/images/update.gif"></h4></p>
			<div class="row">
				<div class="col-sm-7">
					<p style="text-indent:20px">Dosen Pembimbing : <?php echo $apdet['nmLengkap'];?></p>
				</div>
			</div>
		<?php
		}}else{
			echo "<div class='alert alert-danger'>Tidak Ada Data Bimbingan Terbaru</div>";
		}
		?>
	</div>
</div>