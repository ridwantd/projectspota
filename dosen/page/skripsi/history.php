<?php
	$db=new dB($dbsetting);
	$nim=$_GET['nim'];
	$nip=$_SESSION['login-dosen']['nip'];
?>
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
				Forum
			</li>	
		</ol>		
		<div class="page-header">
			<h1> Riwayat Diskusi <small><?php echo "$nim";?></small></h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
	<?php
		$ds="SELECT 
				td.*,
				ts.*,
				tb.*
			FROM tbdiskusi td
			LEFT JOIN tbdosen ts ON (td.pemb=ts.nip)
			LEFT JOIN tbbab tb ON (td.idBab=tb.idBab)
			WHERE td.nim='$nim'";
		$db->runQuery($ds);
		$no=0;
		while($diskusi=$db->dbFetch()){
		$no++;		
			if($diskusi['stDiskusi']==0){
				$statusDiskusi=' - <span class="label label-default">Dalam Proses</span>';
			}else if($diskusi['stDiskusi']==1){
				$statusDiskusi=' - <span class="label label-success">Selesai</span>';
			}					
	?>
	<p><h4 style="text-align:left;margin-top:0"><a href="<?php if($diskusi['pemb']==$nip){echo "?page=skripsi&menu=review&id=$diskusi[idDiskusi]&frcode=me";}else{echo "?page=skripsi&menu=review&id=$diskusi[idDiskusi]&frcode=yo";};?>"><?php echo $no.". ". strtoupper($diskusi['namaBab'])." ( ".$diskusi['subDiskusi']." )";?></a></h4></p>
		<div class="row">
			<div class="col-sm-7">
				<p style="text-indent:20px">Dosen Pembimbing : <?php echo $diskusi['nmLengkap']." - ".tanggalIndo($diskusi['wktMulai'],'j/m/Y'). $statusDiskusi;?></p>
			</div>
		</div>
		<?php
		}
		?>
	</div>
</div>
	