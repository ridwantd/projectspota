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
				List
			</li>
			
		</ol>
		<div class="page-header">
			<h1>Bahasan Diskusi <small></small></h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<?php
		$db=new dB($dbsetting);
		$nim=$_SESSION['login-mhs']['nim'];
		$check="SELECT idDiskusi FROM tbdiskusi WHERE nim='$nim'";
		$db->runQuery($check);
		if($db->dbRows()>0){
			$data="SELECT 
				td.*,
				ts.*,
				tb.*
			FROM tbdiskusi td
			LEFT JOIN tbdosen ts ON (td.pemb=ts.nip)
			LEFT JOIN tbbab tb ON (td.idBab=tb.idBab)
			WHERE td.nim='$nim' group by td.idDiskusi";
			$db->runQuery($data);
			$no=0;
			while($all=$db->dbFetch()){	
				if($all['stDiskusi']==0){
					$statusDiskusi=' - <span class="label label-default">Dalam Proses</span>';
				}else if($all['stDiskusi']==1){
					$statusDiskusi=' - <span class="label label-success">Selesai</span>';
				}			
			$no++;			
		?>
		<p><h4 style="text-align:left;margin-top:0"><a href="?page=outline&menu=review&id=<?php echo $all['idDiskusi'];?>"><?php echo $no.". ". strtoupper($all['namaBab'])." ( ".$all['subDiskusi']." )";?></a></h4></p>
		<div class="row">
			<div class="col-sm-7">
				<p style="text-indent:20px">Dosen Pembimbing : <?php echo $all['nmLengkap']." - ".tanggalIndo($all['wktMulai'],'j/m/Y'). $statusDiskusi;?></p>
			</div>
		</div>
		<?php
		}}else{
			echo "<div class='alert alert-danger'>Belum Ada Data</div>";
		}
		?>
	</div>
</div>