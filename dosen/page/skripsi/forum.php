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
			<h1> Forum Pembimbing <small></small></h1>
		</div>
	</div>
</div>
<!-- end: PAGE HEADER -->
<?php
/*$db=new dB($dbsetting);
$nim=$_SESSION['login-mhs']['nim'];
$prodi=$_SESSION['login-mhs']['prodi'];
$check="SELECT id FROM tbrekaphasil WHERE nim='$nim' and idProdi='$prodi'";
$db->runQuery($check);
if($db->dbRows()>0){
	$tab="SELECT 
		tr.*,
		tm.nim,
		tm.nmLengkap as namaMhs
	FROM tbrekaphasil tr
	LEFT JOIN tbmhs tm ON (tr.nim=tm.nim)
	WHERE tr.nim='$nim'";
	$db->runQuery($tab);
	while($table=$db->dbFetch()){*/
?>
<!-- start: PAGE CONTENT -->
<?php
	$db=new dB($dbsetting);
	$nip=$_SESSION['login-dosen']['nip'];
	$prodi=$_SESSION['login-dosen']['prodi'];
	$check="SELECT * FROM tbrekaphasil WHERE idProdi='$prodi'";
	$db->runQuery($check);
	if($db->dbRows()>0){
		$tab="SELECT 
			tr.*,
			tm.nim,
			tm.nmLengkap as namaMhs,
			(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=pemb1) as dpemb1,
			(SELECT nmLengkap FROM tbdosen WHERE tbdosen.nip=pemb2) as dpemb2,
			(SELECT COUNT(idForum) FROM tbforum WHERE tbforum.idRekap=id AND tbforum.nim=nim GROUP BY tbforum.idRekap) as jumrev,
			(SELECT tglwkt FROM tbforum WHERE tbforum.idRekap=id ORDER BY tglwkt DESC LIMIT 1) as tgl,
			(SELECT tbdosen.nmLengkap FROM tbdosen,tbforum WHERE tbforum.idRekap=id AND tbforum.nip=tbdosen.nip ORDER BY tbforum.tglwkt DESC LIMIT 1) as nama
		FROM tbrekaphasil tr
		LEFT JOIN tbmhs tm ON (tr.nim=tm.nim)
		WHERE tr.pemb1='$nip' or tr.pemb2='$nip'
		";
		$db->runQuery($tab);
		
?>
<div class="row">
	<div class="col-md-12">
		<!-- start: DYNAMIC TABLE PANEL -->
		<div class="panel panel-default">
			<div class="panel-body">
				<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
					<thead>
						<tr>
							<th></th>
							<th width="500px">Tugas Akhir Mahasiswa</th>
							<th>Pembimbing 1</th>
							<th>Pembimbing 2</th>
							<th width="50px">Diskusi</th>
							<th>Perbaruan Terakhir</th>
						</tr>
					</thead>
					<tbody>
						<?php		
								while($table=$db->dbFetch()){	
						?>
						<tr>
							<td align="center"><i class="clip-bulb"></i></td>
							<td><?php echo "<a href=?page=skripsi&menu=history&nim=$table[nim]><b>$table[judul_final]</b></a><br><br> <p>Oleh <i>$table[namaMhs]</i></p>";?></td>							
							<td><?php echo $table['dpemb1'];?></td>
							<td><?php echo $table['dpemb2'];?></td>
							<td align="center">
								<?php if($table['jumrev']>0){
										echo "<a href=?page=skripsi&menu=forumdosen&id=$table[id]><b><u>$table[jumrev]</u></b></a>";
									  }else{
										echo "<a href=?page=skripsi&menu=forumdosen&id=$table[id]><b><u>0</u></b></a>";
									  };?>
							</td>
							<td>
								<?php if($table['tgl']!=""){
										echo "<center>".tanggalIndo($table['tgl'],'j F Y')."</center>"."<br>Oleh <i>$table[nama]</i>";
									  }else{
										echo "-";
									  };?>
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<!-- end: DYNAMIC TABLE PANEL -->
	</div>
</div>
<!-- end: PAGE CONTENT-->
<?php
}else{
	echo "<div class='alert alert-danger'>Tidak Ada Data</div>";
}
?>